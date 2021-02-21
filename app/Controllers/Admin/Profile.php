<?php

namespace App\Controllers\Admin;

use App\Models\AdminModel;

class Profile extends BaseController
{
  protected $form_validation = null;
  public function __construct()
  {
    helper('form');
    $this->form_validation =  \Config\Services::validation();
  }
  public function index()
  {
    $data['_view'] = 'admin/profile/index';
    $data['_title'] = 'Profile';
    $data['_validation'] = $this->form_validation;
    $data = array_merge($data, $this->data);
    $method = $this->request->getMethod();
    if ($method == 'post') {
      return $this->process($data);
    } else {
      return view($data['_view'], $data);
    }
  }
  protected function process($dataData)
  {
    $rule = [
      'admin_nama' => [
        'label'  => 'Nama Admin',
        'rules'  => 'required',
        'errors' => [
          'required' => '{field} tidak boleh kosong',
        ]
      ],
      'admin_password' => [
        'label'  => 'Password Admin',
        'rules'  => 'update_pass[6]',
        'errors' => [
          'update_pass' => '{field} harus lebih dari sama dengan {param} karakter',
        ]
      ],
    ];
    $data = [
      'admin_nama' => htmlspecialchars($this->request->getPost('admin_nama')),
      'admin_password' => htmlspecialchars($this->request->getPost('admin_password')),
    ];
    $this->form_validation->setRules($rule);
    if (!$this->form_validation->run($data)) {
      return redirect()->back()->withInput();
    }
    $adminModel = new AdminModel();
    $data['admin_nama'] = $data['admin_nama'];
    if (empty($data['admin_password'])) {
      unset($data['admin_password']);
    }
    if ($adminModel->update($this->session->admin_id, $data)) {
      $this->session->setFlashdata('success', 'Profile berhasil diubah');
      return redirect()->back();
    } else {
      $this->session->setFlashdata('error', 'Gagal mengubah profile');
      return redirect()->back()->withInput();
    }
  }
}
