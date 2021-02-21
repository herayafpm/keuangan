<?= $this->extend('admin/template'); ?>
<?= $this->section('customcss'); ?>
<link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?= base_url('assets/vendor/adminlte') ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<?= $this->endSection('customcss'); ?>
<?= $this->section('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <?= form_open() ?>
        <div class="form-group row">
          <div class="col-sm-6">
            <div class="row">
              <label for="siswa_nis" class="col-sm-4 col-form-label">NIS</label>
              <div class="col-sm-8">
                <input type="text" class="form-control form-control-sm <?= ($_validation->hasError('siswa_nis') ? "is-invalid" : "") ?>" id="siswa_nis" name="siswa_nis" placeholder="Masukkan NIS (min 3 karakter)" value="<?= old('siswa_nis') ?>">
                <div class="invalid-feedback">
                  <?= $_validation->getError('siswa_nis') ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row">
              <label for="siswa_nama" class="col-sm-2 col-form-label">Nama</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm <?= ($_validation->hasError('siswa_nama') ? "is-invalid" : "") ?>" id="siswa_nama" name="siswa_nama" placeholder="Masukkan Nama" value="<?= old('siswa_nama') ?>">
                <div class="invalid-feedback">
                  <?= $_validation->getError('siswa_nama') ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="siswa_alamat" class="col-sm-2 col-form-label">Alamat</label>
          <div class="col-sm-10">
            <textarea class="form-control form-control-sm <?= ($_validation->hasError('siswa_alamat') ? "is-invalid" : "") ?>" id="siswa_alamat" rows="3" name="siswa_alamat" placeholder="Masukkan Alamat"><?= old('siswa_alamat') ?></textarea>
            <div class="invalid-feedback">
              <?= $_validation->getError('siswa_alamat') ?>
            </div>
          </div>
        </div>


        <input type="hidden" name="jenis_transaksi_ids[]" class="form-jenis_transaksi_ids" value="<?= implode(",", old('jenis_transaksi_ids') ?? []) ?>">
        <input type="hidden" name="jenis_transaksi_namas[]" class="form-jenis_transaksi_namas" value="<?= implode(",", old('jenis_transaksi_namas') ?? []) ?>">
        <input type="hidden" name="jenis_transaksi_hargas[]" class="form-jenis_transaksi_hargas" value="<?= implode(",", old('jenis_transaksi_hargas') ?? []) ?>">
        <input type="hidden" name="transaksi_pembayaran_bayars[]" class="form-transaksi_pembayaran_bayars" value="<?= implode(",", old('transaksi_pembayaran_bayars') ?? []) ?>">
        <?php if ($_validation->hasError('jenis_transaksi_ids')) : ?>
          <p class="text-danger">*<?= $_validation->getError('jenis_transaksi_ids') ?></p>
        <?php endif ?>
        <button class="btn btn-success py-1 px-2 mb-2" type="button" onclick="openModal(0)"><i class="fas fa-fw fa-plus"></i>Tambah Jenis Transaksi</button>
        <div class="table-responsive">
          <table class="table table-stripped table-hover">
            <thead>
              <th>#</th>
              <th>Jenis Transaksi</th>
              <th>Harga</th>
              <th>Nominal Bayar</th>
              <th>Aksi</th>
            </thead>
            <tbody class="tbody-jenis_transaksi">
            </tbody>
          </table>
        </div>
        <button class="btn btn-primary py-2 px-3" type="submit">Simpan</button>
        <?= form_close() ?>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<?= $this->endSection('content'); ?>
<?= $this->section('modal') ?>
<div class="modal fade" id="jenisTransaksiModal" tabindex="-1" role="dialog" aria-labelledby="jenisTransaksiModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="jenisTransaksiModalLabel">Tambah Jenis Transaksi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" data-id="">
        <div class="form-group">
          <label for="jenis_transaksi_id" class="col-form-label">Jenis Transaksi</label>
          <div class="col-lg-12">
            <select class="form-control form-control-sm" id="jenis_transaksi_id" name="jenis_transaksi_id" data-nama="">
              <option value="">-- Jenis Transaksi --</option>
              <?php foreach ($_jenis_transaksis as $jenis_transaksi) : ?>
                <option data-nama="<?= $jenis_transaksi['jenis_transaksi_nama'] ?>" value="<?= $jenis_transaksi['jenis_transaksi_id'] ?>" data-harga="<?= $jenis_transaksi['jenis_transaksi_harga'] ?>"><?= $jenis_transaksi['jenis_transaksi_nama'] ?> Rp. <?= format_rupiah($jenis_transaksi['jenis_transaksi_harga']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis_transaksi_harga" class="col-form-label">Harga Transaksi</label>
          <div class="col-lg-12">
            <input type="text" class="form-control money" id="jenis_transaksi_harga" name="jenis_transaksi_harga" placeholder="Masukkan Nominal Harga Transaksi">
          </div>
        </div>
        <div class="form-group">
          <label for="transaksi_pembayaran_bayar" class="col-form-label">Nominal Bayar</label>
          <div class="col-lg-12">
            <input type="text" class="form-control money" id="transaksi_pembayaran_bayar" name="transaksi_pembayaran_bayar" placeholder="Masukkan Nominal Bayar">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary btn-ubah-jenis">Ubah</button>
        <button type="button" class="btn btn-primary btn-tambah-jenis">Tambah</button>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection('modal') ?>
<?= $this->section('customjs'); ?>
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/select2/js/select2.full.min.js"></script>
<script src="<?= base_url('assets/vendor') ?>/adminlte/plugins/inputmask/jquery.inputmask.min.js"></script>

<script>
  var jenis_transaksi_ids = [];
  var jenis_transaksi_namas = [];
  var jenis_transaksi_hargas = [];
  var transaksi_pembayaran_bayars = [];
  var jenis;
  var harga;
  var bayar;

  function openModal(tipe, index) {
    $('#jenis_transaksi_id').select2({});
    $('#jenis_transaksi_id').on('change', function() {
      var harga = $(this).find(":selected").data('harga')
      $('#jenis_transaksi_harga').val(harga)
    })
    $(".money").inputmask('integer', {
      'removeMaskOnSubmit': true,
      'alias': 'numeric',
      'groupSeparator': '.',
      'autoGroup': true,
      'digitsOptional': false,
      'allowMinus': false,
      'placeholder': '0'
    });
    clearJenisUTTP()
    if (tipe == 0) {
      $('#jenisTransaksiModalLabel').html("Tambah Jenis Transaksi")
      $('.btn-ubah-jenis').addClass('d-none');
      $('.btn-tambah-jenis').removeClass('d-none');
    } else {
      $('#jenisTransaksiModalLabel').html("Ubah Jenis Transaksi")
      $('.btn-tambah-jenis').addClass('d-none');
      $('.btn-ubah-jenis').removeClass('d-none');
      $('#jenis_transaksi_id').val(jenis_transaksi_ids[index]);
      $('#jenis_transaksi_id').trigger('change');
      $('#jenis_transaksi_harga').val(jenis_transaksi_hargas[index]);
      $('#transaksi_pembayaran_bayar').val(transaksi_pembayaran_bayars[index]);
      $('#jenisTransaksiModal').find('.modal-body').data('id', index)
    }
    $('#jenisTransaksiModal').modal()
    $("#jenis_transaksi_id").change(function() {
      $(this).data('nama', $(this).find(":selected").data('nama'))
    });

  }
  $(document).ready(function() {
    $('.btn-tambah-jenis').on('click', function() {
      var isValid = validation()
      if (isValid) {
        jenis_transaksi_namas.push($("#jenis_transaksi_id").data('nama'))
        jenis_transaksi_ids.push(jenis)
        jenis_transaksi_hargas.push(harga)
        transaksi_pembayaran_bayars.push(bayar)
        updateTabel()
        clearJenisUTTP()
        $('#jenisTransaksiModal').modal('hide')
      }
    })
    $('.btn-ubah-jenis').on('click', function() {
      var index = $("#jenisTransaksiModal").find('.modal-body').data('id')
      var isValid = validation()
      if (isValid) {
        var nama = $('#jenis_transaksi_id').data('nama');
        jenis_transaksi_ids.splice(index, 1, jenis);
        if (nama != "") {
          jenis_transaksi_namas.splice(index, 1, nama);
        }
        jenis_transaksi_hargas.splice(index, 1, harga);
        transaksi_pembayaran_bayars.splice(index, 1, bayar);
        updateTabel()
        clearJenisUTTP()
        $('#jenisTransaksiModal').modal('hide')
      }
    })
    $('#siswa_nis').on('keyup change clear', function() {
      var value = $(this).val();
      var min_karakter = 3;
      if (value.length >= min_karakter) {
        $.ajax("<?= base_url('api/siswa/') ?>?siswa_nis=" + value)
          .done(function(json) {
            if (json.data != null) {
              $('#siswa_nama').val(json.data.siswa_nama)
              $('#siswa_alamat').val(json.data.siswa_alamat)
            }
          })
      }
    })
    jenis_transaksi_ids = $('.form-jenis_transaksi_ids').val().split(",").filter((e) => e != "")
    jenis_transaksi_namas = $('.form-jenis_transaksi_namas').val().split(",").filter((e) => e != "")
    jenis_transaksi_hargas = $('.form-jenis_transaksi_hargas').val().split(",").filter((e) => e != "")
    transaksi_pembayaran_bayars = $('.form-transaksi_pembayaran_bayars').val().split(",").filter((e) => e != "")
    updateTabel()

  })

  function clearJenisUTTP() {
    $('.form-jenis_transaksi_ids').val(jenis_transaksi_ids)
    $('.form-jenis_transaksi_namas').val(jenis_transaksi_namas)
    $('.form-jenis_transaksi_hargas').val(jenis_transaksi_hargas)
    $('.form-transaksi_pembayaran_bayars').val(transaksi_pembayaran_bayars)
    $("#jenis_transaksi_id").data('nama', "")
    $('#jenis_transaksi_id').val("");
    $('#jenis_transaksi_id').trigger('change');
    $('#jenis_transaksi_harga').val("");
    $('#transaksi_pembayaran_bayar').val("");
  }

  function hapus(index) {
    jenis_transaksi_ids.splice(index, 1);
    jenis_transaksi_namas.splice(index, 1);
    jenis_transaksi_hargas.splice(index, 1);
    transaksi_pembayaran_bayars.splice(index, 1);
    clearJenisUTTP()
    updateTabel()
  }

  function updateTabel() {
    $('.tbody-jenis_transaksi').html("")
    var html = ""
    jenis_transaksi_ids.forEach((item, index) => {
      html += "<tr>"
      html += "<td>"
      html += index + 1
      html += "</td>"
      html += "<td>"
      html += jenis_transaksi_namas[index]
      html += "</td>"
      html += "<td>"
      html += formatRupiah(jenis_transaksi_hargas[index])
      html += "</td>"
      html += "<td>"
      html += formatRupiah(transaksi_pembayaran_bayars[index])
      html += "</td>"
      html += "<td>"
      html += '<button type="button" class="btn btn-link text-info" onClick="openModal(1,' + index + ')"><i class="fa fa-fw fa-edit" aria-hidden="true" title="Edit Jenis Transaksi' + jenis_transaksi_namas[index] + '"></i></button>'
      html += '<button type="button" class="btn btn-link text-danger" onClick="hapus(' + index + ')"><i class="fa fa-fw fa-trash" aria-hidden="true" title="Hapus Jenis Transaksi' + jenis_transaksi_namas[index] + '"></i></button>'
      html += "</td>"
      html += "</tr>"
    })
    $('.tbody-jenis_transaksi').html(html)
  }

  function validation() {
    jenis = $('#jenis_transaksi_id').val();
    harga = $('#jenis_transaksi_harga').inputmask('unmaskedvalue');
    bayar = $('#transaksi_pembayaran_bayar').inputmask('unmaskedvalue');
    if (jenis == "") {
      showError("Jenis Transaksi harus dipilih")
      return false;
    }
    if (harga == "" || parseInt(harga) == 0) {
      showError("harga tidak boleh kosong")
      return false;
    }
    if (bayar == "" || parseInt(bayar) == 0) {
      showError("nominal bayar tidak boleh kosong")
      return false;
    }
    if (parseInt(bayar) > parseInt(harga)) {
      showError("nominal bayar tidak boleh lebih dari harga transaksi")
      return false;
    }
    return true;
  }

  function showError(title) {
    Swal.fire({
      icon: 'error',
      title: title
    });
  }
</script>
<?= $this->endSection('customjs'); ?>