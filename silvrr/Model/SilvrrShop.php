<?php
////namespace Silvrr\Model;
require_once __DIR__.'/SilvrrModelBase.php';
class SilvrrShop extends SilvrrModelBase
{
   public function __construct($shopId="",$shopName="",$gps="")
   {
       $this->shopId = $shopId;
       $this->shopName = $shopName;
       $this->gps = $gps;
   }

    /**
    * String(127) Required
    */
   public $shopId;

   /**
     * String(127) Required
    */
   public $shopName;

   /**
     * String(127) Required
   */
   public $gps;

    protected function getRequiredFields()
    {
        return array("shopId","shopName","gps");
    }
}