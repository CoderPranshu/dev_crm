<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{VendorReturn, Product, StockMovement, Company};
use Barryvdh\DomPDF\Facade\Pdf;

class VendorReturnController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:vendor-return-list|vendor-return-create|vendor-return-edit|vendor-return-delete', [
            'only' => ['index']
        ]);

        $this->middleware('permission:vendor-return-create', [
            'only' => ['create', 'store']
        ]);

        $this->middleware('permission:vendor-return-edit', [
            'only' => ['edit', 'update', 'statusUpdate', 'collected', 'replace']
        ]);

        $this->middleware('permission:vendor-return-delete', [
            'only' => ['destroy']
        ]);
    }

    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $returnrequests = VendorReturn::where('status', 'pending')->latest()->get();
        }elseif(auth()->user()->hasRole('Vendor')){
            $returnrequests = VendorReturn::where('vendor_id', auth()->user()->id)
                ->where('status', 'pending')
                ->latest()
                ->get();
        }else {
            $returnrequests = VendorReturn::where('vendor_id', auth()->user()->id)
                ->whereHas('product', function ($query) {
                    $query->where('branch_id', auth()->user()->branch_id);
                })
                ->where('status', 'pending')
                ->latest()
                ->get();
        }
        return view('admin.vendorreturn.index', compact('returnrequests'));
    }

    public function approved()
    {
        $user = auth()->user();
        $role = $user->getRoleNames()->first();

        if ($user->hasRole('Admin')) {
            $returnrequests = VendorReturn::where('status', 'approved')->latest()->get();
        } elseif($user->hasRole('Vendor')) {
            $returnrequests = VendorReturn::where('vendor_id', $user->id)
                ->where('status', 'approved')
                ->latest()
                ->get();
        }else{
            $returnrequests = VendorReturn::where('vendor_id', $user->id)
                ->where('status', 'approved')
                ->whereHas('product', function ($query) {
                    $query->where('branch_id', auth()->user()->branch_id);
                })
                ->latest()
                ->get();
        }

        return view('admin.vendorreturn.approved', compact('returnrequests', 'role'));
    }

    public function collectedReturn()
    {
        if (auth()->user()->hasRole('Admin')) {
            $returnrequests = VendorReturn::where('status', 'collected')->latest()->get();
        } elseif(auth()->user()->hasRole('Vendor')) {
            $returnrequests = VendorReturn::where('vendor_id', auth()->user()->id)->latest()->get();
        }else{
             $returnrequests = VendorReturn::where('vendor_id', auth()->user()->id)
                            ->whereHas('product', function ($query) {
                                $query->where('branch_id', auth()->user()->branch_id);
                            })
                            ->latest()->get();
        }
        return view('admin.vendorreturn.collected', compact('returnrequests'));
    }

    public function replaceReturn()
    {
        if (auth()->user()->hasRole('Admin')) {
            $returnrequests = VendorReturn::where('status', 'replaced')->latest()->get();
        } elseif(auth()->user()->hasRole('Vendor')) {
            $returnrequests = VendorReturn::where('vendor_id', auth()->user()->id)
                                ->where('status', 'replaced')->latest()->get();
        }else{
            $returnrequests = VendorReturn::where('vendor_id', auth()->user()->id)
                                ->whereHas('product', function ($query) {
                                    $query->where('branch_id', auth()->user()->branch_id);
                                })
                                ->where('status', 'replaced')->latest()->get();
        }
        return view('admin.vendorreturn.replaced', compact('returnrequests'));
    }

    public function rejectedReturn()
    {
        if (auth()->user()->hasRole('Admin')) {
            $returnrequests = VendorReturn::where('status', 'rejected')->latest()->get();
        } elseif(auth()->user()->hasRole('Vendor')) {
            $returnrequests = VendorReturn::where('vendor_id', auth()->user()->id)->where('status', 'rejected')->latest()->get();
        }else{
            $returnrequests = VendorReturn::where('vendor_id', auth()->user()->id)
                            ->whereHas('products', function ($query) {
                                $query->where('branch_id', auth()->user()->branch_id);
                            })
                            ->where('status', 'rejected')->latest()->get();
        }

        return view('admin.vendorreturn.rejected', compact('returnrequests'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'nullable',
            'quantity' => 'nullable',
            'reason' => 'nullable',
            'note' => 'nullable',
            'vendor_id' => 'nullable'
        ]);

        $user = auth()->user()->id;

        $data['created_by'] = $user;

        $res = VendorReturn::create($data);

        if ($res) {
            return back()->with('success_message', 'Return request created');
        } else {
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function statusUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'nullable'
        ]);

        $return = VendorReturn::where('id', $id)->firstOrFail();

        $return->update($data);

        return back()->with('success_message', 'Data status updated successfully');
    }

    public function collected(Request $request, $id)
    {
        $return = VendorReturn::findOrFail($id);
        $product = Product::findOrFail($return->product_id);

        $before = $product->waste_stock;

        // Update waste stock
        $product->waste_stock += $return->quantity;
        $product->save();

        $after = $product->waste_stock;

        // Stock Movement Entry
        StockMovement::create([
            'product_id' => $product->id,
            'warehouse_id' => $return->warehouse_id ?? null, // optional
            'movement_type' => 'waste_in',
            'quantity' => $return->quantity,
            'quantity_before' => $before ?? 0,
            'quantity_after' => $after,
            'reference_type' => 'VendorReturn',
            'reference_id' => $return->id,
            'note' => 'Collected damaged items from vendor',
            'created_by' => auth()->id(),
        ]);

        $return->status = 'collected';
        $return->pickup_date = now();
        $return->save();

        return back()->with('success', 'Waste collected');
    }

    public function replace($id)
    {
        $return = VendorReturn::findOrFail($id);
        $product = Product::findOrFail($return->product_id);

        if ($product->stock < $return->quantity) {
            return back()->with('error', 'Not enough stock');
        }

        $before = $product->stock;

        // Deduct usable stock
        $product->stock -= $return->quantity;
        $product->save();

        $after = $product->stock;

        // Stock Movement Entry
        StockMovement::create([
            'product_id' => $product->id,
            'warehouse_id' => $return->warehouse_id ?? null,
            'movement_type' => 'replacement_out',
            'quantity' => $return->quantity,
            'quantity_before' => $before,
            'quantity_after' => $after,
            'reference_type' => 'VendorReplacement',
            'reference_id' => $return->id,
            'note' => 'Replacement sent to vendor',
            'created_by' => auth()->id(),
        ]);

        $return->status = 'replaced';
        $return->save();

        return back()->with('success', 'Replacement sent');
    }

    public function wasteReceipt($id)
    {
        $return = VendorReturn::with('product', 'vendor')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.waste_receipt', compact('return'));

        return $pdf->stream('waste_receipt.pdf');
    }

    public function replacementReceipt($id)
    {
        $return = VendorReturn::with('product', 'vendor')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.replacement_receipt', compact('return'));

        return $pdf->stream('replacement_receipt_' . $return->id . '.pdf');
    }

    public function vendorReturnRequest(Request $request, $id, $vendorid)
    {
        $data = $request->validate([
            'replaceqty' => 'required',
            'note' => 'nullable'
        ]);

        // dd($id, $vendorid);

        $vendor = Company::where('id', $vendorid)->firstOrFail();

        VendorReturn::create([
            'vendor_id' => $vendor->user_id,
            'product_id' => $id,
            'quantity' => $data['replaceqty'],
            'reason' => 'replaced',
            'note' => $data['note'],
            'created_by' => auth()->user()->id,
        ]);

        return back()->with('success_message', 'Replacement request created successfully');
    }

    public function replacementShow($id)
    {
        $vendor = Company::where('id', $id)->firstOrFail();

        $return = VendorReturn::where('vendor_id', $vendor->user_id)->get();

        return view('admin.company.replaceHistory', compact('id', 'return'));
    }
}
