<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SiswaLog extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'siswa_log_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'siswa_nis'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
			],
			'siswa_log_at'       => [
				'type'           => 'TIMESTAMP'
			],
		]);
		$this->forge->addKey('siswa_log_id', true);
		$this->forge->createTable('siswa_log');
	}

	public function down()
	{
		$this->forge->dropTable('siswa_log');
	}
}
