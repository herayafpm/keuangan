<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\SiswaModel;
use App\Models\SiswaLogModel;

class Siswa extends BaseController
{
  protected $form_validation = null;
  public function __construct()
  {
    helper('form');
    $this->form_validation =  \Config\Services::validation();
  }
  public function index()
  {
    $data['_view'] = 'admin/siswa/index';
    $data['_title'] = 'Siswa';
    $data['_uri_datatable'] = base_url('admin/siswa/datatable');
    $data['_scroll_datatable'] = "350px";
    $data = array_merge($data, $this->data);
    return view($data['_view'], $data);
  }
  public function datatable()
  {
    $method = $this->request->getMethod();
    if ($method == 'post') {
      $siswaModel = new SiswaModel();
      $where = null;
      $like = null;
      if (!empty($this->request->getPost('siswa_nis'))) {
        $like['siswa.siswa_nis'] = htmlspecialchars($this->request->getPost('siswa_nis'));
      }
      if (!empty($this->request->getPost('siswa_nama'))) {
        $like['siswa.siswa_nama'] = htmlspecialchars($this->request->getPost('siswa_nama'));
      }
      $params = ['where' => $where, 'like' => $like];

      return $this->datatable_data($siswaModel, $params);
    } else {
      return redirect()->back();
    }
  }
  public function tambah()
  {
    $data['_view'] = 'admin/siswa/tambah';
    $data['_title'] = "Tambah Siswa";
    $data['_validation'] = $this->form_validation;
    $data = array_merge($data, $this->data);
    $method = $this->request->getMethod();
    if ($method == 'post') {
      $rule = [
        'siswa_nama' => [
          'label'  => 'Nama',
          'rules'  => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'siswa_nis' => [
          'label'  => 'NIS',
          'rules'  => "required|is_unique[siswa.siswa_nis]",
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} sudah digunakan, gunakan yang lain',
          ]
        ],
        'siswa_alamat' => [
          'label'  => 'Alamat',
          'rules'  => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
      ];
      $data = [
        'siswa_nama' => htmlspecialchars($this->request->getPost('siswa_nama')),
        'siswa_nis' => htmlspecialchars($this->request->getPost('siswa_nis')),
        'siswa_alamat' => htmlspecialchars($this->request->getPost('siswa_alamat')),
      ];
      $this->form_validation->setRules($rule);
      if (!$this->form_validation->run($data)) {
        return redirect()->back()->withInput();
      } else {
        $data['siswa_password'] = env('passwordDefault');
        $siswaModel = new SiswaModel();
        if ($siswaModel->save($data)) {
          $this->session->setFlashdata('success', 'Siswa berhasil ditambah');
          return redirect()->to(base_url('admin/siswa'));
        } else {
          $this->session->setFlashdata('error', 'Gagal menambah siswa');
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
    $siswaModel = new SiswaModel();
    $siswa = $siswaModel->find($id);
    if (!$siswa) {
      $this->session->setFlashdata('error', 'Siswa tidak ditemukan');
      return redirect()->to(base_url('admin/siswa'));
    }
    $data['_siswa'] = $siswa;
    $data['_view'] = 'admin/siswa/ubah';
    $data['_title'] = "Ubah Siswa {$siswa['siswa_nama']}";
    $data['_validation'] = $this->form_validation;
    $data = array_merge($data, $this->data);
    $method = $this->request->getMethod();
    if ($method == 'post') {
      $rule = [
        'siswa_nama' => [
          'label'  => 'Nama',
          'rules'  => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'siswa_nis' => [
          'label'  => 'NIS',
          'rules'  => "required|is_unique[siswa.siswa_nis,siswa_id,{$id}]",
          'errors' => [
            'required' => '{field} tidak boleh kosong',
            'is_unique' => '{field} sudah digunakan, gunakan yang lain',
          ]
        ],
        'siswa_alamat' => [
          'label'  => 'Alamat',
          'rules'  => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong',
          ]
        ],
        'siswa_password' => [
          'label'  => 'Password',
          'rules'  => 'update_pass[6]',
          'errors' => [
            'update_pass' => '{field} min {param} karakter',
          ]
        ],
      ];
      $data = [
        'siswa_nama' => htmlspecialchars($this->request->getPost('siswa_nama')),
        'siswa_nis' => htmlspecialchars($this->request->getPost('siswa_nis')),
        'siswa_alamat' => htmlspecialchars($this->request->getPost('siswa_alamat')),
        'siswa_password' => htmlspecialchars($this->request->getPost('siswa_password')),
      ];
      $this->form_validation->setRules($rule);
      if (!$this->form_validation->run($data)) {
        return redirect()->back()->withInput();
      } else {
        if (empty($data['siswa_password'])) {
          unset($data['siswa_password']);
        }
        if ($siswaModel->update($id, $data)) {
          $this->session->setFlashdata('success', 'Siswa berhasil diubah');
          return redirect()->to(base_url('admin/siswa'));
        } else {
          $this->session->setFlashdata('error', 'Gagal mengubah siswa');
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
      $siswaModel = new SiswaModel();
      $siswa = $siswaModel->find($id);
      if (!$siswa) {
        $this->session->setFlashdata('error', 'siswa tidak ditemukan');
        return redirect()->to(base_url('admin/user'));
      }
      if ($siswaModel->delete($id)) {
        $this->session->setFlashdata('success', 'siswa berhasil dihapus');
        return redirect()->to(base_url('admin/siswa'));
      } else {
        $this->session->setFlashdata('error', 'Gagal menghapus siswa');
        return redirect()->to(base_url('admin/siswa'));
      }
    } catch (\Exception $th) {
      $this->session->setFlashdata('error', 'Gagal menghapus siswa, data masih digunakan');
      return redirect()->to(base_url('admin/siswa'));
    }
  }
  public function log($id = null)
  {
    $data['_view'] = '/admin/siswa/log/index';
    $siswaModel = new SiswaModel();
    $siswa = $siswaModel->find($id);
    $data['_title'] = "Riwayat Masuk {$siswa['siswa_nama']}";
    $data['_uri_datatable'] = base_url("admin/siswa/log/{$id}/datatable");
    $data['_scroll_datatable'] = "350px";
    $data = array_merge($data, $this->data);
    return view($data['_view'], $data);
  }
  public function log_datatable($id = null)
  {
    $method = $this->request->getMethod();
    if ($method == 'post') {
      $siswaLogModel = new SiswaLogModel();
      $siswaModel = new SiswaModel();
      $siswa = $siswaModel->find($id);
      $params = ['where' => ['siswa_nis' => $siswa['siswa_nis']]];
      return $this->datatable_data($siswaLogModel, $params);
    } else {
      return redirect()->back();
    }
  }
  public function import_excel()
  {
    $data['_view'] = 'admin/siswa/import_excel';
    $data['_title'] = "Import Excel Siswa";
    $data['_scroll_datatable'] = "350px";
    $data = array_merge($data, $this->data);
    return view($data['_view'], $data);
  }
}
