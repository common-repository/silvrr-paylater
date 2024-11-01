<?php
/**
 * 取消订单, 无论支付或未支付, 已支付的会发起退款
 */

require_once __DIR__ . "/../Http/Request/SilvrrCancelOrder.php";

/**
 *  基本参数
 */
//创建配置对象， 第二个参数私钥可以是file://<文件全路径>, 或私钥字符串
$config = new SilvrrConfiguration( "74967498","file://".(__DIR__."/rsa_private.pem"),"11.0","Shopify");


$partnerOrderId = "4"; #客户网站上的订单ID

$orderId = "1000051379"; #支付系统里生成的订单ID,或$patnerOrderId是一一对应关系

$cancelOrder = new SilvrrCancelOrder($config,$partnerOrderId,$orderId);


try{
    $result = $cancelOrder->request();
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
