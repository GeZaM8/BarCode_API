<?= $this->extend('template/dashboard'); ?>

<?= $this->section('content'); ?>


<div class="d-flex justify-content-between align-items-center mb-2 gap-5">
  <div class="d-flex align-items-center gap-3">
    <h1>Users</h1>
    <div class="spinner-border text-primary" role="status" id="loading">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
  <div class="d-flex gap-2 ">
    <button class="btn btn-sm btn-primary" id="filter">Reset Filter</button>
    <button class="btn btn-sm btn-success" id="refresh">Refresh</button>
  </div>
</div>
<div class="row mb-2">
  <div class="col-md-3 mb-3">
    <label for="role" class="form-label">Role</label>
    <select class="form-select" aria-label="Select Role" id="role">
      <option selected disabled>Select Role</option>
      <option value="">All</option>
      <?php foreach ($roles as $r): ?>
        <option value="<?= $r->id_role ?>"><?= $r->name_role ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-3 mb-3">
    <label for="class" class="form-label">Class</label>
    <select class="form-select" aria-label="Select Class" id="class" disabled>
      <option selected disabled value="">Select Role Siswa</option>
    </select>
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
  $(document).ready(function() {
    let baseUrl = "<?= admin_url() ?>";
    let table = $('#data-table');
    let head = $('#head-table');
    let loading = $('#loading');
    let filter = $('#filter');
    let refresh = $('#refresh');
    let role = $('#role');
    let kelas = $('#class');

    function requestBackend() {
      $.ajax({
        url: '<?= admin_url('api/get-users') ?>',
        method: 'GET',
        dataType: 'json',
        data: {
          role: role.val(),
          kelas: kelas.val(),
        },
        beforeSend: function() {
          loading.removeClass("d-none");
        },
        success: function(data) {
          let type = data.type;
          let users = data.users;

          loading.addClass("d-none");
          table.html('');
          head.html('');

          switch (type) {
            case '1':
              head.append(`
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Jurusan</th>
                    <th scope="col">No. Absen</th>
                    <th scope="col">NIS</th>
                    <th scope="col">NISN</th>
                  </tr>
                `);
              users.forEach((item, index) => {
                table.append(`
                  <tr>
                    <th scope="row">${index + 1}</th>
                    <td>${item.id_user}</td>
                    <td>${item.nama ?? "-"}</td>
                    <td>${item.email}</td>
                    <td>${item.kelas}</td>
                    <td>${item.kode_jurusan}</td>
                    <td>${item.no_absen ?? "-"}</td>
                    <td>${item.nis ?? "-"}</td>
                    <td>${item.nisn ?? "-"}</td>
                  </tr>
                `);
              })
              break
            case '2':
              head.append(`
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">NIP</th>
                  </tr>
                `);
              users.forEach((item, index) => {
                table.append(`
                  <tr>
                    <th scope="row">${index + 1}</th>
                    <td>${item.id_user}</td>
                    <td>${item.nama ?? "-"}</td>
                    <td>${item.email}</td>
                    <td>${item.nip ?? "-"}</td>
                  </tr>
                `);
              })
              break
            case '3':
              head.append(`
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Email</th>
                  </tr>
                `);
              users.forEach((item, index) => {
                table.append(`
                  <tr>
                    <th scope="row">${index + 1}</th>
                    <td>${item.id_user}</td>
                    <td>${item.email}</td>
                  </tr>
                `);
              })
              break
            default:
              head.append(`
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                  </tr>
                `);
              users.forEach((item, index) => {
                table.append(`
                  <tr>
                    <th scope="row">${index + 1}</th>
                    <td>${item.id_user}</td>
                    <td>${item.nama ?? "-"}</td>
                    <td>${item.email}</td>
                    <td>${item.name_role}</td>
                  </tr>
                `);
              })
              break
          }
        }
      })
    }

    function getKelas() {
      $.ajax({
        url: '<?= admin_url('api/get-kelas') ?>',
        method: 'GET',
        dataType: 'json',
        beforeSend: function() {
          kelas.prop('disabled', true);
        },
        success: function(data) {
          kelas.prop('disabled', false);
          kelas.html('<option selected disabled>Select Class</option>');
          data.forEach((item, index) => {
            kelas.append(`<option value="${item.kelas}">${item.kelas}</option>`);
          })
        }
      })
    }

    function defaultFilter() {
      role.val("")
      role.trigger('change');
      requestBackend()
    }
    defaultFilter()

    role.on('change', function() {
      if (role.val() == '1') {
        getKelas()
      } else {
        kelas.prop('disabled', true);
        kelas.html('<option selected disabled>Select Role Siswa</option>');
        kelas.val($("#class option:first").val());
      }

      requestBackend()
    })

    kelas.on('change', function() {
      requestBackend()
    })

    $('#filter').on('click', defaultFilter)
    $('#refresh').on('click', requestBackend)
  })
</script>

<?= $this->endSection(); ?>