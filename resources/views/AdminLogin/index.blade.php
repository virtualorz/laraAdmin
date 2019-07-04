<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{env('SYSTEM_TITLE','傑思')}} | 使用者登入</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('backend/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/AdminLTE.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/iCheck/square/blue.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">

<div class="alert-area alert alert-dismissible" role="alert" style="padding:22px !important; margin-bottom:0px !important;display:none">
    <button type="button" class="close" onclick="$('.alert').hide()">
        <span aria-hidden="true">&times;</span>
    </button>
    <span class="alert-text"></span>
</div>

<div class="login-box">
    <div class="login-logo">
        <a href="#">{{ env('LOGIN_TITLE','登入畫面') }}</a>
    </div>
    <!-- /.login-logo -->

    <div class="login-box-body">
        <p class="login-box-msg">請使用帳號密碼登入</p>

        <form id="form" action="{{ route('login.ajax_login') }}" method="post">
            <div class="form-group has-feedback">
                <input type="txt" name="username" class="form-control" placeholder="使用者">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="密碼">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>

                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="button" id="btn_login" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
            {{ csrf_field() }}
        </form>

        <div class="social-auth-links text-center">

        </div>
        <!-- /.social-auth-links -->

    </div>

    <!-- /.login-box-body -->
</div>

<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{ asset('backend/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('backend/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('backend/plugins/iCheck/icheck.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('login/vendor/jquery_validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('login/vendor/jquery_validation/additional-methods.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('login/vendor/jquery_validation/default.js') }}"></script>
<script type="text/javascript" src="{{ asset('login/vendor/jquery_validation/localization/messages_zh_tw.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/jquery.form.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/global.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.blockui.js') }}"></script>

<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });

    $(document).ready(function(){
        $("#btn_login").click(function(){
            $("#form").ajaxSubmit(ajaxResponse);
        });

        $("#form").validate({
            submitHandler: function (form) {
                form.submit();
            }
        });

        $("#form").keypress(function(e){
            code = (e.keyCode ? e.keyCode : e.which);

            if(code == 13){
                $("#form").ajaxSubmit(ajaxResponse);
            }
        });


    });

</script>
</body>

</html>
