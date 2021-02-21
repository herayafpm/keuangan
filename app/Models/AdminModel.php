<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'admin';
	protected $primaryKey           = 'admin_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['admin_username', 'admin_nama', 'role_id', 'admin_password', 'admin_keterangan', 'admin_status'];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'admin_created';
	protected $updatedField         = 'admin_updated';
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
		if (!isset($data['data']['admin_password'])) return $data;
		$data['data']['admin_password'] = password_hash($data['data']['admin_password'], PASSWORD_DEFAULT);
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
		$builder->select("role.*");
		$builder->join('role', "role.role_id = {$this->table}.role_id", 'LEFT');
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
		$builder->select("role.*");
		$builder->join('role', "role.role_id = {$this->table}.role_id", 'LEFT');
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
	public function getAdmin($admin_id)
	{
		$builder = $this->db->table($this->table);
		$builder->select("{$this->table}.*");
		$builder->select("role.*");
		$builder->join('role', "role.role_id = {$this->table}.role_id", 'LEFT');
		$builder->where(['admin_id' => $admin_id]);
		$query = $builder->get()->getRow();
		return $query;
	}
	public function authenticate($username, $password)
	{
		$auth = $this->where('admin_username', $username)->first();
		if ($auth) {
			if (password_verify($password, $auth['admin_password'])) {
				$adminLogModel = new AdminLogModel();
				$adminLogModel->save(['admin_username' => $auth['admin_username']]);
				return $auth;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
