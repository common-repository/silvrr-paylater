<?php
////namespace Silvrr\Model;
require_once __DIR__.'/SilvrrModelBase.php';
require_once __DIR__.'/SilvrrSeller.php';

class SilvrrItem extends SilvrrModelBase {
    public function __construct($categoryId="",$skuId="",$skuName="",$unitPrice="",$qty="",$categoryName="",$pictureUrl="",$type="",$seller=null)
    {
        $this->categoryId = $categoryId;
        $this->skuId = $skuId;
        $this->skuName = $skuName;
        $this->unitPrice = $unitPrice;
        $this->qty = $qty;
        $this->categoryName = $categoryName;
        $this->pictureUrl = $pictureUrl;
        $this->type = $type;
        $this->seller = $seller;
    }

    /**
     * Stirng(128) Required;
     */
    public $categoryId;


    public $categoryName;

    /**
     * String(128) Required;
     */
    public $skuId;

    /**
     * String(255) Required;
     */
    public $skuName;

    /**
     * Int Required;
     * unit price, format:ISO:4217
     */
    public $unitPrice;


    /**
     * Int Required;
     * purchase quantity;
     */
    public $qty;

    /**
     * String(2000)  Optional;
     */
    public $pictureUrl;

    /**
     * String Optional;
     * Item Type: PhysicalGood, TaxFee, ShippingFee;
     */
    public $type;

    /**
     * Object Seller  Optional;
     */
    public $seller;

    protected function getRequiredFields()
    {
        return array("categoryId","skuId","skuName","unitPrice","qty");
    }


}

