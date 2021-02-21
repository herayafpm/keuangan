<?php

namespace App\Controllers\Siswa\Transaksi;

use App\Controllers\Siswa\BaseController;
use App\Models\JenisTransaksiModel;
use App\Models\TransaksiModel;

class RiwayatTransaksi extends BaseController
{
  public function index($status)
  {
    $data['_view'] = 'siswa/transaksi/riwayat/index';
    $this->getTransaksiStatus($status);
    $data = array_merge($data, $this->data);
    $data['_title'] = "Riwayat Transaksi {$data['_transaksi_status']}";
    $data['_uri_datatable'] = base_url("siswa/transaksi/{$status}/datatable");
    $data['_riwayat_pembayaran'] = base_url("siswa/transaksi/{$status}/pembayaran");
    $data['_scroll_datatable'] = "350px";
    return view($data['_view'], $data);
  }
  public function datatable($status)
  {
    $method = $this->request->getMethod();
    if ($method == 'post') {
      $transaksiModel = new TransaksiModel();
      $where = ['transaksi.transaksi_status' => $status, 'siswa.siswa_id' => $this->request->siswa['siswa_id']];
      $like = null;
      $params = ['where' => $where, 'like' => $like];
      return $this->datatable_data($transaksiModel, $params);
    } else {
      return redirect()->back();
    }
  }
}
