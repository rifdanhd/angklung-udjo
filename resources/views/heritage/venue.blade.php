{{-- resources/views/venue.blade.php --}}
@extends('layouts.app')

@section('title', 'Venue & Lokasi - Saung Angklung Udjo')

@section('content')

    {{-- STYLES --}}
    @push('styles')
        <style>
            :root {
                --indigo-deep: #1a1445;
                --gold-premium: #c4a47c;
                --v-gray: #f8f8f7;
                --bg-premium: #FAF8F4;
            }

            body {
                font-family: 'Inter', sans-serif;
                color: var(--indigo-deep);
                background-color: var(--bg-premium) !important;
            }

            .font-editorial {
                font-family: 'Libre Baskerville', serif;
            }

            .font-spirax {
                font-family: 'Spirax', cursive;
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

            /* Full Bleed Slider Logic */
            .full-bleed-right {
                padding-left: max(1.5rem, calc((100vw - 1440px) / 2 + 3rem));
            }

            .snap-slider {
                display: flex;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                scroll-behavior: smooth;
                -webkit-overflow-scrolling: touch;
                padding-right: 10vw;
            }

            .snap-slider::-webkit-scrollbar {
                display: none;
            }

            .snap-item {
                scroll-snap-align: start;
                flex: 0 0 auto;
            }

            /* Qatar Card Style */
            .qatar-card {
                position: relative;
                aspect-ratio: 3/4.5;
                overflow: hidden;
                border-radius: 1rem;
                background: var(--indigo-deep);
            }

            .qatar-card img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 1.5s ease;
                opacity: 0.85;
            }

            .qatar-card:hover img {
                transform: scale(1.1);
            }

            .qatar-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(to top, rgba(26, 20, 69, 0.9) 0%, rgba(26, 20, 69, 0.2) 50%, transparent 100%);
                padding: 2.5rem;
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                color: white;
            }

            /* Journey Steps (Custom for Visitor Flow) */
            .journey-step {
                border-left: 1px solid rgba(26, 20, 69, 0.1);
                padding: 0 0 40px 30px;
                position: relative;
            }

            .journey-step::before {
                content: '';
                position: absolute;
                left: -5px;
                top: 0;
                width: 10px;
                height: 10px;
                background: #82bc41;
                /* Warna hijau sesuai Visitor Flow */
                border-radius: 50%;
                box-shadow: 0 0 10px rgba(130, 188, 65, 0.5);
            }
        </style>
    @endpush

    <!-- 1. HERO SECTION -->
    <section class="relative h-[70vh] bg-black overflow-hidden flex items-center">
        <img src="{{ asset('images/Lokasi.webp') }}" class="absolute inset-0 w-full h-full object-cover opacity-60">
        <div class="absolute inset-0 bg-gradient-to-t from-[#1a1445] via-transparent to-transparent z-[1]"></div>
        <div class="relative z-10 max-w-[1400px] mx-auto px-10 md:px-20 text-white w-full">
       
            <h1 class="reveal font-editorial text-4xl md:text-7xl leading-tight tracking-tight uppercase">
                Venue & <br> <span class="italic font-normal">Denah Lokasi</span>
            </h1>
        </div>
    </section>


   <!-- 5. MAPS SECTION -->
    <section class="py-24">
        <div id="mapslokasi"
        <div class="max-w-[1400px] mx-auto px-10">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <div class="reveal">
                    <p class="text-[10px] font-bold tracking-[0.4em] text-gray-400 uppercase mb-6">Lokasi & Navigasi</p>
                    <h2 class="font-editorial text-4xl text-indigo-950 mb-8  tracking-tighter">Saung Angklung<span
                            class="italic font-normal text-gold-premium"> Udjo</span></h2>
                    <p class="text-gray-500 font-light leading-relaxed mb-10">
                        Jl. Padasuka No. 118, Pasirlayung, Bandung. Terletak di kawasan yang sejuk dan mudah dijangkau
                        melalui jalur utama Cicaheum.
                    </p>
                    <a href="https://www.google.com/maps/dir//Saung+Angklung+Udjo..." target="_blank"
                        class="inline-flex items-center gap-6 text-[10px] font-bold tracking-[0.4em] uppercase text-indigo-950 group">
                        <span>Lihat Arah Jalan</span>
                        <div
                            class="w-12 h-px bg-indigo-950/20 group-hover:w-20 group-hover:bg-gold-premium transition-all">
                        </div>
                    </a>
                </div>
                <div
                    class="reveal h-[500px] rounded-[2.5rem] overflow-hidden shadow-2xl grayscale hover:grayscale-0 transition-all duration-1000">
                  <iframe
    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5083.5680509058475!2d107.65527462365527!3d-6.89825314442758!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e7904f868405%3A0xefbc33f025ba4c9c!2sSaung%20Angklung%20Udjo!5e0!3m2!1sid!2sid!4v1772987070362!5m2!1sid!2sid"
    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
    referrerpolicy="no-referrer-when-downgrade">
</iframe>
                </div>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-10 mt-12 text-center reveal">
        <a href="https://www.google.com/maps/dir//Saung+Angklung+Udjo..." target="_blank"
            class="inline-block px-12 py-5 bg-indigo-950 text-white text-[10px] font-bold uppercase tracking-[0.3em] hover:bg-gold-premium transition-all shadow-xl">
            Buka di Google Maps
        </a>
    </div>



    <!-- 2. VENUE SLIDER (GESSER STYLE) -->
    <section class="py-32 overflow-hidden">
        <div class="full-bleed-right">
            <div class="grid lg:grid-cols-12 gap-10 items-start">
                <div class="lg:col-span-3 pr-10 reveal">
                    <p class="text-[10px] font-bold tracking-[0.4em] text-gray-400 uppercase mb-6">Discovery</p>
                    <h2 class="font-editorial text-4xl md:text-5xl text-indigo-950 leading-tight mb-8">
                        Sudut <br> <span class="text-gold-premium italic font-normal">Budaya</span>
                    </h2>
                    <p class="text-gray-400 text-base font-light leading-relaxed mb-10">
                        Dari denting angklung di panggung utama hingga keheningan taman bambu, temukan harmoni di setiap
                        ruang kami.
                    </p>
                    <div class="flex gap-3 mt-12">
                        <button onclick="scrollVenue('left')"
                            class="w-14 h-14 rounded-full border border-gray-200 text-indigo-950 hover:bg-gray-100 transition flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button onclick="scrollVenue('right')"
                            class="w-14 h-14 rounded-full border border-gray-200 text-indigo-950 hover:bg-gray-100 transition flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 5l7 7-7 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="lg:col-span-9">
                    <div id="venueSlider" class="snap-slider gap-6">
                        @php
                            $venues = [
                                [
                                    'cat' => 'PERFORMANCE',
                                    'title' => 'Bale Karesemen',
                                    'img' => 'performance.jpg',
                                    'desc' => 'Amfiteater ikonik tempat mahakarya angklung bergema.',
                                ],
                                [
                                    'cat' => 'WORKSHOP',
                                    'title' => 'Angklung Workshop',
                                    'img' => 'VenueAngklung.jpeg',
                                    'desc' => 'Melihat proses manual pembuatan instrumen bambu kelas dunia.',
                                ],
                                [
                                    'cat' => 'DINING',
                                    'title' => 'Dapoer Angklung',
                                    'img' => 'Dapoer_Angklung.jpeg',
                                    'desc' => 'Cita rasa otentik Sunda di tengah suasana yang asri.',
                                ],
                                [
                                    'cat' => 'SHOPPING',
                                    'title' => 'Souvenir Shop',
                                    'img' => 'SouvenirSHOP.jpeg',
                                    'desc' => 'Bawa pulang sepotong budaya melalui kerajinan bambu pilihan.',
                                ],
                            ];
                        @endphp
                        @foreach ($venues as $v)
                            <div class="snap-item w-[80%] md:w-[40%] group cursor-pointer">
                                <div class="qatar-card">
                                    <img src="{{ asset('img/' . $v['img']) }}">
                                    <div class="qatar-overlay">
                                        <p class="text-[9px] font-bold text-gold-premium uppercase tracking-[0.3em] mb-3">
                                            {{ $v['cat'] }}</p>
                                        <h3 class="font-editorial text-2xl md:text-3xl leading-tight mb-2">
                                            {{ $v['title'] }}</h3>
                                        <p class="text-[10px] opacity-70 font-light mb-6">{{ $v['desc'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    
 

    <br>
    <br>
    <br>
    <br>
    <br>

    <!-- 3. DENAH LOKASI SECTION DENGAN VR TOUR EMBEDDED -->
    <section class="py-24 bg-v-gray">
        <div class="max-w-[1400px] mx-auto px-10">
            <div class="text-center mb-20 reveal">
                <h2 class="font-editorial text-4xl md:text-6xl text-indigo-950 mb-4 uppercase tracking-tight">Peta & Virtual
                    Tour</h2>
                <div class="w-20 h-1 bg-gold-premium mx-auto"></div>
                <p class="mt-4 text-gray-400 font-inter text-sm tracking-widest uppercase">Jelajahi lokasi secara interaktif
                </p>
            </div>

            <!-- DENAH + KETERANGAN -->
            <div class="grid lg:grid-cols-12 gap-16 items-center mb-20">
                <!-- SISI KIRI: GAMBAR DENAH -->
                <div class="lg:col-span-7 reveal">
                    <div class="relative group cursor-zoom-in" onclick="openMapModal()">
                        <div
                            class="bg-white p-4 md:p-8 rounded-[2rem] shadow-2xl transition-transform duration-700 group-hover:scale-[1.02]">
                            <img src="{{ asset('images/A4wSIGN.jpg') }}" alt="Denah Saung Angklung Udjo"
                                class="w-full h-auto rounded-xl">
                        </div>
                        <!-- Icon Zoom Overlay -->
                        <div
                            class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            <div class="bg-indigo-950/20 backdrop-blur-md p-4 rounded-full text-white">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SISI KANAN: KETERANGAN -->
                <div class="lg:col-span-5 reveal">
                    <div class="space-y-2">
                        <div class="journey-step">
                            <h3 class="font-editorial text-xl text-indigo-950 mb-1 uppercase">01. Kedatangan & Parkir</h3>
                            <p class="text-gray-400 text-sm font-light text-justify">Fasilitas parkir luas yang terpisah
                                untuk Bus Pariwisata, Mobil Pribadi, dan Sepeda Motor di area depan.</p>
                        </div>
                        <div class="journey-step">
                            <h3 class="font-editorial text-xl text-indigo-950 mb-1 uppercase">02. Ticketing & Souvenir</h3>
                            <p class="text-gray-400 text-sm font-light text-justify">Masuk melalui gerbang utama menuju area
                                Ticketing dan Souvenir Shop untuk persiapan kunjungan.</p>
                        </div>
                        <div class="journey-step">
                            <h3 class="font-editorial text-xl text-indigo-950 mb-1 uppercase">03. Dapoer Angklung & Workshop
                            </h3>
                            <p class="text-gray-400 text-sm font-light text-justify">Menuju area kuliner (F&B Area) atau
                                mengeksplorasi pembuatan angklung di Workshop Area yang asri.</p>
                        </div>
                        <div class="journey-step">
                            <h3 class="font-editorial text-xl text-indigo-950 mb-1 uppercase">04. Performance Area</h3>
                            <p class="text-gray-400 text-sm font-light text-justify">Pusat dari alur kunjungan, di mana
                                pertunjukan utama digelar di balai bambu yang megah.</p>
                        </div>
                        <div class="journey-step !pb-0 !border-transparent">
                            <h3 class="font-editorial text-xl text-indigo-950 mb-1 uppercase">05. Mushola & Restroom</h3>
                            <p class="text-gray-400 text-sm font-light text-justify">Titik akhir alur pengunjung yang
                                dilengkapi dengan fasilitas Mushola dan toilet bersih.</p>
                        </div>
                    </div>
                </div>
            </div>


    <!-- MODAL MAP LIGHTBOX (Existing) -->
    <div id="mapModal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center p-4 md:p-10">
        <div class="absolute inset-0 bg-[#1a1445]/95 backdrop-blur-xl" onclick="closeMapModal()"></div>
        <button onclick="closeMapModal()"
            class="absolute top-6 right-6 md:top-10 md:right-10 text-white hover:text-gold-premium transition-colors z-[10000]">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
        <div class="relative z-[10000] max-w-full max-h-full flex items-center justify-center">
            <img id="modalImg" src="{{ asset('images/A4wSIGN.jpg') }}"
                class="max-w-[95vw] max-h-[90vh] object-contain shadow-2xl rounded-lg scale-90 transition-transform duration-500">
        </div>
    </div>

  

    <!-- JavaScript -->
    <script>
        // Hide loading when embedded iframe loads
        document.getElementById('vrEmbedded').onload = function() {
            setTimeout(() => {
                const loading = document.getElementById('vrLoadingEmbed');
                loading.style.opacity = '0';
                setTimeout(() => loading.style.display = 'none', 500);
            }, 1000);
        };

        function openVRFullscreen() {
            const modal = document.getElementById('vrFullscreenModal');
            const iframe = document.getElementById('vrFullscreen');

            iframe.src = 'https://indonesiavirtualtour.com/storage/destination/saung-angklung-udjo/src/index.htm';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeVRFullscreen() {
            const modal = document.getElementById('vrFullscreenModal');
            const iframe = document.getElementById('vrFullscreen');

            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
            iframe.src = '';
        }

        function openMapModal() {
            const modal = document.getElementById('mapModal');
            const img = document.getElementById('modalImg');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                img.classList.remove('scale-90');
                img.classList.add('scale-100');
            }, 10);
        }

        function closeMapModal() {
            const modal = document.getElementById('mapModal');
            const img = document.getElementById('modalImg');
            img.classList.remove('scale-100');
            img.classList.add('scale-90');
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape") {
                closeVRFullscreen();
                closeMapModal();
            }
        });
    </script>

    <!-- Additional Styles -->
    <style>
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>



    {{-- SCRIPTS --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('active');
                        }
                    });
                }, {
                    threshold: 0.15
                });
                document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
            });

            function scrollVenue(dir) {
                const slider = document.getElementById('venueSlider');
                const amt = slider.clientWidth * 0.4;
                slider.scrollBy({
                    left: dir === 'left' ? -amt : amt,
                    behavior: 'smooth'
                });
            }

            // Fungsi Buka Modal
            function openMapModal() {
                const modal = document.getElementById('mapModal');
                const img = document.getElementById('modalImg');

                modal.classList.remove('hidden'); // Munculkan modal
                document.body.style.overflow = 'hidden'; // Kunci scroll layar belakang

                setTimeout(() => {
                    img.classList.remove('scale-90');
                    img.classList.add('scale-100'); // Efek zoom in halus
                }, 10);
            }

            // Fungsi Tutup Modal
            function closeMapModal() {
                const modal = document.getElementById('mapModal');
                const img = document.getElementById('modalImg');

                img.classList.remove('scale-100');
                img.classList.add('scale-90'); // Efek zoom out halus

                setTimeout(() => {
                    modal.classList.add('hidden'); // Sembunyikan modal
                    document.body.style.overflow = 'auto'; // Aktifkan kembali scroll
                }, 300);
            }

            // Tutup modal dengan tombol ESC
            document.addEventListener('keydown', (e) => {
                if (e.key === "Escape") closeMapModal();
            });
        </script>
    @endpush

    <!-- MODAL MAP LIGHTBOX -->
    <div id="mapModal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center p-4 md:p-10">
        <!-- Backdrop Gelap -->
        <div class="absolute inset-0 bg-[#1a1445]/95 backdrop-blur-xl" onclick="closeMapModal()"></div>

        <!-- Tombol Close -->
        <button onclick="closeMapModal()"
            class="absolute top-6 right-6 md:top-10 md:right-10 text-white hover:text-gold-premium transition-colors z-[10000]">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>

        <!-- Gambar Besar -->
        <div class="relative z-[10000] max-w-full max-h-full flex items-center justify-center">
            <img id="modalImg" src="{{ asset('images/A4wSIGN.jpg') }}"
                class="max-w-[95vw] max-h-[90vh] object-contain shadow-2xl rounded-lg scale-90 transition-transform duration-500">
        </div>
    </div>

@endsection
