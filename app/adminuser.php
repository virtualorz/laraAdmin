<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class adminuser extends Model
{
    //
    protected $table = 'adminuser';

    protected $fillable = [
        'account',
        'password',
        'name',
        'status',
        'create_admin_id'
    ];
}
