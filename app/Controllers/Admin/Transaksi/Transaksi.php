<?php

namespace App\Controllers\Admin\Transaksi;

use App\Controllers\Admin\BaseController;
use App\Models\JenisTransaksiModel;
use App\Models\SiswaModel;
use App\Models\TransaksiItemModel;
use App\Models\TransaksiModel;
use App\Models\TransaksiPembayaranModel;

class Transaksi extends BaseController
{
  protected $form_validation = null;
  public function __construct()
  {
    helper('form');
    $this->form_validation =  \Config\Services::validation();
  }
  public function index()
  {
    helper('my');
    $data['_view'] = 'admin/transaksi/tambah';
    $data['_validation'] = $this->form_validation;
    $data = array_merge($data, $this->data);
    $data['_title'] = "Transaksi";
    $jenisTransaksiModel = new JenisTransaksiModel();
    $jenisTransaksis = $jenisTransaksiModel->findAll();
    $data['_jenis_transaksis'] = $jenisTransaksis;
    $method = $this->request->getMethod();
    if ($method == 'post') {
      return $this->process();
    } else {
      return view($data['_view'], $data);
    }
  }
  protected function process()
  {
    $min_jenis_transaksi = 2;
    $rule = [
      'siswa_nis' => [
        'label'  => 'NIS',
        'rules'  => 'required',
        'errors' => [
          'required' => '{field} tidak boleh kosong',
        ]
      ],
      'siswa_nama' => [
        'label'  => 'Nama',
        'rules'  => 'required',
        'errors' => [
          'required' => '{field} tidak boleh kosong',
        ]
      ],
      'siswa_alamat' => [
        'label'  => 'Alamat',
        'rules'  => 'required',
        'errors' => [
          'required' => '{field} tidak boleh kosong',
        ]
      ],
      'jenis_transaksi_ids' => [
        'label'  => 'Jenis Transaksi',
        'rules'  => "required|min_length_array[{$min_jenis_transaksi}]",
        'errors' => [
          'required' => '{field} tidak boleh kosong',
          'min_length_array' => '{field} harus lebih dari atau sama dengan {param} jenis',
        ]
      ],
      'jenis_transaksi_namas' => [
        'label'  => 'Jenis Transaksi',
        'rules'  => "required|min_length_array[{$min_jenis_transaksi}]",
        'errors' => [
          'required' => '{field} tidak boleh kosong',
          'min_length_array' => '{field} harus lebih dari atau sama dengan {param} jenis',
        ]
      ],
      'jenis_transaksi_hargas' => [
        'label'  => 'Jenis Transaksi',
        'rules'  => "min_length_array[{$min_jenis_transaksi}]",
        'errors' => [
          'min_length_array' => '{field} harus lebih dari atau sama dengan {param} jenis',
        ]
      ],
      'transaksi_pembayaran_bayars' => [
        'label'  => 'Jenis Transaksi',
        'rules'  => "min_length_array[{$min_jenis_transaksi}]",
        'errors' => [
          'min_length_array' => '{field} harus lebih dari atau sama dengan {param} jenis',
        ]
      ],
    ];
    $data = [
      'siswa_nis' => htmlspecialchars($this->request->getPost('siswa_nis')),
      'siswa_nama' => htmlspecialchars($this->request->getPost('siswa_nama')),
      'siswa_alamat' => htmlspecialchars($this->request->getPost('siswa_alamat')),
      'jenis_transaksi_ids' => $this->request->getPost('jenis_transaksi_ids'),
      'jenis_transaksi_namas' => $this->request->getPost('jenis_transaksi_namas'),
      'jenis_transaksi_hargas' => $this->request->getPost('jenis_transaksi_hargas'),
      'transaksi_pembayaran_bayars' => $this->request->getPost('transaksi_pembayaran_bayars'),
    ];
    $this->form_validation->setRules($rule);
    if (!$this->form_validation->run($data)) {
      return redirect()->back()->withInput();
    } else {
      $siswaModel = new SiswaModel();
      $siswa = $siswaModel->findByNIS($data['siswa_nis']);
      if ($siswa) {
        $data['siswa_id'] = $siswa['siswa_id'];
        $siswaModel->update($siswa['siswa_id'], [
          'siswa_nama' => $data['siswa_nama'],
          'siswa_alamat' => $data['siswa_alamat'],
        ]);
      } else {
        $siswaModel->save([
          'siswa_nis' => $data['siswa_nis'],
          'siswa_nama' => $data['siswa_nama'],
          'siswa_alamat' => $data['siswa_alamat'],
          'siswa_password' => env("passwordDefault"),
        ]);
        $data['siswa_id'] = $siswaModel->InsertID();
      }
      unset($data['siswa_nis']);
      unset($data['siswa_nama']);
      unset($data['siswa_alamat']);
      $admin = $this->data['_admin'];

      $transaksiModel = new TransaksiModel();
      $data['transaksi_by'] = $admin->admin_id;
      if ($transaksiModel->save($data)) {
        $transaksi_id = $transaksiModel->getInsertID();
        $jenis_transaksi_ids = explode(",", $data['jenis_transaksi_ids'][0]);
        $jenis_transaksi_namas = explode(",", $data['jenis_transaksi_namas'][0]);
        $jenis_transaksi_hargas = explode(",", $data['jenis_transaksi_hargas'][0]);
        $transaksi_pembayaran_bayars = explode(",", $data['transaksi_pembayaran_bayars'][0]);
        $no = 0;
        $total_harga = 0;
        $total_bayar = 0;
        $transaksiItemModel = new TransaksiItemModel();
        $transaksiPembayaranModel = new TransaksiPembayaranModel();
        foreach ($jenis_transaksi_ids as $jenis_transaksi_id) {
          $total_harga += (int) $jenis_transaksi_hargas[$no];
          $total_bayar += (int) $transaksi_pembayaran_bayars[$no];
          $transaksiItemModel->save(['transaksi_id' => $transaksi_id, 'jenis_transaksi_id' => $jenis_transaksi_id, 'transaksi_item_harga' =>   $jenis_transaksi_hargas[$no]]);
          $transaksiPembayaranModel->save(['transaksi_id' => $transaksi_id, 'transaksi_pembayaran_bayar' => $transaksi_pembayaran_bayars[$no], 'transaksi_pembayaran_by' => $admin->admin_id, 'transaksi_pembayaran_keterangan' => "{$jenis_transaksi_namas[$no]}"]);
          $no++;
        }
        $status = 0;
        if ($total_bayar == $total_harga) {
          $transaksiModel->update($transaksi_id, ['transaksi_status' => 1, 'transaksi_status_at' => date('Y-m-d H:i:s')]);
          $status = 1;
        }
        $this->session->setFlashdata('success', 'Berhasil menambahkan transaksi');
        return redirect()->to(base_url("admin/transaksi/$status"));
      } else {
        $this->session->setFlashdata('error', 'Gagal menambah transaksi');
        return redirect()->back()->withInput();
      }
    }
  }
}
