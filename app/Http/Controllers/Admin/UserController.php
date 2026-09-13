<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User};
use Arr;
use DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        return view('admin.users.index', compact('users'));
    }

    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'roles'    => 'required'
        ]);
    
        // Get user
        $user = User::findOrFail($id);
    
        // Prepare input (exclude roles)
        $input = Arr::except($request->all(), ['roles']);
    
        // Handle password
        if (!empty($request->password)) {
            $input['password'] = Hash::make($request->password);
        } else {
            unset($input['password']);
        }
    
        // Update user data
        $user->update($input);
    
        // Sync roles (best practice)
        $user->syncRoles($request->input('roles'));
    
        return redirect()->route('admin.user.index')
            ->with('success', 'User updated successfully');
    }
}
