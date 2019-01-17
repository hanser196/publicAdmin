<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\Admin_images;
use App\Model\Admin_text;
use App\Model\News;
use App\Model\Index_info;

class AjaxController extends Controller
{
    //通过构造函数定义header头
    public function __construct()
    {
        header('content-type:application:json;charset=utf8');
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        header("Cache-Control: no-cache, must-revalidate");
    }

    //查询数据方法
    protected function sel($id)
    {
        $res = [];
        $news = DB::table('news')
                    ->join('admin_text', 'news.text_id', '=', 'admin_text.id')
                    ->join('admin_images', 'news.image_id', '=', 'admin_images.id')
                    ->get();
        foreach($news as $v){
            if($v->news_id == $id){
                $res[] = $v;
            }
        }
        return $res;
    }

    //返回首页信息(公司地址及电话)方法
    public function company(Request $request)
    {
        $data = [];
        $data['address_id'] = $address_id = $request['address_id'];
        $data['phone_id'] = $phone_id = $request['phone_id'];
        $data['address'] = Index_info::find($address_id)['info'];
        $data['phone'] = Index_info::find($phone_id)['info'];

        return $data;
    }

    //返回新闻方法
    public function news(Request $request)
    {
        $id = $request['id'];
        $res = $this->sel($id);
        return $res;
    }

    //返回轮播图方法
    public function loop(Request $request)
    {
        $id = $request['id'];
        $res = Admin_images::find($id);
        return $res;
    }

    //返回banner图方法
    public function banner(Request $request)
    {
        $id = $request['id'];
        $res = Admin_images::find($id);
        return $res;
    }
}
