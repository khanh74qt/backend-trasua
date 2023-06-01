<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class vnpayPaymentModel extends Model
{
    // dùng để lưu thông tin thanh toán các đơn hàng
    protected $fillable = [
        'thanh_vien','code_bank','money','note','status_response_code'
    ];
}
