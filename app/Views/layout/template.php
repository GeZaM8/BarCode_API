<!doctype html>
<html lang="en" class="dark">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BarCode | <?= $title ?></title>
  <?= $this->include('layout/header') ?>
  <?= $this->renderSection('styles') ?>
</head>

<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
  <?= $this->renderSection('body') ?>

  <!-- Scripts -->
  <?= $this->renderSection('scripts') ?>
  <?= $this->include('layout/bottom') ?>
</body>

</html>
