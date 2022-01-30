<?php

namespace App\Libraries;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class RuleAttribute
{
    public $rule;
    public $message;

    public function __construct($rule, $message) {
        $this->rule = $rule;
        $this->message = $message;
    }    
}
