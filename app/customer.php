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
}
