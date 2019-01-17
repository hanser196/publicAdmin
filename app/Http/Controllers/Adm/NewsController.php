<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;//删除文件
use Illuminate\Support\Facades\DB;
use App\Model\Admin_images;
use App\Model\Admin_text;
use App\Model\News;

class NewsController extends Controller
{
    // 利用构造函数定义header头
    public function __construct()
    {
        //如果在构造方法中进行中间件验证，则采用如下方式，会限制所有的方法都必须通过中间件
        $this->middleware('admin_id');
    }
    protected function timer()
    {
        $time = date('Y-m-d H:i:s');
        return $time;
    }
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = DB::table('news')
                    ->join('admin_text','news.text_id', '=', 'admin_text.id')
                    ->get()->toArray();
        return view('Adm/News/index', compact('news'));
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
    protected function text($data)
    {
        $text = [];
        $text['category'] = '0';
        $text['title'] = $data['title'];
        $text['introduce'] = $data['introduce'];
        $text['content'] = $data['content'];
        $text['updated_at'] = $text['created_at'] = $this->timer();
        var_dump($text);
        $text_id = Admin_text::insertGetId($text);
        return $text_id;
    }
    protected function image($data)
    {
        $image = [];
        $image['category'] = '1';
        $image['path'] = $data['path'];
        $image['updated_at'] = $image['created_at'] = $this->timer();
        //向数据库中添加信息并返回ID值
        $image_id = Admin_images::insertGetId($image);
        return $image_id;
    }
    public function store(Request $request)
    {
        $success = '恭喜，添加成功！';
        $error = '抱歉，添加失败！';
        $s_url = '/admin/news';
        $e_url = '/admin/news';

        if($_POST['title'] == ''){
            return redirect($e_url)->with('error', '抱歉,请填写文章标题..');
        }elseif($_POST['introduce'] == ''){
            return redirect($e_url)->with('error', '抱歉,请填写文章简介..');
        }elseif($_POST['content'] == ''){
            return redirect($e_url)->with('error', '抱歉,请填写文章内容..');
        }elseif($request->head_img == null){
            return redirect($e_url)->with('error', '抱歉,请上传文章导图..');
        }

        $data = $_POST;
        unset($data['_token']);
        $path = $request->head_img->store('news');
        $data['path'] = $path;
        $data['image_id'] = $this->image($data);
        $data['text_id'] = $this->text($data);
        unset($data['path']);
        unset($data['title']);
        unset($data['introduce']);
        unset($data['content']);
        $data['updated_at'] = $data['created_at'] = $this->timer();
        $res = News::insert($data);
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->sel($id)[0];
        return view('Adm/News/edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //获取原导图id
    protected function old_image_id($id)
    {
        $news = News::where('news_id',$id)->first()->toArray();
        $image_id = $news['image_id'];
        return $image_id;
    }
    //获取原文id
    protected function old_content_id($id)
    {
        $news = News::where('news_id',$id)->first()->toArray();
        $text_id = $news['text_id'];
        return $text_id;
    }
    //获取原文内容
    protected function old_content($id)
    {
        $text_id = $this->old_content_id($id);
        //通过$text_id找到原文内容
        $content = Admin_text::find($text_id)->toArray()['content'];
        //返回原文内容
        return $content;
    }
    //删除原文图片
    protected function del_old_content($content)
    {
        preg_match_all('/<img src="\/Uploads\/(.*?)" title=".*?" alt=".*?" width=".*?" height=".*?"\/>/',$content,$res1);
        $img=$res1[1];
        $lenght=sizeof($img);
        for($i=0;$i<$lenght;$i++){
            $pic=$res1[1][$i];
            var_dump($pic);
            Storage::delete($pic);
        }
    }
    //提交修改文章内容
    protected function updata_text($data)
    {
        //获取原文id
        $text_id = $this->old_content_id($data['news_id']);
        $data['category'] = '0';
        unset($data['news_id']);
        unset($data['type']);
        //提交修改
        $res = DB::table('admin_text')->where('id',$text_id)->update($data);
        return $res;
    }
    //修改文章导图
    protected function updata_image($id)
    {
        $image_id = $this->old_image_id($id);
        $image = Admin_images::where('id',$image_id)->first()->toArray();
        $old_path = $image['path'];
        Storage::delete($old_path);
    }
    public function update(Request $request, $id)
    {
        $success = '恭喜，修改成功！';
        $error = '抱歉，修改失败！';
        $s_url = '/admin/news';
        $e_url = '/admin/news';

        $data = $_POST;
        if(!$request->head_img){
            unset($data['head_img']);
            $r_image = true;
        }else{
            //修改文章导图
            $this->updata_image($data['news_id']);
            $path = $request->head_img->store('news');
            $path_data['path'] = $path;
            $path_data['updated_at'] = $this->timer();
            $image_id = $this->old_image_id($data['news_id']);
            $r_image = DB::table('admin_images')->where('id',$image_id)->update($path_data);
        }
        unset($data['_method']);
        unset($data['_token']);
        $data['updated_at'] = $this->timer();
        //获取原文内容
        $content = $this->old_content($data['news_id']);
        //删除原文图片
        $this->del_old_content($content);
        //提交修改文章内容
        $r_text = $this->updata_text($data);
        $news_id = $data['news_id'];
        unset($data['news_id']);
        unset($data['title']);
        unset($data['introduce']);
        unset($data['content']);
        if($r_text && $r_image){
            $res = DB::table('news')->where('news_id',$news_id)->update($data);
            if($res){
                return redirect($s_url)->with('success', $success);
            }else{
                return redirect($e_url)->with('error', $error);    
            }
        }else{
            return redirect($e_url)->with('error', $error);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function del_image($id)
    {
        $data = Admin_images::where('id',$id)->first()->toArray();
        $path = $data['path'];
        // var_dump($path);
        Storage::delete($path);
        $res = DB::table('admin_images')->delete($id);
        return $res;
    }
    protected function del_text($id)
    {
        $data = Admin_text::where('id',$id)->first()->toArray();
        $content = $data['content'];
        //var_dump($content);
        preg_match_all('/<img src="\/Uploads\/(.*?)" title=".*?" alt=".*?" width=".*?" height=".*?"\/>/',$content,$res1);
        $img=$res1[1];
        $lenght=sizeof($img);
        for($i=0;$i<$lenght;$i++){
            $pic=$res1[1][$i];
            // var_dump($pic);
            Storage::delete($pic);
        }
        $res = DB::table('admin_text')->delete($id);
        var_dump($res);
        return $res;
    }
    public function destroy($id)
    {
        $success = '恭喜，删除成功！';
        $error = '抱歉，删除失败！';
        $s_url = '/admin/news';
        $e_url = '/admin/news';

        $news = News::where('news_id',$id)->first()->toArray();
        $image_id = $news['image_id'];
        $text_id = $news['text_id'];
        $r_image = $this->del_image($image_id);
        $r_text = $this->del_text($text_id);
        if($r_image && $r_text){
            $res = DB::table('news')->where('news_id',$id)->delete();
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
