{{-- resources/views/gallery/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Galeri - Pesona Simfoni Bambu')

@section('content')

    {{-- 1. STYLES: LUXURY MOSAIC STYLE --}}
    @push('styles')
        <style>
            :root {
                --indigo-deep: #1a1445;
                --gold-premium: #c4a47c;
                --v-gray: #f8f8f7;
                  --bg-premium: #F7F7F2;
            }

            body {
                font-family: 'Inter', sans-serif;
                color: var(--indigo-deep);
                background-color: var(--bg-premium);
            }

            .font-editorial {
                font-family: 'Libre Baskerville', serif;
            }

            .font-spirax {
                font-family: 'Spirax', cursive;
            }

            .text-spacing-sm {
                text-transform: uppercase;
                letter-spacing: 0.3em;
                font-size: 0.65rem;
                font-weight: 700;
            }

            .text-spacing-lg {
                text-transform: uppercase;
                letter-spacing: 0.5em;
                font-size: 0.75rem;
                font-weight: 800;
            }

            /* Reveal System */
            .reveal {
                opacity: 0;
                transform: translateY(30px);
                transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1);
                visibility: hidden;
            }

            .reveal.active {
                opacity: 1 !important;
                transform: translateY(0) !important;
                visibility: visible !important;
            }

            /* Modern Filter Link Style */
            .filter-link {
                background: transparent;
                color: var(--indigo-deep);
                border-bottom: 2px solid transparent;
                padding: 0.5rem 0;
                font-size: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.2em;
                transition: all 0.3s ease;
            }

            .filter-link.active {
                border-bottom-color: var(--gold-premium);
                color: var(--gold-premium);
            }

            .filter-link:hover {
                color: var(--gold-premium);
            }

            /* Mosaic Card Effect */
            .mosaic-item {
                position: relative;
                overflow: hidden;
                background: #f0f0f0;
                cursor: pointer;
            }

            .mosaic-item img {
                transition: transform 1.5s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .mosaic-item:hover img {
                transform: scale(1.08);
            }

            .mosaic-overlay {
                position: absolute;
                inset: 0;
                background: rgba(26, 20, 69, 0.4);
                opacity: 0;
                transition: opacity 0.5s ease;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .mosaic-item:hover .mosaic-overlay {
                opacity: 1;
            }

            /* Masonry-like Grid Heights */
            .aspect-tall {
                aspect-ratio: 3/4.5;
            }

            .aspect-wide {
                aspect-ratio: 16/9;
            }

            .aspect-square {
                aspect-ratio: 1/1;
            }

            section {
                margin: 0 !important;
            }
        </style>
    @endpush

    <!-- 1. CINEMATIC HERO -->
    <section class="relative h-[50vh] md:h-[60vh] flex items-center bg-[#1a1445] overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('img/performance.jpg') }}" class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#1a1445]/80"></div>
        </div>

        <div class="container mx-auto px-10 md:px-20 relative z-10 text-white text-center">
            <div class="max-w-4xl mx-auto">
                <p class="reveal text-spacing-lg text-gold-premium mb-6">Visual Storytelling</p>
                <h1 class="reveal font-editorial text-5xl md:text-8xl leading-tight italic" style="transition-delay: 200ms;">
                    Galeri <span class="not-italic font-normal">Momen</span>
                </h1>
            </div>
        </div>
    </section>

    <!-- 2. MINIMALIST NAVIGATION -->
    <section class="py-12 sticky top-20 z-40 border-b border-gray-50">
        <div class="container mx-auto px-10">
            <div class="flex flex-wrap justify-center gap-12">
                <a href="{{ route('gallery.index') }}" class="filter-link {{ $type === 'all' ? 'active' : '' }}">Semua</a>
                <a href="{{ route('gallery.index', ['type' => 'photo']) }}"
                    class="filter-link {{ $type === 'photo' ? 'active' : '' }}">Fotografi</a>
                <a href="{{ route('gallery.index', ['type' => 'video']) }}"
                    class="filter-link {{ $type === 'video' ? 'active' : '' }}">Sinematik</a>
            </div>
        </div>
    </section>

    <!-- 3. MOSAIC GALLERY GRID -->
    <section class="py-24 ">
        <div class="container mx-auto px-10 lg:px-20">
            <div class="columns-1 md:columns-2 lg:columns-3 gap-8 space-y-8">
                @foreach ($galleries as $index => $item)
                    <div class="reveal mosaic-item break-inside-avoid" style="transition-delay: {{ ($index % 3) * 100 }}ms;"
                        data-full-src="{{ asset('storage/' . $item->file_path) }}" data-title="{{ $item->title }}"
                        data-type="{{ $item->type }}">

                        <div class="relative overflow-hidden shadow-sm">
                            @if ($item->type === 'photo')
                                <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->title }}"
                                    class="w-full h-auto object-cover">
                            @else
                                <img src="{{ asset('storage/' . ($item->thumbnail ?? 'img/placeholder.jpg')) }}"
                                    alt="{{ $item->title }}" class="w-full h-auto object-cover">
                            @endif

                            <!-- Video Icon Overlay -->
                            @if ($item->type === 'video')
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div
                                        class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center ring-1 ring-white/30">
                                        <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                        </svg>
                                    </div>
                                </div>
                            @endif

                            <!-- Text Overlay -->
                            <div class="mosaic-overlay">
                                <div class="text-center p-6">
                                    <p class="text-white font-editorial text-xl italic">{{ $item->title }}</p>
                                    <span class="text-spacing-sm text-gold-premium mt-4 block">Lihat Detail</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination (Qatar Style) -->
            @if ($galleries->hasPages())
                <div class="mt-32 pt-12 border-t border-gray-100 flex justify-center">
                    {{ $galleries->links() }}
                </div>
            @endif
        </div>
    </section>

    <!-- 4. LIGHTBOX MODAL (CLEAN VERSION) -->
    <div id="lightbox" class="fixed inset-0 bg-[#1a1445]/98 z-[200] hidden items-center justify-center p-6 md:p-20">
        <button id="close-lightbox" class="absolute top-10 right-10 text-white hover:text-gold-premium transition-all">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-width="1.5" />
            </svg>
        </button>

        <div class="w-full h-full flex flex-col items-center justify-center">
            <div id="lightbox-media" class="max-w-7xl max-h-[80vh] w-full flex items-center justify-center overflow-hidden">
                <!-- Media injected here -->
            </div>
            <div class="mt-10 text-center text-white">
                <p id="lightbox-title" class="font-editorial text-3xl md:text-5xl italic text-gold-premium mb-4"></p>
                <div class="w-12 h-px bg-white/20 mx-auto"></div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Reveal Animation
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) entry.target.classList.add('active');
                    });
                }, {
                    threshold: 0.1
                });
                document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

                // Lightbox Logic
                const lightbox = document.getElementById('lightbox');
                const mediaContainer = document.getElementById('lightbox-media');
                const titleText = document.getElementById('lightbox-title');
                const closeBtn = document.getElementById('close-lightbox');

                document.querySelectorAll('.mosaic-item').forEach(item => {
                    item.addEventListener('click', () => {
                        const type = item.dataset.type;
                        const src = item.dataset.fullSrc;
                        const title = item.dataset.title;

                        if (type === 'photo') {
                            mediaContainer.innerHTML =
                                `<img src="${src}" class="max-w-full max-h-full object-contain animate-fade-in shadow-2xl">`;
                        } else {
                            // Assuming video file source, if YouTube needs iframe change here
                            mediaContainer.innerHTML =
                                `<video controls autoplay class="max-w-full max-h-full shadow-2xl"><source src="${src}" type="video/mp4"></video>`;
                        }

                        titleText.textContent = title;
                        lightbox.classList.replace('hidden', 'flex');
                        document.body.style.overflow = 'hidden';
                    });
                });

                const closeAction = () => {
                    lightbox.classList.replace('flex', 'hidden');
                    mediaContainer.innerHTML = '';
                    document.body.style.overflow = '';
                };

                closeBtn.addEventListener('click', closeAction);
                lightbox.addEventListener('click', (e) => {
                    if (e.target === lightbox) closeAction();
                });
            });
        </script>
    @endpush

@endsection
