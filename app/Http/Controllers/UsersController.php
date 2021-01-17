<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([

        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required | email | unique:users,email',
            'date_of_birth' => 'required'
        ]);



        return response()->json([
            'message' => __('user created'),
            'data' => User::create([
                'name' => $request->name,
                'email' => $request->email,
                'date_of_birth' => $request->date_of_birth,
                'creator_id' => $request->user()->id,
            ])
        ], 201);
    }
}
