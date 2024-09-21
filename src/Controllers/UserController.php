<?php

namespace App\Controllers;

use App\Models\User;
use App\Helpers\Response;

class UserController
{
    // تسجيل الدخول
    public function login($request)
    {
        $email = $request['email'];
        $password = $request['password'];

        $user = User::where('email', $email)->first();

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user'] = $user;
            return Response::json(['success' => true, 'message' => 'Logged in successfully']);
        }

        return Response::json(['success' => false, 'message' => 'Invalid credentials'], 401);
    }

    // تسجيل الخروج
    public function logout()
    {
        session_destroy();
        return Response::redirect('login.php');
    }

    // عرض جميع المستخدمين (خاص بـ Admin)
    public function index()
    {
        $users = User::all();
        return Response::view('users/index', compact('users'));
    }
}
