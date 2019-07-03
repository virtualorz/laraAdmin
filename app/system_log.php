<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class system_log extends Model
{
    //
    protected $table = 'system_log';

    protected $fillable = [
        'page',
        'target_id',
        'before',
        'after',
        'action',
        'remark',
        'update_member_id'
    ];
}
