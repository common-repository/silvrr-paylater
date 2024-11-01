<?php

////namespace Silvrr\Model;
require_once __DIR__.'/SilvrrModelBase.php';
class SilvrrBillingAddress extends SilvrrModelBase {


    public function __construct($firstName="",$lastName="",$countryCode="",$city="",$region="",$postcode = "",$addressLine="",$email="",$street="",$title="")
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->countryCode = $countryCode;
        $this->city = $city;
        $this->region = $region;
        $this->postcode = $postcode;
        $this->addressLine = $addressLine;
        $this->email = $email;
        $this->street = $street;
        $this->title = $title;
    }

    /**
     * String(64) Required;
     */
     public $firstName;

    /**
     * String(64) Required;
     */
     public $lastName;



    /**
     * String(64) Required;
     * follow ISO 3166 alpha-2
     */
    public $countryCode;

    /**
     * String(64) Required;
     * City name;
     */
     public $city;

    /**
     * String(64) Required;
     */
     public $region;

    /**
     * String(64) Optional;
     */
     public $street;

    /**
     * String(10) Required;
     */
     public $postcode;


    /**
     * String(255) Required;
     * street or building or house number;
     */
     public $addressLine;


    /**
     * String(64) Required;
     */
     public $email;

    /**
     * String(255) Optional;
     * The title of billing details;
     */
     public $title;

    protected function getRequiredFields()
    {
        return array("firstName","lastName","countryCode","city","region","postcode","addressLine","email");
    }

}