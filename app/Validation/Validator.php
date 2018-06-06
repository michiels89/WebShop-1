<?php

namespace Cart\Validation;

use Cart\Validation\Contracts\ValidatorInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Exceptions\NestedValidationException;


class Validator implements ValidatorInterface
{
    public $errors = [];
    public function validate(Request $request, array $rules)
    {
        foreach($rules as $field => $rule) {
             try{
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
             }catch(NestedValidationException $e){
                 $this->errors[$field] = $e->getMessage();
             } 
        }
        
        return $this;
        
    }
    
    public function fails()
    {
       return !empty($this->errors);
    }
}