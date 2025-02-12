<?= $this->extend('layout/template') ?>

<?= $this->section('body') ?>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100 dark:from-gray-900 dark:to-gray-800 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8" data-aos="zoom-in">
        <?php if (session()->has("error")): ?>
            <?php foreach (session()->get("error") as $e): ?>
                <div class="bg-red-100 dark:bg-red-900 border-l-4 border-red-500 text-red-700 dark:text-red-200 p-4 rounded-lg shadow-md animate__animated animate__shake" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span class="block sm:inline"><?= $e ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden p-8 card-hover">
            <div class="text-center mb-8" data-aos="fade-down" data-aos-delay="200">
                <img src="<?= base_url("assets/img/logo-full.png") ?>" 
                     class="mx-auto w-48 h-auto hover:scale-105 transition-transform" 
                     alt="BarCode Logo">
            </div>

            <form method="POST" action="<?= base_url("web/login") ?>" class="space-y-6">
                <div data-aos="fade-up" data-aos-delay="400">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        <i class="fas fa-envelope mr-2"></i>Email
                    </label>
                    <div class="mt-1 relative">
                        <input id="email" 
                               name="email" 
                               type="email" 
                               required 
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm transition-all"
                               placeholder="Masukkan email Anda">
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="600">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <div class="mt-1 relative">
                        <input id="password" 
                               name="password" 
                               type="password" 
                               required 
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm transition-all"
                               placeholder="Masukkan password Anda">
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="800">
                    <button type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Theme toggle script -->
<button id="theme-toggle" class="fixed bottom-4 right-4 text-gray-500 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 shadow-lg">
    <i class="fas fa-sun w-5 h-5 hidden dark:block"></i>
    <i class="fas fa-moon w-5 h-5 block dark:hidden"></i>
</button>

<?= $this->endSection() ?>

  <!-- Test -->