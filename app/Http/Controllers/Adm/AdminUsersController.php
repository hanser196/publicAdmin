<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;//删除文件
use Illuminate\Support\Facades\DB;
use App\Model\Admin_user;

class AdminUsersController extends Controller
{
    /*中间件认证*/
    public function __construct()
    {
        //如果在构造方法中进行中间件验证，则采用如下方式，会限制所有的方法都必须通过中间件
        $this->middleware('admin_id');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function setdata($data)
    {
        unset($data['_token']);
        unset($data['agen_password']);
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
        return $data;
    }
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $success = '恭喜，添加成功！';
        $error = '抱歉，添加失败！';
        $s_url = '/admin';
        $e_url = '/admin';
        if($_POST['name'] == ''){
            return redirect($e_url)->with('error', '抱歉,请填写昵称..');
        }elseif($_POST['user_name'] == ''){
            return redirect($e_url)->with('error', '抱歉,请填写管理员账号..');
        }elseif($_POST['password'] == ''){
            return redirect($e_url)->with('error', '抱歉,请填写密码..');
        }elseif($_POST['agen_password'] != $_POST['password']){
            return redirect($e_url)->with('error', '抱歉,请确认密码是否一致..');
        }elseif($request->head_img == null){
            return redirect($e_url)->with('error', '抱歉,请上传管理员头像..');
        }

        dd($_POST);
        
        $res = $_POST;
        $user_name = Admin_user::where('user_name',$res['user_name'])->get()->toArray();
        if($user_name){
            return redirect($e_url)->with('error', '抱歉,管理员账号已存在!');
        }else{
            $data = $this->setdata($res);
            $path = $request->head_img->store('admin_user');
            $data['head_img'] = $path;
            $res = Admin_user::insert($data);
            if($res){
                return redirect($s_url)->with('success', $success);
            }else{
                return redirect($e_url)->with('error', $error);
            }
        }
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
        if($_POST['news-password'] == ''){
            return redirect('/admin')->with('error', '抱歉,请填写新密码..');
        }elseif($_POST['agen-password'] == ''){
            return redirect('/admin')->with('error', '抱歉,请再次填写密码..');
        }elseif($_POST['agen-password'] != $_POST['news-password']){
            return redirect('/admin')->with('error', '抱歉,两次填写密码不一致..');
        }

        $data = $_POST;
        $data['updated_at']=date('Y-m-d H:i:s');
        $data['password'] = $data['news-password'];
        unset($data['_method']);
        unset($data['_token']);
        unset($data['agen-password']);
        unset($data['news-password']);
        $res = DB::table('admin_user')->where('id',$id)->update($data);
        //判断
        if($res){
            $request->session()->forget('admin_password');
            $request->session()->put(['admin_password'=>$data['password']]);
            return redirect('/admin')->with('success', '恭喜,修改成功！');
        }else{
            return redirect('/admin')->with('error', '抱歉,修改失败！');
        }
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
