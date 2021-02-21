<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\JenisTransaksiModel;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanTransaksi extends ResourceController
{

  protected $format       = 'json';
  protected $modelName    = 'App\Models\TransaksiModel';
  public function excel($status)
  {
    try {
      $method = $this->request->getMethod();
      if ($method == 'post') {
        $nama_status = "Belum Lunas";
        if ($status == 1) {
          $nama_status = "Lunas";
        }
        $where = ['transaksi.transaksi_status' => $status];
        $like = null;
        $whereItems = null;
        $fileName = "Laporan Transaksi {$nama_status}";
        if (!empty($this->request->getPost('jenis_transaksi_id'))) {
          $whereItems['transaksi_item.jenis_transaksi_id'] = htmlspecialchars($this->request->getPost('jenis_transaksi_id'));
          $jenisTransaksiModel = new JenisTransaksiModel();
          $jenisTransaksi = $jenisTransaksiModel->find(htmlspecialchars($this->request->getPost('jenis_transaksi_id')));
          $fileName .= " {$jenisTransaksi['jenis_transaksi_nama']}";
        }
        if (!empty($this->request->getPost('siswa_nis'))) {
          $nis = htmlspecialchars($this->request->getPost('siswa_nis'));
          $like['siswa.siswa_nis'] = $nis;
          $fileName .= " {$nis}";
        }
        if (!empty($this->request->getPost('siswa_nama'))) {
          $nama = htmlspecialchars($this->request->getPost('siswa_nama'));
          $like['siswa.siswa_nama'] = $nama;
          $fileName .= " {$nama}";
        }
        if (!empty($this->request->getPost('date'))) {
          $date = explode('/', htmlspecialchars($this->request->getPost('date')));
          $where['transaksi.transaksi_created >='] = $date[0] . " 00:00:00";
          $where['transaksi.transaksi_created <='] = $date[1] . " 23:59:59";
          $dateName = str_replace("/", " - ", $this->request->getPost('date'));
          $fileName .= " {$dateName}";
        }
        $params['where'] = $where;
        $params['like'] = $like;
        $params['whereItems'] = $whereItems;
        return $this->excel_proses($params, $fileName);
      } else {
        throw new Exception("<p>Gagal Membuat Laporan Transaksi</p>");
      }
    } catch (Exception $th) {
      return $this->respond(["status" => 0, "message" => $th->getMessage(), "data" => []], 500);
    }
  }
  function excel_proses($params = [], $fileName)
  {
    helper('my');
    try {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet->setCellValue('A1', 'NO');
      $sheet->setCellValue('B1', 'NIS');
      $sheet->setCellValue('C1', 'Nama');
      $sheet->setCellValue('D1', 'Alamat');
      $sheet->setCellValue('E1', 'Jenis Transaksi');
      $sheet->setCellValue('F1', 'Total Harga');
      $sheet->setCellValue('G1', 'Kurang Bayar');
      $sheet->setCellValue('H1', 'Tanggal');
      $sheet->getColumnDimension('A')->setAutoSize(true);
      $sheet->getColumnDimension('B')->setAutoSize(true);
      $sheet->getColumnDimension('C')->setAutoSize(true);
      $sheet->getColumnDimension('D')->setAutoSize(true);
      $sheet->getColumnDimension('E')->setAutoSize(true);
      $sheet->getColumnDimension('F')->setAutoSize(true);
      $sheet->getColumnDimension('G')->setAutoSize(true);
      $sheet->getColumnDimension('H')->setAutoSize(true);
      $transaksis = $this->model->filter(0, 0, 'transaksi_id', 'ASC', $params);
      if (sizeof($transaksis) > 1) {
        $no = 1;
        $x = 2;
        foreach ($transaksis as $transaksi) {
          $item_transaksi = array_column($transaksi['items'], 'jenis_transaksi_nama');
          $sheet->setCellValue('A' . $x, $no++);
          $sheet->setCellValue('B' . $x, $transaksi['siswa_nis']);
          $sheet->setCellValue('C' . $x, $transaksi['siswa_nama']);
          $sheet->setCellValue('D' . $x, $transaksi['siswa_alamat']);
          $sheet->setCellValue('E' . $x, implode(", ", $item_transaksi));
          $sheet->setCellValue('F' . $x, $transaksi['total_harga']);
          $sheet->setCellValue('G' . $x, (int) $transaksi['total_harga'] - (int)$transaksi['telah_bayar']);
          $sheet->setCellValue('H' . $x, date('d-m-Y H:i', strtotime($transaksi['transaksi_created'])));
          $sheet->getStyle("F$x:G$x")->getNumberFormat()->setFormatCode('"Rp "#,##0.00_-');
          $x++;
        }
      }
      $writer = new Xlsx($spreadsheet);

      $fileUpload = "exports/{$fileName}.xlsx";
      $writer->save($fileUpload);
      return $this->respond(["status" => 1, "message" => "berhasil mengexport", "data" => ["url" => base_url($fileUpload)]], 200);
    } catch (Exception $th) {
      throw new Exception($th->getMessage());
    }
  }
}
