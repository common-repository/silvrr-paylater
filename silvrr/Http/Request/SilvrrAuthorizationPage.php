<?php
//namespace Silvrr\Http\Request;
require_once __DIR__.'/SilvrrRequestBase.php';


class SilvrrAuthorizationPage extends SilvrrRequestBase {

    protected  $uri = "/openpay/v1/{{apiKey}}/auth/authorization-page";

    protected  $method = "POST";

    /**
     * String(128)	Required;
     * The unique ID of the user in the partner application.
     */
    public $partnerUserId;

    /**
     * String(30)	Required;
     * Providing the mobile phone number will facilitate the user to identify the current account,
     */
    public $phoneNumber;

    public function __construct($configuration)
    {
        parent::__construct($configuration);
    }

    protected function getPostData()
    {
        $postData = array(
            'partnerUserId'=>$this->partnerUserId,
            'phoneNumber'=>$this->phoneNumber
        );
        return $postData;
    }

    /**
     *
     * @return array|null
     */
    protected function getRequiredFields()
    {
        return array('partnerUserId');
    }


}