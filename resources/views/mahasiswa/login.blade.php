
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Mahasiswa - KMS UBAYA</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    <div class="relative min-h-screen flex flex-col justify-between overflow-hidden">

        <!-- Background -->
        <div class="absolute inset-0 bg-cover bg-center z-0"
             style="background-image: url('{{ asset('images/bg-hal1ubaya.jpg') }}')">
        </div>

        <div class="absolute inset-0 bg-white/45 backdrop-blur-[2px] z-0"></div>

        <!-- HEADER -->
        <header class="relative z-10 bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-200 py-3 px-6">
            <div class="max-w-7xl mx-auto flex items-center justify-between">

                <button onclick="openModal('about-modal')"
                    class="text-sm font-semibold text-gray-700 hover:text-ubaya-red flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-ubaya-red"></i>
                    <span>About Us</span>
                </button>

                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/bg-logoubayakms.png') }}"
                         alt="Logo UBAYA"
                         class="h-10 w-auto object-contain">

                    <div>
                        <h1 class="font-bold text-gray-900 leading-none text-base md:text-lg">
                            KMS UBAYA
                        </h1>
                        <p class="text-[11px] text-gray-500 font-medium">
                            Knowledge Management System
                        </p>
                    </div>
                </div>

                <button onclick="openModal('login-modal')"
                    class="text-sm font-semibold text-gray-700 hover:text-ubaya-red flex items-center gap-2">
                    <i class="fa-solid fa-user-shield text-gray-500"></i>
                    <span class="hidden sm:inline">Login Staff</span>
                </button>

            </div>
        </header>


        <!-- LOGIN MAHASISWA -->
        <main class="relative z-10 flex-1 flex items-center justify-center p-4">

            <div class="bg-white/95 backdrop-blur-md border border-gray-100 shadow-2xl rounded-2xl p-8 max-w-md w-full text-center my-auto">

                <div class="w-16 h-16 bg-red-50 text-ubaya-red rounded-full flex items-center justify-center mx-auto mb-4 border border-red-100 shadow-inner">
                    <i class="fa-solid fa-id-card text-2xl"></i>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    Selamat Datang Mahasiswa
                </h2>

                <p class="text-sm text-gray-600 mb-6 leading-relaxed">
                    Masukkan NRP Anda untuk mengakses Layanan Informasi & FAQ Layanan Akademik UBAYA.
                </p>

                <form id="nrp-form" onsubmit="handleNrpSubmit(event)" class="space-y-4">

                    <div class="text-left">
                        <label for="input-nrp"
                            class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                            NRP
                        </label>

                        <div class="relative">
                            <i class="fa-solid fa-hashtag absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                            <input
                                type="text"
                                id="input-nrp"
                                required
                                maxlength="45"
                                placeholder="Contoh: 160421001"
                                class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-ubaya-red focus:border-ubaya-red focus:bg-white transition text-gray-900 font-medium tracking-wide outline-none"
                            >
                        </div>
                    </div>

                    <button id="btn-login" type="submit"
                        class="w-full bg-ubaya-red hover:bg-ubaya-hover text-white font-semibold py-3.5 px-6 rounded-xl shadow-lg transition flex items-center justify-center gap-2">

                        <span id="login-text">Masuk</span>
                        <i class="fa-solid fa-arrow-right text-sm" id="login-icon"></i>

                    </button>

                </form>

                <p class="text-xs text-gray-400 mt-6">
                    <i class="fa-solid fa-shield-halved mr-1"></i>
                    Tidak memerlukan kata sandi.
                </p>

            </div>

        </main>


        <!-- FOOTER -->
        <footer class="relative z-10 text-center py-4 text-xs text-gray-600 bg-white/60 backdrop-blur-sm border-t border-gray-200">
            &copy; {{ date('Y') }} Direktorat Administrasi Akademik - Universitas Surabaya
        </footer>

    </div>


    <!-- ================================= -->
    <!-- MODAL ABOUT US                    -->
    <!-- ================================= -->

    <div id="about-modal"
         class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">

        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl relative">

            <button onclick="closeModal('about-modal')"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>

            <div class="flex items-center gap-3 mb-4">

                <div class="w-10 h-10 bg-red-50 text-ubaya-red rounded-xl flex items-center justify-center">
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
                    agar segera dijawab oleh tim Data Entry DAA.
                </p>

            </div>

            <button onclick="closeModal('about-modal')"
                class="mt-6 w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl text-xs transition">
                Tutup
            </button>

        </div>
    </div>


    <!-- ================================= -->
    <!-- MODAL LOGIN STAFF                 -->
    <!-- ================================= -->

    <div id="login-modal"
         class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">

        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl relative">

            <button onclick="closeModal('login-modal')"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>

            <div class="text-center mb-5">

                <div class="w-12 h-12 bg-gray-100 text-gray-700 rounded-full flex items-center justify-center mx-auto mb-2">
                    <i class="fa-solid fa-user-lock text-xl"></i>
                </div>

                <h3 class="font-bold text-gray-900 text-lg">
                    Login Portal Staff
                </h3>

                <p class="text-xs text-gray-500">
                    Khusus untuk Data Entry, Validator & Super Admin
                </p>

            </div>

            <form onsubmit="handleStaffLogin(event)" class="space-y-4 text-xs">

                <div>
                    <label class="block font-semibold text-gray-700 mb-1">
                        Peran Staff (Role)
                    </label>

                    <select id="staff-role"
                        class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-ubaya-red font-medium">

                        <option value="data_entry">Data Entry</option>
                        <option value="validator">Validator</option>
                        <option value="super_admin">Super Admin</option>

                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1">
                        Username / NPK
                    </label>

                    <input type="text" id="staff-username" required
                        placeholder="Masukkan NPK Staff"
                        class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-ubaya-red">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1">
                        Kata Sandi
                    </label>

                    <input type="password" id="staff-password" required
                        placeholder="••••••••"
                        class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-ubaya-red">
                </div>

                <button type="submit"
                    class="w-full bg-gray-900 hover:bg-black text-white font-semibold py-3 rounded-xl transition mt-2 text-xs">
                    Masuk ke Dashboard Staff
                </button>

            </form>

        </div>
    </div>


    <!-- ================================= -->
    <!-- TOAST NOTIFICATION                -->
    <!-- ================================= -->

    <div id="toast"
        class="fixed bottom-5 right-5 hidden bg-gray-900 text-white px-5 py-3 rounded-xl shadow-2xl text-xs z-[60]">
        <span id="toast-message">Notifikasi</span>
    </div>


    <!-- ================================= -->
    <!-- JAVASCRIPT                        -->
    <!-- ================================= -->

    <script>

        // =================================
        // LOGIN MAHASISWA
        // =================================

        async function handleNrpSubmit(e) {

            e.preventDefault();

            const nrp = document.getElementById('input-nrp').value.trim();

            const button = document.getElementById('btn-login');
            const loginText = document.getElementById('login-text');
            const loginIcon = document.getElementById('login-icon');

            if (!nrp) {
                showToast('Silakan masukkan NRP Anda.');
                return;
            }

            button.disabled = true;
            button.classList.add('opacity-70', 'cursor-not-allowed');
            loginText.innerText = 'Memeriksa NRP...';
            loginIcon.className = 'fa-solid fa-spinner fa-spin text-sm';

            try {

                const response = await fetch("{{ route('student.verify-nrp') }}", {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },

                    body: JSON.stringify({
                        nrp: nrp
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {

                    window.location.href = "{{ route('student.kms') }}";

                } else {

                    showToast(data.message || 'NRP tidak terdaftar.');

                }

            } catch (error) {

                console.error(error);
                showToast('Terjadi kesalahan. Silakan coba kembali.');

            } finally {

                button.disabled = false;
                button.classList.remove('opacity-70', 'cursor-not-allowed');
                loginText.innerText = 'Masuk';
                loginIcon.className = 'fa-solid fa-arrow-right text-sm';

            }
        }


        // =================================
        // MODAL CONTROL
        // =================================

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }


        // =================================
        // LOGIN STAFF
        // =================================

        function handleStaffLogin(e) {

            e.preventDefault();

            // Belum terhubung ke autentikasi Laravel.
            showToast('Login Staff belum dihubungkan ke backend.');

        }


        // =================================
        // TOAST NOTIFICATION
        // =================================

        function showToast(message) {

            const toast = document.getElementById('toast');

            document.getElementById('toast-message').innerText = message;

            toast.classList.remove('hidden');

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);

        }

    </script>

</body>
</html>
