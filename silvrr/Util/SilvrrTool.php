<?php

//namespace Silvrr\Util;
class SilvrrTool
{
    /**
     * @param null $timestamp
     * @return String:  string of ISO8601
     * @throws Exception
     */
    public static function timestampTo8601($timestamp=null)
    {
        $timestamp = empty($timestamp)?time():$timestamp;

        $datetime = new DateTime(date('Y-m-d H:i:s',$timestamp));

        return $datetime->format(DateTime::ATOM);
    }

    /**
     * @param $object
     * @return array,null
     *  convert an object to array
     */
    public static function objectToArray($object)
    {
        if(empty($object))
        {
            return "";
        }

        $arr = is_object($object)? get_object_vars($object):$object;

        foreach($arr as $k=>$v)
        {
            if(is_object($v))
            {
                $arr[$k]=self::objectToArray($v);
            }
            else if($v===null)
            {
                $arr[$k]="";
            }
        }
        return $arr;
    }

    /**
     * @return string
     * get an random String for reqId;
     */
    public static function genRandomReqId()
    {
        return md5(time()."".microtime());
    }

    /**
     * @param $method: get or post
     * @param $uri:
     * @param $apiKey
     * @param $reqId
     * @param $reqTime
     * @param $reqData
     * @param $privateKey
     * @return string
     * generate a signature using privateKey and SHA256
     */
    public static function genSignature($method,$uri,$apiKey,$reqId,$reqTime,$reqData,$privateKey)
    {
        $content = strtoupper($method).
              '|'.$uri.
              '|'.$apiKey.
              '|'.$reqId.
              '|'.$reqTime.'|';

        if(!empty($reqData))
        {
            $content.=$reqData;
        }

        $key = openssl_get_privatekey($privateKey);

        openssl_sign($content, $signature, $key, "SHA256");

        openssl_free_key($key);

        $sign = base64_encode($signature);

        return $sign;


    }
}