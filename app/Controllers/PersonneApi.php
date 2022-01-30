<?php

namespace App\Controllers;


use CodeIgniter\RESTful\ResourceController;
use App\Models\Personne;

class PersonneAPI extends ResourceController
{
    private $personneRepo;
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->personneRepo = new Personne();
    }

    public function index()
    {
        $result = $this->personneRepo->findAll();
        $resultToReturn = array();
        foreach($result as $item){
            $formated = $this->formatItem($item);
            array_push($resultToReturn, $formated);
        } 
        return $this->respond($resultToReturn, 200);
    }

    public function show($id = null)
    {
        $result = $this->personneRepo->where('id_personne', $id)->first();
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
            "id_personne" => $body->id_personne,
            "Num_Pass" => $body->num_pass,
            "NomAr" => $body->nom_ar,
            "NomFr" => $body->nom_fr,
            "PrenomAr" => $body->prenom_ar,
            "PrenomFr" => $body->prenom_fr,
            "Date_naiss" => $body->date_naiss,
            "CIN" => $body->cin,
            "Genre" => $body->genre,
            "photo" => $body->photo,            
            "DataModification" => $body->data_modification
        ];
        
        $id = $this->personneRepo->insert($data);
        if($id) {
            $data['id_personne'] = $id;
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
            "id_personne" => $body->id_personne,
            "Num_Pass" => $body->num_pass,
            "NomAr" => $body->nom_ar,
            "NomFr" => $body->nom_fr,
            "PrenomAr" => $body->prenom_ar,
            "PrenomFr" => $body->prenom_fr,
            "Date_naiss" => $body->date_naiss,
            "CIN" => $body->cin,
            "Genre" => $body->genre,
            "photo" => $body->photo,            
            "DataModification" => $body->data_modification
        ];

        $success = $this->personneRepo->update($id, $data);
        if($success) {
            $data['id_personne'] = $id;
            return $this->respondUpdated($this->formatItem($data));
        }
        else 
            return $this->respond($this->formatItem($data), 400, 'something went wrong!');
    }   
    
    public function delete($id = null)
    {
        $success = $this->personneRepo->delete($id);
        if($success) {
            return $this->respondDeleted(array( 'id_personne' => $id));
        }
        else 
            return $this->respond($id, 400, 'something went wrong!');        
    }
    
    private function formatItem($item) {  
        return new class ($item){
            public $id_personne;
            public $nom_ar;
            public $nom_fr;
            public $prenom_ar;
            public $prenom_fr;
            public $num_pass;  
            public $date_naiss;
            public $cin;
            public $genre;
            public $photo;
            public $data_modification;
            public function __construct($item) {
                $this->id_personne = $this->value_or_default("id_Personne", $item, "");
                $this->nom_ar = $this->value_or_default("NomAr", $item, "");
                $this->nom_fr = $this->value_or_default("NomFr", $item, "");
                $this->prenom_ar = $this->value_or_default("PrenomAr", $item, "");
                $this->prenom_fr = $this->value_or_default("PrenomFr", $item, "");
                $this->num_pass = $this->value_or_default("Num_Pass", $item, "");  
                $this->date_naiss = $this->value_or_default("Date_naiss", $item, "");
                $this->cin = $this->value_or_default("CIN", $item, "");
                $this->genre = $this->value_or_default("Genre", $item, ""); 
                $this->data_modification = $this->value_or_default("DataModification", $item, "");                 
            }
            
            private function value_or_default($key, $item, $default){
                return array_key_exists($key, $item) ? $item[$key] : $default;
            }                        
        }; 
                                                    
    }
        
    private function getRules() {
        $rules = [
            "id_personne" => "required",            
            "nom_ar" => "required|min_length[4]|max_length[50]",
            "nom_fr" => "required|min_length[4]|max_length[50]",
            "prenom_ar" => "required|min_length[4]|max_length[50]",            
            "prenom_fr" => "required|min_length[4]|max_length[50]",
            "num_pass" => "required",  
            "date_naiss" => "required",
            "cin" => "required",  
            "genre" => "required",            
            "photo" => "required",                        
            "data_modification" => "required"                      
        ];

        $messages = [
            "id_personne" => [
                "required" => "id_personne is required",
                "min_length" => "id_personne is not in format"
            ],            
            "nom_ar" => [
                "required" => "nom_ar is required",
                "min_length" => "nom_ar is not in format"
            ],
            "nom_fr" => [
                "required" => "nom_fr is required",
                "min_length" => "nom_fr is not in format"
            ],
            "prenom_ar" => [
                "required" => "prenom_ar is required",
                "min_length" => "prenom_ar is not in format"
            ],
            "prenom_fr" => [
                "required" => "prenom_fr is required",
                "min_length" => "prenom_fr is not in format"
            ],            
            "num_pass" => [
                "required" => "num_pass is required",
                "min_length" => "num_pass is not in format"
            ],
            "date_naiss" => [
                "required" => "date_naiss is required",
                "min_length" => "date_naiss is not in format"
            ],
            "cin" => [
                "required" => "cin is required",
                "min_length" => "cin is not in format"
            ],
            "genre" => [
                "required" => "genre is required",
                "min_length" => "genre is not in format"
            ],  
            "photo" => [
                "required" => "photo is required",
                "min_length" => "photo is not in format"
            ],                             
            "data_modification" => [
                "required" => "data_modification is required",
                "min_length" => "data_modification is not in format"
            ]                
        ];

        return [ 'rules' => $rules, 'messages' => $messages];
    }
}
