<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthController extends Controller
{
    //
    public function signin_show(){
        return view('signin');
    }

    public function signup_show(){
        return view('signup');
    }
    public function signup(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => [
                'required',
                'regex:/^\+7\d{10}$/',
                'unique:users,phone_number'
            ],
            'password' => 'required|string|min:6',
        ], [
            'full_name.required' => 'Пожалуйста, укажите ваше ФИО',
            'full_name.max' => 'ФИО не может быть длиннее 255 символов',
            'email.required' => 'Пожалуйста, укажите email',
            'email.email' => 'Пожалуйста, укажите корректный email адрес',
            'email.unique' => 'Пользователь с таким email уже существует',
            'phone_number.required' => 'Пожалуйста, укажите номер телефона',
            'phone_number.regex' => 'Номер телефона должен быть в формате +7XXXXXXXXXX',
            'phone_number.unique' => 'Пользователь с таким номером телефона уже существует',
            'password.required' => 'Пожалуйста, укажите пароль',
            'password.min' => 'Пароль должен содержать минимум 6 символов',
        ]);

       
            $user = User::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('signin')
                           ->with('success', 'Вы успешно зарегистрировались!');
        
    }
    public function signin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Пожалуйста, укажите email',
            'email.email' => 'Пожалуйста, укажите корректный email адрес',
            'password.required' => 'Пожалуйста, укажите пароль'
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            // Получаем текущего пользователя и его роль
            $user = Auth::user();
            if ($user->role === 'admin') {
                // Если роль пользователя admin, перенаправляем на страницу администратора
                return redirect()->route('adminIndex')
                                 ->with('success', 'Вы успешно вошли как администратор!');
            }else {
                // Перенаправление по умолчанию для других ролей
                return redirect()->route('home')
                                 ->with('success', 'Вы успешно вошли в систему!');
            }
        }
    
        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'auth' => 'Неверный email или пароль.'
            ]);
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('index')
        ->with('success', 'Вы успешно вышли из системы');
}
}
