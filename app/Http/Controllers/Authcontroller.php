<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Show the role selection page.
     */
    public function showRoleSelection()
    {
        return view('auth.role_selection');
    }



    /**
     * Show the login form based on role.
     */
    public function showLoginForm($role)
    {
        return view('auth.login', ['role' => $role]);
    }
}
