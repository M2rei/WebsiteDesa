<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Sistem Informasi Desa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="min-h-screen bg-gray-50">
    <div class="max-w-md mx-auto mt-20 bg-white p-8 shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold mb-4 text-center">
            {{ $token ? 'Reset Password' : 'Lupa Password' }}
        </h2>

        @if (session('status'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        @if ($token)
            <form method="POST" action="{{ route('password.custom.reset') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <input type="hidden" name="email" value="{{ $email }}">
                <p class="text-sm mb-4 text-gray-500">Reset password untuk <strong>{{ $email }}</strong></p>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-pink-500 focus:border-pink-500">
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-pink-500 focus:border-pink-500">
                </div>

                <button type="submit"
                    class="w-full bg-pink-600 text-white py-2 rounded-lg hover:bg-pink-700 transition">
                    Reset Password
                </button>
            </form>
        @else
            <form method="POST" action="{{ route('password.custom.email') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-pink-500 focus:border-pink-500"
                        placeholder="Masukkan email yang terdaftar">
                </div>

                <button type="submit"
                    class="w-full bg-pink-600 text-white py-2 rounded-lg hover:bg-pink-700 transition">
                    Kirim Link Reset
                </button>
            </form>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 mt-4 p-3 rounded">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</body>

</html>
