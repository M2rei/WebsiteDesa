@extends('layout.sidebar')

@section('title', 'Profile Desa - Sistem Informasi Desa')
@section('page-title', 'Profile Desa')

@section('content')
    <form action="{{ route('admin.profile.update', $profiledesa->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <h4 class="text-lg font-semibold text-gray-700 mb-4">Profile Desa</h4>
            <textarea id="profile_desa" name="profile_desa"
                class="w-full px-4 py-3 border rounded-lg @error('profile_desa') border-red-500 @enderror" rows="8">{{ old('profile_desa', $profiledesa->profile_desa ?? '') }}</textarea>
            @error('profile_desa')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-700 mb-4">Sejarah</h4>
            <textarea id="sejarah" name="sejarah"
                class="w-full px-4 py-3 border rounded-lg @error('sejarah') border-red-500 @enderror" rows="8">{{ old('sejarah', $profiledesa->sejarah ?? '') }}</textarea>
            @error('sejarah')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-700 mb-4">Visi</h4>
            <textarea id="visi" name="visi"
                class="w-full px-4 py-3 border rounded-lg @error('visi') border-red-500 @enderror" rows="8">{{ old('visi', $profiledesa->visi ?? '') }}</textarea>
            @error('visi')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-700 mb-4">Misi</h4>
            <textarea id="misi" name="misi"
                class="w-full px-4 py-3 border rounded-lg @error('misi') border-red-500 @enderror" rows="8">{{ old('misi', $profiledesa->misi ?? '') }}</textarea>
            @error('misi')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <h4 class="text-lg font-semibold text-gray-700 mb-2 mt-3">No Telepon Desa</h4>
            <input type="text" id="nomor_telepon" name="nomor_telepon"
                value="{{ old('nomor_telepon', $profiledesa->nomor_telepon ?? '') }}"
                class="w-full px-4 py-3 border rounded-lg @error('nomor_telepon') border-red-500 @enderror" />
            @error('nomor_telepon')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-700 mb-2 mt-3">Email Desa</h4>
            <input type="email" id="email" name="email" value="{{ old('email', $profiledesa->email ?? '') }}"
                class="w-full px-4 py-3 border rounded-lg @error('email') border-red-500 @enderror" />
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>


        <!-- Logo Upload Section -->
        <div>
            <div class="upload-area border-2 border-dashed border-blue-400 rounded-lg p-12 text-center bg-blue-50 hover:bg-blue-100 cursor-pointer mt-4"
                onclick="document.getElementById('logo-input').click()">
                <div class="text-blue-500 mb-4">
                    <i class="fas fa-cloud-upload-alt text-5xl"></i>
                </div>
                <p class="text-gray-700 font-medium mb-2">Unggah foto Logo</p>
                <p class="text-gray-500 text-sm">Klik untuk memilih file atau drag & drop</p>
                <input type="file" id="logo-input" name="logo" accept="image/*" class="hidden"
                    onchange="previewLogo(this)">
            </div>
            @error('logo')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if (!empty($profiledesa->logo_url))
                <div class="text-center mt-6">
                    <img src="{{ asset('storage/' . $profiledesa->logo_url) }}" alt="Logo Desa"
                        class="mx-auto rounded-lg border border-gray-200 shadow-sm" style="max-height: 200px;">
                    <p class="text-gray-500 text-sm mt-2">Logo saat ini</p>
                </div>
            @endif
            <div id="logo-preview" class="text-center mt-6 hidden">
                <img id="preview-image" src="/placeholder.svg" alt="Preview Logo"
                    class="mx-auto rounded-lg border border-gray-200 shadow-sm" style="max-height: 200px;">
                <p class="text-gray-500 text-sm mt-2">Preview logo baru</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-4 pt-6">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-medium hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center">
                <i class="fas fa-save mr-2"></i>
                Simpan
            </button>
            {{-- <a href=""
                class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-3 rounded-full font-medium hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center">
                <i class="fas fa-times mr-2"></i>
                Batal
            </a> --}}
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        // Logo preview
        function previewLogo(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('logo-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Drag and Drop
        const uploadArea = document.querySelector('.upload-area');
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.replace('bg-blue-50', 'bg-blue-100');
        });
        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.replace('bg-blue-100', 'bg-blue-50');
        });
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.replace('bg-blue-100', 'bg-blue-50');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('logo-input').files = files;
                previewLogo(document.getElementById('logo-input'));
            }
        });
    </script>
@endpush
