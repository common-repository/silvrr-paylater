<?php
/**
 * 创建退款
 */
require_once __DIR__ . "/../Http/Request/SilvrrCreateRefund.php";


$config = new SilvrrConfiguration( "74967498","file://".(__DIR__."/rsa_private.pem"),"11.0","Shopify");


$partnerOrderId = "10"; #客户网站上的订单ID

$refund = new SilvrrCreateRefund($config,$partnerOrderId);

/**
 * 基本参数
 */
$refund->currency = "IDR";  #货币代码
$refund->refundId = "2";    #退款id, 即客户网站上为此次退款创建的ID, 一般是客户网站退款表的自增ID
$refund->refundAmount = "200000";  #退款总金额, 不得大于订单的支付总额

try{
    $result = $refund->request();  #开始请示

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
   echo $exception->getMessage();
}

