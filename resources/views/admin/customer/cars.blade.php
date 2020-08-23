@extends('admin.layouts.base')

@section('content')
    <div class="main animsition">
        <div class="container-fluid">

            <div class="row">
                <div class="">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">編輯客戶車輛資料({{ $customer->name }})</h3>
                        </div>
                        <div class="panel-body">
                            @include('admin.partials.errors')
                            @include('admin.partials.success')
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.customer.cars.update', [$customer->id]) }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="PUT">
                                
                                @include('admin.customer._cars_form')
                                <div class="form-group">
                                    <div class="col-md-7 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-plus-circle"></i>
                                            儲存
                                        </button>
                                        <button class="btn btn-primary btn-md" onclick="window.history.go(-1); return false;">
                                            <i class="fa fa-sign-in"></i>
                                            返回
                                        </button>
                                    </div>
                                </div>
                            </form>
                            @include('admin.customer._cars_template')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@stop
