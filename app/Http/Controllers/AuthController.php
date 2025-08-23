<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;
class AuthController extends Controller
{
    protected AuthService $_authService;

public function __construct(AuthService $authService) 
     { $this->_authService = $authService; }


    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            switch ($user->role->value) {
                case 'super_admin':
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'tech_lead':
                    return redirect()->route('techlead.dashboard');
                case 'engineer':
                    return redirect()->route('engineer.dashboard');
                default:
                    return redirect('/'); // fallback
            }
        }

        return view('auth.login');
    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Invalid credentials')->withInput();
        }

        $user = Auth::user();

        // Redirect based on role
        switch ($user->role->value) {
            case 'super_admin':
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'tech_lead':
                return redirect()->route('techlead.dashboard');
            case 'engineer':
                return redirect()->route('engineer.dashboard');
            default:
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role not recognized');
        }
    }


    public function logout()
    {
        if (Auth::check()) {
            Auth::logout(); 
        }

        return redirect()->route('login')->with('success', 'Logged out successfully');
    }

    // just for API testing and stuff
    public function loginApi(LoginRequest $request) 
    { $credentials = $request->validated();
         $result = $this->_authService->login($credentials);
          return response()->json($result); 
        }
}
