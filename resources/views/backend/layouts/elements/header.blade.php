<!-- Logo -->
<a href="{{ route('backend.index') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>J</b>PT</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>傑思.愛德威</b>展示系統</span>
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
                    <img src="{{ asset('backend/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                    <span class="hidden-xs">{{ session('js_promote.login_user.name') }}</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <img src="{{ asset('backend/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

                        <p>
                            {{ session('js_promote.login_user.name') }} - {{ session('js_promote.login_user.department') }}
                            <small>Member since {{ session('js_promote.login_user.created_at') }}</small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <li class="user-body">
                        <div class="row">
                            @if(session('js_promote') != null)
                                @foreach(session('js_promote.menu') as $k => $v)
                                    <div class="col-xs-4 text-center"><a href="{{Route($v['menu']['id'])}}">{{$v['menu']['name']}}</a></div>
                                @endforeach
                            @endif
                            <div class="col-xs-4 text-center">
                                <a href="{{ route('login.logout')}}">登出</a>
                            </div>
                        </div>
                        <!-- /.row -->
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">

                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
