<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $_title; ?> | <?= env("app.appName") ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte/plugins') ?>/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/sweetalert2/sweetalert2.min.css">
  <?= $this->renderSection('customcss'); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed text-sm">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?= base_url('siswa/dashboard') ?>" class="nav-link">Dashboard</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= base_url('siswa/dashboard') ?>" class="brand-link navbar-primary">
        <img src="<?= base_url('assets/vendor/adminlte') ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= env("app.appName") ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?= base_url('assets/vendor/adminlte') ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block text-capitalize"><?= $_siswa['siswa_nama'] ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent nav-legacy" data-widget="treeview" role="menu" data-accordion="true">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="<?= base_url('siswa/dashboard') ?>" class="nav-link <?= (strpos($uri, "dashboard") !== false) ? "active" : "" ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-header">Transaksi</li>
            <?php if (sizeof($_transaksi_statuses) > 0) : ?>
              <?php
              $no = 0;
              foreach ($_transaksi_statuses as $status) : ?>
                <?php
                $icon = "clock";
                if ($no == 1) {
                  $icon = "check";
                }
                ?>
                <li class="nav-item">
                  <a href='<?= base_url("siswa/transaksi/{$no}") ?>' class="nav-link <?= (strpos($uri, "siswa/transaksi/{$no}") !== false) ? "active" : "" ?>">
                    <i class="nav-icon fas fa-<?= $icon ?>"></i>
                    <p class="text-capitalize">
                      Transaksi <?= $status ?>
                    </p>
                  </a>
                </li>
              <?php
                $no++;
              endforeach ?>
            <?php endif ?>
            <li class="nav-header">Akun</li>
            <li class="nav-item">
              <a href="<?= base_url('siswa/log') ?>" class="nav-link <?= (strpos($uri, "siswa/log") !== false) ? "active" : "" ?>">
                <i class="nav-icon fas fa-user-clock"></i>
                <p>
                  Riwayat Masuk
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" onclick="logout()" class="nav-link">
                <i class="nav-icon fas fa-power-off"></i>
                <p>
                  Logout
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1 class="m-0"><?= $_title ?></h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <?= $this->renderSection('content'); ?>
        </div>
        <!--/. container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2014-<?= date('Y') ?> Made With <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.1.0-rc
      </div>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/vendor/adminlte') ?>/dist/js/adminlte.js"></script>
  <script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="<?= base_url('assets/vendor/moment/moment-with-locales.js') ?>"></script>

  <script>
    function hapusData({
      fun,
      title = 'Konfirmasi hapus data',
      text = 'Yakin ingin menghapus data ini?'
    }) {
      Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya hapus',
        cancelButtonText: "Tidak",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          fun()
        }
      })

    }
    var Toast = null

    function logout() {
      Swal.fire({
        title: 'Yakin ingin mengakhiri sesi?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location = "<?= base_url('auth/logout') ?>"
        }
      })
    }

    function formatRupiah(angka, prefix) {
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function toLocaleDate(date, format = 'LL') {
      moment.locale('id')
      return moment(date).format(format)
    }
    $(function() {
      Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 8000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })
      <?php if ($_session->getFlashdata('success')) : ?>
        Toast.fire({
          icon: 'success',
          title: "<?= $_session->getFlashdata('success') ?>"
        })
      <?php endif; ?>
      <?php if ($_session->getFlashdata('error')) : ?>
        Toast.fire({
          icon: 'error',
          title: "<?= $_session->getFlashdata('error') ?>"
        })
      <?php endif; ?>
      $('.toLocaleDate').html(toLocaleDate($('.toLocaleDate').html(), 'LLL'))
      $('.toLocaleDateOnly').html(toLocaleDate($('.toLocaleDate').html(), 'LL'))
    });
  </script>
  <?= $this->renderSection('customjs'); ?>
</body>

</html>