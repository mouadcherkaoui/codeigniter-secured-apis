<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Activite extends Entity
{
    protected $id_Activite;
    protected $id_Type_Activite;
    protected $id_Personne;
    protected $id_Entite;
    protected $id_Annee;
    protected $Date_Debut;
    protected $Date_Fin;
    
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
