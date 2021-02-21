<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JenisTransaksi extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'jenis_transaksi_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'jenis_transaksi_nama'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
			],
			'jenis_transaksi_harga'       => [
				'type'           => 'INT',
				'constraint'     => 11,
				'default'			=> 0
			],
		]);
		$this->forge->addKey('jenis_transaksi_id', true);
		$this->forge->createTable('jenis_transaksi');
	}

	public function down()
	{
		$this->forge->dropTable('jenis_transaksi');
	}
}
