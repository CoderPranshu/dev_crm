<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Bom, BomItem};
use DB;

class BomController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:bom-list|bom-create|bom-update|bom-delete|bom-show', ['only' => ['index', 'store']]);
        $this->middleware('permission:bom-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:bom-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:bom-delete', ['only' => ['destroy']]);
        $this->middleware('permission:bom-show', ['only' => ['show']]);
    }

    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $boms = Bom::latest()->get();
        } else {
            $boms = Bom::where('branch_id', auth()->user()->branch_id)->latest()->get();
        }
        return view('admin.bom.index', compact('boms'));
    }

    public function create()
    {
        return view('admin.bom.add');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'version' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'branch_id' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.raw_product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.0001',
            'items.*.wastage_percent' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($data, &$bom) {
            $lastId = DB::table('boms')->lockForUpdate()->max('id');
            $nextId = $lastId ? $lastId + 1 : 1;

            $bomNo = 'Bom-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            $bom = Bom::create([
                'bom_no' => $bomNo,
                'product_id' => $data['product_id'],
                'version' => $data['version'] ?? '1.0',
                'notes' => $data['notes'] ?? null,
                'branch_id' => $data['branch_id'],
                'is_active' => $data['is_active'] ?? 1,
            ]);
        });

        foreach ($data['items'] as $item) {
            BomItem::create([
                'bom_id' => $bom->id,
                'raw_product_id' => $item['raw_product_id'],
                'quantity' => $item['quantity'],
                'wastage_percent' => $item['wastage_percent'] ?? 0,
            ]);
        }

        return back()->with('success_message', 'BOM created successfully');
    }

    public function edit($id)
    {
        $bom = Bom::with('items')->findOrFail($id);

        return view('admin.bom.edit', compact('bom', 'id'));
    }

    public function update(Request $request, $id)
    {
        $bom = Bom::with('items')->findOrFail($id);

        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'version' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'branch_id' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.raw_product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.0001',
            'items.*.wastage_percent' => 'nullable|numeric|min:0',
        ]);

        $is_active = $request->has('is_active') ? 1 : 0;

        $bom->update([
            'product_id' => $data['product_id'],
            'version' => $data['version'] ?? $bom->version,
            'notes' => $data['notes'] ?? null,
            'is_active' => $is_active,
            'branch_id' => $data['branch_id'],
        ]);

        $existingIds = $bom->items->pluck('id')->toArray();
        $receivedIds = [];

        foreach ($data['items'] as $itemData) {

            if (!empty($itemData['id'])) {

                $item = BomItem::find($itemData['id']);

                if ($item) {
                    $item->update([
                        'raw_product_id' => $itemData['raw_product_id'],
                        'quantity' => $itemData['quantity'],
                        'wastage_percent' => $itemData['wastage_percent'] ?? 0,
                    ]);

                    $receivedIds[] = $itemData['id'];
                }
            } else {
                BomItem::create([
                    'bom_id' => $bom->id,
                    'raw_product_id' => $itemData['raw_product_id'],
                    'quantity' => $itemData['quantity'],
                    'wastage_percent' => $itemData['wastage_percent'] ?? 0,
                ]);
            }
        }

        $idsToDelete = array_diff($existingIds, $receivedIds);
        BomItem::whereIn('id', $idsToDelete)->delete();

        return back()->with('success_message', 'BOM updated successfully');
    }


    public function delete(Request $request, $id)
    {
        $bom = Bom::where('id', $id)->firstOrFail();

        $bom->delete();

        return back()->with('success_message', 'Bom deleted successfully');
    }


    public function getFinishedProduct($id)
    {
        $bom = Bom::with('product')->findOrFail($id);

        return response()->json([
            'product_id' => $bom->product_id,
            'product_name' => $bom->product->name
        ]);
    }

    public function show($id)
    {
        $bom = Bom::with('product', 'items')->findOrFail($id);

        return view('admin.bom.show', compact('bom'));
    }
}
