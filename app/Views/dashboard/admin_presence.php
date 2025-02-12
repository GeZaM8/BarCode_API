<?= $this->extend('template/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="mb-6" data-aos="fade-up">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Kehadiran Kelas</h1>
    <p class="text-gray-600 dark:text-gray-400">Kelola dan monitor kehadiran siswa</p>
</div>
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6" data-aos="fade-up" data-aos-delay="100">
    <div class="flex flex-col lg:flex-row justify-between gap-4 mb-6">
        <div class="flex-1">
            <label for="class" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Kelas</label>
            <div class="relative">
                <select id="class" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                    <option selected value="">Semua Kelas</option>
                    <?php foreach ($class as $c): ?>
                        <option value="<?= $c->kelas ?>"><?= $c->kelas ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button id="filter" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                <i class="fas fa-filter mr-2"></i>
                Reset Filter
            </button>
            <button id="refresh" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                <i class="fas fa-sync-alt mr-2"></i>
                Refresh
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun</label>
            <select id="year" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                <option selected disabled>Pilih Tahun</option>
                <?php for ($i = $end_year; $i >= $start_year; $i--): ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div>
            <label for="month" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bulan</label>
            <select id="month" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                <option selected disabled>Pilih tahun terlebih dahulu</option>
            </select>
        </div>
        <div>
            <label for="day" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Hari</label>
            <select id="day" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                <option selected disabled>Pilih bulan terlebih dahulu</option>
            </select>
        </div>
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
            <select id="status" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                <option selected value="">Semua Status</option>
                <option value="Hadir">Hadir</option>
                <option value="Terlambat">Terlambat</option>
                <option value="Tidak Hadir">Tidak Hadir</option>
            </select>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6" data-aos="fade-up" data-aos-delay="200">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Status Kehadiran</h3>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">Hadir</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500">
                    <span id="hadir">0</span>
                </span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">Terlambat</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800/30 dark:text-yellow-500">
                    <span id="terlambat">0</span>
                </span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">Tidak Hadir</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500">
                    <span id="tidak-hadir">0</span>
                </span>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Statistik Mood</h3>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    <i class="fas fa-smile text-green-500 mr-2"></i>Baik
                </span>
                <span class="font-medium text-gray-900 dark:text-white" id="baik">0</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    <i class="fas fa-meh text-yellow-500 mr-2"></i>Netral
                </span>
                <span class="font-medium text-gray-900 dark:text-white" id="netral">0</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    <i class="fas fa-frown text-red-500 mr-2"></i>Sedih
                </span>
                <span class="font-medium text-gray-900 dark:text-white" id="sedih">0</span>
            </div>
        </div>
    </div>

    <div class="hidden" id="loading" role="status">
        <div class="flex items-center justify-center h-full">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
        </div>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="300">
    <div class="overflow-x-auto">
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
</div>

<div id="reason-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <div class="inline-block transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100" id="modal-title">
                                Detil Kehadiran
                            </h3>
                            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <span class="sr-only">Close</span>
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body space-y-4">
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <button type="button" onclick="closeModal()" 
                        class="mt-3 inline-flex w-full justify-center rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-base font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm transition-colors duration-200">
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
        
        let reasonField = `
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alasan</label>
              <textarea class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm" disabled rows="4">${data.reason ?? "-"}</textarea>
            </div>
        `;

        body.html(`
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mood</label>
            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm" value="${data.mood ?? "-"}" disabled>
          </div>
          ${reasonField}
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
        const statusClass = item.status === 'Hadir' ? 'bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500' :
                           item.status === 'Terlambat' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800/30 dark:text-yellow-500' :
                           'bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500';

        const moodIcon = item.mood === 'Baik' ? 'fa-smile text-green-500' :
                        item.mood === 'Netral' ? 'fa-meh text-yellow-500' :
                        item.mood === 'Sedih' ? 'fa-frown text-red-500' : '';

        html += `
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 cursor-pointer" onclick="showReasonModal(${item.id_absensi})">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${index + 1}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    ${item.foto ? 
                      `<img src='<?= base_url("assets/upload/absensi/") ?>${item.foto}' class="h-10 w-10 rounded-full object-cover" />` : 
                      `<div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                           <i class="fas fa-user text-gray-400"></i>
                       </div>`}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">${item.nama}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${item.email}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${item.kelas}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${item.kode_jurusan}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${item.no_absen}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${item.timestamp ?? '-'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    ${item.mood ? `<i class="fas ${moodIcon}"></i> ${item.mood}` : '-'}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusClass}">
                        ${item.status}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${item.tanggal ?? '-'}</td>
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