<?php

//namespace Silvrr\Exception;
class SilvrrInvalidArgumentException extends Exception
{
    public function __construct($message = '', $code = 2)
    {
        parent::__construct($message, $code);
    }
}
