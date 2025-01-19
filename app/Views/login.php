<?= $this->extend('layout/template') ?>

<?= $this->section('body') ?>


<div class="container">
  <div class="row">
    <div class="pt-5 col-md-8 col-lg-4 mx-auto">

      <?php
      if (session()->has("error")) {
        foreach (session()->get("error") as $e) {
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
          <img src="/img/logo-full.png" class="mb-4 mx-auto d-block" style="width: 100%; max-width: 60%;" alt="BarCode Logo">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
          <button type="submit" class="btn btn-success w-100 d-block">Login</button>

          <small class="mt-3 d-block">Activate your account here, <a href="/web/activate">Activate</a></small>

        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>