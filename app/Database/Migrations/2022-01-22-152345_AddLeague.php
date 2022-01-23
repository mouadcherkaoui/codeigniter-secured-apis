<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\Database;

class AddLeague extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'league_id'          => [
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
            'region_id'          => [
                'type'       => 'INT',
                'null'           => false,
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
        $this->forge->addPrimaryKey('league_id', true);
        $this->forge->addForeignKey('region_id', 'regions', 'region_id');
        $this->forge->createTable('leagues');   
    }

    public function down()
    {
        //
    }
}
