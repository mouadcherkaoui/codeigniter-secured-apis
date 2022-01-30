<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Personne extends Entity
{
    protected $id_Personne;
    protected $Num_Pass;
    protected $NomAr;
    protected $NomFr;
    protected $PrenomAr;
    protected $PrenomFr;
    protected $Date_naiss;
    protected $Genre;
    protected $CIN;
    protected $photo;
    protected $DateModification;
    
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
