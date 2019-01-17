{{--引入公共模板--}}
@extends('Layouts.adminIndex')

@section('menu6','active')

@section('itemnav')
<div class="page-header">
    <h1 class="title">
        创业学院
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
                创业学院
            </small>
        </li>
    </ol>
</div>
@endsection

@section('main')
<section class="page-body">
    <div class="row">
        <h1>创业学院</h1>
    </div>
</section>
@endsection