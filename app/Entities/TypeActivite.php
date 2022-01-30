<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class TypeActivite extends Entity
{
    protected $id_type_activite;
	protected $ActiviteAr;
	protected $ActiviteFr;
	protected $actif;
	protected $DateModification;
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
