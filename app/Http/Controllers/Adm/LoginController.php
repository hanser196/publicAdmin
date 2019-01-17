<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin_user;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Layouts/login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //退出登录
        $request->session()->forget('admin_id');
        $request->session()->forget('admin_name');
        $request->session()->forget('admin_head_img');
        $request->session()->forget('admin_password');
        echo "<script>alert('退出成功!下次再见!!');window.location.href='/admin/login'</script>";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $username=$request->user_name;
        $password=$request->password;
        
        //判断用户名是否存在
        $u_name=Admin_user::where('user_name','=',$username)->get()->toArray();
        //判断用户名是否正确
        if(!$u_name){
            return redirect('/admin/login')->with('error', '抱歉,用户名不存在！');
        }
        //判断密码是否正确
        if($u_name[0]['password']!=$password){
            return redirect('/admin/login')->with('error', '抱歉,密码不正确！');
        }
        //保存session
        $request->session()->put(['admin_id'=>$u_name[0]['id'],'admin_name'=>$u_name[0]['name'],'admin_head_img'=>$u_name[0]['head_img'],'admin_password'=>$u_name[0]['password']]);
        return redirect('/admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
