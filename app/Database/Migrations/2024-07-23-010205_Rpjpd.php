<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rpjpd extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_rpjpd' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tahun_awal' => [
                'type'       => 'YEAR',
            ],
            'tahun_akhir' => [
                'type' => 'YEAR',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
        ]);
        $this->forge->addKey('id_rpjpd', true);
        $this->forge->createTable('rpjpd_tb');
    }

    public function down()
    {
        $this->forge->dropTable('rpjpd_tb');
    }
}
