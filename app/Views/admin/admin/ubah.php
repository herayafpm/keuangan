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
          <label for="admin_nama" class="col-form-label">Nama</label>
          <input type="text" class="form-control col-sm-4 <?= ($_validation->hasError('admin_nama') ? "is-invalid" : "") ?>" id="admin_nama" name="admin_nama" placeholder="Masukkan nama" value="<?= old('admin_nama', $admin['admin_nama']) ?>">
          <div class="invalid-feedback">
            <?= $_validation->getError('admin_nama') ?>
          </div>
        </div>
        <div class="form-group">
          <label for="admin_username" class="col-form-label">Username</label>
          <input type="text" class="form-control col-sm-4 <?= ($_validation->hasError('admin_username') ? "is-invalid" : "") ?>" id="admin_username" name="admin_username" placeholder="Masukkan username" value="<?= old('admin_username', $admin['admin_username']) ?>">
          <div class="invalid-feedback">
            <?= $_validation->getError('admin_username') ?>
          </div>
        </div>
        <div class="form-group">
          <label for="admin_keterangan" class="col-form-label">Keterangan</label>
          <textarea class="form-control form-control-sm <?= ($_validation->hasError('admin_keterangan') ? "is-invalid" : "") ?>" id="admin_keterangan" rows="4" name="admin_keterangan" placeholder="Masukkan Keterangan (Opsional)"><?= old('admin_keterangan', $admin['admin_keterangan']) ?></textarea>
          <div class="invalid-feedback">
            <?= $_validation->getError('admin_keterangan') ?>
          </div>
        </div>
        <label for="admin_status" class="col-form-label">Status</label>
        <div class="form-group form-check">
          <input class="form-check-input" type="checkbox" value="1" id="admin_status" name="admin_status" <?= (old('admin_status', $admin['admin_status']) == 1) ? "checked" : "" ?>>
          <label class="form-check-label" for="admin_status">
            Aktif?
          </label>
          <div class="invalid-feedback">
            <?= $_validation->getError('admin_status') ?>
          </div>
        </div>
        <div class="form-group">
          <label for="admin_password" class="col-form-label">Password</label>
          <input type="password" class="form-control col-sm-4 <?= ($_validation->hasError('admin_password') ? "is-invalid" : "") ?>" id="admin_password" name="admin_password" placeholder="Password Baru (Kosongi jika tidak ingin diubah)">
          <div class="invalid-feedback">
            <?= $_validation->getError('admin_password') ?>
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
<?= $this->endSection('customjs'); ?>