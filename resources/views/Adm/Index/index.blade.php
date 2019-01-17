{{--引入公共模板--}}
@extends('Layouts.adminIndex')

@section('menu1','active')

@section('itemnav')
<div class="page-header">
    <h1 class="title">
        首页
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
                首页
            </small>
        </li>
    </ol>
</div>
@endsection

@section('main')
<section class="page-body">
    <div class="row">
        <div class="fettle login">
            <h1 class="title">
                网站信息
            </h1>
            <div class="index-info">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <th>名称</th>
                        <th>内容</th>
                        <th>操作</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="col-md-3 index-info-logo">LOGO</td>
                            <td class="col-md-5">
                                <div class="thumbnail index-info-thumbnail">
                                    <img src="/uploads/{{$info_pic[0]['info']}}">
                                </div>
                            </td>
                            <td class="col-md-4 index-info-btn">
                                <a class="label label-warning mine-info-show" data-toggle="modal" data-target=".menu-info-show" data-type="pic-edit-logo" data-id="{{$info_pic[0]['id']}}" href="##" title="替换">替换</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-3 index-info-qrcode">二维码</td>
                            <td class="col-md-5">
                                <div class="thumbnail index-info-thumbnail">
                                    <img src="/uploads/{{$info_pic[1]['info']}}">
                                </div>
                            </td>
                            <td class="col-md-4 index-info-btn">
                                <a class="label label-warning mine-info-show" data-toggle="modal" data-target=".menu-info-show" data-type="pic-edit-qrcode" data-id="{{$info_pic[1]['id']}}" href="##" title="替换">替换</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="page-header" style="display:flex;justify-content: space-between;">
                    <h1>公司信息</h1>
                    <a class="label label-info mine-info-show" data-toggle="modal" data-target=".menu-info-show" href="#" title="添加" data-type="add" style="vertical-align:middle;padding-bottom:0;line-height:normal;">添加公司信息</a>
                </div>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <th>名称</th>
                        <th>内容</th>
                        <th>操作</th>
                    </thead>
                    <tbody>
                        @foreach ($company_info as $v)
                        <tr>
                            <td class="col-md-3 index-info-company-title" style="vertical-align: middle;">公司地址&电话</td>
                            <td class="col-md-5 index-info-company-main">
                                <div class="input-group index-info-company">
                                    <span class="input-group-addon">地址</span>
                                    <input type="text" readonly="readonly" value="{{$v['info']}}" class="form-control" aria-label="Amount (to the nearest dollar)">
                                </div>
                                <div class="input-group index-info-company">
                                    <span class="input-group-addon">电话</span>
                                    <input type="text" readonly="readonly" value="{{$v['phone']}}" class="form-control" aria-label="Amount (to the nearest dollar)">
                                </div>
                            </td>
                            <td class="col-md-4 index-info-btn">
                                <a class="label label-warning mine-info-show" data-toggle="modal" data-target=".menu-info-show" href="##" data-type="edit-company" data-address-id="{{$v['id']}}" data-phone-id="{{$v['phone_id']}}" title="修改">修改</a>
                                <form action="/admin/index/del/company" method="post" style="display: inline;">
                                    {{method_field('DELETE')}}
                                    {{csrf_field()}}
                                    <input type="hidden" name="_phone_id" value="{{$v['phone_id']}}">
                                    <button type="submit" class="label label-danger" data-type="delete" style="border:none;padding:5px 7px;">删除</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
{{-- 查看信息模态框 --}}
<div class="modal fade menu-info-show" tabindex="-1" role="dialog">
    <div id="edit-index-info-modal" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"></h4>
                <span class="modal-at-time"></span>
            </div>
            <form action="#" method="post" id="edit-form">
                {{method_field('PUT')}}
                {{csrf_field()}}
                <div class="modal-body" id="my-modal-info-show">
                    
                </div>
                <div class="modal-footer mine-index-info-footer">
                    
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('adminjs')
<script type="text/javascript">
    $('.index-info').on('click','a.mine-info-show',function(){
        var type = $(this).attr('data-type'),
            id = $(this).attr('data-id');
        
        switch(type)
        {
            case 'pic-edit-logo':
                $('#edit-index-info-modal').removeClass('modal-lg modal-xs').addClass('modal-sm');
                pic_edit_logo('/admin/index/info/pic',id,type);
            break;
            case 'pic-edit-qrcode':
                $('#edit-index-info-modal').removeClass('modal-lg modal-xs').addClass('modal-sm');
                pic_edit_qrcode('/admin/index/info/pic',id,type);
            break;
            case 'add':
                $('#edit-index-info-modal').removeClass('modal-sm modal-lg').addClass('modal-xs');
                company_add();
            break;
            case 'edit-company':
                var addressId = $(this).attr('data-address-id'),
                    phoneId = $(this).attr('data-phone-id');
                $('#edit-index-info-modal').removeClass('modal-sm modal-lg').addClass('modal-xs');
                editCompany(addressId,phoneId);
            break;
        }
    })
    replace_pic();
</script>
@endsection