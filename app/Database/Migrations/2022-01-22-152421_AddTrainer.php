<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTrainer extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'trainer_id'          => [
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
            'league_id'       => [
                'type'          => 'INT', 
                'null'           => false,           
            ]
        ]);
        $this->forge->addPrimaryKey('trainer_id', true);
        $this->forge->addForeignKey('league_id', 'leagues', 'league_id');
        $this->forge->createTable('trainers');    
    }

    public function down()
    {
        //
    }
}
