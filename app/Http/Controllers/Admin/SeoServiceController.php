<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SeoServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('permission:seo-service-list', ['only' => ['index']]);

        $this->middleware('permission:seo-service-view', ['only' => ['show']]);

        $this->middleware('permission:seo-service-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:seo-service-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:seo-service-delete', ['only' => ['destroy']]);
    }



    public function index()
    {
        $seoServices = SeoService::latest()->get();

        // return 'hello';

        return view('admin.seo-services.index', compact('seoServices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.seo-services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:seo_services,name',
            'description' => 'nullable|string',
            'status'      => 'required|boolean',
        ]);

        SeoService::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        return redirect()
            ->route('admin.seo-services.index')
            ->with('success', 'SEO Service created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SeoService $seoService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SeoService $seoService)
    {
        return view('admin.seo-services.edit', compact('seoService'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SeoService $seoService)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:seo_services,name,' . $seoService->id,
            'description' => 'nullable|string',
            'status'      => 'required|boolean',
        ]);

        $seoService->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        return redirect()
            ->route('admin.seo-services.index')
            ->with('success', 'SEO Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeoService $seoService)
    {
        $seoService->delete();

        return redirect()
            ->route('admin.seo-services.index')
            ->with('success', 'SEO Service deleted successfully.');
    }
}