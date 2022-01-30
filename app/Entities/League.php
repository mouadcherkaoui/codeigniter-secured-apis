<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class League extends Entity
{
	protected $id_league;
	protected $LeagueFr;
	protected $LeagueAr;
	protected $Cd_Reg;
	protected $Actif;
	protected $DateModification;
        
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
