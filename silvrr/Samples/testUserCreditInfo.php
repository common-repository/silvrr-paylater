<?php
/**
 * 获取用户creditInfo
 */
require_once __DIR__."/../Http/Request/SilvrrUserCreditInfo.php";

$config = new SilvrrConfiguration( "74967498","file://".(__DIR__."/rsa_private.pem"),"11.0","Shopify");


$userCreditInfo = new SilvrrUserCreditInfo($config);

$userCreditInfo->userToken = "0x001CUOPGf-YTf3cCe6Dw9VEiQOB4qw8j1GyV3bGcPkGsjotTW1C5WfEn2QfdrgThpo1C2cymY7UQGCOzeujZbmTm9Mr6OwmPnulKueCGmdSMA";

try{
    $result = $userCreditInfo->request();
    if(!empty($result))
    {
        $dataArr = json_decode($result,true);
        if(is_array($dataArr))
        {
            if($dataArr['code']=="SUCCESS" )  //如果成功则可以跳到支付
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
