@extends('admin.layouts.base')

@section('content')

    <div class="row page-title-row" style="margin:5px;">
        <div class="col-md-6">
        </div>
        <div class="col-md-6 text-right">
            @if(Gate::forUser(auth('admin')->user())->check('admin.store.create'))
                <a href="/admin/store/create" class="btn btn-success btn-md">
                    <i class="fa fa-plus-circle"></i> 新增店別
                </a>
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
        <div class="col-xs-12">
            <div class="box">

                @include('admin.partials.errors')
                @include('admin.partials.success')
                <div class="box-body">
                    <table id="tags-table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th data-sortable="false" class="hidden-sm">編號</th>
                            <th data-sortable="false">管理員 / 員工編號 / 電話</th>
                            <th class="hidden-sm">分店簡稱</th>
                            <th class="hidden-md">分店名稱</th>
                            <th class="hidden-md">分店電話</th>
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
        <div class="modal-dialog">
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
                        確認要刪除這個店別嗎?
                    </p>
                </div>
                <div class="modal-footer">
                    <form class="deleteForm" method="POST" action="/admin/store">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-times-circle"></i>確認
                        </button>
                    </form>
                </div>

            </div>
            @stop

            @section('js')
                <script>
                    $(function () {
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
                            order: [[0, "asc"]],
                            serverSide: true,
                            ajax: {
                                url: '/admin/store/index',
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                }
                            },
                            "columns": [
                                {"data": "id"},
                                {"data": "admin_user_id"},
                                {"data": "short_name"},
                                {"data": "name"},
                                {"data": "mobile"},
                                {"data": "action"},
                            ],
                            columnDefs: [
                                {
                                    'targets': -1, 
                                    "render": function (data, type, row) {
                                        var row_edit = {{Gate::forUser(auth('admin')->user())->check('admin.store.edit') ? 1 : 0}};
                                        var row_delete = {{Gate::forUser(auth('admin')->user())->check('admin.store.destroy') ? 1 :0}};
                                        var str = '';

                                        //編輯
                                        if (row_edit) {
                                            str += '<a style="margin:3px;" href="/admin/store/' + row['id'] + '/edit" class="X-Small btn-xs text-success "><i class="fa fa-edit"></i> 編輯</a>';
                                        }

                                        //刪除
                                        if (row_delete) {
                                            str += '<a style="margin:3px;" href="#" attr="' + row['id'] + '" class="delBtn X-Small btn-xs text-danger"><i class="fa fa-times-circle"></i> 刪除</a>';
                                        }

                                        return str;
                                    }
                                },
                                {   
                                    //管理員
                                    'targets': 1, 
                                    "render": function (data, type, row) {
                                        let admin_user = row['admin_user'];
                                        let str = `<a href="/admin/user/${admin_user.id}/edit">` + admin_user.name + ' / ' + admin_user.emp_id + ' / ' + admin_user.mobile + '</a>';
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
                            $('.deleteForm').attr('action', '/admin/store/' + id);
                            $("#modal-delete").modal();
                        });

                    });
                </script>
@stop