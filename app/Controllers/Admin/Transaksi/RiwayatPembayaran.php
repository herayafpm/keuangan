<?php

namespace App\Controllers\Admin\Transaksi;

use App\Controllers\Admin\BaseController;
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
    $data['_view'] = 'admin/transaksi/riwayat_pembayaran/index';
    $this->getTransaksiStatus($status);
    $data = array_merge($data, $this->data);
    $transaksiModel = new TransaksiModel();
    $transaksi = $transaksiModel->getTransaksi($transaksi_id);
    $data['_total_bayar'] = $transaksi['total_harga'];
    $data['_total_kurang_bayar'] = (int) $transaksi['total_harga'] - (int) $transaksi['telah_bayar'];
    $data['_transaksi'] = $transaksi;
    $data['_title'] = "Riwayat Pembayaran {$data['_transaksi_status']} {$transaksi['siswa_nama']}";
    $data['_uri_datatable'] = base_url("admin/transaksi/{$status}/pembayaran/{$transaksi_id}/datatable");
    $data['_url_tambah'] = base_url("admin/transaksi/{$status}/pembayaran/{$transaksi_id}/tambah");
    $data['_url_back'] = base_url("admin/transaksi/{$status}");
    $data['_print_nota'] = base_url("admin/transaksi/{$status}/pembayaran/{$transaksi_id}/print_nota");
    $data['_riwayat_pembayaran'] = base_url("admin/transaksi/pembayaran/{$status}/riwayat");
    $data['_scroll_datatable'] = "350px";
    return view($data['_view'], $data);
  }
  public function datatable($status, $transaksi_id)
  {
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
  public function print_nota($status, $transaksi_id, $transaksi_pembayaran_id)
  {
    helper('my');
    $data['_view'] = 'admin/transaksi/riwayat_pembayaran/nota';
    $transaksiModel = new TransaksiModel();
    $transaksi = $transaksiModel->getTransaksi($transaksi_id);
    if (!$transaksi) {
      $this->session->setFlashdata('error', 'transaksi tidak ditemukkan');
      return redirect()->back();
    }
    $transaksiPembayaranModel = new TransaksiPembayaranModel();
    $transaksiPembayaran = $transaksiPembayaranModel->find($transaksi_pembayaran_id);
    $admin = $this->data['_admin'];
    $data['admin'] = $admin;
    $data['_title'] = "Print Nota Pembayaran";
    $data['transaksi'] = $transaksi;
    $data['transaksi_pembayaran'] = $transaksiPembayaran;
    $data['tanggal_transaksi_pembayaran'] = date('d', strtotime($transaksiPembayaran['transaksi_pembayaran_created'])) . " " . getBulan((int) date('m', strtotime($transaksiPembayaran['transaksi_pembayaran_created'])) - 1) . " " . date('Y', strtotime($transaksiPembayaran['transaksi_pembayaran_created']));
    $data['tanggal_sekarang'] = date('d') . " " . getBulan((int) date('m') - 1) . " " . date('Y');
    return view($data['_view'], $data);
  }
  public function tambah($status, $transaksi_id)
  {
    helper('my');
    $data['_view'] = 'admin/transaksi/riwayat_pembayaran/tambah';
    $data['_validation'] = $this->form_validation;
    $data = array_merge($data, $this->data);
    $data['_title'] = "Transaksi";
    $transaksiModel = new TransaksiModel();
    $transaksi = $transaksiModel->getTransaksi($transaksi_id);
    $data['_total_bayar'] = $transaksi['total_harga'];
    $data['_transaksi_item'] = $transaksi['items'][0];
    $data['_total_kurang_bayar'] = (int) $transaksi['total_harga'] - (int) $transaksi['telah_bayar'];
    $data['_url_back'] = base_url("admin/transaksi/{$status}/pembayaran/{$transaksi['transaksi_id']}");
    $method = $this->request->getMethod();
    if ($method == 'post') {
      return $this->proses_tambah($status, $transaksi);
    } else {
      return view($data['_view'], $data);
    }
  }
  public function proses_tambah($status, $transaksi)
  {
    $harga = (int) $transaksi['total_harga'] - (int) $transaksi['telah_bayar'];
    $hargaRupiah = format_rupiah($harga);
    $rule = [
      'transaksi_pembayaran_bayar' => [
        'label'  => 'Nominal Bayar',
        'rules'  => "required|less_than_or_same_money[{$harga}]",
        'errors' => [
          'required' => '{field} tidak boleh kosong',
          'less_than_or_same_money' => "{field} harus kurang dari atau sama dengan {$hargaRupiah}"
        ]
      ],
      'transaksi_pembayaran_keterangan' => [
        'label'  => 'Keterangan',
        'rules'  => "required",
        'errors' => [
          'required' => '{field} tidak boleh kosong',
        ]
      ],
    ];
    $data = [
      'transaksi_pembayaran_bayar' => htmlspecialchars($this->request->getPost('transaksi_pembayaran_bayar')),
      'transaksi_pembayaran_keterangan' => htmlspecialchars($this->request->getPost('transaksi_pembayaran_keterangan')),
    ];
    $this->form_validation->setRules($rule);
    if (!$this->form_validation->run($data)) {
      return redirect()->back()->withInput();
    } else {
      $admin = $this->data['_admin'];
      $data['transaksi_id'] = $transaksi['transaksi_id'];
      $data['transaksi_pembayaran_by'] = $admin->admin_id;
      $transaksiPembayaranModel = new TransaksiPembayaranModel();
      if ($transaksiPembayaranModel->save($data)) {
        $transaksi_pembayaran_id = $transaksiPembayaranModel->InsertID();
        $this->session->setFlashdata('success', 'Berhasil menambahkan transaksi pembayaran');
        $status = 0;
        if ((int) $data['transaksi_pembayaran_bayar'] == (int) $harga) {
          $status = 1;
          $transaksiModel = new TransaksiModel();
          $transaksiModel->update($transaksi['transaksi_id'], ['transaksi_status' => 1, 'transaksi_status_at' => date('Y-m-d H:i:s')]);
        }
        $this->session->setFlashData('open_url', base_url("admin/transaksi/{$status}/pembayaran/{$transaksi['transaksi_id']}/print_nota/{$transaksi_pembayaran_id}"));
        return redirect()->to(base_url("admin/transaksi/{$status}/pembayaran/{$transaksi['transaksi_id']}"));
      } else {
        $this->session->setFlashdata('error', 'Gagal menambahkan transaksi pembayaran');
        return redirect()->back()->withInput();
      }
    }
  }
}
