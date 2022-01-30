<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Region;
use App\Entities\RegionEntity;

class RegionAPI extends ResourceController
{
    private $regionRepo;
    private $regionEntity;
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->regionRepo = new Region();
        $region = new Region;        
    }

    public function index()
    {
        $result = $this->regionRepo->findAll();
        return $this->respond($result, 200);
    }

    public function show($id = null)
    {
        $result = $this->regionRepo->where('CD_REG', $id)->first();
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
            'CD_REG' => $body->CD_REG,
            "LL_REG" => $body->LL_REG,
            "LA_REG" => $body->LA_REG,
            "Actif" => $body->Actif,
            "DateModification" => $body->DateModification
        ];
        
        $id = $this->regionRepo->insert($data);
        if($id) {
            $data['CD_REG'] = $id;
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
            'CD_REG' => $id,
            "LL_REG" => $body->LL_REG,
            "LA_REG" => $body->LA_REG,
            "Actif" => $body->Actif,
            "DateModification" => $body->DateModification
        ];

        $success = $this->regionRepo->update($id, $data);
        if($success) {
            $data['CD_REG'] = $id;
            return $this->respondUpdated($data);
        }
        else 
            return $this->respond($data, 400, 'something went wrong!');
    }   
    
    public function delete($id = null)
    {
        $success = $this->regionRepo->delete($id);
        if($success) {
            $data['CD_REG'] = $id;
            return $this->respondDeleted($data);
        }
        else 
            return $this->respond($id, 400, 'something went wrong!');        
    }
    private function getRules() {
        $rules = [
            "CD_REG" => "required|max_length[2]",
            "LL_REG" => "required|max_length[35]",
            "LA_REG" => "required|max_length[35]",
            "Actif" => "required",
            "DateModification" => "required"
        ];

        $messages = [
            "CD_REG" => [
                "required" => "CD_REG name is required",
                "max_length" => "CD_REG name is not in format"
            ],
            "LL_REG" => [
                "required" => "LL_REG description is required",
                "max_length" => "LL_REG name is not in format"
            ],
            "LA_REG" => [
                "required" => "LA_REG description is required",
                "max_length" => "LA_REG name is not in format"
            ],
                        
            "Actif" => [
                "required" => "Actif is required",
                "max_length" => "Actif is not in format"
            ],        
            "DateModification" => [
                "required" => "DateModification is required",
                "max_length" => "DateModification is not in format"
            ]               
        ];

        return [ 'rules' => $rules, 'messages' => $messages];
    }
}
