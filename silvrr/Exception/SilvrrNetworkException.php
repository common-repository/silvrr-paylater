<?php


//namespace Silvrr\Exception;
class SilvrrNetworkException extends Exception
{
    public function __construct($message = '', $code = 3)
    {
        parent::__construct($message, $code);
    }
}
