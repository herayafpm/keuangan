<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitSeeder extends Seeder
{
	public function run()
	{
		$this->call('RoleSeeder');
		$this->call('AdminSeeder');
		$this->call('JenisTransaksiSeeder');
		$this->call('SiswaSeeder');
	}
}
