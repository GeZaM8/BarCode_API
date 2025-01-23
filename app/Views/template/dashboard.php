<?= $this->extend('layout/template'); ?>

<?= $this->section('styles'); ?>
<link rel="stylesheet" href="<?= base_url("assets/jquery/jquery.toast.min.css") ?>">
<?= $this->renderSection('styles'); ?>
<?= $this->endSection(); ?>

<?= $this->section('body'); ?>


<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="<?= admin_url() ?>">
      <img src="<?= base_url("assets/img/logo-long.png") ?>" alt="BarCode Logo" height="40">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'home' ? 'active' : '' ?>" href="<?= admin_url() ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url("qrcode") ?>">QRCode</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= str_contains($current_page, 'data') ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Data
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?= $current_page == 'data.users' ? 'active' : '' ?>" href="<?= admin_url('users') ?>">Users</a></li>
            <li><a class="dropdown-item <?= $current_page == 'data.kelas' ? 'active' : '' ?>" href="<?= admin_url('kelas') ?>">Kelas</a></li>
            <li><a class="dropdown-item <?= $current_page == 'data.jurusan' ? 'active' : '' ?>" href="<?= admin_url('jurusan') ?>">Jurusan</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'presence' ? 'active' : '' ?>" href="<?= admin_url('presence') ?>">Kehadiran</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= admin_url('logout') ?>">Keluar</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-3">
  <?= $this->renderSection('content'); ?>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="<?= base_url("assets/jquery/jquery-3.7.1.min.js") ?>"></script>
<script src="<?= base_url("/assets/jquery/jquery.toast.min.js") ?>"></script>
<script src="<?= base_url("/scripts/toast-helper.js") ?>"></script>
<?= $this->renderSection('scripts'); ?>
<?= $this->endSection(); ?>