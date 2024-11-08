<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
class SpeakerAuthController extends Controller
{
    /**
     * Show the login form for speakers.
     * Redirects to dashboard if the speaker is already authenticated.
     */
    public function showLoginForm()
    {
        
        if (Auth::guard('speaker')->check()) {
            return redirect()->route('speaker.dashboard');
        }

        return view('speakers.auth.login');
    }

    /**
     * Handle speaker login.
     */
    public function login(Request $request)
    {
        try {


            $validator = Validator::make($request->all(), [
               
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);
     
            if ($validator->fails()) {
                $request->session()->flash('error', $validator->messages()->all()[0]);
                return back()
                    ->withErrors($validator)
                    ->withInput();

            }
    
            
           
    
            // Attempt to authenticate the speaker with the provided credentials
            if (Auth::guard('speaker')->attempt($request)) {
                return redirect()->route('speaker.dashboard');
            }
    
            // Redirect back with an error message if authentication fails
            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ])->withInput();

        } catch (\Exception $e) {           
            return redirect()->back()->with('error',  $e->getMessage());   
        }
      
    }

    /**
     * Show the registration form for speakers.
     * Redirects to dashboard if the speaker is already authenticated.
     */
    public function showRegisterForm()
    {
        if (Auth::guard('speaker')->check()) {
            return redirect()->route('speaker.dashboard');
        }

        return view('speakers.auth.register');
    }

    /**
     * Handle speaker registration.
     */
    public function register(Request $request)
    {

        try {

            DB::beginTransaction();
            
            $input = $request->all();
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:speakers,email',
                'password' => 'required|string|min:8|confirmed',
            ]);
     
            if ($validator->fails()) {
                $request->session()->flash('error', $validator->messages()->all()[0]);
                return back()
                    ->withErrors($validator)
                    ->withInput();

            }
    
            // Create the new speaker record
            $speaker = Speaker::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
    
    
            // Log in the newly registered speaker
            Auth::guard('speaker')->login($speaker);
            DB::commit();
            return redirect()->route('speaker.dashboard');

        } catch (\Exception $e) {

            DB::rollback();
            $request->session()->flash('error', $e->getMessage());
            return back()->withInput();

           
        }
    }

    /**
     * Handle speaker logout.
     */
    public function logout()
    {
        Auth::guard('speaker')->logout();
        return redirect()->route('speaker.login');
    }
}
