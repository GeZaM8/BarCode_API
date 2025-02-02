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

<h6 class="mt-1 mb-2 text-end">Welcome, <?= session()->get("auth_login")['email'] ?></h6>

<h3 class="mb-1">Kehadiran</h3>
<div class="d-flex flex-column flex-md-row align-items-stretch gap-3">
  <div style="flex: 2;" class="order-2 order-md-1">
    <div class="card mb-3">
      <div class="card-header">
        Hadir Tepat Waktu
      </div>
      <div class="card-body">
        <h1 class="card-title" id="hadir">Loading...</h1>
        <i class="bi bi-clipboard2-check icon-bg"></i>
      </div>
      <a href="<?= admin_url("presence?year=" . date('Y') . "&month=" . date('n') . "&day=" . date('j') . "&status=Hadir") ?>">
        <div class="card-footer text-body-secondary d-flex justify-content-between align-items-center">
          <small>More Info</small>
          <i class="bi bi-chevron-right"></i>
        </div>
      </a>
    </div>

    <div class="card mb-3">
      <div class="card-header">
        Terlambat
      </div>
      <div class="card-body">
        <h1 class="card-title" id="terlambat">Loading...</h1>
        <i class="bi bi-clipboard2-minus icon-bg"></i>
      </div>
      <a href="<?= admin_url("presence?year=" . date('Y') . "&month=" . date('n') . "&day=" . date('j') . "&status=Terlambat") ?>">
        <div class="card-footer text-body-secondary d-flex justify-content-between align-items-center">
          <small>More Info</small>
          <i class="bi bi-chevron-right"></i>
        </div>
      </a>
    </div>

    <div class="card mb-3">
      <div class="card-header">
        Tidak Hadir
      </div>
      <div class="card-body">
        <h1 class="card-title" id="tidak-hadir">Loading...</h1>
        <i class="bi bi-clipboard2-x icon-bg"></i>
      </div>
      <a href="<?= admin_url("presence?year=" . date('Y') . "&month=" . date('n') . "&day=" . date('j') . "&status=Tidak Hadir") ?>">
        <div class="card-footer text-body-secondary d-flex justify-content-between align-items-center">
          <small>More Info</small>
          <i class="bi bi-chevron-right"></i>
        </div>
      </a>
    </div>
  </div>
  <div style="flex: 3;" class="order-1 order-md-2">
    <div class="chartWrapper">
      <canvas id="chartContainer" style="width: 100%;"></canvas>
    </div>
  </div>
</div>



<h3 class="mb-1">Data</h3>
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 mt-1">
  <div class="col mb-3">
    <div class="card">
      <div class="card-header">
        Users
      </div>
      <div class="card-body">
        <h1 class="card-title"><?= $users_count ?></h1>
        <i class="bi bi-people-fill icon-bg"></i>
      </div>
    </div>
  </div>
  <div class="col mb-3">
    <div class="card">
      <div class="card-header">
        Kelas
      </div>
      <div class="card-body">
        <h1 class="card-title"><?= $kelas_count ?></h1>
        <i class="bi bi-building icon-bg"></i>
      </div>
    </div>
  </div>
  <div class="col mb-3">
    <div class="card">
      <div class="card-header">
        Jurusan
      </div>
      <div class="card-body">
        <h1 class="card-title"><?= $jurusan_count ?></h1>
        <i class="bi bi-stars icon-bg"></i>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js" integrity="sha512-ZwR1/gSZM3ai6vCdI+LVF1zSq/5HznD3ZSTk7kajkaj4D292NLuduDCO1c/NT8Id+jE58KYLKT7hXnbtryGmMg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

        new Chart(
          document.getElementById("chartContainer"), {
            type: 'pie',
            data: {
              labels: chartData.map(row => row.status),
              datasets: [{
                label: 'Total',
                data: chartData.map(row => row.count),
                backgroundColor: [
                  'rgb(10, 211, 74)',
                  'rgb(255, 205, 86)',
                  'rgb(248, 83, 119)',
                ]
              }]
            },
            options: {
              plugins: {
                legend: {
                  labels: {
                    font: {
                      size: 14,
                    },
                    color: '#fff'
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