<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required'
        ]);
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw new AuthenticationException();
        }
        return $this->jsonResponse(true, auth()->user(), 200);
    }

    public function logout()
    {
        if (auth()->check()) {
            Auth::logout();
            return $this->jsonResponse(true, 'Logged out successfully', 200);
        }
        return $this->jsonResponse(true, 'Something went wrong', 404);
    }

    private function jsonResponse($success, $data, $status)
    {
        return response()->json([
            'success' => $success,
            'data'    => $data,
        ], $status);
    }
}
