<?= $this->extend('template/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="mb-6" data-aos="fade-up">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Kehadiran Kelas</h1>
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

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Alasan Mood</h3>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    <i class="fas fa-smile text-green-500 mr-2"></i>Baik
                </span>
                <button onclick="showMoodReasons('Baik')" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    Lihat Alasan
                </button>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    <i class="fas fa-meh text-yellow-500 mr-2"></i>Netral
                </span>
                <button onclick="showMoodReasons('Netral')" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    Lihat Alasan
                </button>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    <i class="fas fa-frown text-red-500 mr-2"></i>Sedih
                </span>
                <button onclick="showMoodReasons('Sedih')" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    Lihat Alasan
                </button>
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
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">#</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Foto</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kelas</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jurusan</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">No. Absen</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Timestamp</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Mood</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700/50" id="data-table">
            </tbody>
        </table>
    </div>
</div>

<div id="reason-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-center justify-center p-4">        
        <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 backdrop-blur-sm transition-opacity"></div>    
        <div class="relative w-full max-w-md transform overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-2xl transition-all animate__animated animate__fadeInDown animate__faster">
            
            <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
                <h3 id="modal-title" class="text-lg font-medium text-gray-900 dark:text-white">
                    Detail Kehadiran
                </h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>

            
            <div class="p-6 space-y-4">
                
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Mood Hari Ini
                    </label>
                    <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="mood-icon w-10 h-10 rounded-full flex items-center justify-center bg-white dark:bg-gray-600">
                            
                        </div>
                        <div>
                            <div class="mood-text font-medium text-gray-900 dark:text-white">
                                
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mood-time">
                                
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Alasan
                    </label>
                    <div class="relative">
                        <textarea 
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg resize-none text-gray-900 dark:text-white min-h-[100px]" 
                            disabled
                        ></textarea>
                    </div>
                </div>

                
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Status Kehadiran
                    </label>
                    <div class="status-badge">
                        
                    </div>
                </div>
            </div>

            
            <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4">
                <button type="button" onclick="closeModal()" 
                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>


<div id="mood-reasons-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-center justify-center p-4">
        
        <div class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 backdrop-blur-sm transition-opacity"></div>
        
        
        <div class="relative w-full max-w-2xl transform overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-2xl transition-all">
            
            <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
                <h3 id="mood-modal-title" class="text-lg font-medium text-gray-900 dark:text-white flex items-center gap-2">
                    
                </h3>
                <button onclick="closeMoodModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>

            
            <div class="p-6 overflow-y-auto max-h-[60vh]">
                <div class="mood-modal-body space-y-4">
                    
                </div>
            </div>

            
            <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-end">
                <button type="button" onclick="closeMoodModal()" 
                        class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
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
            const modal = $('#reason-modal');
            
            // Configure mood display
            const moodConfig = {
                'Baik': { icon: 'fa-smile', color: 'text-green-500', bg: 'bg-green-100 dark:bg-green-800/30' },
                'Netral': { icon: 'fa-meh', color: 'text-yellow-500', bg: 'bg-yellow-100 dark:bg-yellow-800/30' },
                'Sedih': { icon: 'fa-frown', color: 'text-red-500', bg: 'bg-red-100 dark:bg-red-800/30' }
            };
            
            const mood = moodConfig[data.mood] || { icon: 'fa-question', color: 'text-gray-500', bg: 'bg-gray-100 dark:bg-gray-800/30' };
            
            // Update mood section
            modal.find('.mood-icon').html(`<i class="fas ${mood.icon} ${mood.color} text-xl"></i>`);
            modal.find('.mood-text').text(data.mood || 'Tidak ada data');
            modal.find('.mood-time').text(data.timestamp || 'Waktu tidak tercatat');
            
            // Update reason
            modal.find('textarea').val(data.reason || 'Tidak ada alasan yang dicatat');
            
            // Update status badge
            const statusConfig = {
                'Hadir': { icon: 'fa-check', class: 'bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500' },
                'Terlambat': { icon: 'fa-clock', class: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800/30 dark:text-yellow-500' },
                'Tidak Hadir': { icon: 'fa-times', class: 'bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500' }
            };
            
            const status = statusConfig[data.status] || statusConfig['Tidak Hadir'];
            
            modal.find('.status-badge').html(`
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${status.class}">
                    <i class="fas ${status.icon} mr-2"></i>${data.status || 'Tidak ada status'}
                </span>
            `);
            
            // Update title
            modal.find('#modal-title').html(`
                <div class="flex items-center gap-2">
                    <i class="fas fa-info-circle text-primary-500"></i>
                    <span>Detail Kehadiran - ${data.nama}</span>
                </div>
            `);
            
            // Show modal with animation
            modal.removeClass('hidden');
        }
    });
  }

  function closeModal() {
    const modal = $('#reason-modal');
    modal.addClass('animate__animated animate__fadeOut');
    
    setTimeout(() => {
        modal.addClass('hidden').removeClass('animate__animated animate__fadeOut');
    }, 200);
  }
</script>

<script>
  // Deklarasikan variabel presence dan moodConfig di awal file, sebelum semua fungsi
  let presence = [];

  // Konfigurasi mood global
  const moodConfig = {
      'Baik': { 
          icon: 'fa-smile', 
          color: 'text-green-500', 
          bg: 'bg-green-100 dark:bg-green-800/30' 
      },
      'Netral': { 
          icon: 'fa-meh', 
          color: 'text-yellow-500', 
          bg: 'bg-yellow-100 dark:bg-yellow-800/30' 
      },
      'Sedih': { 
          icon: 'fa-frown', 
          color: 'text-red-500', 
          bg: 'bg-red-100 dark:bg-red-800/30' 
      }
  };

  $(document).ready(function() {
    const urlbase = new URL(window.location.href);

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
          // Assign data ke variabel global presence
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

          // Update statistik
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
            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200 cursor-pointer group" onclick="showReasonModal(${item.id_absensi})">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${index + 1}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    ${item.foto ? 
                      `<img src='<?= base_url("assets/upload/absensi/") ?>${item.foto}' class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-700 group-hover:ring-primary-500 transition-all duration-200" />` : 
                      `<div class="h-10 w-10 rounded-full bg-gray-100 dark:bg-gray-700 ring-2 ring-gray-200 dark:ring-gray-600 group-hover:ring-primary-500 transition-all duration-200 flex items-center justify-center">
                           <i class="fas fa-user text-gray-400"></i>
                       </div>`}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900 dark:text-white">${item.nama}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${item.email}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${item.kelas}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${item.kode_jurusan}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${item.no_absen}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${item.timestamp ?? '-'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    ${item.mood ? `<span class="inline-flex items-center gap-1.5"><i class="fas ${moodIcon}"></i>${item.mood}</span>` : '-'}
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

<script>
// Fungsi untuk menampilkan alasan mood
window.showMoodReasons = function(moodType) {
    if (!presence || presence.length === 0) {
        toastError('Data tidak tersedia');
        return;
    }

    const modal = $('#mood-reasons-modal');
    const modalTitle = $('#mood-modal-title');
    const modalBody = $('.mood-modal-body');
    
    // Filter data berdasarkan mood
    const filteredData = presence.filter(p => p.mood === moodType);
    
    if (filteredData.length === 0) {
        modalBody.html(`
            <div class="flex flex-col items-center justify-center py-12">
                <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">
                    <i class="fas fa-inbox text-3xl text-gray-400 dark:text-gray-500"></i>
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-center">
                    Tidak ada alasan untuk mood ${moodType}
                </p>
            </div>
        `);
    } else {
        const mood = moodConfig[moodType];
        
        // Generate list alasan
        const reasonsList = filteredData.map(data => `
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:border-primary-500 dark:hover:border-primary-500 transition-colors duration-200">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                ${data.foto ? 
                                    `<img src="<?= base_url('assets/upload/absensi/') ?>${data.foto}" 
                                          class="w-12 h-12 rounded-full object-cover ring-2 ring-offset-2 ${mood.bg} ring-offset-white dark:ring-offset-gray-800"/>` :
                                    `<div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center ring-2 ring-offset-2 ${mood.bg} ring-offset-white dark:ring-offset-gray-800">
                                        <i class="fas fa-user text-gray-400 dark:text-gray-500"></i>
                                     </div>`
                                }
                                <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center ring-2 ring-white dark:ring-gray-800">
                                    <i class="fas ${mood.icon} ${mood.color} text-sm"></i>
                                </div>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white">${data.nama}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                    <i class="fas fa-clock text-xs"></i>
                                    ${data.timestamp || 'Waktu tidak tercatat'}
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${mood.bg} ${mood.color}">
                                ${data.kelas}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                ${data.status === 'Hadir' ? 'bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500' : 
                                data.status === 'Terlambat' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800/30 dark:text-yellow-500' : 
                                'bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500'}">
                                <i class="fas ${data.status === 'Hadir' ? 'fa-check' : 
                                           data.status === 'Terlambat' ? 'fa-clock' : 
                                           'fa-times'} mr-1.5 text-xs"></i>
                                ${data.status}
                            </span>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                        <p class="text-gray-600 dark:text-gray-300 text-sm whitespace-pre-wrap">
                            ${data.reason || 'Tidak ada alasan yang dicatat'}
                        </p>
                    </div>
                </div>
            </div>
        `).join('');
        
        modalBody.html(reasonsList);
    }
    
    // Update judul modal dengan jumlah data
    modalTitle.html(`
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full ${moodConfig[moodType].bg} flex items-center justify-center">
                <i class="fas ${moodConfig[moodType].icon} ${moodConfig[moodType].color}"></i>
            </div>
            <div>
                <span>Alasan Mood ${moodType}</span>
                <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">(${filteredData.length} siswa)</span>
            </div>
        </div>
    `);
    
    // Tampilkan modal dengan animasi
    modal.removeClass('hidden')
         .addClass('animate__animated animate__fadeIn animate__faster');
}

// Fungsi untuk menutup modal mood
window.closeMoodModal = function() {
    const modal = $('#mood-reasons-modal');
    modal.addClass('animate__animated animate__fadeOut');
    
    setTimeout(() => {
        modal.addClass('hidden')
             .removeClass('animate__animated animate__fadeOut');
    }, 200);
}
</script>
<?= $this->endSection(); ?>