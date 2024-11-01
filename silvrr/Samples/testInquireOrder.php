<?php
/**
 * 查询订单
 */


require_once __DIR__."/../Http/Request/SilvrrInquireOrder.php";

/**
 *  基本参数
 */
$config = new SilvrrConfiguration( "74967498","file://".(__DIR__."/rsa_private.pem"),"11.0","Shopify");

$partnerOrderId = 10; #客户网站上的订单ID

$inquireOrder = new SilvrrInquireOrder($config,$partnerOrderId);

try{
    $result = $inquireOrder->request(); #正式发起请求并返回json格式的结果, 具体参照https://silvrr-pay.readme.io/reference/inquire-an-order

    if(!empty($result))
    {
        $dataArr = json_decode($result,true);
        if(is_array($dataArr))
        {
            if($dataArr['code']=="SUCCESS" )  //如果成功
            {
                ////你的处理代码
            }
            else{
                ////你的处理代码
            }
        }
    }
}
catch (Exception $exception)
{

}
