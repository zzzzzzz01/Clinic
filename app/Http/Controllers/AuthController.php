<?php

namespace App\Http\Controllers;

use Jenssegers\Agent\Agent;

use App\Models\User;
use App\Models\Patient;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (!session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        } 

        return view('auth.login'); 
    }

    public function registerPage(){
        return view('auth.register');
    }


    public function register(Request $request) 
    {
        // dd($request);
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'password' => 'required|min:6|confirmed',
                'birth_date' => 'required|string|max:255',
                'gender' => 'required|string|max:255',
            ]);
    
            $login = $this->generateLogin();
    
            $user = User::create([
                'name' => $validated['name'],
                'last_name' => $validated['last_name'],
                'login' => $login,
                'phone' => $validated['phone'], 
                'password' => Hash::make($validated['password']), 
            ]);

            Patient::create([
                'user_id' => $user->id,
                'birth_date' => $validated['birth_date'],
                'gender' => $validated['gender'],
            ]);
    
            $user->roles()->attach(3);
    
            // Avtomatik authenticate
            auth()->login($user);

            return redirect()->intended(route('home.page'))->with('success', 'Ro\'yxatdan o\'tish muvaffaqiyatli!'); 
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Xatolik yuz berdi: ' . $e->getMessage());
        }
    }

    public function generateLogin(): string
    {
        $lastUser = User::where('login', 'regexp', '^[0-9]+$')
                        ->orderBy('login', 'desc')
                        ->first();
        
        if ($lastUser && is_numeric($lastUser->login)) {
            $newLogin = (int)$lastUser->login + 1;
        } else {
            $newLogin = date('Ymd') . rand(100, 999);
        }
        
        while (User::where('login', $newLogin)->exists()) {
            $newLogin = is_numeric($newLogin) ? $newLogin + 1 : date('Ymd') . rand(1000, 9999);
        }
        
        return (string)$newLogin;
    }

    public function authanticate(Request $request)
    {
        try {
            $credentials = $request->validate([
                'login' => ['required', 'string'],
                'password' => ['required', 'string'],
            ]);
    
            if (Auth::attempt([
                'login' => $credentials['login'],
                'password' => $credentials['password']
            ])) {
    
                $request->session()->regenerate();
    
                $user = auth()->user();
                $ip = $request->header('X-Forwarded-For') ?? $request->ip();
                $agent = new Agent();

                LoginHistory::create([
                    'user_id'    => $user->id,
                    'ip_address' => $ip,
                    'device'     => $agent->device() ?: ($agent->isDesktop() ? 'Desktop' : 'Mobile'),
                    'browser'    => $agent->browser(),
                    'platform'   => $agent->platform(),
                    'user_agent' => $request->userAgent(),
                    'login_at'   => now(),
                    'status'     => 'active',
                ]); 
    
                if ($user->roles()->where('name', 'Patient')->exists()) {
                    return redirect()
                        ->route('home.page')
                        ->with('success', 'Siz tizimga muvaffaqiyatli kirdingiz');
                }

                if ($user->roles()->where('name', 'Doctor')->exists()) {
                    return redirect()
                        ->route('doctor.dashboard')
                        ->with('success', 'Siz tizimga muvaffaqiyatli kirdingiz');
                }

                if ($user->roles()->where('name', 'Nurse')->exists()) {
                    return redirect()
                        ->route('nurse.dashboard')
                        ->with('success', 'Siz tizimga muvaffaqiyatli kirdingiz');
                }

                if ($user->roles()->where('name', 'Admin')->exists()) {
                    return redirect()
                        ->route('dashboard.index')
                        ->with('success', 'Siz tizimga muvaffaqiyatli kirdingiz');
                }

                if ($user->roles()->where('name', 'Pharmacist')->exists()) {
                    return redirect()
                        ->route('pharmacist.dashboard')
                        ->with('success', 'Siz tizimga muvaffaqiyatli kirdingiz');
                }

                if ($user->roles()->where('name', 'Laboratory Technician')->exists()) {
                    return redirect()
                        ->route('laboratory.dashboard')
                        ->with('success', 'Siz tizimga muvaffaqiyatli kirdingiz');
                }

                if ($user->roles()->where('name', 'Receptionist')->exists()) {
                    return redirect()
                        ->route('receptionist.dashboard')
                        ->with('success', 'Siz tizimga muvaffaqiyatli kirdingiz');
                }
    
                return redirect()
                    ->route('dashboard.index')
                    ->with('success', 'Siz tizimga muvaffaqiyatli kirdingiz');
            }
    
            return back()->withErrors([
                'login' => 'Login yoki parol noto‘g‘ri!',
            ])->onlyInput('login');
    
        } catch (\Illuminate\Validation\ValidationException $e) {
    
            return back()->withErrors($e->errors())->onlyInput('login');
    
        } catch (\Exception $e) {
    
            return back()->withErrors([
                'error' => 'Tizimda xatolik yuz berdi. Iltimos keyinroq urinib ko\'ring.',
            ])->onlyInput('login');
        }
    }

    public function logout(Request $request)
    {
        try {
    
            LoginHistory::where('user_id', auth()->id())
                ->where('status', 'active')
                ->latest()
                ->first()?->update([
                    'logout_at' => now(),
                    'status' => 'logout',
                ]);
    
            Auth::logout();
    
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            return redirect('/');
    
        } catch (\Exception $e) {
    
            return redirect('/');
    
        }
    }

    public function loginHistory()
    {
        $histories = LoginHistory::where('user_id', auth()->id())
            ->latest('login_at')
            ->paginate(10);

        return view('dashboard.login-history', compact('histories'));
    }

    
}
