<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class payCompleteModel extends Model
{
    //dung để lưu thông tin đơn hàng khi đã thanh toán xong
    protected $fillable = [
        'content',
    ];
}
