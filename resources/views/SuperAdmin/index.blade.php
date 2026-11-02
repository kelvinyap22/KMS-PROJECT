<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Super Admin - KMS UBAYA</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen">

    <!-- HEADER -->
    <header class="bg-white border-b shadow-sm sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-blue-700 flex items-center">
                    <i class="fa-solid fa-book-open mr-2"></i> Knowledge Management System
                </h1>
                <p class="text-xs text-gray-500">Dashboard Super Admin</p>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-semibold text-sm">{{ auth()->user()->name ?? 'Super Admin' }}</p>
                    <p class="text-xs text-gray-500">Super Admin</p>
                </div>

                <form action="{{ route('staff.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center transition shadow-sm">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- CONTENT CONTAINER -->
    <main class="max-w-7xl mx-auto px-6 py-8">

        <!-- ALERTS -->
        @if(session('success'))
            <div class="mb-5 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl text-sm flex items-center shadow-sm">
                <i class="fa-solid fa-circle-check mr-2 text-base"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-5 p-4 bg-red-100 border border-red-200 text-red-700 rounded-xl text-sm flex items-center shadow-sm">
                <i class="fa-solid fa-circle-exclamation mr-2 text-base"></i> {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- TITLE & ACTION BUTTONS -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Dashboard Super Admin</h2>
                <p class="text-gray-500 text-sm">Kelola pengguna, kategori, publikasi FAQ, dan saran pertanyaan mahasiswa.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button onclick="openModalUser()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium shadow flex items-center transition">
                    <i class="fa-solid fa-user-plus mr-2"></i> Tambah User
                </button>
                <button onclick="openModalKategori()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium shadow flex items-center transition">
                    <i class="fa-solid fa-folder-plus mr-2"></i> Tambah Kategori
                </button>
            </div>
        </div>

        <!-- STATISTIK CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5 mb-8">
            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-blue-500 flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">TOTAL PUBLIK/VALIDASI</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $totalPertanyaan }}</h3>
                </div>
                <i class="fa-solid fa-database text-3xl text-blue-500"></i>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-yellow-500 flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">MENUNGGU VALIDASI</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $totalPending }}</h3>
                </div>
                <i class="fa-solid fa-clock text-3xl text-yellow-500"></i>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-green-500 flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">APPROVED / PUBLISHED</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $totalPublished }}</h3>
                </div>
                <i class="fa-solid fa-circle-check text-3xl text-green-500"></i>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-purple-500 flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">TOTAL USER STAFF</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $totalUser }}</h3>
                </div>
                <i class="fa-solid fa-users text-3xl text-purple-500"></i>
            </div>
        </div>

        <!-- TAB NAVIGASI -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-2 mb-6 flex flex-wrap gap-2">
            <button onclick="switchTab('faq')" id="tab-faq" class="tab-btn px-5 py-2.5 rounded-lg text-sm font-semibold transition bg-blue-600 text-white shadow-sm">
                <i class="fa-solid fa-list mr-2"></i> Master FAQ
            </button>
            <button onclick="switchTab('users')" id="tab-users" class="tab-btn px-5 py-2.5 rounded-lg text-sm font-semibold transition text-gray-600 hover:bg-gray-100">
                <i class="fa-solid fa-users-gear mr-2"></i> Manajemen User & Role
            </button>
            <button onclick="switchTab('kategori')" id="tab-kategori" class="tab-btn px-5 py-2.5 rounded-lg text-sm font-semibold transition text-gray-600 hover:bg-gray-100">
                <i class="fa-solid fa-folder-tree mr-2"></i> Kelola Kategori
            </button>
            <button onclick="switchTab('saran')" id="tab-saran" class="tab-btn px-5 py-2.5 rounded-lg text-sm font-semibold transition text-gray-600 hover:bg-gray-100">
                <i class="fa-solid fa-comments mr-2"></i> Saran Mahasiswa
            </button>
        </div>

        <!-- TAB 1: MASTER FAQ -->
        <div id="content-faq" class="tab-content block">
            <div class="bg-white p-5 rounded-xl shadow-sm mb-6 border border-gray-100">
                <form action="{{ route('superadmin.dashboard') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari Pertanyaan</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Masukkan pertanyaan..." class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="kategori" class="w-full border rounded-lg px-4 py-2 text-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border rounded-lg px-4 py-2 text-sm">
                            <option value="">Semua Status Validasi</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex-1 shadow-sm">
                            <i class="fa-solid fa-filter mr-1"></i> Filter
                        </button>
                        <a href="{{ route('superadmin.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- TABLE FAQ -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-900 flex items-center">
                        <i class="fa-solid fa-list mr-2 text-blue-600"></i> Master Pertanyaan FAQ (Siap / Dalam Validasi)
                    </h3>
                    <span class="text-xs font-semibold px-3 py-1 bg-blue-100 text-blue-700 rounded-full">
                        {{ $pertanyaans->total() }} Data Terfilter
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 border-b">
                            <tr>
                                <th class="px-5 py-4">No</th>
                                <th class="px-5 py-4">Kategori</th>
                                <th class="px-5 py-4">Pertanyaan & Jawaban</th>
                                <th class="px-5 py-4 text-center">Status</th>
                                <th class="px-5 py-4 text-center">Pembuat & Validator</th>
                                <th class="px-5 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($pertanyaans as $index => $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4 text-gray-500">{{ $pertanyaans->firstItem() + $index }}</td>
                                    <td class="px-5 py-4">
                                        <span class="px-2.5 py-1 bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold">
                                            {{ $item->kategori->nama ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 max-w-md">
                                        <p class="font-semibold text-gray-900 mb-1">{{ $item->pertanyaan }}</p>
                                        <p class="text-gray-600 text-xs leading-relaxed line-clamp-2">{{ $item->jawaban }}</p>

                                        @if($item->catatan_review)
                                            <div class="mt-2 text-xs bg-red-50 text-red-700 border border-red-100 p-2 rounded-lg flex items-start gap-1">
                                                <i class="fa-solid fa-comment-dots mt-0.5"></i>
                                                <span><strong>Catatan Validator:</strong> {{ $item->catatan_review }}</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        @php
                                            $badge = match($item->status) {
                                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'published' => 'bg-green-100 text-green-800 border-green-200',
                                                'rejected' => 'bg-red-100 text-red-800 border-red-200',
                                                default => 'bg-gray-100 text-gray-700'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 border rounded-full text-xs font-semibold {{ $badge }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center text-xs text-gray-600 space-y-1">
                                        <div>
                                            <span class="text-gray-400">Pembuat:</span>
                                            <p class="font-medium text-gray-900">
                                                <i class="fa-solid fa-user-pen mr-1 text-blue-500"></i>
                                                {{ $item->creator->name ?? '-' }}
                                            </p>
                                        </div>
                                        <div>
                                            <span class="text-gray-400">Validator:</span>
                                            <p class="font-medium {{ $item->reviewer ? 'text-green-700' : 'text-gray-400' }}">
                                                <i class="fa-solid fa-user-check mr-1"></i>
                                                {{ $item->reviewer->name ?? 'Belum Diverifikasi' }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <div class="flex justify-center items-center gap-1.5">
                                            <!-- DETAIL -->
                                            <button onclick="openModalDetailFaq({{ json_encode($item->load(['kategori', 'creator', 'reviewer'])) }})" class="bg-blue-100 hover:bg-blue-200 text-blue-700 p-2 rounded-lg text-xs" title="Lihat Detail & Audit">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>

                                            <!-- EDIT -->
                                            <button onclick="openModalEditFaq({{ json_encode($item) }})" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 p-2 rounded-lg text-xs" title="Edit FAQ">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>

                                            <!-- HAPUS -->
                                            <form action="{{ route('superadmin.pertanyaan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 p-2 rounded-lg text-xs" title="Hapus FAQ">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-10 text-gray-400">
                                        <i class="fa-solid fa-folder-open text-3xl mb-2"></i>
                                        <p>Tidak ada data pertanyaan (Draft disembunyikan dari Super Admin).</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t">
                    {{ $pertanyaans->links() }}
                </div>
            </div>
        </div>

        <!-- TAB 2: MANAJEMEN USER -->
        <div id="content-users" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-900 flex items-center">
                        <i class="fa-solid fa-users-gear mr-2 text-blue-600"></i> Daftar User & Role Staff
                    </h3>
                    <button onclick="openModalUser()" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
                        + User Baru
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 border-b">
                            <tr>
                                <th class="px-5 py-4">ID</th>
                                <th class="px-5 py-4">Nama Lengkap</th>
                                <th class="px-5 py-4">Email</th>
                                <th class="px-5 py-4 text-center">Role</th>
                                <th class="px-5 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4 text-gray-500">#{{ $user->id }}</td>
                                    <td class="px-5 py-4 font-semibold text-gray-900">{{ $user->name }}</td>
                                    <td class="px-5 py-4 text-gray-600">{{ $user->email }}</td>
                                    <td class="px-5 py-4 text-center">
                                        @php
                                            $roleBadge = match($user->role_id) {
                                                1 => 'bg-blue-100 text-blue-800 border-blue-200',
                                                2 => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                3 => 'bg-purple-100 text-purple-800 border-purple-200',
                                                default => 'bg-gray-100 text-gray-700'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 border rounded-full text-xs font-semibold {{ $roleBadge }}">
                                            {{ $user->role->nama ?? 'Tanpa Role' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <button onclick="openModalEditUser({{ json_encode($user) }})" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 p-2 rounded-lg text-xs" title="Edit User">
                                                <i class="fa-solid fa-user-pen"></i>
                                            </button>
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 p-2 rounded-lg text-xs" title="Hapus User">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t">{{ $users->links() }}</div>
            </div>
        </div>

        <!-- TAB 3: KELOLA KATEGORI -->
        <div id="content-kategori" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-900 flex items-center">
                        <i class="fa-solid fa-folder-tree mr-2 text-indigo-600"></i> Daftar Kategori Knowledge Base
                    </h3>
                    <button onclick="openModalKategori()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
                        + Kategori Baru
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 border-b">
                            <tr>
                                <th class="px-5 py-4">ID</th>
                                <th class="px-5 py-4">Nama Kategori</th>
                                <th class="px-5 py-4">Deskripsi</th>
                                <th class="px-5 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($kategoris as $kat)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4 text-gray-500">#{{ $kat->id }}</td>
                                    <td class="px-5 py-4 font-bold text-gray-900">{{ $kat->nama }}</td>
                                    <td class="px-5 py-4 text-gray-600 text-xs">{{ $kat->deskripsi }}</td>
                                    <td class="px-5 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <button onclick="openModalEditKategori({{ json_encode($kat) }})" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 p-2 rounded-lg text-xs" title="Edit Kategori">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            <form action="{{ route('superadmin.kategori.destroy', $kat->id) }}" method="POST" onsubmit="return confirm('Yakin menghapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 p-2 rounded-lg text-xs" title="Hapus Kategori">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 4: SARAN MAHASISWA -->
        <div id="content-saran" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-900 flex items-center">
                        <i class="fa-solid fa-comments mr-2 text-green-600"></i> Umpan Balik / Saran Pertanyaan Mahasiswa
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 border-b">
                            <tr>
                                <th class="px-5 py-4">NRP Mahasiswa</th>
                                <th class="px-5 py-4">Isi Pertanyaan/Saran</th>
                                <th class="px-5 py-4 text-center">Status</th>
                                <th class="px-5 py-4 text-center">Ditangani Oleh</th>
                                <th class="px-5 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($saranPertanyaans as $saran)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4 font-semibold text-blue-700">{{ $saran->mahasiswa->nrp ?? 'Mahasiswa' }}</td>
                                    <td class="px-5 py-4 text-gray-800 leading-relaxed max-w-md">{{ $saran->pertanyaan }}</td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                            {{ ucfirst($saran->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center text-xs text-gray-500">
                                        {{ $saran->petugas->name ?? 'Belum Ditugaskan' }}
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <button onclick="openModalSaran({{ json_encode($saran) }})" class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            Kelola Status
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-gray-400">Belum ada saran dari mahasiswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <!-- MODAL USER -->
    <div id="modalUser" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl max-w-md w-full shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="p-5 border-b flex justify-between items-center bg-gray-50 flex-shrink-0">
                <h3 id="modalUserTitle" class="font-bold text-gray-900">Tambah User Staff</h3>
                <button onclick="closeModal('modalUser')" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <form id="formUser" action="{{ route('superadmin.users.store') }}" method="POST" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <input type="hidden" name="_method" id="methodUser" value="POST">

                <div class="p-5 space-y-4 overflow-y-auto flex-1">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="userName" required class="w-full border rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="userEmail" required class="w-full border rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role Staff</label>
                        <select name="role_id" id="userRoleId" required class="w-full border rounded-lg px-3 py-2 text-sm">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password <span id="pwdHint" class="text-xs text-gray-400 font-normal"></span></label>
                        <input type="password" name="password" id="userPassword" class="w-full border rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="p-4 bg-gray-50 border-t flex justify-end gap-2 flex-shrink-0">
                    <button type="button" onclick="closeModal('modalUser')" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">Simpan User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL KATEGORI -->
    <div id="modalKategori" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl max-w-md w-full shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="p-5 border-b flex justify-between items-center bg-gray-50 flex-shrink-0">
                <h3 id="modalKategoriTitle" class="font-bold text-gray-900">Tambah Kategori</h3>
                <button onclick="closeModal('modalKategori')" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <form id="formKategori" action="{{ route('superadmin.kategori.store') }}" method="POST" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <input type="hidden" name="_method" id="methodKategori" value="POST">

                <div class="p-5 space-y-4 overflow-y-auto flex-1">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                        <input type="text" name="nama" id="kategoriNama" required class="w-full border rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" id="kategoriDeskripsi" rows="3" class="w-full border rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 border-t flex justify-end gap-2 flex-shrink-0">
                    <button type="button" onclick="closeModal('modalKategori')" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT FAQ (DENGAN VERTICAL SCROLLBAR DAN FOOTER TETAP) -->
    <div id="modalFaq" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl max-w-lg w-full shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <!-- Header (Fixed) -->
            <div class="p-5 border-b flex justify-between items-center bg-gray-50 flex-shrink-0">
                <h3 class="font-bold text-gray-900">Edit Pertanyaan FAQ</h3>
                <button type="button" onclick="closeModal('modalFaq')" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <!-- Form Wrapper -->
            <form id="formFaq" method="POST" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                @method('PUT')

                <!-- Scrollable Body -->
                <div class="p-5 space-y-4 overflow-y-auto flex-1">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="kategori_id" id="faqKategoriId" required class="w-full border rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Publikasi</label>
                        <select name="status" id="faqStatus" onchange="toggleCatatanReview(this.value)" required class="w-full border rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="pending">Pending</option>
                            <option value="published">Published</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    <!-- CONTAINER CATATAN PENOLAKAN -->
                    <div id="faqCatatanInputContainer" class="hidden">
                        <label class="block text-sm font-medium text-red-700 mb-1">
                            Catatan Review / Alasan Penolakan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="catatan_review" id="faqCatatanReview" rows="2" placeholder="Masukkan alasan kenapa pertanyaan/jawaban ini ditolak..." class="w-full border border-red-300 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-red-500 bg-red-50/30"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan</label>
                        <textarea name="pertanyaan" id="faqPertanyaan" rows="2" required class="w-full border rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jawaban</label>
                        <textarea name="jawaban" id="faqJawaban" rows="3" required class="w-full border rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>

                <!-- Footer (Fixed at bottom) -->
                <div class="p-4 bg-gray-50 border-t flex justify-end gap-2 flex-shrink-0">
                    <button type="button" onclick="closeModal('modalFaq')" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">Update FAQ</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL DETAIL & AUDIT FAQ -->
    <div id="modalDetailFaq" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl max-w-lg w-full shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="p-5 border-b flex justify-between items-center bg-gray-50 flex-shrink-0">
                <h3 class="font-bold text-gray-900">Detail FAQ & Audit Trail</h3>
                <button type="button" onclick="closeModal('modalDetailFaq')" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <div class="p-5 space-y-4 text-sm overflow-y-auto flex-1">
                <div>
                    <p class="text-xs text-gray-400 uppercase font-semibold">Kategori</p>
                    <p id="detailFaqKategori" class="font-semibold text-gray-800"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase font-semibold">Pertanyaan</p>
                    <p id="detailFaqPertanyaan" class="font-bold text-gray-900 text-base mt-1"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase font-semibold">Jawaban</p>
                    <p id="detailFaqJawaban" class="bg-gray-50 border p-3 rounded-lg text-gray-700 mt-1 leading-relaxed whitespace-pre-line"></p>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-2 border-t">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">Dibuat Oleh (Data Entry)</p>
                        <p id="detailFaqCreator" class="font-semibold text-blue-700 mt-1"></p>
                        <p id="detailFaqCreatedAt" class="text-xs text-gray-500"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">Divalidasi Oleh (Validator)</p>
                        <p id="detailFaqReviewer" class="font-semibold text-green-700 mt-1"></p>
                        <p id="detailFaqReviewedAt" class="text-xs text-gray-500"></p>
                    </div>
                </div>
                <div id="detailCatatanContainer" class="pt-2 border-t hidden">
                    <p class="text-xs text-gray-400 uppercase font-semibold">Catatan Review / Penolakan</p>
                    <div id="detailFaqCatatan" class="bg-red-50 text-red-700 border border-red-200 p-3 rounded-lg text-xs mt-1"></div>
                </div>
            </div>
            <div class="p-4 bg-gray-50 border-t flex justify-end flex-shrink-0">
                <button type="button" onclick="closeModal('modalDetailFaq')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg">Tutup</button>
            </div>
        </div>
    </div>

    <!-- MODAL SARAN MAHASISWA -->
    <div id="modalSaran" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl max-w-md w-full shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="p-5 border-b flex justify-between items-center bg-gray-50 flex-shrink-0">
                <h3 class="font-bold text-gray-900">Kelola Saran Pertanyaan</h3>
                <button type="button" onclick="closeModal('modalSaran')" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <form id="formSaran" method="POST" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                @method('PUT')

                <div class="p-5 space-y-4 overflow-y-auto flex-1">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Saran</label>
                        <select name="status" id="saranStatus" required class="w-full border rounded-lg px-3 py-2 text-sm">
                            <option value="baru">Baru</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tugaskan Kepada Staf</label>
                        <select name="ditangani_oleh" id="saranStaff" class="w-full border rounded-lg px-3 py-2 text-sm">
                            <option value="">-- Belum Ditugaskan --</option>
                            @foreach($staffUsers as $staf)
                                <option value="{{ $staf->id }}">{{ $staf->name }} ({{ $staf->role->nama ?? 'Staff' }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 border-t flex justify-end gap-2 flex-shrink-0">
                    <button type="button" onclick="closeModal('modalSaran')" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">Update Saran</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT HANDLERS -->
    <script>
        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(el => {
                el.classList.add('hidden');
                el.classList.remove('block');
            });
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white', 'shadow-sm');
                btn.classList.add('text-gray-600', 'hover:bg-gray-100');
            });
            document.getElementById('content-' + tabName).classList.remove('hidden');
            document.getElementById('content-' + tabName).classList.add('block');
            const activeBtn = document.getElementById('tab-' + tabName);
            activeBtn.classList.add('bg-blue-600', 'text-white', 'shadow-sm');
            activeBtn.classList.remove('text-gray-600', 'hover:bg-gray-100');
        }

        function openModal(id) {
            const m = document.getElementById(id);
            m.classList.remove('hidden');
            m.classList.add('flex');
        }
        function closeModal(id) {
            const m = document.getElementById(id);
            m.classList.add('hidden');
            m.classList.remove('flex');
        }

        function openModalUser() {
            document.getElementById('modalUserTitle').innerText = 'Tambah User Staff Baru';
            document.getElementById('formUser').action = "{{ route('superadmin.users.store') }}";
            document.getElementById('methodUser').value = 'POST';
            document.getElementById('userName').value = '';
            document.getElementById('userEmail').value = '';
            document.getElementById('userPassword').value = '';
            document.getElementById('userPassword').required = true;
            document.getElementById('pwdHint').innerText = '';
            openModal('modalUser');
        }

        function openModalEditUser(user) {
            document.getElementById('modalUserTitle').innerText = 'Edit User Staff';
            document.getElementById('formUser').action = `/superadmin/users/${user.id}`;
            document.getElementById('methodUser').value = 'PUT';
            document.getElementById('userName').value = user.name;
            document.getElementById('userEmail').value = user.email;
            document.getElementById('userRoleId').value = user.role_id;
            document.getElementById('userPassword').value = '';
            document.getElementById('userPassword').required = false;
            document.getElementById('pwdHint').innerText = '(Kosongkan jika tidak diubah)';
            openModal('modalUser');
        }

        function openModalKategori() {
            document.getElementById('modalKategoriTitle').innerText = 'Tambah Kategori Baru';
            document.getElementById('formKategori').action = "{{ route('superadmin.kategori.store') }}";
            document.getElementById('methodKategori').value = 'POST';
            document.getElementById('kategoriNama').value = '';
            document.getElementById('kategoriDeskripsi').value = '';
            openModal('modalKategori');
        }

        function openModalEditKategori(kat) {
            document.getElementById('modalKategoriTitle').innerText = 'Edit Kategori';
            document.getElementById('formKategori').action = `/superadmin/kategori/${kat.id}`;
            document.getElementById('methodKategori').value = 'PUT';
            document.getElementById('kategoriNama').value = kat.nama;
            document.getElementById('kategoriDeskripsi').value = kat.deskripsi || '';
            openModal('modalKategori');
        }

        function toggleCatatanReview(status) {
            const container = document.getElementById('faqCatatanInputContainer');
            const textarea = document.getElementById('faqCatatanReview');

            if (status === 'rejected') {
                container.classList.remove('hidden');
                textarea.required = true;
            } else {
                container.classList.add('hidden');
                textarea.required = false;
            }
        }

        function openModalEditFaq(item) {
            document.getElementById('formFaq').action = `/superadmin/pertanyaan/${item.id}`;
            document.getElementById('faqKategoriId').value = item.kategori_id;
            document.getElementById('faqStatus').value = item.status;
            document.getElementById('faqPertanyaan').value = item.pertanyaan;
            document.getElementById('faqJawaban').value = item.jawaban;
            document.getElementById('faqCatatanReview').value = item.catatan_review || '';

            toggleCatatanReview(item.status);
            openModal('modalFaq');
        }

        function openModalDetailFaq(item) {
            document.getElementById('detailFaqKategori').innerText = item.kategori ? item.kategori.nama : '-';
            document.getElementById('detailFaqPertanyaan').innerText = item.pertanyaan;
            document.getElementById('detailFaqJawaban').innerText = item.jawaban;
            document.getElementById('detailFaqCreator').innerText = item.creator ? item.creator.name : 'Tidak diketahui';
            document.getElementById('detailFaqCreatedAt').innerText = item.created_at ? new Date(item.created_at).toLocaleString('id-ID') : '-';

            document.getElementById('detailFaqReviewer').innerText = item.reviewer ? item.reviewer.name : 'Belum Diverifikasi';
            document.getElementById('detailFaqReviewedAt').innerText = item.reviewed_at ? new Date(item.reviewed_at).toLocaleString('id-ID') : '-';

            const catatanContainer = document.getElementById('detailCatatanContainer');
            if (item.catatan_review) {
                document.getElementById('detailFaqCatatan').innerText = item.catatan_review;
                catatanContainer.classList.remove('hidden');
            } else {
                catatanContainer.classList.add('hidden');
            }

            openModal('modalDetailFaq');
        }

        function openModalSaran(saran) {
            document.getElementById('formSaran').action = `/superadmin/saran/${saran.id}`;
            document.getElementById('saranStatus').value = saran.status;
            document.getElementById('saranStaff').value = saran.ditangani_oleh || '';
            openModal('modalSaran');
        }
    </script>
</body>
</html>