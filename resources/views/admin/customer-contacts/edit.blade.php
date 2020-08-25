@extends('admin.layouts.base')
@php
    use App\Models\CustomerContact;
@endphp

@section('content')
    <div class="main animsition">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">編輯{{ $title }} (主旨: {{ $title_text }}) <span class="text-info pull-right">給客戶 ({{ $customer['name'] ?? '(empty)' }})</span></h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-5">
                                    
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">客服人員 {{ $manager['name'] ?? '(empty)'}} 說:</h3>
                                        </div>
                                        <div class="panel-body">
                                            <textarea style="resize: none; width: 100%; min-height: 90px;" disabled>{{ $content ?? '' }}</textarea>
                                            <p class="text-muted text-right">建立時間 {{ $created_at }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @foreach ($actions ?? [] as $action)
                                @php
                                    $isAdmin = $action['direction'] === CustomerContact::FROM_ADMIN;
                                    $displayName = $isAdmin ? ($action['manager']['name'] ?? '(empty)') : ($action['customer']['name'] ?? '(empty)');
                                @endphp
                                <div class="row">
                                    <div class="col-md-{{ $isAdmin ? '1' : '5' }}"></div>

                                    <div class="col-md-5">
                                        <div class="panel panel-{{ $isAdmin ? 'primary' : 'success' }}">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">{{ $isAdmin ? '客服人員' : '會員客戶' }} {{ $displayName }} 說:</h3>
                                            </div>
                                            <div class="panel-body">
                                                <textarea style="resize: none; width: 100%; min-height: 90px;" disabled>{{ @$action['content'] }}</textarea>
                                                <p class="text-muted text-right">建立時間 {{ @$action['created_at'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">建立新回覆</h3>
                        </div>
                        <div class="panel-body">
                            @include('admin.partials.errors')
                            @include('admin.partials.success')

                            <form action="{{ route('admin.customer-contacts.update', [$id]) }}" method="POST">
                                <div class="form-group">    
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="PUT">

                                    <textarea class="form-control" name="content" id="" cols="30" rows="10"></textarea>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-warning btn-md" onclick="window.history.go(-1); return false;">
                                        <i class="fa fa-sign-in"></i>
                                        返回
                                    </button>
                                    <button class="btn btn-warning btn-md" type="submit">
                                        <i class="fa fa-sign-in"></i>
                                        發送
                                    </button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop