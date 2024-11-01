<?php

require_once __DIR__.'/SilvrrModelBase.php';
class SilvrrShipping extends SilvrrModelBase {

    public function __construct($receiverName="",$receiverPhone="",$countryCode="",$region="",$city="",$postcode="",$addressLine="",$district="",$street="")
    {
        $this->receiverName = $receiverName;
        $this->receiverPhone = $receiverPhone;
        $this->countryCode = $countryCode;
        $this->region = $region;
        $this->city = $city;
        $this->postcode = $postcode;
        $this->addressLine = $addressLine;
        $this->district = $district;
        $this->street = $street;
    }

    /**
     * String(100) Required;
     */
   public $receiverName;

    /**
     * String(20) Required;
     * phone number , in E.164, for example +8613500000000
     */
   public $receiverPhone;

    /**
     * String(3) Required;
     */
   public $countryCode;

    /**
     * String(100) Required;
     * state,province or region
     */
   public $region;

    /**
     * String(100) Required;
     */
   public $city;

    /**
     * String(100) Optional;
     */
   public $district;

    /**
     * String(100) Optional;
     */
   public $street;

    /**
     * String(100) Required;
     */
   public $postcode;

    /**
     * String(100) Required;
     * street, building number or house number;
     */
   public $addressLine;



    protected function getRequiredFields()
    {
        return array("receiverName","receiverPhone","countryCode","city","region","postcode","addressLine");
    }

}