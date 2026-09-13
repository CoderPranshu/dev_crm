<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeadCategory;

class LeadCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            'permission:lead-category-list|lead-category-create|lead-category-update|lead-category-delete',
            ['only' => ['index', 'store']]
        );

        $this->middleware(
            'permission:lead-category-create',
            ['only' => ['create', 'store']]
        );

        $this->middleware(
            'permission:lead-category-update',
            ['only' => ['edit', 'update']]
        );

        $this->middleware(
            'permission:lead-category-delete',
            ['only' => ['destroy']]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $leadcats = LeadCategory::latest()->get();

        return view(
            'admin.leadcat.index',
            compact('leadcats')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'title' => 'nullable',
    //     ]);

    //     $response = LeadCategory::create($data);

    //     if ($response) {

    //         return redirect()
    //             ->back()
    //             ->with(
    //                 'sucess_message',
    //                 'Lead category created successfully'
    //             );

    //     } else {

    //         return redirect()
    //             ->back()
    //             ->withInput()
    //             ->with(
    //                 'error_message',
    //                 'Something went wrong'
    //             );
    //     }
    // }

    public function store(Request $request)
{
    $data = $request->validate([
        'title' => [
            'required',
            'string',
            'max:255',
            'unique:lead_categories,title',
        ],
    ], [
        'title.required' =>
            'Lead category name is required.',

        'title.unique' =>
            'This Lead Category already exists.',
    ]);


    $response = LeadCategory::create($data);


    if ($response) {

        return redirect()
            ->back()
            ->with(
                'success_message',
                'Lead category created successfully'
            );
    }


    return redirect()
        ->back()
        ->withInput()
        ->with(
            'error_message',
            'Something went wrong'
        );
}




    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    // public function update(Request $request, $id)
    // {
    //     $leadcat = LeadCategory::where(
    //         'id',
    //         $id
    //     )->firstOrFail();

    //     $data = $request->validate([
    //         'title' => 'nullable'
    //     ]);

    //     $response = $leadcat->update($data);

    //     if ($response) {

    //         return redirect()
    //             ->back()
    //             ->with(
    //                 'success_message',
    //                 'Lead Category updated successfully'
    //             );

    //     } else {

    //         return redirect()
    //             ->back()
    //             ->withInput()
    //             ->with(
    //                 'error_message',
    //                 'Something went wrong'
    //             );
    //     }
    // }


    public function update(Request $request, $id)
{
    $leadcat = LeadCategory::where(
        'id',
        $id
    )->firstOrFail();


    $data = $request->validate([
        'title' => [
            'required',
            'string',
            'max:255',

            Rule::unique(
                'lead_categories',
                'title'
            )->ignore($leadcat->id),
        ],
    ], [
        'title.required' =>
            'Lead category name is required.',

        'title.unique' =>
            'This Lead Category already exists.',
    ]);


    $response = $leadcat->update($data);


    if ($response) {

        return redirect()
            ->back()
            ->with(
                'success_message',
                'Lead Category updated successfully'
            );
    }


    return redirect()
        ->back()
        ->withInput()
        ->with(
            'error_message',
            'Something went wrong'
        );
}



    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(Request $request, $id)
    {
        /*
         * Category find karo.
         */

        $leadcat = LeadCategory::where(
            'id',
            $id
        )->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | CHECK CATEGORY HAS LEADS
        |--------------------------------------------------------------------------
        |
        | Agar is category ke andar ek bhi lead hai,
        | category delete nahi hogi.
        |
        */

        if ($leadcat->leads()->exists()) {

            return redirect()
                ->back()
                ->with(
                    'error_message',
                    'This lead category cannot be deleted because it contains leads. Please delete all leads from this category first.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | DELETE EMPTY CATEGORY
        |--------------------------------------------------------------------------
        |
        | Yahan tabhi pahuchega jab category ke andar
        | koi bhi lead nahi hogi.
        |
        */

        $deleted = $leadcat->delete();


        if ($deleted) {

            return redirect()
                ->back()
                ->with(
                    'success_message',
                    'Lead category deleted successfully'
                );
        }


        return redirect()
            ->back()
            ->with(
                'error_message',
                'Something went wrong'
            );
    }
}

