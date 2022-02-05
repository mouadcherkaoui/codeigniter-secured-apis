<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TypeEntite;

class TypeEntiteAPI extends ResourceController
{
    private $Type_EntiteRepo;
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->Type_EntiteRepo = new TypeEntite();
    }

    public function index()
    {
        $result = $this->Type_EntiteRepo->findAll();
        $resultToReturn = array();
        foreach($result as $item){
            $formated = $this->formatItem($item);
            array_push($resultToReturn, $formated);
        } 
        return $this->respond($resultToReturn, 200);    }

    public function show($id = null)
    {
        $result = $this->Type_EntiteRepo->where('id_type_entite', $id)->first();
        return $this->respond($result, 200);
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
            "id_type_entite" => 0,
            "type_entite_ar" => $body->type_entite_ar,
            "type_entite_fr" => $body->type_entite_fr,
            "actif" => $body->actif,          
            "date_modification" => $body->date_modification
        ];
        
        $id = $this->Type_EntiteRepo->insert($data);
        if($id) {
            $data['id_type_entite'] = $id;
            return $this->respondCreated($data);
        }
        else 
            return $this->respond($data, 400, 'something went wrong!');
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
            "id_type_entite" => $id,
            "type_entite_ar" => $body->type_entite_ar,
            "type_entite_fr" => $body->type_entite_fr,
            "actif" => $body->actif,          
            "date_modification" => $body->date_modification
        ];

        $success = $this->Type_EntiteRepo->update($id, $data);
        if($success) {
            $data['id_Type_Entite'] = $id;
            return $this->respondUpdated($data);
        }
        else 
            return $this->respond($data, 400, 'something went wrong!');
    }   
    
    public function delete($id = null)
    {
        $success = $this->Type_EntiteRepo->delete($id);
        if($success) {
            $data['id_type_entite'] = $id;
            return $this->respondDeleted($data);
        }
        else 
            return $this->respond($id, 400, 'something went wrong!');        
    }

    private function formatItem($item) {  
        return new class ($item){
            public $id_type_entite;
            public $type_entite_ar;
            public $type_entite_fr;
            public $actif;
            public $date_modification;
            public function __construct($item) {
                $this->id_type_entite = $this->value_or_default("id_type_entite", $item, "");
                $this->type_entite_ar = $this->value_or_default("type_entite_ar", $item, "");
                $this->type_entite_fr = $this->value_or_default("type_entite_fr", $item, "");
                $this->actif = $this->value_or_default("actif", $item, "");
                $this->date_modification = $this->value_or_default("date_modification", $item, "");
            }
            
            private function value_or_default($key, $item, $default){
                return array_key_exists($key, $item) ? $item[$key] : $default;
            }                        
        }; 
                                                    
    }

    private function getRules() {
        $rules = [
            "Type_EntiteAr" => "required|min_length[6]|max_length[50]",
            "Type_EntiteFr" => "required|min_length[6]|max_length[50]",          
            "Actif" => "required",                        
            "DateModification" => "required"                      
        ];

        $messages = [
            "Type_EntiteAr" => [
                "required" => "Type_EntiteAr is required",
                "min_length" => "Type_EntiteAr is not in format"
            ],
            "Type_EntiteFr" => [
                "required" => "Type_EntiteFr is required",
                "min_length" => "Type_EntiteFr is not in format"
            ],
            "Actif" => [
                "required" => "Actif is required",
                "min_length" => "Actif is not in format"
            ],                           
            "DateModification" => [
                "required" => "DateModification is required",
                "min_length" => "DateModification is not in format"
            ]                
        ];

        return [ 'rules' => $rules, 'messages' => $messages];
    }
}
