<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sitemap;
use Permission;

class PermissionGroupController extends Controller
{
    //
    protected static $message= [
        'status' => 0,
        'status_string' => '',
        'message' => '',
        'data' => []
    ];
    /*
     * 權限群組列表頁面
     */
    public function index(Request $request){

        $group = Permission::groupList($request->get('keyword'),15);

        session(['return_url' => route('backend.permission.group')]);

        return view('backend.PermissionGroup.index',[
            'group' => $group,
            'identity' => Config('permission_identity.identity')
        ]);
    }

    /*
     * 權限群組新增頁面
     */
    public function add(){

        $sitemap = Sitemap::getTreeView();
        $sitemap = Sitemap::routStruct('root',$sitemap);

        session(['return_url' => route('backend.permission.group')]);

        return view('backend.PermissionGroup.add',[
            'sitemap' => json_encode($sitemap),
            'identity' => Config('permission_identity.identity')
        ]);
    }

    /*
     * 權限群組編輯頁面
     */
    public function edit($id){

        $data = Permission::getGroupItem($id);

        $sitemap = Sitemap::getTreeView();

        foreach($sitemap as $k=>$v){
            foreach($v as $k1=>$v1){
                if(in_array($v1['id'],$data->permission)){
                    $sitemap[$k][$k1]['state']['checked'] = true;
                }
            }
        }

        $sitemap = Sitemap::routStruct('root',$sitemap);

        session(['return_url' => route('backend.permission.group')]);

        return view('backend.PermissionGroup.edit',[
            'data' => $data,
            'sitemap' => json_encode($sitemap),
            'identity' => Config('permission_identity.identity')
        ]);
    }

    /*
     * 儲存新權限群組
     */
    public function ajax_add(Request $request){

        return Permission::groupAdd($request->all());

    }

    /*
     * 儲存編輯權限群組
     */
    public function ajax_edit(Request $request){

        return Permission::groupEdit($request->all());
    }

    /*
     * 刪除權限群組
     */
    public function ajax_delete(Request $request){

        return Permission::groupDelete($request->all());
    }
}
