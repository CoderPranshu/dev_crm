<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $roles = Role::latest()->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        $permissions = array_map('intval', $request->permission);

        $role->syncPermissions($permissions);

        return redirect()->route('admin.role.index')
                        ->with('success_message','Role created successfully');
    }

    public function edit($id)
    {
        return view('admin.roles.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'permission' => 'required|array',
        ]);

        $role = Role::findOrFail($id);

        $role->update([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        // Convert "1" to 1 (string → integer)
        $permissions = array_map('intval', $request->permission);

        $role->syncPermissions($permissions);

        return redirect()->route('admin.role.index')
                        ->with('success_message', 'Role updated successfully');
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('admin.role.index')
                        ->with('success_message','Role deleted successfully');
    }

}
