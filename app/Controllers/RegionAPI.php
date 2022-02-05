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
            'code_region' => $body->code_region,
            "ll_region" => $body->ll_region,
            "la_region" => $body->la_region,
            "actif" => $body->actif,
            "date_modification" => $body->date_modification
        ];
        
        $id = $this->regionRepo->insert($data);
        if($id) {
            $data['code_region'] = $id;
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
            'code_region' => $id,
            "ll_region" => $body->ll_region,
            "la_region" => $body->la_region,
            "actif" => $body->actif,
            "date_modification" => $body->date_modification
        ];

        $success = $this->regionRepo->update($id, $data);
        if($success) {
            $data['code_region'] = $id;
            return $this->respondUpdated($data);
        }
        else 
            return $this->respond($data, 400, 'something went wrong!');
    }   
    
    public function delete($id = null)
    {
        $success = $this->regionRepo->delete($id);
        if($success) {
            $data['code_region'] = $id;
            return $this->respondDeleted($data);
        }
        else 
            return $this->respond($id, 400, 'something went wrong!');        
    }
    private function getRules() {
        $rules = [
            "code_region" => "required|max_length[2]",
            "ll_region" => "required|max_length[35]",
            "la_region" => "required|max_length[35]",
            "actif" => "required",
            "date_modification" => "required"
        ];

        $messages = [
            "code_region" => [
                "required" => "code_region name is required",
                "max_length" => "code_region name is not in format"
            ],
            "ll_region" => [
                "required" => "ll_region description is required",
                "max_length" => "ll_region name is not in format"
            ],
            "la_region" => [
                "required" => "la_region description is required",
                "max_length" => "la_region name is not in format"
            ],
                        
            "actif" => [
                "required" => "actif is required",
                "max_length" => "actif is not in format"
            ],        
            "date_modification" => [
                "required" => "date_modification is required",
                "max_length" => "date_modification is not in format"
            ]               
        ];

        return [ 'rules' => $rules, 'messages' => $messages];
    }
}
