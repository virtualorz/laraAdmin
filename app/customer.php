<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class customer extends Model
{
    //
    use SoftDeletes;

    protected $table = 'customer';

    protected $fillable = [
        'name',
        'account',
        'password',
        'limit',
        'create_admin_id',
        'update_admin_id'
    ];

    protected $dates = ['deleted_at'];

    /*
     * 紀錄
     */
    public function log(){
        return $this->hasMany('App\customer_log','customer_id','id');
    }

    /*
     * 最後登入
     */
    public function lastLogin(){
        return $this->hasOne('App\customer_log','customer_id','id')
            ->whereNotNull('login')
            ->orderBy('created_at','DESC');
    }
}
