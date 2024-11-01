<?php

//namespace Silvrr\Http\Request;
require_once __DIR__ . '/SilvrrRequestBase.php';

class SilvrrCancelUserToken extends SilvrrRequestBase
{
    protected $uri = "/openpay/v1/{{apiKey}}/auth/token/cancel";

    protected $method = "POST";

    /**
     * String(256)	Required;
     * the token value obtained on the user authorization process
     */
    public $userToken;

    /**
     * String(128)    Required;
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
            'userToken' => $this->userToken,
            'partnerUserId' => $this->partnerUserId,
        );
        return $postData;
    }

    /**
     *
     * @return array|null
     */
    protected function getRequiredFields()
    {
        return array('userToken', 'partnerUserId');
    }


}