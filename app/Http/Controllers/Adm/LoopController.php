<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;//删除文件
use Illuminate\Support\Facades\DB;
use App\Model\Admin_images;
use App\Model\Loop;

class LoopController extends Controller
{
    /*中间件认证*/
    public function __construct()
    {
        //如果在构造方法中进行中间件验证，则采用如下方式，会限制所有的方法都必须通过中间件
        $this->middleware('admin_id');
    }
    protected function timer()
    {
        return date('Y-m-d H:i:s');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function clean_loop($data)
    {
        $new_data = [];
        foreach($data as $v){
            //var_dump($v);
            $image_id = $v['image_id'];
            //字符串转换数组
            $v['image_id'] = explode(',',$image_id);
            $new_data[] = $v;
        }
        return $new_data;
    }
    protected function clean_path($data)
    {
        $new_data = [];
        //把字符串拆开
        $data = $this->clean_loop($data);
        
        foreach($data as $v){
            foreach($v['image_id'] as $kq=>$vq){
                $path = Admin_images::find($vq)->toArray();
                if($v['image_id'][$kq] == $path['id']){
                    $v['image_id'][$kq] = $path;
                }
            }
            $new_data[] = $v;
        }
        return $new_data;
    }
    protected function clean_data($data)
    {
        $new_data = [];
        //找到对应的图片路径
        $data = $this->clean_path($data);
        
        foreach($data as $v){
            $loop_id = $v['loop_id'];
            $position = $v['position'];
            //var_dump($loop_id,$position);
            foreach($v['image_id'] as $vq){
                $vq['loop_id'] = $loop_id;
                $vq['position'] = $position;
                $new_data[] = $vq;
            }
        }
        return $new_data;
    }
    public function index()
    {
        //$data = Admin_images::where('category','0')->get()->toArray();
        $data = Loop::get()->toArray();
        //整理数据
        $data = $this->clean_data($data);
        //var_dump($data);
        return view('Adm/Loop/index',compact('data'));
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
    protected function uploop($data)
    {
        //存放返回id的数组
        $loop_id = [];
        //存放提交数据信息
        $loop = [];
        foreach($data as $v){
            $path = $v->store('loop');
            $loop['path'] = $path;
            $loop['category'] = '0';
            $loop['created_at'] = $loop['updated_at'] = $this->timer();
            $loop_id[] = Admin_images::insertGetId($loop);
        }
        $id = implode(',',$loop_id);
        return $id;
    }
    public function store(Request $request)
    {
        $success = '恭喜，添加成功！';
        $error = '抱歉，添加失败！';
        $s_url = '/admin/loop';
        $e_url = '/admin/loop';

        $data = $_POST;
        $path_arr = $request->path;
        if(!$path_arr[0]){
            return redirect($e_url)->with('error', '抱歉,请上传有效图片...');
        }
        foreach($path_arr as $k=>$v){
            if(!$v){
                unset($path_arr[$k]);
            }
        }
        //上传图片返回id数组
        $loop_id = $this->uploop($path_arr);
        $loop['image_id'] = $loop_id;
        $loop['position'] = $data['position'];
        $loop['created_at'] = $loop['updated_at'] = $this->timer();
        $res = Loop::insert($loop);
        if($res){
            return redirect($s_url)->with('success', $success);
        }else{
            return redirect($e_url)->with('error', $error);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function lookup_loop($id)
    {
        $loop_data = Loop::where('loop_id',$id)->get()->toArray()[0];
        $image_id = $loop_data['image_id'];
        return $image_id;
    }
    //拆分image_id
    protected function split_image_id($loop_id,$id)
    {
        //找到对应轮播图表的信息
        $image_id = $this->lookup_loop($loop_id);
        //拆分字符串
        $image_id_arr = explode(',',$image_id);
        foreach($image_id_arr as $k=>$v){
            if($v == $id){
                unset($image_id_arr[$k]);
            }
        }
        if(count($image_id_arr) > 0){
            $s_image_id = implode(',',$image_id_arr);
            return $s_image_id;
        }else{
            return '0';
        }
    }
    //重新保存方法
    protected function again_save($loop_id, $s_image_id)
    {
        $data['updated_at'] = $this->timer();
        $data['image_id'] = $s_image_id;
        $res = DB::table('loop')->where('loop_id',$loop_id)->update($data);
        return $res;
    }

    //删除当前轮播图表方法
    protected function del_save($loop_id)
    {
        $res = DB::table('loop')->where('loop_id',$loop_id)->delete();
        return $res;
    }

    //删除图片表信息及图片
    protected function del_image($id)
    {
        $data = Admin_images::where('id',$id)->first()->toArray();
        $path = $data['path'];
        Storage::delete($path);
        $res = DB::table('admin_images')->delete($id);
        return $res;
    }

    public function destroy($id)
    {
        $success = '恭喜，删除成功！';
        $error = '抱歉，删除失败！';
        $s_url = '/admin/loop';
        $e_url = '/admin/loop';

        $loop_id = $_POST['_loop_id'];
        //拆分image_id
        $s_image_id = $this->split_image_id($loop_id,$id);
        if($s_image_id > 0 ){
            $res = $this->again_save($loop_id, $s_image_id);
        }else{
            $res = $this->del_save($loop_id);
        }
        if($res){
            //执行函数图片表信息及保存的图片
            $res_image = $this->del_image($id);
            if($res_image){
                return redirect($s_url)->with('success', $success);
            }else{
                return redirect($e_url)->with('error', $error);
            }
        }else{
            return redirect($e_url)->with('error', $error);
        }
    }
}
