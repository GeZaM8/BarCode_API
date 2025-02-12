<?= $this->extend('layout/template'); ?>

<?= $this->section('styles'); ?>
<link rel="stylesheet" href="<?= base_url("assets/jquery/jquery.toast.min.css") ?>">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    .nav-link-hover {
        @apply relative overflow-hidden;
    }
    
    .nav-link-hover::after {
        content: '';
        @apply absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 transition-all duration-300;
    }
    
    .nav-link-hover:hover::after {
        @apply w-full;
    }
</style>
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

<div class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900">
    
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                
                <div class="flex items-center">
                    <a href="<?= $url_base() ?>" class="flex-shrink-0 flex items-center space-x-3" data-aos="fade-right">
                        <img class="h-10 w-auto" src="<?= base_url("assets/img/logo-long.png") ?>" alt="BarCode Logo">
                    </a>
                </div>

                
                <div class="hidden sm:flex sm:items-center sm:space-x-4">
                    <a href="<?= $url_base() ?>" 
                       class="nav-link-hover <?= $current_page == 'home' ? 'text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300' ?> px-3 py-2 text-sm font-medium hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>

                    
                    <div class="relative group" data-tippy-content="Menu Data">
                        <button class="nav-link-hover <?= str_contains($current_page, 'data') ? 'text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300' ?> px-3 py-2 text-sm font-medium group flex items-center space-x-1">
                            <i class="fas fa-database mr-2"></i>
                            <span>Data</span>
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="absolute hidden group-hover:block w-48 mt-1 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 animate__animated animate__fadeIn animate__faster">
                            <div class="py-1">
                                <a href="<?= $url_base("users") ?>" class="<?= $current_page == 'data.users' ? 'bg-gray-100 dark:bg-gray-700 text-primary-600 dark:text-primary-400' : '' ?> block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                    <i class="fas fa-users mr-2"></i>Users
                                </a>
                                <a href="<?= $url_base("kelas") ?>" class="<?= $current_page == 'data.kelas' ? 'bg-gray-100 dark:bg-gray-700 text-primary-600 dark:text-primary-400' : '' ?> block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                    <i class="fas fa-school mr-2"></i>Kelas
                                </a>
                                <a href="<?= $url_base('jurusan') ?>" class="<?= $current_page == 'data.jurusan' ? 'bg-gray-100 dark:bg-gray-700 text-primary-600 dark:text-primary-400' : '' ?> block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                    <i class="fas fa-graduation-cap mr-2"></i>Jurusan
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="<?= $url_base('presence') ?>" 
                       class="nav-link-hover <?= $current_page == 'presence' ? 'text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300' ?> px-3 py-2 text-sm font-medium hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">
                        <i class="fas fa-clipboard-check mr-2"></i>Kehadiran
                    </a>

                    <button id="theme-toggle" 
                            class="px-3 py-2 rounded-full text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition-colors duration-200"
                            data-tippy-content="Toggle tema">
                        <i class="fas fa-sun text-lg dark:hidden"></i>
                        <i class="fas fa-moon text-lg hidden dark:block"></i>
                    </button>

                    <a href="<?= $url_base('logout') ?>" 
                       class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200"
                       data-tippy-content="Keluar dari sistem">
                        <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                    </a>
                </div>

                
                <div class="flex items-center sm:hidden">
                    <button type="button" 
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition-colors duration-200" 
                            aria-controls="mobile-menu" 
                            aria-expanded="false">
                        <span class="sr-only">Buka menu utama</span>
                        <i class="fas fa-bars h-6 w-6"></i>
                    </button>
                </div>
            </div>
        </div>

        
        <div class="sm:hidden hidden animate__animated animate__fadeIn" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                
                <a href="<?= $url_base() ?>" class="<?= $current_page == 'home' ? 'bg-primary-500 text-white' : 'text-gray-700 dark:text-gray-300' ?> block px-3 py-2 rounded-md text-base font-medium hover:bg-primary-500 hover:text-white transition-colors duration-200">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="<?= $url_base("users") ?>" class="<?= $current_page == 'data.users' ? 'bg-gray-100 dark:bg-gray-700' : '' ?> block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-gray-100">Users</a>
                <a href="<?= $url_base("kelas") ?>" class="<?= $current_page == 'data.kelas' ? 'bg-gray-100 dark:bg-gray-700' : '' ?> block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-gray-100">Kelas</a>
                <a href="<?= $url_base('jurusan') ?>" class="<?= $current_page == 'data.jurusan' ? 'bg-gray-100 dark:bg-gray-700' : '' ?> block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-gray-100">Jurusan</a>
                <a href="<?= $url_base('presence') ?>" class="<?= $current_page == 'presence' ? 'bg-gray-100 dark:bg-gray-700' : '' ?> block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-gray-100">Kehadiran</a>
                <a href="<?= $url_base('logout') ?>" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 dark:text-red-400">Keluar</a>
            </div>
        </div>
    </nav>

    
    <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="animate__animated animate__fadeIn animate__faster">
            <?= $this->renderSection('content'); ?>
        </div>
    </main>

    
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                <div class="text-center sm:text-left">
                    <h5 class="text-gray-600 dark:text-gray-400">&copy; <?= date('Y') ?> barjek. All rights reserved.</h5>
                    <h6 class="text-gray-500 dark:text-gray-500 text-sm">Made with <i class="fas fa-heart text-red-500"></i> by Serge and Team</h6>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-primary-500 transition-colors duration-200">
                        <i class="fab fa-github text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary-500 transition-colors duration-200">
                        <i class="fab fa-linkedin text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="<?= base_url("assets/jquery/jquery-3.7.1.min.js") ?>"></script>
<script src="<?= base_url("/assets/jquery/jquery.toast.min.js") ?>"></script>
<script src="<?= base_url("/scripts/toast-helper.js") ?>"></script>

<script>
    // Mobile menu toggle dengan animasi
    const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuButton.addEventListener('click', () => {
        const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
        mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
        
        if (isExpanded) {
            mobileMenu.classList.add('animate__fadeOut');
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('animate__fadeOut');
            }, 200);
        } else {
            mobileMenu.classList.remove('hidden');
            mobileMenu.classList.add('animate__fadeIn');
        }
    });

    // Theme toggler
    const themeToggle = document.getElementById('theme-toggle');
    themeToggle.addEventListener('click', () => {
        document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
    });

    // Check saved theme
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
</script>
<?= $this->renderSection('scripts'); ?>
<?= $this->endSection(); ?>