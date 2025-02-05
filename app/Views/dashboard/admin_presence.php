<?= $this->extend('template/dashboard'); ?>

<?= $this->section('styles'); ?>
<style>
  .table tr th,
  .table tr td {
    white-space: nowrap;
  }

  .table tr {
    cursor: pointer;
  }
</style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<div class="flex justify-between items-center mb-4">
    <div class="flex items-center gap-4">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Kehadiran Kelas</h1>
        <div>
            <select id="class" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                <option selected value="">Pilih Kelas</option>
                <?php foreach ($class as $c): ?>
                    <option value="<?= $c->kelas ?>"><?= $c->kelas ?></option>
                <?php endforeach; ?>
            </select>
        </div>
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
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
        <select id="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
            <option selected value="">Pilih Status</option>
            <option value="Hadir">Hadir</option>
            <option value="Terlambat">Terlambat</option>
            <option value="Tidak Hadir">Tidak Hadir</option>
        </select>
    </div>
</div>

<div class="flex justify-between mb-4">
    <div class="flex gap-3">
        <span class="inline-flex items-center rounded-md bg-green-100 px-2 py-1 text-sm font-medium text-green-700 dark:bg-green-800/30 dark:text-green-500">
            Hadir: <span id="hadir" class="ml-1">0</span>
        </span>
        <span class="inline-flex items-center rounded-md bg-yellow-100 px-2 py-1 text-sm font-medium text-yellow-700 dark:bg-yellow-800/30 dark:text-yellow-500">
            Terlambat: <span id="terlambat" class="ml-1">0</span>
        </span>
        <span class="inline-flex items-center rounded-md bg-red-100 px-2 py-1 text-sm font-medium text-red-700 dark:bg-red-800/30 dark:text-red-500">
            Tidak Hadir: <span id="tidak-hadir" class="ml-1">0</span>
        </span>
    </div>
    <div class="flex gap-3 text-sm text-gray-600 dark:text-gray-400">
        <span>Mood Baik: <span id="baik" class="font-medium">0</span></span>
        <span>Mood Netral: <span id="netral" class="font-medium">0</span></span>
        <span>Mood Sedih: <span id="sedih" class="font-medium">0</span></span>
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

<div id="reason-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="inline-block transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100" id="modal-title">Detil Kehadiran</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body space-y-4">
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <button type="button" onclick="closeModal()" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
  function showReasonModal(id) {
    $.ajax({
      url: '<?= admin_url('api/get-presence/') ?>' + id,
      method: 'GET',
      dataType: 'json',
      success: function(data) {
        let modal = $('#reason-modal');
        let body = modal.find('.modal-body');
        let title = modal.find('#modal-title');
        body.html(`
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mood</label>
            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm" value="${data.mood ?? "-"}" disabled>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reason</label>
            <textarea class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm" disabled rows="4">${data.reason ?? "-"}</textarea>
          </div>
        `);
        title.text('Detil Kehadiran' + ' - ' + data.nama);
        modal.removeClass('hidden');
      }
    })
  }

  function closeModal() {
    $('#reason-modal').addClass('hidden');
  }
</script>

<script>
  $(document).ready(function() {
    const urlbase = new URL(window.location.href);
    let presence;

    function requestBackend() {
      let year = $('#year').val();
      let month = $('#month').val();
      let day = $('#day').val();
      let kelas = $('#class').val();

      $.ajax({
        url: '<?= admin_url('api/get-presence') ?>',
        method: 'GET',
        dataType: 'json',
        data: {
          year,
          month,
          day,
          kelas,
        },
        beforeSend: function() {
          $('#filter').attr('disabled', true);
          $('#refresh').attr('disabled', true);
          $('#loading').removeClass("d-none");
        },
        complete: function() {
          $('#filter').attr('disabled', false);
          $('#refresh').attr('disabled', false);
          $('#loading').addClass("d-none");
        },
        error: function(err) {
          toastFailRequest(err)
        },
        success: function(data) {
          toastSuccessRequest();

          let student = data.student;
          presence = data.presence;

          if (student.length > 0) {
            presence = student.map((user, index) => {
              const presenceCheck = presence.find(presence => presence.id_user == user.id_user);

              return {
                ...user,
                ...presenceCheck,
                tanggal: presenceCheck ? presenceCheck.tanggal : $('#year').val() + '-' + (0 + $('#month').val()).slice(-2) + '-' + (0 + $('#day').val()).slice(-2),
                status: presenceCheck ? presenceCheck.status : 'Tidak Hadir'
              }
            })
          }

          $('#hadir').text(presence.filter(presence => presence.status == 'Hadir').length);
          $('#terlambat').text(presence.filter(presence => presence.status == 'Terlambat').length);
          $('#tidak-hadir').text(presence.filter(presence => presence.status == 'Tidak Hadir').length);

          $('#baik').text(presence.filter(presence => presence.mood == 'Baik').length);
          $('#netral').text(presence.filter(presence => presence.mood == 'Netral').length);
          $('#sedih').text(presence.filter(presence => presence.mood == 'Sedih').length);

          renderTable();
        }
      })
    }

    function renderTable() {
      let copyPresence = presence;

      if ($('#status').val()) {
        copyPresence = presence.filter(presence => presence.status == $('#status').val());
      }

      let html = '';
      copyPresence.forEach((item, index) => {
        html += `
            <tr onclick="showReasonModal(${item.id_absensi})">
              <th scope="row">${index + 1}</th>
              <td>
                ${item.foto ? 
                  `<a href='<?= base_url("assets/upload/absensi/") ?>${item.foto}'>
                    <img src='<?= base_url("assets/upload/absensi/") ?>${item.foto}' width='50%' />
                  </a>` : `-`}
              </td>
              <td>${item.nama}</td>
              <td>${item.email}</td>
              <td>${item.kelas}</td>
              <td>${item.kode_jurusan}</td>
              <td>${item.no_absen}</td>
              <td>${item.timestamp ?? '-'}</td>
              <td>${item.mood ?? '-'}</td>
              <td><span class="badge text-${item.status == 'Hadir' ? 'bg-success' : item.status == 'Terlambat' ? 'bg-warning' : 'bg-danger'}">${item.status}</span></td>
              <td>${item.tanggal ?? '-'}</td>
            </tr>
            `;
      });
      $('#data-table').html(html);
    }

    // ==========================================
    // Filter Handler
    // ==========================================

    function setParams() {
      urlbase.searchParams.set('year', $('#year').val());
      urlbase.searchParams.set('month', $('#month').val());
      urlbase.searchParams.set('day', $('#day').val());
      urlbase.searchParams.set('kelas', $('#class').val());
      urlbase.searchParams.set('status', $('#status').val());
      window.history.replaceState(null, null, urlbase);
    }

    function getFilterByParams() {
      $('#year').val(urlbase.searchParams.get('year'));
      yearChanged();
      $('#month').val(urlbase.searchParams.get('month'));
      monthChanged();
      $('#day').val(urlbase.searchParams.get('day'));
      $('#class').val(urlbase.searchParams.get('kelas'));
      $('#status').val(urlbase.searchParams.get('status'));

      requestBackend();
    }

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
      $('#class').val('');
      $('#status').val('');

      setParams()

      requestBackend();
    }

    if (urlbase.searchParams.get('year') || urlbase.searchParams.get('month') || urlbase.searchParams.get('day') || urlbase.searchParams.get('kelas') || urlbase.searchParams.get('status')) {
      getFilterByParams();
    } else {
      defaultFilter();
    }

    // ==========================================
    // Event Handler
    // ==========================================

    $('#year').on('change', function() {
      yearChanged();
      setParams();
      requestBackend();
    })

    $('#month').on('change', function() {
      monthChanged();
      setParams();
      requestBackend();
    })

    $('#day').on('change', function() {
      setParams();
      requestBackend();
    })

    $('#class').on('change', function() {
      setParams();
      requestBackend();
    })

    $('#status').on('change', function() {
      setParams();
      renderTable();
    })

    $('#filter').on('click', defaultFilter)
    $('#refresh').on('click', requestBackend)

  });
</script>
<?= $this->endSection(); ?>