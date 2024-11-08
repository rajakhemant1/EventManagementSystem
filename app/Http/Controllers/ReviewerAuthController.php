<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewerAuthController extends Controller
{
    /**
     * Show the login form for reviewers.
     */
    public function showLoginForm()
    {
        return view('reviewers.auth.login');
    }

    /**
     * Handle the reviewer login request.
     */
    public function login(Request $request)
    {
        try {
            
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('reviewer')->attempt($credentials)) {
            return redirect()->route('reviewer.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();

        } catch (\Exception $e) {           
            return redirect()->back()->with('error',  $e->getMessage());   
        }

    }

    /**
     * Log the reviewer out.
     */
    public function logout()
    {
        Auth::guard('reviewer')->logout();
        return redirect()->route('reviewer.login');
    }

    /**
     * Display the dashboard for reviewers.
     */
    public function dashboard()
    {
        return view('reviewers.dashboard');
    }
}
