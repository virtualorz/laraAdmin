@extends('backend.layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    搜尋條件 :
                </div>
                <form class="form-horizontal" action="{{ Route('backend.permission') }}" method="GET">
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

                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <td>人員</td>
                            <td>權限</td>
                            <td>身份</td>
                            <td>最近更新日期</td>
                            <td>功能</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $k=>$v)
                            <tr>
                                <td>{{ $v['name'] }}</td>
                                <td>{{ $v['group_name'] }}</td>
                                <td>{{ $v['identity_name'] }}</td>
                                <td>@if($v['created_at'] != ''){{ date('Y-m-d',strtotime($v['created_at'])) }}@endif</td>
                                <td>
                                    @if(in_array('backend.permission.edit',session(env('LOGINSESSION','virtualorz_default').'.permission')))
                                        <button class="btn btn-info btn-url" data-url="{{ route('backend.permission.edit',['id'=>$v['id']]) }}">編輯</button>
                                    @endif
                                    @if(in_array('backend.permission.ajax_delete',session(env('LOGINSESSION','virtualorz_default').'.permission')))
                                        <button class="btn btn-danger btn-ajax" data-toggle="modal" data-target="#modal-danger"
                                                data-url="{{ route('backend.permission.ajax_delete',['id'=>$v['id']])}}">刪除</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">

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
