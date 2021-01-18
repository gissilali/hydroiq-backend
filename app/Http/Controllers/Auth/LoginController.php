<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\IssuesToken;
use Illuminate\Http\Request;
use Laravel\Passport\Client;

class LoginController extends Controller
{
    use IssuesToken;

    private $client;

    public function __construct()
    {
        $this->client = Client::where('name', config('app.name') . ' Password Grant Client')->first();
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        return $this->issueToken($request, 'password');
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => __('Logged out')
        ]);
    }
}
