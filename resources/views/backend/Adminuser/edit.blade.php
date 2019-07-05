@extends('backend.layouts.master')

@section('head')

@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    編輯管理員 :
                </div>
                <form id="form" class="form-horizontal" action="{{ Route('backend.admin.user.ajax_edit') }}" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">帳號 </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control required" name="account" value="{{$data->account}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">密碼 </label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control required" name="password" value="{{$data->password}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">密碼確認 </label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control required" name="passwordR" value="{{$data->password}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">姓名 </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control required" name="name" value="{{$data->name}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">啟用狀態 </label>
                            <div class="col-sm-10">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="status" value="0" class="required" @if($data->status == 0) checked @endif> 停用
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="status" value="1" class="required" @if($data->status == 1) checked @endif> 啟用
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="button" class="btn btn-default btn-back">取消</button>
                        <button type="submit" class="btn btn-primary" id="submit">送出</button>
                        <input type="hidden" name="id" value="{{ $data->id }}">
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
