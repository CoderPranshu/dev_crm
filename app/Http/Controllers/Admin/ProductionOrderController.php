<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ProductionOrder, Bom, SalesOrder, User};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProductionOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:production-order-list|production-order-create|production-order-update|production-order-delete|production-order-show', ['only' => ['index', 'store']]);
        $this->middleware('permission:production-order-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:production-order-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:production-order-show', ['only' => ['show']]);
        $this->middleware('permission:production-order-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $productionorders = ProductionOrder::latest()->get();
        } else {
            $productionorders = ProductionOrder::where('branch_id', auth()->user()->branch_id)->latest()->get();
        }

        if (auth()->user()->hasRole('Admin')) {
            $salesOrder = SalesOrder::where('status', 'processing')->get();
        } else {
            $salesOrder = SalesOrder::where('branch_id', auth()->user()->branch_id)->where('status', 'processing')->get();
        }
        return view('admin.productorder.index', compact('productionorders', 'salesOrder'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bom_id' => 'required|exists:boms,id',
            'finished_product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:0.0001',
            'meta' => 'nullable|json',
        ]);

        $bom = Bom::with('items')->findOrFail($data['bom_id']);

        if ($bom->product_id != $data['finished_product_id']) {
            return back()->withInput()->with('error_message', 'Selected Finished Product does not match the BOM\'s Finished Product.');
        }

        $planned = [];

        foreach ($bom->items as $item) {
            $requiredQty = ($item->quantity * $data['quantity']) * (1 + ($item->wastage_percent / 100));

            $planned[] = [
                'raw_product_id'    => $item->raw_product_id,
                'raw_product_name'  => $item->rawProduct->name ?? '',
                'qty_per_unit'      => $item->quantity,
                'wastage_percent'   => $item->wastage_percent,
                'total_required'    => $requiredQty,
            ];
        }

        $data['meta'] = json_encode([
            'planned_materials' => $planned,
            'created_from' => 'production_order_form',
        ]);
        $lastId = DB::table('production_orders')->lockForUpdate()->max('id');
        $nextId = $lastId ? $lastId + 1 : 1;
        $data['status'] = 'pending';
        $productionorderno = 'PO-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
        $productionOrder = ProductionOrder::create([
            'bom_id' => $data['bom_id'],
            'finished_product_id' => $data['finished_product_id'],
            'quantity' => $data['quantity'],
            'status' => 'pending',
            'meta' => $data['meta'],
            'branch_id' => $bom->branch_id,
            'production_no' => $productionorderno
        ]);

        if ($productionOrder) {
            return redirect()->route('admin.productionorder.index')
                ->with('success_message', 'Production Order created successfully');
        }

        return back()->withInput()->with('error_message', 'Something went wrong.');
    }


    public function update(Request $request, $id)
    {
        $productionOrder = ProductionOrder::with('bom.items', 'finishedProduct')->findOrFail($id);

        if ($productionOrder->status != 'pending') {
            return back()->with('error_message', 'You cannot edit this production order because it is already ' . $productionOrder->status);
        }

        $data = $request->validate([
            'bom_id' => 'required|exists:boms,id',
            'finished_product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:0.0001',
        ]);

        $bom = Bom::with('items', 'product')->findOrFail($data['bom_id']);

        if ($bom->product_id != $data['finished_product_id']) {
            return back()->withInput()->with('error_message', 'Selected Finished Product does not match the BOM\'s Finished Product.');
        }

        $planned = [];

        foreach ($bom->items as $item) {
            $requiredQty = ($item->quantity * $data['quantity']) * (1 + ($item->wastage_percent / 100));

            $planned[] = [
                'raw_product_id'    => $item->raw_product_id,
                'raw_product_name'  => $item->rawProduct->name ?? '',
                'qty_per_unit'      => $item->quantity,
                'wastage_percent'   => $item->wastage_percent,
                'total_required'    => $requiredQty,
            ];
        }

        $metaJson = json_encode([
            'planned_materials' => $planned,
            'updated_from' => 'production_order_edit_form'
        ]);

        $productionOrder->update([
            'bom_id' => $data['bom_id'],
            'finished_product_id' => $data['finished_product_id'],
            'quantity' => $data['quantity'],
            'meta' => $metaJson,
            'branch_id' => $bom->branch_id,
        ]);

        return redirect()->route('admin.productionorder.index')
            ->with('success_message', 'Production Order updated successfully.');
    }


    public function delete(Request $request, $id)
    {
        $production = ProductionOrder::where('id', $id)->first();

        $res = $production->delete();

        if ($res) {
            return back()->with('success_message', 'Production order successfully');
        } else {
            return back()->with('error_message', 'Something went wrong');
        }
    }

    public function show($id)
    {
        $productionOrder = ProductionOrder::with('bom.items', 'finishedProduct')->findOrFail($id);

        return view('admin.productorder.show', compact('productionOrder'));
    }

    // public function approveOrder(Request $request, $id)
    // {
    //     $data = $request->validate([
    //         'production_status' => 'required'
    //     ]);

    //     $salesOrder = SalesOrder::with('items.product.bom.items')
    //         ->findOrFail($id);

    //     //already approved
    //     if ($salesOrder->production_status === 'approved') {
    //         return back()->with('error_message', 'Order already approved. Stock already deducted.');
    //     }

    //     $required = [];

    //     foreach ($salesOrder->items as $orderItem) {
    //         $orderQty = (float) ($orderItem->quantity ?? 1);

    //         $boms = $orderItem->product?->bom ?? collect();

    //         foreach ($boms as $bom) {
    //             foreach (($bom->items ?? []) as $bomItem) {

    //                 $rawProductId = $bomItem->raw_product_id;
    //                 $perUnitQty   = (float) ($bomItem->quantity ?? 0);

    //                 if (!$rawProductId || $perUnitQty <= 0) {
    //                     continue;
    //                 }

    //                 $usedQty = $perUnitQty * $orderQty;

    //                 $required[$rawProductId] = ($required[$rawProductId] ?? 0) + $usedQty;
    //             }
    //         }
    //     }

    //     if (empty($required)) {
    //         $salesOrder->update($data);
    //         return back()->with('success_message', 'Items Approved (No BOM consumption found)');
    //     }

    //     try {
    //         DB::transaction(function () use ($salesOrder, $data, $required) {

    //             foreach ($required as $productId => $usedQty) {

    //                 $product = \App\Models\Product::where('id', $productId)
    //                     ->lockForUpdate()
    //                     ->first();

    //                 if (!$product) {
    //                     throw new \Exception("Raw product not found (ID: {$productId})");
    //                 }

    //                 $currentStock = (float) $product->stock;

    //                 // DEBUG (remove after testing)
    //                 // logger("Stock Check", [
    //                 //     'product_id' => $productId,
    //                 //     'product_name' => $product->name,
    //                 //     'stock_in_db' => $currentStock,
    //                 //     'required' => $usedQty
    //                 // ]);

    //                 if ($currentStock < $usedQty) {
    //                     throw new \Exception(
    //                         "Insufficient stock for {$product->name}. Needed {$usedQty}, available {$currentStock}"
    //                     );
    //                 }

    //                 // deduct stock safely
    //                 $product->decrement('stock', $usedQty);
    //             }

    //             $salesOrder->update($data);
    //         });

    //         // ================= Notifications =================

    //         $vendorUser = $salesOrder->customer?->user;

    //         $systemRecipients = getNotificationRecipients(
    //             type: 'raw_material',
    //             channel: 'system',
    //             extraUsers: $vendorUser ? [$vendorUser] : []
    //         );

    //         $mailRecipients = getNotificationRecipients(
    //             type: 'raw_material',
    //             channel: 'mail',
    //             extraUsers: ($vendorUser && !empty($vendorUser->email)) ? [$vendorUser] : []
    //         )->filter(fn($user) => !empty($user->email));

    //         if ($systemRecipients->isNotEmpty()) {
    //             sendSystemNotification(
    //                 users: $systemRecipients->all(),
    //                 title: 'Raw Material Assigned',
    //                 message: 'Raw material assigned for Sales Order ' . $salesOrder->so_no,
    //                 type: 'raw_material',
    //                 url: route('admin.salesorders.index'),
    //                 extra: [
    //                     'sales_order_id' => $salesOrder->id,
    //                     'received_by' => auth()->id(),
    //                 ]
    //             );
    //         }

    //         foreach ($mailRecipients as $user) {
    //             $mailData = [
    //                 'subject' => 'Raw Material Assigned',
    //                 'name' => $user->name,
    //                 'sales_order' => $salesOrder->so_no,
    //                 'message' => 'Raw material assigned for Sales Order ' . $salesOrder->so_no,
    //             ];

    //             Mail::to($user->email)->queue(new \App\Mail\GenericMail($mailData));
    //         }

    //         return back()->with('success_message', 'Items Approved and Inventory Updated');
    //     } catch (\Throwable $e) {
    //         return back()->withInput()->with('error_message', $e->getMessage());
    //     }
    // }
    
    public function approveOrder(Request $request, $id)
    {
        $data = $request->validate([
            'production_status' => 'required'
        ]);
    
        $salesOrder = SalesOrder::with('items.product.bom.items')
            ->findOrFail($id);
    
        // Already approved
        if ($salesOrder->production_status === 'approved') {
            return back()->with('error_message', 'Order already approved. Stock already deducted.');
        }
    
        $required = [];
    
        foreach ($salesOrder->items as $orderItem) {
            $orderQty = (float) ($orderItem->quantity ?? 1);
    
            $boms = $orderItem->product?->bom ?? collect();
    
            foreach ($boms as $bom) {
                foreach (($bom->items ?? []) as $bomItem) {
    
                    $rawProductId = $bomItem->raw_product_id;
                    $perUnitQty   = (float) ($bomItem->quantity ?? 0);
    
                    if (!$rawProductId || $perUnitQty <= 0) {
                        continue;
                    }
    
                    $usedQty = $perUnitQty * $orderQty;
    
                    $required[$rawProductId] = ($required[$rawProductId] ?? 0) + $usedQty;
                }
            }
        }
    
        if (empty($required)) {
            $salesOrder->update($data);
            return back()->with('success_message', 'Items Approved (No BOM consumption found)');
        }
    
        try {
            DB::transaction(function () use ($salesOrder, $data, $required) {
    
                $pr = null; // Single PR per order
    
                foreach ($required as $productId => $usedQty) {
    
                    $product = \App\Models\Product::where('id', $productId)
                        ->lockForUpdate()
                        ->first();
    
                    if (!$product) {
                        throw new \Exception("Raw product not found (ID: {$productId})");
                    }
    
                    $currentStock = (float) $product->stock;
    
                    if ($currentStock < $usedQty) {
                        throw new \Exception(
                            "Insufficient stock for {$product->name}. Needed {$usedQty}, available {$currentStock}"
                        );
                    }
    
                    // Deduct stock
                    $product->decrement('stock', $usedQty);
                    $product->refresh();
    
                    // ================= MIN STOCK CHECK =================
                    if (!is_null($product->min_stock) && $product->stock <= $product->min_stock) {
    
                        // Create or reuse PR (ONE per sales order)
                        if (!$pr) {
                            $pr = \App\Models\PurchaseRequisition::firstOrCreate(
                                [
                                    'reference_type' => 'sales_order',
                                    'reference_id'   => $salesOrder->id,
                                    'status'         => 'pending',
                                ],
                                [
                                    'pr_number'    => 'PR-' . time(),
                                    'requested_by' => auth()->id(),
                                    'department'   => 'production',
                                    'branch_id'    => $product->branch_id,
                                ]
                            );
                        }
    
                        // Prevent duplicate PR item for same product
                        $existingItem = $pr->items()
                            ->where('product_id', $product->id)
                            ->first();
    
                        if (!$existingItem) {
    
                            $availableQty = (float) $product->stock;
    
                            // Target stock (you can improve this with reorder_qty column)
                            $targetStock = $product->min_stock * 2;
    
                            $toOrderQty = max(0, $targetStock - $availableQty);
    
                            $pr->items()->create([
                                'product_id'    => $product->id,
                                'required_qty'  => $targetStock,
                                'available_qty' => $availableQty,
                                'to_order_qty'  => $toOrderQty,
                                'priority'      => 'high',
                            ]);
                        }
                    }
                }
    
                // Update order status
                $salesOrder->update($data);
            });
    
            // ================= Notifications =================
    
            $vendorUser = $salesOrder->customer?->user;
    
            $systemRecipients = getNotificationRecipients(
                type: 'raw_material',
                channel: 'system',
                extraUsers: $vendorUser ? [$vendorUser] : []
            );
    
            $mailRecipients = getNotificationRecipients(
                type: 'raw_material',
                channel: 'mail',
                extraUsers: ($vendorUser && !empty($vendorUser->email)) ? [$vendorUser] : []
            )->filter(fn($user) => !empty($user->email));
    
            if ($systemRecipients->isNotEmpty()) {
                sendSystemNotification(
                    users: $systemRecipients->all(),
                    title: 'Raw Material Assigned',
                    message: 'Raw material assigned for Sales Order ' . $salesOrder->so_no,
                    type: 'raw_material',
                    url: route('admin.salesorders.index'),
                    extra: [
                        'sales_order_id' => $salesOrder->id,
                        'received_by' => auth()->id(),
                    ]
                );
            }
    
            foreach ($mailRecipients as $user) {
                $mailData = [
                    'subject' => 'Raw Material Assigned',
                    'name' => $user->name,
                    'sales_order' => $salesOrder->so_no,
                    'message' => 'Raw material assigned for Sales Order ' . $salesOrder->so_no,
                ];
    
                Mail::to($user->email)->queue(new \App\Mail\GenericMail($mailData));
            }
    
            return back()->with('success_message', 'Items Approved, Inventory Updated & PR Generated if Needed');
    
        } catch (\Throwable $e) {
            return back()->withInput()->with('error_message', $e->getMessage());
        }
    }
}
