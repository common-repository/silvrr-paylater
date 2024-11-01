<?php

///namespace Silvrr\Http\Request;
require_once __DIR__.'/SilvrrRequestBase.php';
require_once __DIR__."/../../Util/SilvrrTool.php";
require_once __DIR__."/../../Model/SilvrrItem.php";
require_once __DIR__."/../../Model/SilvrrBillingAddress.php";
require_once __DIR__."/../../Model/SilvrrBuyer.php";
require_once __DIR__."/../../Model/SilvrrSeller.php";
require_once __DIR__."/../../Model/SilvrrShipping.php";


class SilvrrOrderPay extends SilvrrRequestBase {

    protected  $uri = "/openpay/v1/{{apiKey}}/checkout/orders/{{partnerOrderId}}";

    protected  $method = "POST";

    /**
     * String Optional;
     */
    public $userToken;

    /**
     * String(127) Required;
     */
    public $partnerOrderId;

    /**
     * Int Required;
     */
    public $partnerOrderAmount;

    /**
     * String(2) Required;
     * Country ISO 3166 code;
     */
    public $purchaseCountry;

    /**
     * String(3) Required;
     * Currency of ISO4217
     */
    public $currency;

    /**
     * @var string
     * optional values: NonZeroDecimal, ZeroDecimal
     */
    public $currencyUnit = "NonZeroDecimal";

    /**
     * String(512) Required;
     * Redirect page, used for jumping back to the merchant specified URL after the user completes the payment. use HTTPS
     */
    public $redirectUrl;

    /**
     * String(512) Required;
     * Callback notification URL, used to receive notification of the transaction state changes. Path variable is not supported;
     */
    public $callbackUrl;

    /**
     * String(32)  Optional;
     */
    public $expireTime;

    /**
     * Object(Buyer)  Required;
     */
    public $buyer;

    /**
     * Object(Shipping) Required;
     */
    public $shipping;

    /**
     * Array(Item) Required;
     */
    public $items;

    /**
     * Object(BillingAddress)	Required;
     */
    public $billingAddress;

    /**
     * Object(DeviceInfo)	Optional;
     */
    public $deviceInfo;

    /**
     * String(20000) Optional;
     * Metadata is used to store a merchant's internal reference information or arbitrary data based on the needs of merchants.
     * It is recommended to use the JSON format, and Akucicil will return the data in the query and callback of the order
     */
    public $metadata;

    /**
     * String(2000)	Optional;
     * Extend information, please use JSON format
     */
    public $extendInfo;

    /**
     * Integer	Optional;
     * When you request the installment-plan interface, get the "repaymentPeriod" parameter in the response,
     * please refer to https://akucicil.readme.io/reference/installment-plan#Installment
     */
    public $repaymentPeriod;


    public function __construct($configuration,$partnerOrderId)
    {
       $this->uri = str_replace("{{partnerOrderId}}",$partnerOrderId,$this->uri);
       parent::__construct($configuration);

    }

    protected function getPostData()
    {
        $postData = array(
            'userToken'=>$this->userToken,
            'partnerOrderId'=>$this->partnerOrderId,
            'partnerOrderAmount'=>$this->partnerOrderAmount,
            'purchaseCountry'=>$this->purchaseCountry,
            'currency'=>$this->currency,
            'currencyUnit'=>$this->currencyUnit,
            'redirectUrl'=>$this->redirectUrl,
            'callbackUrl'=>$this->callbackUrl,
            'expireTime'=>$this->expireTime,
            'buyer'=>SilvrrTool::objectToArray($this->buyer),
            'shipping'=>SilvrrTool::objectToArray($this->shipping),
            'items'=>SilvrrTool::objectToArray($this->items),
            'billingAddress'=>SilvrrTool::objectToArray($this->billingAddress),
            'metadata'=>$this->metadata,
            'extendInfo'=>$this->extendInfo,
            'repaymentPeriod'=>$this->repaymentPeriod
        );
        return $postData;
    }

    /**
     *
     * @return array|null
     */
    protected function getRequiredFields()
    {
        return array('partnerOrderId','partnerOrderAmount', 'purchaseCountry',
            'currency', 'currency','redirectUrl','buyer','shipping',
            'items','billingAddress'
        );
    }


}