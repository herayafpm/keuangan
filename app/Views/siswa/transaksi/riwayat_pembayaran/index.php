<?= $this->extend('siswa/template'); ?>
<?= $this->section('customcss'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-rowgroup/css/rowGroup.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/daterangepicker/daterangepicker.css" />

<?= $this->endSection('customcss'); ?>
<?= $this->section('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <!-- /.card-header -->
      <div class="card-body">
        <p>Harga Transaksi: Rp<?= format_rupiah($_total_bayar ?? "") ?></p>
        <p>Kurang Bayar: Rp<?= format_rupiah($_total_kurang_bayar) ?></p>
        <button class="btn btn-primary mb-1" onClick="detail()"><i class="fa fa-eye"></i> Detail Transaksi</button>
        <a class="btn btn-secondary mb-1" href="<?= $_url_back ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
        <table id="datatable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Jumlah Bayar</th>
              <th>Diverif</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Jumlah Bayar</th>
              <th>Diverif</th>
              <th>Tanggal</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
<div class="modal fade" id="detailTransaksiModel" tabindex="-1" role="dialog" aria-labelledby="detailTransaksiModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailTransaksiModelLabel">Detail Transaksi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" data-id="">
        <div class="row">
          <div class="col-4">
            Nama
          </div>
          <div class="col">
            : <span class="siswa_nama"></span>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            Alamat
          </div>
          <div class="col">
            : <span class="siswa_alamat"></span>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            Jenis Transaksi
          </div>
          <div class="col d-flex">
            <div class="">
              :
            </div>
            <div class="jenis_transaksi">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            Total Harga
          </div>
          <div class="col">
            : <span class="transaksi_bayar"></span>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            Total Kurang Bayar
          </div>
          <div class="col">
            : <span class="kurang_bayar"></span>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            Dibuat
          </div>
          <div class="col">
            : <span class="transaksi_by"></span>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            Tanggal Dibuat
          </div>
          <div class="col">
            : <span class="transaksi_created"></span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection('content'); ?>
<?= $this->section('customjs'); ?>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-rowgroup/js/dataTables.rowGroup.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-rowgroup/js/rowGroup.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/vendor') ?>/adminlte/plugins/inputmask/jquery.inputmask.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets/vendor') ?>/adminlte/plugins/daterangepicker/daterangepicker.js"></script>

<script>
  var tabel = null;
  var datas = [];
  var id = null;
  var data = {};
  var date = "";
  var start;
  var end;
  var transaksi;

  function detail() {
    $('.siswa_nama').html(transaksi.siswa_nama);
    $('.siswa_alamat').html(transaksi.siswa_alamat);
    $('.transaksi_bayar').html(formatRupiah(transaksi.total_harga));
    var kurang_bayar = transaksi.total_harga;
    if (transaksi.telah_bayar != null) {
      kurang_bayar = parseInt(transaksi.total_harga) - parseInt(transaksi.telah_bayar);
    }
    $('.kurang_bayar').html(formatRupiah("" + kurang_bayar));
    var jenis_transaksi = "<ul>"
    transaksi.items.forEach(element => {
      jenis_transaksi += "<li>"
      jenis_transaksi += element.jenis_transaksi_nama
      jenis_transaksi += "</li>"
    });
    jenis_transaksi += "</ul>"
    $('.jenis_transaksi').html(jenis_transaksi);
    $('.transaksi_by').html(transaksi.transaksi_by_admin_nama);
    $('.transaksi_created').html(toLocaleDate(transaksi.transaksi_created, 'LLL'));
    $('#detailTransaksiModel').modal()
  }

  $(function() {
    $(":input").inputmask();
    transaksi = <?= json_encode($_transaksi) ?>;
    tabel = $("#datatable").DataTable({
      "language": {
        "buttons": {
          "pageLength": {
            "_": "Tampil %d baris <i class='fas fa-fw fa-caret-down'></i>",
            "-1": "Tampil Semua <i class='fas fa-fw fa-caret-down'></i>"
          }
        },
        "lengthMenu": "Tampil _MENU_ data per hal",
        "zeroRecords": "Data tidak ditemukan",
        "info": "Tampil halaman _PAGE_ dari _PAGES_",
        "infoEmpty": "Tidak ada data",
        "infoFiltered": "(difilter dari _MAX_ total data)"
      },
      "dom": 'Bfrtip',
      "buttons": [{
        extend: "pageLength",
        attr: {
          "class": "btn btn-primary"
        },
      }, {
        text: '<i class="fas fa-fw fa-sync"></i> Segarkan',
        attr: {
          "class": "btn btn-info"
        },
        action: function(e, dt, node, config) {
          data = {};
          dt.ajax.reload()
        }
      }],
      "searching": false,
      "processing": true,
      "serverSide": true,
      "ordering": true, // Set true agar bisa di sorting
      "order": [
        [0, 'desc'],
      ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
      'columnDefs': [],
      "ajax": {
        "url": "<?= $_uri_datatable ?>", // URL file untuk proses select datanya
        "type": "POST",
        "data": function(d) {
          return {
            ...d,
            ...data
          }
        }
      },
      "initComplete": function(settings, json) {
        datas = json.data;
      },
      "scrollY": "<?= $_scroll_datatable ?>",
      "scrollCollapse": true,
      "lengthChange": true,
      "lengthMenu": [
        [10, 25, 50, -1],
        ['10 baris', '25 baris', '50 baris', 'Tampilkan Semua']
      ],
      "columns": [{
        "data": "transaksi_pembayaran_id",
      }, {
        "data": "transaksi_pembayaran_bayar",
        "render": function(data, type, row, meta) {
          return formatRupiah(row.transaksi_pembayaran_bayar, 'Rp');
        }
      }, {
        "data": "transaksi_pembayaran_by_admin_nama",
      }, {
        "data": "transaksi_pembayaran_created",
        "render": function(data, type, row, meta) {
          return toLocaleDate(row.transaksi_pembayaran_created)
        }
      }],
    });

    tabel.on('order.dt page.dt', function() {
      tabel.column(0, {
        order: 'applied',
        page: 'applied',
      }).nodes().each(function(cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();
    <?php if ($_session->getFlashdata('open_url')) : ?>
      window.open("<?= $_session->getFlashdata('open_url') ?>", '_blank')
    <?php endif; ?>
  });
</script>
<?= $this->endSection('customjs'); ?>