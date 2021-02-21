<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SiswaSeeder extends Seeder
{
  public function run()
  {
    $password = password_hash(env('passwordDefault'), PASSWORD_DEFAULT);
    $date = date('Y-m-d H:i:s');
    $initDatas = [
      [
        "siswa_nis" => "2001",
        "siswa_nama" => "Heraya",
        "siswa_alamat" => "Banjarnegara",
        'siswa_password' => $password,
        'siswa_created' => $date,
        'siswa_updated' => $date,
      ],
      [
        "siswa_nis" => "tu",
        "siswa_nis" => "2002",
        "siswa_nama" => "Fitra",
        "siswa_alamat" => "Jawa Tengah",
        'siswa_password' => $password,
        'siswa_created' => $date,
        'siswa_updated' => $date,
      ],
    ];
    $this->db->table('siswa')->insertBatch($initDatas);
  }
}
