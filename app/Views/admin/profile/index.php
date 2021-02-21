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
          <label for="admin_nama" class="col-form-label">Nama Admin</label>
          <input type="text" class="form-control col-sm-4 <?= ($_validation->hasError('admin_nama') ? "is-invalid" : "") ?>" id="admin_nama" name="admin_nama" placeholder="Masukkan nama admin" value="<?= old('admin_nama') ?? $_admin->aparatur_nama ?? $_admin->admin_nama ?>" <?= (isset($_admin->aparatur_id)) ? "disabled" : "" ?>>
          <div class="invalid-feedback">
            <?= $_validation->getError('admin_nama') ?>
          </div>
        </div>
        <div class="form-group">
          <label for="admin_password" class="col-form-label">Password</label>
          <input type="password" class="form-control col-sm-4 <?= ($_validation->hasError('admin_password') ? "is-invalid" : "") ?>" id="admin_password" name="admin_password" placeholder="(kosongi jika tidak ingin diubah)">
          <div class="invalid-feedback">
            <?= $_validation->getError('admin_password') ?>
          </div>
        </div>
        <button class="btn btn-primary py-2 px-3" type="submit">Ubah</button>
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

<?= $this->endSection('customjs'); ?>