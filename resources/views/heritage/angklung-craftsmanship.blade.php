{{-- resources/views/heritage/cara-membuat.blade.php --}}
@extends('layouts.app')

@section('title', 'Proses Pembuatan Angklung - Saung Angklung Udjo')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

        <style>
            :root {
                --indigo-deep: #1a1445;
                --gold-premium: #c4a47c;
                --soft-gray: #fcfcfb;
                --border-light: rgba(26, 20, 69, 0.08);
                --bg-premium: #F7F7F2;
            }

            .bg-indigo-950 { background-color: var(--indigo-deep); }
            .text-gold-premium { color: var(--gold-premium); }

            body {
                font-family: 'Inter', sans-serif;
                color: var(--indigo-deep);
                background: var(--bg-premium);
                overflow-x: hidden;
            }

            .font-editorial { font-family: 'Libre Baskerville', serif; }

            /* Reveal Animation */
            .reveal {
                opacity: 0;
                transform: translateY(30px);
                transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .reveal.active {
                opacity: 1;
                transform: translateY(0);
            }

            /* Badge */
            .badge-category {
                display: inline-block;
                padding: 6px 16px;
                background: var(--gold-premium);
                color: #fff;
                font-size: 10px;
                font-weight: 800;
                letter-spacing: 0.25em;
                text-transform: uppercase;
                margin-bottom: 1.5rem;
            }

            /* ==============================
               STEP INDICATOR (Progress Bar)
               ============================== */
            .step-indicator {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0;
                margin-bottom: 40px;
                overflow-x: auto;
                padding: 8px 16px;
                scrollbar-width: none;
            }
            .step-indicator::-webkit-scrollbar { display: none; }

            .step-dot-wrap {
                display: flex;
                align-items: center;
                cursor: pointer;
            }

            .step-dot {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                background: #e2e2dc;
                color: #aaa;
                font-size: 10px;
                font-weight: 800;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all .4s ease;
                border: 2px solid transparent;
                flex-shrink: 0;
            }
            .step-dot.active {
                background: var(--gold-premium);
                color: #fff;
                border-color: var(--gold-premium);
                transform: scale(1.2);
                box-shadow: 0 4px 12px rgba(196, 164, 124, 0.4);
            }
            .step-dot.passed {
                background: var(--indigo-deep);
                color: #fff;
            }

            .step-line {
                width: 28px;
                height: 2px;
                background: #e2e2dc;
                transition: background .4s ease;
                flex-shrink: 0;
            }
            .step-line.passed { background: var(--indigo-deep); }

            .step-counter {
                text-align: center;
                font-size: 0.75rem;
                color: #999;
                margin-top: 12px;
                letter-spacing: 0.15em;
            }
            .step-counter span {
                color: var(--gold-premium);
                font-weight: 700;
            }

            /* Swiper */
            .myProsesSwiper { padding: 50px 0 100px; }

            .swiper-slide {
                opacity: 0.55;
                transform: scale(0.85);
                transition: all .6s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .swiper-slide-active {
                opacity: 1;
                transform: scale(1);
            }

            .slide-card {
                background: #fff;
                border-radius: 16px;
                overflow: hidden;
                border: 1px solid var(--border-light);
                box-shadow: 0 30px 60px rgba(0, 0, 0, .05);
            }

            .slide-img-container {
                width: 100%;
                aspect-ratio: 4 / 3;
                overflow: hidden;
                background: #eee;
            }
            .slide-img-container img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            /* Swiper Controls */
            .swiper-button-next,
            .swiper-button-prev {
                background: #fff;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                color: var(--indigo-deep);
                box-shadow: 0 10px 20px rgba(0, 0, 0, .1);
            }
            .swiper-button-next:after,
            .swiper-button-prev:after {
                font-size: 18px;
                font-weight: bold;
            }

            .swiper-pagination-bullet {
                background: var(--indigo-deep);
                opacity: .3;
            }
            .swiper-pagination-bullet-active {
                background: var(--gold-premium);
                opacity: 1;
            }

            /* Video */
            .video-container {
                position: relative;
                padding-bottom: 56.25%;
                height: 0;
                overflow: hidden;
                border-radius: 4px;
                background: #000;
                box-shadow: 0 40px 80px rgba(0, 0, 0, .15);
            }
            .video-container iframe {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                border: 0;
            }

            /* ==============================
               MODAL — Prev/Next Navigation
               ============================== */
            .modal-nav-btn {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                background: rgba(255,255,255,0.12);
                border: 1px solid rgba(255,255,255,0.2);
                color: #fff;
                width: 48px;
                height: 48px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                z-index: 10001;
                transition: all .3s ease;
                backdrop-filter: blur(6px);
            }
            .modal-nav-btn:hover {
                background: var(--gold-premium);
                border-color: var(--gold-premium);
            }
            .modal-nav-prev { left: -64px; }
            .modal-nav-next { right: -64px; }

            .modal-step-indicator {
                display: flex;
                gap: 6px;
                justify-content: center;
                margin-top: 20px;
            }
            .modal-step-dot {
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: rgba(255,255,255,0.3);
                transition: all .3s;
            }
            .modal-step-dot.active {
                background: var(--gold-premium);
                width: 20px;
                border-radius: 3px;
            }

            /* MOBILE */
            @media (max-width: 768px) {
                .slide-img-container { aspect-ratio: 4 / 3; background: #f5f5f5; }
                section.relative.h-\[70vh\] { height: 85vh; }
                section.relative h1 { font-size: 2.7rem; line-height: 1.15; }
                section.relative p { font-size: 10px; letter-spacing: 0.35em; }
                section[style*="padding: 120px"] { padding: 80px 16px !important; }
                section h2.font-editorial { font-size: 1.9rem !important; line-height: 1.3; }
                section h2 span { display: block; margin-top: 8px; }
                section p { font-size: 0.95rem; padding: 0 12px; }
                .swiper-slide { transform: scale(0.95); }
                .swiper-slide-active { transform: scale(1); }
                .slide-card { border-radius: 16px; }
                .slide-card h3 { font-size: 1.4rem; }
                .slide-card p { font-size: 0.9rem; }
                .swiper-button-next, .swiper-button-prev { display: none; }
                .swiper-pagination { margin-top: 24px; }
                .modal-nav-prev { left: 8px; top: auto; bottom: -56px; transform: none; }
                .modal-nav-next { right: 8px; top: auto; bottom: -56px; transform: none; }
                .step-dot { width: 26px; height: 26px; font-size: 9px; }
                .step-line { width: 18px; }
            }
        </style>
    @endpush

    {{-- HERO --}}
    <section class="relative h-[70vh] flex items-center justify-center bg-indigo-950">
        <div class="absolute inset-0">
            <img src="{{ asset('img/soevenir.jpg') }}" class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-t from-indigo-950/80 to-transparent"></div>
        </div>
        <div class="relative text-center px-6">
            <p class="reveal text-[11px] tracking-[0.6em] font-bold uppercase text-gold-premium mb-6">
                The Master's Craftsmanship
            </p>
            <h1 class="reveal font-editorial text-5xl md:text-7xl text-white">
                Pembuatan<br>
                <span class="italic text-white/90">Angklung</span>
            </h1>
        </div>
    </section>

    <!-- VIDEO SECTION -->
    <section style="padding: 120px 0; background: var(--bg-premium);">
        <div class="v-container">
            <div class="reveal" style="text-align: center; margin-bottom: 48px;">
                <h2 class="font-editorial" style="font-size: 2.5rem; margin-top: 16px;">
                    Proses yang Dijalani <br>
                    <span style="font-style: italic; color: var(--gold-premium);">
                        dengan Kesabaran & Ketelitian
                    </span>
                </h2>
                <p style="max-width: 700px; margin: 24px auto 0; color: #777; line-height: 1.8;">
                    Setiap angklung tidak hanya dibuat, tetapi <em>dihidupkan</em> melalui tahapan
                    yang menjunjung harmoni antara manusia, alam, dan budaya.
                </p>
            </div>

            <div class="reveal" style="max-width: 1200px; margin: 0 auto;">
                <div style="position: relative; width: 100%; padding-bottom: 56.25%; background: #000;
                       border-radius: 12px; overflow: hidden;
                       box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
                    <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                        src="https://www.youtube.com/embed/ZA_6JKDif2Y?start=6" title="Saung Angklung Udjo" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen>
                    </iframe>
                </div>
                <p style="text-align: center; margin-top: 24px; font-size: 0.95rem;
                      color: #888; font-style: italic;">
                    "Suara angklung adalah resonansi antara alam dan jiwa manusia."
                </p>
            </div>
        </div>
    </section>

    {{-- SLIDER --}}
    <section class="py-24 md:py-32 bg-transparent">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-8 md:mb-12 reveal">
                <span class="text-[10px] tracking-[0.4em] uppercase font-bold text-indigo-900/40">Step by Step</span>
                <h2 class="font-editorial text-3xl md:text-5xl italic mt-4">9 Tahap Pembuatan Angklung</h2>
            </div>

            {{-- ✅ STEP INDICATOR --}}
            <div class="reveal">
                <div class="step-indicator" id="stepIndicator">
                    @for ($i = 1; $i <= 9; $i++)
                        <div class="step-dot-wrap" onclick="goToSlide({{ $i - 1 }})">
                            <div class="step-dot {{ $i === 1 ? 'active' : '' }}" id="stepDot{{ $i }}">
                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            @if ($i < 9)
                                <div class="step-line" id="stepLine{{ $i }}"></div>
                            @endif
                        </div>
                    @endfor
                </div>
                <p class="step-counter">Tahap <span id="stepCurrent">01</span> dari <span>09</span></p>
            </div>

            <div class="swiper myProsesSwiper reveal">
                <div class="swiper-wrapper">

                    @php
                        $steps = [
                            ['01', 'Pemilihan Bambu',
                             'Tidak semua bambu layak menjadi angklung. Pengrajin memilih bambu hitam (Gigantochloa atroviolacea) atau bambu tali yang berusia minimal 4–6 tahun — cukup tua untuk keras, namun belum lapuk. Setiap ruas diperiksa dengan teliti; hanya yang lurus dan bebas cacat yang dipilih.',
                             'proses-1-jenis-bambu.png'],
                            ['02', 'Penebangan Bijak',
                             'Penebangan dilakukan saat musim kemarau, ketika kadar air dalam bambu berada di titik terendah. Ini mencegah bambu menjadi tempat berkembang biak serangga dan jamur. Waktu penebangan pun diperhitungkan — umumnya pagi hari sebelum matahari terik untuk menjaga kualitas serat.',
                             '2.png'],
                            ['03', 'Teknik Diunun',
                             'Bambu yang baru ditebang diasapi menggunakan teknik tradisional bernama "diunun". Proses pengasapan ini bertujuan mengeluarkan kadar air sisa dan memperkuat struktur serat bambu, sehingga lebih tahan terhadap perubahan cuaca dan serangan hama jangka panjang.',
                             '3.png'],
                            ['04', 'Proteksi Hama',
                             'Setelah diasapi, bambu disimpan di tempat yang teduh dan berventilasi baik selama minimal 6 bulan. Proses pengeringan alami ini memastikan bambu benar-benar kering hingga ke bagian terdalam, sehingga tidak mudah retak dan stabil secara dimensi saat dibentuk.',
                             '4.png'],
                            ['05', 'Pembuatan Bakalan',
                             'Bambu yang sudah matang dipotong dan dibentuk sesuai pola nada yang diinginkan. Setiap tabung (lodong) dipotong dengan panjang yang berbeda karena panjang tabung menentukan tinggi-rendahnya nada. Presisi di tahap ini sangat krusial — selisih beberapa milimeter pun dapat mengubah nada.',
                             '5.png'],
                            ['06', 'Penalaan',
                             'Ini adalah inti dari seni membuat angklung. Pengrajin ahli menggunakan pendengarannya yang terlatih — kadang dibantu tuner digital — untuk menyetel setiap tabung ke nada yang tepat. Bagian dalam tabung dikerok atau ditambahkan material kecil untuk mencapai frekuensi yang presisi.',
                             '6.png'],
                            ['07', 'Perakitan',
                             'Dua atau tiga tabung bambu bernada yang sudah selesai dirakit bersama dalam sebuah rangka bambu menggunakan tali rotan. Teknik pengikatan rotan ini bukan sekadar fungsional — ia juga memberikan karakter visual khas angklung yang organik dan estetik, sekaligus memungkinkan tabung bergetar bebas saat digoyangkan.',
                             '7.png'],
                            ['08', 'Quality Control',
                             'Angklung yang sudah dirakit tidak langsung dijual. Ia disimpan selama sekitar 2 bulan dalam kondisi suhu ruang normal untuk proses stabilisasi nada alami. Setiap unit kemudian diperiksa ulang secara menyeluruh — nada, kekuatan rangka, dan kerapian ikatan rotan — sebelum dinyatakan lolos.',
                             '8.png'],
                            ['09', 'Harmoni Budaya',
                             'Angklung yang telah lolos seleksi siap menjadi bagian dari warisan budaya yang hidup. Setiap instrumen membawa kisah panjang — dari rumpun bambu di lereng gunung, tangan para pengrajin yang penuh dedikasi, hingga panggung-panggung dunia di mana angklung pernah memukau jutaan pendengar.',
                             '9.png'],
                        ];
                    @endphp

                    @foreach ($steps as $index => $s)
                        <div class="swiper-slide px-4">
                            <div class="slide-card text-center group cursor-zoom-in"
                                onclick="openProsesModal({{ $index }})">

                                <div class="slide-img-container overflow-hidden rounded-xl relative">
                                    <img src="{{ asset('makeangklung/' . $s[3]) }}" alt="{{ $s[1] }}"
                                        class="transition-transform duration-700 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-indigo-950/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </div>

                                <div class="p-10">
                                    <span class="text-[10px] tracking-[0.3em] font-black text-gold-premium uppercase">
                                        Tahap {{ $s[0] }}
                                    </span>
                                    <h3 class="font-editorial text-2xl mt-2 mb-4">{{ $s[1] }}</h3>
                                    {{-- Deskripsi singkat di card --}}
                                    <p class="text-sm text-gray-500">{{ Str::limit($s[2], 100) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination mt-10"></div>
            </div>
        </div>
    </section>

    <!-- ✅ CTA SECTION — Tombol lebih spesifik -->
    <section class="py-32 bg-indigo-950 text-center text-white relative overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('img/performance.jpg') }}" alt="Bamboo background"
                class="w-full h-full object-cover opacity-100" />
            <div class="absolute inset-0 bg-gradient-to-b from-indigo-950/80 via-indigo-950/60 to-indigo-950/80"></div>
        </div>

        <div class="reveal px-6 relative z-10">
            <h2 class="font-editorial text-4xl md:text-6xl lg:text-7xl italic mb-6 leading-tight drop-shadow-2xl">
                Siap untuk merasakan <br>keharmonisan bambu?
            </h2>
            <p class="text-white/60 text-base md:text-lg mb-10 max-w-xl mx-auto">
                Kunjungi workshop kami dan saksikan langsung bagaimana setiap nada dilahirkan dari tangan para pengrajin.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                {{-- Ganti '#' dengan route yang sesuai, contoh: route('contact.index') --}}
                
            </div>
        </div>
    </section>

    @php
        $stepsData = array_map(fn($s) => [
            'img'   => asset('makeangklung/' . $s[3]),
            'title' => $s[1],
            'step'  => 'Tahap ' . $s[0],
            'desc'  => $s[2],
        ], $steps);
    @endphp

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            // ===== DATA STEPS untuk Modal =====
            const stepsData = @json($stepsData);

            let currentModalIndex = 0;

            // ===== SWIPER =====
            let swiperInstance;

            document.addEventListener('DOMContentLoaded', () => {
                swiperInstance = new Swiper('.myProsesSwiper', {
                    effect: 'coverflow',
                    centeredSlides: true,
                    slidesPerView: 'auto',
                    coverflowEffect: {
                        rotate: 0,
                        stretch: 80,
                        depth: 200,
                        modifier: 1,
                        slideShadows: false,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        320: { slidesPerView: 1.1 },
                        480: { slidesPerView: 1.3 },
                        768: { slidesPerView: 2 },
                        1024: { slidesPerView: 2.5 },
                    },
                    on: {
                        // ✅ Update step indicator saat slide berubah
                        slideChange: function () {
                            updateStepIndicator(this.realIndex);
                        }
                    }
                });

                // Reveal
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('active');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });
                document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
            });

            // ===== STEP INDICATOR =====
            function updateStepIndicator(activeIndex) {
                const total = 9;
                for (let i = 1; i <= total; i++) {
                    const dot = document.getElementById('stepDot' + i);
                    const line = document.getElementById('stepLine' + i);
                    dot.classList.remove('active', 'passed');
                    if (line) line.classList.remove('passed');

                    if (i - 1 < activeIndex) {
                        dot.classList.add('passed');
                        if (line) line.classList.add('passed');
                    } else if (i - 1 === activeIndex) {
                        dot.classList.add('active');
                    }
                }
                document.getElementById('stepCurrent').textContent = String(activeIndex + 1).padStart(2, '0');
            }

            function goToSlide(index) {
                swiperInstance.slideTo(index);
            }

            // ===== MODAL =====
            function openProsesModal(index) {
                currentModalIndex = index;
                renderModal(index);

                const modal = document.getElementById('prosesModal');
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                const img = document.getElementById('prosesModalImg');
                const contentEl = document.getElementById('prosesModalContent');
                setTimeout(() => {
                    img.classList.remove('scale-95');
                    img.classList.add('scale-100');
                    contentEl.classList.remove('opacity-0', 'translate-y-4');
                    contentEl.classList.add('opacity-100', 'translate-y-0');
                }, 50);
            }

            function renderModal(index) {
                const s = stepsData[index];
                const img = document.getElementById('prosesModalImg');
                const titleEl = document.getElementById('prosesModalTitle');
                const stepEl = document.getElementById('prosesModalStep');
                const descEl = document.getElementById('prosesModalDesc');

                img.src = s.img;
                titleEl.innerText = s.title;
                stepEl.innerText = s.step;
                descEl.innerText = s.desc;

                // Update modal dots
                document.querySelectorAll('.modal-step-dot').forEach((dot, i) => {
                    dot.classList.toggle('active', i === index);
                });

                // Update prev/next button visibility
                document.getElementById('modalPrev').style.opacity = index === 0 ? '0.3' : '1';
                document.getElementById('modalPrev').style.pointerEvents = index === 0 ? 'none' : 'auto';
                document.getElementById('modalNext').style.opacity = index === stepsData.length - 1 ? '0.3' : '1';
                document.getElementById('modalNext').style.pointerEvents = index === stepsData.length - 1 ? 'none' : 'auto';
            }

            function navigateModal(direction) {
                const newIndex = currentModalIndex + direction;
                if (newIndex < 0 || newIndex >= stepsData.length) return;

                const img = document.getElementById('prosesModalImg');
                const contentEl = document.getElementById('prosesModalContent');

                // Animasi out
                img.classList.add('scale-95');
                contentEl.classList.add('opacity-0', 'translate-y-4');

                setTimeout(() => {
                    currentModalIndex = newIndex;
                    renderModal(newIndex);
                    img.classList.remove('scale-95');
                    img.classList.add('scale-100');
                    contentEl.classList.remove('opacity-0', 'translate-y-4');
                    contentEl.classList.add('opacity-100', 'translate-y-0');
                }, 250);
            }

            function closeProsesModal() {
                const modal = document.getElementById('prosesModal');
                const img = document.getElementById('prosesModalImg');
                const contentEl = document.getElementById('prosesModalContent');

                img.classList.remove('scale-100');
                img.classList.add('scale-95');
                contentEl.classList.add('opacity-0', 'translate-y-4');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }, 300);
            }

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeProsesModal();
                if (e.key === 'ArrowRight') navigateModal(1);
                if (e.key === 'ArrowLeft') navigateModal(-1);
            });
        </script>
    @endpush

    <!-- MODAL PROSES PEMBUATAN LIGHTBOX -->
    <div id="prosesModal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center p-4 md:p-10">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-[#1a1445]/90 backdrop-blur-xl" onclick="closeProsesModal()"></div>

        <!-- Tombol Close -->
        <button onclick="closeProsesModal()"
            class="absolute top-6 right-6 text-white hover:text-gold-premium transition-colors z-[10000]">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>

        <!-- Konten Modal -->
        <div class="relative z-[10000] max-w-5xl w-full flex flex-col items-center">

            <!-- Wrapper gambar + tombol nav -->
            <div class="relative w-full flex items-center justify-center">

                {{-- ✅ TOMBOL PREV --}}
                <button id="modalPrev" class="modal-nav-btn modal-nav-prev" onclick="navigateModal(-1)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <img id="prosesModalImg" src=""
                    class="max-h-[60vh] w-auto object-contain shadow-2xl rounded-2xl scale-95 transition-transform duration-500">

                {{-- ✅ TOMBOL NEXT --}}
                <button id="modalNext" class="modal-nav-btn modal-nav-next" onclick="navigateModal(1)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>

            {{-- ✅ MODAL STEP DOTS --}}
            <div class="modal-step-indicator">
                @for ($i = 0; $i < 9; $i++)
                    <div class="modal-step-dot {{ $i === 0 ? 'active' : '' }}"></div>
                @endfor
            </div>

            <div id="prosesModalContent"
                class="text-center text-white opacity-0 translate-y-4 transition-all duration-500 delay-100 mt-6">
                <span id="prosesModalStep" class="text-gold-premium font-bold tracking-[0.3em] uppercase text-xs"></span>
                <h3 id="prosesModalTitle" class="font-editorial text-3xl md:text-4xl mt-2 mb-4"></h3>
                {{-- ✅ Deskripsi lengkap di modal --}}
                <p id="prosesModalDesc" class="text-white/70 font-inter max-w-2xl mx-auto leading-relaxed text-sm md:text-base"></p>
                <p class="text-white/30 text-xs mt-4">← → untuk navigasi antar tahap</p>
            </div>
        </div>
    </div>

@endsection