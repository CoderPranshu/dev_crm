<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ProductionConsumption, ProductionOrder, StockMovement, Product, PurchaseRequisition, PurchaseRequisitionItem, SalesOrder};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProductionConsumptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:production-consumption-list|production-consumption-create|production-consumption-update|production-consumption-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:production-consumption-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:production-consumption-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:production-consumption-delete', ['only' => ['destroy']]);
        $this->middleware('permission:manufacturing', ['only' => ['manufacturing']]);
        $this->middleware('permission:manufacturing-start', ['only' => ['productManufacture']]);
    }

    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $usage = ProductionConsumption::where('production_order_id', '!=', null)->latest()->get();
        } else {
            $usage = ProductionConsumption::where('branch_id', auth()->user()->branch_id)->where('production_order_id', '!=', null)->latest()->get();
        }

        $salesOrder = ProductionConsumption::where('sales_order_id', '!=', null)->get();

        return view('admin.productionconsumption.index', compact('usage', 'salesOrder'));
    }

    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'production_order_id' => 'required|exists:production_orders,id',
    //         'branch_id' => 'required',
    //     ]);

    //     DB::beginTransaction();

    //     try {

    //         $productionOrder = ProductionOrder::with('bom.items')->findOrFail($data['production_order_id']);
    //         $bom = $productionOrder->bom;

    //         if (!$bom) {
    //             return back()->with('error_message', 'BOM not found for this production order');
    //         }

    //         if ($data['branch_id'] != $productionOrder->branch_id) {
    //             return back()->with('error_message', 'Warehouse must match Production Order branch');
    //         }

    //         $warehouseId = $productionOrder->branch_id;
    //         $qtyToProduce = (float)$productionOrder->quantity;

    //         $purchaseRequisition = null;

    //         foreach ($bom->items as $item) {

    //             // ✅ SAFE FETCH
    //             $product = Product::find($item->raw_product_id);

    //             if (!$product) {
    //                 throw new \Exception("Raw product not found (ID: {$item->raw_product_id})");
    //             }

    //             if ($product->branch_id != $warehouseId) {
    //                 throw new \Exception("Product {$product->id} does not belong to selected branch");
    //             }

    //             $requiredQty = ($item->quantity * $qtyToProduce);

    //             if (!empty($item->wastage_percent)) {
    //                 $requiredQty *= (1 + ($item->wastage_percent / 100));
    //             }

    //             $bufferMultiplier = 1.1;
    //             $requiredWithBuffer = $requiredQty * $bufferMultiplier;

    //             $lastMovement = StockMovement::where('product_id', $item->raw_product_id)
    //                 ->where('warehouse_id', $warehouseId)
    //                 ->latest()
    //                 ->first();

    //             $availableStock = $lastMovement
    //                 ? (float)$lastMovement->quantity_after
    //                 : (float)($product->opening_stock ?? 0);

    //             if ($availableStock > 0) {

    //                 $consumeQty = min($availableStock, $requiredQty);
    //                 $quantityAfter = $availableStock - $consumeQty;

    //                 ProductionConsumption::create([
    //                     'production_order_id' => $productionOrder->id,
    //                     'raw_product_id' => $item->raw_product_id,
    //                     'quantity_used' => $consumeQty,
    //                     'branch_id' => $warehouseId,
    //                 ]);

    //                 // STOCK MOVEMENT DISABLED

    //                 $product->stock = $quantityAfter;
    //                 $product->save();
    //             }

    //             if ($availableStock < $requiredWithBuffer) {

    //                 $shortQty = max($requiredWithBuffer - $availableStock, 0);

    //                 if ($shortQty > 0) {

    //                     if (!$purchaseRequisition) {

    //                         $purchaseRequisition = PurchaseRequisition::create([
    //                             'pr_number'      => null,
    //                             'requested_by'   => auth()->id(),
    //                             'department'     => 'Production',
    //                             'reference_type' => 'production_order',
    //                             'reference_id'   => $productionOrder->id,
    //                             'status'         => 'pending',
    //                         ]);

    //                         $purchaseRequisition->update([
    //                             'pr_number' => 'PR-' . str_pad($purchaseRequisition->id, 6, '0', STR_PAD_LEFT)
    //                         ]);
    //                     }

    //                     PurchaseRequisitionItem::create([
    //                         'requisition_id' => $purchaseRequisition->id,
    //                         'product_id' => $item->raw_product_id,
    //                         'required_qty' => $shortQty,
    //                     ]);
    //                 }
    //             }
    //         }

    //         // =========================
    //         // FINISHED GOODS
    //         // =========================
    //         if (empty($productionOrder->finished_product_id)) {
    //             throw new \Exception("Production order does not have a finished product assigned.");
    //         }

    //         $finishedProduct = Product::find($productionOrder->finished_product_id);

    //         if (!$finishedProduct) {
    //             throw new \Exception("Finished product not found (ID: {$productionOrder->finished_product_id})");
    //         }

    //         if ($finishedProduct->branch_id != $warehouseId) {
    //             throw new \Exception("Finished product does not belong to selected branch");
    //         }

    //         $lastFinishedMovement = StockMovement::where('product_id', $finishedProduct->id)
    //             ->where('warehouse_id', $warehouseId)
    //             ->latest()
    //             ->first();

    //         $availableFinishedStock = $lastFinishedMovement
    //             ? (float)$lastFinishedMovement->quantity_after
    //             : (float)($finishedProduct->opening_stock ?? 0);

    //         $newFinishedStock = $availableFinishedStock + $qtyToProduce;

    //         // STOCK MOVEMENT DISABLED

    //         $finishedProduct->stock = $newFinishedStock;
    //         $finishedProduct->save();

    //         $productionOrder->update([
    //             'status' => $purchaseRequisition ? 'pending' : 'in_progress'
    //         ]);

    //         DB::commit();

    //         return back()->with(
    //             'success_message',
    //             $purchaseRequisition
    //                 ? 'Production started. Purchase Requisition created.'
    //                 : 'Production started successfully.'
    //         );
    //     } catch (\Exception $e) {

    //         DB::rollBack();
    //         return back()->withInput()->with('error_message', 'Error: ' . $e->getMessage());
    //     }
    // }

    public function store(Request $request)
    {
        $data = $request->validate([
            'production_order_id' => 'required|exists:production_orders,id',
            'branch_id' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $productionOrder = ProductionOrder::with('bom.items')->findOrFail($data['production_order_id']);
            $bom = $productionOrder->bom;

            if (!$bom) {
                return back()->with('error_message', 'BOM not found for this production order');
            }

            if ($data['branch_id'] != $productionOrder->branch_id) {
                return back()->with('error_message', 'Branch mismatch with Production Order');
            }

            $warehouseId = $productionOrder->branch_id;
            $qtyToProduce = (float)$productionOrder->quantity;

            $purchaseRequisition = null;

            foreach ($bom->items as $item) {

                $product = Product::find($item->raw_product_id);

                if (!$product) {
                    throw new \Exception("Raw product not found (ID: {$item->raw_product_id})");
                }

                if ($product->branch_id != $warehouseId) {
                    throw new \Exception("Product {$product->id} does not belong to selected branch");
                }

                $requiredQty = ($item->quantity * $qtyToProduce);

                if (!empty($item->wastage_percent)) {
                    $requiredQty *= (1 + ($item->wastage_percent / 100));
                }

                $bufferMultiplier = 1.1;
                $requiredWithBuffer = $requiredQty * $bufferMultiplier;

                // ✅ USE PRODUCT STOCK DIRECTLY
                $currentStock = (float) $product->stock;

                // =========================
                // CONSUMPTION
                // =========================
                if ($currentStock > 0) {

                    $consumeQty = min($currentStock, $requiredQty);
                    $newStock = $currentStock - $consumeQty;

                    ProductionConsumption::create([
                        'production_order_id' => $productionOrder->id,
                        'raw_product_id' => $item->raw_product_id,
                        'quantity_used' => $consumeQty,
                        'branch_id' => $warehouseId,
                    ]);

                    // ✅ UPDATE STOCK (SUBTRACT)
                    $product->stock = $newStock;
                    $product->save();
                }

                // =========================
                // PURCHASE REQUISITION
                // =========================
                if ($currentStock < $requiredWithBuffer) {

                    $shortQty = max($requiredWithBuffer - $currentStock, 0);

                    if ($shortQty > 0) {

                        if (!$purchaseRequisition) {

                            $purchaseRequisition = PurchaseRequisition::create([
                                'pr_number'      => null,
                                'requested_by'   => auth()->id(),
                                'department'     => 'Production',
                                'reference_type' => 'production_order',
                                'reference_id'   => $productionOrder->id,
                                'status'         => 'pending',
                            ]);

                            $purchaseRequisition->update([
                                'pr_number' => 'PR-' . str_pad($purchaseRequisition->id, 6, '0', STR_PAD_LEFT)
                            ]);
                        }

                        PurchaseRequisitionItem::create([
                            'requisition_id' => $purchaseRequisition->id,
                            'product_id' => $item->raw_product_id,
                            'required_qty' => $shortQty,
                        ]);
                    }
                }
            }

            // =========================
            // FINISHED GOODS
            // =========================
            if (empty($productionOrder->finished_product_id)) {
                throw new \Exception("Production order does not have a finished product assigned.");
            }

            $finishedProduct = Product::find($productionOrder->finished_product_id);

            if (!$finishedProduct) {
                throw new \Exception("Finished product not found (ID: {$productionOrder->finished_product_id})");
            }

            if ($finishedProduct->branch_id != $warehouseId) {
                throw new \Exception("Finished product does not belong to selected branch");
            }

            // ✅ ADD STOCK (INCREMENT)
            $currentFinishedStock = (float) $finishedProduct->stock;
            $newFinishedStock = $currentFinishedStock + $qtyToProduce;

            $finishedProduct->stock = $newFinishedStock;
            $finishedProduct->save();

            // =========================
            // STATUS UPDATE
            // =========================
            $productionOrder->update([
                'status' => $purchaseRequisition ? 'pending' : 'in_progress'
            ]);

            DB::commit();

            return back()->with(
                'success_message',
                $purchaseRequisition
                    ? 'Production started. Purchase Requisition created.'
                    : 'Production started successfully.'
            );
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->withInput()->with('error_message', 'Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'production_order_id' => 'required',
            'raw_product_id' => 'required',
            'quantity_used' => 'required',
            'branch_id' => 'required',
        ]);

        $productcom = ProductionConsumption::where('id', $id)->first();

        $res = $productcom->update($data);

        if ($res) {
            return back()->with('success_message', 'Production consumption updated successfully');
        } else {
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        $productcom = ProductionConsumption::where('id', $id)->first();

        $productcom->delete();

        return back()->with('success_message', 'Production consumption deleted successfully');
    }

    public function manufacturing()
    {
        if (auth()->user()->hasRole('Admin')) {
            $salesOrder = SalesOrder::where('status', 'manufacturing')->where('production_status', 'approved')->where('manufactured', 'processing')->get();
        } else {
            $salesOrder = SalesOrder::where('branch_id', auth()->user()->branch_id)->where('status', 'manufacturing')->where('production_status', 'approved')->where('manufactured', 'processing')->get();
        }

        return view('admin.productionconsumption.manufacturing', compact('salesOrder'));
    }

    // public function productManufacture(Request $request, $id)
    // {
    //     DB::beginTransaction();

    //     try {

    //         $warehouseId = $request->branch ?? null;

    //         // Load sales order with BOM items
    //         $salesorder = SalesOrder::with('items.product.bom.items')->findOrFail($id);

    //         // dd($salesorder->items->pluck('product')->pluck('bom')->pluck('items'));

    //         // OPTIONAL: if no items
    //         if ($salesorder->items->isEmpty()) {
    //             return back()->with('error_message', 'Sales order has no items.');
    //         }

    //         $purchaseRequisition = null;

    //         foreach ($salesorder->items as $soItem) {

    //             $product = $soItem->product;

    //             // dd($soItem->product_id);

    //             if (!$product || !$product->bom) {
    //                 return back()->with('error_message', "BOM missing for product: {$product->name}");
    //             }

    //             // $bom = $product->bom;

    //             // Quantity to produce based on sales order item quantity
    //             $qtyToProduce = (float)($soItem->quantity ?? 0);

    //             // // dd($bom);

    //             if ($qtyToProduce <= 0) {
    //                 continue;
    //             }

    //             // dd($bom->items);

    //             foreach ($product->bom as $bom) {
    //                 // dd($bom->items);
    //                 foreach ($bom->items as $bomItem) {

    //                     // required qty = bom qty * sales order item qty
    //                     $requiredQty = ((float)$bomItem->quantity) * $qtyToProduce;

    //                     // dd($requiredQty);
    //                     if (!empty($bomItem->wastage_percent)) {
    //                         $requiredQty *= (1 + ((float)$bomItem->wastage_percent / 100));
    //                     }

    //                     // buffer
    //                     $bufferMultiplier = 11;
    //                     $requiredWithBuffer = $requiredQty * $bufferMultiplier;

    //                     // Get stock for raw material
    //                     $query = StockMovement::where('product_id', $bomItem->raw_product_id);

    //                     if ($warehouseId) {
    //                         $query->where('warehouse_id', $warehouseId);
    //                     } else {
    //                         $query->whereNull('warehouse_id');
    //                     }

    //                     $lastMovement = $query->latest()->first();
    //                     $rawProduct = Product::find($bomItem->raw_product_id);

    //                     $availableStock = $lastMovement
    //                         ? (float)$lastMovement->quantity_after
    //                         : (float)($rawProduct->opening_stock ?? 0);

    //                     //  Consume if stock exists
    //                     if ($availableStock > 0 && $requiredQty > 0) {

    //                         $consumeQty = min($availableStock, $requiredQty);
    //                         $quantityAfter = $availableStock - $consumeQty;

    //                         // Save consumption record (create your own table or reuse existing)
    //                         ProductionConsumption::create([
    //                             // Since this is sales order based:
    //                             'sales_order_id'   => $salesorder->id,
    //                             'sales_order_item_id' => $soItem->id,
    //                             'finished_product_id' => $product->id,
    //                             'raw_product_id'   => $bomItem->raw_product_id,
    //                             'quantity_used'    => $consumeQty,
    //                             'warehouse_id'     => $warehouseId,
    //                         ]);

    //                         StockMovement::create([
    //                             'product_id'       => $bomItem->raw_product_id,
    //                             'warehouse_id'     => $warehouseId,
    //                             'movement_type'    => 'manufacturing_consumption',
    //                             'quantity'         => $consumeQty,
    //                             'quantity_before'  => $availableStock,
    //                             'quantity_after'   => $quantityAfter,
    //                             'reference_type'   => 'sales_order',
    //                             'reference_id'     => $salesorder->id,
    //                             'note'             => 'Auto consumption from Sales Order manufacturing',
    //                         ]);

    //                         // Update available stock variable so shortage calc is correct
    //                         $availableStock = $quantityAfter;
    //                     }

    //                     //  If below buffer -> PR creation
    //                     if ($availableStock < $requiredWithBuffer) {

    //                         $bufferShortQty = max($requiredWithBuffer - $availableStock, 0);

    //                         if ($bufferShortQty > 0) {

    //                             if (!$purchaseRequisition) {

    //                                 $lastPR = PurchaseRequisition::latest()->first();

    //                                 $purchaseRequisition = PurchaseRequisition::create([
    //                                     'pr_number'      => 'PR-' . str_pad(($lastPR->id ?? 0) + 1, 6, '0', STR_PAD_LEFT),
    //                                     'requested_by'   => auth()->id(),
    //                                     'department'     => 'Production',
    //                                     'reference_type' => 'sales_order',
    //                                     'reference_id'   => $salesorder->id,
    //                                     'status'         => 'pending',
    //                                     'approved_by'    => null,
    //                                 ]);
    //                             }

    //                             PurchaseRequisitionItem::create([
    //                                 'requisition_id' => $purchaseRequisition->id,
    //                                 'product_id'              => $bomItem->raw_product_id,
    //                                 'required_qty'       => $bufferShortQty,
    //                             ]);
    //                         }
    //                     }
    //                 }
    //             }

    //             foreach ($salesorder->items as $soItem) {

    //                 $inv = Product::find($soItem->product_id);

    //                 $beforeStock = $inv->stock ?? 0;
    //                 $afterStock = $beforeStock + $soItem->quantity;

    //                 // Update product stock
    //                 $inv->update([
    //                     'stock' => $afterStock
    //                 ]);

    //                 // Save stock movement
    //                 StockMovement::create([
    //                     'product_id'       => $soItem->product_id,
    //                     'warehouse_id'     => $warehouseId,
    //                     'movement_type'    => 'manufacturing_consumption',
    //                     'quantity'         => $soItem->quantity,
    //                     'quantity_before'  => $beforeStock,
    //                     'quantity_after'   => $afterStock,
    //                     'reference_type'   => 'sales_order',
    //                     'reference_id'     => $salesorder->id,
    //                     'note'             => 'Finished goods added to inventory from Sales Order manufacturing',
    //                 ]);
    //             }
    //         }

    //         // Update sales order status (you decide statuses)
    //         $salesorder->update([
    //             // 'status' => $purchaseRequisition ? 'manufacturing' : 'in_progress',
    //             'manufactured' => 'manufactured'
    //         ]);


    //         DB::commit();


    //         $vendorUser = $salesorder->customer?->user;

    //         // Global recipients from notification_settings table
    //         $systemRecipients = getNotificationRecipients(
    //             type: 'manufacturing_started',
    //             channel: 'system',
    //             extraUsers: $vendorUser ? [$vendorUser] : []
    //         );

    //         $mailRecipients = getNotificationRecipients(
    //             type: 'manufacturing_started',
    //             channel: 'mail',
    //             extraUsers: ($vendorUser && !empty($vendorUser->email)) ? [$vendorUser] : []
    //         )->filter(fn($user) => !empty($user->email));

    //         // Send system notification
    //         if ($systemRecipients->isNotEmpty()) {
    //             sendSystemNotification(
    //                 users: $systemRecipients->all(),
    //                 title: 'Manufacturing Started',
    //                 message: 'Manufactuing against the Sales Order ' . $salesorder->so_no . ' .',
    //                 type: 'manufacturing_started',
    //                 url: route('admin.product.manufacturing'),
    //                 extra: [
    //                     'proforma_id' => $salesorder->id,
    //                     'received_by' => auth()->id(),
    //                 ]
    //             );
    //         }

    //         // Send mail
    //         // foreach ($mailRecipients as $user) {
    //         //     $mailData = [
    //         //         'subject' => 'Manufacturing Started',
    //         //         'name' => $user->name,
    //         //         'message' => 'Manufacturing against the Sales Order ' .$salesorder->so_no . ' has been started.',
    //         //     ];

    //         //     Mail::to($user->email)->queue(new \App\Mail\GenericMail($mailData));
    //         // }

    //         return back()->with(
    //             'success_message',
    //             $purchaseRequisition
    //                 ? 'Manufacturing started. Purchase Requisition created.'
    //                 : 'Manufacturing started successfully.'
    //         );
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return back()->withInput()->with('error_message', 'Error: ' . $e->getMessage());
    //     }
    // }

    public function productManufacture(Request $request, $id)
{
    DB::beginTransaction();

    try {

        $salesorder = SalesOrder::with('items.product.bom.items')->findOrFail($id);

        // dd($salesorder);

        $salesOrderBranchId = $salesorder->branch_id; // IMPORTANT

        if ($salesorder->items->isEmpty()) {
            return back()->with('error_message', 'Sales order has no items.');
        }

        foreach ($salesorder->items as $soItem) {

            $product = $soItem->product;

            if (!$product || !$product->bom) {
                return back()->with('error_message', "BOM missing for product: {$product->name}");
            }

            $qtyToProduce = (float)($soItem->quantity ?? 0);

            if ($qtyToProduce <= 0) {
                continue;
            }

            foreach ($product->bom as $bom) {
                foreach ($bom->items as $bomItem) {

                    $requiredQty = ((float)$bomItem->quantity) * $qtyToProduce;

                    if (!empty($bomItem->wastage_percent)) {
                        $requiredQty *= (1 + ((float)$bomItem->wastage_percent / 100));
                    }

                    // dd($salesOrderBranchId);
                    // Raw material only from SAME branch
                    $rawProduct = Product::where('id', $bomItem->raw_product_id)
                        ->where('branch_id', $salesOrderBranchId)
                        ->lockForUpdate()
                        ->first();

                    // dd($rawProduct);

                    if (!$rawProduct) {
                        throw new \Exception("Raw material not found in this branch");
                    }

                    $currentStock = (float) $rawProduct->stock;

                    if ($currentStock < $requiredQty) {
                        throw new \Exception(
                            "Insufficient stock for {$rawProduct->name}. Needed {$requiredQty}, available {$currentStock}"
                        );
                    }

                    //  Deduct stock
                    // $rawProduct->decrement('stock', $requiredQty);

                    //  Save consumption (NO warehouse_id issue)
                    ProductionConsumption::create([
                        'sales_order_id'        => $salesorder->id,
                        'sales_order_item_id'   => $soItem->id ?? null,
                        'finished_product_id'   => $product->id ?? null,
                        'raw_product_id'        => $bomItem->raw_product_id,
                        'quantity_used'         => $requiredQty,
                        'warehouse_id'          => null, // FIXED
                    ]);
                }
            }

            //  Add finished goods in SAME branch
            $finishedProduct = Product::where('id', $soItem->product_id)
                ->where('branch_id', $salesOrderBranchId)
                ->lockForUpdate()
                ->first();

            if (!$finishedProduct) {
                throw new \Exception("Finished product not found in this branch");
            }

            $finishedProduct->increment('stock', $qtyToProduce);
        }

        // Update status
        $salesorder->update([
            'manufactured' => 'manufactured'
        ]);

        DB::commit();

        return back()->with('success_message', 'Manufacturing completed successfully');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withInput()->with('error_message', $e->getMessage());
    }
}
}
