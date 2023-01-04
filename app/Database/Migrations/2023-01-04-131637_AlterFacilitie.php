<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterFacilitie extends Migration
{
    public function up()
    {
        $this->forge->addColumn('facilitie', [
            'created_by INT(5) UNIQUE'
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('facilitie', 'created_by');
    }
}
