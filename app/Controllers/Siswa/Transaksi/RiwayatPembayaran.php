<?php

namespace App\Controllers\Siswa\Transaksi;

use App\Controllers\Siswa\BaseController;
use App\Models\TransaksiModel;
use App\Models\TransaksiPembayaranModel;

class RiwayatPembayaran extends BaseController
{
  protected $form_validation = null;
  public function __construct()
  {
    helper('form');
    $this->form_validation =  \Config\Services::validation();
  }
  public function index($status, $transaksi_id)
  {
    helper('my');
    $data['_view'] = 'siswa/transaksi/riwayat_pembayaran/index';
    $this->getTransaksiStatus($status);
    $data = array_merge($data, $this->data);
    $transaksiModel = new TransaksiModel();
    $data['_url_back'] = base_url("siswa/transaksi/{$status}");
    $transaksi = $transaksiModel->getTransaksi($transaksi_id);
    if (sizeof($transaksi) < 2) {
      $this->session->setFlashdata('error', 'Unauthorized');
      return redirect()->to($data['_url_back']);
    }
    if ($transaksi['siswa_id'] != $this->request->siswa['siswa_id']) {
      $this->session->setFlashdata('error', 'Unauthorized');
      return redirect()->to($data['_url_back']);
    }
    $data['_total_bayar'] = $transaksi['total_harga'];
    $data['_total_kurang_bayar'] = (int) $transaksi['total_harga'] - (int) $transaksi['telah_bayar'];
    $data['_transaksi'] = $transaksi;
    $data['_title'] = "Riwayat Pembayaran {$data['_transaksi_status']} {$transaksi['siswa_nama']}";
    $data['_uri_datatable'] = base_url("siswa/transaksi/{$status}/pembayaran/{$transaksi_id}/datatable");
    $data['_scroll_datatable'] = "350px";
    return view($data['_view'], $data);
  }
  public function datatable($status, $transaksi_id)
  {
    $transaksiModel = new TransaksiModel();
    $transaksi = $transaksiModel->find($transaksi_id);
    if (sizeof($transaksi) < 2) {
      $this->session->setFlashdata('error', 'Unauthorized');
      return redirect()->to(base_url("siswa/transaksi/{$status}"));
    }
    if ($transaksi['siswa_id'] != $this->request->siswa['siswa_id']) {
      $this->session->setFlashdata('error', 'Unauthorized');
      return redirect()->to(base_url("siswa/transaksi/{$status}"));
    }
    $method = $this->request->getMethod();
    if ($method == 'post') {
      $transaksiPembayaranModel = new TransaksiPembayaranModel();
      $where = ['transaksi_pembayaran.transaksi_id' => $transaksi_id];
      $like = null;
      $params = ['where' => $where, 'like' => $like];
      return $this->datatable_data($transaksiPembayaranModel, $params);
    } else {
      return redirect()->back();
    }
  }
}
