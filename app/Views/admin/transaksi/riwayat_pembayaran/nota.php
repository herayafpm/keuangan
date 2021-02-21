<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title><?= $_title ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link href="<?= base_url('assets/css/report.css') ?>" rel="stylesheet" type="text/css">
  <style>
    body {
      counter-reset: page;
    }

    #pageFooter {
      page-break-after: always;
      counter-increment: page;
    }

    #pageFooter:after {
      display: block;
      text-align: right;
      padding: 5px 20px;
      content: "Halaman "counter(page);
    }

    @media print {
      @page {
        size: 5.8in 8.2in;
        size: landscape;
      }
    }

    #sign {
      margin-top: 100px;
      padding: 20px 20px;
    }
  </style>
  <?php $this->renderSection('customcss') ?>
</head>

<body>
  <div id="body">
    <table style="page-break-after: none;">
      <tbody>
        <tr>
          <td style="padding: 5px 20px;" colspan="3">
            <?= env("app.appName") ?>
          </td>
        </tr>
        <tr>
          <td style="padding: 5px 20px;" colspan="3">
            <hr style="border-bottom: 2px solid #000000; height:0px;">
          </td>
        </tr>
        <tr>
          <td style="padding: 5px 20px;" colspan="3">
            <div style="display:flex;text-align: justify;margin-bottom: 5px;">
              <div style="width: 130px;">No Kwitansi</div>
              <div style="margin-right: 10px;">:</div>
              <div style="flex:1"> ...........................................</div>
            </div>
            <div style="display:flex;text-align: justify;margin-bottom: 5px;">
              <div style="width: 130px;">Telah terima dari</div>
              <div style="margin-right: 10px;">:</div>
              <div style="flex:1"> <?= $transaksi['siswa_nama'] ?></div>
            </div>
            <div style="display:flex;text-align: justify;margin-bottom: 5px;">
              <div style="width: 130px;">Uang Sejumlah</div>
              <div style="margin-right: 10px;">:</div>
              <div style="flex:1"> Rp.<?= format_rupiah($transaksi_pembayaran['transaksi_pembayaran_bayar']) ?></div>
            </div>
            <div style="display:flex;text-align: justify;margin-bottom: 5px;">
              <div style="width: 130px;">Untuk pembayaran</div>
              <div style="margin-right: 10px;">:</div>
              <div style="flex:1"> <?= $transaksi_pembayaran['transaksi_pembayaran_keterangan'] ?></div>
            </div>

            <div style="display:flex;text-align: justify;margin-bottom: 5px;">
              <div style="width: 130px;">Tanggal</div>
              <div style="margin-right: 10px;">:</div>
              <div style="flex:1"> <?= $tanggal_transaksi_pembayaran ?></div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <div id="sign">
      <table style="width: 300px;">
        <tr>
          <td align="center" style="width:60px;padding: 20px 20px;">
            <p align="left">Purwokerto, <?= $tanggal_sekarang ?></p>
            <p>Petugas</p>
            <br>
            <br>
            <br>
            <p style="border-bottom: 1px solid rgba(0, 0, 0, 0.6);"><?= $admin->admin_nama ?></p>
          </td>
        </tr>
      </table>
    </div>
    <!-- <div id="content">
      <div id="pageFooter">
      </div>
    </div> -->
  </div>
  <script>
    window.print()
  </script>
</body>

</html>