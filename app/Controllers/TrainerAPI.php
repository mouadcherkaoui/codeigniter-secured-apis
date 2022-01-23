<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Trainer;

class TrainerAPI extends ResourceController
{

    private $trainerRepo;
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->trainerRepo = new Trainer();
    }
    public function index()
    {
        //
    }

    public function create()
    {
        $body = $this->request->getJSON();
        //$body = json_decode($jsonBody);
        $data = [
            'trainer_id' => $body->trainer_id,
            "firstname" => $body->firstname,
            "lastname" => $body->lastname,
            "address" => $body->address,
            "birthdate" => $body->birthdate,
            "phone" => $body->phone,
            "mobile" => $body->mobile,
            "league_id => $body->league_id"
        ];
        //$this->traineeRepo->insert()
        return $this->respondCreated($data);
    }
}
