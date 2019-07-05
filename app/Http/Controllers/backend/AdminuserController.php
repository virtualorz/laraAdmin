<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\adminuser;
use DB;
use ActionLog;
use Route;

class AdminuserController extends Controller
{
    //
    //
    protected static $message= [
        'status' => 0,
        'status_string' => '',
        'message' => '',
        'data' => []
    ];
    /*
     * 管理員表頁面
     */
    public function index(Request $request){

        $keyword = $request->get('keyword');

        $adminuser = adminuser::whereNotNUll('id');
        if(!is_null($keyword)){
            $adminuser->where(function($query)use($keyword){
                $query->orWhere('name','LIKE','%'.$keyword.'%');
                $query->orWhere('account','LIKE','%'.$keyword.'%');
            });
        }

        $adminuser = $adminuser->orderBy('created_at','desc')
            ->paginate(15);


        return view('backend.Adminuser.index',[
            'adminuser' => $adminuser
        ]);
    }

    /*
     * 管理員新增頁面
     */
    public function add(){

        return view('backend.Adminuser.add',[

        ]);
    }

    /*
     * 管理員編輯頁面
     */
    public function edit($id){

        $data = adminuser::where('id',$id)
            ->first();

        return view('backend.Adminuser.edit',[
            'data' => $data
        ]);
    }

    /*
     * 儲存新權限群組
     */
    public function ajax_add(Request $request){

        $validator = Validator::make($request->all(),[
            'account' =>'required|max:24',
            'password' =>'required|max:24',
            'passwordR' =>'required|same:password',
            'name' =>'required|max:24',
            'status' => 'required|Integer'
        ]);

        if($validator->fails()){
            $error = $validator->errors()->toArray();
            $error = reset($error);

            self::$message['status_string'] = '驗證錯誤';
            self::$message['message'] = $error[0];

            return self::$message;
        }

        DB::beginTransaction();
        try {

            //檢查帳號是否重複
            $admin_count = adminuser::where('account',$request->get('account'))
                ->count();

            if($admin_count != 0){

                self::$message['status_string'] = '驗證錯誤';
                self::$message['message'] = "帳號重複";

                return self::$message;
            }

            $adminuser = adminuser::create([
                'account' => $request->get('account'),
                'password' => md5($request->get('password')),
                'name' => $request->get('name'),
                'status' => $request->get('status'),
                'create_admin_id' => session(env('LOGINSESSION','virtualorz_default'))['login_user']['id'],
            ]);

            ActionLog::save(Route::getCurrentRoute()->action['parent'],1,'新增管理員',$adminuser);

            $return_target = '';
            $parent = Route::getCurrentRoute()->action['parent'];
            $routes = Route::getRoutes();
            foreach ($routes as $route) {
                $action = $route->getAction();
                if (!empty($action['as']) && $parent == $action['as']) {
                    $return_target = $route->action['parent'];
                }
            }

            DB::commit();

            self::$message['status'] = 1;
            self::$message['status_string'] = '新增成功';
            self::$message['data']['redirectURL'] = Route($return_target);
        }catch (\Exception $ex){
            DB::rollBack();

            self::$message['status_string'] = '錯誤';
            self::$message['message'] = "資料庫錯誤 : ".$ex->getMessage();
        }

        return self::$message;

    }

    /*
     * 儲存編輯權限群組
     */
    public function ajax_edit(Request $request){

        $validator = Validator::make($request->all(),[
            'account' =>'required|max:24',
            'password' =>'required',
            'passwordR' =>'required|same:password',
            'name' =>'required|max:24',
            'status' => 'required|Integer'
        ]);

        if($validator->fails()){
            $error = $validator->errors()->toArray();
            $error = reset($error);

            self::$message['status_string'] = '驗證錯誤';
            self::$message['message'] = $error[0];

            return self::$message;
        }

        DB::beginTransaction();
        try {

            //檢查帳號是否重複
            $admin_count = adminuser::where('account',$request->get('account'))
                ->where('id','!=',$request->get('id'))
                ->count();

            if($admin_count != 0){

                self::$message['status_string'] = '驗證錯誤';
                self::$message['message'] = "帳號重複";

                return self::$message;
            }


            $adminuser = adminuser::where('id',$request->get('id'))
                ->first();

            if($adminuser == null){
                self::$message['status_string'] = '驗證錯誤';
                self::$message['message'] = "找不到此管理員";

                return self::$message;
            }

            $password = $request->get('password');
            if($adminuser->password != $request->get('password')){
                $password = md5($password);
            }

            $adminuser->account = $request->get('account');
            $adminuser->password = $password;
            $adminuser->name = $request->get('name');
            $adminuser->status = $request->get('status');


            ActionLog::save(Route::getCurrentRoute()->action['parent'],2,'編輯管理員',$adminuser);

            $adminuser->save();

            $return_target = '';
            $parent = Route::getCurrentRoute()->action['parent'];
            $routes = Route::getRoutes();
            foreach ($routes as $route) {
                $action = $route->getAction();
                if (!empty($action['as']) && $parent == $action['as']) {
                    $return_target = $route->action['parent'];
                }
            }

            DB::commit();

            self::$message['status'] = 1;
            self::$message['status_string'] = '編輯成功';
            self::$message['data']['redirectURL'] = Route($return_target);
        }catch (\Exception $ex){
            DB::rollBack();

            self::$message['status_string'] = '錯誤';
            self::$message['message'] = "資料庫錯誤 : ".$ex->getMessage();
        }

        return self::$message;
    }

    /*
     * 刪除權限群組
     */
    public function ajax_delete(Request $request){

        DB::beginTransaction();
        try {

            $adminuser = adminuser::where('id',$request->get('id'))
                ->first();

            if($adminuser == null){
                self::$message['status_string'] = '驗證錯誤';
                self::$message['message'] = "找不到此管理員";

                return self::$message;
            }

            $adminuser->delete();


            ActionLog::save(Route::getCurrentRoute()->action['parent'],0,'刪除管理員',$adminuser);

            DB::commit();

            self::$message['status'] = 1;
            self::$message['status_string'] = '刪除成功';
            self::$message['data']['redirectURL'] = Route(Route::getCurrentRoute()->action['parent']);
        }catch (\Exception $ex){
            DB::rollBack();

            self::$message['status_string'] = '錯誤';
            self::$message['message'] = "資料庫錯誤 : ".$ex->getMessage();
        }

        return self::$message;
    }
}
