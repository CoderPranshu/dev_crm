<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Grn, GrnItem, StockMovement, Product, Warehouse, PurchaseBill, PurchaseBillItem, Vendor, PurchaseOrder};
use DB;

class GrnController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:grn-list|grn-create|grn-update|grn-delete|grn-show', ['only' => ['index', 'store']]);
        $this->middleware('permission:grn-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:grn-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:grn-delete', ['only' => ['destroy']]);
        $this->middleware('permission:grn-show', ['only' => ['show']]);
    }

    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $grns = Grn::with('warehouse')->latest()->get();
            $products = Product::get();
        } else {
            $grns = Grn::where('branch_id', auth()->user()->branch_id)->with('warehouse')->latest()->get();
            $products = Product::where('branch_id', auth()->user()->branch_id)->get();
        }
        $warehouses = Warehouse::get();
        return view('admin.grn.index', compact('grns', 'warehouses', 'products'));
    }

    public function create()
    {
        $warehouses = Warehouse::get();
        if (auth()->user()->hasRole('Admin')) {
            $products = Product::get();
        } else {
            $products = Product::where('branch_id', auth()->user()->branch_id)->get();
        }

        $vendors = Vendor::get();

        // dd($vendors);

        return view('admin.grn.create', compact('warehouses', 'products', 'vendors'));
    }

    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'supplier_name' => 'nullable|string',
    //         'grn_date' => 'required|date',
    //         'warehouse_id' => 'nullable|exists:warehouses,id',
    //         'items' => 'required|array|min:1',
    //         'items.*.product_id' => 'required|exists:products,id',
    //         'items.*.quantity' => 'required|numeric|min:0.0001',
    //         'items.*.rate' => 'nullable|numeric|min:0',
    //         'items.*.hsn_code' => 'nullable|string',
    //         'items.*.gst_rate' => 'nullable|numeric|min:0'
    //     ]);

    //     DB::transaction(function () use ($request, $data) {

    //         // ---------- CREATE GRN ----------
    //         $grnNo = 'GRN-' . str_pad(Grn::max('id') + 1, 5, '0', STR_PAD_LEFT);

    //         $grn = Grn::create([
    //             'grn_no' => $grnNo,
    //             'supplier_name' => $data['supplier_name'] ?? null,
    //             'grn_date' => $data['grn_date'],
    //             'warehouse_id' => $data['warehouse_id'] ?? null,
    //             'notes' => $request->notes
    //         ]);

    //         $taxableAmount = 0;
    //         $cgst = $sgst = $igst = 0;

    //         // 🔧 later replace with supplier state logic
    //         $isSameState = true;

    //         // ---------- GRN ITEMS + STOCK ----------
    //         foreach ($data['items'] as $item) {

    //             $amount = $item['rate'] * $item['quantity'];
    //             $taxableAmount += $amount;

    //             $gstRate = $item['gst_rate'] ?? 0;
    //             $gstAmount = $amount * ($gstRate / 100);

    //             if ($isSameState) {
    //                 $cgst += $gstAmount / 2;
    //                 $sgst += $gstAmount / 2;
    //             } else {
    //                 $igst += $gstAmount;
    //             }

    //             GrnItem::create([
    //                 'grn_id' => $grn->id,
    //                 'product_id' => $item['product_id'],
    //                 'quantity' => $item['quantity'],
    //                 'rate' => $item['rate'],
    //                 'amount' => $amount
    //             ]);


    //             // ---------- UPDATE PRODUCT STOCK ----------
    //             Product::where('id', $item['product_id'])->increment('stock', $quantity);

    //             // Stock movement
    //             $this->recordStockMovement([
    //                 'product_id' => $item['product_id'],
    //                 'warehouse_id' => $data['warehouse_id'] ?? null,
    //                 'movement_type' => 'purchase',
    //                 'quantity' => $item['quantity'],
    //                 'reference_type' => 'grn',
    //                 'reference_id' => $grn->id,
    //                 'note' => 'GRN Received #' . $grn->grn_no
    //             ]);
    //         }

    //         // ---------- PURCHASE BILL ----------
    //         $totalTax = $cgst + $sgst + $igst;
    //         $grandTotal = $taxableAmount + $totalTax;

    //         $bill = PurchaseBill::create([
    //             'grn_id' => $grn->id,
    //             'bill_no' => 'PB-' . str_pad(PurchaseBill::max('id') + 1, 5, '0', STR_PAD_LEFT),
    //             'bill_date' => now(),
    //             'supplier_name' => $grn->supplier_name,
    //             'taxable_amount' => $taxableAmount,
    //             'cgst_amount' => $cgst,
    //             'sgst_amount' => $sgst,
    //             'igst_amount' => $igst,
    //             'total_tax' => $totalTax,
    //             'total_amount' => $grandTotal,
    //             'paid_amount' => 0,
    //             'due_amount' => $grandTotal,
    //             'status' => 'unpaid'
    //         ]);

    //         // ---------- PURCHASE BILL ITEMS ----------
    //         foreach ($data['items'] as $item) {

    //             $amount = $item['rate'] * $item['quantity'];
    //             $gstRate = $item['gst_rate'] ?? 0;
    //             $gstAmount = $amount * ($gstRate / 100);

    //             PurchaseBillItem::create([
    //                 'purchase_bill_id' => $bill->id,
    //                 'product_id' => $item['product_id'],
    //                 'quantity' => $item['quantity'],
    //                 'rate' => $item['rate'],
    //                 'amount' => $amount,
    //                 'hsn_code' => $item['hsn_code'] ?? null,
    //                 'gst_rate' => $gstRate,
    //                 'gst_amount' => $gstAmount
    //             ]);
    //         }
    //     });

    //     return redirect()->route('admin.grn.index')
    //         ->with('success_message', 'GRN created successfully');
    // }


    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_name' => 'nullable|string',
            'grn_date' => 'required|date',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'branch_id' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.0001',
            'items.*.rate' => 'nullable|numeric|min:0',
            'items.*.hsn_code' => 'nullable|string',
            'items.*.gst_rate' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $data) {

            // ---------- CREATE GRN ----------
            $grnNo = 'GRN-' . str_pad((Grn::max('id') + 1), 5, '0', STR_PAD_LEFT);

            $grn = Grn::create([
                'grn_no' => $grnNo,
                'supplier_name' => $data['supplier_name'] ?? null,
                'grn_date' => $data['grn_date'],
                'warehouse_id' => $data['warehouse_id'] ?? null,
                'notes' => $request->notes,
                'branch_id' => $data['branch_id'] ?? null,
            ]);

            if ($request->purchase_order_id) {

                PurchaseOrder::where('id', $request->purchase_order_id)
                    ->update([
                        'status' => 'Completed'
                    ]);
            }

            $taxableAmount = 0;
            $cgst = 0;
            $sgst = 0;
            $igst = 0;

            // later replace with supplier state logic
            $isSameState = true;

            // ---------- GRN ITEMS + STOCK ----------
            foreach ($data['items'] as $item) {

                $rate = $item['rate'] ?? 0;
                $quantity = $item['quantity'];
                $amount = $rate * $quantity;

                $taxableAmount += $amount;

                $gstRate = $item['gst_rate'] ?? 0;
                $gstAmount = $amount * ($gstRate / 100);

                if ($isSameState) {
                    $cgst += $gstAmount / 2;
                    $sgst += $gstAmount / 2;
                } else {
                    $igst += $gstAmount;
                }

                GrnItem::create([
                    'grn_id' => $grn->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $quantity,
                    'rate' => $rate,
                    'amount' => $amount
                ]);

                // ---------- UPDATE PRODUCT STOCK ----------
                $product = Product::findOrFail($item['product_id']);

                $product->stock = (string) (
                    (is_numeric($product->stock) ? (float) $product->stock : 0) +
                    (is_numeric($quantity) ? (float) $quantity : 0)
                );

                $data33 = $product->save();

                // ---------- STOCK MOVEMENT ----------
                $this->recordStockMovement([
                    'product_id' => $item['product_id'],
                    'warehouse_id' => $data['warehouse_id'] ?? null,
                    'movement_type' => 'purchase',
                    'quantity' => $quantity,
                    'reference_type' => 'grn',
                    'reference_id' => $grn->id,
                    'note' => 'GRN Received #' . $grn->grn_no
                ]);
            }

            // ---------- PURCHASE BILL ----------
            $totalTax = $cgst + $sgst + $igst;
            $grandTotal = $taxableAmount + $totalTax;

            $bill = PurchaseBill::create([
                'grn_id' => $grn->id,
                'bill_no' => 'PB-' . str_pad((PurchaseBill::max('id') + 1), 5, '0', STR_PAD_LEFT),
                'bill_date' => now(),
                'supplier_name' => $grn->supplier_name,
                'taxable_amount' => $taxableAmount,
                'cgst_amount' => $cgst,
                'sgst_amount' => $sgst,
                'igst_amount' => $igst,
                'total_tax' => $totalTax,
                'total_amount' => $grandTotal,
                'paid_amount' => 0,
                'due_amount' => $grandTotal,
                'status' => 'unpaid',
                'branch_id' => $grn->branch_id
            ]);

            // ---------- PURCHASE BILL ITEMS ----------
            foreach ($data['items'] as $item) {

                $rate = $item['rate'] ?? 0;
                $quantity = $item['quantity'];
                $amount = $rate * $quantity;
                $gstRate = $item['gst_rate'] ?? 0;
                $gstAmount = $amount * ($gstRate / 100);

                PurchaseBillItem::create([
                    'purchase_bill_id' => $bill->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $quantity,
                    'rate' => $rate,
                    'amount' => $amount,
                    'hsn_code' => $item['hsn_code'] ?? null,
                    'gst_rate' => $gstRate,
                    'gst_amount' => $gstAmount
                ]);
            }
        });

        return redirect()->route('admin.grn.index')
            ->with('success_message', 'GRN created successfully');
    }

    private function recordStockMovement(array $data)
    {
        // Find last qty_after
        $query = StockMovement::where('product_id', $data['product_id']);

        if (!empty($data['warehouse_id'])) {
            $query->where('warehouse_id', $data['warehouse_id']);
        } else {
            $query->whereNull('warehouse_id');
        }

        $last = $query->latest()->first();

        $quantityBefore = $last ? $last->quantity_after : Product::find($data['product_id'])->opening_stock ?? 0;

        $qty = (float) $data['quantity'];
        $quantityAfter = $quantityBefore + $qty; // GRN always increases stock

        StockMovement::create([
            'product_id' => $data['product_id'],
            'warehouse_id' => $data['warehouse_id'] ?? null,
            'movement_type' => 'purchase',
            'quantity' => $qty,
            'quantity_before' => $quantityBefore,
            'quantity_after' => $quantityAfter,
            'reference_type' => $data['reference_type'],
            'reference_id' => $data['reference_id'],
            'note' => $data['note'],
        ]);
    }

    public function show($id)
    {
        $grn = Grn::with('warehouse', 'items')->findOrFail($id);
        return view('admin.grn.show', compact('grn'));
    }

    public function getBranchProducts($id)
    {
        $products = Product::where('branch_id', $id)->get();

        return response()->json([
            'products' => $products
        ]);
    }
}
