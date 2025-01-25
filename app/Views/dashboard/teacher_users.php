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
    <button class="btn btn-sm btn-secondary" id="filter">Reset Filter</button>
    <button class="btn btn-sm btn-primary" id="refresh">Refresh</button>
  </div>
</div>
<div class="row mb-2">
  <div class="col-md-3 mb-3">
    <label for="role_filter" class="form-label">Role</label>
    <select class="form-select" aria-label="Select Role" id="role_filter">
      <option selected disabled>Select Role</option>
      <option value="">All</option>
      <?php foreach ($roles as $r): ?>
        <option value="<?= $r->id_role ?>"><?= $r->name_role ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-3 mb-3">
    <label for="class" class="form-label">Kelas</label>
    <select class="form-select" aria-label="Select Class" id="class" disabled>
      <option selected disabled value="">Pilih Role Siswa</option>
      <?php foreach ($kelas as $c): ?>
        <option value="<?= $c->id_kelas ?>"><?= $c->kelas ?></option>
      <?php endforeach; ?>
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
  let baseUrl = "<?= teacher_url() ?>";
  let table = $('#data-table');
  let head = $('#head-table');
  let loading = $('#loading');
  let add = $('#add');
  let filter = $('#filter');
  let refresh = $('#refresh');
  let role = $('#role_filter');
  let kelas = $('#class');
  let roleUser = $('input[name="id_role"]');
  let expandForm = $('#expand-data');

  function requestBackend() {
    $.ajax({
      url: '<?= teacher_url('api/get-users') ?>',
      method: 'GET',
      dataType: 'json',
      data: {
        role: role.val(),
        kelas: kelas.val(),
      },
      beforeSend: function() {
        loading.removeClass("d-none");
        filter.attr('disabled', true);
        refresh.attr('disabled', true);
      },
      complete: function() {
        loading.addClass("d-none");
        filter.attr('disabled', false);
        refresh.attr('disabled', false);
      },
      error: function(err) {
        toastFailRequest(err)
      },
      success: function(data) {
        toastSuccessRequest()

        let type = data.type;
        let users = data.users;

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
                    <td>${item.email ?? "-"}</td>
                    <td>${item.kelas ?? "-"}</td>
                    <td>${item.kode_jurusan ?? "-"}</td>
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
  requestBackend();

  function defaultFilter() {
    role.val("")
    role.trigger('change');
  }

  roleUser.on("change", (e) => {
    const role_id = e.target.value;

    expandForm.html('');

    switch (role_id) {
      case "1":
        expandForm.html(`
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="class" class="form-label">Kelas</label>
              <select class="form-select" aria-label="Select Class" id="class" name="id_kelas">
                <option selected disabled>Select Class</option>
                <?php foreach ($kelas as $k): ?>
                  <option value="<?= $k->id_kelas ?>"><?= $k->kelas ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="jurusan" class="form-label">Jurusan</label>
              <select class="form-select" aria-label="Select Jurusan" id="jurusan" name="kode_jurusan">
                <option selected disabled>Select Jurusan</option>
                <?php foreach ($jurusan as $j): ?>
                  <option value="<?= $j->kode_jurusan ?>">[<?= $j->kode_jurusan ?>] <?= $j->nama_jurusan ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="no_absen" class="form-label">No. Absen</label>
              <input type="number" class="form-control" id="no_absen" name="no_absen">
            </div>
            <div class="col-md-6 mb-3">
              <label for="nis" class="form-label">NIS</label>
              <input type="number" class="form-control" id="nis" name="nis">
            </div>
            <div class="col-md-6 mb-3">
              <label for="nisn" class="form-label">NISN</label>
              <input type="number" class="form-control" id="nisn" name="nisn">
            </div>
          </div>
        `);
        break
      case "2":
        expandForm.html(`
          <div class="row">
            <div class="col-12 mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="col-12 mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="col-md-6 mb-3">
              <label for="nip" class="form-label">NIP</label>
              <input type="number" class="form-control" id="nip" name="nip">
            </div>
          </div>
        `);
        break
      default:
        expandForm.html(`
          <div class="row">
            <div class="col-12 mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="col-12 mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password">
            </div>
          </div>
        `);
        break
    }
  });

  role.on('change', function() {
    kelas.val("");
    console.log(role.val());
    if (role.val() == '1') {
      kelas.prop('disabled', false);
      kelas.find('option:first').html('Pilih kelas');
    } else {
      kelas.prop('disabled', true);
      kelas.find('option:first').html('Pilih role siswa');
    }

    requestBackend()
  })

  kelas.on('change', function() {
    requestBackend()
  })

  $('#filter').on('click', defaultFilter)
  $('#refresh').on('click', requestBackend)
</script>

<?= $this->endSection(); ?>