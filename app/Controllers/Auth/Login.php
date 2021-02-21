<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\AdminModel;

class Login extends BaseController
{
  protected $form_validation = null;
  public function __construct()
  {
    helper('form');
    $this->form_validation =  \Config\Services::validation();
  }
  public function index()
  {
    $data['_session'] = $this->session;
    $data['_title'] = 'Masuk Aplikasi';
    $data['_view'] = 'auth/login';
    $data['_validation'] = $this->form_validation;
    $method = $this->request->getMethod();
    if ($method == 'post') {
      return $this->process();
    } else {
      return view($data['_view'], $data);
    }
  }

  public function process()
  {
    $rule = [
      'username' => [
        'label'  => 'Username / NIS',
        'rules'  => 'required',
        'errors' => [
          'required' => '{field} tidak boleh kosong',
        ]
      ],
      'password' => [
        'label'  => 'Password',
        'rules'  => 'required',
        'errors' => [
          'required' => '{field} tidak boleh kosong'
        ]
      ],
    ];
    $data = [
      'username' => htmlspecialchars($this->request->getPost('username')),
      'password' => htmlspecialchars($this->request->getPost('password')),
    ];
    $this->form_validation->setRules($rule);
    if (!$this->form_validation->run($data)) {
      return redirect()->back()->withInput();
    } else {
      $adminModel = new AdminModel();
      $authAdmin = $adminModel->authenticate($data['username'], $data['password']);
      if ($authAdmin) {
        $authAdmin['isAdmin'] = true;
        $authAdmin['isLogin'] = true;
        $this->session->set($authAdmin);
        return redirect()->to(base_url('admin/dashboard'));
      } else {
        $siswaModel = new SiswaModel();
        $authSiswa = $siswaModel->authenticate($data['username'], $data['password']);
        if ($authSiswa) {
          $authSiswa['isLogin'] = true;
          $this->session->set($authSiswa);
          return redirect()->to(base_url('siswa/dashboard'));
        } else {
          $this->session->setFlashdata('error', 'Username atau password salah');
          return redirect()->back()->withInput();
        }
      }
    }
  }

  //--------------------------------------------------------------------

}
