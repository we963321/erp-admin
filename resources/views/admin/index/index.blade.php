@extends('admin.layouts.base')

@section('content')

    <iframe src="/{{env('ADMIN_PREFIX')}}/log-viewer" frameborder="0" style="width: 100%;min-height: 650px;"></iframe>

@endsection


@section('js')

@endsection