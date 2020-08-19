@extends('admin.layouts.base')

@section('content')

    <div class="row page-title-row" id="dangqian" style="margin:5px;">
        <div class="col-md-6">
            @if($cid==0)
                <span style="margin:3px;" id="cid" attr="{{$cid}}" class="btn-flat text-info"> 頂級列表</span>
            @else
                <span style="margin:3px;" id="cid" attr="{{$cid}}" class="text-info"> {{$data->display_name}}
                        </span>
                <a style="margin:3px;" href="/{{env('ADMIN_PREFIX')}}/permission"
                   class="btn btn-warning btn-md animation-shake reloadBtn"><i class="fa fa-mail-reply-all"></i> 返回頂級列表
                </a>
            @endif
        </div>

        <div class="col-md-6 text-right">
    @if(Gate::forUser(auth('admin')->user())->check('permission.create'))
        <a href="/{{env('ADMIN_PREFIX')}}/permission/{{$cid}}/create" class="btn btn-success btn-md"><i class="fa fa-plus-circle"></i> 新增權限 </a>
    @endif
</div>
</div>
<div class="row page-title-row" style="margin:5px;">
<div class="col-md-6">
</div>
<div class="col-md-6 text-right">
</div>
</div>

<div class="row">
<div class="col-sm-12">
    <div class="box">
        @include('admin.partials.errors')
        @include('admin.partials.success')
        <div class="box-body">
            <table id="tags-table" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th data-sortable="false" class="hidden-sm"></th>
                    <th class="hidden-sm">權限規則</th>
                    <th class="hidden-sm">權限名稱</th>
                    <th class="hidden-sm">權限概述</th>
                    <th class="hidden-md">權限創建日期</th>
                    <th class="hidden-md">權限修改日期</th>
                    <th data-sortable="false">操作</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div class="modal fade" id="modal-delete" tabIndex="-1">
<div class="modal-dialog modal-warning">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                ×
            </button>
            <h4 class="modal-title">提示</h4>
        </div>
        <div class="modal-body">
            <p class="lead">
                <i class="fa fa-question-circle fa-lg"></i>
                確認要刪除這個權限嗎?
            </p>
        </div>
        <div class="modal-footer">
            <form class="deleteForm" method="POST" action="/{{env('ADMIN_PREFIX')}}/list">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="DELETE">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-times-circle"></i> 確認
                </button>
            </form>
        </div>


    </div>
    @stop

    @section('js')
        <script>
            $(function () {
                var cid = $('#cid').attr('attr');
                var table = $("#tags-table").DataTable({
                    language: {
                        "sProcessing": "處理中...",
                        "sLengthMenu": "顯示 _MENU_ 項結果",
                        "sZeroRecords": "沒有匹配結果",
                        "sInfo": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
                        "sInfoEmpty": "顯示第 0 至 0 項結果，共 0 項",
                        "sInfoFiltered": "(由 _MAX_ 項結果過濾)",
                        "sInfoPostFix": "",
                        "sSearch": "搜索:",
                        "sUrl": "",
                        "sEmptyTable": "表中數據為空",
                        "sLoadingRecords": "載入中...",
                        "sInfoThousands": ",",
                        "oPaginate": {
                            "sFirst": "首頁",
                            "sPrevious": "上頁",
                            "sNext": "下頁",
                            "sLast": "末頁"
                        },
                        "oAria": {
                            "sSortAscending": ": 以升序排列此列",
                            "sSortDescending": ": 以降序排列此列"
                        }
                    },
                    order: [[5, "asc"]],
                    serverSide: true,

                    ajax: {
                        url: '/{{env('ADMIN_PREFIX')}}/permission/index',
                        type: 'POST',
                        data: function (d) {
                            d.cid = cid;
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    },
                    "columns": [
                        {"data": "id"},
                        {"data": "name"},
                        {"data": "label"},
                        {"data": "description"},
                        {"data": "created_at"},
                        {"data": "updated_at"},
                        {"data": "action"}
                    ],
                    columnDefs: [
                        {
                            'targets': -1, "render": function (data, type, row) {
                            var row_edit = {{Gate::forUser(auth('admin')->user())->check('permission.edit') ? 1 : 0}};
                            var row_delete = {{Gate::forUser(auth('admin')->user())->check('permission.destroy') ? 1 :0}};
                            var str = '';

                            //下級列表
                            if (cid == 0) {
                                str += '<a style="margin:3px;"  href="/{{env('ADMIN_PREFIX')}}/permission/' + row['id'] + '" class="X-Small btn-xs text-success "><i class="fa fa-adn"></i>下級列表</a>';
                            }

                            //編輯
                            if (row_edit) {
                                str += '<a style="margin:3px;" href="/{{env('ADMIN_PREFIX')}}/permission/' + row['id'] + '/edit" class="X-Small btn-xs text-success "><i class="fa fa-edit"></i> 編輯</a>';
                            }

                            //刪除
                            if (row_delete) {
                                str += '<a style="margin:3px;" href="#" attr="' + row['id'] + '" class="delBtn X-Small btn-xs text-danger"><i class="fa fa-times-circle"></i> 刪除</a>';
                            }

                            return str;

                        }
                        }
                    ]
                });

                table.on('preXhr.dt', function () {
                    loadShow();
                });

                table.on('draw.dt', function () {
                    loadFadeOut();
                });

                table.on('order.dt search.dt', function () {
                    table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }).draw();

                $("table").delegate('.delBtn', 'click', function () {
                    var id = $(this).attr('attr');
                    $('.deleteForm').attr('action', '/{{env('ADMIN_PREFIX')}}/permission/' + id);
                    $("#modal-delete").modal();
                });

            });
        </script>
@stop