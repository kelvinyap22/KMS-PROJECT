
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Validator - KMS UBAYA</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen text-gray-800">

    <!-- HEADER -->
    <header class="bg-white border-b shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <div>
                <h1 class="font-bold text-xl text-gray-900">
                    KMS FAQ UBAYA
                </h1>
                <p class="text-xs text-gray-500">
                    Portal Staff - Validator
                </p>
            </div>

            <div class="flex items-center gap-4">

                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-gray-500">
                        Validator
                    </p>
                </div>

                <form action="{{ route('staff.logout') }}" method="POST">
                    @csrf

                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i>
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </header>


    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-6 py-8">

        <!-- TITLE -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                Validasi Pertanyaan dan Jawaban
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                Periksa pertanyaan dan jawaban yang telah dibuat oleh Data Entry
                sebelum dipublikasikan kepada mahasiswa.
            </p>
        </div>


        <!-- NOTIFIKASI -->
        @if(session('success'))
            <div class="mb-5 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                <i class="fa-solid fa-circle-check mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                <i class="fa-solid fa-circle-exclamation mr-2"></i>
                {{ session('error') }}
            </div>
        @endif


        <!-- VALIDATION ERRORS -->
        @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif


        <!-- JUMLAH PERTANYAAN -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 mb-6 shadow-sm">
            <div class="flex items-center gap-4">

                <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-clock text-xl"></i>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Menunggu Validasi
                    </p>

                    <h3 class="text-2xl font-bold text-gray-900">
                        {{ $pertanyaans->count() }}
                    </h3>
                </div>

            </div>
        </div>


        <!-- DAFTAR PERTANYAAN -->
        <div class="space-y-5">

            @forelse($pertanyaans as $pertanyaan)

                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

                    <!-- CARD HEADER -->
                    <div class="p-5 border-b border-gray-100 flex flex-wrap justify-between items-center gap-3">

                        <div class="flex items-center gap-3">

                            <span class="px-3 py-1.5 bg-red-50 text-red-600 border border-red-100 rounded-lg text-xs font-bold uppercase">
                                {{ $pertanyaan->kategori->nama ?? 'Umum' }}
                            </span>

                            <span class="px-3 py-1.5 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-lg text-xs font-semibold">
                                <i class="fa-solid fa-clock mr-1"></i>
                                Menunggu Validasi
                            </span>

                        </div>

                        <span class="text-xs text-gray-400">
                            Diajukan:
                            {{ $pertanyaan->created_at->format('d M Y, H:i') }}
                        </span>

                    </div>


                    <!-- CARD BODY -->
                    <div class="p-5 space-y-5">

                        <!-- PERTANYAAN -->
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wide">
                                Pertanyaan
                            </label>

                            <p class="mt-2 text-base font-semibold text-gray-900 leading-relaxed">
                                {{ $pertanyaan->pertanyaan }}
                            </p>
                        </div>


                        <!-- JAWABAN -->
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wide">
                                Jawaban
                            </label>

                            <div class="mt-2 bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                                {{ $pertanyaan->jawaban }}
                            </div>
                        </div>


                        <!-- PEMBUAT -->
                        <div class="text-xs text-gray-500">
                            <i class="fa-solid fa-user-pen mr-1"></i>
                            Dibuat oleh:
                            <strong>
                                {{ $pertanyaan->creator->name ?? 'Tidak diketahui' }}
                            </strong>
                        </div>


                        <!-- ACTION BUTTONS -->
                        <div class="pt-4 border-t border-gray-100 flex flex-wrap gap-3">

                            <!-- FORM SETUJU -->
                            <form
                                action="{{ route('validator.approve', $pertanyaan->id) }}"
                                method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menyetujui pertanyaan dan jawaban ini?')">

                                @csrf

                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition">

                                    <i class="fa-solid fa-check mr-1"></i>
                                    Setujui & Publikasikan

                                </button>

                            </form>


                            <!-- TOMBOL TOLAK -->
                            <button
                                type="button"
                                onclick="openRejectModal({{ $pertanyaan->id }})"
                                class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition">

                                <i class="fa-solid fa-xmark mr-1"></i>
                                Tolak Pertanyaan

                            </button>

                        </div>

                    </div>

                </div>

            @empty

                <div class="bg-white border border-gray-200 rounded-xl p-12 text-center">

                    <div class="w-16 h-16 bg-green-50 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-check-double text-2xl"></i>
                    </div>

                    <h3 class="font-bold text-gray-900 text-lg">
                        Tidak Ada Pertanyaan Menunggu
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        Semua pertanyaan yang diajukan Data Entry sudah diperiksa.
                    </p>

                </div>

            @endforelse

        </div>

    </main>


    <!-- MODAL PENOLAKAN -->
    <div id="reject-modal"
        class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">

        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl">

            <div class="flex justify-between items-center mb-4">

                <h3 class="font-bold text-lg text-gray-900">
                    Tolak Pertanyaan
                </h3>

                <button onclick="closeRejectModal()"
                    class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>

            </div>

            <p class="text-sm text-gray-500 mb-4">
                Berikan catatan atau alasan mengapa pertanyaan dan jawaban ini ditolak.
                Catatan ini akan dapat dilihat oleh Data Entry.
            </p>

            <form id="reject-form" method="POST">

                @csrf

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Alasan Penolakan
                </label>

                <textarea
                    name="catatan_review"
                    required
                    maxlength="1000"
                    rows="5"
                    placeholder="Contoh: Jawaban belum sesuai dengan prosedur akademik yang berlaku..."
                    class="w-full border border-gray-300 rounded-xl p-3 text-sm outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 resize-none"></textarea>

                <div class="flex justify-end gap-3 mt-5">

                    <button type="button"
                        onclick="closeRejectModal()"
                        class="px-4 py-2.5 rounded-lg border border-gray-300 text-gray-600 text-sm font-semibold hover:bg-gray-50">
                        Batal
                    </button>

                    <button type="submit"
                        class="px-4 py-2.5 rounded-lg bg-red-600 text-white text-sm font-semibold hover:bg-red-700">
                        Kirim Penolakan
                    </button>

                </div>

            </form>

        </div>

    </div>


    <!-- JAVASCRIPT -->
    <script>

        function openRejectModal(id) {

            const form = document.getElementById('reject-form');

            form.action = `/validator/pertanyaan/${id}/reject`;

            document.getElementById('reject-modal')
                .classList.remove('hidden');

        }

        function closeRejectModal() {

            document.getElementById('reject-modal')
                .classList.add('hidden');

        }

    </script>

</body>
</html>
