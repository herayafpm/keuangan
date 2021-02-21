<?php

namespace App\Controllers\Admin;

use App\Models\TransaksiModel;

class Dashboard extends BaseController
{
  public function index()
  {
    $data['_view'] = 'admin/dashboard';
    $data['_title'] = 'Dashboard';
    $data = array_merge($data, $this->data);
    $transaksiModel = new TransaksiModel();
    $data['_total_belum_lunas'] = $transaksiModel->where('transaksi_status', 0)->countAllResults();
    $data['_total_lunas'] = $transaksiModel->where('transaksi_status', 1)->countAllResults();
    return view($data['_view'], $data);
  }
}
