<!-- Logo -->
<a href="{{ route('backend.index') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">{!! env('SYSTEM_HEADER_SHORT') !!}</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg">{!! env('SYSTEM_HEADER') !!}</span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="@if(isset(session(env('LOGINSESSION','virtualorz_default'))['login_user']['pic']) && session(env('LOGINSESSION','virtualorz_default'))['login_user']['pic'] != ''){{ session(env('LOGINSESSION','virtualorz_default'))['login_user']['pic'] }}@else{{ asset('backend/dist/img/user2-160x160.jpg') }}@endif" class="user-image" alt="User Image">
                    <span class="hidden-xs">{{ session(env('LOGINSESSION','virtualorz_default').'.login_user.name') }}</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <img src="@if(isset(session(env('LOGINSESSION','virtualorz_default'))['login_user']['pic']) && session(env('LOGINSESSION','virtualorz_default'))['login_user']['pic'] != ''){{ session(env('LOGINSESSION','virtualorz_default'))['login_user']['pic'] }}@else{{ asset('backend/dist/img/user2-160x160.jpg') }}@endif" class="img-circle" alt="User Image">

                        <p>
                            {{ session(env('LOGINSESSION','virtualorz_default').'.login_user.name') }} - {{ session(env('LOGINSESSION','virtualorz_default').'.login_user.department') }}
                            <small>Member since {{ date("Y-m-d",strtotime(session(env('LOGINSESSION','virtualorz_default').'.login_user.created_at'))) }}</small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <li class="user-body">
                        <div class="row">
                            @if(session(env('LOGINSESSION','virtualorz_default')) != null)
                                @foreach(session(env('LOGINSESSION','virtualorz_default').'.menu') as $k => $v)
                                    <div class="col-xs-4 text-center"><a href="{{Route($v['menu']['id'])}}">{{$v['menu']['name']}}</a></div>
                                @endforeach
                            @endif
                        </div>
                        <!-- /.row -->
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-right">
                            <a href="{{ route('login.logout')}}" class="btn btn-default btn-flat">登出</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
