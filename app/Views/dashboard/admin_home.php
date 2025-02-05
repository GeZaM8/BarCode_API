<?= $this->extend('template/dashboard'); ?>

<?= $this->section('styles'); ?>


<style>
  .card-title {
    font-size: 2.5rem;
    margin: 0;
  }

  .icon-bg {
    position: absolute;
    top: -8px;
    right: -4px;
    font-size: 5rem;
    opacity: 0.3;
    margin: 0;
  }

  .card-body {
    overflow: hidden;
    position: relative;
  }

  a {
    text-decoration: none;
  }

  .chartWrapper {
    height: 500px;
    width: 100%;
    display: flex;
    justify-content: center;
  }

  @media (max-width: 768px) {
    .chartWrapper {
      height: 360px;
      width: 100%;
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }
  }
</style>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Header Section dengan animasi -->
<div class="mb-8" data-aos="fade-down">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Dashboard Overview</h1>
        <div class="flex items-center space-x-4">
            <div class="flex items-center bg-white dark:bg-gray-800 p-2 rounded-lg shadow">
                <i class="bi bi-person-circle text-xl mr-2 text-gray-600 dark:text-gray-300"></i>
                <span class="text-sm text-gray-600 dark:text-gray-300"><?= session()->get("auth_login")['email'] ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Kehadiran Section -->
<div class="mb-8" data-aos="fade-up">
    <h3 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-200">Statistik Kehadiran</h3>
    
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Card Kehadiran dengan efek hover dan transisi -->
        <div class="w-full md:w-2/5 space-y-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden" 
                 data-aos="zoom-in" data-aos-delay="100">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Hadir Tepat Waktu</h3>
                </div>
                <div class="px-6 py-6 relative">
                    <h1 id="hadir" class="text-5xl font-bold text-emerald-600 dark:text-emerald-400">Loading...</h1>
                    <i class="bi bi-clipboard2-check absolute top-2 right-4 text-7xl opacity-20 text-emerald-500"></i>
                </div>
                <a href="<?= admin_url("presence?year=" . date('Y') . "&month=" . date('n') . "&day=" . date('j') . "&status=Hadir") ?>" 
                   class="block px-4 py-2 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    <div class="flex justify-between items-center">
                        <span class="text-sm">More Info</span>
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </a>
            </div>

            <!-- Card Terlambat -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden"
                 data-aos="zoom-in" data-aos-delay="200">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Terlambat</h3>
                </div>
                <div class="px-6 py-6 relative">
                    <h1 id="terlambat" class="text-5xl font-bold text-yellow-600 dark:text-yellow-400">Loading...</h1>
                    <i class="bi bi-clipboard2-minus absolute top-2 right-4 text-7xl opacity-20 text-yellow-500"></i>
                </div>
                <a href="<?= admin_url("presence?year=" . date('Y') . "&month=" . date('n') . "&day=" . date('j') . "&status=Terlambat") ?>" 
                   class="block px-4 py-2 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    <div class="flex justify-between items-center">
                        <span class="text-sm">More Info</span>
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </a>
            </div>

            <!-- Card Tidak Hadir -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden"
                 data-aos="zoom-in" data-aos-delay="300">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Tidak Hadir</h3>
                </div>
                <div class="px-6 py-6 relative">
                    <h1 id="tidak-hadir" class="text-5xl font-bold text-red-600 dark:text-red-400">Loading...</h1>
                    <i class="bi bi-clipboard2-x absolute top-2 right-4 text-7xl opacity-20 text-red-500"></i>
                </div>
                <a href="<?= admin_url("presence?year=" . date('Y') . "&month=" . date('n') . "&day=" . date('j') . "&status=Tidak Hadir") ?>" 
                   class="block px-4 py-2 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    <div class="flex justify-between items-center">
                        <span class="text-sm">More Info</span>
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </a>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="w-full md:w-3/5" data-aos="fade-left">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 h-[500px] md:h-full">
                <canvas id="chartContainer" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Data Statistics Section -->
<div class="mb-8" data-aos="fade-up">
    <h3 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-200">Statistik Data</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden p-6"
             data-aos="zoom-in" data-aos-delay="100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-2"><?= $users_count ?></h3>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-lg">
                    <i class="bi bi-people-fill text-3xl text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden p-6"
             data-aos="zoom-in" data-aos-delay="100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Kelas</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-2"><?= $kelas_count ?></h3>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-lg">
                    <i class="bi bi-people-fill text-3xl text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden p-6"
             data-aos="zoom-in" data-aos-delay="100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Jurusan</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-2"><?= $jurusan_count ?></h3>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-lg">
                    <i class="bi bi-people-fill text-3xl text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    AOS.init({
        duration: 800,
        once: true
    });
    
    $.ajax({
      url: '<?= admin_url('api/get-presence') ?>',
      method: 'GET',
      dataType: 'json',
      data: {
        year: '<?= date('Y') ?>',
        month: '<?= date('n') ?>',
        day: '<?= date('j') ?>',
      },
      error: function(err) {
        toastFailRequest(err)
      },
      success: function(data) {
        toastSuccessRequest();

        let student = data.student;
        let presence = data.presence;

        if (student.length > 0) {
          presence = student.map((user, index) => {
            const presenceCheck = presence.find(presence => presence.id_user == user.id_user);
            return {
              ...user,
              status: presenceCheck ? presenceCheck.status : 'Tidak Hadir'
            }
          })
        }

        const hadir = presence.filter(presence => presence.status == 'Hadir').length;
        const terlambat = presence.filter(presence => presence.status == 'Terlambat').length;
        const tidakHadir = presence.filter(presence => presence.status == 'Tidak Hadir').length;

        $('#hadir').text(hadir);
        $('#terlambat').text(terlambat);
        $('#tidak-hadir').text(tidakHadir);

        const chartData = [{
            status: "Tepat Waktu",
            count: hadir
          },  
          {
            status: "Terlambat",
            count: terlambat
          },
          {
            status: "Tidak Hadir",
            count: tidakHadir
          },
        ];

        new Chart(
          document.getElementById("chartContainer"), {
            type: 'bar',
            data: {
              labels: chartData.map(row => row.status),
              datasets: [{
                label: 'Total Kehadiran',
                data: chartData.map(row => row.count),
                backgroundColor: [
                  'rgba(34, 197, 94, 0.8)',
                  'rgba(234, 179, 8, 0.8)',
                  'rgba(239, 68, 68, 0.8)',
                ],
                borderColor: [
                  'rgb(34, 197, 94)',
                  'rgb(234, 179, 8)',
                  'rgb(239, 68, 68)',
                ],
                borderWidth: 2,
                borderRadius: 8,
                maxBarThickness: 50
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                y: {
                  beginAtZero: true,
                  grid: {
                    color: document.documentElement.classList.contains('dark') ? 
                      'rgba(255, 255, 255, 0.1)' : 
                      'rgba(0, 0, 0, 0.1)'
                  }
                },
                x: {
                  grid: {
                    display: false
                  }
                }
              }
            }
          });
      }
    });
});
</script>
<?= $this->endSection(); ?>