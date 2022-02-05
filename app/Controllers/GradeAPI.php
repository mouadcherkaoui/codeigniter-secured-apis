<?php

namespace App\Controllers;


use CodeIgniter\RESTful\ResourceController;
use App\Models\Grade;

class GradeAPI extends ResourceController
{
    private $gradeRepo;
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->gradeRepo = new Grade();
    }

    public function index()
    {
        $result = $this->gradeRepo->findAll();
        return $this->respond($result, 200);
    }

    public function show($id = null)
    {
        $result = $this->gradeRepo->where('id_grade', $id)->first();
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
            "id_grade" => 0,
            "grade_ar" => $body->GradeAr,
            "grade_fr" => $body->GradeFr,
            "actif" => $body->Actif,          
            "date_modification" => $body->DateModification
        ];
        
        $id = $this->gradeRepo->insert($data);
        if($id) {
            $data['id_grade'] = $id;
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
            "id_grade" => 0,
            "grade_ar" => $body->grade_ar,
            "grade_fr" => $body->grade_fr,
            "actif" => $body->Actif,          
            "date_modification" => $body->date_modification
        ];

        $success = $this->gradeRepo->update($id, $data);
        if($success) {
            $data['id_grade'] = $id;
            return $this->respondUpdated($data);
        }
        else 
            return $this->respond($data, 400, 'something went wrong!');
    }   
    
    public function delete($id = null)
    {
        $success = $this->gradeRepo->delete($id);
        if($success) {
            $data['id_grade'] = $id;
            return $this->respondDeleted($data);
        }
        else 
            return $this->respond($id, 400, 'something went wrong!');        
    }
    private function getRules() {
        $rules = [
            "grade_ar" => "required|min_length[6]|max_length[50]",
            "grade_fr" => "required|min_length[6]|max_length[50]",          
            "actif" => "required",                        
            "date_modification" => "required"                      
        ];

        $messages = [
            "grade_ar" => [
                "required" => "grade_ar is required",
                "min_length" => "grade_ar is not in format"
            ],
            "grade_fr" => [
                "required" => "grade_fr is required",
                "min_length" => "grade_fr is not in format"
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
