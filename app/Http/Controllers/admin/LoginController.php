<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('admin.index');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $user = User::where([
            'uname' => $request->uname,
            'status' => 'a'
        ])->first();

        $key = "KODLUYORUZ";
        $pass = $key.$request->password;
           
        if (!$user || !Hash::check($pass, $user->password)) {
            return redirect()->route('admin.login-page')->withErrors('notfound', 'Kullanıcı bulunamadı.');
        }

        /* DRY => Dont repeat yourself
        if (!Hash::check($user->password, $request->password)) {
            return redirect()->route('panel.login')->with('error', 'Şifreler uyuşmuyor.');
        }
        */


        Auth::login($user);
        return redirect()->route('admin.index');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login-page');
    }


    public function register()
    {

        if (Auth::check()) {
            return redirect()->route('admin.index');
        }

        return view('admin.register');
    }

    public function registerSave(Request $request)
    {

        $key ="KODLUYORUZ";
        $pass = $key.$request->password;

        $data_ = [
            'fname' => $request->fname,
            'lname' => $request->lname,
            'uname' => $request->uname,
            'email' => $request->email,
            'mpno' => $request->mpno,
            'password' => Hash::make($pass),
            'auth_x' => "|super|"
        ];


        User::create($data_);

        return view('admin.login');
    }
}
