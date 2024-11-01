<?php
require_once __DIR__."/../Exception/SilvrrNetworkException.php";
require_once __DIR__."/../Util/SilvrrTool.php";

////namespace Silvrr\Http

class SilvrrHttpRequest
{
    private $sdkVersion="1.0";

    public $uri;

    public $method;

    protected $domain = "https://oapi.silvrr.com";//"https://test-oapi.wisecartapp.com"; //正式环境  https://oapi.silvrr.com

    protected $headers = array("Content-Type"=>"application/json","Accept"=>"application/json");

    protected $ch;

    protected $reqTime;

    protected $privateKeyVersion = "1.0";

    protected  $postData;


    public function __construct($uri,$apiKey, $reqId,$method,$reqTime,$privateKeyVersion="1.0")
    {
        $this->uri = $uri;

        $this->reqTime = $reqTime;

        $this->method = $method;

        $this->privateKeyVersion = $privateKeyVersion;

        $this->addHeader("X-OP-ApiKey",$apiKey);

        $this->addHeader("X-OP-ReqId",$reqId);

        $this->addHeader("X-OP-ReqTime",$this->reqTime);

        $this->addHeader("Sdk-Version",$this->sdkVersion);

        $this->initCurl();
    }


    /**
     * init curl;
     */
    public function initCurl()
    {


      //  $this->ch = curl_init();

     //   curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);

    //    curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);

     //   curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);

        if($this->method=='POST')
        {

           // curl_setopt($this->ch, CURLOPT_POST, 1);
        }

      //


    }

    /**
     * @param $signature
     * set the signature header of current request;
     */
    public function setSignature($signature)
    {

        $this->addHeader("Signature","alg=RSA256,keyVersion=".$this->privateKeyVersion.",signature=".$signature);
    }


    /**a
     * @param $data: Json
     */
    public function setData($dataJson)
    {
        if(strtoupper($this->method)=="POST")
        {
            $this->postData = json_decode($dataJson,true);
           // curl_setopt($this->ch, CURLOPT_POSTFIELDS, $dataJson);
        }
        else
        {
            //curl_setopt($this->ch,CURLOPT_CUSTOMREQUEST,'GET');
            //curl_setopt($this->ch, CURLOPT_POSTFIELDS, $dataJson);
        }

    }

    /**
     * @param $headerStr: for example: "My-Header:XXX";
     */
    public function addHeader($key,$val)
    {

        $this->headers[$key] = $val;
    }

    public function execute()
    {

        $args     = array(
            'method' => $this->method,
            'body'        => json_encode($this->postData),
            'timeout'     => '20',
            'headers'     => $this->headers
        );
        $output = wp_remote_request( $this->domain.$this->uri, $args );

        return $output['body'];

    }

}