<?= $this->extend('template/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-2 gap-5">
  <div class="d-flex align-items-center gap-3">
    <h1>Kelas</h1>
    <div class="spinner-border text-primary" role="status" id="loading">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
  <div class="d-flex gap-2 ">
    <button class="btn btn-sm btn-success" id="add" onclick="openData()">Tambah</button>
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

<div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="edit-kelas" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="edit-form" onsubmit="formHandle(event)" action method="post">
        <div class=" modal-header">
          <h1 class="modal-title fs-5" id="modal-title">Tambah Kelas</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="kelas" class="form-label">Nama Kelas</label>
            <input type="text" class="form-control" id="kelas" name="kelas">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
  let baseUrl = "<?= admin_url() ?>";
  let table = $('#data-table');
  let head = $('#head-table');
  let loading = $('#loading');
  let refresh = $('#refresh');
  let editForm = $('#edit-form');
  let editModal = $('#edit-modal');

  function openData(id = null) {
    if (id == null) {
      editModal.modal('show');
      editModal.find('#modal-title').text('Tambah Kelas');
      editForm.attr('action', '<?= admin_url('api/add-kelas') ?>');
      editForm.trigger('reset');
      return;
    }

    $.ajax({
      url: '<?= admin_url('api/get-kelas/') ?>' + id,
      method: 'GET',
      dataType: 'json',
      beforeSend: function() {
        $('.btn').attr('disabled', true);
        editModal.modal('hide');
        editModal.find('#modal-title').text('Edit Kelas');
        editForm.trigger('reset');
        editForm.find('#kelas').val('');
        loading.removeClass("d-none");
      },
      success: function(res) {
        $('.btn').attr('disabled', false);
        loading.addClass("d-none");
        editModal.modal('show');
        editForm.find('#kelas').val(res.kelas);
        editForm.attr('action', '<?= admin_url('api/edit-kelas/') ?>' + id);
      },
      error: function(res) {
        $('.btn').attr('disabled', false);
        toastFailRequest(res);
      }
    })
  }

  function deleteKelas(id) {
    $.ajax({
      url: '<?= admin_url('api/delete-kelas/') ?>' + id,
      method: 'DELETE',
      dataType: 'json',
      beforeSend: function() {
        $('.btn').attr('disabled', true);
      },
      success: function(res) {
        $('.btn').attr('disabled', false);
        loadTable();
        toastSuccessRequest(res.message);
      },
      error: function(res) {
        $('.btn').attr('disabled', false);
        toastFailRequest(res);
      }
    })
  }

  function formHandle(e) {
    e.preventDefault();
    $.ajax({
      url: editForm.attr('action'),
      method: 'POST',
      dataType: 'json',
      data: editForm.serialize(),
      beforeSend: function() {
        $('.btn').attr('disabled', true);
      },
      complete: function() {
        $('.btn').attr('disabled', false);
      },
      success: function(res) {
        editModal.modal('hide');
        loadTable();
        toastSuccessRequest(res.message);
      }
    })
  }

  loadTable();

  function loadTable() {
    $.ajax({
      url: '<?= admin_url('api/get-kelas') ?>',
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
                  <th>Nama Kelas</th>
                  <th>Aksi</th>
                </tr>
              `);
        table.html('');
        res.forEach((item, index) => {
          table.append(`
                  <tr>
                    <td>${index + 1}</td>
                    <td>${item.kelas}</td>
                    <td>
                      <button type="button" class="btn btn-sm btn-success edit-btn" onclick="openData('${item.id_kelas}')"><i class="bi bi-pencil-fill"></i></button>
                      <button type="button" class="btn btn-sm btn-danger delete-btn" onclick="deleteKelas('${item.id_kelas}')"><i class="bi bi-trash-fill"></i></button>
                    </td>
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