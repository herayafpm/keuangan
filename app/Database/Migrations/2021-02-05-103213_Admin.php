<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Admin extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'admin_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'admin_username'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
				'unique' 		 => true,
			],
			'admin_nama'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
			],
			'role_id' => [
				'type' => 'INT',
				'constraint'     => 11,
				'unsigned'          => TRUE,
			],
			'admin_password'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
			],
			'admin_keterangan'       => [
				'type'           => 'TEXT',
				'null'					=> true,
			],
			'admin_status'       => [
				'type'           => 'INT',
				'constraint'     => 11,
				'default'					=> 1,
			],
			'admin_created'       => [
				'type'           => 'TIMESTAMP',
				'default' => date('Y-m-d H:i:s')
			],
			'admin_updated'       => [
				'type'           => 'TIMESTAMP',
				'default' => date('Y-m-d H:i:s')
			],
		]);
		$this->forge->addKey('admin_id', true);
		$this->forge->addForeignKey('role_id', 'role', 'role_id');
		$this->forge->createTable('admin');
	}

	public function down()
	{
		$this->forge->dropTable('admin');
	}
}
