<?= $this->extend('template/dashboard'); ?>

<?= $this->section('content'); ?>

<h1>Presence</h1>
<div class="row mb-3">
  <div class="col-3">
    <label for="year" class="form-label">Year</label>
    <select class="form-select" aria-label="Select Year" id="year">
      <option selected disabled>Select Year</option>
      <?php for ($i = $end_year; $i >= $start_year; $i--): ?>
        <option value="<?= $i ?>"><?= $i ?></option>
      <?php endfor; ?>
    </select>
  </div>
  <div class="col-3">
    <label for="month" class="form-label">Month</label>
    <select class="form-select" aria-label="Select Month" id="month">
      <option selected disabled>Select Year First</option>
    </select>
  </div>
  <div class="col-3">
    <label for="day" class="form-label">Day</label>
    <select class="form-select" aria-label="Select Day" id="day">
      <option selected disabled>Select Month First</option>
    </select>
  </div>
  <div class="col-3">
    <label for="class" class="form-label">Class</label>
    <select class="form-select" aria-label="Select Class" id="class">
      <option selected disabled>Select Class</option>
      <?php foreach ($class as $c): ?>
        <option value="<?= $c->kelas ?>"><?= $c->kelas ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>
<div class="table-responsive">
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nama</th>
        <th scope="col">Kelas</th>
        <th scope="col">Jurusan</th>
        <th scope="col">Nomor Absen</th>
        <th scope="col">Tanggal</th>
        <th scope="col">Timestamp</th>
      </tr>
    </thead>
    <tbody id="data-table">
    </tbody>
  </table>
</div>
<div class="d-flex justify-content-center" id="loading">
  <div class="spinner-border" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
  $(document).ready(function() {
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
          kelas
        },
        beforeSend: function() {
          $('#loading').removeClass("d-none");
        },
        complete: function() {
          $('#loading').addClass("d-none");
        },
        success: function(data) {
          console.log(data);
          let html = '';
          data.forEach((item, index) => {
            html += `
            <tr>
              <th scope="row">${index + 1}</th>
              <td>${item.nama}</td>
              <td>${item.kelas}</td>
              <td>${item.kode_jurusan}</td>
              <td>${item.no_absen}</td>
              <td>${item.tanggal}</td>
              <td>${item.timestamp}</td>
            </tr>
            `;
          });
          $('#data-table').html(html);
        }
      })
    }
    requestBackend();

    $('#year').on('change', function() {
      $('#day').html('<option selected disabled>Select Month First</option>');
      $('#month').html('<option selected disabled>Select Month</option>');
      $('#month').append('<option value="<?= date('m') ?>">This Month</option>');
      for (let i = 1; i <= 12; i++) {
        $('#month').append(`<option value="${i}">${i}</option>`);
      }

      requestBackend();
    })

    $('#month').on('change', function() {
      $('#day').html('<option selected disabled>Select Day</option>');
      $('#day').append('<option value="<?= date('d') ?>">This Day</option>');
      const totalDay = new Date($('#year').val(), $('#month').val(), 0).getDate();
      for (let i = 1; i <= totalDay; i++) {
        $('#day').append(`<option value="${i}">${i}</option>`);
      }

      requestBackend();
    })

    $('#day').on('change', function() {
      requestBackend();
    })

    $('#class').on('change', function() {
      requestBackend();
    })
  });
</script>
<?= $this->endSection(); ?>