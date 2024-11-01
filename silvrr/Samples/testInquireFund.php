<?php
/**
 * 查询退款
 */
require_once __DIR__."/../Http/Request/SilvrrInquireRefund.php";

$config = new SilvrrConfiguration( "74967498","file://".(__DIR__."/rsa_private.pem"),"11.0","Shopify");
$refundId = "2";  #客户网站的退款ID

$inquireRefund = new SilvrrInquireRefund($config,$refundId);
try{
    $result = $inquireRefund->request(); #发起请求
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
