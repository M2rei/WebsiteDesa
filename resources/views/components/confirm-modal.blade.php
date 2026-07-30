@props([
    'id',
    'formId',
    'title',
    'description',
    'confirmLabel' => 'Ya',
    'cancelLabel' => 'Batal',
    'color' => 'red',
    'method' => 'DELETE',
    'action' => '',
])

@php
    $palette = $color === 'green'
        ? ['bg-green-100', 'text-green-600', 'bg-green-600', 'hover:bg-green-700']
        : ['bg-red-100', 'text-red-600', 'bg-red-600', 'hover:bg-red-700'];
@endphp

<div id="{{ $id }}" class="fixed inset-0 bg-gray-600/50 hidden z-50 items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex items-center mb-4">
            <div class="flex-shrink-0 w-10 h-10 rounded-full {{ $palette[0] }} flex items-center justify-center">
                <i class="fas fa-exclamation-triangle {{ $palette[1] }}"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
                <p class="text-sm text-gray-500">{{ $description }}</p>
            </div>
        </div>
        <div class="flex justify-end space-x-3">
            <button type="button"
                onclick="document.getElementById('{{ $id }}').classList.add('hidden'); document.getElementById('{{ $id }}').classList.remove('flex')"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                {{ $cancelLabel }}
            </button>
            <form id="{{ $formId }}" method="POST" action="{{ $action }}">
                @csrf
                @if (strtoupper($method) !== 'POST')
                    @method($method)
                @endif
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white {{ $palette[2] }} border border-transparent rounded-md {{ $palette[3] }}">
                    {{ $confirmLabel }}
                </button>
            </form>
        </div>
    </div>
</div>
