<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Backlink;
use App\Models\BacklinkCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BacklinkController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Backlink::with([
            'category',
            'assignedTo',
            'assignedBy'
        ]);

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('website_url', 'like', '%' . $request->search . '%')
                  ->orWhere('domain_authority', 'like', '%' . $request->search . '%')
                  ->orWhere('page_authority', 'like', '%' . $request->search . '%');

            });

        }

        if ($request->filled('category')) {

            $query->where(
                'backlink_category_id',
                $request->category
            );

        }

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }

        $backlinks = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $categories = BacklinkCategory::where('status',1)->get();

        $totalBacklinks = Backlink::count();

        $availableBacklinks = Backlink::where(
            'status',
            'available'
        )->count();

        $assignedBacklinks = Backlink::where(
            'status',
            'assigned'
        )->count();

        $completedBacklinks = Backlink::where(
            'status',
            'completed'
        )->count();

        return view(
            'admin.backlinks.index',
            compact(
                'backlinks',
                'categories',
                'totalBacklinks',
                'availableBacklinks',
                'assignedBacklinks',
                'completedBacklinks'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $categories = BacklinkCategory::where(
            'status',
            1
        )->get();

        return view('admin.backlinks.create', compact('categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'backlink_category_id' => 'required|exists:backlink_categories,id',

            'website_url' => 'required|url|unique:backlinks,website_url',

            'domain_authority' => 'nullable|numeric|min:0|max:100',

            'page_authority' => 'nullable|numeric|min:0|max:100',

        ]);

        DB::beginTransaction();

        try {

            Backlink::create([

                'backlink_category_id' => $request->backlink_category_id,

                'website_url' => $request->website_url,

                'domain_authority' => $request->domain_authority,

                'page_authority' => $request->page_authority,

                'created_by' => auth()->id(),

            ]);

            DB::commit();

            return redirect()
                ->route('admin.backlinks.index')
                ->with(
                    'success',
                    'Backlink Added Successfully.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );

        }
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $backlink = Backlink::findOrFail($id);

        $categories = BacklinkCategory::where(
            'status',
            1
        )->get();

        return view(
            'admin.backlinks.edit',
            compact(
                'backlink',
                'categories'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $backlink = Backlink::findOrFail($id);

        $request->validate([

            'backlink_category_id' => 'required|exists:backlink_categories,id',

            'website_url' => 'required|url|unique:backlinks,website_url,' . $backlink->id,

            'domain_authority' => 'nullable|numeric|min:0|max:100',

            'page_authority' => 'nullable|numeric|min:0|max:100',

        ]);

        DB::beginTransaction();

        try {

            $backlink->update([

                'backlink_category_id' => $request->backlink_category_id,

                'website_url' => $request->website_url,

                'domain_authority' => $request->domain_authority,

                'page_authority' => $request->page_authority,

            ]);

            DB::commit();

            return redirect()
                ->route('admin.backlinks.index')
                ->with(
                    'success',
                    'Backlink Updated Successfully.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );

        }
    }

    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $backlink = Backlink::findOrFail($id);

            $backlink->delete();

            DB::commit();

            return redirect()
                ->route('admin.backlinks.index')
                ->with(
                    'success',
                    'Backlink Deleted Successfully.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with(
                    'error',
                    $e->getMessage()
                );

        }
    }

    public function upload()
    {
        $categories = BacklinkCategory::where(
            'status',
            1
        )->get();

        return view(
            'admin.backlinks.upload',
            compact('categories')
        );
    }

    public function import(Request $request)
    {
        $request->validate([

            'backlink_category_id'=>'required|exists:backlink_categories,id',

            'csv'=>'required|mimes:csv,txt'

        ]);

        $file = fopen($request->file('csv')->getRealPath(),'r');

        $header = fgetcsv($file);

        DB::beginTransaction();

        try{

            $imported=0;

            $skipped=0;

            while(($row=fgetcsv($file))!==false){

                $website=trim($row[0]);

                $da=$row[1] ?? null;

                $pa=$row[2] ?? null;

                if(
                    Backlink::where('website_url',$website)->exists()
                ){
                    $skipped++;
                    continue;
                }

                Backlink::create([

                    'backlink_category_id'=>$request->backlink_category_id,

                    'website_url'=>$website,

                    'domain_authority'=>$da,

                    'page_authority'=>$pa,

                    'status'=>'available',

                    'created_by'=>auth()->id(),

                ]);

                $imported++;

            }

            fclose($file);

            DB::commit();

            return redirect()
                ->route('admin.backlinks.index')
                ->with(
                    'success',
                    "Imported : {$imported} | Skipped : {$skipped}"
                );

        }catch(\Exception $e){

            DB::rollBack();

            return back()->with(
                'error',
                $e->getMessage()
            );

        }
    }
}