<?php
//namespace Silvrr\Http\Request;
require_once __DIR__.'/SilvrrRequestBase.php';

class SilvrrExchangeUserToken extends SilvrrRequestBase{

    protected  $uri = "/openpay/v1/{{apiKey}}/auth/token";

    protected  $method = "POST";

    /**
     * String(1024)	Required;
     * The authorization code obtained after the user agrees to the authorization. You can get the auth_code from redirect_url request parameters.
     */
    public $authCode;

    /**
     * String(128)	Required;
     * The unique ID of the user in the partner application. You can provide encrypted value, but you need to make sure it is a unique identifier for the user
     */
    public $partnerUserId;

    public function __construct($configuration)
    {
        parent::__construct($configuration);
    }

    protected function getPostData()
    {
        $postData = array(
            'authCode'=>$this->authCode,
            'partnerUserId'=>$this->partnerUserId,
        );
        return $postData;
    }

    /**
     *
     * @return array|null
     */
    protected function getRequiredFields()
    {
        return array('authCode','partnerUserId');
    }


}