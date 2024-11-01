<?php
//namespace Silvrr\Http\Request;
require_once __DIR__.'/SilvrrRequestBase.php';

class SilvrrCreateRefund extends SilvrrRequestBase{

    protected  $uri = "/openpay/v1/{{apiKey}}/orders/{{partnerOrderId}}/refunds";

    protected  $method = "POST";

    public  $partnerOrderId = "";

    /**
     * String(127)	Required;
     * Idempotent KEY. Unique refund ID. Please make sure of the uniqueness of the refund ID for each time. The same RefundId will not be refunded repeatedly.
     */
    public $refundId;

    /**
     * Integer	Required;
     */
    public $refundAmount;

    /**
     * String	Required;
     */
    public $currency;


    public function __construct($configuration,$partnerOrderId)
    {
        $this->uri = str_replace("{{partnerOrderId}}",$partnerOrderId,$this->uri);
        parent::__construct($configuration);
        $this->partnerOrderId = $partnerOrderId;

    }

    protected function getPostData()
    {
        $data = array(
            'partnerOrderId' =>$this->partnerOrderId,
            'refundId'=>$this->refundId,
            'refundAmount'=>$this->refundAmount,
            'currency'=>$this->currency
        );
        return $data;

    }
    protected function getRequiredFields()
    {
        return array("partnerOrderId","refundId","refundAmount","currency");
    }
}