<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiPembayaranModel extends Model
{
  protected $DBGroup              = 'default';
  protected $table                = 'transaksi_pembayaran';
  protected $primaryKey           = 'transaksi_pembayaran_id';
  protected $useAutoIncrement     = true;
  protected $insertID             = 0;
  protected $returnType           = 'array';
  protected $useSoftDelete        = false;
  protected $protectFields        = true;
  protected $allowedFields        = ['transaksi_id', 'transaksi_pembayaran_bayar', 'transaksi_pembayaran_by', 'transaksi_pembayaran_keterangan'];

  // Dates
  protected $useTimestamps        = true;
  protected $dateFormat           = 'datetime';
  protected $createdField         = 'transaksi_pembayaran_created';
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

  public function filter($limit, $start, $orderBy, $ordered, $params = [])
  {
    $builder = $this->db->table($this->table);
    $builder->orderBy($orderBy, $ordered); // Untuk menambahkan query ORDER BY
    if ($limit > 0) {
      $builder->limit($limit, $start);
    }
    $adminFields = [];
    foreach ($this->adminFields as $field) {
      array_push($adminFields, "transaksi_pembayaran_by_admin.{$field} as transaksi_pembayaran_by_{$field}");
    }
    $builder->select("{$this->table}.*");
    $builder->select(implode(",", $adminFields));
    $builder->join('admin as transaksi_pembayaran_by_admin', "transaksi_pembayaran_by_admin.admin_id = {$this->table}.transaksi_pembayaran_by", 'LEFT');
    if (isset($params['where'])) {
      $builder->where($params['where']);
    }
    if (isset($params['like'])) {
      foreach ($params['like'] as $key => $value) {
        $builder->like($key, $value);
      }
    }
    $datas = $builder->get()->getResultArray();
    return $datas; // Eksekusi query sql sesuai kondisi diatas
  }
  public function count_all($params = [])
  {
    $builder = $this->db->table($this->table);
    $adminFields = [];
    foreach ($this->adminFields as $field) {
      array_push($adminFields, "transaksi_pembayaran_by_admin.{$field} as transaksi_pembayaran_by_{$field}");
    }
    $builder->select("{$this->table}.*");
    $builder->select(implode(",", $adminFields));
    $builder->join('admin as transaksi_pembayaran_by_admin', "transaksi_pembayaran_by_admin.admin_id = {$this->table}.transaksi_pembayaran_by", 'LEFT');
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

  public function getTotalTelahBayar($where)
  {
    $builder = $this->db->table($this->table);
    $builder->selectSum("transaksi_pembayaran_bayar");
    $builder->where($where);
    $datas = $builder->get()->getRowArray();
    return $datas['transaksi_pembayaran_bayar'];
  }
}
