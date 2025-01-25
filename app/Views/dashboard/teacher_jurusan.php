<?= $this->extend('template/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-2 gap-5">
  <div class="d-flex align-items-center gap-3">
    <h1>Jurusan</h1>
    <div class="spinner-border text-primary" role="status" id="loading">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
  <div class="d-flex gap-2 ">
    <button class="btn btn-sm btn-primary" id="refresh" onclick="loadTable()">Refresh</button>
  </div>
</div>

<div class="table-responsive">
  <table class="table">
    <thead id="head-table">
    </thead>
    <tbody id="data-table">
    </tbody>
  </table>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
  let baseUrl = "<?= teacher_url() ?>";
  let table = $('#data-table');
  let head = $('#head-table');
  let loading = $('#loading');
  let refresh = $('#refresh');

  loadTable();

  function loadTable() {
    $.ajax({
      url: '<?= teacher_url('api/get-jurusan') ?>',
      method: 'GET',
      dataType: 'json',
      beforeSend: function() {
        loading.removeClass("d-none");
        refresh.attr('disabled', true);
      },
      success: function(res) {
        loading.addClass("d-none");
        refresh.attr('disabled', false);
        head.html(`
                <tr>
                  <th>No.</th>
                  <th>Kode Jurusan</th>
                  <th>Nama Jurusan</th>
                </tr>
              `);
        table.html('');
        res.forEach((item, index) => {
          table.append(`
                  <tr>
                    <td>${index + 1}</td>
                    <td>${item.kode_jurusan}</td>
                    <td>${item.nama_jurusan}</td>
                  </tr>
                `);
        });
      },
      error: function(res) {
        loading.addClass("d-none");
        refresh.attr('disabled', false);
        toastFailRequest(res);
      }
    })
  }
</script>

<?= $this->endSection(); ?>