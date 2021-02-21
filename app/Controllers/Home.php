<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$session = session();
		if (!isset($session->isLogin)) {
			return redirect()->to(base_url('auth/login'));
		}
		if (isset($session->isAdmin)) {
			return redirect()->to(base_url('admin/dashboard'));
		} else {
			return redirect()->to(base_url('user/dashboard'));
		}
	}
}
