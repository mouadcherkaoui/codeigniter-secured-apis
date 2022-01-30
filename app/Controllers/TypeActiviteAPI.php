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
            "id_Type_Activite" => 0,
            "ActiviteAr" => $body->ActiviteAr,
            "ActiviteFr" => $body->ActiviteFr,
            "Actif" => $body->Actif,          
            "DateModification" => $body->DateModification
        ];
        
        $id = $this->TypeActiviteRepo->insert($data);
        if($id) {
            $data['id_Type_Activite'] = $id;
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
            "ActiviteAr" => $body->ActiviteAr,
            "ActiviteFr" => $body->ActiviteFr,
            "Actif" => $body->Actif,          
            "DateModification" => $body->DateModification
        ];

        $success = $this->TypeActiviteRepo->update($id, $data);
        if($success) {
            $data['id_Type_Activite'] = $id;
            return $this->respondUpdated($data);
        }
        else 
            return $this->respond($data, 400, 'something went wrong!');
    }   
    
    public function delete($id = null)
    {
        $success = $this->TypeActiviteRepo->delete($id);
        if($success) {
            $data['id_Type_Activite'] = $id;
            return $this->respondDeleted($data);
        }
        else 
            return $this->respond($id, 400, 'something went wrong!');        
    }
    private function getRules() {
        $rules = [
            "ActiviteAr" => "required|min_length[6]|max_length[50]",
            "ActiviteFr" => "required|min_length[6]|max_length[50]",          
            "Actif" => "required",                        
            "DateModification" => "required"                      
        ];

        $messages = [
            "ActiviteAr" => [
                "required" => "ActiviteAr is required",
                "min_length" => "ActiviteAr is not in format"
            ],
            "ActiviteFr" => [
                "required" => "ActiviteFr is required",
                "min_length" => "ActiviteFr is not in format"
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
