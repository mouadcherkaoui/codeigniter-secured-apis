<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Entite extends Entity
{
	protected $id_Entite;
	protected $cd_prov;
	protected $EntiteAr;
	protected $EntiteFr;
	protected $id_type_entite;
	protected $Adresse;
	protected $Actif;
	protected $DateModification;

    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
