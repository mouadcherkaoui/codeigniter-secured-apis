<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\League;

class LeagueAPI extends ResourceController
{
    private $leagueRepo;
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->leagueRepo = new League();
    }

    public function index()
    {
        $result = $this->leagueRepo->findAll();
        $resultToReturn = array();
        foreach($result as $item){
            $formated = $this->formatItem($item);
            array_push($resultToReturn, $formated);
        }
        return $this->respond($resultToReturn, 200);
    }

    public function show($id = null)
    {
        $result = $this->leagueRepo->where('id_league', $id)->first();
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
            "id_league" => $body->id_league ?? 0,
            "leagueAr" => $body->league_ar,
            "leagueFr" => $body->league_fr,
            "Cd_Reg" => $body->code_region,
            "Actif" => $body->actif,
            "DateModification" => $body->date_modification
        ];
        $id = $this->leagueRepo->insert($data);
        if($id) {
            $data['id_league'] = $id;
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
            "id_league" => $id,
            "league_ar" => $body->league_ar,
            "league_fr" => $body->league_fr,
            "code_region" => $body->code_region,
            "actif" => $body->actif,
            "date_modification" => $body->date_modification
        ];

        $success = $this->leagueRepo->update($id, $data);
        if($success) {
            $data['id_league'] = $id;
            return $this->respondUpdated($this->formatItem($data));
        }
        else 
            return $this->respond($this->formatItem($data), 400, 'something went wrong!');
    }   
    
    public function delete($id = null)
    {
        $success = $this->leagueRepo->delete($id);
        if($success) {
            return $this->respondDeleted(array('id_league' => $id));
        }
        else 
            return $this->respond($id, 400, 'something went wrong!');        
    }
    
    private function formatItem($item) {  
        return new class ($item){
            public $id_league;
            public $league_ar;
            public $league_fr;
            public $code_region;
            public $actif;
            public $date_modification;
            public function __construct($i) {
                $this->id_league = $this->value_or_default("id_league", $i, "");
                $this->league_ar = $this->value_or_default("league_ar", $i, "");
                $this->league_fr = $this->value_or_default("league_fr", $i, "");
                $this->code_region = $this->value_or_default("code_regino", $i, "");
                $this->actif = $this->value_or_default("actif", $i, "");  
                $this->date_modification = $this->value_or_default("date_modification", $i, "");                 
            }
            
            private function value_or_default($key, $item, $default){
                return array_key_exists($key, $item) ? $item[$key] : $default;
            }            
        }; 
                                                    
    }
        
    private function getRules() {
        $rules = [
            "id_league" => "required",
            "league_ar" => "required|min_length[6]|max_length[50]",
            "league_fr" => "required|min_length[6]|max_length[150]",
            "code_region" => "required",  
            "actif" => "required",
            "date_modification" => "required"                      
        ];

        $messages = [
            "id_league" => [
                "required" => "id_league is required",
                "min_length" => "id_league is not in format"
            ],            
            "league_ar" => [
                "required" => "league_ar is required",
                "min_length" => "league_ar is not in format"
            ],
            "league_fr" => [
                "required" => "league_fr is required",
                "min_length" => "league_fr is not in format"
            ],
            "code_region" => [
                "required" => "code_region is required",
                "min_length" => "code_region is not in format"
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
