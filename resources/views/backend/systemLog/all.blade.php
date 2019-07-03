@extends('backend.layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header">

                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <td>頁面</td>
                            <td>操作</td>
                            <td>動作</td>
                            <td>操作時間</td>
                            <td>操作人員</td>
                            <td>功能</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($log as $k=>$v)
                            <tr>
                                <td>{{ $v->page }}</td>
                                <td>{{ $log_action[$v->action] }}</td>
                                <td>{{ $v->remark }}</td>
                                <td>{{ $v->created_at }}</td>
                                <td>{{ session('js_promote.member')[$v->update_member_id]['name'] }}</td>
                                <td>
                                    <button class="btn btn-info btn-url" data-url="{{ route('backend.system.log.all.content',['id'=>$v->id]) }}">異動內容</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        {{ $log->appends($_GET)->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });

    </script>
@endsection
