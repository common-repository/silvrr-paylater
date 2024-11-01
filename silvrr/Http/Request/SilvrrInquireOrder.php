<?php
//namespace Silvrr\Http\Request;
require_once __DIR__.'/SilvrrRequestBase.php';

class SilvrrInquireOrder extends SilvrrRequestBase{

    protected  $uri = "/openpay/v1/{{apiKey}}/orders/{{partnerOrderId}}";

    protected  $method = "GET";

    protected  $partnerOrderId = "";

    public function __construct($configuration,$partnerOrderId)
    {

        $this->partnerOrderId = $partnerOrderId;
        $this->uri = str_replace("{{partnerOrderId}}",$partnerOrderId,$this->uri);

        parent::__construct($configuration);
    }

    protected function getPostData()
    {
        return '';
        //return array('partnerOrderId'=>$this->partnerOrderId);
    }


}