<?php

//namespace Silvrr\Exception;
class SilvrrInternalException extends Exception
{
    public function __construct($message = '', $code = 1)
    {
        parent::__construct($message, $code);
    }
}
