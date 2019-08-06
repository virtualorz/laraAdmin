<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Route;
use App\member_style;
use DB;
use Storage;
use User;

class PersonalController extends Controller
{
    //
    protected static $message= [
        'status' => 0,
        'status_string' => '',
        'message' => '',
        'data' => []
    ];
    /**
     * Member profile show page
     *
     * @param null
     * @return View
     */
    public function member() {

        //取得個人設定資料
        $member_style = member_style::where('id',User::get('id'))
            ->first();

        return view('backend.Personal.member',[
            'member_style' => $member_style,
            'files' => (isset($member_style->pic) && $member_style->pic !== '') ? json_decode($member_style->pic,true) : []
        ]);
    }

    /**
     * Member profile edit page
     *
     * @param null
     * @return View
     */
    public function ajax_edit_personal(Request $request) {

        //處理上傳的檔案
        $files = [];
        foreach($request->get('upload_file') as $k=>$v){
            if($v != null){
                $v = json_decode($v,true);
                array_push($files,$v);
            }
        }

        DB::beginTransaction();
        try{
            if(member_style::where('id',User::get('id'))->exists()){
                member_style::where('id',User::get('id'))
                    ->update([
                        'show_name' => $request->post('show_name'),
                        'pic' => json_encode($files),
                        'theme' => ($request->post('theme') != null) ? $request->post('theme') : ''
                    ]);
            }
            else{
                member_style::create([
                    'id' => User::get('id'),
                    'show_name' => $request->post('show_name'),
                    'pic' => json_encode($files),
                    'theme' => ($request->post('theme') != null) ? $request->post('theme') : ''
                ]);
            }

            //更新session
            if(isset($files[0])) {
                session([env('LOGINSESSION', 'virtualorz_default') . '.login_user.pic' => Storage::url(env('UPLOADDIR') . '/' . $files[0]['name'])]);
            }
            session([env('LOGINSESSION','virtualorz_default').'.login_user.name' => $request->post('show_name')]);
            session([env('LOGINSESSION','virtualorz_default').'.login_user.theme' => $request->post('theme')]);

            DB::commit();

            self::$message['status'] = 1;
            self::$message['status_string'] = '編輯成功';
            self::$message['message'] = '個人資料成功';
            self::$message['data']['redirectURL'] = Route('backend.personal.member');

        } catch (\PDOException $ex) {
            DB::rollBack();

            self::$message['status_string'] = '錯誤';
            self::$message['message'] = "資料庫錯誤 : ".$ex->getMessage();


        } catch (\Exception $ex) {
            DB::rollBack();

            self::$message['status_string'] = '錯誤';
            self::$message['message'] = "資料庫錯誤 : ".$ex->getMessage();

        }

        return self::$message;
    }

}
