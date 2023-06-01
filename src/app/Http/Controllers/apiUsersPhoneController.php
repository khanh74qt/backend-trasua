<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\model\usersPhoneModel;
use App\model\orderModel;
use stdClass;

class apiUsersPhoneController extends Controller
{
    public function login(Request $request)
    {
        $responseData = new stdClass;
        $user = new usersPhoneModel();
        $orderModel = new orderModel();
        $isExist = $user::select("*")
        ->where("sdt",$request->sdt)
        ->exists();
        if ($isExist) {
            // nếu sdt đã tồn tại thì trả về thông tin của sdt này 
            // thông tin trả về sẽ là tổng số tiền và đơn hàng đã mua từ trước đến nay
            //return response()->json(['totalPrice'=>53000,'totalOrder'=>2], 200);
            $responseData->totalPrice = 0;
            $responseData->totalOrder = 2;
        }else{
            //nếu sdt không tồn tại thì tiến hành thêm sdt này vào database đồng thời cũng trả về thông tin của sdt này
            $user->sdt = $request->sdt;
            $user->save();
            $responseData->totalPrice = 45000;
            $responseData->totalOrder = 2;
            //return response()->json(['totalPrice'=>0,'totalOrder'=>0], 200);
        }
        // sau khi nhập sdt xong thì sdt này sẽ được thêm vào bảng orderCurrent (tức nghĩa là đơn hàng hiện tại)\
        // lưu ý trong bảng này phải đảm bảo chỉ có 1 đơn hàng duy nhất (chính vì vậy trước khi ghi bản ghi vào đây cần kiểm tra xem trong này có còn đơn hàng nào không)
        // nếu trong này vẫn còn đơn hàng thì tức nghĩa vẫn còn khách hàng chưa thanh toán đơn hàng này
        
        $order = $orderModel::all();
        if(!empty($order))
        {
            //order Model dang co don hang
            //$orderModel->all()->delete();
        
            $orderModel::truncate();
            $orderModel->sdt = $request->sdt;
            $orderModel->content = "";
            $orderModel->status = "loginSuccess";
            $orderModel->save();
        }
        else{
            //orderModel dang khong co don hang
            
            $orderModel->sdt = $request->sdt;
            $orderModel->content = "";
            $orderModel->status = "loginSuccess";
            $orderModel->save();
        }
        
        return response()->json($responseData, 200);
    }

    public function PayOrder(Request $request)
    {
        //method để lưu thông tin order của khách vào database
        $orderModel = orderModel::find(1);
        $orderModel->content = $request->content;
        $orderModel->status = $request->status;
        $orderModel->update();
        return response()->json(['message'=>'updatesuccess'], 200);
        
    }
}
