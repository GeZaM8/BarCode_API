<?= $this->extend('template/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="mb-6" data-aos="fade-up">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Manajemen Pengguna</h1>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6" data-aos="fade-up" data-aos-delay="100">
    <div class="flex flex-col lg:flex-row justify-between gap-4 mb-6">
        <div class="flex-1">
            <label for="role_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
            <div class="relative">
                <select id="role_filter" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                    <option selected disabled>Pilih Role</option>
                    <option value="">Semua</option>
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= $r->id_role ?>"><?= $r->name_role ?></option>
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

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="class" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kelas</label>
            <select id="class" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200" disabled>
                <option selected disabled value="">Pilih Role Siswa</option>
                <?php foreach ($kelas as $c): ?>
                    <option value="<?= $c->id_kelas ?>"><?= $c->kelas ?></option>
                <?php endforeach; ?>
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
            <thead class="bg-gray-50 dark:bg-gray-700" id="head-table">
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="data-table">
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
let baseUrl = "<?= teacher_url() ?>";
let table = $('#data-table');
let head = $('#head-table');
let loading = $('#loading');
let filter = $('#filter');
let refresh = $('#refresh');
let role = $('#role_filter');
let kelas = $('#class');

function requestBackend() {
    $.ajax({
        url: '<?= teacher_url('api/get-users') ?>',
        method: 'GET',
        dataType: 'json',
        data: {
            role: role.val(),
            kelas: kelas.val(),
        },
        beforeSend: function() {
            loading.removeClass("hidden");
            filter.attr('disabled', true);
            refresh.attr('disabled', true);
        },
        complete: function() {
            loading.addClass("hidden");
            filter.attr('disabled', false);
            refresh.attr('disabled', false);
        },
        error: function(err) {
            toastFailRequest(err)
        },
        success: function(data) {
            toastSuccessRequest()
            renderTable(data);
        }
    });
}

function renderTable(data) {
    let type = data.type;
    let users = data.users;

    table.html('');
    head.html('');

    if (users.length === 0) {
        table.html(`
            <tr>
                <td colspan="9" class="px-6 py-12">
                    <div class="text-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-users text-4xl mb-3"></i>
                        <p>Tidak ada data pengguna</p>
                    </div>
                </td>
            </tr>
        `);
        return;
    }

    switch (type) {
        case '1': // Siswa
            renderStudentTable(users);
            break;
        case '2': // Guru
            renderTeacherTable(users);
            break;
        case '3': // Admin
            renderAdminTable(users);
            break;
        default:
            renderDefaultTable(users);
    }
}

function renderStudentTable(users) {
    head.append(`
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kelas</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jurusan</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No. Absen</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NIS</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NISN</th>
        </tr>
    `);

    users.forEach((item, index) => {
        table.append(`
            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${index + 1}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.id_user}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nama}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.email ?? '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.kelas ?? '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.kode_jurusan ?? '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.no_absen ?? '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nis ?? '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nisn ?? '-'}</td>
            </tr>
        `);
    });
}

function renderTeacherTable(users) {
    head.append(`
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NIP</th>
        </tr>
    `);

    users.forEach((item, index) => {
        table.append(`
            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${index + 1}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.id_user}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nama}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.email ?? '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nip ?? '-'}</td>
            </tr>
        `);
    });
}

function renderAdminTable(users) {
    head.append(`
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
        </tr>
    `);

    users.forEach((item, index) => {
        table.append(`
            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${index + 1}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.id_user}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nama}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.email ?? '-'}</td>
            </tr>
        `);
    });
}

function renderDefaultTable(users) {
    head.append(`
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
        </tr>
    `);

    users.forEach((item, index) => {
        table.append(`
            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${index + 1}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.id_user}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.nama}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.email ?? '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">${item.name_role ?? '-'}</td>
            </tr>
        `);
    });
}

$(document).ready(function() {
    role.on('change', function() {
        if ($(this).val() == 1) {
            kelas.prop('disabled', false);
        } else {
            kelas.prop('disabled', true);
            kelas.val('');
        }
        requestBackend();
    });

    kelas.on('change', function() {
        requestBackend();
    });

    filter.on('click', function() {
        role.val('');
        kelas.val('');
        kelas.prop('disabled', true);
        requestBackend();
    });

    refresh.on('click', function() {
        requestBackend();
    });

    requestBackend();
});
</script>
<?= $this->endSection(); ?>