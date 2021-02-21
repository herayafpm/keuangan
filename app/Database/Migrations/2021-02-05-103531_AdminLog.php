<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AdminLog extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'admin_log_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'admin_username'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
			],
			'admin_log_at'       => [
				'type'           => 'TIMESTAMP'
			],
		]);
		$this->forge->addKey('admin_log_id', true);
		$this->forge->createTable('admin_log');
	}

	public function down()
	{
		$this->forge->dropTable('admin_log');
	}
}
