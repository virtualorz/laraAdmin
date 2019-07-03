@extends('backend.layouts.master')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                搜尋條件 :
            </div>
            <form class="form-horizontal" action="{{ Route('backend.permission.group') }}" method="GET">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label input-lg">關鍵字 : </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control input-lg" name="keyword" placeholder="關鍵字搜尋" value="@if(isset($_GET['keyword'])){{$_GET['keyword']}}@endif">
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">搜尋</button>
                </div>
            </form>
        </div>
        <div class="box box-success">
            <div class="box-header">
                @if(in_array('backend.permission.group.add',session('js_promote.permission')))
                <button class="btn btn-success btn-url" data-url="{{ Route('backend.permission.group.add') }}">新增群組</button>
                @endif
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <td>群組名稱</td>
                        <td>身份</td>
                        <td>套用人數</td>
                        <td>新增日期</td>
                        <td>啟用狀態</td>
                        <td>功能</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($group as $k=>$v)
                    <tr>
                        <td>{{ $v->name }}</td>
                        <td>{{ $identity[$v->identity] }}</td>
                        <td>{{ count($v->permission_use) }}</td>
                        <td>{{ $v->created_at->format('Y-m-d') }}</td>
                        <td>@if($v->enable == 0)停用 @else 啟用 @endif</td>
                        <td>
                            @if(in_array('backend.permission.group.edit',session('js_promote.permission')))
                            <button class="btn btn-info btn-url" data-url="{{ route('backend.permission.group.edit',['id'=>$v['id']]) }}">編輯</button>
                            @endif
                            @if(in_array('backend.permission.group.ajax_delete',session('js_promote.permission')))
                            <button class="btn btn-danger btn-ajax" data-toggle="modal" data-target="#modal-danger"
                                    data-url="{{ route('backend.permission.group.ajax_delete',['id'=>$v['id']])}}">刪除</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <ul class="pagination pagination-sm no-margin pull-right">
                    {{ $group->appends($_GET)->links() }}
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {

    });

</script>
@endsection
