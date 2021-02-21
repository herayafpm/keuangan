<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransaksiItem extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'transaksi_item_id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'transaksi_id'       => [
				'type' => 'INT',
				'constraint'     => 11,
				'unsigned'          => TRUE,
			],
			'jenis_transaksi_id'       => [
				'type' => 'INT',
				'constraint'     => 11,
				'unsigned'          => TRUE,
			],
			'transaksi_item_harga'       => [
				'type' => 'INT',
				'constraint'     => 11,
				'default' => 0
			],
		]);
		$this->forge->addKey('transaksi_item_id', true);
		$this->forge->addForeignKey('transaksi_id', 'transaksi', 'transaksi_id');
		$this->forge->addForeignKey('jenis_transaksi_id', 'jenis_transaksi', 'jenis_transaksi_id');
		$this->forge->createTable('transaksi_item');
	}

	public function down()
	{
		$this->forge->dropTable('transaksi_item');
	}
}
