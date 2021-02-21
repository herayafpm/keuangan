<?php

namespace App\Controllers\Siswa;

use App\Controllers\Siswa\BaseController;
use App\Models\SiswaLogModel;

class Log extends BaseController
{
  public function index()
  {
    $data['_view'] = 'siswa/log/index';
    $data['_title'] = 'Riwayat Masuk';
    $data['_uri_datatable'] = base_url('siswa/log/datatable');
    $data['_scroll_datatable'] = "350px";
    $data = array_merge($data, $this->data);
    return view($data['_view'], $data);
  }
  public function datatable()
  {
    $method = $this->request->getMethod();
    if ($method == 'post') {
      $siswaLogModel = new SiswaLogModel();
      $params = ['where' => ['siswa_nis' => $this->request->siswa['siswa_nis']]];
      return $this->datatable_data($siswaLogModel, $params);
    } else {
      return redirect()->back();
    }
  }
}
