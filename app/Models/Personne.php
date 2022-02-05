<?php

namespace App\Models;

use CodeIgniter\Model;

class Personne extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'Personne';
    protected $primaryKey       = 'id_personne';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "id_personne",
        "num_pass",
        "nom_ar",
        "nom_fr",
        "prenom_ar",
        "prenom_fr",
        "date_naissance",
        "cin",
        "genre",
        "photo",            
        "date_modification"
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
