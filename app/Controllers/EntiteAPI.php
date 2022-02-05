<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Entite;

class EntiteAPI extends ResourceController
{
    private $entiteRepo;
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->entiteRepo = new Entite();
    }

    public function index()
    {
        $result = $this->entiteRepo->findAll();
        $resultToReturn = array();
        foreach($result as $item){
            $formated = $this->formatItem($item);
            array_push($resultToReturn, $formated);
        }
        return $this->respond($resultToReturn, 200);
    }

    public function show($id = null)
    {
        $result = $this->entiteRepo->where('id_Entite', $id)->first();
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
            "id_Entite" => $body->id_entite ?? 0,
            "id_type_entite" => $body->id_type_entite,            
            "cd_prov" => $body->code_province,
            "entiteAr" => $body->entite_ar,
            "entiteFr" => $body->entite_fr,
            "Adresse" => $body->adresse,            
            "Actif" => $body->actif,
            "DateModification" => $body->date_modification
        ];

        $id = $this->entiteRepo->insert($data);
        if($id) {
            $data['id_Entite'] = $id;
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
            "id_Entite" => $id,
            "id_type_entite" => $body->id_type_entite,            
            "cd_prov" => $body->code_province,
            "entite_ar" => $body->entite_ar,
            "entite_fr" => $body->entite_fr,
            "adresse" => $body->adresse,            
            "actif" => $body->actif,
            "date_modification" => $body->date_modification
        ];

        $success = $this->entiteRepo->update($id, $data);
        if($success) {
            $data['id_Entite'] = $id;            
            return $this->respondUpdated($this->formatItem($data));
        }
        else 
            return $this->respond($this->formatItem($data), 400, 'something went wrong!');
    }   
    
    public function delete($id = null)
    {
        $success = $this->entiteRepo->delete($id);
        if($success) {
            return $this->respondDeleted(array('id_entite' => $id));
        }
        else 
            return $this->respond($id, 400, 'something went wrong!');        
    }
    
    private function formatItem($item) {
        return new class($item) {
            public $id_entite;
            public $id_type_entite;
            public $code_province;
            public $entite_ar;
            public $entite_fr;
            public $adresse;
            public $actif;
            public $date_modification;
            public function __construct($item){
                $this->id_entite = $this->value_or_default("id_entite", $item, "");            
                $this->id_type_entite = $this->value_or_default("id_type_entite", $item, "");                            
                $this->code_province = $this->value_or_default("code_province", $item, "");
                $this->entite_ar = $this->value_or_default("entite_ar", $item, "");
                $this->entite_fr = $this->value_or_default("entite_fr", $item, "");
                $this->adresse = $this->value_or_default("adresse", $item, "");            
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
            "id_entite" => "required",            
            "entite_ar" => "required|max_length[50]",
            "entite_fr" => "required|max_length[150]",
            "id_type_entite" => "required",  
            "actif" => "required",
            "date_modification" => "required"                      
        ];

        $messages = [
            "id_entite" => [
                "required" => "id_entite is required",
                "min_length" => "id_entite is not in format"
            ],                        
            "entite_ar" => [
                "required" => "entite_ar is required",
                "min_length" => "entite_ar is not in format"
            ],
            "entite_fr" => [
                "required" => "entite_fr is required",
                "min_length" => "entite_fr is not in format"
            ],
            "id_type_entite" => [
                "required" => "id_type_entite is required",
                "min_length" => "id_type_entite is not in format"
            ],
            "actif" => [
                "required" => "actif is required",
                "min_length" => "actif is not in format"
            ],        
            "date_modification" => [
                "required" => "date_modification is required",
                "min_length" => "date_modification is not in format"
            ]                
        ];

        return [ 'rules' => $rules, 'messages' => $messages];
    }
}
