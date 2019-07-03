<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Permission;

class PermissionController extends Controller
{
    //
    protected static $message= [
        'status' => 0,
        'status_string' => '',
        'message' => '',
        'data' => []
    ];
    /*
     * 人員權限列表頁
     */
    public function index(Request $request){

        $data = Permission::permissionList($request->get('keyword'));


        return view('backend.Permission.index',[
            'data' => $data
        ]);
    }

    /*
     * 權限設定編輯頁
     */
    public function edit($id){

        $result = Permission::getPermissionItem($id);

        return view('backend.Permission.edit',[
            'permissionedArray' => $result[0],
            'group' => $result[1],
            'identity' => Config('permission_identity.identity'),
            'id' => $id
        ]);
    }

    /*
     * 儲存權限設定
     */
    public function ajax_edit(Request $request){

        return Permission::permissionEdit($request->all());
    }

    /*
     * 刪除權限設定
     */
    public function ajax_delete(Request $request){

        return Permission::permissionDelete($request->all());
    }
}
