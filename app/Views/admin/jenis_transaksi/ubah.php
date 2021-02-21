<?= $this->extend('admin/template'); ?>
<?= $this->section('customcss'); ?>
<?= $this->endSection('customcss'); ?>
<?= $this->section('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <?= form_open() ?>
        <div class="form-group">
          <label for="jenis_transaksi_nama" class="col-form-label">Nama Transaksi</label>
          <input type="text" class="form-control col-sm-4 <?= ($_validation->hasError('jenis_transaksi_nama') ? "is-invalid" : "") ?>" id="jenis_transaksi_nama" name="jenis_transaksi_nama" placeholder="Masukkan nama transaksi" value="<?= old('jenis_transaksi_nama', $jenis_transaksi['jenis_transaksi_nama']) ?>">
          <div class="invalid-feedback">
            <?= $_validation->getError('jenis_transaksi_nama') ?>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis_transaksi_harga" class="col-form-label">Harga Transaksi</label>
          <input type="text" class="form-control money col-sm-4 <?= ($_validation->hasError('jenis_transaksi_harga') ? "is-invalid" : "") ?>" id="jenis_transaksi_harga" name="jenis_transaksi_harga" placeholder="Masukkan Nominal Harga Transaksi" value="<?= old('jenis_transaksi_harga', $jenis_transaksi['jenis_transaksi_harga']) ?>">
          <div class="invalid-feedback">
            <?= $_validation->getError('jenis_transaksi_harga') ?>
          </div>
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
<!-- /.row -->
<?= $this->endSection('content'); ?>
<?= $this->section('customjs'); ?>
<script src="<?= base_url('assets/vendor') ?>/adminlte/plugins/inputmask/jquery.inputmask.min.js"></script>
<script>
  $(document).ready(function() {
    $(".money").inputmask('integer', {
      'removeMaskOnSubmit': true,
      'alias': 'numeric',
      'groupSeparator': '.',
      'autoGroup': true,
      'digitsOptional': false,
      'allowMinus': false,
      'placeholder': '0'
    });
  });
</script>
<?= $this->endSection('customjs'); ?>