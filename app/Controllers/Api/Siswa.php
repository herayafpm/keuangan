<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Siswa extends ResourceController
{

  protected $format       = 'json';
  protected $modelName    = 'App\Models\SiswaModel';
  public function index()
  {
    $dataGet = $this->request->getGet();
    $siswa = $this->model->findByNIS($dataGet['siswa_nis']);
    return $this->respond(["status" => 1, "message" => "data siswa", "data" => $siswa], 200);
  }
  public function create()
  {
    $dataPost = $this->request->getPost();
    try {
      $data = [
        'siswa_nis' => htmlspecialchars($dataPost['siswa_nis'] ?? ''),
        'siswa_nama' => htmlspecialchars($dataPost['siswa_nama'] ?? ''),
        'siswa_alamat' => htmlspecialchars($dataPost['siswa_alamat'] ?? ''),
        'siswa_password' => env('passwordDefault')
      ];
      $siswa = $this->model->findByNIS($data['siswa_nis']);
      if ($siswa) {
        // unset($data['siswa_nis']);
        // unset($data['siswa_password']);
        // $update = $this->model->update($siswa['siswa_id'], $data);
        // if ($update) {
        //   return $this->respond(["status" => 1, "message" => "data siswa berhasil diubah", "data" => $dataPost], 200);
        // } else {
        //   return $this->respond(["status" => 0, "message" => "data siswa gagal diubah", "data" => $dataPost], 400);
        // }
        return $this->respond(["status" => 0, "message" => "data siswa sudah ada", "data" => $dataPost], 200);
      } else {
        $create = $this->model->save($data);
        if ($create) {
          return $this->respond(["status" => 1, "message" => "data siswa berhasil ditambahkan", "data" => $dataPost], 200);
        } else {
          return $this->respond(["status" => 0, "message" => "data siswa gagal ditambahkan", "data" => $dataPost], 200);
        }
      }
    } catch (\Exception $th) {
      return $this->respond(["status" => 0, "message" => $th->getMessage(), "data" => $dataPost], 500);
    }
  }
}
