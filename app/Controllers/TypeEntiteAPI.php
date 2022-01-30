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
        $result = $this->Type_EntiteRepo->where('id_Type_Entite', $id)->first();
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
            "id_Type_Entite" => 0,
            "Type_EntiteAr" => $body->type_entite_ar,
            "Type_EntiteFr" => $body->type_entite_fr,
            "Actif" => $body->actif,          
            "DateModification" => $body->date_modification
        ];
        
        $id = $this->Type_EntiteRepo->insert($data);
        if($id) {
            $data['id_Type_Entite'] = $id;
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
            "id_Type_Entite" => $id,
            "Type_EntiteAr" => $body->type_entite_ar,
            "Type_EntiteFr" => $body->type_entite_fr,
            "Actif" => $body->actif,          
            "DateModification" => $body->date_modification
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
            $data['id_Type_Entite'] = $id;
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
                $this->id_type_entite = $this->value_or_default("id_Type_Entite", $item, "");
                $this->type_entite_ar = $this->value_or_default("Type_EntiteAr", $item, "");
                $this->type_entite_fr = $this->value_or_default("Type_EntiteFr", $item, "");
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
