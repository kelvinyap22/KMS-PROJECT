
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Data Entry | KMS</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-100 text-gray-800">

<div class="min-h-screen">

    <!-- HEADER -->
    <header class="bg-white border-b shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <div>
                <h1 class="text-2xl font-bold text-blue-700">
                    <i class="fa-solid fa-book-open mr-2"></i>
                    Knowledge Management System
                </h1>

                <p class="text-sm text-gray-500">
                    Dashboard Data Entry
                </p>
            </div>

            <div class="flex items-center gap-4">

                <div class="text-right">
                    <p class="font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">Data Entry</p>
                </div>

                <form action="{{ route('staff.logout') }}" method="POST">
                    @csrf

                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i>
                        Logout
                    </button>
                </form>

            </div>

        </div>
    </header>

    <!-- CONTENT -->
    <main class="max-w-7xl mx-auto px-6 py-8">

        <!-- ALERT -->
        @if(session('success'))
            <div class="mb-5 p-4 bg-green-100 text-green-700 rounded-lg">
                <i class="fa-solid fa-circle-check mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-5 p-4 bg-red-100 text-red-700 rounded-lg">
                <i class="fa-solid fa-circle-exclamation mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- TITLE -->
        <div class="flex justify-between items-center mb-6">

            <div>
                <h2 class="text-2xl font-bold">
                    Dashboard Data Entry
                </h2>

                <p class="text-gray-500">
                    Kelola dan kirim pertanyaan ke Validator.
                </p>
            </div>

            <button onclick="openTambahModal()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow">
                <i class="fa-solid fa-plus mr-2"></i>
                Tambah Pertanyaan
            </button>

        </div>

        <!-- STATISTIK -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">

            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-blue-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm">Total Pertanyaan</p>
                        <h3 class="text-3xl font-bold mt-2">
                            {{ $totalPertanyaan }}
                        </h3>
                    </div>
                    <i class="fa-solid fa-database text-3xl text-blue-500"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-yellow-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm">Pending</p>
                        <h3 class="text-3xl font-bold mt-2">
                            {{ $totalPending }}
                        </h3>
                    </div>
                    <i class="fa-solid fa-clock text-3xl text-yellow-500"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-green-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm">Published</p>
                        <h3 class="text-3xl font-bold mt-2">
                            {{ $totalPublished }}
                        </h3>
                    </div>
                    <i class="fa-solid fa-circle-check text-3xl text-green-500"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-gray-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm">Draft</p>
                        <h3 class="text-3xl font-bold mt-2">
                            {{ $totalDraft }}
                        </h3>
                    </div>
                    <i class="fa-solid fa-file-pen text-3xl text-gray-500"></i>
                </div>
            </div>

        </div>

        <!-- SARAN PERTANYAAN MAHASISWA -->
        <!-- FILTER -->
        <div class="bg-white p-5 rounded-xl shadow-sm mb-6">

            <form action="{{ route('dataentry.index') }}"
                method="GET"
                class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Cari Pertanyaan
                    </label>

                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Masukkan pertanyaan..."
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Kategori
                    </label>

                    <select name="kategori"
                        class="w-full border rounded-lg px-4 py-2">

                        <option value="">Semua Kategori</option>

                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Status
                    </label>

                    <select name="status"
                        class="w-full border rounded-lg px-4 py-2">

                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>

                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex-1">
                        <i class="fa-solid fa-filter mr-1"></i>
                        Filter
                    </button>

                    <a href="{{ route('dataentry.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">
                        Reset
                    </a>
                </div>

            </form>

        </div>


        <!-- TAB DAN KONTEN TABEL -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">

            <!-- TOMBOL TAB -->
            <div class="border-b">
                <div class="flex items-center gap-6 px-5 pt-4">

                    <button type="button"
                        id="tabPertanyaan"
                        onclick="gantiTab('pertanyaan')"
                        class="border-b-2 border-blue-600 text-blue-600 pb-4 font-semibold">

                        <i class="fa-solid fa-list mr-2"></i>
                        Daftar Pertanyaan

                    </button>

                    <button type="button"
                        id="tabSaran"
                        onclick="gantiTab('saran')"
                        class="border-b-2 border-transparent text-gray-500 pb-4 font-semibold">

                        <i class="fa-solid fa-lightbulb mr-2"></i>
                        Saran Mahasiswa

                        <span class="ml-1 bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">
                            {{ $saranPertanyaans->where('status', 'baru')->count() }}
                        </span>

                    </button>

                </div>
            </div>


            <!-- ===================================== -->
            <!-- KONTEN TAB 1: DAFTAR PERTANYAAN -->
            <!-- ===================================== -->

            <div id="kontenPertanyaan">

                <div class="p-5 border-b flex justify-between items-center">

                    <h3 class="font-bold text-lg">
                        <i class="fa-solid fa-list mr-2 text-blue-600"></i>
                        Daftar Pertanyaan
                    </h3>

                    <span class="text-sm text-gray-500">
                        {{ $pertanyaans->total() }} data
                    </span>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-5 py-4 text-left">No</th>
                                <th class="px-5 py-4 text-left">Kategori</th>
                                <th class="px-5 py-4 text-left">Pertanyaan</th>
                                <th class="px-5 py-4 text-center">Status</th>
                                <th class="px-5 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">

                            @forelse($pertanyaans as $index => $item)

                                <tr class="hover:bg-gray-50">

                                    <td class="px-5 py-4">
                                        {{ $pertanyaans->firstItem() + $index }}
                                    </td>

                                    <td class="px-5 py-4">
                                        {{ $item->kategori->nama ?? '-' }}
                                    </td>

                                    <td class="px-5 py-4 max-w-md">
                                        <p class="font-medium">
                                            {{ $item->pertanyaan }}
                                        </p>

                                        <p class="text-gray-400 text-xs mt-1">
                                            ID: {{ $item->id }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-4 text-center">

                                        @php
                                            $statusClass = match($item->status) {
                                                'draft' => 'bg-gray-100 text-gray-600',
                                                'pending' => 'bg-yellow-100 text-yellow-700',
                                                'approved' => 'bg-green-100 text-green-700',
                                                'published' => 'bg-green-100 text-green-700',
                                                'rejected' => 'bg-red-100 text-red-700',
                                                default => 'bg-gray-100 text-gray-600'
                                            };
                                        @endphp

                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                            {{ ucfirst($item->status) }}
                                        </span>

                                    </td>

                                    <td class="px-5 py-4">

                                        <div class="flex justify-center items-center gap-2">

                                            <!-- DETAIL -->
                                            <button
                                                type="button"
                                                onclick="lihatPertanyaan({{ json_encode($item) }})"
                                                class="bg-blue-100 text-blue-600 hover:bg-blue-200 px-3 py-2 rounded"
                                                title="Detail">

                                                <i class="fa-solid fa-eye"></i>

                                            </button>

                                            <!-- EDIT -->
                                            @if(in_array($item->status, ['draft', 'rejected']))

                                                <button
                                                    type="button"
                                                    onclick="editPertanyaan({{ json_encode($item) }})"
                                                    class="bg-yellow-100 text-yellow-600 hover:bg-yellow-200 px-3 py-2 rounded"
                                                    title="Edit">

                                                    <i class="fa-solid fa-pen"></i>

                                                </button>

                                            @endif

                                            <!-- KIRIM KE VALIDATOR -->
                                            @if(in_array($item->status, ['draft', 'rejected']))

                                                <form action="{{ route('dataentry.kirim', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Kirim pertanyaan ke Validator?')">

                                                    @csrf

                                                    <button type="submit"
                                                        class="bg-green-100 text-green-600 hover:bg-green-200 px-3 py-2 rounded"
                                                        title="Kirim ke Validator">

                                                        <i class="fa-solid fa-paper-plane"></i>

                                                    </button>

                                                </form>

                                            @endif

                                            <!-- HAPUS -->
                                            @if(!in_array($item->status, ['pending', 'published']))

                                                <form action="{{ route('dataentry.destroy', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus pertanyaan ini?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="bg-red-100 text-red-600 hover:bg-red-200 px-3 py-2 rounded"
                                                        title="Hapus">

                                                        <i class="fa-solid fa-trash"></i>

                                                    </button>

                                                </form>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center py-12 text-gray-400">
                                        <i class="fa-solid fa-folder-open text-4xl mb-3"></i>
                                        <p>Belum ada pertanyaan.</p>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <!-- PAGINATION -->
                <div class="p-5 border-t">
                    {{ $pertanyaans->links() }}
                </div>

            </div>


            <!-- ===================================== -->
            <!-- KONTEN TAB 2: SARAN MAHASISWA -->
            <!-- ===================================== -->

            <div id="kontenSaran" class="hidden">

                <div class="p-5 border-b flex justify-between items-center">

                    <div>
                        <h3 class="font-bold text-lg">
                            <i class="fa-solid fa-lightbulb mr-2 text-yellow-500"></i>
                            Saran Pertanyaan Mahasiswa
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Daftar pertanyaan yang disarankan oleh mahasiswa.
                        </p>
                    </div>

                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">
                        {{ $saranPertanyaans->where('status', 'baru')->count() }} Saran Baru
                    </span>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-5 py-4 text-left">No</th>
                                <th class="px-5 py-4 text-left">NRP</th>
                                <th class="px-5 py-4 text-left">Pertanyaan Mahasiswa</th>
                                <th class="px-5 py-4 text-left">Tanggal</th>
                                <th class="px-5 py-4 text-center">Status</th>
                                <th class="px-5 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">

                            @forelse($saranPertanyaans as $index => $saran)

                                <tr class="hover:bg-gray-50">

                                    <td class="px-5 py-4">
                                        {{ $index + 1 }}
                                    </td>

                                    <!-- NRP MAHASISWA -->
                                    <td class="px-5 py-4">
                                        <span class="font-medium text-gray-700">
                                            {{ $saran->mahasiswa->nrp ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 max-w-md">
                                        <p class="font-medium">
                                            {{ $saran->pertanyaan }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-4">
                                        {{ $saran->created_at?->format('d/m/Y H:i') ?? '-' }}
                                    </td>

                                    <td class="px-5 py-4 text-center">

                                        @php
                                            $saranStatusClass = match($saran->status) {
                                                'baru' => 'bg-yellow-100 text-yellow-700',
                                                'diproses' => 'bg-blue-100 text-blue-700',
                                                'selesai' => 'bg-green-100 text-green-700',
                                                'ditolak' => 'bg-red-100 text-red-700',
                                                default => 'bg-gray-100 text-gray-600'
                                            };
                                        @endphp

                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $saranStatusClass }}">
                                            {{ ucfirst($saran->status) }}
                                        </span>

                                    </td>

                                    <td class="px-5 py-4">

                                        <div class="flex justify-center gap-2">

                                            @if($saran->status == 'baru')

                                                <!-- BUAT FAQ DARI SARAN -->
                                                <button
                                                    type="button"
                                                    onclick="gunakanSaran({{ json_encode($saran->pertanyaan) }}, {{ $saran->id }})"
                                                    class="bg-blue-100 text-blue-600 hover:bg-blue-200 px-3 py-2 rounded"
                                                    title="Buat FAQ dari saran">

                                                    <i class="fa-solid fa-plus"></i>

                                                </button>

                                                <!-- TOLAK SARAN -->
                                                <form action="{{ route('dataentry.saran.update-status', $saran->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Tolak saran pertanyaan ini?')">

                                                    @csrf
                                                    @method('PUT')

                                                    <input type="hidden" name="status" value="ditolak">

                                                    <button type="submit"
                                                        class="bg-red-100 text-red-600 hover:bg-red-200 px-3 py-2 rounded"
                                                        title="Tolak saran">

                                                        <i class="fa-solid fa-xmark"></i>

                                                    </button>

                                                </form>

                                            @elseif($saran->status == 'diproses')

                                                <!-- TANDAI SELESAI -->
                                                <form action="{{ route('dataentry.saran.update-status', $saran->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Tandai saran ini sudah selesai ditindaklanjuti?')">

                                                    @csrf
                                                    @method('PUT')

                                                    <input type="hidden" name="status" value="selesai">

                                                    <button type="submit"
                                                        class="bg-green-100 text-green-600 hover:bg-green-200 px-3 py-2 rounded"
                                                        title="Tandai selesai">

                                                        <i class="fa-solid fa-check"></i>

                                                    </button>

                                                </form>

                                            @else

                                                <span class="text-gray-400 text-xs">
                                                    Tidak ada aksi
                                                </span>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center py-12 text-gray-400">

                                        <i class="fa-solid fa-inbox text-4xl mb-3"></i>

                                        <p>Belum ada saran pertanyaan dari mahasiswa.</p>

                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

<!-- MODAL TAMBAH / EDIT -->
<div id="modalPertanyaan"
    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 overflow-y-auto p-4">

    <div class="bg-white rounded-xl w-full max-w-xl shadow-xl my-auto max-h-[90vh] overflow-y-auto">

        <div class="flex justify-between items-center p-5 border-b">

            <h3 id="modalTitle" class="font-bold text-xl">
                Tambah Pertanyaan
            </h3>

            <button onclick="closeModal()"
                class="text-gray-400 hover:text-gray-700 text-xl">
                <i class="fa-solid fa-xmark"></i>
            </button>

        </div>

        <form id="formPertanyaan"
            action="{{ route('dataentry.store') }}"
            method="POST">

            @csrf
            <input type="hidden" name="saran_id" id="saranIdInput">
            <input type="hidden" name="_method" id="methodInput" value="POST">

            <div class="p-5 space-y-4">


<!-- PERINGATAN PERTANYAAN MIRIP -->
@if(session('similar_questions'))

    <div id="similarQuestionsWarning"
        class="bg-yellow-50 border border-yellow-300 rounded-xl p-4">

        <div class="flex items-center gap-2 text-yellow-800 font-bold mb-2">

            <i class="fa-solid fa-triangle-exclamation"></i>

            Pertanyaan Serupa Ditemukan!

        </div>

        <p class="text-sm text-yellow-800 mb-3">
            Sistem menemukan pertanyaan yang mirip dengan data yang sudah ada.
            Silakan periksa sebelum melanjutkan.
        </p>

        <div class="space-y-3">

            @foreach(session('similar_questions') as $similar)

                <div class="bg-white border border-yellow-200 rounded-lg p-3">

                    <p class="font-semibold text-sm text-gray-800">
                        {{ $similar['pertanyaan'] }}
                    </p>

                    <div class="flex flex-wrap items-center gap-2 mt-2">

                        <span class="text-xs text-gray-500">
                            ID: {{ $similar['id'] }}
                        </span>

                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">
                            {{ $similar['similarity'] }}% Mirip
                        </span>

                        <span class="text-xs text-gray-500">
                            Status: {{ ucfirst($similar['status']) }}
                        </span>

                    </div>

                </div>

            @endforeach

        </div>

        <p class="text-xs text-yellow-800 mt-3">
            Jika pertanyaan baru memang berbeda, kamu tetap dapat menyimpannya.
        </p>

    </div>

@endif


                <div>
    <label class="block font-medium mb-2">
        Kategori
    </label>

    <select name="kategori_id"
        id="kategoriInput"
        required
        @if(session('similar_questions')) disabled @endif
        class="w-full border rounded-lg px-4 py-2
        @if(session('similar_questions'))
            bg-gray-100 cursor-not-allowed
        @endif">

        <option value="">Pilih Kategori</option>

        @foreach($kategoris as $kategori)
            <option value="{{ $kategori->id }}"
                {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama }}
            </option>
        @endforeach

    </select>

    {{-- Agar kategori tetap terkirim meskipun select disabled --}}
    @if(session('similar_questions'))
        <input type="hidden" name="kategori_id"
            value="{{ old('kategori_id') }}">
    @endif
</div>

                <div>
                    <label class="block font-medium mb-2">
                        Pertanyaan
                    </label>

                    <textarea name="pertanyaan"
                        id="pertanyaanInput"
                        rows="3"
                        required
                        @if(session('similar_questions')) readonly @endif
                        class="w-full border rounded-lg px-4 py-2
                        @if(session('similar_questions')) bg-gray-100 cursor-not-allowed @endif"
                        placeholder="Masukkan pertanyaan"></textarea>
                </div>

                <div>
                    <label class="block font-medium mb-2">
                        Jawaban
                    </label>

                    <textarea name="jawaban"
                        id="jawabanInput"
                        rows="4"
                        required
                        @if(session('similar_questions')) readonly @endif
                        class="w-full border rounded-lg px-4 py-2
                        @if(session('similar_questions')) bg-gray-100 cursor-not-allowed @endif"
                        placeholder="Masukkan jawaban"></textarea>
                </div>

            </div>

            <div class="p-5 border-t flex justify-end gap-3">

    <button type="button"
        onclick="closeModal()"
        class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">
        Batal
    </button>

    <input type="hidden"
        name="force_save"
        id="forceSaveInput"
        value="0">

    <button type="submit"
        id="btnTetapSimpan"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">

        <i class="fa-solid fa-save mr-1"></i>

        <span id="teksTombolSimpan">
            @if(session('similar_questions'))
                Tetap Simpan
            @else
                Simpan
            @endif
        </span>

    </button>

</div>

        </form>

    </div>

</div>

<!-- MODAL DETAIL -->
<div id="modalDetail"
    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-xl w-full max-w-xl mx-4 shadow-xl">

        <div class="flex justify-between items-center p-5 border-b">
            <h3 class="font-bold text-xl">Detail Pertanyaan</h3>

            <button onclick="closeDetail()"
                class="text-gray-400 hover:text-gray-700 text-xl">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="p-5 space-y-4">

            <div>
                <p class="text-gray-500 text-sm">Kategori</p>
                <p id="detailKategori" class="font-semibold"></p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Pertanyaan</p>
                <p id="detailPertanyaan" class="font-semibold"></p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Jawaban</p>
                <p id="detailJawaban" class="whitespace-pre-line"></p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Status</p>
                <p id="detailStatus" class="font-semibold"></p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Catatan Validator</p>
                <p id="detailCatatan" class="whitespace-pre-line"></p>
            </div>

        </div>

        <div class="p-5 border-t flex justify-end">
            <button onclick="closeDetail()"
                class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">
                Tutup
            </button>
        </div>

    </div>

</div>

<script>
    // ================= PINDAH TAB =================


function gantiTab(tab) {

    const kontenPertanyaan = document.getElementById('kontenPertanyaan');
    const kontenSaran = document.getElementById('kontenSaran');

    const tabPertanyaan = document.getElementById('tabPertanyaan');
    const tabSaran = document.getElementById('tabSaran');

    // Simpan tab terakhir yang dipilih
    localStorage.setItem('tabDataEntry', tab);

    if (tab === 'pertanyaan') {

        // Tampilkan daftar pertanyaan
        kontenPertanyaan.classList.remove('hidden');
        kontenSaran.classList.add('hidden');

        // Aktifkan tab pertanyaan
        tabPertanyaan.classList.add('border-blue-600', 'text-blue-600');
        tabPertanyaan.classList.remove('border-transparent', 'text-gray-500');

        // Nonaktifkan tab saran
        tabSaran.classList.remove('border-blue-600', 'text-blue-600');
        tabSaran.classList.add('border-transparent', 'text-gray-500');

    } else {

        // Tampilkan saran mahasiswa
        kontenPertanyaan.classList.add('hidden');
        kontenSaran.classList.remove('hidden');

        // Aktifkan tab saran
        tabSaran.classList.add('border-blue-600', 'text-blue-600');
        tabSaran.classList.remove('border-transparent', 'text-gray-500');

        // Nonaktifkan tab pertanyaan
        tabPertanyaan.classList.remove('border-blue-600', 'text-blue-600');
        tabPertanyaan.classList.add('border-transparent', 'text-gray-500');

    }
}


// ================= MEMULIHKAN TAB TERAKHIR =================

document.addEventListener('DOMContentLoaded', function() {

    // Ambil tab terakhir yang tersimpan
    const tabTerakhir = localStorage.getItem('tabDataEntry');

    // Jika belum ada pilihan sebelumnya, tampilkan daftar pertanyaan
    gantiTab(tabTerakhir || 'pertanyaan');

});


// ================= MODAL TAMBAH =================
let adaPertanyaanMirip = @json(session()->has('similar_questions'));

function openTambahModal() {
    const form = document.getElementById('formPertanyaan');
    const modal = document.getElementById('modalPertanyaan');
    const warning = document.getElementById('similarQuestionsWarning');

    document.getElementById('modalTitle').innerText = 'Tambah Pertanyaan';
    form.action = "{{ route('dataentry.store') }}";
    document.getElementById('methodInput').value = 'POST';

    // Siapkan form baru dalam keadaan kosong dan aktif.
    form.reset();
    document.getElementById('kategoriInput').value = '';
    document.getElementById('pertanyaanInput').value = '';
    document.getElementById('jawabanInput').value = '';
    document.getElementById('saranIdInput').value = '';

    adaPertanyaanMirip = false;
    document.getElementById('forceSaveInput').value = '0';

    document.getElementById('kategoriInput').disabled = false;
    document.getElementById('pertanyaanInput').readOnly = false;
    document.getElementById('jawabanInput').readOnly = false;

    // Hapus juga tampilan terkunci dari CSS agar cursor kembali normal.
    document.getElementById('kategoriInput').classList.remove('bg-gray-100', 'cursor-not-allowed');
    document.getElementById('pertanyaanInput').classList.remove('bg-gray-100', 'cursor-not-allowed');
    document.getElementById('jawabanInput').classList.remove('bg-gray-100', 'cursor-not-allowed');

    document.getElementById('teksTombolSimpan').innerText = 'Simpan';

    if (warning) {
        warning.classList.add('hidden');
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

// ================= MODAL EDIT =================
function editPertanyaan(item) {
    const form = document.getElementById('formPertanyaan');
    const modal = document.getElementById('modalPertanyaan');
    const warning = document.getElementById('similarQuestionsWarning');

    form.reset();
    document.getElementById('modalTitle').innerText = 'Edit Pertanyaan';
    form.action = `/dataentry/update-pertanyaan/${item.id}`;
    document.getElementById('methodInput').value = 'PUT';

    // Pastikan semua field aktif saat mengedit.
    document.getElementById('kategoriInput').disabled = false;
    document.getElementById('pertanyaanInput').readOnly = false;
    document.getElementById('jawabanInput').readOnly = false;

    // Hapus juga tampilan terkunci dari CSS agar cursor kembali normal.
    document.getElementById('kategoriInput').classList.remove('bg-gray-100', 'cursor-not-allowed');
    document.getElementById('pertanyaanInput').classList.remove('bg-gray-100', 'cursor-not-allowed');
    document.getElementById('jawabanInput').classList.remove('bg-gray-100', 'cursor-not-allowed');

    document.getElementById('kategoriInput').value = item.kategori_id ?? '';
    document.getElementById('pertanyaanInput').value = item.pertanyaan ?? '';
    document.getElementById('jawabanInput').value = item.jawaban ?? '';
    document.getElementById('saranIdInput').value = '';
    document.getElementById('forceSaveInput').value = '0';
    document.getElementById('teksTombolSimpan').innerText = 'Simpan';

    adaPertanyaanMirip = false;

    if (warning) {
        warning.classList.add('hidden');
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

// ================= GUNAKAN SARAN MAHASISWA =================
function gunakanSaran(pertanyaan, saranId) {
    openTambahModal();

    document.getElementById('modalTitle').innerText =
        'Buat FAQ dari Saran Mahasiswa';

    document.getElementById('pertanyaanInput').value = pertanyaan;
    document.getElementById('saranIdInput').value = saranId;
}

// ================= TUTUP MODAL =================
function closeModal() {
    const modal = document.getElementById('modalPertanyaan');
    const form = document.getElementById('formPertanyaan');
    const warning = document.getElementById('similarQuestionsWarning');

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    // Reset seluruh kondisi agar modal berikutnya tidak mewarisi status kemiripan.
    form.reset();
    adaPertanyaanMirip = false;

    document.getElementById('forceSaveInput').value = '0';
    document.getElementById('kategoriInput').disabled = false;
    document.getElementById('pertanyaanInput').readOnly = false;
    document.getElementById('jawabanInput').readOnly = false;

    // Hapus juga tampilan terkunci dari CSS agar cursor kembali normal.
    document.getElementById('kategoriInput').classList.remove('bg-gray-100', 'cursor-not-allowed');
    document.getElementById('pertanyaanInput').classList.remove('bg-gray-100', 'cursor-not-allowed');
    document.getElementById('jawabanInput').classList.remove('bg-gray-100', 'cursor-not-allowed');
    document.getElementById('teksTombolSimpan').innerText = 'Simpan';
    document.getElementById('saranIdInput').value = '';

    if (warning) {
        warning.classList.add('hidden');
    }
}

// Saat form dikirim:
// - Pengiriman pertama selalu force_save=0 agar Controller memeriksa kemiripan.
// - Setelah peringatan muncul, tombol "Tetap Simpan" mengirim force_save=1.
document.getElementById('formPertanyaan').addEventListener('submit', function () {
    document.getElementById('forceSaveInput').value =
        adaPertanyaanMirip ? '1' : '0';
});

// ================= DETAIL =================

function lihatPertanyaan(item) {

    document.getElementById('detailKategori').innerText =
        item.kategori ? item.kategori.nama : '-';

    document.getElementById('detailPertanyaan').innerText =
        item.pertanyaan || '-';

    document.getElementById('detailJawaban').innerText =
        item.jawaban || '-';

    document.getElementById('detailStatus').innerText =
        item.status || '-';

    document.getElementById('detailCatatan').innerText =
        item.catatan_review || '-';

    const modal = document.getElementById('modalDetail');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDetail() {

    const modal = document.getElementById('modalDetail');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// ================= KLIK LUAR MODAL =================

document.getElementById('modalPertanyaan').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

document.getElementById('modalDetail').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDetail();
    }
});

// ========================================
// MEMBUKA KEMBALI MODAL JIKA ADA PERTANYAAN MIRIP
// ========================================
document.addEventListener('DOMContentLoaded', function () {
    const warning = document.getElementById('similarQuestionsWarning');

    if (!warning) {
        return;
    }

    // openTambahModal() mengosongkan form; setelah itu pulihkan data lama.
    openTambahModal();

    document.getElementById('kategoriInput').value =
        @json(old('kategori_id'));

    document.getElementById('pertanyaanInput').value =
        @json(old('pertanyaan'));

    document.getElementById('jawabanInput').value =
        @json(old('jawaban'));

    document.getElementById('saranIdInput').value =
        @json(old('saran_id'));

    // Aktifkan mode konfirmasi kemiripan.
    adaPertanyaanMirip = true;
    document.getElementById('forceSaveInput').value = '0';

    // Kunci ketiga field agar tidak berubah setelah sistem menemukan kemiripan.
    document.getElementById('kategoriInput').disabled = true;
    document.getElementById('pertanyaanInput').readOnly = true;
    document.getElementById('jawabanInput').readOnly = true;

    document.getElementById('teksTombolSimpan').innerText = 'Tetap Simpan';

    // Tampilkan kembali peringatan setelah openTambahModal() menyembunyikannya.
    warning.classList.remove('hidden');

    const modal = document.getElementById('modalPertanyaan');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
});

</script>   

</body>
</html>
