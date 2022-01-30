<?php

namespace App\Libraries;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class MaxLength
{
    public $rule_name = "max_length";
    public $rule;
    public $message;

    public function __construct($length, $message) {
        $this->rule = "$this->rule_name[$length]";
        $this->message = array($this->rule_name => $message);  
    }
}
