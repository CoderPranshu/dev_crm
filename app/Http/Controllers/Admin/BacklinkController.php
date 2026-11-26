<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Backlink;
use App\Models\BacklinkCategory;
use App\Models\BacklinkUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BacklinkController extends Controller
{
    /**
     * Display uploaded CSV / Excel files.
     */
    public function index()
    {
        $ownerQuery = BacklinkUpload::query()
            ->where('created_by', auth()->id());

        $totalUploadedFiles = (clone $ownerQuery)->count();

        $csvUploadedFiles = (clone $ownerQuery)
            ->where('extension', 'csv')
            ->count();

        $excelUploadedFiles = (clone $ownerQuery)
            ->whereIn('extension', ['xls', 'xlsx'])
            ->count();

        $totalUploadedBytes = (int) (clone $ownerQuery)->sum('size');

        $uploads = BacklinkUpload::query()
            ->with('category')
            ->where('created_by', auth()->id())
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view(
            'admin.backlinks.index',
            compact(
                'uploads',
                'totalUploadedFiles',
                'csvUploadedFiles',
                'excelUploadedFiles',
                'totalUploadedBytes'
            )
        );
    }

    /**
     * Show the manual backlink form.
     */
    public function create()
    {
        $categories = BacklinkCategory::where('status', 1)
            ->orderBy('name')
            ->get();

        return view('admin.backlinks.create', compact('categories'));
    }

    /**
     * Store a manually created backlink.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'backlink_category_id' => ['required', 'exists:backlink_categories,id'],
            'website_url' => ['required', 'url', 'unique:backlinks,website_url'],
            'domain_authority' => ['nullable', 'integer', 'min:0', 'max:100'],
            'page_authority' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);

        try {
            DB::transaction(function () use ($validated) {
                Backlink::create([
                    'backlink_category_id' => $validated['backlink_category_id'],
                    'website_url' => $validated['website_url'],
                    'domain_authority' => $validated['domain_authority'] ?? null,
                    'page_authority' => $validated['page_authority'] ?? null,
                    'status' => 'available',
                    'created_by' => auth()->id(),
                ]);
            });

            return redirect()
                ->route('admin.backlinks.index')
                ->with('success', 'Backlink added successfully.');
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Backlink could not be added.');
        }
    }

    /**
     * Show the manual backlink edit form.
     */
    public function edit($id)
    {
        $backlink = Backlink::findOrFail($id);

        $categories = BacklinkCategory::where('status', 1)
            ->orderBy('name')
            ->get();

        return view(
            'admin.backlinks.edit',
            compact('backlink', 'categories')
        );
    }

    /**
     * Update a manually created backlink.
     */
    public function update(Request $request, $id)
    {
        $backlink = Backlink::findOrFail($id);

        $validated = $request->validate([
            'backlink_category_id' => ['required', 'exists:backlink_categories,id'],
            'website_url' => [
                'required',
                'url',
                'unique:backlinks,website_url,' . $backlink->id,
            ],
            'domain_authority' => ['nullable', 'integer', 'min:0', 'max:100'],
            'page_authority' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);

        try {
            DB::transaction(function () use ($backlink, $validated) {
                $backlink->update([
                    'backlink_category_id' => $validated['backlink_category_id'],
                    'website_url' => $validated['website_url'],
                    'domain_authority' => $validated['domain_authority'] ?? null,
                    'page_authority' => $validated['page_authority'] ?? null,
                ]);
            });

            return redirect()
                ->route('admin.backlinks.index')
                ->with('success', 'Backlink updated successfully.');
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Backlink could not be updated.');
        }
    }

    /**
     * Delete a manually created backlink.
     */
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                Backlink::findOrFail($id)->delete();
            });

            return redirect()
                ->route('admin.backlinks.index')
                ->with('success', 'Backlink deleted successfully.');
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Backlink could not be deleted.');
        }
    }
}




