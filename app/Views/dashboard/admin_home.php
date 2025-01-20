<?= $this->extend('template/dashboard'); ?>

<?= $this->section('styles'); ?>

<style>
  .card-title {
    font-size: 5rem;
    margin: 0;
  }

  .icon-bg {
    position: absolute;
    top: 0;
    right: -4px;
    font-size: 7rem;
    margin: 0;
  }

  .card-body {
    overflow: hidden;
    position: relative;
  }
</style>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<h1>Welcome, <?= session()->get("auth_login")['email'] ?></h1>

<div class="row mt-4">
  <div class="col-12 col-md-6 col-lg-4">
    <div class="card">
      <div class="card-header">
        Users
      </div>
      <div class="card-body">
        <h1 class="card-title">50</h1>
        <i class="bi bi-people-fill icon-bg"></i>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-4">
    <div class="card">
      <div class="card-header">
        Keterlambatan (Bulan ini)
      </div>
      <div class="card-body">

      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>