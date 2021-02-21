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
          <label for="siswa_nama" class="col-form-label">Nama</label>
          <input type="text" class="form-control col-sm-4 <?= ($_validation->hasError('siswa_nama') ? "is-invalid" : "") ?>" id="siswa_nama" name="siswa_nama" placeholder="Masukkan nama" value="<?= old('siswa_nama', $_siswa['siswa_nama']) ?>">
          <div class="invalid-feedback">
            <?= $_validation->getError('siswa_nama') ?>
          </div>
        </div>
        <div class="form-group">
          <label for="siswa_nis" class="col-form-label">NIS</label>
          <input type="text" class="form-control col-sm-4 <?= ($_validation->hasError('siswa_nis') ? "is-invalid" : "") ?>" id="siswa_nis" name="siswa_nis" placeholder="Masukkan NIS" value="<?= old('siswa_nis', $_siswa['siswa_nis']) ?>">
          <div class="invalid-feedback">
            <?= $_validation->getError('siswa_nis') ?>
          </div>
        </div>
        <div class="form-group">
          <label for="siswa_alamat">Alamat</label>
          <textarea class="form-control col-sm-4 <?= ($_validation->hasError('siswa_alamat') ? "is-invalid" : "") ?>" id="siswa_alamat" rows="3" name="siswa_alamat" placeholder="Masukkan Alamat"><?= old('siswa_alamat', $_siswa['siswa_alamat']) ?></textarea>
          <div class="invalid-feedback">
            <?= $_validation->getError('siswa_alamat') ?>
          </div>
        </div>
        <div class="form-group">
          <label for="siswa_password" class="col-form-label">Password</label>
          <input type="password" class="form-control col-sm-4 <?= ($_validation->hasError('siswa_password') ? "is-invalid" : "") ?>" id="siswa_password" name="siswa_password" placeholder="Password Baru (Kosongi jika tidak ingin diubah)">
          <div class="invalid-feedback">
            <?= $_validation->getError('siswa_password') ?>
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
  $(function() {
    $(":input").inputmask();
  })
</script>
<?= $this->endSection('customjs'); ?>