{{-- resources/views/heritage/angklung-history.blade.php --}}
@extends('layouts.app')

@section('title', 'Sejarah Lengkap Angklung - Simfoni Bambu Nusantara')

@section('content')

    @push('styles')
        <link
            href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap"
            rel="stylesheet">
        <style>
            :root {
                --qatar-blue: #004b87;
                --qatar-burgundy: #8a1538;
                --gold-accent: #c4a47c;
                --text-primary: #333;
                --text-secondary: #666;
                --bg-ivory: #f9f7f4;
                --bg-premium: #F7F7F2;
            }

            body {
                font-family: 'Inter', sans-serif;
                color: var(--text-primary);
                background-color: var(--bg-premium);
            }

            .font-serif {
                font-family: 'Libre Baskerville', serif;
            }

            /* Reveal Animation */
            .reveal {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .reveal.active {
                opacity: 1;
                transform: translateY(0);
            }

            /* Hero Section */
          .hero-history { 
    height: 70vh; 
    position: relative; 
    overflow: hidden; 
    background: #000; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    text-align: center;
}

.hero-bg { 
    position: absolute; 
    inset: 0; 
    width: 100%; 
    height: 100%; 
    object-fit: cover; 
    opacity: 0.4; /* Mengatur kegelapan gambar agar teks terbaca */
}

.hero-overlay { 
    position: absolute; 
    inset: 0; 
    background: linear-gradient(to bottom, transparent 0%, #1a1445 100%); 
}
         .hero-title {
    font-family: 'Libre Baskerville', serif;
    font-size: clamp(2.5rem, 6vw, 4.5rem);
    color: #ffffff;
    font-weight: 400;
    margin-bottom: 1.5rem;
    letter-spacing: -0.02em;
    font-style: italic; /* Agar sama dengan style Achievements */
}

        .hero-subtitle {
    font-size: clamp(0.75rem, 2vw, 0.85rem); /* Ukuran disamakan dengan text-spacing-lg */
    text-transform: uppercase;
    letter-spacing: 0.5em;
    font-weight: 800;
    color: var(--gold-accent);
    margin-bottom: 2rem;
}

            /* Timeline Section */
            .timeline-section {
                padding: 100px 0;
                background: var(--bg-premium);
            }

            .timeline-container {
                max-width: 1400px;
                margin: 0 auto;
                padding: 0 40px;
            }

            .timeline-item {
                display: grid;
                grid-template-columns: 280px 1px 1fr;
                gap: 60px;
                padding: 60px 0;
                position: relative;
            }

            .timeline-item:not(:last-child) {
                border-bottom: 1px solid #e5e5e5;
            }

            /* Year Column */
            .timeline-year {
                font-family: 'Libre Baskerville', serif;
                font-size: 3rem;
                font-weight: 400;
                color: #22185d;
                text-align: right;
                padding-right: 20px;
                line-height: 1;
            }

            /* Vertical Line */
            .timeline-line {
                width: 1px;
                background: #d0d0d0;
                position: relative;
            }

            .timeline-line::before {
                content: '';
                position: absolute;
                top: 15px;
                left: -3px;
                width: 7px;
                height: 7px;
                background: var(--qatar-burgundy);
                border-radius: 50%;
            }

            /* Content Column */
            .timeline-content {
                padding-top: 8px;
            }

            .timeline-subtitle {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.5rem;
                color: var(--text-primary);
                margin-bottom: 1rem;
                font-weight: 700;
            }

            .timeline-text {
                font-size: 1.05rem;
                line-height: 1.8;
                color: var(--text-secondary);
                font-weight: 300;
                max-width: 800px;
            }

            /* Nested Timeline */
            .nested-timeline {
                margin-top: 40px;
                padding-left: 0;
            }

            .nested-item {
                margin-top: 50px;
                padding-top: 50px;
                border-top: 1px solid #f0f0f0;
            }

            .nested-subtitle {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.5rem;
                color: var(--text-primary);
                margin-bottom: 0.75rem;
                display: block;
                font-weight: 700;
            }

            /* Early History Section */
            .early-history-section {
                padding: 100px 0;
                background: var(--bg-premium);
            }

            .early-history-container {
                max-width: 1400px;
                margin: 0 auto;
                padding: 0 40px;
            }

            .early-history-title {
                font-family: 'Libre Baskerville', serif;
                font-size: clamp(2rem, 4vw, 2.5rem);
                color: #22185d;
                margin-bottom: 3rem;
                text-align: center;
            }

            .history-grid {
                display: grid;
                gap: 80px;
            }

            .history-item {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 60px;
                align-items: center;
            }

            .history-item:nth-child(even) {
                direction: rtl;
            }

            .history-item:nth-child(even) .history-text {
                direction: ltr;
            }

            .history-image {
                width: 100%;
                height: 400px;
                object-fit: cover;
                border-radius: 12px;
            }

            .history-image-selection {
                width: 100%;

                aspect-ratio: 3 / 4;
                /* portrait */
                object-fit: cover;
                object-position: right center;
                /* INI KUNCINYA */
                border-radius: 12px;
            }

            .history-text {
                font-size: 1.05rem;
                line-height: 1.8;
                color: var(--text-secondary);
                font-weight: 300;
            }

            .history-text-center {
                text-align: center;
                max-width: 900px;
                margin: 60px auto;
                font-size: 1.15rem;
                line-height: 1.9;
                color: var(--text-secondary);
            }

            /* CTA Section */
            .cta-section {
                padding: 100px 40px;
                text-align: center;
                background: var(--bg-premium);
            }

            .cta-title {
                font-family: 'Libre Baskerville', serif;
                font-size: clamp(1.75rem, 4vw, 2.5rem);
                color: #22185d;
                margin-bottom: 2rem;
            }

            .cta-button {
                display: inline-block;
                padding: 16px 48px;
                border: 2px solid var(--qatar-blue);
                color: #22185d;
                text-decoration: none;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-size: 0.875rem;
                transition: all 0.3s ease;
                border-radius: 0;
            }

            .cta-button:hover {
                background: #22185d;
                color: #fff;
            }

            /* Responsive */
            @media (max-width: 1024px) {
                .timeline-item {
                    grid-template-columns: 200px 1px 1fr;
                    gap: 40px;
                }

                .timeline-year {
                    font-size: 2.5rem;
                }
            }

            @media (max-width: 768px) {
                .timeline-container {
                    padding: 0 20px;
                }

                .timeline-item {
                    grid-template-columns: 1fr;
                    gap: 20px;
                    padding: 40px 0;
                }

                .timeline-year {
                    text-align: left;
                    padding-right: 0;
                    font-size: 2rem;
                }

                .timeline-line {
                    display: none;
                }

                .timeline-content {
                    padding-top: 0;
                }

                .history-item {
                    grid-template-columns: 1fr;
                    gap: 30px;
                }

                .history-item:nth-child(even) {
                    direction: ltr;
                }

                .history-image {
                    height: 300px;
                }
            }
        </style>
    @endpush

    <!-- HERO -->
   <section class="hero-history">
    <img src="{{ asset('images/maen di pendopo dulu.jpg') }}" class="hero-bg" alt="History Header">
    
    <div class="hero-overlay"></div>

    <div class="relative z-10 text-center text-white px-6">
        <div class="reveal">
            <p class="hero-subtitle">The Journey of Bamboo</p>
            
            <h1 class="hero-title">History of Angklung</h1>
            
            <p style="max-width: 600px; margin: 0 auto; color: rgba(255,255,255,0.7); font-weight: 300; line-height: 1.8;">
                Menelusuri jejak resonansi bambu dari ritual sakral agraris hingga menjadi warisan dunia yang diakui UNESCO.
            </p>
        </div>
    </div>
</section>

    <!-- EARLY HISTORY -->
    <section class="early-history-section background: var(--bg-premium);">
        <div class="early-history-container">
            <h2 class="early-history-title reveal">Sejarah Awal</h2>

            <div class="history-grid">
                <!-- Item 1 -->
                <div class="history-item reveal">
                    <div>
                        <p class="history-text">
                            Angklung lahir dari jiwa agraris masyarakat Sunda yang menjadikan padi sebagai sumber kehidupan.
                            Instrumen bambu ini diciptakan sebagai persembahan kepada Nyai Sri Pohaci—Dewi Padi pemberi
                            kehidupan. Sejak Kerajaan Sunda (abad ke-12–16), angklung telah menjadi bagian sakral dari
                            ritual penanaman hingga pesta panen Seren Taun.
                        </p>
                    </div>
                    <div>
                        <img src="/images/ZAMANAWAL.jpg" alt="Tradisi Angklung Sunda" class="history-image">
                    </div>
                </div>

                <!-- Text Center -->
                <p class="history-text-center reveal">
                    Di Jasinga, Bogor, permainan angklung gubrag masih bertahan sejak lebih dari 400 tahun lampau—saksi
                    hidup bagaimana angklung diciptakan untuk memikat Dewi Sri turun ke bumi memberkati tanaman padi rakyat.
                </p>

                <!-- Item 2 -->
                <div class="history-item reveal">
                    <div>
                        <img src="/images/DAENGSOETIGMA.jpg" alt="Udjo Ngalagena" class="history-image-selection">
                    </div>
                    <div>
                        <p class="history-text">
                            Pada 1938, Daeng Soetigna melakukan revolusi dengan mengubah laras angklung dari pentatonik
                            menjadi diatonik, membuka pintu bagi angklung untuk memainkan lagu-lagu internasional. Namun
                            tongkat estafet pelestarian sejati baru dimulai ketika <strong>Udjo Ngalagena</strong> tampil di
                            Konferensi Asia-Afrika 1955, lalu mendirikan <strong>Saung Angklung Udjo</strong> pada 1966
                            bersama istrinya, Uum Sumiati.
                        </p>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="history-item reveal">
                    <div>
                        <p class="history-text">
                            Sejak 1966, Mang Udjo mengembangkan teknik permainan berdasarkan laras pelog, salendro, dan
                            madenda, serta mengajarkan angklung kepada berbagai komunitas dari seluruh dunia. Visinya
                            sederhana namun agung: menjadikan angklung bukan hanya warisan budaya, tetapi jembatan
                            pendidikan dan pemberdayaan masyarakat Padasuka. Puncaknya tiba pada 2010, ketika UNESCO
                            menginskripsikan angklung sebagai Warisan Budaya Takbenda Manusia—mengukuhkan mandat Saung
                            Angklung Udjo sebagai pusat pendidikan budaya bambu global.
                        </p>
                    </div>
                    <div>
                        <img src="/images/PENGAJAR.jpg" alt="Saung Angklung Udjo" class="history-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- VIDEO SECTION - TAMBAHKAN SETELAH EARLY HISTORY -->
    <section style="padding: 120px 0; background: var(--bg-premium);">
        <div class="early-history-container">
            <div class="reveal" style="text-align: center; margin-bottom: 3rem;">
                <span
                    style="display: inline-block; font-size: 0.875rem; letter-spacing: 3px; color: #22185d; font-bold text-transform: uppercase; margin-bottom: 1rem;">Perjalanan
                    Visual</span>
                <h2
                    style="font-family: 'Libre Baskerville', serif; font-size: clamp(2rem, 4vw, 2.5rem); color: #22185d; margin-bottom: 1rem;">
                    Simfoni Bambu yang Mendunia
                </h2>
                <p
                    style="font-size: 1.05rem; line-height: 1.8; color: var(--text-secondary); max-width: 700px; margin: 0 auto;">
                    Saksikan bagaimana angklung dari Padasuka memikat hati dunia
                </p>
            </div>

            <div class="reveal" style="max-width: 1200px; margin: 0 auto;">
                <div
                    style="position: relative; width: 100%; padding-bottom: 56.25%; background: #000; border-radius: 12px; overflow: hidden; box-shadow: 0 30px 80px rgba(0,0,0,0.2);">
                    <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                        src="https://www.youtube.com/embed/ASqV9Fedt4w?start=7"
                        title="Saung Angklung Udjo - Simfoni Bambu Nusantara" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- TIMELINE -->
    <section class="timeline-section">
        <div class="timeline-container">

            <!-- 1000s: Abad ke-11 -->
            <div class="timeline-item reveal">
                <div class="timeline-year">1000s</div>
                <div class="timeline-line"></div>
                <div class="timeline-content">
                    <h2 class="timeline-subtitle">1031</h2>
                    <p class="timeline-text">
                        Bukti tertulis tertua ditemukan pada Prasasti Cibadak di Sukabumi bertahun 952 Saka (1031 M). Raja
                        Sunda, Sri Jayabuphati, menggunakan Angklung sebagai media upacara suci—sebuah penghubung spiritual
                        antara manusia dengan Sang Pencipta.
                    </p>

                    <!-- Nested: 1359 -->
                    <div class="nested-timeline">
                        <div class="nested-item">
                            <h3 class="nested-subtitle">1359</h3>
                            <p class="timeline-text">
                                Dicatat dalam buku Nagara Kartagama sebagai media hiburan dalam pesta penyambutan raja. Di
                                Jasinga, Bogor, ditemukan Angklung tertua yang diperkirakan telah berusia lebih dari 400
                                tahun, saksi bisu keagungan seni bambu Nusantara.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 1600s: Abad ke-17 -->
            <div class="timeline-item reveal">
                <div class="timeline-year">1600s</div>
                <div class="timeline-line"></div>
                <div class="timeline-content">
                    <h2 class="timeline-subtitle">Abad ke-17</h2>
                    <p class="timeline-text">
                        Pada abad ke-17, Angklung menjadi media pemanggil Dewi Sri (Dewi Kesuburan) agar turun ke bumi
                        memberkati musim tanam. Menggunakan laras tritonik, tetratonik, dan pentatonik, alat ini dikenal
                        sebagai <strong>Angklung Buhun</strong>—getaran bambu yang membawa doa untuk kemakmuran tanah paré.
                    </p>
                </div>
            </div>

            <!-- 1900s: Era Modern -->
            <div class="timeline-item reveal">
                <div class="timeline-year">1900s</div>
                <div class="timeline-line"></div>
                <div class="timeline-content">
                    <h2 class="timeline-subtitle">1938</h2>
                    <p class="timeline-text">
                        Daeng Soetigna melakukan revolusi di Kuningan dengan mengubah laras pentatonik menjadi diatonik.
                        Inovasi ini memungkinkan Angklung beradaptasi dengan musik modern dan komposisi lagu internasional.
                    </p>

                    <!-- Nested: 1955 -->
                    <div class="nested-timeline">
                        <div class="nested-item">
                            <h3 class="nested-subtitle">1955</h3>
                            <p class="timeline-text">
                                Angklung mulai memikat telinga dunia. Musikus Australia, Igor Hmelnitsky, menyatakan
                                kekagumannya. Di perhelatan Konferensi Asia Afrika, <strong>Udjo Ngalagena</strong> tampil
                                sebagai pemain, langkah awal menuju pendirian Saung Udjo.
                            </p>
                        </div>

                        <!-- Nested: 1960s -->
                        <div class="nested-item">
                            <h3 class="nested-subtitle">1960s</h3>
                            <p class="timeline-text">
                                Benih gerakan budaya tumbuh dari keluarga besar Mang Udjo dan keterlibatan aktif masyarakat
                                Padasuka dalam menjaga tradisi.
                            </p>
                        </div>

                        <!-- Nested: 1966 -->
                        <div class="nested-item">
                            <h3 class="nested-subtitle">1966</h3>
                            <p class="timeline-text">
                                Udjo Ngalagena dan istrinya, Uum Sumiati, mendirikan <strong>Saung Angklung Udjo</strong>
                                sebagai ruang suci untuk pendidikan dan pelestarian seni Sunda bagi generasi muda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2000s: Era UNESCO -->
            <div class="timeline-item reveal">
                <div class="timeline-year">2000s</div>
                <div class="timeline-line"></div>
                <div class="timeline-content">
                    <h2 class="timeline-subtitle">2010</h2>
                    <p class="timeline-text">
                        Angklung diinskripsí sebagai Warisan Budaya Takbenda oleh UNESCO, mengukuhkan mandat Saung Angklung
                        Udjo dalam mengedukasi budaya bambu global.
                    </p>
                </div>
            </div>

            <!-- Present: Kini -->
            <div class="timeline-item reveal">
                <div class="timeline-year" style="font-size: 2.5rem;">Present</div>
                <div class="timeline-line"></div>
                <div class="timeline-content">
                    <h2 class="timeline-subtitle">Kini</h2>
                    <p class="timeline-text">
                        Terus merawat harmoni antara inovasi pertunjukan, pendidikan dini, dan pemberdayaan komunitas
                        Padasuka yang mandiri.
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="reveal">
            <h2 class="cta-title">Saksikan Sejarah Berjalan</h2>
            <a href="{{ route('experience.performances') }}" class="cta-button">
                Book Experience
            </a>
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
