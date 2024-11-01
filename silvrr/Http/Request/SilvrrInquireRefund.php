<?php
//namespace Silvrr\Http\Request;
require_once __DIR__.'/SilvrrRequestBase.php';

class SilvrrInquireRefund extends SilvrrRequestBase{

    protected  $uri = "/openpay/v1/{{apiKey}}/refunds/{{refundId}}";

    protected  $method = "GET";

    public $refundId = "";

    public function __construct($configuration,$refundId)
    {

        $this->refundId = $refundId;
        $this->uri = str_replace("{{refundId}}",$refundId,$this->uri);
        parent::__construct($configuration);

    }

    protected function getPostData()
    {
        return "";
        //return array('refundId'=>$this->refundId);
    }


}