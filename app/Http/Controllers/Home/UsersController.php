<?php

namespace App\Http\Controllers\Home;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>['show','create','store']]);
        $this->middleware('guest',['only'=>['home','create']]);

    }

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

    public function edit(User $user)
    {
        return view('home.users.edit', compact('user'));
    }

    public function update(User $user,Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:50',
            'password'=>'nullable|confirmation|min:6']);

        try{
            $this->authorize('update', $user);
            return view('home.users.edit', compact('user'));

        } catch (\Exception $exception){
            session()->flash('danger','暂无权限');
            return view('comment.401');
        }
        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show',$user->id);
    }

    public function destory()
    {

    }
}
