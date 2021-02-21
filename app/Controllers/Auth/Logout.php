<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class Logout extends BaseController
{
  public function index()
  {
    $this->session->destroy();
    $this->session->setFlashdata('success', 'Anda berhasil logout');
    return redirect()->to(base_url('auth/login'));
  }
}
