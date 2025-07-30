<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Desa Ngrejo - Kabupaten Blitar Jawa Timur')</title>
    <link rel="icon" href="{{ asset('storage/' . $desa->logo_url) }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a'
                        },
                        orange: {
                            500: '#f97316',
                            600: '#ea580c'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .hero-bg {
            background: linear-gradient(rgba(30, 58, 138, 0.8), rgba(30, 58, 138, 0.8)), url('/images/hero-bg.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

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

<body class="bg-gray-50">
    <nav id="navbar"
        class="fixed top-0 left-0 w-full z-50 transition-all duration-300 ease-in-out bg-transparent text-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center space-x-3">
                    <div class="inline-block">
                        <img src="{{ asset('storage/' . $desa->logo_url) }}" alt="Logo Desa"
                            class="h-auto max-h-12 w-auto object-contain" />
                    </div>
                    <div>
                        <h1 class="font-bold text-lg">Desa Ngrejo</h1>
                        <p class="text-sm text-white-200">Kabupaten Blitar Jawa Timur</p>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('dashboard') }}"
                        class="transition-colors px-3 py-2 rounded {{ request()->routeIs('dashboard') ? 'bg-blue-700 text-white' : 'hover:text-blue-200' }}">
                        Home
                    </a>
                    <a href="{{ route('user.profile') }}"
                        class="transition-colors px-3 py-2 rounded {{ request()->routeIs('user.profile') ? 'bg-blue-700 text-white' : 'hover:text-blue-200' }}">
                        Profile Desa
                    </a>
                    <a href="{{ route('user.organisasi') }}"
                        class="transition-colors px-3 py-2 rounded {{ request()->routeIs('user.organisasi') ? 'bg-blue-700 text-white' : 'hover:text-blue-200' }}">
                        Struktur Organisasi
                    </a>
                    <a href="{{ route('user.informasi') }}"
                        class="transition-colors px-3 py-2 rounded {{ request()->routeIs('user.informasi') ? 'bg-blue-700 text-white' : 'hover:text-blue-200' }}">
                        Informasi
                    </a>
                    <a href="{{ route('user.potensidesa') }}"
                        class="transition-colors px-3 py-2 rounded {{ request()->routeIs('user.potensidesa') ? 'bg-blue-700 text-white' : 'hover:text-blue-200' }}">
                        Potensi Desa
                    </a>
                    <a href="{{ route('user.surat.create') }}"
                        class="transition-colors px-3 py-2 rounded {{ request()->routeIs('user.surat.create') ? 'bg-blue-700 text-white' : 'hover:text-blue-200' }}">
                        Surat Desa
                    </a>
                </div>
                <!-- Mobile Menu Button -->
                <button class="md:hidden text-white" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu"
                class="md:hidden hidden pb-4 bg-primary-800 text-white absolute top-full left-0 w-full shadow-lg z-50">
                <div class="space-y-2 p-4">
                    <a href="{{ route('dashboard') }}" class="block py-2 hover:text-blue-200">Home</a>
                    <a href="{{ route('user.profile') }}" class="block py-2 hover:text-blue-200">Profile Desa</a>
                    <a href="{{ route('user.organisasi') }}" class="block py-2 hover:text-blue-200">Struktur
                        Organisasi</a>
                    <a href="{{ route('user.informasi') }}" class="block py-2 hover:text-blue-200">Informasi</a>
                    <a href="{{ route('user.potensidesa') }}" class="block py-2 hover:text-blue-200">Potensi Desa</a>
                    <a href="{{ route('user.surat.create') }}" class="block py-2 hover:text-blue-200">Surat Desa</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="bg-primary-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="inline-block">
                            <img src="{{ asset('storage/' . $desa->logo_url) }}" alt="Logo Desa"
                                class="h-auto max-h-20 w-auto object-contain">
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
                            class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-500 transition-colors">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="http://www.youtube.com/@pemdesngrejo1287"
                            class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center hover:bg-red-500 transition-colors">
                            <i class="fab fa-youtube text-sm text-white"></i>
                        </a>
                        <a href="https://www.instagram.com/pemdesngrejo?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                            class="w-8 h-8 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-500 transition-colors">
                            <i class="fab fa-instagram text-sm"></i>
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
                <p>&copy; 2025 Desa Ngrejo. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.remove('bg-transparent');
                navbar.classList.add('bg-primary-800');
                navbar.classList.add('text-white');
            } else {
                navbar.classList.remove('bg-primary-800');
                navbar.classList.add('bg-transparent');
                navbar.classList.add('text-white');
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
