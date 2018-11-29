<?php

namespace App\Http\Controllers\Home;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionController extends Controller
{
    //

    public function create()
    {
        return view('home.session.create');
    }

    public function store(Request $request)
    {
        $validate = $this->validate($request,[
            'email'=>'required|email|max:255',
            'password'=>'required|min:6']);

        if (Auth::attempt($validate,$request->has('remember'))) {
            session()->flash('success','登录成功');
            return redirect()->route('home');

        } else {
            session()->flash('danger','登录失败，账号或密码不正确');
            return redirect()->route('login')->withInput();

        }
    }

    public function logout()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
