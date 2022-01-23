<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Trainee;

class TraineeAPI extends ResourceController
{
    private $traineeRepo;

    public function __construct(){
        $this->traineeRepo = new Trainee;
        $this->request = \Config\Services::request();
    }

    public function show($id = null)
    {
        $this->traineeRepo->where('trainee_id', $id)->first();
    }

    public function create()
    {
        $body = $this->request->getJSON();
        //$body = json_decode($jsonBody);
        $data = [
            'trainee_id' => $body->trainee_id,
            "firstname" => $body->firstname,
            "lastname" => $body->lastname,
            "address" => $body->address,
            "birthdate" => $body->birthdate,
            "phone" => $body->phone,
            "mobile" => $body->mobile,
            "club_id => $body->club_id"
        ];
        $this->traineeRepo->insert($data, true);

        return $this->respondCreated($data);
    }

    public function edit($id = null)
    {

    }

    public function delete($id = null)
    {

    }        
}
