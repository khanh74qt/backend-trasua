<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class orderModel extends Model
{
    protected $fillable = [
        'sdt','status'
    ];
    protected $casts = [
        'content' => 'array'
    ];
}
