<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
	public function run()
	{
		$initDatas = [
			[
				"role_nama" => "super admin",
			],
			[
				"role_nama" => "petugas TU",
			],
		];
		$this->db->table('role')->insertBatch($initDatas);
	}
}
