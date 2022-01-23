<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClub extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'club_id'          => [
                'type'           => 'INT',
                'null'           => false,
                'auto_increment' => true,
            ],
            'name'       => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],            
            'description'       => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ], 
            'league_id'  => [
                'type'       => 'INT',
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
        $this->forge->addPrimaryKey('club_id', true);
        $this->forge->addForeignKey('league_id', 'leagues', 'league_id');    
        $this->forge->createTable('clubs');    
    }

    public function down()
    {
        //
    }
}
