<?= $this->extend('template/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="flex justify-between items-center mb-4">
    <div class="flex items-center gap-4">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Kehadiran</h1>
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

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
    <div>
        <label for="class" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas</label>
        <select id="class" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
            <option selected disabled>Pilih Kelas</option>
            <?php foreach ($class as $c): ?>
                <option value="<?= $c->kelas ?>"><?= $c->kelas ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun</label>
        <select id="year" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
            <option selected disabled>Pilih Tahun</option>
            <?php for ($i = $end_year; $i >= $start_year; $i--): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
        </select>
    </div>
    <div>
        <label for="month" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bulan</label>
        <select id="month" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
            <option selected disabled>Pilih tahun terlebih dahulu</option>
        </select>
    </div>
    <div>
        <label for="day" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hari</label>
        <select id="day" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
            <option selected disabled>Pilih bulan terlebih dahulu</option>
        </select>
    </div>
</div>

<div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Foto</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kelas</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jurusan</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No. Absen</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Timestamp</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Mood</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="data-table">
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
  $(document).ready(function() {
    function requestBackend() {
      let year = $('#year').val();
      let month = $('#month').val();
      let day = $('#day').val();
      let kelas = $('#class').val();

      $.ajax({
        url: '<?= teacher_url('api/get-presence') ?>',
        method: 'GET',
        dataType: 'json',
        data: {
          year,
          month,
          day,
          kelas
        },
        beforeSend: function() {
          $('#filter').attr('disabled', true);
          $('#refresh').attr('disabled', true);
          $('#loading').removeClass("hidden");
        },
        complete: function() {
          $('#filter').attr('disabled', false);
          $('#refresh').attr('disabled', false);
          $('#loading').addClass("hidden");
        },
        error: function(err) {
          toastFailRequest(err)
        },
        success: function(data) {
          toastSuccessRequest();

          let student = data.student;
          let presence = data.presence;

          if (student.length > 0) {
            presence = student.map((item, index) => {
              const presenceCheck = presence.find(presence => presence.id_user == item.id_user);

              return {
                ...item,
                ...presenceCheck,
                tanggal: presenceCheck ? presenceCheck.tanggal : $('#year').val() + '-' + (0 + $('#month').val()).slice(-2) + '-' + (0 + $('#day').val()).slice(-2),
                status: presenceCheck ? presenceCheck.status : 'Tidak Hadir'
              }
            })
          }

          let html = '';
          presence.forEach((item, index) => {
            html += `
            <tr class="bg-white dark:bg-gray-800">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">${index + 1}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                ${item.foto ? 
                  `<a href='<?= base_url("assets/upload/absensi/") ?>${item.foto}' class="hover:opacity-75 transition-opacity">
                    <img src='<?= base_url("assets/upload/absensi/") ?>${item.foto}' class="w-16 h-16 object-cover rounded-lg" />
                  </a>` : `-`}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">${item.nama}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">${item.email}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">${item.kelas}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">${item.kode_jurusan}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">${item.no_absen}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">${item.timestamp ?? '-'}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">${item.mood ?? '-'}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center rounded-md ${item.status == 'Hadir' ? 'bg-green-100 text-green-700 dark:bg-green-800/30 dark:text-green-500' : 'bg-red-100 text-red-700 dark:bg-red-800/30 dark:text-red-500'} px-2 py-1 text-sm font-medium">
                  ${item.status}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">${item.tanggal ?? '-'}</td>
            </tr>
            `;
          });
          $('#data-table').html(html);
        }
      })
    }

    // ==========================================
    // Filter Handler
    // ==========================================

    function yearChanged() {
      $('#day').html('<option selected disabled>Pilih bulan terlebih dahulu</option>');
      $('#month').html('<option selected disabled>Pilih bulan</option>');
      $('#month').append('<option value="<?= date('n') ?>">Bulan ini</option>');
      for (let i = 1; i <= 12; i++) {
        $('#month').append(`<option value="${i}">${i}</option>`);
      }
    }

    function monthChanged() {
      $('#day').html('<option selected disabled>Pilih hari</option>');
      $('#day').append('<option value="<?= date('j') ?>">Hari ini</option>');
      const totalDay = new Date($('#year').val(), $('#month').val(), 0).getDate();
      for (let i = 1; i <= totalDay; i++) {
        $('#day').append(`<option value="${i}">${i}</option>`);
      }
    }

    function defaultFilter() {
      $('#year').val(<?= date('Y') ?>);
      yearChanged();
      $('#month').val(<?= date('m') ?>);
      monthChanged();
      $('#day').val(<?= date('d') ?>);
      $('#class').val($('#class option:first').val());

      requestBackend();
    }

    defaultFilter();

    // ==========================================
    // Event Handler
    // ==========================================

    $('#year').on('change', function() {
      yearChanged();
      requestBackend();
    })

    $('#month').on('change', function() {
      monthChanged();
      requestBackend();
    })

    $('#day').on('change', function() {
      requestBackend();
    })

    $('#class').on('change', function() {
      requestBackend();
    })

    $('#filter').on('click', defaultFilter)
    $('#refresh').on('click', requestBackend)

  });
</script>
<?= $this->endSection(); ?>