<?php
require_once __DIR__.'/SilvrrRequestBase.php';
require_once __DIR__."/../../Util/SilvrrTool.php";
require_once __DIR__."/../../Model/SilvrrItem.php";
require_once __DIR__."/../../Model/SilvrrBuyer.php";

////namespace Silvrr\Http\Request;
class SilvrrInstallmentPlan extends SilvrrRequestBase {

    protected  $uri = "/openpay/v1/{{apiKey}}/checkout/installment-plan";

    protected  $method = "POST";

    /**
     * String	Optional;
     * Akucicil User Token
     */
    public $userToken;

    /**
     * Integer	Required;
     * The user needs to pay the amount
     */
    public $partnerOrderAmount;

    /**
     * String	Required	Currency;
     */
    public $currency;

    /**
     * Object(Buyer)	Required;
     * Buyer information. Providing buyer information will help to obtain a more accurate installment plan, which will greatly improve the user experience
     */
    public $buyer;

    /**
     * Array(Item)	Required.
     * order items list.
     */
    public $items;


    public function __construct($configuration)
    {
       parent::__construct($configuration);
    }

    protected function getPostData()
    {
        $postData = array(
            'userToken'=>$this->userToken,
            'partnerOrderAmount'=>$this->partnerOrderAmount,
            'currency'=>$this->currency,
            'buyer'=>SilvrrTool::objectToArray($this->buyer),
            'items'=>SilvrrTool::objectToArray($this->items)
        );
        return $postData;
    }

    /**
     * @return array|null
     */
    protected function getRequiredFields()
    {
        return array(
            'partnerOrderAmount',
            'currency',
            'items'
        );
    }


}