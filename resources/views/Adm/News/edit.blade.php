{{--引入公共模板--}}
@extends('Layouts.adminIndex')

@section('menu3','active')

@section('itemnav')
<div class="page-header">
    <h1 class="title">
        修改文章
        <small>控制面板</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}" title="家">
                <i class="iconfont icon-home"></i>
                <small>家</small>
            </a>
        </li>
        <li class="active">
            <small>
                修改文章
            </small>
        </li>
    </ol>
</div>
@endsection

@section('main')
<section class="col-lg-12 widget-drag">
    <form action="/admin/news/{{$data->news_id}}" method="post" enctype="multipart/form-data">
        {{ method_field('PUT') }}
        {{csrf_field()}}
        <input type="hidden" name="news_id" value="{{$data->news_id}}">
        <div class="box" style="display:flex;">
            <div class="form-group" style="width:33%;margin-bottom:0;padding-right:5%;">
                <label for="edit_title">文章标题</label>
                <input type="text" class="form-control" id="edit_title" name="title" value="{{$data->title}}">
            </div>
            <div class="form-group" style="width:33%;margin-bottom:0;padding-right:5%;">
                <label for="edit_head_img">文章导图</label>
                <input type="file" name="head_img" id="edit_head_img">
                <p class="help-block">请上传宽度小于XX,高度小于XX的图片.</p>
            </div>
            <div class="form-group" style="width:33%;margin-bottom:0;">
                <label for="add_type">文章分类</label>
                <select class="form-control" name="type" id="add_type">
                    @if($data->type == 0)
                    <option value="0" selected = "selected">文章分类1</option>
                    <option value="1">文章分类2</option>
                    @elseif($data->type == 1)
                    <option value="0">文章分类1</option>
                    <option value="1" selected = "selected">文章分类2</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="edit_introduce">文章简介</label>
            <textarea class="form-control" id="edit_introduce" name="introduce" rows="2">{!! $data->introduce !!}</textarea>
        </div>
        <div class="form-group">
            <label for="edit_content">文章内容</label>
            <textarea id="edit_content" name="content" style="width:100%;height:500px;position: relative; z-index: 100">{!! $data->content !!}</textarea>
        </div>
        <button type="submit" class="btn btn-default">提交</button>
        <button type="button" class="btn btn-primary" onclick="javascript:history.back(-1);">返回</button>
    </form>
</section>
@endsection

@section('adminjs')
<script type="text/javascript" charset="utf-8" src="/adm/uedit/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/adm/uedit/ueditor.all.min.js"></script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="/adm/uedit/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    var edit_txt = UE.getEditor('edit_content');
</script>
@endsection