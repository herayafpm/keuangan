<?= $this->extend('admin/template'); ?>
<?= $this->section('customcss'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<?= $this->endSection('customcss'); ?>
<?= $this->section('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <!-- /.card-header -->
      <div class="card-body">
        <div class="form-group">
          <label for="files">Import Excel (CSV)</label>
          <input type="file" class="form-control-file" id="files" accept=".csv" required>
        </div>
        <button class="btn btn-success py-2 px-3 mb-2" id="importData" type="button" onclick="importData()"><i class="fas fa-fw fa-file-import"></i> Import</button>
        <button class="btn btn-danger py-2 px-3 mb-2" type="button" onclick="reset()">Reset</button>
        <table id="datatable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>NIS</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Status</th>
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
              <th>Status</th>
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
<?= $this->endSection('content'); ?>
<?= $this->section('customjs'); ?>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url('assets/vendor') ?>/papaparse/papaparse.min.js"></script>
<script>
  var tabel = null;
  var datas = [];
  var id = null;
  var data = {};

  function reset() {
    $('#files').val('')
    datas = []
    tabel.clear().rows.add(datas).draw();
  }

  function importData() {
    if ($('#files').val() != '') {
      $('#importData').html('<i class="fas fa-circle-notch fa-spin"></i>')
      $('#importData').prop('disabled', true)
      datas.forEach((element, index) => {
        var data = {
          ...element,
          index
        }
        datas[index] = {
          ...element,
          status: '<span class="text-info"><i class="fas fa-circle-notch fa-spin"></i> Proses</span>'
        }
        $.ajax({
            method: "POST",
            url: "<?= base_url('api/siswa') ?>",
            data: data
          })
          .done(function(res) {
            if (res.status == 1) {
              datas[res.data.index] = {
                ...element,
                status: '<span class="text-success"><i class="fas fa-check"></i> ' + res.message + '</span>'
              }
            } else {
              datas[res.data.index] = {
                ...element,
                status: '<span class="text-danger"><i class="fas fa-times"></i> ' + res.message + '</span>'
              }
            }
            if (res.data.index == datas.length - 1) {
              $('#importData').html('<i class="fas fa-fw fa-file-import"></i> Import')
              $('#importData').prop('disabled', false)
              Toast.fire({
                icon: 'success',
                title: "Selesai mengimpor"
              })
            }
            tabel.clear().rows.add(datas).draw();
          });
        tabel.clear().rows.add(datas).draw();
      });
    }
  }
  $(function() {
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
      }],
      "data": datas,
      "searching": true,
      "ordering": true, // Set true agar bisa di sorting
      "order": [
        [0, 'desc']
      ],
      "scrollY": "<?= $_scroll_datatable ?>",
      "scrollCollapse": true,
      "lengthChange": true,
      "lengthMenu": [
        [10, 25, 50, -1],
        ['10 baris', '25 baris', '50 baris', 'Tampilkan Semua']
      ],
      "columns": [{
          "data": "no",
        },
        {
          "data": "siswa_nis",
        },
        {
          "data": "siswa_nama",
        },
        {
          "data": "siswa_alamat",
        },
        {
          "data": "status",
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

    $('#files').on('change', function() {
      $('#files').parse({
        config: {
          delimiter: ";",
          complete: function(results, file) {
            var ds = results.data;
            datas = []
            for (let index = 1; index < ds.length; index++) {
              const element = ds[index];
              if (element[0] != "") {
                datas.push({
                  "no": element[0],
                  "siswa_nis": element[1],
                  "siswa_nama": element[2],
                  "siswa_alamat": element[3],
                  "status": "belum diproses"
                })
              }
            }
            tabel.clear().rows.add(datas).draw();
          },
        },
        before: function(file, inputElem) {
          console.log("Parsing file...", file);
        },
        error: function(err, file) {
          console.log("ERROR:", err, file);
        },
        complete: function() {
          console.log("Done with all files");
        }
      });
    })
  });
</script>
<?= $this->endSection('customjs'); ?>