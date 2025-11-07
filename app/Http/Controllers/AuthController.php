<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        $registered = (bool) $request->boolean('registered');

        return view('auth.login', [
            'registered' => $registered,
        ]);
    }

    public function login(Request $request)
    {
        // Preserve variable names
        $username = trim($request->input('username', ''));
        $password = (string) $request->input('password', '');

        $validatedErrors = [
            'username' => [],
            'password' => [],
        ];

        if ($username === '') {
            $validatedErrors['username'][] = 'Enter username.';
        }
        if ($password === '') {
            $validatedErrors['password'][] = 'Enter password.';
        }

        if (!empty($validatedErrors['username']) || !empty($validatedErrors['password'])) {
            return back()
                ->withErrors($validatedErrors)
                ->withInput();
        }

        $user = DB::table('users')
            ->select(['id', 'password_hash'])
            ->where('username', $username)
            ->first();

        if (!$user) {
            return back()
                ->withErrors(['username' => ['Username not found.']])
                ->withInput();
        }

        if (!password_verify($password, $user->password_hash ?? '')) {
            return back()
                ->withErrors(['password' => ['Incorrect password.']])
                ->withInput();
        }

        $request->session()->regenerate();
        Session::put('user_id', $user->id);
        Session::put('username', $username);

        return redirect()->route('builder');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Preserve variable names
        $username = trim($request->input('username', ''));
        $password = (string) $request->input('password', '');

        $errors = [
            'username' => [],
            'password' => [],
        ];

        if ($username === '') {
            $errors['username'][] = 'Enter a username.';
        } elseif (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $username)) {
            $errors['username'][] = 'Username must be 3–30 letters, numbers, or underscore.';
        }

        if ($password === '') {
            $errors['password'][] = 'Enter a password.';
        } elseif (strlen($password) < 6) {
            $errors['password'][] = 'Password must be at least 6 characters.';
        }

        if (!empty($errors['username']) || !empty($errors['password'])) {
            return back()->withErrors($errors)->withInput();
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            DB::table('users')->insert([
                'username' => $username,
                'password_hash' => $hash,
            ]);
        } catch (\Throwable $e) {
            $sqlState = method_exists($e, 'getCode') ? (string) $e->getCode() : '';
            if ($sqlState === '23505' || $sqlState === '23000') { // unique violation (PG / MySQL/SQLite)
                return back()->withErrors(['username' => ['Username already taken.']])->withInput();
            }
            Log::error('Registration error: ' . $e->getMessage());
            return back()->withErrors(['username' => ['Registration failed.']])->withInput();
        }

        return redirect()->route('login', ['registered' => 1]);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::forget(['user_id', 'username']);
        return redirect()->route('login');
    }
}


