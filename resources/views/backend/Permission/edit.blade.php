@extends('backend.layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-warning">
                <div class="box-header">
                    編輯權限 :
                </div>
                <form id="form" class="form-horizontal" action="{{ Route('backend.permission.ajax_edit') }}" method="POST">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <td>選取</td>
                                <td>權限</td>
                                <td>身份</td>
                                <td>可用功能數</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($group as $k=>$v)
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="select[]" value="{{$v['id']}}" @if(array_key_exists($v['id'],$permissionedArray)) checked @endif>
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{ $v['name'] }}</td>
                                    <td>{{ $identity[$v['identity']] }}</td>
                                    <td>{{ count(json_decode($v['permission'],true)) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <button type="button" class="btn btn-default btn-back">取消</button>
                        <button type="submit" class="btn btn-primary" id="submit">送出</button>
                        <input type="hidden" name="id" value="{{ $id }}">
                        {!! csrf_field() !!}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {

            $("#submit").click(function(){
                $("#form").ajaxSubmit(ajaxResponse);
                return false;
            });

            $("#form").validate({
                submitHandler: function (form) {

                    form.submit();
                }
            });
        });

    </script>
@endsection
