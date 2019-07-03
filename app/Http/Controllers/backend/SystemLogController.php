<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use ActionLog;

use App\system_log;
use App\customer;
use App\file;
use App\system_permission;
use App\system_permission_group;

class SystemLogController extends Controller
{
    //
    public function all(){

        $log = ActionLog::logList(15);

        return view('backend.systemLog.all',[
            'log' => $log,
            'log_action' => Config('actionLog_logAction.log_action')
        ]);
    }

    public function all_content($id){

        $logContent = ActionLog::logContent($id);

        return view('backend.systemLog.all_content',[
            'logContent' => $logContent
        ]);
    }
}
