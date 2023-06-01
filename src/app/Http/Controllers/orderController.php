<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\model\orderModel;
use App\model\historyOrderModel;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Auth;

class orderController extends Controller
{
    //method này dùng để truy xuất ra order của khách hàng gần nhất để tiến hành gửi về client để pha chế
    public function orderInfo()
    {
        $orderModel = new orderModel();
        $dataOrder = $orderModel->all();
        return response()->json($dataOrder, 200);
    }
    //method này dùng để nhận thông tin order của khách hàng lưu vào database
    public function orderSend(Request $request)
    {
        $order = new orderModel;
        $order->content = $request->content;
        $order->save();
        return response()->json(['message' => 'success'], 200);
    }
}
