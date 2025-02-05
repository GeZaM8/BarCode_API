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

<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Dashboard</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Selamat datang kembali, <?= session()->get("auth_login")['email'] ?>
            </p>
        </div>
        <nav class="flex mt-3 md:mt-0">
            <ol class="inline-flex items-center space-x-1 text-sm">
                <li><span class="text-gray-500 dark:text-gray-400">Home</span></li>
                <li class="flex items-center">
                    <svg class="w-3 h-3 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="text-gray-600 dark:text-gray-300">Dashboard</span>
                </li>
            </ol>
        </nav>
    </div>
</div>

<h3 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Kehadiran</h3>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="p-6 bg-white rounded-xl shadow-sm dark:bg-gray-800 hover:shadow-lg transition-shadow">
        <div class="flex items-center">
            <div class="inline-flex items-center justify-center p-3 rounded-lg bg-green-100 dark:bg-green-900">
                <i class="bi bi-clipboard2-check text-2xl text-green-500 dark:text-green-300"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Hadir Tepat Waktu</h3>
                <p id="hadir" class="text-2xl font-semibold text-gray-900 dark:text-white">Loading...</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="<?= admin_url("presence?year=" . date('Y') . "&month=" . date('n') . "&day=" . date('j') . "&status=Hadir") ?>" 
               class="text-sm text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 inline-flex items-center">
                Lihat Detail
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>

    <div class="p-6 bg-white rounded-xl shadow-sm dark:bg-gray-800 hover:shadow-lg transition-shadow">
        <div class="flex items-center">
            <div class="inline-flex items-center justify-center p-3 rounded-lg bg-yellow-100 dark:bg-yellow-900">
                <i class="bi bi-clipboard2-minus text-2xl text-yellow-500 dark:text-yellow-300"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Terlambat</h3>
                <p id="terlambat" class="text-2xl font-semibold text-gray-900 dark:text-white">Loading...</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="<?= admin_url("presence?year=" . date('Y') . "&month=" . date('n') . "&day=" . date('j') . "&status=Terlambat") ?>" 
               class="text-sm text-yellow-600 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300 inline-flex items-center">
                Lihat Detail
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>

    <div class="p-6 bg-white rounded-xl shadow-sm dark:bg-gray-800 hover:shadow-lg transition-shadow">
        <div class="flex items-center">
            <div class="inline-flex items-center justify-center p-3 rounded-lg bg-red-100 dark:bg-red-900">
                <i class="bi bi-clipboard2-x text-2xl text-red-500 dark:text-red-300"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Tidak Hadir</h3>
                <p id="tidak-hadir" class="text-2xl font-semibold text-gray-900 dark:text-white">Loading...</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="<?= admin_url("presence?year=" . date('Y') . "&month=" . date('n') . "&day=" . date('j') . "&status=Tidak Hadir") ?>" 
               class="text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 inline-flex items-center">
                Lihat Detail
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>
</div>

<h3 class="text-2xl font-semibold my-6 text-gray-800 dark:text-gray-200">Data</h3>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Statistik Kehadiran</h3>
            <div id="attendanceChart" class="w-full" style="height: 400px;"></div>
        </div>
    </div>
    
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-gray-700 dark:text-gray-300">Users</h3>
            </div>
            <div class="px-4 py-4 relative">
                <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200"><?= $users_count ?></h1>
                <i class="bi bi-people-fill absolute top-0 right-0 text-6xl opacity-30 text-gray-400 dark:text-gray-600"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-gray-700 dark:text-gray-300">Kelas</h3>
            </div>
            <div class="px-4 py-4 relative">
                <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200"><?= $kelas_count ?></h1>
                <i class="bi bi-building absolute top-0 right-0 text-6xl opacity-30 text-gray-400 dark:text-gray-600"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-gray-700 dark:text-gray-300">Jurusan</h3>
            </div>
            <div class="px-4 py-4 relative">
                <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200"><?= $jurusan_count ?></h1>
                <i class="bi bi-stars absolute top-0 right-0 text-6xl opacity-30 text-gray-400 dark:text-gray-600"></i>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
  $(document).ready(function() {
    $.ajax({
      url: '<?= teacher_url('api/get-presence') ?>',
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

        const chartOptions = {
          series: [{
            name: 'Kehadiran',
            data: chartData.map(row => row.count)
          }],
          chart: {
            type: 'bar',
            height: 400,
            toolbar: {
              show: false
            },
            fontFamily: 'Inter, sans-serif'
          },
          colors: ['#22c55e', '#eab308', '#ef4444'],
          plotOptions: {
            bar: {
              borderRadius: 8,
              columnWidth: '60%',
              distributed: true
            }
          },
        };

        const chart = new ApexCharts(document.querySelector("#attendanceChart"), chartOptions);
        chart.render();
      }
    });
  });
</script>
<?= $this->endSection(); ?>