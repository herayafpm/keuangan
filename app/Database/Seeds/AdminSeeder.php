<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
	public function run()
	{
		$password = password_hash(env('passwordDefault'), PASSWORD_DEFAULT);
		$date = date('Y-m-d H:i:s');
		$initDatas = [
			[
				"admin_username" => "superadmin",
				"admin_nama" => "Super Admin",
				"role_id" => 1,
				'admin_password' => $password,
				'admin_created' => $date,
				'admin_updated' => $date,
			],
			[
				"admin_username" => "tu",
				"admin_nama" => "Petugas TU",
				"role_id" => 2,
				'admin_password' => $password,
				'admin_created' => $date,
				'admin_updated' => $date,
			],
		];
		$this->db->table('admin')->insertBatch($initDatas);
	}
}
