<?= $this->extend('auth/template') ?>
<?= $this->section('customcss') ?>
<?= $this->endSection('customcss'); ?>
<?= $this->section('content') ?>
<p class="login-box-msg">Masuk Aplikasi</p>
<?= form_open(); ?>
<div class="input-group mb-3">
  <input type="username" class="form-control  <?= ($_validation->hasError('username') ? "is-invalid" : "") ?>" name="username" placeholder="Username / NIS">
  <div class="input-group-append">
    <div class="input-group-text">
      <span class="fas fa-user"></span>
    </div>
  </div>
  <div class="invalid-feedback">
    <?= $_validation->getError('username') ?>
  </div>
</div>
<div class="input-group mb-3">
  <input type="password" class="form-control <?= ($_validation->hasError('password') ? "is-invalid" : "") ?>" name="password" placeholder="Password">
  <div class="input-group-append">
    <div class="input-group-text">
      <span class="fas fa-lock"></span>
    </div>
  </div>
  <div class="invalid-feedback">
    <?= $_validation->getError('password') ?>
  </div>
</div>
<div class="row">
  <!-- /.col -->
  <div class="col">
    <button type="submit" class="btn btn-primary btn-block">Login</button>
  </div>
  <!-- /.col -->
</div>
<?= form_close(); ?>
<?= $this->endSection('content'); ?>
<?= $this->section('customjs') ?>
<?= $this->endSection('customjs'); ?>