<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Province extends Entity
{
	protected $CD_PROV;
	protected $CD_REG;
	protected $LL_PROV;
	protected $LA_PROV;
	protected $Actif;
	protected $DateModification;    
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
