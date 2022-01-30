<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Region extends Entity
{
	protected $CD_REG;
	protected $LL_REG;
	protected $LA_REG;
	protected $Actif;
	protected $DateModification;
        
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
