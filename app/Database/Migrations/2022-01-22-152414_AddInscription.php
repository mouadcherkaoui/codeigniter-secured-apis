<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddInscription extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'inscription_id'          => [
                'type'           => 'INT',
                'null'           => false,
                'auto_increment' => true,
            ],
            'trainee_id'       => [
                'type'       => 'INT',
            ],            
            'club_id'       => [
                'type'       => 'INT',
            ], 
            'date_inscription' => [
                'type'       => 'DATETIME',
            ],
            'created_at'        => [
                'type'       => 'DATETIME'
            ],           
            'updated_at'        => [
                'type'       => 'DATETIME'
            ],                       
            'deleted_at'        => [
                'type'       => 'DATETIME'
            ]                       
        ]);
        $this->forge->addPrimaryKey('inscription_id', true);
        $this->forge->addForeignKey('trainee_id', 'trainees', 'trainee_id');        
        $this->forge->addForeignKey('club_id', 'clubs', 'club_id');                
        $this->forge->createTable('inscriptions');    
    }

    public function down()
    {
        //
    }
}
