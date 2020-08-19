@extends('admin.layouts.base')

@php
$controllerName = 'Admin\\CountiesController';
$resourceName = 'counties';
@endphp

@section('content')
    <div class="main animsition">
        <div class="container-fluid">
            <div class="row">
                <div class="">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">編輯縣市</h3>
                        </div>
                        <div class="panel-body">
                            
                            @include('admin.partials.errors')
                            @include('admin.partials.success')
                            <form class="form-horizontal" role="form" method="POST"
                                  action="{{ action($controllerName . '@update', ['id' => $id]) }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="id" value="{{ $id }}">
                                @include('admin.' . $resourceName . '._form')
                                <div class="form-group">
                                    <div class="col-md-7 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-plus-circle"></i>
                                            保存
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