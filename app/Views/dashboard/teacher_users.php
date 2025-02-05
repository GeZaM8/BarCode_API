<?= $this->extend('template/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="flex justify-between items-center mb-6">
    <div class="flex items-center gap-4">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Users</h1>
        <div class="text-primary-600 dark:text-primary-400 hidden" id="loading" role="status">
            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>
    <div class="flex gap-2">
        <button id="filter" class="px-3 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 text-sm font-medium transition-colors">
            Reset Filter
        </button>
        <button id="refresh" class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 text-sm font-medium transition-colors">
            Refresh
        </button>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div>
        <label for="role_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
        <select id="role_filter" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
            <option selected disabled>Select Role</option>
            <option value="">All</option>
            <?php foreach ($roles as $r): ?>
                <option value="<?= $r->id_role ?>"><?= $r->name_role ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="class" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas</label>
        <select id="class" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm" disabled>
            <option selected disabled value="">Pilih Role Siswa</option>
            <?php foreach ($kelas as $c): ?>
                <option value="<?= $c->id_kelas ?>"><?= $c->kelas ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
    <table class="min-w-full whitespace-nowrap">
        <thead class="bg-gray-50 dark:bg-gray-700" id="head-table">
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="data-table">
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
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kelas</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jurusan</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No. Absen</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NIS</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NISN</th>
              </tr>
            `);
            users.forEach((item, index) => {
              table.append(`
                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${index + 1}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.id_user}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nama}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.email ?? '-'}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.kelas ?? '-'}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.kode_jurusan ?? '-'}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.no_absen ?? '-'}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nis ?? '-'}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nisn ?? '-'}</td>
                </tr>
              `);
            });
            break;
          case '2':
            head.append(`
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NIP</th>
              </tr>
            `);
            users.forEach((item, index) => {
              table.append(`
                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${index + 1}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.id_user}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nama}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.email ?? '-'}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nip ?? '-'}</td>
                </tr>
              `);
            });
            break;
          case '3':
            head.append(`
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
              </tr>
            `);
            users.forEach((item, index) => {
              table.append(`
                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${index + 1}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.id_user}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.email}</td>
                </tr>
              `);
            });
            break
          default:
            head.append(`
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
              </tr>
            `);
            users.forEach((item, index) => {
              table.append(`
                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${index + 1}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.id_user}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nama}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.email}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.name_role}</td>
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