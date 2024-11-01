<?php
////namespace Silvrr\Model;
require_once __DIR__.'/SilvrrModelBase.php';
class SilvrrUserToken extends SilvrrModelBase{
    /**
     * String(127) Required;
     * partnerUserId = Buyer.buyerId
     */
   public $partnerUserid;

    /**
     * String(255) Required;
     * User Token
     */
   public $token;

    /**
     * String(64) Required;
     * Token Expire Time, in IOS_8601 format;
     */
   public $tokenExpireTime;

    protected function getRequiredFields()
    {
        return array("partnerUserid","token","tokenExpireTime");
    }
}