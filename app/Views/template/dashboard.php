<?= $this->extend('layout/template'); ?>

<?= $this->section('styles'); ?>
<link rel="stylesheet" href="<?= base_url("assets/jquery/jquery.toast.min.css") ?>">
<?= $this->renderSection('styles'); ?>
<?= $this->endSection(); ?>

<?= $this->section('body'); ?>

<?php
$user_role = get_user_auth_role();
$url_base = "";

if ($user_role == 3) {
    $url_base = "admin_url";
} elseif ($user_role == 2) {
    $url_base = "teacher_url";
}
?>

<div class="flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="<?= $url_base() ?>" class="flex-shrink-0">
                        <img class="h-10 w-auto" src="<?= base_url("assets/img/logo-long.png") ?>" alt="BarCode Logo">
                    </a>
                </div>
                
                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Desktop menu -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <div class="flex space-x-4">
                        <a href="<?= $url_base() ?>" class="<?= $current_page == 'home' ? 'bg-gray-100 dark:bg-gray-700' : '' ?> px-3 py-2 rounded-md text-sm font-medium text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Home
                        </a>
                        <a href="<?= base_url("qrcode") ?>" class="px-3 py-2 rounded-md text-sm font-medium text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700">
                            QRCode
                        </a>
                        
                        <!-- Dropdown -->
                        <div class="relative group">
                            <button class="<?= str_contains($current_page, 'data') ? 'bg-gray-100 dark:bg-gray-700' : '' ?> px-3 py-2 rounded-md text-sm font-medium text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 inline-flex items-center">
                                Data
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="absolute hidden group-hover:block w-48 py-1 mt-1 bg-white dark:bg-gray-800 rounded-md shadow-lg">
                                <a href="<?= $url_base("users") ?>" class="<?= $current_page == 'data.users' ? 'bg-gray-100 dark:bg-gray-700' : '' ?> block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Users</a>
                                <a href="<?= $url_base("kelas") ?>" class="<?= $current_page == 'data.kelas' ? 'bg-gray-100 dark:bg-gray-700' : '' ?> block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Kelas</a>
                                <a href="<?= $url_base('jurusan') ?>" class="<?= $current_page == 'data.jurusan' ? 'bg-gray-100 dark:bg-gray-700' : '' ?> block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Jurusan</a>
                            </div>
                        </div>

                        <a href="<?= $url_base('presence') ?>" class="<?= $current_page == 'presence' ? 'bg-gray-100 dark:bg-gray-700' : '' ?> px-3 py-2 rounded-md text-sm font-medium text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Kehadiran
                        </a>
                        <a href="<?= $url_base('logout') ?>" class="px-3 py-2 rounded-md text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900">
                            Keluar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="sm:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="<?= $url_base() ?>" class="<?= $current_page == 'home' ? 'bg-gray-100 dark:bg-gray-700' : '' ?> block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-gray-100">Home</a>
                <a href="<?= base_url("qrcode") ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-gray-100">QRCode</a>
                <a href="<?= $url_base("users") ?>" class="<?= $current_page == 'data.users' ? 'bg-gray-100 dark:bg-gray-700' : '' ?> block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-gray-100">Users</a>
                <a href="<?= $url_base("kelas") ?>" class="<?= $current_page == 'data.kelas' ? 'bg-gray-100 dark:bg-gray-700' : '' ?> block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-gray-100">Kelas</a>
                <a href="<?= $url_base('jurusan') ?>" class="<?= $current_page == 'data.jurusan' ? 'bg-gray-100 dark:bg-gray-700' : '' ?> block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-gray-100">Jurusan</a>
                <a href="<?= $url_base('presence') ?>" class="<?= $current_page == 'presence' ? 'bg-gray-100 dark:bg-gray-700' : '' ?> block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-gray-100">Kehadiran</a>
                <a href="<?= $url_base('logout') ?>" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 dark:text-red-400">Keluar</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?= $this->renderSection('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h5 class="text-gray-600 dark:text-gray-400">&copy; <?= date('Y') ?> barjek. All rights reserved.</h5>
            <h6 class="text-gray-500 dark:text-gray-500 text-sm">Made by Serge and Team</h6>
        </div>
    </footer>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="<?= base_url("assets/jquery/jquery-3.7.1.min.js") ?>"></script>
<script src="<?= base_url("/assets/jquery/jquery.toast.min.js") ?>"></script>
<script src="<?= base_url("/scripts/toast-helper.js") ?>"></script>
<script>
    // Mobile menu toggle
    const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuButton.addEventListener('click', () => {
        const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
        mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
        mobileMenu.classList.toggle('hidden');
    });
</script>
<?= $this->renderSection('scripts'); ?>
<?= $this->endSection(); ?>