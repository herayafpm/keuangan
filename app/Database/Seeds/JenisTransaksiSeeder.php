<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JenisTransaksiSeeder extends Seeder
{
  public function run()
  {
    $initDatas = [
      [
        "jenis_transaksi_nama" => "Pembayaran Infak",
        "jenis_transaksi_harga" => 10000000
      ],
      [
        "jenis_transaksi_nama" => "LKS",
        "jenis_transaksi_harga" => 20000000
      ],
      [
        "jenis_transaksi_nama" => "Daftar Ulang untuk kelas VII",
        "jenis_transaksi_harga" => 30000000
      ],
      [
        "jenis_transaksi_nama" => "Ujian",
        "jenis_transaksi_harga" => 40000000
      ],
      [
        "jenis_transaksi_nama" => "Studi Tour untuk kelas VIII",
        "jenis_transaksi_harga" => 50000000
      ],
    ];
    $this->db->table('jenis_transaksi')->insertBatch($initDatas);
  }
}
