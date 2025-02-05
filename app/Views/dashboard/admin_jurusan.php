<?= $this->extend('template/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="flex justify-between items-center mb-6">
    <div class="flex items-center gap-4">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Jurusan</h1>
        <div class="text-primary-600 dark:text-primary-400" id="loading" role="status">
            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="flex gap-2">
        <button onclick="openData()" class="px-3 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 text-sm font-medium transition-colors">
            Tambah
        </button>
        <button onclick="loadTable()" class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 text-sm font-medium transition-colors">
            Refresh
        </button>
    </div>
</div>

<div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700" id="head-table">
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="data-table">
        </tbody>
    </table>
</div>

<div id="edit-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="inline-block transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <form id="edit-form" onsubmit="formHandle(event)">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100" id="modal-title">
                        Tambah Jurusan
                    </h3>
                    <div class="mt-4 space-y-4">
                        <div>
                            <label for="kode_jurusan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Kode Jurusan
                            </label>
                            <input type="text" name="kode_jurusan" id="kode_jurusan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                        </div>
                        <div>
                            <label for="nama_jurusan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nama Jurusan
                            </label>
                            <input type="text" name="nama_jurusan" id="nama_jurusan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="submit" class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                        Simpan
                    </button>
                    <button type="button" onclick="closeModal()" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
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
  let editForm = $('#edit-form');
  let editModal = $('#edit-modal');

  function openModal() {
    editModal.removeClass('hidden');
  }

  function closeModal() {
    editModal.addClass('hidden');
  }

  function openData(id = null) {
    if (id == null) {
      openModal();
      $('#modal-title').text('Tambah Jurusan');
      editForm.attr('action', '<?= admin_url('api/add-jurusan') ?>');
      editForm.trigger('reset');
      return;
    }

    $.ajax({
      url: '<?= admin_url('api/get-jurusan/') ?>' + id,
      method: 'GET',
      dataType: 'json',
      beforeSend: function() {
        $('button').attr('disabled', true);
        closeModal();
        $('#modal-title').text('Edit Jurusan');
        editForm.trigger('reset');
        loading.removeClass("hidden");
      },
      success: function(res) {
        $('button').attr('disabled', false);
        loading.addClass("hidden");
        openModal();
        editForm.find('#kode_jurusan').val(res.kode_jurusan);
        editForm.find('#nama_jurusan').val(res.nama_jurusan);
        editForm.attr('action', '<?= admin_url('api/edit-jurusan/') ?>' + id);
      },
      error: function(res) {
        $('button').attr('disabled', false);
        loading.addClass("hidden");
        toastFailRequest(res);
      }
    })
  }

  function deleteJurusan(id) {
    if(!confirm('Apakah anda yakin ingin menghapus data ini?')) return;
    
    $.ajax({
      url: '<?= admin_url('api/delete-jurusan/') ?>' + id,
      method: 'DELETE',
      dataType: 'json',
      beforeSend: function() {
        $('button').attr('disabled', true);
      },
      success: function(res) {
        $('button').attr('disabled', false);
        loadTable();
        toastSuccessRequest(res.message);
      },
      error: function(res) {
        $('button').attr('disabled', false);
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
        $('button').attr('disabled', true);
      },
      complete: function() {
        $('button').attr('disabled', false);
      },
      success: function(res) {
        closeModal();
        loadTable();
        toastSuccessRequest(res.message);
      },
      error: function(res) {
        toastFailRequest(res);
      }
    })
  }

  loadTable();

  function loadTable() {
    $.ajax({
      url: '<?= admin_url('api/get-jurusan') ?>',
      method: 'GET',
      dataType: 'json',
      beforeSend: function() {
        loading.removeClass("hidden");
        $('button').attr('disabled', true);
      },
      success: function(res) {
        loading.addClass("hidden");
        $('button').attr('disabled', false);
        head.html(`
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No.</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kode Jurusan</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Jurusan</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
          </tr>
        `);
        
        table.html('');
        res.forEach((item, index) => {
          table.append(`
            <tr class="bg-white dark:bg-gray-800">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">${index + 1}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">${item.kode_jurusan}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">${item.nama_jurusan}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                <button onclick="openData('${item.kode_jurusan}')" class="text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300">
                  <i class="bi bi-pencil-fill"></i>
                </button>
                <button onclick="deleteJurusan('${item.kode_jurusan}')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                  <i class="bi bi-trash-fill"></i>
                </button>
              </td>
            </tr>
          `);
        });
      },
      error: function(res) {
        loading.addClass("hidden");
        $('button').attr('disabled', false);
        toastFailRequest(res);
      }
    })
  }
</script>
<?= $this->endSection(); ?>