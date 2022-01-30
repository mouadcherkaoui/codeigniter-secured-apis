<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Annee extends Entity
{
    protected $id_Annee;
    protected $Annee;
    
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
