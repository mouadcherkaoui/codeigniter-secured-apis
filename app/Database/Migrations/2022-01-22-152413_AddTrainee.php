<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTrainee extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'trainee_id'          => [
                'type'           => 'INT',
                'null'           => false,
                'auto_increment' => true,
            ],
            'firstname'       => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'lastname'       => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],            
            'address'       => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],   
            'phone'       => [
                'type'       => 'VARCHAR',
                'constraint' => '12',
            ], 
            'mobile'       => [
                'type'       => 'VARCHAR',
                'constraint' => '12',
            ], 
            'birthdate'       => [
                'type'       => 'DATETIME',
            ],
            'club_id' => [
                'type' => 'INT',
                'null'           => false
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
        $this->forge->addPrimaryKey('trainee_id', true);
        $this->forge->addForeignKey('club_id', 'clubs', 'club_id');
        $this->forge->createTable('trainees');         
    }

    public function down()
    {
        //
    }
}
