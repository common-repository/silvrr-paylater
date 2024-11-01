<?php
/**
 * https://silvrr-pay.readme.io/reference/get-user-credit-info
 */

//namespace Silvrr\Http\Request;
require_once __DIR__.'/SilvrrRequestBase.php';

class SilvrrUserCreditInfo extends SilvrrRequestBase {

    protected  $uri = "/openpay/v1/{{apiKey}}/auth/user-info";

    protected  $method = "POST";

    /**
     * String	Required;
     * the token value obtained on the user authorization process
     */
    public $userToken;


    public function __construct($configuration)
    {
        parent::__construct($configuration);
    }

    protected function getPostData()
    {
        return array('userToken'=>$this->userToken);
    }
    /**
     *
     * @return array|null
     */
    protected function getRequiredFields()
    {
        return array('userToken');
    }


}
