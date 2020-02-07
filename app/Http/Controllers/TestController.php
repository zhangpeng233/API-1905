<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
   public function alipay()
   {
       $ali_gateway = 'https://openapi.alipaydev.com/gateway.do';  //支付网关
   	$appid='2016101000651408';
   	$method='alipay.trade.page.pay';
   	$charset='utf-8';
   	$signtype='RSA2';
   	$sign='';
   	$timestamp=date('Y-m-d H:i:s');
   	$version ='1.0';
   	$return_url='http://1905zhangpeng.comcto.com/alipay/notify';
   	$notify_url='http://1905zhangpeng.comcto.com/alipay/notify';   //支付宝异步通知地址


   	

   	//请求参数
   	$out_trade_no =time() . rand(1111,9999);
   	$product_code='FAST_INSTANT_TRADE_PAY';
   	$total_amount =0.01;
   	$subject='测试订单' .$out_trade_no;

	 $request_param = [
            'out_trade_no'  => $out_trade_no,
            'product_code'  => $product_code,
            'total_amount'  => $total_amount,
            'subject'       => $subject
        ];
        $param = [
            'app_id'        => $appid,
            'method'        => $method,
            'charset'       => $charset,
            'sign_type'     => $signtype,
            'timestamp'     => $timestamp,
            'version'       => $version,
            'notify_url'    => $notify_url,
            'return_url'    => $return_url,
            'biz_content'   => json_encode($request_param)
        ];

        echo '<pre>';print_r($param);echo'</pre>';
        // sort($param);
        // echo '<pre>';print_r($param);echo'</pre>';
       //字典序排序
       ksort($param);
       echo '<pre>';print_r($param);echo'</pre>';

        $str ="";
        foreach($param as $k=>$v)
        {

         $str .=$k . '=' . $v .'&';

        }
        //echo 'str:' .$str;die;
        $str = rtrim($str,'&');
        //echo 'str: '.$str;echo '</br>';echo '<hr>';
        // 3 计算签名   https://docs.open.alipay.com/291/106118
        $key = storage_path('keys/app_priv');
        $priKey = file_get_contents($key);
        $res = openssl_get_privatekey($priKey);
        //var_dump($res);echo '</br>';
        openssl_sign($str, $sign, $res, OPENSSL_ALGO_SHA256);       //计算签名
        $sign = base64_encode($sign);
        $param['sign'] = $sign;
        // 4 urlencode
        $param_str = '?';
        foreach($param as $k=>$v){
            $param_str .= $k.'='.urlencode($v) . '&';
        }
        $param_str = rtrim($param_str,'&');
        $url = $ali_gateway . $param_str;
        //发送GET请求
        //echo $url;die;
        header("Location:".$url);

   }

   public function ascii()
   {
       $char = 'Hello world';
       $length = strlen($char);
       echo $length;
       echo '</br>';
       $pass = "";
       for ($i = 0; $i < $length; $i++) {

           echo $char[$i] . '>>>' . ord($char[$i]);
           echo '</br>';
           $ord = ord(ord($char[$i]) + 3);
           $chr = chr($ord);
           echo $char[$i] . '>>>' . $ord . '>>>' . $chr;
           echo '<hr>';
           $pass .= $chr;
       }
       echo '</br>';
       echo $pass;
   }
    //解密
    public function dec()
    {

        $enc= 'khoor#zruog';

        $length =strlen($enc);

        for($i=0;$i>$length;$i++)
        {
            $ord =ord($enc[$i]);
            echo $ord;echo '</br>';


        }
    }


    public function sign1()
    {
        
        echo '<pre>';print_r($_GET);echo'</pre>';
        $sign =$_GET['sign'];  //base64的签名
        unset($_GET['sign']);

        //字典排序
        ksort($_GET);
        echo '<pre>';print_r($_GET);echo '</pre>';


         //拼接字符串
         $str ="";
         foreach ($_GET as $k=>$v)
         {
             $str .=$k . '=' .$v . '&';
         }
         $str =rtrim($str,'&');
         echo $str;echo '<hr>';

        
         //使用公钥验签
        $pub_key = file_get_contents(storage_path('keys/pubkey2'));
        
        // echo "123";
        // echo $pub_key;die;
        $status = openssl_verify($str,base64_decode($sign),$pub_key,OPENSSL_ALGO_SHA256);
         var_dump($status);
        if($status)     //验签通过
        {
            echo "success";
        }else{
            echo "验签失败";
        }
    }



}
