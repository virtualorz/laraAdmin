<!-- Sidebar user panel -->
<div class="user-panel">
    <div class="pull-left image">
        <img src="@if(isset(session(env('LOGINSESSION','virtualorz_default'))['login_user']['pic']) && session(env('LOGINSESSION','virtualorz_default'))['login_user']['pic'] != ''){{ session(env('LOGINSESSION','virtualorz_default'))['login_user']['pic'] }}@else{{ asset('backend/dist/img/user2-160x160.jpg') }}@endif" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
        <p>{{ session(env('LOGINSESSION','virtualorz_default').'.login_user.name') }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
</div>
<!-- search form -->
<form action="#" method="get" class="sidebar-form">
    <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
        </span>
    </div>
</form>
<!-- /.search form -->
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">主選單</li>
    @php ($systen_id = 0)
    @if(session(env('LOGINSESSION','virtualorz_default')) != null)
        @foreach(session(env('LOGINSESSION','virtualorz_default').'.menu') as $k=>$v)
            @if(in_array(Route::currentRouteName(),$v['map']))
                @php($systen_id = $k)

                @break
            @endif
        @endforeach
    @endif

    @if(session(env('LOGINSESSION','virtualorz_default')) != null)
        @foreach(session(env('LOGINSESSION','virtualorz_default').'.menu')[$systen_id]['left'] as $k=>$v)
            <li class="treeview @if((isset(Route::getCurrentRoute()->action['label']) && Route::getCurrentRoute()->action['label'] == $k) || (isset(Route::getRoutes()->getByName(Route::getCurrentRoute()->action['parent'])->action['label']) && Route::getRoutes()->getByName(Route::getCurrentRoute()->action['parent'])->action['label'] == $k)) active @endif">
                <a href="#">
                    <i class="fa {{ $v['fa'] }}"></i> <span>{{ $k }}</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                @foreach($v['menu'] as $k1=>$v1)
                        <li @if((isset(Route::getCurrentRoute()->action['as']) && Route::getCurrentRoute()->action['as'] == $v1['id']) || (isset(Route::getRoutes()->getByName(Route::getCurrentRoute()->action['parent'])->action['as']) && Route::getRoutes()->getByName(Route::getCurrentRoute()->action['parent'])->action['as'] == $v1['id'])) class="active" @endif><a href="{{Route($v1['id'])}}"><i class="fa fa-circle-o"></i>{{$v1['name']}}</a></li>
                @endforeach
                </ul>
            </li>
        @endforeach
    @else
        <li class="treeview menu-open">
            <a href="#">
                <i class="fa fa-files-o"></i> <span>API文件</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu" style="display: block;">
                <li><a href="{{Route('system.api.customer')}}"><i class="fa fa-circle-o"></i>客戶代理商資料同步</a></li>
                <li><a href="{{ Route('system.api.trace') }}"><i class="fa fa-circle-o"></i>業務追蹤客戶</a></li>
            </ul>
        </li>
    @endif
</ul>
