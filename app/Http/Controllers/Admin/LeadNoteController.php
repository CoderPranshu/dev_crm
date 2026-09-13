<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{LeadNote, Lead};

class LeadNoteController extends Controller
{
    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'description' => 'nullable',
    //         'lead_id' => 'nullable',
    //         'call_date' => 'nullable'
    //     ]);

    //     $data['created_by'] = auth()->user()->id;

    //     LeadNote::create($data);

    //     return redirect()->back()->with('success', 'Note added successfully');
    // }

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $data = $request->validate([
            'description' => [
                'required',
                'string',
                'max:2000',
            ],

            'lead_id' => [
                'required',
                'exists:leads,id',
            ],

            'call_date' => [
                'nullable',
                'date',
            ],
        ], [
            'description.required' =>
                'Lead Note is required.',

            'lead_id.required' =>
                'Lead is required.',

            'lead_id.exists' =>
                'Selected lead does not exist.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | LEAD
        |--------------------------------------------------------------------------
        */

        $lead = Lead::findOrFail(
            $data['lead_id']
        );


        /*
        |--------------------------------------------------------------------------
        | ACCESS CONTROL
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();

        if (
            !$user->hasRole('Admin')
            &&
            (int) $lead->user_id !== (int) $user->id
        ) {

            if ($request->expectsJson()) {

                return response()->json([
                    'status' => false,
                    'message' =>
                        'You are not allowed to add a note to this lead.',
                ], 403);
            }


            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | CREATED BY
        |--------------------------------------------------------------------------
        */

        $data['created_by'] =
            $user->id;


        /*
        |--------------------------------------------------------------------------
        | CREATE NOTE
        |--------------------------------------------------------------------------
        */

        $note = LeadNote::create(
            $data
        );


        /*
        |--------------------------------------------------------------------------
        | AJAX RESPONSE
        |--------------------------------------------------------------------------
        */

        if (
            $request->expectsJson()
            ||
            $request->ajax()
        ) {

            return response()->json([

                'status' =>
                    true,

                'message' =>
                    'Lead Note added successfully.',

                'note' => [

                    'id' =>
                        $note->id,

                    'lead_id' =>
                        $note->lead_id,

                    'description' =>
                        $note->description,

                    'created_by' =>
                        $note->created_by,

                    'call_date' =>
                        $note->call_date,
                ],
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL FORM RESPONSE
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->back()
            ->with(
                'success',
                'Note added successfully'
            );
    }



    public function history($id)
    {
        $lead = Lead::findOrFail($id);

        $notes = LeadNote::with('user')
            ->where('lead_id', $id)
            ->latest()
            ->get();

        return view('admin.leads.leadhis', compact('lead', 'notes'));
    }
}
