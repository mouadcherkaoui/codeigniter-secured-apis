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
            "GradeAr" => $body->GradeAr,
            "GradeFr" => $body->GradeFr,
            "Actif" => $body->Actif,          
            "DateModification" => $body->DateModification
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
            "GradeAr" => $body->GradeAr,
            "GradeFr" => $body->GradeFr,
            "Actif" => $body->Actif,          
            "DateModification" => $body->DateModification
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
            "GradeAr" => "required|min_length[6]|max_length[50]",
            "GradeFr" => "required|min_length[6]|max_length[50]",          
            "Actif" => "required",                        
            "DateModification" => "required"                      
        ];

        $messages = [
            "GradeAr" => [
                "required" => "GradeAr is required",
                "min_length" => "GradeAr is not in format"
            ],
            "GradeFr" => [
                "required" => "GradeFr is required",
                "min_length" => "GradeFr is not in format"
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
