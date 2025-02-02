<?= $this->extend('template/dashboard'); ?>

<?= $this->section('styles'); ?>

<style>
  .card-title {
    font-size: 5rem;
    margin: 0;
  }

  .icon-bg {
    position: absolute;
    top: 4px;
    right: -4px;
    font-size: 7rem;
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
</style>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<h1 class="mt-4 mb-3">Welcome, <?= session()->get("auth_login")['email'] ?></h1>

<h3 class="mb-1">Kehadiran</h3>
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 mt-1">
  <div class="col mb-3">
    <div class="card">
      <div class="card-header">
        Hadir
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
  </div>
  <div class="col mb-3">
    <div class="card">
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
  </div>
  <div class="col mb-3">
    <div class="card">
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
<script>
  $(document).ready(function() {
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

        $('#hadir').text(presence.filter(presence => presence.status == 'Hadir').length);
        $('#terlambat').text(presence.filter(presence => presence.status == 'Terlambat').length);
        $('#tidak-hadir').text(presence.filter(presence => presence.status == 'Tidak Hadir').length);
      }
    });
  });
</script>
<?= $this->endSection(); ?>