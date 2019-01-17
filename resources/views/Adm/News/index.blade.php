{{--引入公共模板--}}
@extends('Layouts.adminIndex')

@section('menu3','active')

@section('itemnav')
<div class="page-header">
    <h1 class="title">
        新闻动态
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
                新闻动态
            </small>
        </li>
    </ol>
</div>
@endsection

@section('main')
<section class="col-lg-12 widget-drag">
    <ul id="myTab" class="nav nav-tabs">
        <li class="active">
            <a href="#news-list" data-toggle="tab" aria-expanded="true">文章列表</a>
        </li>
        <li>
            <a href="#news-add" data-toggle="tab" aria-expanded="false">添加文章</a>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="news-list">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>文章ID</th>
                        <th>文章标题</th>
                        <th>文章分类</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($news as $v)
                        <tr>
                            <td>{{$v->news_id}}</td>
                            <td>{{$v->title}}</td>
                            @if($v->type == 0)
                            <td>文章分类1</td>
                            @elseif($v->type == 1)
                            <td>文章分类2</td>
                            @endif
                            <td class="td-status">
                                <a class="label label-info mine-info-show" data-toggle="modal" data-target=".menu-info-show" href="#" title="查看" data-type="show" data-id={{$v->news_id}}>查看</a>
                                <a class="label label-warning" href="/admin/news/{{$v->news_id}}/edit" title="修改">修改</a>
                                <form action="/admin/news/{{$v->news_id}}" method="post" style="display: inline;">
                                    {{method_field('DELETE')}}
                                    {{csrf_field()}}
                                    <button type="submit" class="label label-danger" data-type="delete" style="border:none;padding:5px 7px;">删除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="news-add">
            <form action="/admin/news" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="box" style="display:flex;">
                    <div class="form-group" style="width:33%;margin-bottom:0;padding-right:5%;">
                        <label for="add_title">文章标题</label>
                        <input type="text" class="form-control" name="title" id="add_title" placeholder="文章标题">
                    </div>
                    <div class="form-group" style="width:33%;margin-bottom:0;padding-right:5%;">
                        <label for="add_head_img">文章导图</label>
                        <input type="file" name="head_img" id="add_head_img">
                        <p class="help-block">请上传宽度小于XX,高度小于XX的图片.</p>
                    </div>
                    <div class="form-group" style="width:33%;margin-bottom:0;">
                        <label for="add_type">文章分类</label>
                        <select class="form-control" name="type" id="add_type">
                            <option value="0">文章分类1</option>
                            <option value="1">文章分类2</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="add_introduce">文章简介</label>
                    <textarea class="form-control" id="add_introduce" name="introduce" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="add_content">文章内容</label>
                    <textarea id="add_content" name="content" style="width:100%;height:450px;position: relative; z-index: 100"></textarea>
                </div>
                <button type="submit" class="btn btn-default">提交</button>
            </form>
        </div>
    </div>
</section>
{{-- 查看信息模态框 --}}
<div class="modal fade menu-info-show" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"></h4>
                <span class="modal-at-time"></span>
            </div>
            <div class="modal-body" id="my-modal-info-show">
                
            </div>
            <div class="modal-footer">
                <h3 class="modal-footer-title"><span class="label label-default">导图 & 简介</span></h3>
                <div class="modal-footer-content">
                    <div class="modal-footer-content-thumbnail thumbnail">
                        
                    </div>
                    <div class="modal-footer-content-introduction">
                        <textarea class="form-control" rows="8"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('adminjs')
<script type="text/javascript" charset="utf-8" src="/adm/uedit/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/adm/uedit/ueditor.all.min.js"></script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="/adm/uedit/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    var add_txt = UE.getEditor('add_content');

    $('.widget-drag').on('click','.mine-info-show',function(){
        var type = $(this).attr('data-type'),
            id = $(this).attr('data-id');
        switch(type)
        {
            case 'show':
                showinfo(id);
            break;
        }
    })
</script>
@endsection