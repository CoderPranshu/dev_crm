<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthController extends Controller
{


    // public function login(Request $request)
    // {



    //     $request->validate([

    //         'email'=>'required|email',

    //         'password'=>'required'

    //     ]);



    //     $user = User::where(
    //         'email',
    //         $request->email
    //     )->first();



    //     if(
    //         !$user ||
    //         !Hash::check(
    //             $request->password,
    //             $user->password
    //         )
    //     ){

    //         return response()->json([

    //             'status'=>false,

    //             'message'=>'Invalid email or password'

    //         ],401);

    //     }



    //     $token = $user->createToken(
    //         'mobile-app'
    //     )->plainTextToken;



    //     return response()->json([

    //         'status'=>true,

    //         'message'=>'Login successful',

    //         'token'=>$token,

    //         'user'=>[

    //             'id'=>$user->id,

    //             'name'=>$user->name,

    //             'email'=>$user->email,

    //             'role'=>$user->getRoleNames()

    //         ]

    //     ]);

    // }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Logged out successfully.',
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user()->load('branch', 'designation');

        return response()->json([
            'status' => true,
            'data'   => [
                'id'          => $user->id,
                'name'        => $user->name,
                'last_name'   => $user->last_name,
                'email'       => $user->email,
                'phone'       => $user->phone,
                'branch_id'   => $user->branch_id,
                'branch'      => $user->branch,
                'designation' => $user->designation,
                'roles'       => $user->getRoleNames()->values(),
                'permissions' => $user->getAllPermissions()->pluck('name')->values(),
            ],
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (
            !$user ||
            !Hash::check($request->password, $user->password)
        ) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Login successful',
            'token'   => $token,

            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,

                'role' => $user
                    ->getRoleNames()
                    ->values(),

                'permissions' => $user->getAllPermissions()->pluck('name')->values(),
            ],
        ], 200);
    }


}
