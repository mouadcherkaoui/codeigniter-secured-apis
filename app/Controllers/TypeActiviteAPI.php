<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TypeActivite;

class TypeActiviteAPI extends ResourceController
{
    private $TypeActiviteRepo;
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->TypeActiviteRepo = new TypeActivite();
    }

    public function index()
    {
        $result = $this->TypeActiviteRepo->findAll();
        return $this->respond($result, 200);
    }

    public function show($id = null)
    {
        $result = $this->TypeActiviteRepo->where('id_Type_Activite', $id)->first();
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
            "id_type_activite" => 0,
            "type_activite_ar" => $body->type_activite_ar,
            "type_activite_fr" => $body->type_activite_fr,
            "actif" => $body->actif,          
            "date_modification" => $body->date_modification
        ];
        
        $id = $this->TypeActiviteRepo->insert($data);
        if($id) {
            $data['id_type_activite'] = $id;
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
            "id_Type_Activite" => 0,
            "type_activite_ar" => $body->type_activite_ar,
            "type_activite_fr" => $body->type_activite_fr,
            "actif" => $body->actif,          
            "date_modification" => $body->date_modification
        ];

        $success = $this->TypeActiviteRepo->update($id, $data);
        if($success) {
            $data['id_type_activite'] = $id;
            return $this->respondUpdated($data);
        }
        else 
            return $this->respond($data, 400, 'something went wrong!');
    }   
    
    public function delete($id = null)
    {
        $success = $this->TypeActiviteRepo->delete($id);
        if($success) {
            $data['id_type_activite'] = $id;
            return $this->respondDeleted($data);
        }
        else 
            return $this->respond($id, 400, 'something went wrong!');        
    }
    private function getRules() {
        $rules = [
            "type_activite_ar" => "required|min_length[6]|max_length[50]",
            "type_activite_fr" => "required|min_length[6]|max_length[50]",          
            "actif" => "required",                        
            "date_modification" => "required"                      
        ];

        $messages = [
            "type_activite_ar" => [
                "required" => "type_activite_ar is required",
                "min_length" => "type_activite_ar is not in format"
            ],
            "type_activite_fr" => [
                "required" => "type_activite_fr is required",
                "min_length" => "type_activite_fr is not in format"
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
