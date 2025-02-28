<?= $this->extend('template/dashboard'); ?>

<?= $this->section('content'); ?>


<div class="mb-6" data-aos="fade-up">
  <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Manajemen Pengguna</h1>
</div>


<div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4" data-aos="fade-up" data-aos-delay="100">
  <div class="flex items-center gap-3">
    <div id="loading" class="animate-spin rounded-full h-5 w-5 border-b-2 border-primary-500 hidden"></div>
  </div>
  <div class="flex flex-wrap gap-2">
    <button id="add" onclick="openData()"
      class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
      <i class="fas fa-plus mr-2"></i>
      Tambah
    </button>
    <button id="upload" onclick="openUploadModal()"
      class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
      <i class="fas fa-file-excel mr-2"></i>
      Upload Excel
    </button>
    <button id="export" onclick="openExportModal()"
      class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
      <i class="fas fa-file-export mr-2"></i>
      Export Excel
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
        <option selected disabled value="">Pilih Kelas</option>
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


<div id="upload-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 backdrop-blur-sm transition-opacity"></div>

  <div class="flex min-h-screen items-center justify-center p-4">
    <div class="relative w-full max-w-lg transform overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-2xl transition-all animate__animated animate__fadeInUp animate__faster">
      <form id="upload-form" onsubmit="uploadExcel(event)">
        <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            <i class="fas fa-file-excel mr-2 text-primary-500"></i>
            Upload Data Excel
          </h3>
          <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 rounded-lg p-1" data-dismiss="modal">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <div class="p-6 space-y-6">
          <div class="space-y-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role:</label>
            <div class="flex flex-wrap gap-3">
              <?php foreach ($roles as $r): ?>
                <div class="flex-shrink-0">
                  <input type="radio" id="upload-role-<?= $r->id_role ?>" name="id_role" value="<?= $r->id_role ?>" class="hidden peer" required>
                  <label for="upload-role-<?= $r->id_role ?>" class="inline-flex items-center px-4 py-2 border-2 border-primary-500 text-primary-500 rounded-lg peer-checked:bg-primary-500 peer-checked:text-white cursor-pointer hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all duration-200">
                    <i class="fas fa-user-tag mr-2"></i>
                    <?= $r->name_role ?>
                  </label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="space-y-4">
            <div class="relative">
              <input type="file" name="file" accept=".xls,.xlsx" required 
                class="block w-full text-sm text-gray-900 dark:text-white 
                file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 
                file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 
                hover:file:bg-primary-100 dark:file:bg-primary-900/20 dark:file:text-primary-300">
            </div>
            
            <div class="text-sm text-gray-600 dark:text-gray-400">
              <a href="#" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                <i class="fas fa-download mr-1"></i>
                Download Template Excel
              </a>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 text-sm">
              <h4 class="font-medium text-gray-900 dark:text-white mb-2">Format Excel:</h4>
              <ul class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-400">
                <li>Nama</li>
                <li>Kelas (contoh: X RPL 1)</li>
                <li>Jurusan (kode: RPL/TBG/TBS/dll)</li>
                <li>No. Absen</li>
                <li>NIS</li>
                <li>NISN</li>
              </ul>
            </div>
          </div>

          <div id="upload-progress" class="hidden space-y-4">
            <div class="relative pt-1">
              <div class="flex mb-2 items-center justify-between">
                <div>
                  <span class="text-xs font-semibold inline-block text-primary-600 dark:text-primary-400">
                    Progress Upload
                  </span>
                </div>
                <div class="text-right">
                  <span id="progress-percentage" class="text-xs font-semibold inline-block text-primary-600 dark:text-primary-400">
                    0%
                  </span>
                </div>
              </div>
              <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-primary-200 dark:bg-primary-900/20">
                <div id="progress-bar" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary-500" style="width: 0%"></div>
              </div>
            </div>
          </div>

          <div id="upload-result" class="hidden">
            <div class="rounded-lg border dark:border-gray-700 overflow-hidden">
              <div class="p-4 bg-gray-50 dark:bg-gray-700/50 border-b dark:border-gray-700">
                <h4 class="font-medium text-gray-900 dark:text-white">Hasil Upload</h4>
              </div>
              <div class="p-4 space-y-3">
                <div id="success-message" class="text-sm text-green-600 dark:text-green-400"></div>
                <div id="error-container" class="hidden">
                  <div class="text-sm font-medium text-red-600 dark:text-red-400 mb-2">Error ditemukan:</div>
                  <ul id="error-list" class="text-sm text-red-600 dark:text-red-400 list-disc list-inside space-y-1"></ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50 dark:bg-gray-700/50">
          <button type="button" class="inline-flex items-center px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200" data-dismiss="modal">
            <i class="fas fa-times mr-2"></i>
            Batal
          </button>
          <button type="submit" id="upload-button" class="inline-flex items-center px-4 py-2 border-2 border-primary-500 rounded-lg text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
            <i class="fas fa-upload mr-2"></i>
            Upload
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<div id="export-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 backdrop-blur-sm transition-opacity"></div>

  <div class="flex min-h-screen items-center justify-center p-4">
    <div class="relative w-full max-w-lg transform overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-2xl transition-all animate__animated animate__fadeInUp animate__faster">
      <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
          <i class="fas fa-file-export mr-2 text-primary-500"></i>
          Export Data
        </h3>
        <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 rounded-lg p-1" data-dismiss="modal">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <div class="p-6 space-y-6">
        <div class="space-y-3">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Role yang akan diexport:</label>
          <div class="grid grid-cols-2 gap-3">
            <div class="col-span-2">
              <input type="radio" id="export-role-all" name="export_role" value="" class="hidden peer" checked>
              <label for="export-role-all" class="flex items-center justify-center px-4 py-3 border-2 border-primary-500 text-primary-500 rounded-lg peer-checked:bg-primary-500 peer-checked:text-white cursor-pointer hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all duration-200">
                <i class="fas fa-users mr-2"></i>
                Semua Pengguna
              </label>
            </div>
            <?php foreach ($roles as $r): ?>
            <div>
              <input type="radio" id="export-role-<?= $r->id_role ?>" name="export_role" value="<?= $r->id_role ?>" class="hidden peer">
              <label for="export-role-<?= $r->id_role ?>" class="flex items-center justify-center px-4 py-3 border-2 border-primary-500 text-primary-500 rounded-lg peer-checked:bg-primary-500 peer-checked:text-white cursor-pointer hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all duration-200">
                <i class="fas <?= $r->id_role == 1 ? 'fa-user-graduate' : ($r->id_role == 2 ? 'fa-chalkboard-teacher' : 'fa-user-shield') ?> mr-2"></i>
                <?= $r->name_role ?>
              </label>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div id="export-class-section" class="space-y-3 hidden">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Kelas (opsional):</label>
          <select id="export-class" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
            <option value="">Semua Kelas</option>
            <?php foreach ($kelas as $k): ?>
              <option value="<?= $k->id_kelas ?>"><?= $k->kelas ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
          <h4 class="font-medium text-gray-900 dark:text-white mb-2">Informasi Export:</h4>
          <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
            <p id="export-info-siswa" class="hidden">
              <i class="fas fa-info-circle mr-1"></i>
              Data siswa akan mencakup: Nama, Kelas, Jurusan, No. Absen, NIS, dan NISN
            </p>
            <p id="export-info-guru" class="hidden">
              <i class="fas fa-info-circle mr-1"></i>
              Data guru akan mencakup: Nama, NIP, dan Email
            </p>
            <p id="export-info-admin" class="hidden">
              <i class="fas fa-info-circle mr-1"></i>
              Data admin akan mencakup: Nama dan Email
            </p>
            <p id="export-info-all" class="hidden">
              <i class="fas fa-info-circle mr-1"></i>
              Data akan mencakup: Nama, Role, Email, Kelas, dan Jurusan
            </p>
          </div>
        </div>
      </div>

      <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50 dark:bg-gray-700/50">
        <button type="button" class="inline-flex items-center px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200" data-dismiss="modal">
          <i class="fas fa-times mr-2"></i>
          Batal
        </button>
        <button type="button" onclick="startExport()" id="start-export" class="inline-flex items-center px-4 py-2 border-2 border-primary-500 rounded-lg text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
          <i class="fas fa-file-export mr-2"></i>
          Export Excel
        </button>
      </div>
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
                    class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-white-600 rounded-lg focus:outline-none focus:border-primary-500 peer transition-colors duration-200">
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
                    class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-white-600 rounded-lg focus:outline-none focus:border-primary-500 peer transition-colors duration-200">
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
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="relative">
                            <select name="id_kelas" required class="block w-full px-4 py-3 text-gray-900 dark:text-white bg-transparent border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:border-primary-500 peer transition-colors duration-200">
                                <option value="" disabled selected class="bg-transparent">Pilih Kelas</option>
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

  function openUploadModal() {
    $('#upload-modal').removeClass('hidden');
    $('#upload-modal').addClass('animate__animated animate__fadeIn');
  }

  function uploadExcel(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    const uploadButton = $('#upload-button');
    const progressDiv = $('#upload-progress');
    const resultDiv = $('#upload-result');
    const successMessage = $('#success-message');
    const errorContainer = $('#error-container');
    const errorList = $('#error-list');
    const progressBar = $('#progress-bar');
    const progressPercentage = $('#progress-percentage');


    progressDiv.removeClass('hidden');
    resultDiv.addClass('hidden');
    errorContainer.addClass('hidden');
    errorList.empty();
    progressBar.css('width', '0%');
    progressPercentage.text('0%');

    uploadButton.prop('disabled', true);
    uploadButton.html('<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...');

    $.ajax({
      url: '<?= admin_url('api/add-users-xls') ?>',
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      xhr: function() {
        const xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function(evt) {
          if (evt.lengthComputable) {
            const percentComplete = Math.round((evt.loaded / evt.total) * 100);
            progressBar.css('width', percentComplete + '%');
            progressPercentage.text(percentComplete + '%');
          }
        }, false);
        return xhr;
      },
      success: function(response) {
        resultDiv.removeClass('hidden');
          
        successMessage.html(`<i class="fas fa-check-circle mr-1"></i>${response.success_count} data berhasil diupload`);
        
        // Tampilkan error jika ada
        if (response.errors && response.errors.length > 0) {
          errorContainer.removeClass('hidden');
          response.errors.forEach(error => {
            errorList.append(`<li>${error}</li>`);
          });
        }

        // Jika partial success, tampilkan notifikasi
        if (response.status === 'partial') {
          Swal.fire({
            icon: 'warning',
            title: 'Upload Selesai dengan Warning',
            text: response.message,
            confirmButtonText: 'OK'
          });
        } else {
          Swal.fire({
            icon: 'success',
            title: 'Upload Berhasil',
            text: response.message,
            confirmButtonText: 'OK'
          });
        }

        // Refresh tabel setelah upload
        requestBackend();
      },
      error: function(xhr) {
        resultDiv.removeClass('hidden');
        errorContainer.removeClass('hidden');
        
        let errorMessage = 'Terjadi kesalahan saat upload file';
        try {
          const response = JSON.parse(xhr.responseText);
          errorMessage = response.message || errorMessage;
        } catch (e) {}

        errorList.append(`<li>${errorMessage}</li>`);

        Swal.fire({
          icon: 'error',
          title: 'Upload Gagal',
          text: errorMessage,
          confirmButtonText: 'OK'
        });
      },
      complete: function() {
        // Reset button state
        uploadButton.prop('disabled', false);
        uploadButton.html('<i class="fas fa-upload mr-2"></i>Upload');
      }
    });
  }

  function openExportModal() {
    $('#export-modal').removeClass('hidden');
    updateExportInfo();
  }

  function updateExportInfo() {
    const selectedRole = $('input[name="export_role"]:checked').val();
    
    // Sembunyikan semua info
    $('#export-info-siswa, #export-info-guru, #export-info-admin, #export-info-all').addClass('hidden');
    
    // Tampilkan info yang sesuai
    if (selectedRole === '1') {
      $('#export-info-siswa').removeClass('hidden');
      $('#export-class-section').removeClass('hidden');
    } else if (selectedRole === '2') {
      $('#export-info-guru').removeClass('hidden');
      $('#export-class-section').addClass('hidden');
    } else if (selectedRole === '3') {
      $('#export-info-admin').removeClass('hidden');
      $('#export-class-section').addClass('hidden');
    } else {
      $('#export-info-all').removeClass('hidden');
      $('#export-class-section').addClass('hidden');
    }
  }

  function startExport() {
    const role = $('input[name="export_role"]:checked').val();
    const kelas = role === '1' ? $('#export-class').val() : '';
    
    // Tampilkan loading state
    const exportBtn = $('#start-export');
    exportBtn.prop('disabled', true);
    exportBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Exporting...');

    // Buat URL dengan query parameters
    let url = '<?= admin_url('api/export-users-xls') ?>';
    const params = new URLSearchParams();
    
    if (role) params.append('role', role);
    if (kelas) params.append('kelas', kelas);
    
    if (params.toString()) {
      url += '?' + params.toString();
    }

    // Download file
    fetch(url)
      .then(response => response.blob())
      .then(blob => {
        // Buat link untuk download
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `users_export_${new Date().toISOString().slice(0,10)}.xlsx`;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        
        // Reset button state dan tutup modal
        exportBtn.prop('disabled', false);
        exportBtn.html('<i class="fas fa-file-export mr-2"></i>Export Excel');
        $('#export-modal').addClass('hidden');
      })
      .catch(error => {
        console.error('Export failed:', error);
        Swal.fire({
          icon: 'error',
          title: 'Export Gagal',
          text: 'Terjadi kesalahan saat mengexport data',
          confirmButtonText: 'OK'
        });
        
        // Reset button state
        exportBtn.prop('disabled', false);
        exportBtn.html('<i class="fas fa-file-export mr-2"></i>Export Excel');
      });
  }
</script>

<?= $this->endSection(); ?>