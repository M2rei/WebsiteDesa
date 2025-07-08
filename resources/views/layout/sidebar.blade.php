<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Profile Desa')</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                            700: '#1d4ed8'
                        },
                        pink: {
                            500: '#ec4899',
                            600: '#db2777'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar-shadow {
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .content-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .upload-area {
            background-image: url("data:image/svg+xml,%3csvg width='100' height='100' xmlns='http://www.w3.org/2000/svg'%3e%3cdefs%3e%3cpattern id='a' patternUnits='userSpaceOnUse' width='20' height='20' patternTransform='scale(0.5) rotate(0)'%3e%3crect x='0' y='0' width='100%25' height='100%25' fill='none'/%3e%3cpath d='M 10,-2.55e-7 V 20 Z M -1.1677362e-8,10 H 20 Z' stroke-width='1' stroke='%233b82f6' fill='none' opacity='0.2'/%3e%3c/pattern%3e%3c/defs%3e%3crect width='100%25' height='100%25' fill='url(%23a)'/%3e%3c/svg%3e");
        }

        .gradient-header {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .gradient-save {
            background: linear-gradient(135deg, #ec4899, #db2777);
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-50 font-sans">
    <!-- Sidebar -->
    <div class="fixed left-0 top-0 w-64 h-full bg-gray-100 sidebar-shadow z-10">
        <div class="p-5 border-b border-gray-200">
            <h5 class="text-lg font-semibold text-gray-700">Menu</h5>
        </div>

        <nav class="mt-5">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.profile.index') }}"
                        class="flex items-center px-5 py-3 text-gray-700 hover:bg-gray-200 transition-colors duration-200 {{ request()->routeIs('admin.profile.index') ? 'bg-gray-600 text-white hover:bg-gray-700' : '' }}">
                        <i class="fas fa-home w-5 text-center mr-3"></i>
                        Profile Desa
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.struktur-organisasi.index') }}"
                        class="flex items-center px-5 py-3 text-gray-700 hover:bg-gray-200 transition-colors duration-200 {{ request()->routeIs('admin.struktur-organisasi.index') ? 'bg-gray-600 text-white hover:bg-gray-700' : '' }}">
                        <i class="fas fa-sitemap w-5 text-center mr-3"></i>
                        Struktur Organisasi
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.potensi-desa.index') }}"
                        class="flex items-center px-5 py-3 text-gray-700 hover:bg-gray-200 transition-colors duration-200 {{ request()->routeIs('admin.potensi-desa.index') ? 'bg-gray-600 text-white hover:bg-gray-700' : '' }}">
                        <i class="fas fa-chart-line w-5 text-center mr-3"></i>
                        Potensi Desa
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.informasi.index') }}"
                        class="flex items-center px-5 py-3 text-gray-700 hover:bg-gray-200 transition-colors duration-200 {{ request()->routeIs('admin.informasi.index') ? 'bg-gray-600 text-white hover:bg-gray-700' : '' }}">
                        <i class="fas fa-info-circle w-5 text-center mr-3"></i>
                        Informasi
                    </a>
                </li>
                <li>
                    <a href=""
                        class="flex items-center px-5 py-3 text-gray-700 hover:bg-gray-200 transition-colors duration-200 {{ request()->routeIs('surat.*') ? 'bg-gray-600 text-white hover:bg-gray-700' : '' }}">
                        <i class="fas fa-envelope w-5 text-center mr-3"></i>
                        Surat Desa
                    </a>
                </li>
                <li class="mt-8">
                    <a href=""
                        class="flex items-center px-5 py-3 text-red-600 hover:bg-red-50 hover:text-red-800 transition-colors duration-200"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt w-5 text-center mr-3"></i>
                        Keluar
                    </a>
                    <form id="logout-form" action="" method="POST" class="hidden">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>


    <!-- Main Content -->
    <div class="ml-64 min-h-screen">
        <!-- Header -->
        <div class="gradient-header text-white p-6">
            <h2 class="text-2xl font-bold">@yield('page-title', 'Profile Desa')</h2>
        </div>

        <!-- Content Area -->
        <div class="p-6">
            <div class="bg-white rounded-lg content-shadow p-8">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                            onclick="this.parentElement.style.display='none'">
                            <i class="fas fa-times"></i>
                        </span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                            onclick="this.parentElement.style.display='none'">
                            <i class="fas fa-times"></i>
                        </span>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
