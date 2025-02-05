<?= $this->extend('template/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-5">
    <div class="flex items-center gap-3">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Users</h1>
        <div id="loading" class="animate-spin rounded-full h-5 w-5 border-b-2 border-blue-500"></div>
    </div>
    <div class="flex gap-2">
        <button id="add" onclick="openData()" class="px-4 py-2 text-sm bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
            Tambah
        </button>
        <button id="filter" class="px-4 py-2 text-sm bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
            Reset Filter
        </button>
        <button id="refresh" class="px-4 py-2 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
            Refresh
        </button>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div>
        <label for="role_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
        <select id="role_filter" class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option selected disabled>Select Role</option>
            <option value="">All</option>
            <?php foreach ($roles as $r): ?>
                <option value="<?= $r->id_role ?>"><?= $r->name_role ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="class" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas</label>
        <select id="class" disabled class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option selected disabled value="">Pilih Role Siswa</option>
            <?php foreach ($kelas as $c): ?>
                <option value="<?= $c->id_kelas ?>"><?= $c->kelas ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
    <table class="min-w-full table-auto whitespace-nowrap">
        <thead class="bg-gray-50 dark:bg-gray-700" id="head-table">
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="data-table">
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div id="edit-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
        
        <div class="relative bg-white dark:bg-gray-800 rounded-lg max-w-md w-full">
            <form id="edit-form" onsubmit="formHandle(event)">
                <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
                    <h3 id="modal-title" class="text-lg font-semibold text-gray-900 dark:text-gray-100">Tambah Users</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500" data-dismiss="modal">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="p-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role:</label>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($roles as $r): ?>
                                <div class="flex items-center">
                                    <input type="radio" id="id-role-<?= $r->id_role ?>" name="id_role" value="<?= $r->id_role ?>" 
                                           class="hidden peer" required>
                                    <label for="id-role-<?= $r->id_role ?>" 
                                           class="px-3 py-2 text-sm border border-blue-500 text-blue-500 rounded-lg peer-checked:bg-blue-500 peer-checked:text-white cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900 transition-colors">
                                        <?= $r->name_role ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama</label>
                        <input type="text" id="nama" name="nama" 
                               class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div id="expand-data">
                    </div>
                </div>
                
                <div class="flex justify-end gap-2 p-4 border-t dark:border-gray-700">
                    <button type="button" class="px-4 py-2 text-sm bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="password-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
        
        <div class="relative bg-white dark:bg-gray-800 rounded-lg max-w-md w-full">
            <form id="password-form" onsubmit="changePasswordUser(event)">
                <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Ubah Password</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500" data-dismiss="modal">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="p-4">
                    <input type="hidden" id="id_user" name="id_user">
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                        <input type="password" id="password" name="password" 
                               class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="flex justify-end gap-2 p-4 border-t dark:border-gray-700">
                    <button type="button" class="px-4 py-2 text-sm bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Simpan
                    </button>
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
  let add = $('#add');
  let filter = $('#filter');
  let refresh = $('#refresh');
  let role = $('#role_filter');
  let kelas = $('#class');
  let editModal = $('#edit-modal');
  let passModal = $('#password-modal');
  let editForm = $('#edit-form');
  let passForm = $('#password-form');
  let roleUser = $('input[name="id_role"]');
  let expandForm = $('#expand-data');

  function openData(id = null) {
    editModal.modal('show');
    editModal.find('#modal-title').text('Tambah Users');
    editForm.trigger('reset');
    expandForm.html('');

    if (id == null) {
      editForm.attr('action', '<?= admin_url('api/add-users') ?>');
      return;
    }
  }

  function openPasswordModal(id) {
    passModal.modal('show');
    passModal.find('#modal-title').text('Ubah Password');
    passForm.trigger('reset');
    passForm.find('#id_user').val(id);
  }

  function changePasswordUser(e) {
    e.preventDefault();

    $.post({
      url: '<?= admin_url('api/change-password-user') ?>',
      dataType: 'json',
      data: passForm.serialize(),
      beforeSend: function() {
        $('.btn').attr('disabled', true);
        loading.removeClass("d-none");
      },
      complete: function() {
        loading.addClass("d-none");
        $('.btn').attr('disabled', false);
      },
      error: function(err) {
        toastFailRequestTop(err);
      },
      success: function(data) {
        toastSuccessRequestTop(data.message);
        passModal.modal('hide');
      }
    });
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
        loading.removeClass("d-none");
      },
      complete: function() {
        loading.addClass("d-none");
        $('.btn').attr('disabled', false);
      },
      error: function(err) {
        toastFailRequest(err);
      },
      success: function(data) {
        toastSuccessRequest(data.message);
        editModal.modal('hide');
        requestBackend();
      }
    })
  }

  function deleteUser(id) {
    $.ajax({
      url: '<?= admin_url('api/delete-users/') ?>' + id,
      method: 'DELETE',
      dataType: 'json',
      beforeSend: function() {
        $('.btn').attr('disabled', true);
        loading.removeClass("d-none");
      },
      complete: function() {
        loading.addClass("d-none");
        $('.btn').attr('disabled', false);
      },
      error: function(err) {
        toastFailRequest(err);
      },
      success: function(data) {
        toastSuccessRequest(data.message);
        editModal.modal('hide');
        requestBackend();
      }
    })
  }


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
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-10">#</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-20">ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-24">Kelas</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-32">Jurusan</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-28">No. Absen</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-28">NIS</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-28">NISN</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-24">Aksi</th>
              </tr>
            `);
            users.forEach((item, index) => {
              table.append(`
                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${index + 1}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.id_user}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nama ?? "-"}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.email ?? "-"}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.kelas ?? "-"}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.kode_jurusan ?? "-"}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.no_absen ?? "-"}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nis ?? "-"}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nisn ?? "-"}</td>
                  <td class="px-6 py-4 text-sm font-medium space-x-2">
                    <button type="button" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300" onclick="openPasswordModal('${item.id_user}')">
                      <i class="bi bi-unlock-fill"></i>
                    </button>
                    <button type="button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="deleteUser('${item.id_user}')">
                      <i class="bi bi-trash-fill"></i>
                    </button>
                  </td>
                </tr>
              `);
            });
            break
          case '2':
            head.append(`
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-10">#</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-20">ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-32">NIP</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-24">Aksi</th>
              </tr>
            `);
            users.forEach((item, index) => {
              table.append(`
                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${index + 1}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.id_user}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nama ?? "-"}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.email}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nip ?? "-"}</td>
                  <td class="px-6 py-4 text-sm font-medium space-x-2">
                    <button type="button" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300" onclick="openPasswordModal('${item.id_user}')">
                      <i class="bi bi-unlock-fill"></i>
                    </button>
                    <button type="button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="deleteUser('${item.id_user}')">
                      <i class="bi bi-trash-fill"></i>
                    </button>
                  </td>
                </tr>
              `);
            });
            break
          case '3':
            head.append(`
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-10">#</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-20">ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-24">Aksi</th>
              </tr>
            `);
            users.forEach((item, index) => {
              table.append(`
                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${index + 1}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.id_user}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.email}</td>
                  <td class="px-6 py-4 text-sm font-medium space-x-2">
                    <button type="button" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300" onclick="openPasswordModal('${item.id_user}')">
                      <i class="bi bi-unlock-fill"></i>
                    </button>
                    <button type="button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="deleteUser('${item.id_user}')">
                      <i class="bi bi-trash-fill"></i>
                    </button>
                  </td>
                </tr>
              `);
            });
            break
          default:
            head.append(`
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-10">#</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-20">ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-32">Role</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-24">Aksi</th>
              </tr>
            `);
            users.forEach((item, index) => {
              table.append(`
                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${index + 1}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.id_user}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nama ?? "-"}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.email ?? "-"}</td>
                  <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.name_role}</td>
                  <td class="px-6 py-4 text-sm font-medium space-x-2">
                    <button type="button" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300" onclick="openPasswordModal('${item.id_user}')">
                      <i class="bi bi-unlock-fill"></i>
                    </button>
                    <button type="button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="deleteUser('${item.id_user}')">
                      <i class="bi bi-trash-fill"></i>
                    </button>
                  </td>
                </tr>
              `);
            });
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