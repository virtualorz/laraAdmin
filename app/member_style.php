<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class member_style extends Model
{
    //
    protected $table = 'member_style';

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'show_name',
        'pic',
        'theme'
    ];
}
