<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransaksiPembayaran extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'transaksi_pembayaran_id'          => [
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
      'transaksi_pembayaran_bayar'       => [
        'type' => 'INT',
        'constraint'     => 11,
        'default' => 0
      ],
      'transaksi_pembayaran_by'       => [
        'type' => 'INT',
        'constraint'     => 11,
        'unsigned'          => TRUE,
      ],
      'transaksi_pembayaran_keterangan'       => [
        'type' => 'TEXT',
      ],
      'transaksi_pembayaran_created'       => [
        'type'           => 'TIMESTAMP',
        'default' => date('Y-m-d H:i:s')
      ],
    ]);
    $this->forge->addKey('transaksi_pembayaran_id', true);
    $this->forge->addForeignKey('transaksi_id', 'transaksi', 'transaksi_id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('transaksi_pembayaran_by', 'admin', 'admin_id');
    $this->forge->createTable('transaksi_pembayaran');
  }

  public function down()
  {
    $this->forge->dropTable('transaksi_pembayaran');
  }
}
