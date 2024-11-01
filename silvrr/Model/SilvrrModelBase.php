<?php

//namespace Silvrr\Model;
require_once __DIR__.'/SilvrrModelBase.php';
class SilvrrModelBase
{
    /**
     * @throws SilvrrInvalidArgumentException
     * validate current object's required fields;
     */
    public function validate()
    {
        $requiredFields = $this->getRequiredFields();
        if($requiredFields && count($requiredFields)>0)
        {
            foreach($requiredFields as $field)
            {
                if($this->$field===null || $this->$field==="")
                {
                    throw new SilvrrInvalidArgumentException("Parameter ".$field. " of Class ".get_class($this)." is required");
                }
            }
        }
    }

    /**
     * @return null|array
     * get the reauired fields for function validate() to validate;
     */
    protected function getRequiredFields()
    {
        return null;
    }
}