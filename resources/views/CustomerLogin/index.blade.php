<!DOCTYPE html>
<html>
<head>
    <title>{{env('SYSTEM_TITLE','傑思')}} | 使用者登入</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ asset('login/images/icons/favicon.ico') }}"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/animsition/css/animsition.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/daterangepicker/daterangepicker.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('login/css/main.css') }}">
    <!--===============================================================================================-->

    <style>
        main::before {
            background: url("@if($image != null) {{$image}} @else{{ asset('login/images/bg-01.jpg') }}@endif") 0 / cover fixed;
        }

        main {
            background: hsla(253,11%,84%,.3);
            position: absolute;
            overflow: hidden;

            /* 其他樣式 */
        }

        main::before {
            content: '';
            position: absolute;
            top:0; right:0; bottom:0; left:0;
            filter: blur(20px);
            z-index: -1;
            margin: -30px;
        }
    </style>
</head>
<body>
<div class="alert-area alert alert-dismissible" role="alert" style="padding:22px !important; margin-bottom:0px !important;display:none">
    <button type="button" class="close" onclick="$('.alert').hide()">
        <span aria-hidden="true">&times;</span>
    </button>
    <span class="alert-text"></span>
</div>
<div class="limiter">
    <div class="container-login100" style="background-image: url('@if($image != null) {{$image}} @else{{ asset('login/images/bg-01.jpg') }}@endif');">
        <main style="height: 100%;width: 100%;top: -1px;left: -1px"></main>
        <div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41" style="color: #0a0a0a">
					{{ env('LOGIN_TITLE','登入畫面') }}
				</span>
            <form id="form" class="login100-form validate-form p-b-33 p-t-5" action="{{ Route('login.ajax_login') }}" method="POST">

                <div class="wrap-input100 validate-input" data-validate = "Enter username">
                    <input class="input100" type="text" name="username" placeholder="帳號">
                    <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Enter password">
                    <input class="input100" type="password" name="password" placeholder="密碼">
                    <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                </div>

                <div class="container-login100-form-btn m-t-32">
                    <input type="button" class="login100-form-btn" value="Login" id="btn_login" style="cursor: pointer">
                </div>
                <input type="hidden" name="hash" value="{{$hash}}">
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</div>


<div id="dropDownSelect1"></div>


<!--===============================================================================================-->
<script src="{{ asset('login/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('login/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('login/vendor/bootstrap/js/popper.js') }}"></script>
<script src="{{ asset('login/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('login/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('login/vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('login/vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('login/vendor/countdowntime/countdowntime.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('login/js/main.js') }}"></script>


<script type="text/javascript" src="{{ asset('login/vendor/jquery_validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('login/vendor/jquery_validation/additional-methods.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('login/vendor/jquery_validation/default.js') }}"></script>
<script type="text/javascript" src="{{ asset('login/vendor/jquery_validation/localization/messages_zh_tw.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/jquery.form.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/global.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.blockui.js') }}"></script>

</body>
<script>
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
</html>
