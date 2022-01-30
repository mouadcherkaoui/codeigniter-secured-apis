<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Province;

class ProvinceAPI extends ResourceController
{
    private $provinceRepo;
    private $provinceEntity;
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->provinceRepo = new Province();
        $province = new province;        
    }

    public function index()
    {
        $result = $this->provinceRepo->findAll();
        $resultToReturn = array();
        foreach($result as $item){
            $formated = $this->formatItem($item);
            array_push($resultToReturn, $formated);
        }
        return $this->respond($resultToReturn, 200);
    }

    public function show($id = null)
    {
        $result = $this->provinceRepo->where('CD_REG', $id)->first();
        if($result != null){
            $resultToReturn = $this->formatItem($result);
            return $this->respond($resultToReturn, 200);            
        }
        
        return $this->respond(array('message' => 'Not FOUND'), 404);    

    }

    public function create()
    {
        $rules = $this->getRules();
        if(!$this->validate($rules['rules'], $rules['messages'])) {
            $response = array('message' => 'BAD_REQUEST',
                'errors' => $this->validator->getErrors(),
                'rules' => $rules['rules']);
            return $this->respond($response, 400);
        }
        
        $body = $this->request->getJSON();

        $data = [
            'CD_PROV' => $body->code_province,
            'CD_REG' => $body->code_region,            
            "LL_PROV" => $body->ll_province,
            "LA_PROV" => $body->la_province,
            "Actif" => $body->actif,
            "DateModification" => $body->date_modification
        ];
        
        $id = $this->provinceRepo->insert($data);
        if($id) {
            $data['CD_REG'] = $id;
            return $this->respondCreated($this->formatItem($data));
        }
        else 
            return $this->respond($this->formatItem($data), 400, 'something went wrong!');
    }  
    
    public function update($id = null)
    {
        $rules = $this->getRules();
        if(!$this->validate($rules['rules'], $rules['messages'])) {
            $response = array('message' => 'BAD_REQUEST', 
                'errors' => $this->validator->getErrors(),
                'rules' => $rules['rules']);
            return $this->respond($response, 400);
        }

        $body = $this->request->getJSON();        

        $data = [
            'CD_PROV' => $body->code_province,
            'CD_REG' => $body->code_region,            
            "LL_PROV" => $body->ll_province,
            "LA_PROV" => $body->la_province,
            "Actif" => $body->actif,
            "DateModification" => $body->date_modification
        ];

        $success = $this->provinceRepo->update($id, $data);
        if($success) {
            $data['CD_REG'] = $id;
            return $this->respondUpdated($this->formatItem($data));
        }
        else 
            return $this->respond($this->formatItem($data), 400, 'something went wrong!');
    }   
    
    public function delete($id = null)
    {
        $success = $this->provinceRepo->delete($id);
        if($success) {
            return $this->respondDeleted(array( 'code_province' => $id));
        }
        else 
            return $this->respond($id, 400, 'something went wrong!');        
    }
    
        private function formatItem($item) {
        return new class($item) {
            public $code_province;
            public $code_region;
            public $ll_province;
            public $la_province;
            public $actif;
            public $date_modification;
            public function __construct($item){
                $this->code_province = $this->value_or_default("CD_PROV", $item, "");      
                $this->code_region = $this->value_or_default("CR_REG", $item, "");                      
                $this->ll_province = $this->value_or_default("LL_PROV", $item, "");            
                $this->la_province = $this->value_or_default("LA_PROV", $item, "");                            
                $this->actif = $this->value_or_default("Actif", $item, "");
                $this->date_modification = $this->value_or_default("DateModification", $item, "");
            }
            
            private function value_or_default($key, $item, $default){
                return array_key_exists($key, $item) ? $item[$key] : $default;
            }
        };    
    }
    
    private function getRules() {
        $rules = [
            "code_province" => "required|max_length[2]",            
            "code_region" => "required|max_length[2]",
            "ll_province" => "required|max_length[35]",
            "la_province" => "required|max_length[35]",
            "actif" => "required",
            "date_modification" => "required"
        ];

        $messages = [
            "code_province" => [
                "required" => "code_province is required",
                "max_length" => "code_province is not in format"
            ],            
            "code_region" => [
                "required" => "code_region is required",
                "max_length" => "code_region is not in format"
            ],
            "ll_province" => [
                "required" => "ll_province is required",
                "max_length" => "ll_province is not in format"
            ],
            "la_province" => [
                "required" => "la_province is required",
                "max_length" => "la_province is not in format"
            ],
                        
            "aActif" => [
                "required" => "Actif is required",
                "max_length" => "Actif is not in format"
            ],        
            "date_modification" => [
                "required" => "date_modification is required",
                "max_length" => "date_modification is not in format"
            ]               
        ];

        return [ 'rules' => $rules, 'messages' => $messages];
    }
}
