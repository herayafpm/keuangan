<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\JenisTransaksiModel;

class JenisTransaksi extends BaseController
{
  protected $form_validation = null;
  public function __construct()
  {
    helper('form');
    $this->form_validation =  \Config\Services::validation();
  }
  public function index()
  {
    $data['_view'] = 'admin/jenis_transaksi/index';
    $data['_title'] = 'Jenis Transaksi';
    $data['_uri_datatable'] = base_url('admin/jenis_transaksi/datatable');
    $data['_scroll_datatable'] = "350px";
    $data = array_merge($data, $this->data);
    return view($data['_view'], $data);
  }
  public function datatable()
  {
    $method = $this->request->getMethod();
    if ($method == 'post') {
      $jenisTransaksiModel = new JenisTransaksiModel();
      $where = null;
      $like = null;
      if (!empty($this->request->getPost('jenis_transaksi_nama'))) {
        $like['jenis_transaksi.jenis_transaksi_nama'] = htmlspecialchars($this->request->getPost('jenis_transaksi_nama'));
      }
      $params = ['where' => $where, 'like' => $like];

      return $this->datatable_data($jenisTransaksiModel, $params);
    } else {
      return redirect()->back();
    }
  }
  public function tambah()
  {
    $data['_view'] = 'admin/jenis_transaksi/tambah';
    $data['_title'] = 'Tambah Jenis Transaksi';
    $data['_validation'] = $this->form_validation;
    $data = array_merge($data, $this->data);
    $method = $this->request->getMethod();
    if ($method == 'post') {
      $rule = [
        'jenis_transaksi_nama' => [
          'label'  => 'Nama Transaksi',
          'rules'  => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'jenis_transaksi_harga' => [
          'label'  => 'Harga Transaksi',
          'rules'  => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
      ];
      $data = [
        'jenis_transaksi_nama' => htmlspecialchars($this->request->getPost('jenis_transaksi_nama')),
        'jenis_transaksi_harga' => htmlspecialchars($this->request->getPost('jenis_transaksi_harga')),
      ];
      $this->form_validation->setRules($rule);
      if (!$this->form_validation->run($data)) {
        return redirect()->back()->withInput();
      } else {
        $jenisTransaksiModel = new JenisTransaksiModel();
        if ($jenisTransaksiModel->save($data)) {
          $this->session->setFlashdata('success', 'Jenis Transaksi berhasil ditambahkan');
          return redirect()->to(base_url('admin/jenis_transaksi'));
        } else {
          $this->session->setFlashdata('error', 'Gagal menambahkan Jenis Transaksi');
          return redirect()->back()->withInput();
        }
      }
    } else {
      return view($data['_view'], $data);
    }
  }
  public function ubah($id = null)
  {
    if ($id == null) {
      return redirect()->back();
    }
    $jenisTransaksiModel = new JenisTransaksiModel();
    $jenisTransaksi = $jenisTransaksiModel->find($id);
    if (!$jenisTransaksi) {
      $this->session->setFlashdata('error', 'Jenis Transaksi tidak ditemukan');
      return redirect()->to(base_url('admin/jenis_transaksi'));
    }
    $data['jenis_transaksi'] = $jenisTransaksi;
    $data['_view'] = 'admin/jenis_transaksi/ubah';
    $data['_title'] = "Ubah Jenis Transaksi {$jenisTransaksi['jenis_transaksi_nama']}";
    $data['_validation'] = $this->form_validation;
    $data = array_merge($data, $this->data);
    $method = $this->request->getMethod();
    if ($method == 'post') {
      $rule = [
        'jenis_transaksi_nama' => [
          'label'  => 'Nama Transaksi',
          'rules'  => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'jenis_transaksi_harga' => [
          'label'  => 'Harga Transaksi',
          'rules'  => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
      ];
      $data = [
        'jenis_transaksi_nama' => htmlspecialchars($this->request->getPost('jenis_transaksi_nama')),
        'jenis_transaksi_harga' => htmlspecialchars($this->request->getPost('jenis_transaksi_harga')),
      ];
      $this->form_validation->setRules($rule);
      if (!$this->form_validation->run($data)) {
        return redirect()->back()->withInput();
      } else {
        if ($jenisTransaksiModel->update($id, $data)) {
          $this->session->setFlashdata('success', 'Jenis Transaksi berhasil diubah');
          return redirect()->to(base_url('admin/jenis_transaksi'));
        } else {
          $this->session->setFlashdata('error', 'Gagal mengubah Jenis Transaksi');
          return redirect()->back()->withInput();
        }
      }
    } else {
      return view($data['_view'], $data);
    }
  }
  public function hapus($id = null)
  {
    try {
      if ($id == null) {
        return redirect()->back();
      }
      $jenisTransaksiModel = new JenisTransaksiModel();
      $jenisTransaksi = $jenisTransaksiModel->find($id);
      if (!$jenisTransaksi) {
        $this->session->setFlashdata('error', 'Jenis Transaksi tidak ditemukan');
        return redirect()->to(base_url('admin/jenis_transaksi'));
      }
      if ($jenisTransaksiModel->delete($id)) {
        $this->session->setFlashdata('success', 'Jenis Transaksi berhasil dihapus');
        return redirect()->to(base_url('admin/jenis_transaksi'));
      } else {
        $this->session->setFlashdata('error', 'Gagal menghapus Jenis Transaksi');
        return redirect()->to(base_url('admin/jenis_transaksi'));
      }
    } catch (\Exception $th) {
      $this->session->setFlashdata('error', 'Gagal menghapus Jenis Transaksi, data masih digunakan');
      return redirect()->to(base_url('admin/jenis_transaksi'));
    }
  }
}
