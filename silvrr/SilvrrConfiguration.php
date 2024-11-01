<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2022/5/16
 * Time: 9:31
 */
class SilvrrConfiguration{

    public $platform = "";

    public $apiKey = "";

    public $privateKey= "";

    public $privateKeyVersion = "1.0";

    public $platformVersion = '1.0';

    public function __construct($apiKey,$privateKey,$privateKeyVersion,$platform,$platformVersion=1.0)
    {
        $this->apiKey = $apiKey;
        $this->privateKey = $privateKey;
        $this->privateKeyVersion = $privateKeyVersion;
        $this->platform = $platform;
        $this->platformVersion = $platformVersion;
    }

}
