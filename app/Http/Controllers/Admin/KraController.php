<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Kra, Department, User};

class KraController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kra-list|kra-create|kra-edit|kra-delete', ['only' => ['index','store']]);
        $this->middleware('permission:kra-create', ['only' => ['create','store']]);
        $this->middleware('permission:kra-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:kra-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $kras = Kra::get();
        $departments = Department::get();
        // dd($departments);
        return view('admin.kra.index', compact('kras', 'departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'department_id' => 'required',
            'branch_id' => 'required'
        ]);

        $res = Kra::create($data);

        if($res)
        {
            return redirect()->back()->with('success_message', 'Kra created successfully');
        }else
        {
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'department_id' => 'required',
            'branch_id' => 'required'
        ]);

        $kra = Kra::where('id', $id)->firstOrFail();

        $res = $kra->update($data);

        if($res)
        {
            return redirect()->back()->withInput()->with('success_message', 'Kra updated successfully');
        }else{
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        $kra = Kra::where('id', $id)->firstOrFail();

        $res = $kra->delete();

        if($res)
        {
            return back()->with('success_message', 'Kra deleted successfully');
        }
    }

    public function completion($kra_id, User $user)
    {
        $user_id = $user->id;

        $pivot = \DB::table('kra_user')
            ->where('kra_id', $kra_id)
            ->where('user_id', $user_id)
            ->first();

        if ($pivot) {
            // toggle complete
            \DB::table('kra_user')
                ->where('kra_id', $kra_id)
                ->where('user_id', $user_id)
                ->update([
                    'complete' => $pivot->complete == 1 ? 0 : 1,
                    'updated_at' => now(),
                ]);
        } else {
            // insert if not exists
            \DB::table('kra_user')->insert([
                'kra_id'     => $kra_id,
                'user_id'    => $user_id,
                'complete'   => 1,
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'KRA completion updated',
            'reload' => 'kra'
        ]);
    }

    public function status($kra_id, User $user)
    {
        \DB::table('kra_user')
            ->where('kra_id', $kra_id)
            ->where('user_id', $user->id)
            ->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'KRA removed for user',
            'reload' => 'kra'
        ]);
    }



}
