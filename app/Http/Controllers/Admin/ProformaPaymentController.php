<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ProformaPayment, Proforma, User, Lead};
use Barryvdh\DomPDF\Facade\Pdf;
use NumberFormatter;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Mail;

class ProformaPaymentController extends Controller
{
    public function index(Request $request, $id)
    {
        $payments = ProformaPayment::where('proforma_id', $id)->get();

        return view('admin.proforma.paymentdetails', compact('payments'));
    }

    public function payment(Request $request)
    {
        $data = $request->validate([
            'amount' => 'nullable',
            'payment_method' => 'nullable',
            'transaction_id' => 'nullable',
            'payment_date' => 'nullable',
            'proforma_id' => 'nullable'
        ]);

        $proforma = Proforma::with('customer.user')->findOrFail($data['proforma_id']);

        $data['branch_id'] = $proforma->branch_id;

        $receiptNo = 'RCPT-' . str_pad(ProformaPayment::count() + 1, 5, '0', STR_PAD_LEFT);

        $data['customer_id'] = $proforma->customer_id;
        $data['status'] = 'received';
        $data['receipt_no'] = $receiptNo;

        $res = ProformaPayment::create($data);

        if ($res) {

                if ($proforma->lead_id) {
                    Lead::where('id', $proforma->lead_id)
                        ->update(['stage' => 'Won']);
                }

            $vendorUser = $proforma->customer?->user;

            // Global recipients from notification_settings table
            $systemRecipients = getNotificationRecipients(
                type: 'payment_received',
                channel: 'system',
                extraUsers: $vendorUser ? [$vendorUser] : []
            );

            $mailRecipients = getNotificationRecipients(
                type: 'payment_received',
                channel: 'mail',
                extraUsers: ($vendorUser && !empty($vendorUser->email)) ? [$vendorUser] : []
            )->filter(fn($user) => !empty($user->email));

            // Send system notification
            if ($systemRecipients->isNotEmpty()) {
                sendSystemNotification(
                    users: $systemRecipients->all(),
                    title: 'Payment Received',
                    message: 'Payment of ₹' . number_format($data['amount'], 2) .
                        ' received for Proforma #' . $proforma->id,
                    type: 'payment_received',
                    url: route('admin.proforma.index'),
                    extra: [
                        'proforma_id' => $proforma->id,
                        'payment_id' => $res->id,
                        'amount' => $data['amount'],
                        'received_by' => auth()->id(),
                    ]
                );
            }

            // Send mail
            foreach ($mailRecipients as $user) {
                $mailData = [
                    'subject' => 'Payment Received',
                    'name' => $user->name,
                    'amount' => $data['amount'],
                    'message' => 'Payment of ₹' . number_format($data['amount'], 2) .
                        ' received for Proforma #' . $proforma->id . '.',
                ];

                Mail::to($user->email)->queue(new \App\Mail\GenericMail($mailData));
            }

            return back()->with('success_message', 'Payment entered successfully');
        }

        return back()->withInput()->with('error_message', 'Something went wrong');
    }

    public function paymentrecipt(Request $request, $id)
    {
        $payment = ProformaPayment::where('id', $id)->firstOrFail();

        return view('admin.proforma.paymentrec', compact('payment'));
    }

    public function pdf(ProformaPayment $payment)
    {
        $payment->load([
            'customer',
            'proforma.payment',
            'proforma.items.product'
        ]);

        $formatter = new NumberFormatter('en_IN', NumberFormatter::SPELLOUT);
        $amountInWords = ucfirst($formatter->format($payment->amount)) . ' only';

        $pdf = Pdf::loadView('admin.proforma.reciptpdf', compact(
            'payment',
            'amountInWords'
        ))->setPaper('A4', 'portrait');

        return $pdf->download('Payment_Receipt_' . $payment->receipt_no . '.pdf');
    }
}
