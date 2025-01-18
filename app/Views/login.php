<?= $this->extend('layout/main') ?>

<?= $this->section('body') ?>


<div class="container">
  <div class="row">
    <div class="pt-5 col-4 mx-auto">

      <?php
      if (session()->has("error")) {
        $errors = session()->get("error");
        foreach ($errors as $e) {
          echo "
            <div class='alert alert-danger' role='alert'>
              $e
            </div>
          ";
        }
      }

      ?>
      <form class="card" method="POST" action="/web/login">
        <div class="card-body">
          <img src="/img/logo-icon.png" class="img-fluid mb-4" alt="BarCode Logo">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
          <button type="submit" class="btn btn-success w-100 d-block">Login</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>