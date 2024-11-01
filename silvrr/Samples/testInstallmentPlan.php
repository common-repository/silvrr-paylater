<?php
/**
 * 创建分期付款
 */
require_once __DIR__ . "/../Http/Request/SilvrrInstallmentPlan.php";

/**
 *  基本参数
 */
$config = new SilvrrConfiguration( "74967498","file://".(__DIR__."/rsa_private.pem"),"11.0","Shopify");


$installmentPlan = new SilvrrInstallmentPlan($config);

$installmentPlan->currency="IDR";  #货币代码
$installmentPlan->partnerOrderAmount = "20000000";  #总价, 印尼最低20000

#商品项
$item1 = new SilvrrItem();
/*Required*/
$item1->categoryId = "Category-0001";
$item1->categoryName = "Mobile";
$item1->skuId = "Mobile-0001";
$item1->skuName = "xiaomi";
$item1->unitPrice = "20000000";
$item1->qty = 1;

/*Optional*/
$item1->type = "PhysicalGood";



$item1->seller = new SilvrrSeller("Seller-1000","JD");#买家

$installmentPlan->items = array($item1);#设置商品项
$installmentPlan->buyer = new SilvrrBuyer("buyer-001"); #设置买家


try{
    $result = $installmentPlan->request();
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