<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>展示系統 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/select2/dist/css/select2.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/skins/_all-skins.min.css') }}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/morris.js/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/fullcalendar/dist/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/bower_components/fullcalendar/dist/fullcalendar.print.min.css') }}" media="print">
    <!-- summernote-->
    <link rel="stylesheet" href="{{ asset('backend/plugins/summernote/summernote.css') }}">

    @yield('head')
    <style>
        .error {
            color: red;
        }
        .file_input {
            opacity:0;
            position:absolute;
            left:0;
            right:0;
            margin-top:-26px;
            width:115px;
            height:35px;
            cursor:pointer
        }
        .progress-upload {
            width: 120px;
            position: relative;
            display: inline-block;
            vertical-align: middle;
        }
        .alert_show_error {
            width: 135px;
            display: inline-block;
        }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- jQuery 3 -->
    <script src="{{ asset('backend/bower_components/jquery/dist/jquery.min.js') }}"></script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="alert-area alert alert-dismissible" role="alert" style="padding:22px !important; margin-bottom:0px !important;display:none">
    <button type="button" class="close" onclick="$('.alert').hide()">
        <span aria-hidden="true">&times;</span>
    </button>
    <span class="alert-text"></span>
</div>
<div class="wrapper">

    <header class="main-header">
        @include('backend.layouts.elements.header')
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            @include('backend.layouts.elements.left')
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ (isset(Route::getCurrentRoute()->action['name'])) ? Route::getCurrentRoute()->action['name'] : '--' }}
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                @include('backend.layouts.elements._build_navi_path')
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('content')
            @include('backend.layouts.elements.popup')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.4.0
        </div>
        <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">

    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
   immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('backend/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('backend/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('backend/bower_components/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('backend/bower_components/morris.js/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('backend/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('backend/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('backend/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('backend/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('backend/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('backend/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('backend/bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.zh-TW.min.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('backend/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('backend/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{ asset('backend/dist/js/pages/dashboard.js') }}"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('backend/dist/js/demo.js') }}"></script>
<!-- fullCalendar -->
<script src="{{ asset('backend/bower_components/moment/moment.js') }}"></script>
<script src="{{ asset('backend/bower_components/fullcalendar/dist/fullcalendar.min.js') }}"></script>
<script src="{{ asset('backend/bower_components/fullcalendar/dist/locale-all.js') }}"></script>
<!-- jquery validation -->
<script src="{{ asset('backend/bower_components/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('backend/bower_components/jquery-validation/dist/localization/messages_zh_TW.min.js') }}"></script>
<!-- summernote -->
<script src="{{ asset('backend/plugins/summernote/summernote.min.js') }}"></script>
<script src="{{ asset('backend/plugins/summernote/summernote-zh-TW.js') }}"></script>

<!-- summernote -->
<script src="{{ asset('backend/plugins/summernote/summernote.min.js') }}"></script>
<script src="{{ asset('backend/plugins/summernote/summernote-zh-TW.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('backend/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

<script type="text/javascript" src="{{ asset('js/jquery.form.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/global.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.blockui.js') }}"></script>

<script>
    $.widget.bridge('uibutton', $.ui.button);
    $(document).ready(function () {
        $(".btn-ajax").click(function () {
            $($(this).attr("data-target")).find(".btn-confirm").attr("data-url", $(this).attr(
                'data-url'));
            $($(this).attr("data-target")).find(".action").html($(this).html());
        });

        $(".btn-ajax_multi").click(function () {
            var multi_id = "";
            $(".select_item").each(function(){
                if($(this).is(":checked")){
                    multi_id += $(this).val()+"_";
                }
            });
            $($(this).attr("data-target")).find(".btn-confirm").attr("data-url", $(this).attr(
                'data-url')+"&multi_id="+multi_id);
            $($(this).attr("data-target")).find(".action").html($(this).html());
        });

        $(".btn-confirm").click(function () {
            $('<form action="' + $(this).attr('data-url') +
                '" method="POST">{{ csrf_field() }}</form>')
                .appendTo('body').ajaxSubmit(ajaxResponse);
            $(".modal").hide();
        });

        $(document).on("click",".btn-url",function(){
            location.href = $(this).data('url');
        });

        $(document).on("click",".btn-url-black",function(){
            window.open($(this).data('url'));
        });

        $(".btn-back").click(function(){
            window.history.back();
        });
    });

</script>

@yield('script')
</body>

</html>
