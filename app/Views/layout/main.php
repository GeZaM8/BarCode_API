<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BarCode | <?= $title ?></title>
  <?= $this->include('layout/head') ?>
  <?= $this->renderSection('styles') ?>
</head>

<body>
  <?= $this->renderSection('body') ?>

  <!-- Scripts -->
  <?= $this->renderSection('scripts') ?>
  <?= $this->include('layout/bottom') ?>
</body>

</html>