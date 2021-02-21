<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'siswa';
	protected $primaryKey           = 'siswa_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['siswa_nis', 'siswa_nama', 'siswa_alamat', 'siswa_password'];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'siswa_created';
	protected $updatedField         = 'siswa_updated';
	protected $deletedField         = '';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = ['hashPassword'];
	protected $afterInsert          = [];
	protected $beforeUpdate         = ['hashPassword'];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];
	protected function hashPassword(array $data)
	{
		if (!isset($data['data']['siswa_password'])) return $data;
		$data['data']['siswa_password'] = password_hash($data['data']['siswa_password'], PASSWORD_DEFAULT);
		return $data;
	}
	public function filter($limit, $start, $orderBy, $ordered, $params = [])
	{
		$builder = $this->db->table($this->table);
		$builder->orderBy($orderBy, $ordered);
		if ($limit > 0) {
			$builder->limit($limit, $start);
		}
		$builder->select("{$this->table}.*");
		if (isset($params['where'])) {
			$builder->where($params['where']);
		}
		if (isset($params['like'])) {
			foreach ($params['like'] as $key => $value) {
				$builder->like($key, $value);
			}
		}
		$datas = $builder->get()->getResultArray();
		return $datas;
	}
	public function count_all($params = [])
	{
		$builder = $this->db->table($this->table);
		$builder->select("{$this->table}.*");
		if (isset($params['where'])) {
			$builder->where($params['where']);
		}
		if (isset($params['like'])) {
			foreach ($params['like'] as $key => $value) {
				$builder->like($key, $value);
			}
		}
		return $builder->countAllResults();
	}
	public function authenticate($nis, $password)
	{
		$auth = $this->where('siswa_nis', $nis)->first();
		if ($auth) {
			if (password_verify($password, $auth['siswa_password'])) {
				$siswaLogModel = new SiswaLogModel();
				$siswaLogModel->save(['siswa_nis' => $auth['siswa_nis']]);
				return $auth;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function findByNIS($nis)
	{
		return $this->where('siswa_nis', $nis)->first();
	}
}
