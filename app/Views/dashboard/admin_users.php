<?= $this->extend('template/dashboard'); ?>

<?= $this->section('content'); ?>


<div class="mb-6" data-aos="fade-up">
  <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Manajemen Pengguna</h1>
</div>


<div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4" data-aos="fade-up" data-aos-delay="100">
  <div class="flex items-center gap-3">
    <div id="loading" class="animate-spin rounded-full h-5 w-5 border-b-2 border-primary-500 hidden"></div>
  </div>
  <div class="flex gap-2">
    <button id="add" onclick="openData()"
      class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
      <i class="fas fa-plus mr-2"></i>
      Tambah
    </button>
    <button id="filter"
      class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
      <i class="fas fa-filter mr-2"></i>
      Reset Filter
    </button>
    <button id="refresh"
      class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
      <i class="fas fa-sync-alt mr-2"></i>
      Refresh
    </button>
  </div>
</div>


<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6" data-aos="fade-up" data-aos-delay="200">
  <div>
    <label for="role_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
    <div class="relative">
      <select id="role_filter" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
        <option selected disabled>Select Role</option>
        <option value="">All</option>
        <?php foreach ($roles as $r): ?>
          <option value="<?= $r->id_role ?>"><?= $r->name_role ?></option>
        <?php endforeach; ?>
      </select>
      <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
        <i class="fas fa-chevron-down text-gray-400"></i>
      </div>
    </div>
  </div>
  <div>
    <label for="class" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kelas</label>
    <div class="relative">
      <select id="class" disabled class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
        <option selected disabled value="">Pilih Role Siswa</option>
        <?php foreach ($kelas as $c): ?>
          <option value="<?= $c->id_kelas ?>"><?= $c->kelas ?></option>
        <?php endforeach; ?>
      </select>
      <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
        <i class="fas fa-chevron-down text-gray-400"></i>
      </div>
    </div>
  </div>
</div>


<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="300">
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-gray-50 dark:bg-gray-700" id="head-table">
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="data-table">
      </tbody>
    </table>
  </div>
</div>


<div id="edit-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">

  <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 backdrop-blur-sm transition-opacity"></div>

  <div class="flex min-h-screen items-center justify-center p-4">

    <div class="relative w-full max-w-lg transform overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-2xl transition-all animate__animated animate__fadeInUp animate__faster">
      <form id="edit-form" onsubmit="formHandle(event)">

        <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
          <h3 id="modal-title" class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            <i class="fas fa-user-plus mr-2 text-primary-500"></i>
            Tambah Users
          </h3>
          <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 rounded-lg p-1" data-dismiss="modal">
            <span class="sr-only">Close</span>
            <i class="fas fa-times"></i>
          </button>
        </div>


        <div class="p-6 space-y-6">

          <div class="space-y-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role:</label>
            <div class="flex flex-wrap gap-3">
              <?php foreach ($roles as $r): ?>
                <div class="flex-shrink-0">
                  <input type="radio" id="id-role-<?= $r->id_role ?>" name="id_role" value="<?= $r->id_role ?>"
                    class="hidden peer" required>
                  <label for="id-role-<?= $r->id_role ?>"
                    class="inline-flex items-center px-4 py-2 border-2 border-primary-500 text-primary-500 rounded-lg peer-checked:bg-primary-500 peer-checked:text-white cursor-pointer hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-user-tag mr-2"></i>
                    <?= $r->name_role ?>
                  </label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>


          <div class="relative">
            <input type="text" id="nama" name="nama" required
              class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer placeholder-transparent transition-colors duration-200">
            <label for="nama"
              class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary-500">
              Nama
            </label>
          </div>


          <div id="expand-data" class="space-y-4">
          </div>
        </div>


        <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50 dark:bg-gray-700/50">
          <button type="button"
            class="inline-flex items-center px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 transform hover:scale-105"
            data-dismiss="modal">
            <i class="fas fa-times mr-2"></i>
            Batal
          </button>
          <button type="submit"
            class="inline-flex items-center px-4 py-2 border-2 border-primary-500 rounded-lg text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 transform hover:scale-105">
            <i class="fas fa-save mr-2"></i>
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<div id="password-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">

  <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 backdrop-blur-sm transition-opacity"></div>

  <div class="flex min-h-screen items-center justify-center p-4">

    <div class="relative w-full max-w-lg transform overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-2xl transition-all animate__animated animate__fadeInUp animate__faster">
      <form id="password-form" onsubmit="changePasswordUser(event)">

        <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            <i class="fas fa-key mr-2 text-primary-500"></i>
            Ubah Password
          </h3>
          <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 rounded-lg p-1" data-dismiss="modal">
            <span class="sr-only">Close</span>
            <i class="fas fa-times"></i>
          </button>
        </div>


        <div class="p-6 space-y-6">
          <input type="hidden" id="id_user" name="id_user">

          <div class="relative">
            <input type="password" id="password" name="password" required
              class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer placeholder-transparent transition-colors duration-200">
            <label for="password"
              class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary-500">
              Password
            </label>
            <button type="button"
              onclick="togglePasswordVisibility()"
              class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-500">
              <i class="fas fa-eye" id="password-toggle-icon"></i>
            </button>
          </div>
        </div>


        <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50 dark:bg-gray-700/50">
          <button type="button"
            class="inline-flex items-center px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 transform hover:scale-105"
            data-dismiss="modal">
            <i class="fas fa-times mr-2"></i>
            Batal
          </button>
          <button type="submit"
            class="inline-flex items-center px-4 py-2 border-2 border-primary-500 rounded-lg text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 transform hover:scale-105">
            <i class="fas fa-save mr-2"></i>
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
  function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('password-toggle-icon');

    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      toggleIcon.classList.remove('fa-eye');
      toggleIcon.classList.add('fa-eye-slash');
    } else {
      passwordInput.type = 'password';
      toggleIcon.classList.remove('fa-eye-slash');
      toggleIcon.classList.add('fa-eye');
    }
  }
</script>


<script id="student-fields-template" type="text/template">
  <div class="space-y-6">
        
        <div class="relative">
            <select name="id_kelas" required
                    class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer transition-colors duration-200">
                <option value="" disabled selected>Pilih Kelas</option>
                <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k->id_kelas ?>"><?= $k->kelas ?></option>
                <?php endforeach; ?>
            </select>
            <label class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400">
                Kelas
            </label>
        </div>

        
        <div class="relative">
            <select name="kode_jurusan" required
                    class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer transition-colors duration-200">
                <option value="" disabled selected>Pilih Jurusan</option>
                <?php foreach ($jurusan as $j): ?>
                    <option value="<?= $j->kode_jurusan ?>">[<?= $j->kode_jurusan ?>] <?= $j->nama_jurusan ?></option>
                <?php endforeach; ?>
            </select>
            <label class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400">
                Jurusan
            </label>
        </div>

        
        <div class="relative">
            <input type="number" name="no_absen" required min="1"
                   class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer placeholder-transparent transition-colors duration-200">
            <label class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary-500">
                No. Absen
            </label>
        </div>

        
        <div class="relative">
            <input type="text" name="nis" required pattern="[0-9]+" maxlength="10"
                   class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer placeholder-transparent transition-colors duration-200">
            <label class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary-500">
                NIS
            </label>
        </div>

        
        <div class="relative">
            <input type="text" name="nisn" required pattern="[0-9]+" maxlength="10"
                   class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer placeholder-transparent transition-colors duration-200">
            <label class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary-500">
                NISN
            </label>
        </div>
    </div>
</script>


<script id="teacher-fields-template" type="text/template">
  <div class="space-y-6">
        
        <div class="relative">
            <input type="text" name="nip" required pattern="[0-9]+" maxlength="18"
                   class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer placeholder-transparent transition-colors duration-200">
            <label class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary-500">
                NIP
            </label>
        </div>

        
        <div class="relative">
            <input type="text" name="mata_pelajaran" required
                   class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer placeholder-transparent transition-colors duration-200">
            <label class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary-500">
                Mata Pelajaran
            </label>
        </div>
    </div>
</script>


<script>
  $('input[name="id_role"]').on('change', function() {
    const role = $(this).val();
    const expandData = $('#expand-data');

    // Clear previous fields
    expandData.empty();

    // Add appropriate fields based on role
    if (role === '1') { // Siswa
      expandData.html($('#student-fields-template').html());
    } else if (role === '2') { // Guru
      expandData.html($('#teacher-fields-template').html());
    }
  });
</script>

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

  // Close modal when clicking close button or backdrop
  $('[data-dismiss="modal"]').on('click', function() {
    const modal = $(this).closest('.fixed');
    closeModal(modal);
  });

  // Close modal when clicking outside
  $(document).on('click', function(e) {
    if ($(e.target).hasClass('fixed')) {
      closeModal($(e.target));
    }
  });

  // Close modal when pressing ESC key
  $(document).on('keydown', function(e) {
    if (e.key === 'Escape') {
      closeModal($('.fixed:visible'));
    }
  });

  // Generic close modal function
  function closeModal(modal) {
    // Add fade out animation
    modal.addClass('animate__animated animate__fadeOut');

    // Wait for animation to complete then hide and reset
    setTimeout(() => {
      modal.removeClass('animate__animated animate__fadeOut');
      modal.addClass('hidden');
      // Reset form if exists
      const form = modal.find('form');
      if (form.length) {
        form[0].reset();
        // Reset any custom select/input states if needed
        form.find('select').val('').trigger('change');
      }
    }, 200);
  }

  // Open modal functions
  function openData(id = null) {
    editModal.removeClass('hidden');
    editModal.addClass('animate__animated animate__fadeIn');
    editForm.trigger('reset');
    expandForm.html('');

    editModal.removeClass('hidden');
    editModal.addClass('animate__animated animate__fadeIn');

    // Reset dan enable jurusan select
    const jurusanSelect = $('select[name="kode_jurusan"]');
    jurusanSelect.prop('disabled', false);

    if (id == null) {
      editForm.attr('action', '<?= admin_url('api/add-users') ?>');
      return;
    }
  }

  function openPasswordModal(id) {
    passModal.removeClass('hidden');
    passModal.addClass('animate__animated animate__fadeIn');
    passForm.trigger('reset');
    passForm.find('#id_user').val(id);
  }

  function changePasswordUser(e) {
    e.preventDefault();

    $.ajax({
      url: passForm.attr('action'),
      method: 'POST',
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
        closeModal(passModal);
      }
    });
  }

  function formHandle(e) {
    e.preventDefault();

    let disabledFields = editForm.find(":disabled");
    disabledFields.prop("disabled", false);

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

        disabledFields.prop("disabled", true);
      },
      error: function(err) {
        toastFailRequest(err);
      },
      success: function(data) {
        toastSuccessRequest(data.message);
        closeModal(editModal);
        requestBackend();
      }
    });
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
        closeModal(editModal);
        requestBackend();
      }
    });
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
      case "1": // Siswa
        expandForm.html(`
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="relative">
                            <select name="id_kelas" required class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer transition-colors duration-200">
                                <option value="" disabled selected>Pilih Kelas</option>
                                <?php foreach ($kelas as $k): ?>
                                    <option value="<?= $k->id_kelas ?>"><?= $k->kelas ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400">
                                Kelas
                            </label>
                        </div>

                        
                        <div class="relative">
                            <select name="kode_jurusan" required class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer transition-colors duration-200">
                                <option value="" disabled selected>Pilih Jurusan</option>
                                <?php foreach ($jurusan as $j): ?>
                                    <option value="<?= $j->kode_jurusan ?>">[<?= $j->kode_jurusan ?>] <?= $j->nama_jurusan ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400">
                                Jurusan
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <div class="relative">
                            <input type="number" name="no_absen" required min="1"
                                   class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer placeholder-transparent transition-colors duration-200">
                            <label class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400">
                                No. Absen
                            </label>
                        </div>

                        
                        <div class="relative">
                            <input type="text" name="nis" required pattern="[0-9]+" maxlength="10"
                                   class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer placeholder-transparent transition-colors duration-200">
                            <label class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400">
                                NIS
                            </label>
                        </div>

                        
                        <div class="relative">
                            <input type="text" name="nisn" required pattern="[0-9]+" maxlength="10"
                                   class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer placeholder-transparent transition-colors duration-200">
                            <label class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400">
                                NISN
                            </label>
                        </div>
                    </div>
                </div>
            `);
        break;

      case "2": // Guru
        expandForm.html(`
                <div class="space-y-6">
                    
                    <div class="relative">
                        <input type="email" name="email" required
                               class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer placeholder-transparent transition-colors duration-200">
                        <label class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400">
                            Email
                        </label>
                    </div>

                    
                    <div class="relative">
                        <input type="password" name="password" required
                               class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer placeholder-transparent transition-colors duration-200">
                        <label class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400">
                            Password
                        </label>
                        <button type="button" onclick="togglePasswordVisibility(this)"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-500">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    
                    <div class="relative">
                        <input type="text" name="nip" required pattern="[0-9]+" maxlength="18"
                               class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer placeholder-transparent transition-colors duration-200">
                        <label class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400">
                            NIP
                        </label>
                    </div>
                </div>
            `);
        break;

      default: // Admin
        expandForm.html(`
                <div class="space-y-6">
                    
                    <div class="relative">
                        <input type="email" name="email" required
                               class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer placeholder-transparent transition-colors duration-200">
                        <label class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400">
                            Email
                        </label>
                    </div>

                    
                    <div class="relative">
                        <input type="password" name="password" required
                               class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer placeholder-transparent transition-colors duration-200">
                        <label class="absolute left-4 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm text-gray-600 dark:text-gray-400">
                            Password
                        </label>
                        <button type="button" onclick="togglePasswordVisibility(this)"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-500">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            `);
        break;
    }
  });

  // Add password toggle functionality
  function togglePasswordVisibility(button) {
    const input = button.previousElementSibling.previousElementSibling;
    const icon = button.querySelector('i');

    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }

  role.on('change', function() {
    kelas.val("");
    // console.log(role.val());
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

  // Fungsi untuk mendapatkan kode jurusan dari nama kelas
  function getJurusanFromKelas(kelasName) {
    const jurusanCodes = {
      'TBG': 'TBG',
      'RPL': 'RPL',
      'PH': 'PH',
      'TBS': 'TBS',
      'ULW': 'ULW'
    };

    for (const [code, value] of Object.entries(jurusanCodes)) {
      if (kelasName.includes(code)) {
        return value;
      }
    }
    return null;
  }

  // Event handler untuk perubahan kelas
  $(document).on('change', 'select[name="id_kelas"]', function() {
    const selectedKelas = $(this).find('option:selected').text();
    const jurusanSelect = $('select[name="kode_jurusan"]');

    const jurusanCode = getJurusanFromKelas(selectedKelas);

    if (jurusanCode) {
      // Set nilai jurusan dan trigger change event
      jurusanSelect.val(jurusanCode).trigger('change');

      // Disable jurusan select karena sudah otomatis
      jurusanSelect.prop('disabled', true);
    } else {
      // Enable kembali jika tidak ada jurusan yang cocok
      jurusanSelect.prop('disabled', false);
    }
  });

  // Tambahkan style untuk select yang disabled
  const style = document.createElement('style');
  style.textContent = `
    select:disabled {
        background-color: #f3f4f6;
        cursor: not-allowed;
        opacity: 0.7;
    }
    .dark select:disabled {
        background-color: #374151;
    }
  `;
  document.head.appendChild(style);
</script>

<?= $this->endSection(); ?>