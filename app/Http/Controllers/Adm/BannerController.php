<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;//删除文件
use Illuminate\Support\Facades\DB;
use App\Model\Admin_images;
use App\Model\Banner;

class BannerController extends Controller
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
    protected function clean_path($data)
    {
        $new_data = [];
        foreach($data as $v){
            $path = Admin_images::find($v['image_id'])->toArray();
            if($v['image_id'] == $path['id']){
                $v['image_id'] = $path;
            }
            $new_data[] = $v;
        }
        return $new_data;
    }
    protected function clean_data($data){
        $data = $this->clean_path($data);
        $new_data = [];

        foreach($data as $v){
            $v['image_id']['banner_id'] = $v['banner_id'];
            $v['image_id']['position'] = $v['position'];
            $new_data[] = $v['image_id'];
        }
        return $new_data;
    }
    public function index()
    {
        $data = Banner::get()->toArray();
        //整理信息
        $data = $this->clean_data($data);
        //var_dump($data);
        return view('Adm/Banner/index',compact('data'));
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
    protected function add_banner($path)
    {
        $data = [];
        $data['path'] = $path;
        $data['category'] = '2';
        $data['created_at'] = $data['updated_at'] = $this->timer();
        $id = Admin_images::insertGetId($data);
        return $id;
    }
    public function store(Request $request)
    {
        $success = '恭喜，添加成功！';
        $error = '抱歉，添加失败！';
        $s_url = '/admin/banner';
        $e_url = '/admin/banner';

        $data = $_POST;
        if($request->path == null){
            return redirect($e_url)->with('error', '抱歉,请上传有效图片...');
        }else{
            $path = $request->path->store('banner');
            $data['image_id'] = $this->add_banner($path);
            unset($data['_token']);
            $data['created_at'] = $data['updated_at'] = $this->timer();
            $res = Banner::insert($data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //删除图片表信息
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
        $s_url = '/admin/banner';
        $e_url = '/admin/banner';

        $banner_id = $_POST['_banner_id'];
        //删除banner表信息
        $res_banner = DB::table('banner')->where('banner_id',$banner_id)->delete();
        if($res_banner){
            $res = $this->del_image($id);
            if($res){
                return redirect($s_url)->with('success', $success);
            }else{
                return redirect($e_url)->with('error', $error);
            }
        }else{
            return redirect($e_url)->with('error', $error);
        }
    }
}
