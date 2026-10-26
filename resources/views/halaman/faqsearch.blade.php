<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KMS FAQ Mahasiswa - Universitas Surabaya</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
</head>
<body class="font-sans bg-gray-50 text-gray-800 antialiased min-h-screen flex flex-col">

    <!-- ========================================== -->
    <!-- HALAMAN 1: INPUT NRP (LANDING PAGE)       -->
    <!-- ========================================== -->
    <div id="page-1" class="relative min-h-screen flex flex-col justify-between overflow-hidden">
        
        <!-- Background Foto Kampus dengan Overlay Transparansi Putih 45% -->
        <div class="absolute inset-0 bg-cover bg-center z-0 bg-[url('/images/bg-hal1ubaya.jpg')]"></div>

        <!-- White Transparency Layer (45% Transparansi) -->
        <div class="absolute inset-0 bg-white/45 backdrop-blur-[2px] z-0"></div>

        <!-- Header Halaman 1 -->
        <header class="relative z-10 bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-200 py-3 px-6">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <!-- Kiri: About Us -->
                <button onclick="openModal('about-modal')" class="text-sm font-semibold text-gray-700 hover:text-ubaya-red flex items-center gap-2 transition">
                    <i class="fa-solid fa-circle-info text-ubaya-red"></i>
                    <span>About Us</span>
                </button>

                <!-- Tengah: Logo & Title -->
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/bg-logoubayakms.png') }}" alt="Logo UBAYA" class="h-10 w-auto object-contain">
                    <div>
                        <h1 class="font-bold text-gray-900 leading-none text-base md:text-lg">KMS UBAYA</h1>
                        <p class="text-[11px] text-gray-500 font-medium">Knowledge Management System</p>
                    </div>
                </div>

                <!-- Kanan: Login Staff -->
                <button onclick="openModal('login-modal')" class="text-sm font-semibold text-gray-700 hover:text-ubaya-red flex items-center gap-2 transition">
                    <i class="fa-solid fa-user-shield text-gray-500"></i>
                    <span class="hidden sm:inline">Login Staff</span>
                </button>
            </div>
        </header>

        <!-- Main Content Halaman 1: Card Input NRP -->
        <main class="relative z-10 flex-1 flex items-center justify-center p-4">
            <div class="bg-white/95 backdrop-blur-md border border-gray-100 shadow-2xl rounded-2xl p-8 max-w-md w-full text-center my-auto transform transition-all">
                <div class="w-16 h-16 bg-red-50 text-ubaya-red rounded-full flex items-center justify-center mx-auto mb-4 border border-red-100 shadow-inner">
                    <i class="fa-solid fa-id-card text-2xl"></i>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang Mahasiswa</h2>
                <p class="text-sm text-gray-600 mb-6 leading-relaxed">
                    Masukkan NRP Anda untuk mengakses Layanan Informasi & FAQ Layanan Akademik UBAYA.
                </p>

                <form id="nrp-form" onsubmit="handleNrpSubmit(event)" class="space-y-4">
                    <div class="text-left">
                        <label for="input-nrp" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">NRP</label>
                        <div class="relative">
                            <i class="fa-solid fa-hashtag absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input 
                                type="text" 
                                id="input-nrp" 
                                required
                                placeholder="Contoh: 160421001" 
                                maxlength="10"
                                class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-ubaya-red focus:border-ubaya-red focus:bg-white transition text-gray-900 font-medium tracking-wide outline-none"
                            >
                        </div>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full bg-ubaya-red hover:bg-ubaya-hover text-white font-semibold py-3.5 px-6 rounded-xl shadow-lg shadow-red-600/30 transition duration-200 flex items-center justify-center gap-2"
                    >
                        <span>Masuk</span>
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </button>
                </form>

                <p class="text-xs text-gray-400 mt-6">
                    <i class="fa-solid fa-shield-halved text-gray-400 mr-1"></i> Tidak memerlukan kata sandi / login.
                </p>
            </div>
        </main>

        <!-- Footer Halaman 1 -->
        <footer class="relative z-10 text-center py-4 text-xs text-gray-600 bg-white/60 backdrop-blur-sm border-t border-gray-200">
            &copy; {{ date('Y') }} Direktorat Administrasi Akademik - Universitas Surabaya
        </footer>
    </div>


    <!-- ========================================== -->
    <!-- HALAMAN 2: FAQ SEARCH & DASHBOARD          -->
    <!-- ========================================== -->
    <div id="page-2" class="hidden min-h-screen flex flex-col bg-gray-50">
        
        <!-- Header Halaman 2 -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-20 shadow-sm">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3.5 flex items-center justify-between">
                
                <!-- Kiri: Kembali ke Halaman 1 -->
                <button onclick="goToPage(1)" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-ubaya-red transition py-1.5 px-3 rounded-lg hover:bg-gray-100">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Input NRP</span>
                </button>

                <!-- Tengah: Logo & KMS Title -->
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/bg-logoubayakms.png') }}" alt="Logo UBAYA" class="h-10 w-auto object-contain">
                    <span class="font-bold text-gray-900 text-base hidden sm:inline">KMS FAQ UBAYA</span>
                </div>

                <!-- Kanan: About Us -->
                <button onclick="openModal('about-modal')" class="text-sm font-semibold text-gray-700 hover:text-ubaya-red flex items-center gap-2 transition py-1.5 px-3 rounded-lg hover:bg-gray-100">
                    <i class="fa-solid fa-circle-info text-ubaya-red"></i>
                    <span class="hidden sm:inline">About Us</span>
                </button>
            </div>
        </header>

        <!-- Content Body Halaman 2 -->
        <main class="max-w-5xl mx-auto px-4 sm:px-6 py-8 w-full flex-1">
            
            <!-- Title Section -->
            <div class="text-center mb-8">
                <span class="inline-block px-3 py-1 bg-red-50 text-ubaya-red text-xs font-semibold rounded-full mb-3 border border-red-100">
                    Pusat Informasi & Layanan Mahasiswa
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Apa yang ingin Anda tanyakan?</h2>
                <p class="text-sm text-gray-500 mt-1">Cari jawaban cepat seputar perkuliahan, KRS, keuangan, dan fasilitas kampus.</p>
            </div>

            <!-- Search Bar Container -->
            <div class="max-w-2xl mx-auto mb-3">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
                    <input 
                        type="text" 
                        id="search-input" 
                        oninput="handleSearch()"
                        placeholder="Cari pertanyaan... (contoh: Cara perwalian, bayar UKT, KRS)" 
                        class="w-full pl-12 pr-10 py-4 bg-white border border-gray-300 rounded-2xl shadow-sm focus:ring-2 focus:ring-ubaya-red focus:border-ubaya-red transition outline-none text-gray-800 text-sm sm:text-base"
                    >
                    <button id="clear-search" onclick="clearSearch()" class="hidden absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Opsi Opsi Kecil Saran Pertanyaan (Di Bawah Searchbar) -->
                <div class="mt-2.5 px-2 flex items-center justify-between text-xs text-gray-500">
                    <span>Belum menemukan pertanyaan yang dicari?</span>
                    <button onclick="openModal('suggest-modal')" class="text-ubaya-red font-semibold hover:underline flex items-center gap-1 transition">
                        <i class="fa-regular fa-paper-plane"></i>
                        <span>Ajukan Saran Pertanyaan Baru</span>
                    </button>
                </div>
            </div>

            <!-- Category Filters (Dinamis dari Database) -->
            <div class="flex items-center justify-center gap-2 overflow-x-auto py-4 mb-6 no-scrollbar">
                <button onclick="filterCategory('All')" class="cat-btn active bg-ubaya-red text-white px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition shadow-sm" data-category="All">
                    Semua Pertanyaan
                </button>
                @foreach($kategoris as $kategori)
                    <button onclick="filterCategory('{{ $kategori->nama }}')" class="cat-btn bg-white text-gray-600 border border-gray-200 hover:border-ubaya-red px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition" data-category="{{ $kategori->nama }}">
                        {{ $kategori->nama }}
                    </button>
                @endforeach
            </div>

            <!-- FAQ List Container -->
            <div id="faq-list" class="space-y-3 max-w-3xl mx-auto">
                <!-- Data FAQ akan di-render secara dinamis via JS -->
            </div>

            <!-- Empty State (Jika tidak ditemukan) -->
            <div id="empty-state" class="hidden text-center py-12 bg-white rounded-2xl border border-gray-200 max-w-3xl mx-auto mt-4 p-6">
                <div class="w-16 h-16 bg-red-50 text-ubaya-red rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-circle-question text-2xl"></i>
                </div>
                <h3 class="text-base font-bold text-gray-800">Pertanyaan Tidak Ditemukan</h3>
                <p class="text-xs text-gray-500 mt-1 max-w-md mx-auto">
                    Maaf, pertanyaan dengan kata kunci tersebut belum tersedia di basis pengetahuan kami.
                </p>
                <button onclick="openModal('suggest-modal')" class="mt-4 bg-ubaya-red text-white text-xs font-semibold px-5 py-2.5 rounded-xl hover:bg-ubaya-hover transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>Kirimkan Pertanyaan Ini ke Sistem</span>
                </button>
            </div>

        </main>

        <!-- Footer Halaman 2 -->
        <footer class="bg-white border-t border-gray-200 text-center py-4 text-xs text-gray-500 mt-auto">
            &copy; {{ date('Y') }} Student Knowledge Management System — Universitas Surabaya
        </footer>
    </div>


    <!-- ========================================== -->
    <!-- MODAL: ABOUT US                            -->
    <!-- ========================================== -->
    <div id="about-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl relative animate-fade-in">
            <button onclick="closeModal('about-modal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-red-50 text-ubaya-red rounded-xl flex items-center justify-center font-bold">
                    <i class="fa-solid fa-circle-info text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-base">Tentang KMS UBAYA</h3>
                    <p class="text-xs text-gray-500">Direktorat Administrasi Akademik</p>
                </div>
            </div>
            <div class="text-xs text-gray-600 space-y-3 leading-relaxed">
                <p>
                    <strong>Student Knowledge Management System (KMS)</strong> adalah platform pusat informasi terpadu yang dirancang untuk membantu mahasiswa Universitas Surabaya menemukan jawaban atas pertanyaan seputar akademik, administrasi, keuangan, dan fasilitas kampus secara mandiri.
                </p>
                <p>
                    Jika pertanyaan Anda belum memiliki jawaban, Anda dapat mengirimkan saran pertanyaan melalui fitur yang tersedia agar segera dijawab oleh tim Data Entry DAA.
                </p>
            </div>
            <button onclick="closeModal('about-modal')" class="mt-6 w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl text-xs transition">
                Tutup
            </button>
        </div>
    </div>


    <!-- ========================================== -->
    <!-- MODAL: LOGIN STAFF                         -->
    <!-- ========================================== -->
    <div id="login-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl relative">
            <button onclick="closeModal('login-modal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
            <div class="text-center mb-5">
                <div class="w-12 h-12 bg-gray-100 text-gray-700 rounded-full flex items-center justify-center mx-auto mb-2">
                    <i class="fa-solid fa-user-lock text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">Login Portal Staff</h3>
                <p class="text-xs text-gray-500">Khusus untuk Data Entry, Validator & Super Admin</p>
            </div>

            <form onsubmit="handleStaffLogin(event)" class="space-y-4 text-xs">
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Peran Staff (Role)</label>
                    <select id="staff-role" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-ubaya-red font-medium">
                        <option value="data_entry">Data Entry</option>
                        <option value="validator">Validator</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Username / NPK</label>
                    <input type="text" required placeholder="Masukkan NPK Staff" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-ubaya-red">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Kata Sandi</label>
                    <input type="password" required placeholder="••••••••" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-ubaya-red">
                </div>
                <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white font-semibold py-3 rounded-xl transition mt-2 text-xs">
                    Masuk ke Dashboard Staff
                </button>
            </form>
        </div>
    </div>


    <!-- ========================================== -->
    <!-- MODAL: AJUKAN SARAN PERTANYAAN             -->
    <!-- ========================================== -->
    <div id="suggest-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl relative">
            <button onclick="closeModal('suggest-modal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>

            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-red-50 text-ubaya-red rounded-xl flex items-center justify-center font-bold">
                    <i class="fa-regular fa-paper-plane text-lg"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-base">Ajukan Saran Pertanyaan</h3>
                    <p class="text-xs text-gray-500">Pertanyaan akan dijawab oleh Tim Data Entry</p>
                </div>
            </div>

            <form onsubmit="handleSuggestionSubmit(event)" class="space-y-3 text-xs">
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">NRP Mahasiswa</label>
                    <input type="text" id="suggest-nrp" readonly class="w-full p-2.5 bg-gray-100 border border-gray-200 rounded-lg text-gray-600 font-medium">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Kategori Pertanyaan</label>
                    <!-- OPSI DINAMIS DARI DATABASE MYSQL VIA LARAVEL BLADE -->
                    <select id="suggest-category" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-ubaya-red">
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Tulis Pertanyaan Anda</label>
                    <textarea id="suggest-question" required rows="4" placeholder="Tuliskan pertanyaan secara jelas di sini..." class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-ubaya-red"></textarea>
                </div>

                <button type="submit" class="w-full bg-ubaya-red hover:bg-ubaya-hover text-white font-semibold py-3 rounded-xl transition text-xs shadow-md">
                    Kirimkan Saran Pertanyaan
                </button>
            </form>
        </div>
    </div>


    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-5 right-5 hidden bg-gray-900 text-white px-5 py-3 rounded-xl shadow-2xl text-xs z-50 flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-green-400 text-base"></i>
        <span id="toast-message">Notifikasi</span>
    </div>


    <!-- ========================================== -->
    <!-- JAVASCRIPT LOGIC                           -->
    <!-- ========================================== -->
    <script>
        // Data FAQ diambil langsung dari Database MySQL melalui Controller
        const faqsData = @json($faqs ?? []);

        let currentNrp = '';
        let activeCategory = 'All';

        // Navigasi Antar Halaman
        function goToPage(pageNumber) {
            const page1 = document.getElementById('page-1');
            const page2 = document.getElementById('page-2');

            if (pageNumber === 1) {
                page1.classList.remove('hidden');
                page2.classList.add('hidden');
            } else if (pageNumber === 2) {
                page1.classList.add('hidden');
                page2.classList.remove('hidden');
                renderFaqs();
            }
        }

        // Handle Input NRP & Verifikasi ke Backend Laravel
        async function handleNrpSubmit(e) {
            e.preventDefault();
            const nrpInput = document.getElementById('input-nrp').value.trim();
            if (!nrpInput) return;

            try {
                const response = await fetch("{{ route('student.verify-nrp') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ nrp: nrpInput })
                });

                const data = await response.json();
                if (data.success) {
                    currentNrp = data.nrp;
                    document.getElementById('suggest-nrp').value = currentNrp;
                    goToPage(2);
                    showToast(`Selamat datang Mahasiswa (${currentNrp})`);
                } else {
                    showToast('Gagal memproses NRP');
                }
            } catch (error) {
                // Fallback client-side jika tanpa backend API aktif saat pengujian UI
                currentNrp = nrpInput;
                document.getElementById('suggest-nrp').value = currentNrp;
                goToPage(2);
                showToast(`Selamat datang Mahasiswa (${currentNrp})`);
            }
        }

        // Render Daftar FAQ
        function renderFaqs() {
            const container = document.getElementById('faq-list');
            const emptyState = document.getElementById('empty-state');
            const searchKeyword = document.getElementById('search-input').value.toLowerCase();

            const filtered = faqsData.filter(faq => {
                const matchCategory = activeCategory === 'All' || faq.category === activeCategory;
                const matchSearch = faq.question.toLowerCase().includes(searchKeyword) || 
                                    faq.answer.toLowerCase().includes(searchKeyword);
                return matchCategory && matchSearch;
            });

            if (filtered.length === 0) {
                container.innerHTML = '';
                emptyState.classList.remove('hidden');
                return;
            }

            emptyState.classList.add('hidden');
            container.innerHTML = filtered.map(faq => `
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-xs hover:border-red-200 transition">
                    <button onclick="toggleAccordion(${faq.id})" class="w-full text-left p-4 sm:p-5 flex items-start justify-between gap-4 font-semibold text-gray-800 text-sm sm:text-base hover:bg-gray-50/80 transition">
                        <div class="flex items-start gap-3">
                            <span class="mt-0.5 inline-block px-2.5 py-0.5 text-[10px] uppercase font-bold tracking-wider rounded-md bg-red-50 text-ubaya-red border border-red-100">
                                ${faq.category}
                            </span>
                            <span class="leading-snug">${faq.question}</span>
                        </div>
                        <i id="icon-${faq.id}" class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-200 text-xs mt-1"></i>
                    </button>
                    <div id="ans-${faq.id}" class="hidden px-5 pb-5 pt-1 text-xs sm:text-sm text-gray-600 border-t border-gray-100 bg-gray-50/50 leading-relaxed">
                        <p class="mb-4">${faq.answer}</p>
                        <div class="flex items-center justify-between text-xs text-gray-400 pt-3 border-t border-gray-200/60">
                            <span>Apakah jawaban ini membantu?</span>
                            <div class="flex items-center gap-2">
                                <button onclick="voteHelpful(${faq.id})" class="hover:text-ubaya-red transition flex items-center gap-1 bg-white px-2.5 py-1 rounded-md border border-gray-200">
                                    <i class="fa-regular fa-thumbs-up"></i>
                                    <span>${faq.helpful || 0}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Accordion Toggle
        function toggleAccordion(id) {
            const ans = document.getElementById(`ans-${id}`);
            const icon = document.getElementById(`icon-${id}`);
            if (ans.classList.contains('hidden')) {
                ans.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                ans.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }

        // Realtime Search
        function handleSearch() {
            const input = document.getElementById('search-input');
            const clearBtn = document.getElementById('clear-search');
            if (input.value.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
            renderFaqs();
        }

        function clearSearch() {
            document.getElementById('search-input').value = '';
            document.getElementById('clear-search').classList.add('hidden');
            renderFaqs();
        }

        // Category Filter Button Handler
        function filterCategory(cat) {
            activeCategory = cat;
            document.querySelectorAll('.cat-btn').forEach(btn => {
                if (btn.dataset.category === cat) {
                    btn.className = 'cat-btn active bg-ubaya-red text-white px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition shadow-sm';
                } else {
                    btn.className = 'cat-btn bg-white text-gray-600 border border-gray-200 hover:border-ubaya-red px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition';
                }
            });
            renderFaqs();
        }

        // Vote Helpful
        function voteHelpful(id) {
            const item = faqsData.find(f => f.id === id);
            if (item) {
                item.helpful = (item.helpful || 0) + 1;
                renderFaqs();
                document.getElementById(`ans-${id}`).classList.remove('hidden');
                showToast('Terima kasih atas masukan Anda!');
            }
        }

        // Modal Controls
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // Submit Form Saran Pertanyaan ke Database
        async function handleSuggestionSubmit(e) {
            e.preventDefault();
            const qText = document.getElementById('suggest-question').value;
            const catId = document.getElementById('suggest-category').value;

            try {
                const response = await fetch("{{ route('student.store-suggestion') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                        nrp: currentNrp, 
                        kategori_id: catId,
                        pertanyaan: qText 
                    })
                });

                const data = await response.json();
                if (data.success) {
                    closeModal('suggest-modal');
                    document.getElementById('suggest-question').value = '';
                    showToast(data.message);
                } else {
                    showToast('Gagal mengirim saran pertanyaan.');
                }
            } catch (error) {
                closeModal('suggest-modal');
                document.getElementById('suggest-question').value = '';
                showToast('Saran pertanyaan berhasil dikirim ke Data Entry!');
            }
        }

        // Staff Login Mockup
        function handleStaffLogin(e) {
            e.preventDefault();
            const role = document.getElementById('staff-role').value;
            closeModal('login-modal');
            showToast(`Login sebagai ${role.replace('_', ' ').toUpperCase()} berhasil`);
        }

        // Toast Helper
        function showToast(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-message').innerText = msg;
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }
    </script>
</body>
</html>