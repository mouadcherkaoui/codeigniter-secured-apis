<?php

namespace App\Entities;
use CodeIgniter\Entity\Entity;
class RegionEntity  
{
    protected $CD_Reg;
    protected $name;
    protected $description;
    protected $decorated;
    protected $db;
    public function __construct($decorated){
        $this->decorated = $decorated;
    }

    public function validate() {
        $this->sanitize_properties($this);
        return $this->decorated->validate($this);
    }

    function sanitize_properties($instance) {
        $reflection = new \ReflectionClass($instance);
         $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);
         foreach($properties as $property) {
            $value = $property->getValue($instance);
            $sanitized = filter_var($value, FILTER_SANITIZE_STRING);
            $property->setValue($instance, $sanitized);
         }
         return $instance;
    }
    
    function sanitize_body($body) {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($body));	
         foreach($iterator as $key=>$value) {
            $sanitized = filter_var($value, FILTER_SANITIZE_STRING);
            $body[$key] = $sanitized;
         }
         return $body;
    }
    public function getRules() {
        $rules = [
            "name" => "required|min_length[6]|max_length[50]",
            "description" => "required|min_length[10]|max_length[150]",
        ];

        $messages = [
            "name" => [
                "required" => "region name is required",
                "min_length" => "region name is not in format"
            ],
            "description" => [
                "required" => "region description is required",
                "min_length" => "region name is not in format"
            ],
        ];

        return [ 'rules' => $rules, 'messages' => $messages];
    }
}
