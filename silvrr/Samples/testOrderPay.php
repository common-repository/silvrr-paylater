<?php
/**
 * 创建支付功能
 */

require_once __DIR__."/../Http/Request/SilvrrOrderPay.php";

/**
 *  基本参数
 */
$config = new SilvrrConfiguration( "74967498","file://".(__DIR__."/rsa_private.pem"),"11.0","Shopify");


$partnerOrderId = "11";  #客户网站上的订单ID

$orderPay = new SilvrrOrderPay($config,$partnerOrderId);  #创建订单请求

/**
 * SilvrrOrderPay需要填写的参数
 */

$orderPay->partnerOrderId = $partnerOrderId;  #客户网站上的订单ID,必填
$orderPay->currency = "IDR";    #货币代码
$orderPay->partnerOrderAmount = 200000;   #订单总价,印尼最低20000
$orderPay->purchaseCountry = "IDN";  #国家代码, 目前只有印尼IDN
$orderPay->redirectUrl = "https://www.ausua.com/test/return.php";  #支付成功或失败后的返回业面. 可以在这个页面完成订单状态更改, 示例: https://www.ausua.com/test/return.php?appId=74967498&refNo=4&sign=71A3qa2RvI0OSailLxz0jpjuYbDcLabt4tyS-IyjhPGOm_JsJh0Lmykc222a1uDMT2uOAZ4eR5GW1qmHlZ9kug
$orderPay->callbackUrl = "https://www.ausua.com/test/callback.php"; #同redirectUrl, 但仅用于支付系统向客户网站服务器端发送. 订单状态修改一般在这个页面实现



$buyer = new SilvrrBuyer();  #购买者, SilvrrOrderPay的成员变量buyer
/*Required*/
$buyer->buyerId = 10;  #购买者id

/*Optional */
$buyer->birthDate ="2000-01-01";
$buyer->gender = "Male";
$buyer->name = "Smith";


$shipping = new SilvrrShipping();  #货运对象, SilvrrOrderPay的成员变量shipping
/* Required */
$shipping->city = "Chengdu";
$shipping->countryCode = "IDN";
$shipping->receiverName = "Tom";
$shipping->receiverPhone = "0812000000";
$shipping->region = "Sichuan";
$shipping->postcode = "610000";
$shipping->addressLine = "Building B, House 42";

/*Optional */
$shipping->district = "Tianfu";
$shipping->street = "Tianfu Avenue";




$item1 = new SilvrrItem();  #单位货物信息, SilvrrOrderPay的成员变量item数组的一员
/*Required*/
$item1->categoryId = "12";
$item1->skuId = "2";
$item1->skuName = "Iphone";
$item1->unitPrice = "100000";
$item1->qty = 1;
/*Optional*/
$item1->categoryName = "Phone";
$item1->pictureUrl = "https://www.baidu.com/1.jpg";
$item1->PhysicalGood = "PhysicalGood";
$item1->seller = new SilvrrSeller("1000","JD");


$billingAddress = new SilvrrBillingAddress();  #发票信息,SilvrrOrderPay的成员变量billingAddress
/*Required*/
$billingAddress->firstName = "Tom";
$billingAddress->lastName = "Tom";
$billingAddress->countryCode = "CHN";
$billingAddress->city = "Chengdu";
$billingAddress->region = "Sichuan";
$billingAddress->postcode = "610000";
$billingAddress->addressLine = "Building B, House 42";
$billingAddress->email = "tom@gmail.com";
/*Optional*/
$billingAddress->street = "Tianfu Avenue";
$billingAddress->title = "SilvrrPay Billing Details";


/**
 * 将前面创建的四个类对象赋值给SilvrrOrderPay对象
 */
$orderPay->buyer = $buyer;
$orderPay->shipping = $shipping;
$orderPay->items = array($item1);
$orderPay->billingAddress = $billingAddress;


try{

    $result = $orderPay->request(); #正式发起请求并返回json格式的结果, 具体参照https://silvrr-pay.readme.io/reference/create-a-checkout-order
    if(!empty($result))
    {

        $dataArr = json_decode($result,true);

        if(is_array($dataArr))
        {
            if($dataArr['code']=="SUCCESS" || $dataArr['code']=="DUPLICATE")  //如果成功则可以跳到支付, 或作其他处理
            {
                $payUrl = $dataArr['order']['paymentEntryUrl'];

                //如果成功, 则跳转到支付 .
                header("Location:".$payUrl);
            }
            else{
                /////
            }

        }
    }
}
catch (Exception $exception)
{
   echo $exception->getMessage();
}











