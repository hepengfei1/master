<?php

namespace App\Http\Controllers\Home;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{


    public function index()
    {
        return view('home.users.index');
    }

    public function signup()
    {
        return view('home.users.signup');
    }
    public function create()
    {
        return view('home.users.create');
    }

    public function show(User $user)
    {
        return view('home.users.add_and_edit',compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:50',
            'email'=>'required|email|unique:users|max:255',
            'password'=>'required|confirmed|min:6']);


        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success','添加成功');
        return redirect()->route('users.show',[$user]);
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destory()
    {

    }
}
