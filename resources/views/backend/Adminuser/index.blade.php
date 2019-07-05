@extends('backend.layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    搜尋條件 :
                </div>
                <form class="form-horizontal" action="{{ Route('backend.admin.user') }}" method="GET">
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
                    @if(in_array('backend.admin.user.add',session(env('LOGINSESSION','virtualorz_default').'.permission')))
                        <button class="btn btn-success btn-url" data-url="{{ Route('backend.admin.user.add') }}">新增管理員</button>
                    @endif
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <td>帳號</td>
                            <td>姓名</td>
                            <td>新增日期</td>
                            <td>啟用狀態</td>
                            <td>功能</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($adminuser as $k=>$v)
                            <tr>
                                <td>{{ $v->account }}</td>
                                <td>{{ $v->name }}</td>
                                <td>{{ $v->created_at->format('Y-m-d') }}</td>
                                <td>@if($v->status == 0)停用 @else 啟用 @endif</td>
                                <td>
                                    @if(in_array('backend.admin.user.edit',session(env('LOGINSESSION','virtualorz_default').'.permission')))
                                        <button class="btn btn-info btn-url" data-url="{{ route('backend.admin.user.edit',['id'=>$v['id']]) }}">編輯</button>
                                    @endif
                                    @if(in_array('backend.admin.user.ajax_delete',session(env('LOGINSESSION','virtualorz_default').'.permission')))
                                        <button class="btn btn-danger btn-ajax" data-toggle="modal" data-target="#modal-danger"
                                                data-url="{{ route('backend.admin.user.ajax_delete',['id'=>$v['id']])}}">刪除</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        {{ $adminuser->appends($_GET)->links() }}
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
