{{--引入公共模板--}}
@extends('Layouts.adminIndex')

@section('menu1','active')

@section('itemnav')
<div class="page-header">
    <h1 class="title">
        轮播图
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
                轮播图
            </small>
        </li>
    </ol>
</div>
@endsection

@section('main')
<section class="col-lg-12 widget-drag">
    <a class="label label-info mine-info-show" data-toggle="modal" data-target=".menu-info-show" href="#" title="添加" data-type="add">添加轮播图</a>
    <div class="loop_list">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>图片ID</th>
                    <th>缩略图</th>
                    <th>类别</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $v)
                    <tr>
                        <td>{{$v['id']}}</td>
                        <td>
                            <a class="mine-info-show" data-toggle="modal" data-target=".menu-info-show" href="#" title="查看" data-type="show" data-position={{$v['position']}} data-id={{$v['id']}}>
                                <div class="thumbnail" style="font-size:0;width:80px;height:80px;margin:0 auto;">
                                    <img src="/uploads/{{$v['path']}}" style="display:block;width:100%;height:100%;">
                                </div>
                            </a>
                        </td>
                        @if($v['position'] == 0)
                        <td style="text-align:center;line-height:80px;">顶部轮播图</td>
                        @elseif($v['position'] == 1)
                        <td style="text-align:center;line-height:80px;">底部轮播图</td>
                        @endif
                        <td class="td-status" style="text-align:center;line-height:80px;">
                            <form action="/admin/loop/{{$v['id']}}" method="post" style="display: inline;">
                                {{method_field('DELETE')}}
                                {{csrf_field()}}
                                <input type="hidden" name="_loop_id" value="{{$v['loop_id']}}">
                                <button type="submit" class="label label-danger" data-type="delete" style="border:none;padding:5px 7px;">删除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
            <form action="#" method="post" id="edit-form">
                {{-- {{method_field('PUT')}} --}}
                {{csrf_field()}}
                <div class="modal-body modal-body-loop-add" id="my-modal-info-show">

                </div>
                <div class="modal-footer mine-loop-footer">
                    
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('adminjs')
<script type="text/javascript">
    $('.widget-drag').on('click','a.mine-info-show',function(){
        var type = $(this).attr('data-type'),
            id = $(this).attr('data-id'),
            position = $(this).attr('data-position');
        switch(type)
        {
            case 'add':
                loop_add();
            break;
            case 'show':
                loop_show(id,position);
            break;
        }
    })
    replace();
    $('.modal-at-time').click(function(){
        var last_children = $('.browse_pic_list').children('.browse_pic').eq(-1).children().length;
        if(last_children > 1){
            $('.browse_pic_list').append('<div class="browse_pic">'+
                                            '<input class="browse_pic_add" type="file" name="path[]">'+
                                        '</div>');
        }else{
            alert('请优先添加空的插槽..');
        }
    })
</script>
@endsection