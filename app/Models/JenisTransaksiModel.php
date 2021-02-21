<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisTransaksiModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'jenis_transaksi';
	protected $primaryKey           = 'jenis_transaksi_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['jenis_transaksi_nama', 'jenis_transaksi_harga'];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

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
}
