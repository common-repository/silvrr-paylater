<?php
////namespace Silvrr\Model;
require_once __DIR__.'/SilvrrModelBase.php';
class SilvrrBuyer extends SilvrrModelBase {
    public function __construct($buyerId="",$birthDate="",$gender="",$name="")
    {
        $this->buyerId = $buyerId;
        $this->birthDate = $birthDate;
        $this->gender = $gender;
        $this->name = $name;
    }


    /**
     * String(127) Required;
     * Buyer account ID, each user should be unique ID;
     */
    public $buyerId;

    /**
     * String(20) Optional;
     * Buyer’s phone number. In E.164; +6281212345678
     */
    public $buyerPhone;

    /**
     * String(100)	Optional;
     * Buyer email
     */
    public $buyerEmail;

    /**
     * Int Optional;
     * Registration duration, the unit is daily. example, 180
     */
    public $registrationDays;

    /**
     * String(10) Optional;
     * Buyer's birthdate;
     * @example  1988-03-05
     */
    public $birthDate;


    /**
     * String(6) Optional;
     * @example  Male,Female;
     */
    public $gender;

    /**
     * String(255) Optional;
     * Appellation for the buyer;
     */
    public $name;

    protected function getRequiredFields()
    {
        return array("buyerId");
    }

}