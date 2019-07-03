@extends('backend.layouts.master')

@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/treeView/bootstrap-treeview.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    編輯權限群組 :
                </div>
                <form id="form" class="form-horizontal" action="{{ Route('backend.permission.group.ajax_edit') }}" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">群組名稱 </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control required" name="name" value="{{ $data->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">使用權限 </label>
                            <div class="col-sm-10">
                                <div id="treeview">

                                </div>
                                <input type="hidden" id="tree_node" value="{{ $sitemap }}">
                                <input type="hidden" name="permission" id="permission" value="[]">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">使用身份 </label>
                            <div class="col-sm-10">
                                @foreach($identity as $k=>$v)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="identity" value="{{$k}}" class="required" @if($data->identity == $k) checked @endif> {{$v}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">啟用狀態 </label>
                            <div class="col-sm-10">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="enable" value="0" class="required" @if($data->enable == 0) checked @endif> 停用
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="enable" value="1" class="required" @if($data->enable == 1) checked @endif> 啟用
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
    <script src="{{ asset('vendor/treeView/bootstrap-treeview.js') }}"></script>
    <script src="{{ asset('vendor/treeView/permission_tree.js') }}"></script>
    <script>
        $(document).ready(function () {

            $("#submit").click(function(){
                $("#permission").val(JSON.stringify($('#treeview').treeview('getChecked')));
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
