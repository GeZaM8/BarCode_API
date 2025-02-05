<?= $this->extend('template/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="flex justify-between items-center mb-6">
    <div class="flex items-center gap-4">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Jurusan</h1>
        <div class="text-primary-600 dark:text-primary-400 hidden" id="loading" role="status">
            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>
    <div class="flex gap-2">
        <button id="refresh" onclick="loadTable()" class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 text-sm font-medium transition-colors">
            Refresh
        </button>
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
  let refresh = $('#refresh');

  loadTable();

  function loadTable() {
    $.ajax({
      url: '<?= teacher_url('api/get-jurusan') ?>',
      method: 'GET',
      dataType: 'json',
      beforeSend: function() {
        loading.removeClass("hidden");
        refresh.attr('disabled', true);
      },
      success: function(res) {
        loading.addClass("hidden");
        refresh.attr('disabled', false);
        head.html(`
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No.</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kode Jurusan</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Jurusan</th>
          </tr>
        `);
        
        table.html('');
        res.forEach((item, index) => {
          table.append(`
            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
              <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${index + 1}</td>
              <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.kode_jurusan}</td>
              <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nama_jurusan}</td>
            </tr>
          `);
        });
      },
      error: function(res) {
        loading.addClass("hidden");
        refresh.attr('disabled', false);
        toastFailRequest(res);
      }
    })
  }
</script>
<?= $this->endSection(); ?>