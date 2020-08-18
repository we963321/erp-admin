@extends('admin.layouts.base')

@section('content')
    <div class="main animsition">
        <div class="container-fluid">
            <div class="row">
                <div class="">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">新增車輛品牌</h3>
                        </div>
                        <div class="panel-body">
                            @include('admin.partials.errors')
                            @include('admin.partials.success')
                            <form class="form-horizontal" role="form" method="POST" action="{{ action('Admin\\VehicleBrandController@store')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                @include('admin.customer-category._form')
                                <div class="form-group">
                                    <div class="col-md-7 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-plus-circle"></i>
                                            新增
                                        </button>
                                        <button class="btn btn-primary btn-md" onclick="window.history.go(-1); return false;">
                                            <i class="fa fa-sign-in"></i>
                                            返回
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop