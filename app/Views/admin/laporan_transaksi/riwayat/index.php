<?= $this->extend('admin/template'); ?>
<?= $this->section('customcss'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-rowgroup/css/rowGroup.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<?= $this->endSection('customcss'); ?>
<?= $this->section('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <!-- /.card-header -->
      <div class="card-body">
        <h5>Filter</h5>
        <div class="form-group row">
          <div class="col-md-4 mb-1"><input class="form-control form-control-sm" type="text" id="siswa_nis" placeholder="NIS (min 3 karakter)" /></div>
          <div class="col-md-4 mb-1"><input class="form-control form-control-sm" type="text" id="siswa_nama" placeholder="Nama (min 3 karakter)" /></div>
          <div class="col-md-4 mb-1">
            <select class="form-control form-control-sm" id="jenis_transaksi_id">
              <option value="">--Pilih Jenis Transaksi--</option>
              <?php foreach ($_jenis_transaksis as $jenis_transaksi) : ?>
                <option value="<?= $jenis_transaksi['jenis_transaksi_id'] ?>"><?= $jenis_transaksi['jenis_transaksi_nama'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-4 mb-1">
            <div id="daterange" class="form-control form-control-sm"><span class="date">Pilih Tanggal</span> <i class="fa fa-fw fa-calendar"></i>&nbsp;<span></span> <i class="fa fa-caret-down"></i></div>
          </div>
        </div>
        <table id="datatable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>NIS</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Jenis Transaksi</th>
              <th>Kurang Bayar</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
            <tr>
              <th>No</th>
              <th>NIS</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Jenis Transaksi</th>
              <th>Kurang Bayar</th>
              <th>Tanggal</th>
              <th>Aksi</th>
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
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/select2/js/select2.full.min.js"></script>

<script>
  var tabel = null;
  var datas = [];
  var id = null;
  var data = {};
  var date = "";
  var start;
  var end;

  function detail(index) {
    var transaksi = datas[index];
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
    $('#jenis_transaksi_id').select2({});
    $(":input").inputmask();
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
        text: '<i class="fas fa-fw fa-file-excel"></i> Export Excel',
        attr: {
          "class": "btn btn-success"
        },
        action: function(e, dt, node, config) {
          $.ajax({
              method: "POST",
              url: "<?= $_uri_excel ?>",
              data: data,
            })
            .done(function(res) {
              if (res.status == 1) {
                window.open(res.data.url, "_blank")
              }
            });
        }
      }, {
        text: '<i class="fas fa-fw fa-sync"></i> Segarkan',
        attr: {
          "class": "btn btn-info"
        },
        action: function(e, dt, node, config) {
          data = {};
          $('#jenis_transaksi_id').val('');
          $('#siswa_nis').val('');
          $('.date').html('Pilih Tanggal');
          start = moment();
          end = moment();
          cb(start, end)
          dt.ajax.reload()
        }
      }],
      "searching": false,
      "processing": true,
      "serverSide": true,
      "ordering": true, // Set true agar bisa di sorting
      "order": [
        [6, 'desc'],
      ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
      'columnDefs': [{
        "targets": [7],
        "orderable": false
      }],
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
          "data": "transaksi_id",
        }, {
          "data": "siswa_nis",
        }, {
          "data": "siswa_nama",
        }, {
          "data": "siswa_alamat",
        }, {
          "render": function(data, type, row, meta) { // Tampilkan kolom aksi
            var html = "<ul>"
            row.items.forEach(element => {
              html += "<li>"
              html += element.jenis_transaksi_nama
              html += "</li>"
            });
            html += "</ul>"
            return html
          }
        }, {
          "data": "telah_bayar",
          "render": function(data, type, row, meta) { // Tampilkan kolom aksi
            var kurang_bayar = row.total_harga;
            if (row.telah_bayar != null) {
              kurang_bayar = parseInt(row.total_harga) - parseInt(row.telah_bayar);
            }
            return formatRupiah("" + kurang_bayar)
          }
        }, {
          "data": "transaksi_created",
          "render": function(data, type, row, meta) { // Tampilkan kolom aksi
            return toLocaleDate(row.transaksi_created)
          }
        },
        {
          "render": function(data, type, row, meta) { // Tampilkan kolom aksi
            var html = '<button type="button" class="btn btn-link text-info" onClick="detail(' + meta.row + ')"><i class="fa fa-fw fa-eye" aria-hidden="true" title="Detail"></i></button>'
            return html
          }
        },
      ],
    });

    tabel.on('order.dt page.dt', function() {
      tabel.column(0, {
        order: 'applied',
        page: 'applied',
      }).nodes().each(function(cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();
    $('#siswa_nis').on('keyup change clear', function() {
      var value = $(this).val();
      var min_karakter = 3;
      if (value.length >= min_karakter) {
        data.siswa_nis = value;
      }
      if (value.length == 0 && value.length < min_karakter) {
        data.siswa_nis = "";
      }
      if (value.length >= min_karakter || value.length == 0) {
        tabel.ajax.reload(null, function(data) {
          datas = json.data
        })
      }
    })
    $('#siswa_nama').on('keyup change clear', function() {
      var value = $(this).val();
      var min_karakter = 3;
      if (value.length >= min_karakter) {
        data.siswa_nama = value;
      }
      if (value.length == 0 && value.length < min_karakter) {
        data.siswa_nama = "";
      }
      if (value.length >= min_karakter || value.length == 0) {
        tabel.ajax.reload(null, function(data) {
          datas = json.data
        })
      }
    })
    $('#jenis_transaksi_id').on('change clear', function() {
      var value = $(this).val();
      data.jenis_transaksi_id = value;
      tabel.ajax.reload(null, function(data) {
        datas = json.data
      })
    })

    moment.locale('id')
    start = moment();
    end = moment();

    function cb(start, end) {
      data.date = start.format('YYYY-MM-D') + '/' + end.format('YYYY-MM-D');
      $('.date').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'))
      tabel.ajax.reload(function(json) {
        datas = json.data
      })
    }

    $('#daterange').daterangepicker({
      showDropdowns: true,
      autoApply: false,
      startDate: start,
      endDate: end,
      locale: {
        customRangeLabel: 'Tentukan Sendiri',
        cancelLabel: 'Batal',
        applyLabel: 'Pilih',
      },
      ranges: {
        'Hari ini': [moment(), moment()],
        'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        '7 Hari terakhir': [moment().subtract(6, 'days'), moment()],
        '30 Hari terakhir': [moment().subtract(29, 'days'), moment()],
        'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
        'Bulan sebelumnya': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
    }, cb);
    cb(start, end)
    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
      cb(picker.startDate, picker.endDate)
    })
    <?php if ($_session->getFlashdata('open_url')) : ?>
      window.open("<?= $_session->getFlashdata('open_url') ?>", '_blank')
    <?php endif; ?>
  });
</script>
<?= $this->endSection('customjs'); ?>