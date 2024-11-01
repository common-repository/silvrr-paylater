<?php
/*
 * 换取userToken
 */



require_once __DIR__ . "/../Http/Request/SilvrrExchangeUserToken.php";

$config = new SilvrrConfiguration( "74967498","file://".(__DIR__."/rsa_private.pem"),"11.0","Shopify");

$exchangeToken = new SilvrrExchangeUserToken($config);

/*required*/
$exchangeToken->authCode="0x001CUOPGf-YTf3cCe6Dw9VEppdcht3Ztjwmi2AUe4quJt0KGZgjpfAhTEyGLK4zqHvvuERINADJp6G0KTYu3ocQA0V4aOwzX9lotkqbhVyeFU";
$exchangeToken->partnerUserId = "2";



try{
    $result = $exchangeToken->request();
    /**
     *
     返回结果示例:
     {"code":"SUCCESS","userToken":"0x001CUOPGf-YTf3cCe6Dw9VEj4DXoVDFOVlyhdmTw2ZDLwgWyXDKroQXb3hq5vdewo52zzgptbDWTyy6Bib1YYfHK4qgSpGUWVLUoNX2cb8Y8A","tokenExpireTime": "2022-05-22T09:47:56Z" }

     */

    $dataArr = json_decode($result,true);

    if(is_array($dataArr))
    {
        if($dataArr['code']=="SUCCESS")  #成功则
        {
                ///////////
        }
        else
        {
                //////////////
        }

    }
}
catch (Exception $exception)
{
    echo $exception->getMessage();
}
