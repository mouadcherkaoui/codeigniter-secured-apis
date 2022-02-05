<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Activite;

class ActiviteAPI extends ResourceController
{
    private $activiteRepo;
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->activiteRepo = new Activite();
    }

    public function index()
    {
        $result = $this->activiteRepo->findAll();
        $resultToReturn = array();
        foreach($result as $item){
            $formated = $this->formatItem($item);
            array_push($resultToReturn, $formated);
        } 
        return $this->respond($resultToReturn, 200);
    }

    public function show($id = null)
    {
        $result = $this->activiteRepo->where('id_activite', $id)->first();
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
            $response = array(
                'message' => 'BAD_REQUEST', 
                'Errors' => $this->validator->getErrors() , 
                'rules' => $rules['rules']);

            return $this->respond($response , 400);
        }
        
        $body = $this->request->getJSON();

        $data = [
            "id_activite" => $body->id_activite ?? 0,
            "id_type_activite" => $body->id_type_activite,
            "id_personne" => $body->id_personne,
            "id_entite" => $body->id_entite,
            "id_annee" => $body->id_annee,
            "date_debut" => $body->date_debut,
            "date_fin" => $body->date_fin,
        ];

        $id = $this->activiteRepo->insert($data);
        if($id) {
            $data['id_activite'] = $id;
            return $this->respondCreated($data);
        }
        else 
            return $this->respond($data, 400, 'something went wrong!');
    }  
    
    public function update($id = null)
    {
        $rules = $this->getRules();
        if(!$this->validate($rules['rules'], $rules['messages'])) {
            $response = array(
                'message' => 'BAD_REQUEST', 
                'errors' => $this->validator->getErrors(),
                'rules' => $rules['rules']);
            return $this->respond($response, 400);
        }

        $body = $this->request->getJSON();        

        $data = [
            "id_activite" => $id,
            "id_type_activite" => $body->id_type_activite,
            "id_Personne" => $body->id_personne,
            "id_Entite" => $body->id_entite,
            "id_Annee" => $body->id_annee,
            "Date_Debut" => $body->date_debut,
            "Date_Fin" => $body->date_fin,
        ];

        $success = $this->activiteRepo->update($id, $data);
        if($success) {
            $data['id_activite'] = $id;
            return $this->respondUpdated($this->formatItem($data));
        }
        else 
            return $this->respond($this->formatItem($data), 400, 'something went wrong!');
    }   
    
    public function delete($id = null)
    {
        $success = $this->activiteRepo->delete($id);
        if($success) {
            return $this->respondDeleted(array('id_activite' => $id));
        }
        else 
            return $this->respond($id, 400, 'something went wrong!');        
    }
     
    private function formatItem($item) {
        return new class($item) {
            public $id_activite;            
            public $id_type_activite;
            public $id_entite;
            public $id_personne;
            public $id_annee;
            public $date_debut;
            public $date_fin;
            public function __construct($item){
                $this->id_activite = $this->value_or_default("id_activite", $item, "");                                            
                $this->id_type_activite = $this->value_or_default("id_type_activite", $item, "");                            
                $this->id_entite = $this->value_or_default("id_entite", $item, "");            
                $this->id_personne = $this->value_or_default("id_personne", $item, "");
                $this->id_annee = $this->value_or_default("id_annee", $item, "");
                $this->date_debut = $this->value_or_default("date_debut", $item, "");
                $this->date_fin = $this->value_or_default("date_fin", $item, "");            
            }
            
            private function value_or_default($key, $item, $default){
                return array_key_exists($key, $item) ? $item[$key] : $default;
            }
        };    
    }    
    private function getRules() {
        $rules = [
            "id_activite" => "required",
            "id_type_activite" => "required",
            "id_entite" => "required",
            "id_personne" => "required",  
            "id_annee" => "required",
            "date_debut" => "required",
            "date_fin" => "required"                                   
        ];

        $messages = [
            "id_type_activite" => [
                "required" => "id_activite is required",
                "min_length" => "id_activite is not in format"
            ],            
            "id_type_activite" => [
                "required" => "id_type_activite is required",
                "min_length" => "id_type_activite is not in format"
            ],
            "id_entite" => [
                "required" => "id_entite is required",
                "min_length" => "id_entite is not in format"
            ],
            "id_personne" => [
                "required" => "id_personne is required",
                "min_length" => "id_personne is not in format"
            ],
            "id_annee" => [
                "required" => "id_annee is required",
                "min_length" => "id_annee is not in format"
            ],        
            "date_debut" => [
                "required" => "date_debut is required",
                "min_length" => "date_debut is not in format"
            ],
            "date_fin" => [
                "required" => "date_fin is required",
                "min_length" => "date_fin is not in format"
            ]                                
        ];

        return [ 'rules' => $rules, 'messages' => $messages];
    }
}
