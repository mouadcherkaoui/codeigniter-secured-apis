<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Annee;


class AnneeAPI extends ResourceController
{
    private $anneeRepo;
    private $anneeEntity;
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->anneeRepo = new Annee();
    }

    public function index()
    {
        $result = $this->anneeRepo->findAll();
        $resultToReturn = array();
        foreach($result as $item){
            $formated = $this->formatItem($item);
            array_push($resultToReturn, $formated);
        }
        return $this->respond($resultToReturn, 200);
    }

    public function show($id = null)
    {
        $result = $this->anneeRepo->where('id_annee', $id)->first();
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
            return $this->respond(array('message' => 'BAD_REQUEST', 'rules' => $rules['rules']), 400);
        }
        
        $body = $this->request->getJSON();

        $data = [
            "id_Annee" => $body->id_annee,
            "Annee" => $body->annee,
        ];
        
        $id = $this->anneeRepo->insert($data);
        if($id) {
            $data['id_Annee'] = $id;
            return $this->respondCreated($this->formatItem($data));
        }
        else 
            return $this->respond($this->formatItem($data), 400, 'something went wrong!');
    }  
    
    public function update($id = null)
    {
        $rules = $this->getRules();
        if(!$this->validate($rules['rules'], $rules['messages'])) {
            return $this->respond(array('message' => 'BAD_REQUEST', 'rules' => $rules['rules']), 400);
        }

        $body = $this->request->getJSON();        
        
        $data = [
            'id_Annee' => $body->id_annee,
            "Annee" => $body->annee,
        ];

        $success = $this->anneeRepo->update($id, $data);
        if($success) {
            $data['id_Annee'] = $id;
            return $this->respondUpdated($this->formatItem($data));
        }
        else 
            return $this->respond($this->formatItem($data), 400, 'something went wrong!');
    }   
    
    public function delete($id = null)
    {
        $success = $this->anneeRepo->delete($id);
        if($success) {
            return $this->respondDeleted(array('id_annee' => $id));
        }
        else 
            return $this->respond($id, 400, 'something went wrong!');        
    }
    
    private function formatItem($item){
        return new class($item){
            public $id_annee;
            public $annee;
            public function __construct($item){
                $this->id_annee = $this->value_or_default("id_Annee", $item, "");
                $this->annee = $this->value_or_default("Annee", $item, "");                
            }
            
            private function value_or_default($key, $item, $default) {
                return array_key_exists($key, $item) ? $item[$key] : $default;
            }
        };
    }
    
    private function getRules() {
        $rules = [
            "id_annee" => "required",          
            "annee" => "required"
        ];

        $messages = [
            "id_annee" => [
                "required" => "id_annee is required",
            ],              
            "annee" => [
                "required" => "annee is required",
            ]            
        ];

        return [ 'rules' => $rules, 'messages' => $messages];
    }
}
