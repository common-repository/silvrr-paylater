<?php
////namespace Silvrr\Model;
require_once __DIR__.'/SilvrrModelBase.php';
class SilvrrSeller extends SilvrrModelBase {


    public function __construct($sellerId="",$sellerName="")
    {
        $this->sellerId = $sellerId;
        $this->sellerName = $sellerName;
    }

    /**
     * string(127) required
     */
   public $sellerId;

   /**
    *  String(255)	required
    */
   public $sellerName;



    protected function getRequiredFields()
    {
        return array("sellerId","sellerName");
    }

}