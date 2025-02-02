<?= $this->extend('template/dashboard'); ?>

<?= $this->section('styles'); ?>
<style>
  .table tr th,
  .table tr td {
    white-space: nowrap;
  }
</style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-2 gap-5">
  <div class="d-flex align-items-center gap-3">
    <h1>Kehadiran Kelas</h1>
    <div>
      <select class="form-select" aria-label="Select Class" id="class">
        <option selected value="">Pilih Kelas</option>
        <?php foreach ($class as $c): ?>
          <option value="<?= $c->kelas ?>"><?= $c->kelas ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="spinner-border text-primary" role="status" id="loading">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
  <div class="d-flex gap-2 ">
    <button class="btn btn-sm btn-secondary" id="filter">Reset Filter</button>
    <button class="btn btn-sm btn-primary" id="refresh">Refresh</button>
  </div>
</div>
<div class="row mb-2">
  <div class="col-md-3 mb-3">
    <label for="year" class="form-label">Tahun</label>
    <select class="form-select" aria-label="Select Year" id="year">
      <option selected disabled>Pilih Tahun</option>
      <?php for ($i = $end_year; $i >= $start_year; $i--): ?>
        <option value="<?= $i ?>"><?= $i ?></option>
      <?php endfor; ?>
    </select>
  </div>
  <div class="col-md-3 mb-3">
    <label for="month" class="form-label">Bulan</label>
    <select class="form-select" aria-label="Select Month" id="month">
      <option selected disabled>Pilih tahun terlebih dahulu</option>
    </select>
  </div>
  <div class="col-md-3 mb-3">
    <label for="day" class="form-label">Day</label>
    <select class="form-select" aria-label="Select Day" id="day">
      <option selected disabled>Pilih bulan terlebih dahulu</option>
    </select>
  </div>
  <div class="col-md-3 mb-3">
    <label for="Status" class="form-label">Status</label>
    <select class="form-select" aria-label="Select Status" id="status">
      <option selected value="">Pilih Status</option>
      <option value="Hadir">Hadir</option>
      <option value="Terlambat">Terlambat</option>
      <option value="Tidak Hadir">Tidak Hadir</option>
    </select>
  </div>
</div>

<div class="row row-cols-1 row-cols-md-4">
  <h5 class="mb-1"><span class="badge text-bg-success">Hadir: <span id="hadir">-</span></span></h5>
  <h5 class="mb-1"><span class="badge text-bg-warning">Terlambat: <span id="terlambat">-</span></span></h5>
  <h5 class="mb-1"><span class="badge text-bg-danger">Tidak Hadir: <span id="tidak-hadir">-</span></span></h5>
</div>

<div class="table-responsive mt-3">
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Foto</th>
        <th scope="col">Nama</th>
        <th scope="col">Email</th>
        <th scope="col">Kelas</th>
        <th scope="col">Jurusan</th>
        <th scope="col">No. Absen</th>
        <th scope="col">Timestamp</th>
        <th scope="col">Mood</th>
        <th scope="col">Status</th>
        <th scope="col">Tanggal</th>
      </tr>
    </thead>
    <tbody id="data-table">
    </tbody>
  </table>
</div>


<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
  $(document).ready(function() {
    const urlbase = new URL(window.location.href);
    let presence;

    function requestBackend() {
      let year = $('#year').val();
      let month = $('#month').val();
      let day = $('#day').val();
      let kelas = $('#class').val();

      $.ajax({
        url: '<?= admin_url('api/get-presence') ?>',
        method: 'GET',
        dataType: 'json',
        data: {
          year,
          month,
          day,
          kelas,
        },
        beforeSend: function() {
          $('#filter').attr('disabled', true);
          $('#refresh').attr('disabled', true);
          $('#loading').removeClass("d-none");
        },
        complete: function() {
          $('#filter').attr('disabled', false);
          $('#refresh').attr('disabled', false);
          $('#loading').addClass("d-none");
        },
        error: function(err) {
          toastFailRequest(err)
        },
        success: function(data) {
          toastSuccessRequest();

          let student = data.student;
          presence = data.presence;

          if (student.length > 0) {
            presence = student.map((user, index) => {
              const presenceCheck = presence.find(presence => presence.id_user == user.id_user);

              return {
                ...user,
                tanggal: presenceCheck ? presenceCheck.tanggal : $('#year').val() + '-' + (0 + $('#month').val()).slice(-2) + '-' + (0 + $('#day').val()).slice(-2),
                status: presenceCheck ? presenceCheck.status : 'Tidak Hadir'
              }
            })
          }

          $('#hadir').text(presence.filter(presence => presence.status == 'Hadir').length);
          $('#terlambat').text(presence.filter(presence => presence.status == 'Terlambat').length);
          $('#tidak-hadir').text(presence.filter(presence => presence.status == 'Tidak Hadir').length);

          renderTable();
        }
      })
    }

    function renderTable() {
      let copyPresence = presence;

      if ($('#status').val()) {
        copyPresence = presence.filter(presence => presence.status == $('#status').val());
      }

      let html = '';
      copyPresence.forEach((item, index) => {
        html += `
            <tr>
              <th scope="row">${index + 1}</th>
              <td>
                ${item.foto ? 
                  `<a href='<?= base_url("assets/upload/absensi/") ?>${item.foto}'>
                    <img src='<?= base_url("assets/upload/absensi/") ?>${item.foto}' width='50%' />
                  </a>` : `-`}
              </td>
              <td>${item.nama}</td>
              <td>${item.email}</td>
              <td>${item.kelas}</td>
              <td>${item.kode_jurusan}</td>
              <td>${item.no_absen}</td>
              <td>${item.timestamp ?? '-'}</td>
              <td>${item.mood ?? '-'}</td>
              <td><span class="badge text-${item.status == 'Hadir' ? 'bg-success' : item.status == 'Terlambat' ? 'bg-warning' : 'bg-danger'}">${item.status}</span></td>
              <td>${item.tanggal ?? '-'}</td>
            </tr>
            `;
      });
      $('#data-table').html(html);
    }

    // ==========================================
    // Filter Handler
    // ==========================================

    function setParams() {
      urlbase.searchParams.set('year', $('#year').val());
      urlbase.searchParams.set('month', $('#month').val());
      urlbase.searchParams.set('day', $('#day').val());
      urlbase.searchParams.set('kelas', $('#class').val());
      urlbase.searchParams.set('status', $('#status').val());
      window.history.replaceState(null, null, urlbase);
    }

    function getFilterByParams() {
      $('#year').val(urlbase.searchParams.get('year'));
      yearChanged();
      $('#month').val(urlbase.searchParams.get('month'));
      monthChanged();
      $('#day').val(urlbase.searchParams.get('day'));
      $('#class').val(urlbase.searchParams.get('kelas'));
      $('#status').val(urlbase.searchParams.get('status'));

      requestBackend();
    }

    function yearChanged() {
      $('#day').html('<option selected disabled>Pilih bulan terlebih dahulu</option>');
      $('#month').html('<option selected disabled>Pilih bulan</option>');
      $('#month').append('<option value="<?= date('n') ?>">Bulan ini</option>');
      for (let i = 1; i <= 12; i++) {
        $('#month').append(`<option value="${i}">${i}</option>`);
      }
    }

    function monthChanged() {
      $('#day').html('<option selected disabled>Pilih hari</option>');
      $('#day').append('<option value="<?= date('j') ?>">Hari ini</option>');
      const totalDay = new Date($('#year').val(), $('#month').val(), 0).getDate();
      for (let i = 1; i <= totalDay; i++) {
        $('#day').append(`<option value="${i}">${i}</option>`);
      }
    }

    function defaultFilter() {
      $('#year').val(<?= date('Y') ?>);
      yearChanged();
      $('#month').val(<?= date('m') ?>);
      monthChanged();
      $('#day').val(<?= date('d') ?>);
      $('#class').val('');
      $('#status').val('');

      setParams()

      requestBackend();
    }

    if (urlbase.searchParams.get('year') || urlbase.searchParams.get('month') || urlbase.searchParams.get('day') || urlbase.searchParams.get('kelas') || urlbase.searchParams.get('status')) {
      getFilterByParams();
    } else {
      defaultFilter();
    }

    // ==========================================
    // Event Handler
    // ==========================================

    $('#year').on('change', function() {
      yearChanged();
      setParams();
      requestBackend();
    })

    $('#month').on('change', function() {
      monthChanged();
      setParams();
      requestBackend();
    })

    $('#day').on('change', function() {
      setParams();
      requestBackend();
    })

    $('#class').on('change', function() {
      setParams();
      requestBackend();
    })

    $('#status').on('change', function() {
      setParams();
      renderTable();
    })

    $('#filter').on('click', defaultFilter)
    $('#refresh').on('click', requestBackend)

  });
</script>
<?= $this->endSection(); ?>