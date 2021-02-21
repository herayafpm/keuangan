<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaksi extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'transaksi_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'siswa_id'       => [
				'type' => 'INT',
				'constraint'     => 11,
				'unsigned'          => TRUE,
			],
			'transaksi_status'       => [
				'type' => 'INT',
				'constraint'     => 11,
				'default' => 0
			],
			'transaksi_status_at'       => [
				'type'           => 'TIMESTAMP',
				'null'				=> true
			],
			'transaksi_by'       => [
				'type' => 'INT',
				'constraint'     => 11,
				'unsigned'          => TRUE,
				'null'					=> true
			],
			'transaksi_created'       => [
				'type'           => 'TIMESTAMP',
				'default' => date('Y-m-d H:i:s')
			],
		]);
		$this->forge->addKey('transaksi_id', true);
		$this->forge->addForeignKey('siswa_id', 'siswa', 'siswa_id');
		$this->forge->addForeignKey('transaksi_by', 'admin', 'admin_id');
		$this->forge->createTable('transaksi');
	}

	public function down()
	{
		$this->forge->dropTable('transaksi');
	}
}
