<?php
/**
 * 取消userToken
 */

require_once __DIR__ . "/../Http/Request/SilvrrCancelUserToken.php";

//创建配置对象， 第二个参数私钥可以是file://<文件全路径>, 或私钥字符串
$config = new SilvrrConfiguration( "74967498","file://".(__DIR__."/rsa_private.pem"),"11.0","Shopify");

$cancelToken  = new SilvrrCancelUserToken($config);

$cancelToken->partnerUserId = "2";
$cancelToken->userToken = "0x001CUOPGf-YTf3cCe6Dw9VEiQOB4qw8j1GyV3bGcPkGsjotTW1C5WfEn2QfdrgThpo1C2cymY7UQGCOzeujZbmTm9Mr6OwmPnulKueCGmdSMA";

try{
    $result = $cancelToken->request();

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
catch (Exception $exception)
{
    echo $exception->getMessage();
}


