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
        <p>Harga Transaksi: Rp<?= format_rupiah($_total_bayar ?? "") ?></p>
        <p>Kurang Bayar: Rp<?= format_rupiah($_total_kurang_bayar) ?></p>
        <?= form_open() ?>
        <div class="form-group row">
          <label for="transaksi_pembayaran_bayar" class="col-sm-2 col-form-label">Nominal Bayar</label>
          <div class="col-sm-4">
            <input type="text" class="form-control money <?= ($_validation->hasError('transaksi_pembayaran_bayar') ? "is-invalid" : "") ?>" id="transaksi_pembayaran_bayar" name="transaksi_pembayaran_bayar" placeholder="Masukkan Nominal Bayar" value="<?= old('transaksi_pembayaran_bayar') ?>">
            <div class="invalid-feedback">
              <?= $_validation->getError('transaksi_pembayaran_bayar') ?>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="transaksi_pembayaran_keterangan" class="col-sm-2 col-form-label">Untuk Pembayaran</label>
          <div class="col-sm-8">
            <textarea class="form-control form-control-sm <?= ($_validation->hasError('transaksi_pembayaran_keterangan') ? "is-invalid" : "") ?>" id="transaksi_pembayaran_keterangan" rows="4" name="transaksi_pembayaran_keterangan" placeholder="Masukkan Keterangan (Opsional)"><?= old('transaksi_pembayaran_keterangan', $_transaksi_item['jenis_transaksi_nama']) ?></textarea>
            <div class="invalid-feedback">
              <?= $_validation->getError('transaksi_pembayaran_keterangan') ?>
            </div>
          </div>
        </div>
        <button class="btn btn-primary py-2 px-3" type="submit">Simpan</button>
        <a class="btn btn-secondary py-2 px-3" role="button" href="<?= $_url_back ?>">Kembali</a>
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
<script src="<?= base_url('assets/vendor/adminlte') ?>/plugins/select2/js/select2.full.min.js"></script>
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
  })
</script>
<?= $this->endSection('customjs'); ?>