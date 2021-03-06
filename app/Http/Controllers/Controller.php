<?php

namespace HoursLoad\Http\Controllers;

use HoursLoad\Professors;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use HoursLoad\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function login(Request $request){
        return view('auth/login');
    }

    public function authenticate(Request $request) {

        if (Auth::attempt(['email' =>$request->get('email'), 'password' => $request->get('password')])) {
            return redirect()->intended('prof/'.  Auth::user()->role);
        } else {
            return redirect()->back()->withInput()->with('message', 'Ошибка входа! Возможно email и/или пароль не верны');
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('auth/login');
    }

    public function resetPage(){
        return view('resetpass',
            array('page' => 'resetpass'));
    }

    public function updatePass(Request $request){
        $oldPass = $request->cur_password;
        $newPass = $request->new_password;
        $user = Auth::user();
        if(!Hash::check($oldPass, $user->password))
            return redirect('resetpass')->with('error', 'Это не ваш пароль');
        else {
            User::changePass($user->idUser,Hash::make($newPass) );
            return redirect('profile/'.Professors::getIdProfByFKUser(Auth::user()->idUser))->with('save', 'Пароль успешно изменён');

        }
    }

}
