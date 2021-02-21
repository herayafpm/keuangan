<?php

namespace App\Controllers\Admin\Transaksi;

use App\Controllers\Admin\BaseController;
use App\Models\JenisTransaksiModel;
use App\Models\TransaksiModel;


class LaporanTransaksi extends BaseController
{
  public function index($status)
  {
    $data['_view'] = 'admin/laporan_transaksi/riwayat/index';
    $this->getTransaksiStatus($status);
    $data = array_merge($data, $this->data);
    $data['_title'] = "Laporan Transaksi {$data['_transaksi_status']}";
    $data['_uri_datatable'] = base_url("admin/transaksi/{$status}/laporan/datatable");
    $data['_uri_excel'] = base_url("api/transaksi/{$status}/laporan");
    $data['_scroll_datatable'] = "350px";
    $jenisTransaksiModel = new JenisTransaksiModel();
    $data['_jenis_transaksis'] = $jenisTransaksiModel->findAll();
    return view($data['_view'], $data);
  }
  public function datatable($status)
  {
    $method = $this->request->getMethod();
    if ($method == 'post') {
      $transaksiModel = new TransaksiModel();
      $where = ['transaksi.transaksi_status' => $status];
      $like = null;
      $whereItems = null;
      if (!empty($this->request->getPost('jenis_transaksi_id'))) {
        $whereItems['transaksi_item.jenis_transaksi_id'] = htmlspecialchars($this->request->getPost('jenis_transaksi_id'));
      }
      if (!empty($this->request->getPost('siswa_nis'))) {
        $like['siswa.siswa_nis'] = htmlspecialchars($this->request->getPost('siswa_nis'));
      }
      if (!empty($this->request->getPost('siswa_nama'))) {
        $like['siswa.siswa_nama'] = htmlspecialchars($this->request->getPost('siswa_nama'));
      }
      if (!empty($this->request->getPost('date'))) {
        $date = explode('/', htmlspecialchars($this->request->getPost('date')));
        $where['transaksi.transaksi_created >='] = $date[0] . " 00:00:00";
        $where['transaksi.transaksi_created <='] = $date[1] . " 23:59:59";
      }
      $params = ['where' => $where, 'like' => $like, 'whereItems' => $whereItems];
      return $this->datatable_data($transaksiModel, $params);
    } else {
      return redirect()->back();
    }
  }
}
