<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\AdminLogModel;

class Log extends BaseController
{
  public function index()
  {
    $data['_view'] = 'admin/log/index';
    $data['_title'] = 'Riwayat Masuk';
    $data['_uri_datatable'] = base_url('admin/log/datatable');
    $data['_scroll_datatable'] = "350px";
    $data = array_merge($data, $this->data);
    return view($data['_view'], $data);
  }
  public function datatable()
  {
    $method = $this->request->getMethod();
    if ($method == 'post') {
      $adminLogModel = new AdminLogModel();
      $params = ['where' => ['admin_username' => $this->request->admin->admin_username]];
      return $this->datatable_data($adminLogModel, $params);
    } else {
      return redirect()->back();
    }
  }
}
