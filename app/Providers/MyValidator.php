<?php namespace App\Providers;
 
use Illuminate\Validation\Validator;
 
class MyValidator extends Validator {
 
    public function validateEmptyWith($attribute, $value, $parameters)
    {
        return false;
    }
 
}