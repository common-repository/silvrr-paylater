<?php
//namespace Silvrr\Http\Request;

require_once __DIR__."/../../Exception/SilvrrInvalidArgumentException.php";
require_once __DIR__."/../../Model/SilvrrModelBase.php";
require_once __DIR__."/../SilvrrHttpRequest.php";
require_once __DIR__.'/../../SilvrrConfiguration.php';

class SilvrrRequestBase{

    protected  $uri = "";

    protected  $apiKey = "";

    protected  $reqId = "";

    protected  $method = "POST";

    protected  $privateKey = "";

    protected  $reqTime = "";

    protected  $privateKeyVersion = "1.0";

    protected  $request;

    protected $platform ;

    protected $platformVersion;

    public function __construct($configuration)
    {

        $this->apiKey = $configuration->apiKey;

        $this->privateKey = $configuration->privateKey;

        $this->privateKeyVersion = $configuration->privateKeyVersion;

        $this->platform = $configuration->platform;

        $this->platformVersion = $configuration->platformVersion;

        $this->reqId = SilvrrTool::genRandomReqId();

        $this->uri = str_replace("{{apiKey}}",$this->apiKey,$this->uri);

        $this->reqTime = SilvrrTool::timestampTo8601();

        $this->request = new SilvrrHttpRequest($this->uri,$this->apiKey,$this->reqId,$this->method,$this->reqTime,$this->privateKeyVersion);

        $this->request->addHeader('op-platform',$this->platform);
        $this->request->addHeader('op-platform-version',$this->platformVersion);



    }
    public function request()
    {
        //$this->validate();

        $data = $this->getPostData();

        $dataJson = empty($data)?"":json_encode($data);

        $signature = SilvrrTool::genSignature($this->method,$this->uri,$this->apiKey,$this->reqId,$this->reqTime,$dataJson,$this->privateKey);

        $this->request->setSignature($signature);

        $this->request->setData($dataJson);


        return $this->request->execute();
    }

    /**
     * @return null|array
     * Get the array data that will be taken as request body for current http request;
     */
    protected function getPostData()
    {
        return null;
    }

    /**
     * @throws SilvrrInvalidArgumentException
     * validate current Object
     */
    public function validate()
    {
        /*
        $requiredFields = $this->getRequiredFields();

        if(empty($this->apiKey))
        {
            throw new SilvrrInvalidArgumentException("apiKey can not be empty");
        }

        if(empty($this->privateKey))
        {
            throw new SilvrrInvalidArgumentException("privateKey can not be empty");
        }


        if($requiredFields && count($requiredFields)>0)
        {
            foreach($requiredFields as $field)
            {
                if($this->$field===null || $this->$field==="")
                {
                    throw new SilvrrInvalidArgumentException("Parameter ".$field. " of Class ".get_class($this)." is required");
                }
                else if(is_object($this->$field) && $this->$field instanceof SilvrrModelBase){
                    ($this->$field)->validate();
                }
                else if(is_array($this->$field))
                {
                    foreach($this->$field as $item)
                    {
                        if(is_object($item) && $item instanceof SilvrrModelBase)
                        {
                            $item->validate();
                        }
                    }
                }

            }
        }*/
    }

    /**
     * @return null|array
     * get the required fields that function validate() will validate
     */
    protected function getRequiredFields()
    {
        return null;
    }


}