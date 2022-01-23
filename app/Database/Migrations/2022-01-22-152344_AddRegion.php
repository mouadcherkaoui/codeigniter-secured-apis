<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRegion extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'region_id'          => [
                'type'           => 'INT',
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
        $this->forge->addPrimaryKey('region_id', true);
        $this->forge->createTable('regions');    
    }

    public function down()
    {
        //
    }
}
