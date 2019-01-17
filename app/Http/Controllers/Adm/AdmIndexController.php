<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;//删除文件
use Illuminate\Support\Facades\DB;
use App\Model\Index_info;

class AdmIndexController extends Controller
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
    public function index()
    {
        $info_pic = [];
        $info_pic[] = $logo = Index_info::where('type','0')->get()->toArray()[0];
        $info_pic[] = $qrcode = Index_info::where('type','3')->get()->toArray()[0];

        $company_info = [];
        $address = Index_info::where('type','1')->get()->toArray();
        $phone = Index_info::where('type','2')->get()->toArray();

        foreach($address as $v){
            foreach($phone as $vq){
                if($v['id'] == $vq['p_id']){
                    $v['phone_id'] = $vq['id'];
                    $v['phone_p_id'] = $vq['p_id'];
                    $v['phone'] = $vq['info'];
                }
            }
            $company_info[] = $v;
        }
        //var_dump($company_info);
        return view('Adm/Index/index',compact('info_pic','company_info'));
    }

    public function editpic(Request $request)
    {
        $success = '恭喜，修改成功！';
        $error = '抱歉，修改失败！';
        $s_url = '/admin';
        $e_url = '/admin';
        if($request->path == null){
            return redirect($e_url)->with('error', '抱歉,请上传图片..');
        }

        $id = $_POST['id'];
        $old_pic = Index_info::find($id)->toArray();
        Storage::delete($old_pic['info']);
        $data = [];
        $data['info'] = $request->path->store('indexInfo');
        $data['updated_at'] = $this->timer();
        $res = DB::table('index_info')->where('id',$id)->update($data);
        if($res){
            return redirect($s_url)->with('success', $success);
        }else{
            return redirect($e_url)->with('error', $error);
        }
    }

    //添加公司地址
    protected function addAddress($address)
    {
        $data = [];
        $data['created_at'] = $data['updated_at'] = $this->timer();
        $data['type'] = '1';
        $data['info'] = $address;
        $address_id = Index_info::insertGetId($data);
        return $address_id;
    }
    //添加公司地址
    protected function addPhone($address_id, $phone)
    {
        $data = [];
        $data['created_at'] = $data['updated_at'] = $this->timer();
        $data['type'] = '2';
        $data['info'] = $phone;
        $data['p_id'] = $address_id;
        $res = Index_info::insert($data);
        return $res;
    }

    //添加公司信息
    public function addCompany(Request $request)
    {
        $success = '恭喜，添加成功！';
        $error = '抱歉，添加失败！';
        $s_url = '/admin';
        $e_url = '/admin';
        if($_POST['address'] == '' && $_POST['phone'] == ''){
            return redirect($e_url)->with('error', '抱歉,请填写信息..');
        }elseif($_POST['address'] == ''){
            return redirect($e_url)->with('error', '抱歉,请填写公司地址..');
        }elseif($_POST['phone'] == ''){
            return redirect($e_url)->with('error', '抱歉,请填写公司电话..');
        }elseif(!preg_match_all("/13[123569]{1}\d{8}|15[1235689]\d{8}|188\d{8}/",$_POST['phone'])){
            return redirect($e_url)->with('error', '抱歉,请填写正确电话..');
        }

        $address = $_POST['address'];
        $phone = $_POST['phone'];
        //添加公司地址
        $address_id = $this->addAddress($address);
        //添加公司电话
        $res = $this->addPhone($address_id, $phone);
        if($res){
            return redirect($s_url)->with('success', $success);
        }else{
            return redirect($e_url)->with('error', $error);
        }
    }

    //修改公司信息
    public function editCompany(Request $request)
    {
        $success = '恭喜，修改成功！';
        $error = '抱歉，修改失败！';
        $s_url = '/admin';
        $e_url = '/admin';
        
        if(!preg_match_all("/13[123569]{1}\d{8}|15[1235689]\d{8}|188\d{8}/",$_POST['phone'])){
            return redirect($e_url)->with('error', '抱歉,请填写正确电话..');
        }

        dd($_POST);

        $address_data = $phone_data = [];
        $address_data['updated_at'] = $phone_data['updated_at'] = $this->timer();

        $address_id = $_POST['address_id'];
        $address_data['info'] = $_POST['address'];

        $phone_id = $_POST['phone_id'];
        $phone_data['info'] = $_POST['phone'];

        $res_address = DB::table('index_info')->where('id',$address_id)->update($address_data);
        if($res_address){
            $res = DB::table('index_info')->where('id',$phone_id)->update($phone_data);
            if($res){
                return redirect($s_url)->with('success', $success);
            }else{
                return redirect($e_url)->with('error', $error);
            }
        }else{
            return redirect($e_url)->with('error', $error);
        }
    }

    //删除公司信息方法
    public function delCompany(Request $request)
    {
        $success = '恭喜，删除成功！';
        $error = '抱歉，删除失败！';
        $s_url = '/admin';
        $e_url = '/admin';

        $phone_id = $_POST['_phone_id'];
        $address_id = Index_info::find($phone_id)['p_id'];
        $res_address = DB::table('index_info')->delete($address_id);
        if($res_address){
            $res = DB::table('index_info')->delete($phone_id);
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
