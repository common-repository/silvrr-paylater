<?php
//namespace Silvrr\Http\Request;
require_once __DIR__.'/SilvrrRequestBase.php';

class SilvrrSignatureTest extends SilvrrRequestBase{

    protected  $uri = "/openpay/v1/{{apiKey}}/signature/testing";

    protected  $method = "GET";

    public function __construct($configuration)
    {
        parent::__construct($configuration);
    }

    protected function getPostData()
    {
        return '';
        //return array('partnerOrderId'=>$this->partnerOrderId);
    }


}