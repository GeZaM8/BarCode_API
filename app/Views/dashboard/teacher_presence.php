<?= $this->extend('template/dashboard'); ?>

<?= $this->section('content'); ?>

<!-- Header -->
<div class="mb-6" data-aos="fade-up">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Kehadiran Siswa</h1>
    <p class="text-gray-600 dark:text-gray-400">Monitor dan kelola kehadiran siswa di kelas Anda</p>
</div>

<!-- Filter -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6" data-aos="fade-up" data-aos-delay="100">
    <div class="flex flex-col lg:flex-row justify-between gap-4 mb-6">
        <div class="flex-1">
            <label for="class" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Kelas</label>
            <div class="relative">
                <select id="class" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                    <option selected disabled>Pilih Kelas</option>
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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
    </div>
</div>

<div class="text-primary-600 dark:text-primary-400 hidden" id="loading" role="status">
    <div class="flex items-center justify-center">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600 dark:border-primary-400"></div>
    </div>
</div>
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="200">
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
            data: { year, month, day, kelas },
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
                renderTable(data);
            }
        })
    }

    function renderTable(data) {
        let student = data.student;
        let presence = data.presence;

        if (student.length > 0) {
            presence = student.map((item, index) => {
                const presenceCheck = presence.find(p => p.id_user == item.id_user);
                return {
                    ...item,
                    ...presenceCheck,
                    tanggal: presenceCheck ? presenceCheck.tanggal : 
                            $('#year').val() + '-' + 
                            (0 + $('#month').val()).slice(-2) + '-' + 
                            (0 + $('#day').val()).slice(-2),
                    status: presenceCheck ? presenceCheck.status : 'Tidak Hadir'
                }
            });
        }

        let html = '';
        presence.forEach((item, index) => {
            const statusClass = item.status === 'Hadir' ? 'bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500' :
                              item.status === 'Terlambat' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800/30 dark:text-yellow-500' :
                              'bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500';

            const moodIcon = item.mood === 'Baik' ? 'fa-smile text-green-500' :
                           item.mood === 'Netral' ? 'fa-meh text-yellow-500' :
                           item.mood === 'Sedih' ? 'fa-frown text-red-500' : '';

            html += `
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${index + 1}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${item.foto ? 
                          `<a href='<?= base_url("assets/upload/absensi/") ?>${item.foto}' class="hover:opacity-75 transition-opacity">
                              <img src='<?= base_url("assets/upload/absensi/") ?>${item.foto}' class="h-10 w-10 rounded-full object-cover" />
                           </a>` : 
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

    // Filter Handlers
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

    // Event Handlers
    $('#year').on('change', function() {
        yearChanged();
        requestBackend();
    });

    $('#month').on('change', function() {
        monthChanged();
        requestBackend();
    });

    $('#day, #class').on('change', requestBackend);
    $('#filter').on('click', defaultFilter);
    $('#refresh').on('click', requestBackend);

    // Initialize
    defaultFilter();
});
</script>
<?= $this->endSection(); ?>