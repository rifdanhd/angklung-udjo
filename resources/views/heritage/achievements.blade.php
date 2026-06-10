{{-- resources/views/heritage/achievements.blade.php --}}
@extends('layouts.app')

@section('title', 'Pencapaian & Penghargaan - Saung Angklung Udjo')

@section('content')

    {{-- 1. STYLES: GLOBAL LUXURY ARCHIVE --}}
    @push('styles')
        <style>
            :root {
                --v-indigo: #1a1445;
                --v-gold: #c4a47c;
                --v-cream: #FAF8F4;
                --bg-premium: #F7F7F2;
            }

            body {
                background-color: var(--bg-premium);
            }

            .text-spacing-lg {
                text-transform: uppercase;
                letter-spacing: 0.5em;
                font-size: 0.75rem;
                font-weight: 800;
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

            /* Hero Cinematic */
            .hero-achieve {
                height: 60vh;
                position: relative;
                overflow: hidden;
                background: #000;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .hero-bg {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                opacity: 0.4;
            }

            .hero-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(to bottom, transparent 0%, var(--v-indigo) 100%);
            }

            /* Achievement Timeline Style */
            .award-row {
                border-bottom: 1px solid rgba(26, 20, 69, 0.08);
                padding: 3.5rem 0;
                display: grid;
                grid-template-columns: 180px 1fr;
                gap: 4rem;
                transition: all 0.4s ease;
            }

            

            .award-year {
                font-family: 'Inter', sans-serif;
                font-weight: 800;
                color: var(--v-gold);
                font-size: 1.5rem;
                letter-spacing: -0.02em;
            }

            .decade-header {
                padding: 6rem 0 2rem 0;
                border-bottom: 2px solid var(--v-indigo);
                margin-bottom: 2rem;
            }

            section {
                margin: 0 !important;
            }

            @media (max-width: 768px) {
                .award-row {
                    grid-template-columns: 1fr;
                    gap: 1rem;
                    padding: 2rem 0;
                }
            }
        </style>
    @endpush

    <!-- 1. HERO SECTION -->
    <section class="hero-achieve">
        <img src="{{ asset('img/performance.jpg') }}" class="hero-bg" alt="Achievements Header">
        <div class="hero-overlay"></div>
        <div class="relative z-10 text-center text-white px-6">
            <p class="reveal text-spacing-lg text-gold-premium mb-8 uppercase">A History of Excellence</p>
            <h1 class="reveal font-editorial text-5xl md:text-8xl leading-tight italic">Pencapaian </h1>
        </div>
    </section>

    <!-- 2. HIGHLIGHT: GUINNESS WORLD RECORD (SIMPLIFIED LUXURY) -->
    <section class="py-24 overflow-hidden">
        <div class="max-w-[1300px] mx-auto px-10">
            <div class="grid lg:grid-cols-2 gap-20 items-center">

                <!-- SISI KIRI: Visual Minimalis -->
                <div class="reveal">
                    <a href="https://www.youtube.com/watch?v=21WL5KtanJ8" target="_blank"
                        class="relative block aspect-[16/10] overflow-hidden">
                        <img src="https://img.youtube.com/vi/21WL5KtanJ8/maxresdefault.jpg"
                            class="w-full h-full object-cover scale-105">

                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                            <span class="text-white tracking-widest text-xs uppercase border px-6 py-3">
                                Watch Documentary
                            </span>
                        </div>
                    </a>

                    <!-- Caption Tipis di Bawah Foto -->
                    <p class="mt-6 text-[9px] font-bold tracking-[0.4em] text-gray-400 uppercase">
                        Gelora Bung Karno, Jakarta — 2023
                    </p>
                </div>

                <!-- SISI KANAN: Konten Editorial -->
                <div class="reveal" style="transition-delay: 200ms;">
                    <p class="text-spacing-lg text-gold-premium mb-6">Pencapaian Tertinggi</p>
                    <h2 class="font-editorial text-4xl md:text-6xl text-indigo-950 leading-tight mb-10">
                        The Largest <br> <span class="italic font-normal">Angklung Ensemble.</span>
                    </h2>

                    <p class="text-gray-500 text-lg leading-loose font-light mb-12">
                        Diinisiasi oleh Ibu Iriana Joko Widodo, orkestra raksasa ini melibatkan 15.110 peserta yang
                        memainkan 20.060 angklung dalam satu harmoni yang diakui secara resmi oleh Guinness World Records.
                    </p>

                    <!-- Statistik Sederhana (Satu Baris) -->
                    <div class="flex gap-12 py-8 border-t border-gray-100">
                        <div>
                            <span class="text-2xl font-editorial text-indigo-950">15.110</span>
                            <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Peserta</p>
                        </div>
                        <div class="w-px h-10 bg-gray-100"></div>
                        <div>
                            <span class="text-2xl font-editorial text-indigo-950">20.060</span>
                            <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Angklung</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. CHRONOLOGICAL ARCHIVE (EVERYTHING FROM 1968 - 2025) -->
    <section class="py-32">
        <div class="max-w-[1300px] mx-auto px-10 md:px-20">

            <div class="mb-24 reveal text-center lg:text-left">
                <p class="text-spacing-lg text-gray-400 mb-6">Arsip Kehormatan</p>
                <h3 class="font-editorial text-4xl md:text-6xl text-indigo-950 italic">Jejak Langkah Lintas Generasi</h3>
            </div>

            <!-- DEKADE 2020 -->
            <div class="decade-header reveal">
                <span class="text-spacing-lg text-indigo-950">Era Transformasi (2020 — 2025)</span>
            </div>

            <div class="award-row reveal">
                <div class="award-year">2025</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Kawasan Berbasis Kekayaan Intelektual</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Diberikan oleh Kemenkumham Jabar
                    </p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">2025</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Kekayaan Intelektual Komunal Indonesia</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Kategori Ekspresi Budaya
                        Tradisional - Kemenkumham</p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">2024</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Outstanding in Preserving Sundanese Educational
                        Tourism</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Diberikan oleh CNN Indonesia</p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">2024</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Anugrah Pesona Pariwisata Kota Bandung</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Dinas Kebudayaan dan Pariwisata
                        Kota Bandung</p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">2024</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Icon of Indonesian Ethnic Music</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Markplus Conference 2025
                        (Marketeers Music Icon)</p>
                </div>
            </div>

            <!-- DEKADE 2010 -->
            <div class="decade-header reveal">
                <span class="text-spacing-lg text-indigo-950">Era Globalisasi (2010 — 2019)</span>
            </div>

            <div class="award-row reveal">
                <div class="award-year">2019</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Bronze Winner of Planet Tourism Indonesia</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Kategori Daya Tarik Budaya
                        (Culture)</p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">2015</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Best ASEAN Cultural Preservation Event</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">29th ASEANTE Award for Excellence
                        (Manila, Philippines)</p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">2010</div>
                <div>
                    <h4 class="font-editorial text-2xl text-gold-premium italic mb-4">Bintang Budaya Parama Dharma</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Diberikan oleh Presiden Republik
                        Indonesia</p>
                    <p class="text-gray-500 text-sm mt-4 font-light leading-loose">Penghargaan tertinggi negara atas
                        dedikasi luar biasa dalam melestarikan, mempromosikan, dan memperkuat warisan budaya nasional.</p>
                </div>
            </div>

            <!-- DEKADE 2000 -->
            <div class="decade-header reveal">
                <span class="text-spacing-lg text-indigo-950">Era Millenium (2000 — 2009)</span>
            </div>

            <div class="award-row reveal">
                <div class="award-year">2008</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Danamon Awards: Pemberdayaan Masyarakat</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Kategori Menengah - Beasiswa Seni
                        Untuk Anak</p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">2007</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Pesona Wisata Award: No. 1 Resort Destination
                    </h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Diberikan oleh Dinas Pariwisata
                        Kota Bandung</p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">2007</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Rekor MURI: 10.000 Angklung</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Pemecahan Rekor Bermain Angklung
                        Terbanyak di UNPAD</p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">2004</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">PATA Heritage and Culture Gold Award</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Presented by PATA in Jeju Island,
                        South Korea</p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">2004</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Indonesia Tourism Achievement and Innovations
                    </h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Menteri Seni, Budaya, dan
                        Pariwisata Republik Indonesia</p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">2000</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Father of Music Innovator (Udjo Ngalagena)</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Penghargaan Majalah Anak Fantasi
                    </p>
                </div>
            </div>

            <!-- SEJARAH AWAL -->
            <div class="decade-header reveal">
                <span class="text-spacing-lg text-indigo-950">Akar Prestasi (1960 — 1999)</span>
            </div>

            <div class="award-row reveal">
                <div class="award-year">1997</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2 italic text-gold-premium">Masterpiece Award of
                        National Tourism</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Diberikan oleh Presiden Republik
                        Indonesia</p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">1994</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Pencatatan Inovator Angklung (Udjo Ngalagena)
                    </h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Diberikan oleh Gubernur Jawa Barat
                    </p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">1992</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Partisipasi KTT Non Blok X</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Gubernur Jawa Barat</p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">1988</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2 italic text-gold-premium">Masterpiece Award of
                        Tourism</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Menteri Pariwisata, Pos, dan
                        Telekomunikasi RI</p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">1983</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Pelestarian Seni & Budaya Sunda</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Departemen Pariwisata RI</p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">1975</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Arts and Cultural Award</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Gubernur Jawa Barat</p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">1971</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Peserta Internasional Exhibition Jabar</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Gubernur Jawa Barat</p>
                </div>
            </div>
            <div class="award-row reveal">
                <div class="award-year">1968</div>
                <div>
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Pengembangan Musik Tradisional</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Gubernur DKI Jakarta</p>
                </div>
            </div>

        </div>
    </section>

   <!-- FINAL CTA — VISIT QATAR SPLIT STYLE -->
<section class="relative w-full overflow-hidden">
    <div class="flex flex-col md:flex-row" style="min-height: 400px; height: auto;">

        <!-- SISI KIRI / ATAS (mobile): Foto -->
        <div class="w-full md:w-1/2 relative overflow-hidden" style="height: 45vw; min-height: 220px; max-height: 500px;">
            <img src="{{ asset('img/Angklungmasal.webp') }}"
                 class="absolute inset-0 w-full h-full object-cover transition-transform duration-[6s] hover:scale-105"
                 alt="Pertunjukan Saung Angklung Udjo">
        </div>

        <!-- SISI KANAN / BAWAH (mobile): Teks + CTA -->
        <div class="w-full md:w-1/2 relative overflow-hidden" style="min-height: 300px;">
            <img src="{{ asset('img/performance.jpg') }}"
                 class="absolute inset-0 w-full h-full object-cover"
                 alt="">
            <div class="absolute inset-0 bg-[#1a1445]/80"></div>

            <div class="relative z-10 h-full flex flex-col justify-center
                        px-8 py-12
                        md:px-12 md:py-0
                        lg:px-20
                        text-center md:text-left">

                <p class="text-[9px] font-bold tracking-[0.5em] text-[#c4a47c] uppercase mb-4 md:mb-5">
                    {{ __('home.performances.eyebrow') ?? 'Masa Depan Tradisi' }}
                </p>

                <h2 class="font-editorial text-3xl md:text-4xl lg:text-5xl text-white leading-[1.15] mb-6 md:mb-8 italic">
                 Sejarah ini <br>
                    terus dimainkan.
                </h2>

                <!-- Tombol: center di mobile, left di desktop -->
                <div class="flex justify-center md:justify-start">
                    <a href="https://www.traveloka.com/id-id/activities/indonesia/product/tiket-saung-angklung-udjo-2000858975309"
                       target="_blank" rel="noopener noreferrer"
                       style="display:inline-block;padding:0.9rem 2rem;background:#7d002a;color:white;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:0.3em;text-decoration:none;transition:all 0.4s ease;"
                       onmouseover="this.style.background='#c4a47c';this.style.color='#1a1445';"
                       onmouseout="this.style.background='#7d002a';this.style.color='white';">
                        Reservasi Tiket Sekarang
                    </a>
                </div>

            </div>
        </div>

    </div>
</section>

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
                    threshold: 0.1
                });
                document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
            });
        </script>
    @endpush

@endsection
