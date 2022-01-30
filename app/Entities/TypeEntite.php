<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class TypeEntite extends Entity
{
	protected $id_type_entite;
	protected $Type_EntiteAr;
	protected $Type_EntiteFr;
	protected $Actif;
	protected $DateModification;
        
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
