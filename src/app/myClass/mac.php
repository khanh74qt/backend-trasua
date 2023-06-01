<?php
namespace App\myClass;
class ZaloPayMac{
    static function compute(string $params, string $key = null)
    {
      if (is_null($key)) {
        //$key = Config::get()['key1'];
        $key = "9phuAOYhan4urywHTh0ndEXiV3pKHr5Q";
      }
      return hash_hmac("sha256", $params, $key);
    }
  
    static function createOrderMacData(Array $order)
    {
      return $order["appid"]."|".$order["apptransid"]."|".$order["appuser"]."|".$order["amount"]
        ."|".$order["apptime"]."|".$order["embeddata"]."|".$order["item"];
    }
  
    public static function createOrder(Array $order)
    {
      return self::compute(self::createOrderMacData($order));
    }
}