<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Transformers\UserTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'data' => fractal(User::orderBy('created_at', 'desc')->get(), new UserTransformer())
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
            'data' => fractal(User::create([
                'name' => $request->name,
                'email' => $request->email,
                'date_of_birth' => Carbon::parse($request->date_of_birth),
                'creator_id' => $request->user()->id,
            ]), new UserTransformer())
        ], 201);
    }
}
