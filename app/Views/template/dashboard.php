<?= $this->extend('layout/template'); ?>

<?= $this->section('body'); ?>

<?php

$baseUrl = "/web/admin";

?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="#">BarCode</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'home' ? 'active' : '' ?>" href="<?= $baseUrl ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/qrcode">QRCode</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'users' ? 'active' : '' ?>" href="<?= $baseUrl ?>/users">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'presence' ? 'active' : '' ?>" href="<?= $baseUrl ?>/presence">Presence</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= $baseUrl ?>/logout">Logout</a>
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
<script src="/scripts/jquery-3.7.1.min.js"></script>
<?= $this->renderSection('scripts'); ?>
<?= $this->endSection(); ?>