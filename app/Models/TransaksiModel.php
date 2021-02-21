<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'transaksi';
	protected $primaryKey           = 'transaksi_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['siswa_id', 'transaksi_status', 'transaksi_by', 'transaksi_status_at'];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'transaksi_created';
	protected $updatedField         = '';
	protected $deletedField         = '';

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

	protected $adminFields = ['admin_nama'];
	protected $siswaFields = ['siswa_nama', 'siswa_nis', 'siswa_alamat'];

	public function filter($limit, $start, $orderBy, $ordered, $params = [])
	{
		$builder = $this->db->table($this->table);
		$builder->orderBy($orderBy, $ordered); // Untuk menambahkan query ORDER BY
		if ($limit > 0) {
			$builder->limit($limit, $start);
		}
		$adminFields = [];
		foreach ($this->adminFields as $field) {
			array_push($adminFields, "transaksi_by_admin.{$field} as transaksi_by_{$field}");
		}
		$siswaFields = [];
		foreach ($this->siswaFields as $field) {
			array_push($siswaFields, "{$field}");
		}
		$builder->select("{$this->table}.*");
		$builder->select(implode(",", $siswaFields));
		$builder->select(implode(",", $adminFields));
		$builder->join('siswa', "siswa.siswa_id = {$this->table}.siswa_id", 'LEFT');
		$builder->join('admin as transaksi_by_admin', "transaksi_by_admin.admin_id = {$this->table}.transaksi_by", 'LEFT');
		if (isset($params['where'])) {
			$builder->where($params['where']);
		}
		if (isset($params['like'])) {
			foreach ($params['like'] as $key => $value) {
				$builder->like($key, $value);
			}
		}
		$datas = $builder->get()->getResultArray();
		$no = 0;
		$transaksiPembayaranModel = new TransaksiPembayaranModel();
		$transaksiItemModel = new TransaksiItemModel();
		foreach ($datas as $data) {
			$datas[$no]['telah_bayar'] = $transaksiPembayaranModel->getTotalTelahBayar([$this->primaryKey => $data[$this->primaryKey]]);
			$whereItems =  [$this->primaryKey => $data[$this->primaryKey]];
			if (isset($params['whereItems'])) {
				$whereItems = array_merge($whereItems, $params['whereItems']);
			}
			$datas[$no]['items'] = $transaksiItemModel->filter(0, 0, 'transaksi_item_id', 'asc', ['where' => $whereItems]);
			$datas[$no]['total_harga'] = $transaksiItemModel->getTotalHarga([$this->primaryKey => $data[$this->primaryKey]]);
			if (sizeof($datas[$no]['items']) == 0) {
				unset($datas[$no]);
			}
			$no++;
		}
		return $datas;
	}
	public function count_all($params = [])
	{
		$builder = $this->db->table($this->table);
		$adminFields = [];
		foreach ($this->adminFields as $field) {
			array_push($adminFields, "transaksi_by_admin.{$field} as transaksi_by_{$field}");
		}
		$siswaFields = [];
		foreach ($this->siswaFields as $field) {
			array_push($siswaFields, "{$field}");
		}
		$builder->select("{$this->table}.*");
		$builder->select(implode(",", $siswaFields));
		$builder->select(implode(",", $adminFields));
		$builder->join('siswa', "siswa.siswa_id = {$this->table}.siswa_id", 'LEFT');
		$builder->join('admin as transaksi_by_admin', "transaksi_by_admin.admin_id = {$this->table}.transaksi_by", 'LEFT');
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
	public function getTransaksi($transaksi_id)
	{
		$builder = $this->db->table($this->table);
		$adminFields = [];
		foreach ($this->adminFields as $field) {
			array_push($adminFields, "transaksi_by_admin.{$field} as transaksi_by_{$field}");
		}
		$siswaFields = [];
		foreach ($this->siswaFields as $field) {
			array_push($siswaFields, "{$field}");
		}
		$builder->select("{$this->table}.*");
		$builder->select(implode(",", $siswaFields));
		$builder->select(implode(",", $adminFields));
		$builder->join('siswa', "siswa.siswa_id = {$this->table}.siswa_id", 'LEFT');
		$builder->join('admin as transaksi_by_admin', "transaksi_by_admin.admin_id = {$this->table}.transaksi_by", 'LEFT');
		$builder->where(["{$this->table}.{$this->primaryKey}" => $transaksi_id]);
		$datas = $builder->get()->getRowArray();
		$transaksiPembayaranModel = new TransaksiPembayaranModel();
		$transaksiItemModel = new TransaksiItemModel();
		$datas['telah_bayar'] = $transaksiPembayaranModel->getTotalTelahBayar([$this->primaryKey => $datas[$this->primaryKey]]);
		$datas['items'] = $transaksiItemModel->filter(0, 0, 'transaksi_item_id', 'asc', ['where' => [$this->primaryKey => $datas[$this->primaryKey]]]);
		$datas['total_harga'] = $transaksiItemModel->getTotalHarga([$this->primaryKey => $datas[$this->primaryKey]]);
		return $datas;
	}
}
