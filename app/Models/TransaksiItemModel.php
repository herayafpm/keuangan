<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiItemModel extends Model
{
  protected $DBGroup              = 'default';
  protected $table                = 'transaksi_item';
  protected $primaryKey           = 'transaksi_item_id';
  protected $useAutoIncrement     = true;
  protected $insertID             = 0;
  protected $returnType           = 'array';
  protected $useSoftDelete        = false;
  protected $protectFields        = true;
  protected $allowedFields        = ['jenis_transaksi_id', 'transaksi_id', 'transaksi_item_harga'];

  // Dates
  protected $useTimestamps        = false;
  protected $dateFormat           = 'datetime';
  protected $createdField         = '';
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

  public function filter($limit, $start, $orderBy, $ordered, $params = [])
  {
    $builder = $this->db->table($this->table);
    $builder->orderBy($orderBy, $ordered); // Untuk menambahkan query ORDER BY
    if ($limit > 0) {
      $builder->limit($limit, $start);
    }
    $builder->select("{$this->table}.*");
    $builder->select("jenis_transaksi.*");
    $builder->join('jenis_transaksi', "jenis_transaksi.jenis_transaksi_id = {$this->table}.jenis_transaksi_id", 'LEFT');
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
    $builder->select("{$this->table}.*");
    $builder->select("jenis_transaksi.*");
    $builder->join('jenis_transaksi', "jenis_transaksi.jenis_transaksi_id = {$this->table}.jenis_transaksi_id", 'LEFT');
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

  public function getTotalHarga($where)
  {
    $builder = $this->db->table($this->table);
    $builder->selectSum("transaksi_item_harga");
    $builder->where($where);
    $datas = $builder->get()->getRowArray();
    return $datas['transaksi_item_harga'];
  }
}
