<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use App\model\payCompleteModel;

class momoPaymentController extends Controller
{
    public function momoPayment(Request $request)
    {
        header('Content-type: text/html; charset=utf-8');
        //$price = request()->price;
        $price = 5000;
        function execPostRequest($url, $data)
        {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data)
                )
            );
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            //execute post
            $result = curl_exec($ch);
            //close connection
            curl_close($ch);
            return $result;
        }
        $endpoint = "https://payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOQSEP20230323';
        $accessKey = 'CJTq0P8eyxuV301T';
        $serectkey = 'nAwfTuAk2VtoDZueL6wqVCRSdQTyIJE7';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $price;
        $orderId = time() . "";
        $redirectUrl = "http://localhost:3000/paycomplete";
        $ipnUrl = "http://localhost:8989/api/resultPayment";
        $extraData = "";

        $requestId = time() . "";
        $requestType = "captureWallet";
        //$extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $serectkey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there

        header('Location: ' . $jsonResult['payUrl']);
    }

    public function resultPayment(Request $request){
        
        $data = new payCompleteModel;
        $data->content = 'thanh cong';
        $data->save();
        return response()->json([], 204);
    }
}
