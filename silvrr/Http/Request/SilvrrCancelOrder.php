<?php
//namespace Silvrr\Http\Request;
require_once __DIR__.'/SilvrrRequestBase.php';
;
class SilvrrCancelOrder extends SilvrrRequestBase{

    protected  $uri = "/openpay/v1/{{apiKey}}/orders/{{partnerOrderId}}/cancel";

    protected  $method = "POST";

    public $orderId;

    public function __construct($configuration,$partnerOrderId,$orderId)
    {
        $this->orderId = $orderId;

        $this->uri = str_replace("{{partnerOrderId}}",$partnerOrderId,$this->uri);
        parent::__construct($configuration);



    }

    protected function getPostData()
    {
        $postData = array(
            'orderId'=>$this->orderId
        );
        return $postData;
    }

    protected function getRequiredFields()
    {
        return array("orderId");
    }


}