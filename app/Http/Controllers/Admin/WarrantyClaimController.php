<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Warranty, WarrantyClaim, WarrantyHistory};
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class WarrantyClaimController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:warranty-list|warranty-create|warranty-edit', ['only' => ['index', 'store']]);
        $this->middleware('permission:warranty-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:warranty-edit', ['only' => ['updateStatus', 'assignVendor']]);
        $this->middleware('permission:warranty-show', ['only' => ['warrantyHistory']]);
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole(['Admin', 'Sales'])) {
            $claims = WarrantyClaim::with(['user', 'vendor', 'product', 'assignedVendor'])
                ->latest()
                ->get();
        } elseif ($user->hasRole('Vendor')) {
            $claims = WarrantyClaim::where(function ($q) use ($user) {
                    $q->where('vendor_id', $user->id)
                    ->orWhere('assign_to', $user->id);
                })
                ->with(['user', 'vendor', 'product', 'assignedVendor'])
                ->latest()
                ->get();
        } elseif ($user->hasRole('End Customer')) {
            $claims = WarrantyClaim::where('user_id', $user->id)
                ->with(['user', 'vendor', 'product', 'assignedVendor'])
                ->latest()
                ->get();
        } else {
            $claims = WarrantyClaim::where('user_id', $user->id)
                ->whereHas('product', function ($query) use ($user) {
                    $query->where('branch_id', $user->branch_id);
                })
                ->with(['user', 'vendor', 'product', 'assignedVendor'])
                ->latest()
                ->get();
        }

        $vendors = User::role('Vendor')->get();

        return view('admin.warrantyClaim.index', compact('claims', 'vendors'));
    }

    public function fetchWarranty(Request $request)
    {
        $request->validate([
            'warranty_no' => 'required'
        ]);

        $warrantyNo = trim($request->warranty_no);

        // Debug
        // dd($warrantyNo);

        $warranty = Warranty::with(['user', 'product', 'vendor'])
            ->whereRaw('TRIM(warranty_no) = ?', [$warrantyNo])
            ->first();

        if (!$warranty) {
            return response()->json([
                'status' => false,
                'message' => 'Warranty not found',
                'searched_warranty_no' => $warrantyNo
            ]);
        }

        $expiryDate = \Carbon\Carbon::parse($warranty->created_at)->addYear()->endOfDay();

        if (now()->gt($expiryDate)) {
            return response()->json([
                'status' => false,
                'message' => 'Warranty expired',
                'expiry_date' => $expiryDate->format('Y-m-d')
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'user_id' => $warranty->user_id,
                'vendor_id' => $warranty->vendor_id,
                'product_id' => $warranty->product_id,
                'user_name' => $warranty->user->name ?? '',
                'user_email' => $warranty->user->email ?? '',
                'product_name' => $warranty->product->name ?? '',
                'expiry_date' => $expiryDate->format('Y-m-d')
            ]
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'warranty_no' => 'required|string',
            'description' => 'required|string',
            'file'        => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $warranty = Warranty::with(['user', 'product', 'vendor'])
            ->where('warranty_no', $request->warranty_no)
            ->first();

        if (!$warranty) {
            return redirect()->back()->with('error_message', 'Invalid warranty number.');
        }

        // Block only if a pending claim already exists
        $pendingClaim = WarrantyClaim::where('warranty_no', $warranty->warranty_no)
            ->where('status', 'pending')
            ->first();

        if ($pendingClaim) {
            return redirect()->back()->with('error_message', 'Your warranty claim is already under process.');
        }

        $filePath = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/warranty-claims'), $filename);
            $filePath = 'uploads/warranty-claims/' . $filename;
        }

        $claim = WarrantyClaim::create([
            'user_id'     => $warranty->user_id,
            'vendor_id'   => $warranty->vendor_id,
            'product_id'  => $warranty->product_id,
            'warranty_no' => $warranty->warranty_no,
            'description' => $request->description,
            'file'        => $filePath,
            'status'      => 'pending',
        ]);

        WarrantyHistory::create([
            'warranty_claim_id' => $claim->id,
            'action'            => 'claim_created',
            'old_status'        => null,
            'new_status'        => 'pending',
            'note'              => 'Warranty claim submitted successfully.',
            'changed_by'        => auth()->id(),
            'assigned_to'       => null,
            'date'              => now(),
        ]);


        // ---------------- SYSTEM NOTIFICATION ----------------
        $systemRecipients = getNotificationRecipients(
            type: 'warranty_claim',
            channel: 'system'
        );

        // ---------------- MAIL NOTIFICATION ----------------
        $mailRecipients = getNotificationRecipients(
            type: 'warranty_claim',
            channel: 'mail'
        )->filter(fn($user) => !empty($user->email));

        // ---------------- SEND SYSTEM ----------------
        if ($systemRecipients->isNotEmpty()) {
            sendSystemNotification(
                users: $systemRecipients->all(),
                title: 'Warranty Claim Request',
                message: 'A warranty claim request has been submitted for Warranty No: ' . $data['warranty_no'],
                type: 'warranty_claim',
                url: route('admin.WarrantyClaim.index'),
                extra: []
            );
        }

        // ---------------- SEND MAIL ----------------
        foreach ($mailRecipients as $user) {
            $mailData = [
                'subject' => 'Warranty Claim Request',
                'name' => $user->name,
                'message' => 'We would like to inform you that a warranty claim request has been raised for Warranty No: ' . $data['warranty_no'] . '. Kindly review and take the necessary action.',
            ];

            Mail::to($user->email)->queue(new \App\Mail\GenericMail($mailData));
        }



        return redirect()->back()->with('success_message', 'Warranty claim submitted successfully.');
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $claim = WarrantyClaim::findOrFail($id);

        $oldStatus = $claim->status;

        $claim->update([
            'status' => $request->status,
        ]);

        WarrantyHistory::create([
            'warranty_claim_id' => $claim->id,
            'action'            => 'status_updated',
            'old_status'        => $oldStatus,
            'new_status'        => $request->status,
            'note'              => 'Status changed from ' . $oldStatus . ' to ' . $request->status,
            'changed_by'        => auth()->id(),
            'assigned_to'       => $claim->assign_to,
            'date'              => now(),
        ]);

        return redirect()->back()->with('success_message', 'Claim status updated successfully.');
    }

    public function assignVendor(Request $request, $id)
    {
        $request->validate([
            'assign_to' => 'required|exists:users,id',
        ]);

        $claim = WarrantyClaim::findOrFail($id);

        $vendorUser = User::role('Vendor')->where('id', $request->assign_to)->first();

        if (!$vendorUser) {
            return redirect()->back()->with('error_message', 'Selected user is not a vendor.');
        }

        $oldAssignedTo = $claim->assign_to;

        $claim->update([
            'assign_to' => $vendorUser->id,
        ]);

        WarrantyHistory::create([
            'warranty_claim_id' => $claim->id,
            'action'            => 'assigned_to_vendor',
            'old_status'        => $claim->status,
            'new_status'        => $claim->status,
            'note'              => $oldAssignedTo
                ? 'Claim reassigned to vendor: ' . $vendorUser->name
                : 'Claim assigned to vendor: ' . $vendorUser->name,
            'changed_by'        => auth()->id(),
            'assigned_to'       => $vendorUser->id,
            'date'              => now(),
        ]);

        return redirect()->back()->with('success_message', 'Warranty claim assigned successfully.');
    }

    public function warrantyHistory($id)
    {
        $currentClaim = WarrantyClaim::findOrFail($id);

        $claims = WarrantyClaim::with([
            'user',
            'vendor',
            'product',
            'assignedVendor',
            'histories.changedBy',
            'histories.assignedTo'
        ])
            ->where('warranty_no', $currentClaim->warranty_no)
            ->latest()
            ->get();

        $allHistories = $claims->flatMap(function ($claim) {
            return $claim->histories->map(function ($history) use ($claim) {
                $history->claim_id = $claim->id;
                $history->claim_status = $claim->status;
                $history->claim_description = $claim->description;
                $history->claim_file = $claim->file;
                return $history;
            });
        })->sortByDesc('date');

        return view('admin.warrantyClaim.history', compact('claims', 'currentClaim', 'allHistories'));
    }

    public function serviceStatus(Request $request, $id)
    {
        $data = $request->validate([
            'service_status' => 'required'
        ]);

        $warranty = WarrantyClaim::where('id', $id)->firstOrFail();

        $warranty->update($data);

        return back()->with('success_message', 'Service status updated successfully');
    }
}
