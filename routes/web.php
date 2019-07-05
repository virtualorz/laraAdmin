<?php

/*
 * 登入系統
 */
Route::get('/home/{hash}',
    [
        'as' => 'login' ,
        'uses' => 'LoginController@index' ,
        'permission' => false
    ]);
Route::get('/home',
    [
        'as' => 'login.no_hash' ,
        'uses' => 'LoginController@index' ,
        'permission' => false
    ]);
Route::post('/ajax_login',
    [
        'as' => 'login.ajax_login' ,
        'uses' => 'LoginController@ajax_login',
        'permission' => false
    ]);
Route::get('/logout',
    [
        'as' => 'login.logout' ,
        'uses' => 'LoginController@logout',
        'permission' => false
    ]);
//=======================================================

Route::group(['middleware' => ['checkLoginCustomer'] ], function(){
    /*
     * 首頁
     */
    Route::get('/{hash}',
        [
            'as' => 'index' ,
            'uses' => 'IndexController@index',
            'parent' => 'web',
            'name' => '前台首頁'
        ]);
    //=======================================================
});

Route::group(['middleware' => ['checkLogin','checkPermission'], 'prefix' => '/Backend' ], function(){
    /*
     * 首頁
     */
    Route::get('/index',
        [
            'as' => 'backend.index' ,
            'uses' => 'backend\IndexController@index',
            'parent' => 'root',
            'name' => '資料管理'
        ]);
    //=======================================================

    /*
     * 系統管理員首頁
     */
    Route::get('/system',
        [
            'as' => 'backend.index.system' ,
            'uses' => 'backend\IndexController@system',
            'parent' => 'root',
            'name' => '系統管理'
        ]);
    //=======================================================


    /*
     * 權限群組
     */
    Route::get('/Permission/group',
        [
            'as' => 'backend.permission.group' ,
            'uses' => 'backend\PermissionGroupController@index',
            'parent'=> 'backend.index.system',
            'name' => '權限群組',
            'label' =>'權限設定',
            'fa' => 'fa-dashboard'
        ]);
    Route::get('/Permission/group/add',
        [
            'as' => 'backend.permission.group.add' ,
            'uses' => 'backend\PermissionGroupController@add',
            'parent'=> 'backend.permission.group',
            'name' => '新增'
        ]);
    Route::post('/Permission/group/add',
        [
            'as' => 'backend.permission.group.ajax_add' ,
            'uses' => 'backend\PermissionGroupController@ajax_add',
            'parent'=> 'backend.permission.group.add'
        ]);
    Route::get('/Permission/group/edit/{id}',
        [
            'as' => 'backend.permission.group.edit' ,
            'uses' => 'backend\PermissionGroupController@edit',
            'parent'=> 'backend.permission.group',
            'name' => '編輯'
        ]);
    Route::post('/Permission/group/edit',
        [
            'as' => 'backend.permission.group.ajax_edit' ,
            'uses' => 'backend\PermissionGroupController@ajax_edit',
            'parent'=> 'backend.permission.group.edit'
        ]);
    Route::post('/Permission/group/delete',
        [
            'as' => 'backend.permission.group.ajax_delete' ,
            'uses' => 'backend\PermissionGroupController@ajax_delete',
            'parent'=> 'backend.permission.group',
            'name' => '刪除'
        ]);
    //=======================================================

    /*
     * 人員權限
     */
    Route::get('/Permission',
        [
            'as' => 'backend.permission' ,
            'uses' => 'backend\PermissionController@index',
            'parent'=> 'backend.index.system',
            'name' => '員工權限',
            'label' =>'權限設定',
            'fa' => 'fa-dashboard'
        ]);
    Route::get('/Permission/edit/{id}',
        [
            'as' => 'backend.permission.edit' ,
            'uses' => 'backend\PermissionController@edit',
            'parent'=> 'backend.permission',
            'name' => '編輯'
        ]);
    Route::post('/Permission/edit',
        [
            'as' => 'backend.permission.ajax_edit' ,
            'uses' => 'backend\PermissionController@ajax_edit',
            'parent'=> 'backend.permission.edit'
        ]);
    Route::post('/Permission/delete',
        [
            'as' => 'backend.permission.ajax_delete' ,
            'uses' => 'backend\PermissionController@ajax_delete',
            'parent'=> 'backend.permission',
            'name' => '刪除'
        ]);
    //=======================================================

    /*
     * 系統操作記錄
     */
    Route::get('/System/log/customer/relation',
        [
            'as' => 'backend.system.log.all' ,
            'uses' => 'backend\SystemLogController@all',
            'parent'=> 'backend.index.system',
            'name' => '全站操作記錄',
            'label' =>'系統操作紀錄',
            'fa' => 'fa-users'
        ]);
    Route::get('/System/log/all/content/{id}',
        [
            'as' => 'backend.system.log.all.content' ,
            'uses' => 'backend\SystemLogController@all_content',
            'parent'=> 'backend.system.log.all',
            'name' => '紀錄內容'
        ]);
    //=======================================================

    /*
     * 個人資料捨定
     */
    Route::get('/Personal/member',
        [
            'as' => 'backend.personal.member' ,
            'uses' => 'backend\PersonalController@member',
            'parent'=> 'root',
            'name' => '個人資料'
        ]);
    Route::post('/Personal/member',
        [
            'as' => 'backend.personal.member.ajax_edit' ,
            'uses' => 'backend\PersonalController@ajax_edit_personal',
            'parent'=> 'backend.personal.member',
        ]);
    //=======================================================

});
