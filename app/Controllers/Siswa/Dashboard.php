<?php

namespace App\Controllers\Siswa;

use App\Models\TransaksiModel;

class Dashboard extends BaseController
{
  public function index()
  {
    $data['_view'] = 'siswa/dashboard';
    $data['_title'] = 'Dashboard';
    $data = array_merge($data, $this->data);
    $transaksiModel = new TransaksiModel();
    $siswa = $this->data['_siswa'];
    $data['_total_belum_lunas'] = $transaksiModel->where(['siswa_id' => $siswa['siswa_id'], 'transaksi_status' => 0])->countAllResults();
    $data['_total_lunas'] = $transaksiModel->where(['siswa_id' => $siswa['siswa_id'], 'transaksi_status' => 1])->countAllResults();
    return view($data['_view'], $data);
  }
}
