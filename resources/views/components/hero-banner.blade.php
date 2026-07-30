@props(['title', 'subtitle' => null, 'image' => 'image/background/2.JPG'])

<section class="relative bg-primary-800 text-white overflow-hidden min-h-[320px] flex items-center">
    <img src="{{ asset($image) }}" alt="" width="1500" height="1000"
        class="absolute inset-0 z-0 w-full h-full object-cover opacity-50">
    <div class="relative z-10 container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold {{ $subtitle ? 'mb-6' : '' }}">{{ $title }}</h1>
            @if ($subtitle)
                <p class="text-xl text-blue-200">{{ $subtitle }}</p>
            @endif
        </div>
    </div>
</section>
