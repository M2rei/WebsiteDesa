<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Desa Ngrejo - Kabupaten Blitar Jawa Timur')</title>
    <meta name="description"
        content="@yield('meta_description', 'Portal resmi Desa Ngrejo, Kecamatan Bakung, Kabupaten Blitar, Jawa Timur. Informasi, profil desa, potensi desa, dan layanan surat menyurat online.')">
    <link rel="icon" href="{{ \App\Helpers\ImageHelper::url($desa->logo_url) }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-shadow {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .gradient-overlay {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.9), rgba(29, 78, 216, 0.9));
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
    <nav id="navbar"
        class="fixed top-0 left-0 w-full z-50 transition-all duration-300 ease-in-out bg-transparent text-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center space-x-3">
                    <div class="inline-block">
                        <img src="{{ \App\Helpers\ImageHelper::url($desa->logo_url) }}" alt="Logo Desa" width="200"
                            height="200" class="h-auto max-h-12 w-auto object-contain" />
                    </div>
                    <div>
                        <h1 class="font-bold text-lg">Desa Ngrejo</h1>
                        <p class="text-sm text-white-200">Kabupaten Blitar Jawa Timur</p>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('dashboard') }}"
                        class="transition-colors px-3 py-2 border-b-4 {{ request()->routeIs('dashboard') ? 'border-white text-white' : 'border-transparent hover:text-blue-200' }}">
                        Home
                    </a>
                    <a href="{{ route('user.profile') }}"
                        class="transition-colors px-3 py-2 border-b-4 {{ request()->routeIs('user.profile') ? 'border-white text-white' : 'border-transparent hover:text-blue-200' }}">
                        Profile Desa
                    </a>
                    <a href="{{ route('user.organisasi') }}"
                        class="transition-colors px-3 py-2 border-b-4 {{ request()->routeIs('user.organisasi') ? 'border-white text-white' : 'border-transparent hover:text-blue-200' }}">
                        Struktur Organisasi
                    </a>
                    <a href="{{ route('user.informasi') }}"
                        class="transition-colors px-3 py-2 border-b-4 {{ request()->routeIs('user.informasi') ? 'border-white text-white' : 'border-transparent hover:text-blue-200' }}">
                        Informasi
                    </a>
                    <a href="{{ route('user.potensidesa') }}"
                        class="transition-colors px-3 py-2 border-b-4 {{ request()->routeIs('user.potensidesa') ? 'border-white text-white' : 'border-transparent hover:text-blue-200' }}">
                        Potensi Desa
                    </a>
                    <a href="{{ route('user.surat.create') }}"
                        class="transition-colors px-3 py-2 border-b-4 {{ request()->routeIs('user.surat.create') ? 'border-white text-white' : 'border-transparent hover:text-blue-200' }}">
                        Surat Desa
                    </a>
                </div>
                <!-- Mobile Menu Button -->
                <button type="button" class="md:hidden w-11 h-11 flex items-center justify-center text-white"
                    onclick="toggleMobileMenu()" aria-label="Buka menu" aria-controls="mobile-menu"
                    aria-expanded="false" id="mobile-menu-btn">
                    <i class="fas fa-bars text-xl" id="mobile-menu-icon"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu"
                class="md:hidden hidden pb-4 bg-primary-800 text-white absolute top-full left-0 w-full shadow-lg z-50">
                <div class="space-y-2 p-4">
                    <a href="{{ route('dashboard') }}"
                        class="block py-2 border-b-4 {{ request()->routeIs('dashboard') ? 'border-white text-white' : 'border-transparent hover:text-blue-200' }}">Home</a>
                    <a href="{{ route('user.profile') }}"
                        class="block py-2 border-b-4 {{ request()->routeIs('user.profile') ? 'border-white text-white' : 'border-transparent hover:text-blue-200' }}">Profile
                        Desa</a>
                    <a href="{{ route('user.organisasi') }}"
                        class="block py-2 border-b-4 {{ request()->routeIs('user.organisasi') ? 'border-white text-white' : 'border-transparent hover:text-blue-200' }}">Struktur
                        Organisasi</a>
                    <a href="{{ route('user.informasi') }}"
                        class="block py-2 border-b-4 {{ request()->routeIs('user.informasi') ? 'border-white text-white' : 'border-transparent hover:text-blue-200' }}">Informasi</a>
                    <a href="{{ route('user.potensidesa') }}"
                        class="block py-2 border-b-4 {{ request()->routeIs('user.potensidesa') ? 'border-white text-white' : 'border-transparent hover:text-blue-200' }}">Potensi
                        Desa</a>
                    <a href="{{ route('user.surat.create') }}"
                        class="block py-2 border-b-4 {{ request()->routeIs('user.surat.create') ? 'border-white text-white' : 'border-transparent hover:text-blue-200' }}">Surat
                        Desa</a>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Backdrop -->
        <div id="mobile-menu-backdrop" onclick="toggleMobileMenu()"
            class="md:hidden hidden fixed inset-0 bg-black/50 z-40 transition-opacity duration-300"></div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-primary-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="inline-block">
                            <img src="{{ \App\Helpers\ImageHelper::url($desa->logo_url) }}" alt="Logo Desa"
                                width="200" height="200" class="h-auto max-h-20 w-auto object-contain">
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Desa Ngrejo</h3>
                        </div>
                    </div>
                    <p class="text-blue-200 mb-4 overflow-hidden text-ellipsis line-clamp-3">
                        {{ $desa->profile_desa }}
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/profile.php?id=61578703221314"
                            aria-label="Facebook Desa Ngrejo" target="_blank" rel="noopener"
                            class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-500 transition-colors">
                            <i class="fab fa-facebook-f text-sm" aria-hidden="true"></i>
                        </a>
                        <a href="http://www.youtube.com/@pemdesngrejo1287" aria-label="YouTube Desa Ngrejo"
                            target="_blank" rel="noopener"
                            class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center hover:bg-red-500 transition-colors">
                            <i class="fab fa-youtube text-sm text-white" aria-hidden="true"></i>
                        </a>
                        <a href="https://www.instagram.com/pemdesngrejo?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                            aria-label="Instagram Desa Ngrejo" target="_blank" rel="noopener"
                            class="w-8 h-8 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-500 transition-colors">
                            <i class="fab fa-instagram text-sm" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-lg mb-4">Menu Utama</h4>
                    <ul class="space-y-2 text-blue-200">
                        <li><a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Home</a></li>
                        <li><a href="{{ route('user.profile') }}" class="hover:text-white transition-colors">Profile
                                Desa</a></li>
                        <li><a href="{{ route('user.organisasi') }}"
                                class="hover:text-white transition-colors">Struktur
                                Organisasi</a></li>
                        <li><a href="{{ route('user.informasi') }}"
                                class="hover:text-white transition-colors">Informasi</a></li>
                        <li><a href="{{ route('user.potensidesa') }}"
                                class="hover:text-white transition-colors">Potensi Desa</a></li>
                        <li><a href="{{ route('user.surat.create') }}" class="hover:text-white transition-colors">Surat
                                Desa</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-lg mb-4">Kontak</h4>
                    <div class="space-y-3 text-blue-200">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Desa Ngrejo, Kabupaten Blitar, Jawa Timur</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-phone"></i>
                            <span>{{ $desa->nomor_telepon }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-envelope"></i>
                            <span>{{ $desa->email }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-blue-800 mt-8 pt-8 text-center text-blue-200">
                <p>&copy; {{ date('Y') }} Pemerintah Desa Ngrejo. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        let mobileMenuOpen = false;

        function updateNavbarBackground() {
            const navbar = document.getElementById('navbar');
            if (mobileMenuOpen || window.scrollY > 50) {
                navbar.classList.remove('bg-transparent');
                navbar.classList.add('bg-primary-800');
                navbar.classList.add('text-white');
            } else {
                navbar.classList.remove('bg-primary-800');
                navbar.classList.add('bg-transparent');
                navbar.classList.add('text-white');
            }
        }

        function toggleMobileMenu() {
            mobileMenuOpen = !mobileMenuOpen;

            const menu = document.getElementById('mobile-menu');
            const backdrop = document.getElementById('mobile-menu-backdrop');
            const icon = document.getElementById('mobile-menu-icon');
            const btn = document.getElementById('mobile-menu-btn');

            menu.classList.toggle('hidden', !mobileMenuOpen);
            backdrop.classList.toggle('hidden', !mobileMenuOpen);
            icon.classList.toggle('fa-bars', !mobileMenuOpen);
            icon.classList.toggle('fa-times', mobileMenuOpen);
            btn.setAttribute('aria-expanded', mobileMenuOpen ? 'true' : 'false');

            updateNavbarBackground();
        }

        window.addEventListener('scroll', updateNavbarBackground);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileMenuOpen) {
                toggleMobileMenu();
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
