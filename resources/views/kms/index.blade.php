
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>KMS FAQ UBAYA</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ubaya: {
                            red: '#DC2626',
                            hover: '#B91C1C',
                            light: '#FEF2F2',
                            dark: '#991B1B'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
<style>
    /* Animasi dropdown FAQ */
    .faq-answer {
        display: grid;
        grid-template-rows: 0fr;
        opacity: 0;
        transition:
            grid-template-rows 350ms ease,
            opacity 300ms ease;
    }

    .faq-answer.open {
        grid-template-rows: 1fr;
        opacity: 1;
    }

    .faq-answer-inner {
        overflow: hidden;
        min-height: 0;
    }

    /* Animasi ikon chevron */
    .faq-chevron {
        transition: transform 350ms ease;
    }

    .faq-chevron.rotate {
        transform: rotate(180deg);
    }

    /* Animasi hover card */
    .faq-card {
        transition:
            border-color 250ms ease,
            box-shadow 250ms ease,
            transform 250ms ease;
    }

    .faq-card:hover {
        transform: translateY(-1px);
    }

    @media (prefers-reduced-motion: reduce) {
        .faq-answer,
        .faq-chevron,
        .faq-card {
            transition: none;
        }
    }
</style>

</head>

<body class="font-sans bg-gray-50 text-gray-800 antialiased min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-20 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3.5 flex items-center justify-between relative">

        <!-- Kiri: Kembali ke Input NRP -->
        <button onclick="window.location.href='{{ url('/login-mahasiswa') }}'"
            class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-ubaya-red transition py-1.5 px-3 rounded-lg hover:bg-gray-100">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Input NRP</span>
        </button>

        <!-- Tengah: Logo dan Judul -->
        <div class="absolute left-1/2 -translate-x-1/2 flex items-center gap-3">
            <img src="{{ asset('images/bg-logoubayakms.png') }}"
                alt="Logo UBAYA"
                class="h-10 w-auto object-contain">

            <span class="font-bold text-gray-900 text-base sm:text-lg whitespace-nowrap">
                KMS FAQ UBAYA
            </span>
        </div>

        <!-- Kanan: About Us -->
        <button onclick="openModal('about-modal')"
            class="text-sm font-semibold text-gray-700 hover:text-ubaya-red flex items-center gap-2 transition py-1.5 px-3 rounded-lg hover:bg-gray-100">
            <i class="fa-solid fa-circle-info text-ubaya-red"></i>
            <span class="hidden sm:inline">About Us</span>
        </button>

    </div>
</header>

    <!-- MAIN CONTENT -->
    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-8 w-full flex-1">

        <!-- TITLE -->
        <div class="text-center mb-8">

            <span class="inline-block px-3 py-1 bg-red-50 text-ubaya-red
                         text-xs font-semibold rounded-full mb-3 border border-red-100">
                Pusat Informasi & Layanan Mahasiswa
            </span>

            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">
                Apa yang ingin Anda tanyakan?
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Cari jawaban cepat seputar perkuliahan, KRS, keuangan, dan fasilitas kampus.
            </p>

        </div>


        <!-- SEARCH BAR -->
        <div class="max-w-2xl mx-auto mb-3">

            <div class="relative">

                <i class="fa-solid fa-magnifying-glass absolute left-4
                          top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>

                <input
                    type="text"
                    id="search-input"
                    oninput="handleSearch()"
                    placeholder="Cari pertanyaan... (contoh: Cara perwalian, bayar UKT, KRS)"
                    class="w-full pl-12 pr-10 py-4 bg-white border border-gray-300
                           rounded-2xl shadow-sm focus:ring-2 focus:ring-ubaya-red
                           focus:border-ubaya-red transition outline-none
                           text-gray-800 text-sm sm:text-base"
                >

                <button
                    id="clear-search"
                    onclick="clearSearch()"
                    class="hidden absolute right-4 top-1/2 -translate-y-1/2
                           text-gray-400 hover:text-gray-600">

                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>

            </div>


            <!-- SARAN PERTANYAAN -->
            <div class="mt-2.5 px-2 flex items-center justify-between
                        text-xs text-gray-500">

                <span>Belum menemukan pertanyaan yang dicari?</span>

                <button
                    onclick="openModal('suggest-modal')"
                    class="text-ubaya-red font-semibold hover:underline
                           flex items-center gap-1 transition">

                    <i class="fa-regular fa-paper-plane"></i>
                    <span>Ajukan Saran Pertanyaan Baru</span>
                </button>

            </div>

        </div>


        <!-- FILTER KATEGORI -->
        <div class="flex items-center justify-center gap-2 overflow-x-auto
                    py-4 mb-6 no-scrollbar">

            <button
                type="button"
                data-category="All"
                onclick="filterCategory('All')"
                class="cat-btn active bg-ubaya-red text-white px-4 py-2
                       rounded-xl text-xs font-semibold whitespace-nowrap
                       transition shadow-sm">

                Semua Pertanyaan
            </button>

            @foreach($kategoris as $kategori)

                <button
                    type="button"
                    data-category="{{ $kategori->nama }}"
                    onclick="filterCategory(@js($kategori->nama))"
                    class="cat-btn bg-white text-gray-600 border border-gray-200
                           hover:border-ubaya-red px-4 py-2 rounded-xl text-xs
                           font-semibold whitespace-nowrap transition">

                    {{ $kategori->nama }}

                </button>

            @endforeach

        </div>


        <!-- DAFTAR FAQ -->
        <div id="faq-list" class="space-y-3 max-w-3xl mx-auto">
            <!-- FAQ ditampilkan melalui JavaScript -->
        </div>


        <!-- EMPTY STATE -->
        <div id="empty-state"
             class="hidden text-center py-12 bg-white rounded-2xl
                    border border-gray-200 max-w-3xl mx-auto mt-4 p-6">

            <div class="w-16 h-16 bg-red-50 text-ubaya-red rounded-full
                        flex items-center justify-center mx-auto mb-3">

                <i class="fa-solid fa-circle-question text-2xl"></i>

            </div>

            <h3 class="text-base font-bold text-gray-800">
                Pertanyaan Tidak Ditemukan
            </h3>

            <p class="text-xs text-gray-500 mt-1 max-w-md mx-auto">
                Maaf, pertanyaan dengan kata kunci tersebut belum tersedia
                di basis pengetahuan kami.
            </p>

            <button
                onclick="openModal('suggest-modal')"
                class="mt-4 bg-ubaya-red text-white text-xs font-semibold
                       px-5 py-2.5 rounded-xl hover:bg-ubaya-hover
                       transition inline-flex items-center gap-2">

                <i class="fa-solid fa-plus"></i>
                <span>Kirimkan Pertanyaan Ini ke Sistem</span>

            </button>

        </div>

    </main>


    <!-- FOOTER -->
    <footer class="bg-white border-t border-gray-200 text-center
                   py-4 text-xs text-gray-500 mt-auto">

        &copy; {{ date('Y') }}
        Student Knowledge Management System — Universitas Surabaya

    </footer>


    <!-- MODAL ABOUT US -->
    <div id="about-modal"
         class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50
                flex items-center justify-center p-4">

        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl relative">

            <button onclick="closeModal('about-modal')"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">

                <i class="fa-solid fa-xmark text-lg"></i>

            </button>

            <div class="flex items-center gap-3 mb-4">

                <div class="w-10 h-10 bg-red-50 text-ubaya-red rounded-xl
                            flex items-center justify-center font-bold">

                    <i class="fa-solid fa-circle-info text-xl"></i>

                </div>

                <div>
                    <h3 class="font-bold text-gray-900 text-base">
                        Tentang KMS UBAYA
                    </h3>

                    <p class="text-xs text-gray-500">
                        Direktorat Administrasi Akademik
                    </p>
                </div>

            </div>

            <div class="text-xs text-gray-600 space-y-3 leading-relaxed">

                <p>
                    <strong>Student Knowledge Management System (KMS)</strong>
                    adalah platform pusat informasi terpadu yang dirancang
                    untuk membantu mahasiswa Universitas Surabaya menemukan
                    jawaban atas pertanyaan seputar akademik, administrasi,
                    keuangan, dan fasilitas kampus secara mandiri.
                </p>

                <p>
                    Jika pertanyaan Anda belum memiliki jawaban, Anda dapat
                    mengirimkan saran pertanyaan melalui fitur yang tersedia
                    agar dapat ditindaklanjuti oleh tim Data Entry DAA.
                </p>

            </div>

            <button onclick="closeModal('about-modal')"
                class="mt-6 w-full bg-gray-100 hover:bg-gray-200 text-gray-700
                       font-semibold py-2.5 rounded-xl text-xs transition">

                Tutup

            </button>

        </div>
    </div>


    <!-- MODAL SARAN PERTANYAAN -->
    <div id="suggest-modal"
         class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50
                flex items-center justify-center p-4">

        <div class="bg-white rounded-2xl max-w-md w-full p-6
                    shadow-xl relative">

            <button onclick="closeModal('suggest-modal')"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">

                <i class="fa-solid fa-xmark text-lg"></i>

            </button>

            <div class="flex items-center gap-3 mb-4">

                <div class="w-10 h-10 bg-red-50 text-ubaya-red rounded-xl
                            flex items-center justify-center font-bold">

                    <i class="fa-regular fa-paper-plane text-lg"></i>

                </div>

                <div>
                    <h3 class="font-bold text-gray-900 text-base">
                        Ajukan Saran Pertanyaan
                    </h3>

                    <p class="text-xs text-gray-500">
                        Pertanyaan akan ditindaklanjuti oleh Tim Data Entry
                    </p>
                </div>

            </div>


            <form id="suggestion-form"
                  onsubmit="handleSuggestionSubmit(event)"
                  class="space-y-3 text-xs">

                <!-- NRP DARI SESSION -->
                <div>

                    <label class="block font-semibold text-gray-700 mb-1">
                        NRP Mahasiswa
                    </label>

                    <input
                        type="text"
                        value="{{ session('nrp') }}"
                        readonly
                        class="w-full p-2.5 bg-gray-100 border border-gray-200
                               rounded-lg text-gray-600 font-medium"
                    >

                </div>


                <!-- PERTANYAAN -->
                <div>

                    <label for="suggest-question"
                           class="block font-semibold text-gray-700 mb-1">

                        Tulis Pertanyaan Anda

                    </label>

                    <textarea
                        id="suggest-question"
                        required
                        minlength="5"
                        maxlength="1000"
                        rows="4"
                        placeholder="Tuliskan pertanyaan secara jelas di sini..."
                        class="w-full p-3 bg-gray-50 border border-gray-300
                               rounded-xl outline-none focus:ring-2
                               focus:ring-ubaya-red"></textarea>

                </div>


                <button
                    type="submit"
                    id="suggest-submit-button"
                    class="w-full bg-ubaya-red hover:bg-ubaya-hover
                           text-white font-semibold py-3 rounded-xl
                           transition text-xs shadow-md">

                    Kirimkan Saran Pertanyaan

                </button>

            </form>

        </div>
    </div>


    <!-- TOAST NOTIFICATION -->
    <div id="toast"
         class="fixed bottom-5 right-5 hidden bg-gray-900 text-white
                px-5 py-3 rounded-xl shadow-2xl text-xs z-[60]
                items-center gap-2">

        <i class="fa-solid fa-circle-check text-green-400 text-base"></i>

        <span id="toast-message">Notifikasi</span>

    </div>


    <!-- JAVASCRIPT -->
    <script>

        // Data FAQ dari StudentFaqController
        const faqsData = @json($faqs ?? []);

        let activeCategory = 'All';


        // ==============================
        // ESCAPE HTML
        // ==============================
        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, function(char) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                }[char];
            });
        }


        // ==============================
        // RENDER FAQ
        // ==============================
        function renderFaqs() {

            const container = document.getElementById('faq-list');
            const emptyState = document.getElementById('empty-state');

            const searchKeyword = document
                .getElementById('search-input')
                .value
                .toLowerCase()
                .trim();

            const filtered = faqsData.filter(faq => {

                const category = String(faq.category ?? 'Umum').toLowerCase();

                const question = String(faq.question ?? '').toLowerCase();

                const answer = String(faq.answer ?? '').toLowerCase();

                const matchCategory =
                    activeCategory === 'All' ||
                    category === activeCategory.toLowerCase();

                const matchSearch =
                    question.includes(searchKeyword) ||
                    answer.includes(searchKeyword);

                return matchCategory && matchSearch;

            });


            // Jika FAQ tidak ditemukan
            if (filtered.length === 0) {

                container.innerHTML = '';

                emptyState.classList.remove('hidden');

                return;
            }


            emptyState.classList.add('hidden');


            // Tampilkan FAQ
            
container.innerHTML = filtered.map(faq => `
    <div class="faq-card bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:border-red-200">

        <button
            onclick="toggleAccordion(${faq.id})"
            aria-expanded="false"
            aria-controls="ans-${faq.id}"
            id="question-${faq.id}"
            class="w-full text-left p-4 sm:p-5 flex items-start justify-between gap-4 font-semibold text-gray-800 text-sm sm:text-base hover:bg-gray-50/80 transition">

            <div class="flex items-start gap-3">

                <span class="mt-0.5 inline-block px-2.5 py-2 text-[10px] uppercase font-bold tracking-wider rounded-md bg-red-50 text-ubaya-red border border-red-100">
                    ${faq.category}
                </span>

                <span class="leading-snug pt-1">
                    ${faq.question}
                </span>

            </div>

            <i id="icon-${faq.id}"
                class="faq-chevron fa-solid fa-chevron-down text-gray-400 text-xs mt-2">
            </i>

        </button>

        <!-- Jawaban FAQ -->
        <div
            id="ans-${faq.id}"
            class="faq-answer">

            <div class="faq-answer-inner">

                <div class="px-5 pb-5 pt-3 text-xs sm:text-sm text-gray-600 border-t border-gray-100 bg-gray-50/50 leading-relaxed">

                    <p class="mb-4">
                        ${faq.answer}
                    </p>

                </div>

            </div>

        </div>

    </div>
`).join('');


        }


        // ==============================
        // ACCORDION
        // ==============================
        
function toggleAccordion(id) {

    const answer = document.getElementById(`ans-${id}`);
    const icon = document.getElementById(`icon-${id}`);
    const question = document.getElementById(`question-${id}`);

    if (!answer) return;

    const isOpen = answer.classList.contains('open');

    // Tutup dropdown
    if (isOpen) {

        answer.classList.remove('open');
        icon.classList.remove('rotate');
        question.setAttribute('aria-expanded', 'false');

    }

    // Buka dropdown
    else {

        answer.classList.add('open');
        icon.classList.add('rotate');
        question.setAttribute('aria-expanded', 'true');

    }

}



        // ==============================
        // SEARCH
        // ==============================
        function handleSearch() {

            const input = document.getElementById('search-input');

            const clearButton = document.getElementById('clear-search');

            if (input.value.length > 0) {

                clearButton.classList.remove('hidden');

            } else {

                clearButton.classList.add('hidden');

            }

            renderFaqs();

        }


        function clearSearch() {

            document.getElementById('search-input').value = '';

            document.getElementById('clear-search').classList.add('hidden');

            renderFaqs();

        }


        // ==============================
        // FILTER KATEGORI
        // ==============================
        function filterCategory(category) {

            activeCategory = category;

            document.querySelectorAll('.cat-btn').forEach(button => {

                const isActive = button.dataset.category === category;

                if (isActive) {

                    button.className =
                        'cat-btn active bg-ubaya-red text-white px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition shadow-sm';

                } else {

                    button.className =
                        'cat-btn bg-white text-gray-600 border border-gray-200 hover:border-ubaya-red px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition';

                }

            });

            renderFaqs();

        }


        // ==============================
        // MODAL
        // ==============================
        function openModal(id) {

            document.getElementById(id).classList.remove('hidden');

        }


        function closeModal(id) {

            document.getElementById(id).classList.add('hidden');

        }


        // ==============================
        // TOAST
        // ==============================
        let toastTimeout;

        function showToast(message, isError = false) {

            const toast = document.getElementById('toast');

            const icon = toast.querySelector('i');

            document.getElementById('toast-message').innerText = message;

            icon.className = isError
                ? 'fa-solid fa-circle-exclamation text-red-400 text-base'
                : 'fa-solid fa-circle-check text-green-400 text-base';

            toast.classList.remove('hidden');

            toast.classList.add('flex');

            clearTimeout(toastTimeout);

            toastTimeout = setTimeout(() => {

                toast.classList.add('hidden');

                toast.classList.remove('flex');

            }, 3000);

        }


        // ==============================
        // KIRIM SARAN PERTANYAAN
        // ==============================
        async function handleSuggestionSubmit(event) {

            event.preventDefault();

            const question = document
                .getElementById('suggest-question')
                .value
                .trim();

            const submitButton = document.getElementById('suggest-submit-button');

            if (!question) {

                showToast('Pertanyaan tidak boleh kosong.', true);

                return;
            }

            submitButton.disabled = true;

            submitButton.innerText = 'Mengirim...';

            try {

                const response = await fetch(
                    "{{ route('student.store-suggestion') }}",
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document
                                .querySelector('meta[name="csrf-token"]')
                                .content,
                            'Accept': 'application/json'
                        },

                        body: JSON.stringify({
                            pertanyaan: question
                        })
                    }
                );

                const data = await response.json();

                if (response.ok && data.success) {

                    closeModal('suggest-modal');

                    document.getElementById('suggestion-form').reset();

                    showToast(data.message);

                } else {

                    showToast(
                        data.message || 'Gagal mengirim saran pertanyaan.',
                        true
                    );

                }

            } catch (error) {

                showToast('Terjadi kesalahan. Silakan coba kembali.', true);

            } finally {

                submitButton.disabled = false;

                submitButton.innerText = 'Kirimkan Saran Pertanyaan';

            }

        }


        // ==============================
        // TAMPILKAN FAQ SAAT HALAMAN DIBUKA
        // ==============================
        document.addEventListener('DOMContentLoaded', function() {

            renderFaqs();

        });

    </script>

</body>
</html>
