<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Grade extends Entity
{
	protected $id_Grade;
	protected $GradeAr;
	protected $GradeFr;
	protected $Actif;
	protected $DateModification;

    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
