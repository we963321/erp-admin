<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>客戶管理系統</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">

    <link rel="stylesheet" href="/dist/css/skins/skin-blue.min.css">

    {{--datepicker--}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    {{--dataTabels--}}
    {{--<link href="/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet">--}}
    <link href="/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">

    {{--loding--}}
    <link href="/dist/css/load/load.css" rel="stylesheet">
    @yield('css')

    <!-- datepicker -->
    <script src="/dist/js/1.12.4.jquery.js"></script>
    <script src="/dist/js/1.12.1.jquery-ui.js"></script>

    <!-- Bootstrap 3.3.6 -->
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/dist/js/app.min.js"></script>
</head>

<body class="hold-transition skin-blue sidebar-mini">

    <div id="loading">
        <div id="loading-center">
            <div id="loading-center-absolute">
                <div class="object" id="object_four"></div>
                <div class="object" id="object_three"></div>
                <div class="object" id="object_two"></div>
                <div class="object" id="object_one"></div>
            </div>
        </div>
    </div>

    <div class="wrapper">

        @include('layouts.mainHeader')

        @include('layouts.mainSidebar')

        <div class="content-wrapper">
            <section class="content">
                @yield('content')
            </section>
        </div>

    </div>

    <!-- dataTables -->
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="/plugins/tokenfield/dist/bootstrap-tokenfield.min.js"></script>
    <script src="/dist/js/common.js"></script>

    <script>
        $(function() {
            $( "#datepicker" ).datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                yearRange: "c-100:c+0",
            });
        });
    </script>

    @yield('js')
</body>
</html>
