<?php
/**
 * 获取授权页面地址
 */

require_once __DIR__ . "/../Http/Request/SilvrrAuthorizationPage.php";

//创建配置对象， 第二个参数私钥可以是file://<文件全路径>, 或私钥字符串
$config = new SilvrrConfiguration( "74967498","file://".(__DIR__."/rsa_private.pem"),"11.0","Shopify");

$authorizationPage = new SilvrrAuthorizationPage($config);

/*Required*/
$authorizationPage->partnerUserId = "2";  #客户网站当前用户的ID

/*Optional*/
$authorizationPage->phoneNumber = "0812000001";



try{
    $result = $authorizationPage->request();

     $dataArr = json_decode($result,true);


    if(is_array($dataArr))
    {
        if($dataArr['code']=="SUCCESS")
        {
            $authUrl =  $dataArr['authorizationUrl'];
            $redirect_url = "https://www.ausua.com/test/return.php";
            $auth_redirect_url = $authUrl.'?redirect_uri='.urlencode($redirect_url);

            //如果成功, 则跳转到授权页面
            header("Location:".$auth_redirect_url);
        }

    }
}
catch (Exception $exception)
{
    echo $exception->getMessage();
}


