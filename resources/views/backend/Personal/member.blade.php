@extends('backend.layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active">
                    <h3 class="widget-user-username">@if(isset($member_style->show_name) && $member_style->show_name != ''){{ $member_style->show_name }}@else{{ session(env('LOGINSESSION','virtualorz_default'))['login_user']['name'] }}@endif</h3>
                    <h5 class="widget-user-desc">{{ session('worklist')['login_user']['department'] }}</h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="@if(isset($member_style->pic) && $member_style->pic != ''){{ Storage::url(env('UPLOADDIR').'/'.$files[0]['name']) }}@else{{ asset('backend/dist/img/user2-160x160.jpg') }}@endif" alt="User Avatar">
                </div>
                <div class="box-footer">

                </div>
            </div>
            <!-- /.widget-user -->
        </div>
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">個人檔案</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form id="form" role="form" action="{{ route('backend.personal.member.ajax_edit') }}" method="POST" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name">姓名</label>
                            <p>{{ session(env('LOGINSESSION','virtualorz_default'))['login_user']['org_name'] }}</p>
                        </div>
                        <div class="form-group">
                            <label for="email">email</label>
                            <p>{{ session(env('LOGINSESSION','virtualorz_default'))['login_user']['email'] }}</p>
                        </div>
                        <div class="form-group">
                            <label for="department">所屬部門</label>
                            <p>{{ session(env('LOGINSESSION','virtualorz_default'))['login_user']['department_id'] }}</p>
                        </div>
                        <div class="form-group">
                            <label for="created_at">報到日期</label>
                            <p>{{ session(env('LOGINSESSION','virtualorz_default'))['login_user']['created_at'] }}</p>
                        </div>
                        <div class="form-group">
                            <label for="show_name">顯示名稱</label>
                            <input type="text" class="form-control" id="show_name" name="show_name" value="@if(isset($member->show_name)){{ $member->show_name }}@else{{ session(env('LOGINSESSION','virtualorz_default'))['login_user']['name'] }}@endif">
                        </div>
                        <div class="form-group ">
                            <label for="pic">大頭貼</label>
                            <br>
                            <span class="file_upload">
                                <span class="btn btn-success fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>上傳檔案</span>
                                    <input type="file" name="file" id="file" class="file_input" accept=".jpg">
                                </span>
                            </span>

                            {!! Fileupload::createUploadArea($files)!!}
                            <br>
                        </div>
                        <div class="form-group ">
                            <label for="theme">主題</label>
                            <select class="form-control" id="theme" name="theme">
                                <option class="default_option" value="">請選擇主題</option>
                                @foreach(Config('theme') as $k=>$v)
                                    <option value="{{ $v }}" @if($member_style != null && $member_style->theme == $v) selected @endif>{{ $k }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="button" id="submit" class="btn btn-primary">更新</button>
                    </div>
                    {{ csrf_field() }}
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('vendor/fileupload/fileupload.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(".btn-back").click(function () {
                history.back(-1);
            });
            $("#theme").change(function(){
                var list = $('body').attr('class').split(/\s+/);
                $.each(list,function(index,item){
                    if(item.substring(0,5) == 'skin-')
                    {
                        $('body').removeClass(item);
                    }
                });
                $('body').addClass($(this).val());
            });
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
