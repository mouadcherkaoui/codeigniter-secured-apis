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
        $this->regionEntity = new RegionEntity($this);
        $region = new Region;        
    }

    public function index()
    {
        $result = $this->regionRepo->findAll();
        return $this->respond($result, 200);
    }

    public function show($id = null)
    {
        $result = $this->regionRepo->where('region_id', $id)->first();
        return $this->respond($result, 200);
    }

    public function create()
    {
        $rules = $this->getRules();
        if(!$this->validate($rules['rules'], $rules['messages'])) {
            return $this->respond(array('message' => 'BAD_REQUEST'), 400);
        }
        
        $body = $this->request->getJSON();

        $data = [
            'region_id' => 0,
            "name" => $body->name,
            "description" => $body->description,
        ];
        $id = $this->regionRepo->insert($data);
        if($id) {
            $data['region_id'] = $id;
            return $this->respondCreated($data);
        }
        else 
            return $this->respond($data, 400, 'something went wrong!');
    }  
    
    public function update($id = null)
    {
        $rules = $this->getRules();
        if(!$this->validate($rules['rules'], $rules['messages'])) {
            return $this->respond(array('message' => 'BAD_REQUEST'), 400);
        }

        $body = $this->request->getJSON();        

        $data = [
            'region_id' => $id,
            "name" => $body->name,
            "description" => $body->description,
        ];


        $success = $this->regionRepo->update($id, $data);
        if($success) {
            $data['region_id'] = $id;
            return $this->respondUpdated($data);
        }
        else 
            return $this->respond($data, 400, 'something went wrong!');
    }   
    
    public function delete($id = null)
    {
        $success = $this->regionRepo->delete($id);
        if($success) {
            $data['region_id'] = $id;
            return $this->respondDeleted($data);
        }
        else 
            return $this->respond($id, 400, 'something went wrong!');        
    }
    private function getRules() {
        $rules = [
            "name" => "required|min_length[6]|max_length[50]",
            "description" => "required|min_length[10]|max_length[150]",
        ];

        $messages = [
            "name" => [
                "required" => "region name is required",
                "min_length" => "region name is not in format"
            ],
            "description" => [
                "required" => "region description is required",
                "min_length" => "region name is not in format"
            ],
        ];

        return [ 'rules' => $rules, 'messages' => $messages];
    }
}
