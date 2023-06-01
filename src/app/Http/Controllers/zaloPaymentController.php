<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Hamcrest\Util;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Console;

class zaloPaymentController extends Controller
{

    public function zaloPayment(){
    
        $config = [
            "app_id" => 2553,
            "key1" => "PcY4iZIKFCIdgZvA6ueMcMHHUbRLYjPL",
            "key2" => "kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz",
            "endpoint" => "https://sb-openapi.zalopay.vn/v2/create"
        ];
        $embeddata = '{}'; // Merchant's data
        $items = '[]'; // Merchant's data
        $transID = rand(0,1000000); //Random trans id
  
        $order = [
            "app_id" => $config["app_id"],
            "app_time" => round(microtime(true) * 1000), // miliseconds
            "app_trans_id" => date("ymd") . "_" . $transID, // translation missing: vi.docs.shared.sample_code.comments.app_trans_id
            "app_user" => "user123",
            "item" => $items,
            "embed_data" => $embeddata,
            "amount" => 10000,
            "description" => "Lazada - Payment for the order #$transID",
            "bank_code" => "zalopayapp"
        ];
      
        $data = $order["app_id"] . "|" . $order["app_trans_id"] . "|" . $order["app_user"] . "|" . $order["amount"]
        . "|" . $order["app_time"] . "|" . $order["embed_data"] . "|" . $order["item"];
        $order["mac"] = hash_hmac("sha256", $data, $config["key1"]);
        $context = stream_context_create([
            "http" => [
                "header" => "Content-type: application/x-www-form-urlencoded\r\n",
                "method" => "POST",
                "content" => http_build_query($order)
            ]
        ]);
        $resp = file_get_contents($config["endpoint"], false, $context);
        $result = json_decode($resp, true);
        header('Location: ' . $result['order_url']);
        
        
    }
   
}
