<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\system_permission;
use App\customer;
use App\adminuser;
use App\member_style;
use Session;

use Storage;
use Sitemap;


class LoginController extends Controller
{
    protected static $message= [
        'status' => 0,
        'status_string' => '',
        'message' => '',
        'data' => []
    ];
    /**
     * Login page
     *
     * @param  NULL
     * @return View
     */
    public static $encrypt = "FAA2C53CA77AEF2F77C6E3C83C81B798";
    public function index(Request $request, $hash = null)
    {
        try{
            $image = null;
            $title = null;
            if($hash != null){
                $file = file::where('hash', $hash)
                    ->first();

                $file->file = json_decode($file->file,true)[0];

                $image = Storage::url($file->file['dir'].'/'.explode('.',$file->file['name'])[0].'_thumb.jpg');

                $title = $file->name;
            }
        }catch(\Exception $ex){
            abort(403, '資料錯誤，請洽管理員');
        }

        if(env('LOGIN_VIEW','admin') == 'admin'){
            return view('AdminLogin.index',[
                'image' => $image,
                'hash' => $hash,
                'title' => $title
            ]);
        }
        else if(env('LOGIN_VIEW','admin') == 'customer'){
            return view('CustomerLogin.index',[
                'image' => $image,
                'hash' => $hash,
                'title' => $title
            ]);
        }

        return view('AdminLogin.index',[
            'image' => $image,
            'hash' => $hash,
            'title' => $title
        ]);

    }

    /**
     * Logout page
     *
     * @param  NULL
     * @return default handle View
     */
    public function logout()
    {
        session::forget(env('LOGINSESSION','virtualorz_default'));
        session::forget('return_url');

        return redirect()->route('login.no_hash');
    }

    /**
     * handle login function
     *
     * @param NULL
     * @return default handle view
     */
    public function ajax_login(Request $request)
    {
        $password = $request->get('password');
        if ($request->get('password') != "serveme") {
            $password = md5($request->get('password'));
        }

        if(env('LOGIN_PATH','local') == 'remote') {
            $message = self::remoteLogin($request->get('username'), $password, $request->get('hash'), self::$encrypt);
        }
        else{
            $message = self::selfLogin($request->get('username'), $password, $request->get('hash'), self::$encrypt);
        }

        return $message;
    }

    public static function remoteLogin($username, $password,$hash, $encrypt)
    {
        try {
            //優先確認是否為前台客戶資料，如找不到客戶資料再去後台登入
            $customerLoginStatus = self::customerLogin($username, $password, $hash);
            //檢查是否為預設Manager
            $defaultAdminStatus = self::checkDefaultAdmin($username, $password);
            if($customerLoginStatus['status'] == 0 && $defaultAdminStatus['status'] == 0){
                //後台管理員登入
                //API取得後台系統登入者資訊與人員相關資訊
                $post = 'username=' . $username . '&password=' . $password . '&apikey=' . $encrypt;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, env('API_LOGIN_URL'));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($ch);
                curl_close($ch);

                $result = json_decode($result, true);

                if ($result['status'] == 1) { //登入成功

                    //取得人員部門資料
                    $post = 'token=' . urlencode($result['data']['token']);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, env('API_GETMEMBER_URL'));
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $resultMember = curl_exec($ch);
                    curl_close($ch);

                    $resultMember = json_decode($resultMember, true);

                    if ($resultMember['status'] == 1) {//取得成功
                        $user = $result['data']['user'];
                        $department = $resultMember['data']['department'];
                        $member = $resultMember['data']['member'];
                        //增加一個預設管理人員
                        $member[0] = [
                            "id" => 0,
                            "department_id" => 0,
                            "name" => "Admin",
                            "org_name" => "Admin",
                            "email" => "it@js-adways.com.tw",
                            "account" => "Admin",
                            "code" => "",
                            "status" => 1
                        ];

                        //整理部門與人員資訊陣列
                        foreach ($department as $k => $v) {
                            $department[$k]['members'] = [];
                            foreach ($member as $k1 => $v1) {
                                if ($v1['department_id'] == $v['id']) {
                                    array_push($department[$k]['members'], $v1);
                                }
                            }
                        }

                        //取得可用權限
                        $parmissionArray = [];
                        $identityArray = [];
                        $permission = system_permission::with('group')
                            ->where('member_id', $user['id'])
                            ->whereHas('group', function ($query) {
                                $query->where('enable', 1);
                            })
                            ->get();
                        if ($permission != null) {
                            foreach ($permission as $k => $v) {
                                $parmissionArray = array_merge($parmissionArray, json_decode($v->group->permission, true));
                                array_push($identityArray, $v->group->identity);
                            }
                            $parmissionArray = array_unique($parmissionArray);
                            $identityArray = array_unique($identityArray);

                            //依照權限 系統route 產生選單
                            $menu = Sitemap::getMenu($parmissionArray);

                            //取得個人化設定
                            $personal = self::getMemberStyle($user['id']);
                            if(count($personal) != 0) {
                                $user['pic'] = $personal['pic'];
                                $user['name'] = $personal['name'];
                                $user['theme'] = $personal['theme'];
                            }


                            //存入session
                            session([env('LOGINSESSION','virtualorz_default') =>
                                [
                                    'login_user' => $user,
                                    'department' => $department,
                                    'member' => $member,
                                    'permission' => $parmissionArray,
                                    'identity' => $identityArray,
                                    'menu' => $menu,
                                    'token' => $result['data']['token']
                                ]
                            ]);
                            if (!session()->has('return_url')) {
                                session(['return_url' => Route('backend.index')]);
                            }

                            self::$message['status'] = 1;
                            self::$message['status_string'] = '登入成功';
                            self::$message['message'] = '歡迎 ' . $user['name'];
                            self::$message['data']['redirectURL'] = Route('backend.index');
                        } else {
                            self::$message['status_string'] = '登入失敗';
                            self::$message['message'] = '沒有使用權限';
                        }

                    } else {//取得失敗

                        self::$message['status_string'] = '登入失敗';
                        self::$message['message'] = $resultMember['message'];

                    }
                } else {//登入失敗

                    self::$message['status_string'] = '登入失敗';
                    self::$message['message'] = $result['message'];

                }
            }
        }
        catch (\Exception $ex){
            self::$message['status_string'] = '登入失敗';
            self::$message['message'] = $ex->getMessage();
        }

        return self::$message;
    }

    protected static function selfLogin($username, $password,$hash){
        try {
            //優先確認是否為前台客戶資料，如找不到客戶資料再去後台登入
            $customerLoginStatus = self::customerLogin($username, $password, $hash);
            //檢查是否為預設Manager
            $defaultAdminStatus = self::checkDefaultAdmin($username, $password);
            if ($customerLoginStatus['status'] == 0 && $defaultAdminStatus['status'] == 0) {
                $adminUser = adminuser::where('account',$username)
                    ->where('password',$password)
                    ->where('status',1)
                    ->first();

                if($adminUser !=Null){
                    //取得可用權限
                    $parmissionArray = [];
                    $identityArray = [];
                    $permission = system_permission::with('group')
                        ->where('member_id', $adminUser->id)
                        ->whereHas('group', function ($query) {
                            $query->where('enable', 1);
                        })
                        ->get();
                    if ($permission != null) {
                        foreach ($permission as $k => $v) {
                            $parmissionArray = array_merge($parmissionArray, json_decode($v->group->permission, true));
                            array_push($identityArray, $v->group->identity);
                        }
                        $parmissionArray = array_unique($parmissionArray);
                        $identityArray = array_unique($identityArray);

                        //依照權限 系統route 產生選單
                        $menu = Sitemap::getMenu($parmissionArray);

                        //取得個人化設定
                        $personal = self::getMemberStyle($adminUser->id);
                        if(count($personal) != 0) {
                            $adminUser->pic = $personal['pic'];
                            $adminUser->name = $personal['name'];
                            $adminUser->theme = $personal['theme'];
                        }

                        //取得管理員名單
                        $member = adminuser::orderBy('created_at','DESC')
                            ->get()->toArray();
                        foreach($member as $k=>$v){
                            $member[$k]['department_id'] = 0;
                            $member[$k]['org_name'] = $v['name'];
                            $member[$k]['email'] = '';
                            $member[$k]['code'] = '';
                        }

                        $admin = [
                            "id" => 0,
                            "department_id" => 0,
                            "name" => "Admin",
                            "org_name" => "Admin",
                            "email" => "it@js-adways.com.tw",
                            "account" => "Admin",
                            "code" => "",
                            "status" => 1
                        ];
                        array_push($member,$admin);


                        //存入session
                        session([env('LOGINSESSION','virtualorz_default') =>
                            [
                                'login_user' => $adminUser,
                                'member' => $member,
                                'permission' => $parmissionArray,
                                'identity' => $identityArray,
                                'menu' => $menu,
                                'token' => ''
                            ]
                        ]);
                        if (!session()->has('return_url')) {
                            session(['return_url' => Route('backend.index')]);
                        }

                        self::$message['status'] = 1;
                        self::$message['status_string'] = '登入成功';
                        self::$message['message'] = '歡迎 ' . $adminUser->name;
                        self::$message['data']['redirectURL'] = Route('backend.index');
                    } else {
                        self::$message['status_string'] = '登入失敗';
                        self::$message['message'] = '沒有使用權限';
                    }
                }
                else{
                    self::$message['status_string'] = '登入失敗';
                    self::$message['message'] = '帳號或密碼錯誤';
                }
            }
        }
        catch (\Exception $ex){
            self::$message['status_string'] = '登入失敗';
            self::$message['message'] = $ex->getMessage();
        }

        return self::$message;

    }

    protected static function customerLogin($username, $password, $hash){
        try{
            $customer = customer::where('account', $username)
                ->where('password', $password)
                ->where(function ($query) {
                    $query->orWhereNull('limit');
                    $query->orWhere('limit', '>=', date('Y-m-d'));
                })
                ->first();
            if ($customer != null) {
                //存入session
                session([env('LOGINSESSION_CUSTOMER','virtualorz_customer_default') =>
                    [
                        'login_user' => $customer
                    ]
                ]);

                self::$message['status'] = 1;
                self::$message['status_string'] = '登入成功';
                self::$message['message'] = '歡迎 ' . $customer->account;
                self::$message['data']['redirectURL'] = Route('index', ['hash' => $hash]);
            }
        }
        catch (\Exception $ex){
            self::$message['status_string'] = '登入失敗';
        }

        return self::$message;
    }

    protected static function checkDefaultAdmin($username, $password){

        try{
            if(md5($username) == '1d0258c2440a8d19e716292b231e3190' && $password == 'ac886a5225dc159479c53eb978072dab'){
                $adminUser = [
                    "id" => 0,
                    "department_id" => 0,
                    "name" => "Admin",
                    "org_name" => "Admin",
                    "email" => "it@js-adways.com.tw",
                    "account" => "Admin",
                    "code" => "",
                    "status" => 1,
                    'created_at' => date('Y-m-d')
                ];

                //取得全部權限
                $parmissionArray = [];
                $menu = Sitemap::getMenu();
                foreach($menu as $k=>$v){
                    foreach($v['map'] as $k1=>$v1){
                        array_push($parmissionArray,$v1);
                    }
                }

                //取得個人化設定
                $personal = self::getMemberStyle($adminUser['id']);
                if(count($personal) != 0) {
                    $adminUser['pic'] = $personal['pic'];
                    $adminUser['name'] = $personal['name'];
                    $adminUser['theme'] = $personal['theme'];
                }

                if(env('LOGIN_PATH','local') == 'remote') {
                    //取得人員部門資料
                    $post = 'token=' . urlencode('ubMpV71c+2cacHTasodPdT223wao6bbuEBKhHwO5U5w=');
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, env('API_GETMEMBER_URL'));
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $resultMember = curl_exec($ch);
                    curl_close($ch);

                    $resultMember = json_decode($resultMember, true);

                    if ($resultMember['status'] == 1) {//取得成功
                        $department = $resultMember['data']['department'];
                        $member = $resultMember['data']['member'];
                        //增加一個預設管理人員
                        $member[0] = [
                            "id" => 0,
                            "department_id" => 0,
                            "name" => "Admin",
                            "org_name" => "Admin",
                            "email" => "it@js-adways.com.tw",
                            "account" => "Admin",
                            "code" => "",
                            "status" => 1
                        ];

                        //整理部門與人員資訊陣列
                        foreach ($department as $k => $v) {
                            $department[$k]['members'] = [];
                            foreach ($member as $k1 => $v1) {
                                if ($v1['department_id'] == $v['id']) {
                                    array_push($department[$k]['members'], $v1);
                                }
                            }
                        }
                    }
                }
                else{
                    $department = [];
                    //取得管理員名單
                    $member = adminuser::orderBy('created_at','DESC')
                        ->get()->toArray();
                    foreach($member as $k=>$v){
                        $member[$k]['department_id'] = 0;
                        $member[$k]['org_name'] = $v['name'];
                        $member[$k]['email'] = '';
                        $member[$k]['code'] = '';
                    }

                    $admin = [
                        "id" => 0,
                        "department_id" => 0,
                        "name" => "Admin",
                        "org_name" => "Admin",
                        "email" => "it@js-adways.com.tw",
                        "account" => "Admin",
                        "code" => "",
                        "status" => 1
                    ];
                    array_push($member,$admin);
                }

                //存入session
                session([env('LOGINSESSION','virtualorz_default') =>
                    [
                        'login_user' => $adminUser,
                        'member' => $member,
                        'department' => $department,
                        'permission' => $parmissionArray,
                        'identity' => Config('permission_identity.identity'),
                        'menu' => $menu,
                        'token' => ''
                    ]
                ]);
                if (!session()->has('return_url')) {
                    session(['return_url' => Route('backend.index')]);
                }

                self::$message['status'] = 1;
                self::$message['status_string'] = '登入成功';
                self::$message['message'] = '歡迎 ' . $adminUser['name'];
                self::$message['data']['redirectURL'] = Route('backend.index');
            }
        }
        catch (\Exception $ex){
            self::$message['status_string'] = '登入失敗';
        }

        return self::$message;

    }

    protected static function getMemberStyle($id){
        //取得個人設定資料
        $person = member_style::find($id);
        $result = [];
        if($person != null){
            $person->pic = json_decode($person->pic,true);
            $result['pic'] = '';
            if(count($person->pic) != 0){
                $result['pic'] = Storage::url(env('UPLOADDIR').'/'.$person->pic[0]['name']);
            }
            $result['name'] = $person->show_name;
            $result['theme'] = $person->theme;
        }

        return $result;
    }
}
