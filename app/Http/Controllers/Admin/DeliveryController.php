<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Invoice, SalesOrder,};
use Illuminate\Support\Facades\Mail;

class DeliveryController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:packing-list', ['only' => ['packing']]);
        $this->middleware('permission:delivery-list', ['only' => ['index']]);
    }

    public function markReadyToDelivery($id)
    {
        $so = SalesOrder::findOrFail($id);

        if ($so->status !== 'ready to delivery') {
            return back()->with('error_message', 'Sales Order must ready for delivery.');
        }

        $so->update([
            'status' => 'ready to packing'
        ]);

        $vendorUser = $so->customer?->user;

        // Global recipients from notification_settings table
        $systemRecipients = getNotificationRecipients(
            type: 'send_to_delivery',
            channel: 'system',
            extraUsers: $vendorUser ? [$vendorUser] : []
        );

        $mailRecipients = getNotificationRecipients(
            type: 'send_to_delivery',
            channel: 'mail',
            extraUsers: ($vendorUser && !empty($vendorUser->email)) ? [$vendorUser] : []
        )->filter(fn($user) => !empty($user->email));

        // Send system notification
        if ($systemRecipients->isNotEmpty()) {
            sendSystemNotification(
                users: $systemRecipients->all(),
                title: 'Sended to packing',
                message: 'Sales Order ' . $so->so_no . ' has been sended for the packing',
                type: 'send_to_delivery',
                url: route('admin.delivery.ready'),
                extra: [
                    'sales_order' => $so->id,
                    'received_by' => auth()->id(),
                ]
            );
        }

        // Send mail
        foreach ($mailRecipients as $user) {
            $mailData = [
                'subject' => 'Sended to packing',
                'name' => $user->name,
                'message' => 'Sales Order ' . $so->so_no . 'has been sended for the packing',
            ];

            Mail::to($user->email)->queue(new \App\Mail\GenericMail($mailData));
        }

        return redirect()->back()->with(
            'success_message',
            'Order marked as Ready to Delivery successfully.'
        );


        TrackingController::logEvent(
            $so->id,
            'ready_to_delivery',
            'Order is ready for delivery',
            'The package is packed and awaiting dispatch.'
        );
    }

    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $readyOrders = SalesOrder::where('status', 'ready to dispatch')->latest()->get();
        } else {
            $readyOrders = SalesOrder::where('branch_id', auth()->user()->branch_id)->where('status', 'ready to dispatch')->latest()->get();
        }
        return view('admin.delivery.index', compact('readyOrders'));
    }

    public function packing()
    {
        if (auth()->user()->hasRole('Admin')) {
            $readyOrders = SalesOrder::where('status', 'ready to delivery')->latest()->get();
        } else {
            $readyOrders = SalesOrder::where('branch_id', auth()->user()->branch_id)->where('status', 'ready to delivery')->latest()->get();
        }
        return view('admin.delivery.packing', compact('readyOrders'));
    }
}
