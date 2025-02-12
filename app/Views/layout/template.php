<!DOCTYPE html>
<html lang="en" class="dark scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem Absensi Modern dan Efisien">
    <meta name="theme-color" content="#0ea5e9">
    <title>BarCode | <?= $title ?></title>
    <?= $this->include('layout/header') ?>
    <?= $this->renderSection('styles') ?>
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen flex flex-col">
    <!-- Loading Overlay -->
    <div id="loading" class="fixed inset-0 bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm z-50 flex items-center justify-center transition-all duration-300 opacity-0 pointer-events-none">
        <div class="flex flex-col items-center gap-3">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-primary-500 border-t-transparent"></div>
            <p class="text-sm text-gray-600 dark:text-gray-400">Loading...</p>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow page-transition">
        <?= $this->renderSection('body') ?>
    </main>

    <!-- Scripts -->
    <?= $this->renderSection('scripts') ?>
    <?= $this->include('layout/bottom') ?>
</body>

</html>
