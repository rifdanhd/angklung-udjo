{{-- resources/views/heritage/maestro-bio.blade.php --}}
@extends('layouts.app', [
    'seoTitle'       => 'Tentang Saung Angklung Udjo — Sejarah & Maestro Udjo Ngalagena',
    'seoDescription' => 'Mengenal sejarah Saung Angklung Udjo (1966) dan biografi Udjo Ngalagena, maestro yang mendedikasikan hidupnya melestarikan angklung warisan budaya UNESCO.',
    'seoKeywords'    => 'udjo ngalagena, sejarah saung angklung udjo, biografi mang udjo, maestro angklung, sejarah angklung bandung, pelestari angklung',
    'seoType'        => 'article',
])

@section('title', 'Tentang Saung Angklung Udjo — Sejarah & Maestro Udjo Ngalagena')

@section('content')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
<style>
    :root {
        --q-maroon: #831633; 
        --q-gold: #c4a47c;
        --q-cream: #FAF8F4;
        --q-navy: #1a1445;
        --q-text: #333333;
    }

    body { 
        background-color: white; 
        color: var(--q-text); 
        font-family: 'Inter', sans-serif; 
        -webkit-font-smoothing: antialiased;
        overflow-x: hidden;
    }

    .font-serif { font-family: 'Libre Baskerville', serif; }

    /* Container Standard Visit Qatar */
    .v-container {
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* Sistem Reveal */
    .reveal { opacity: 0; transform: translateY(40px); transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal.active { opacity: 1; transform: translateY(0); }

    /* Hero Section */
    .hero-history {
        height: 85vh;
        background: #000;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .hero-history img {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.5;
        transition: transform 10s ease;
    }
    .hero-history:hover img { transform: scale(1.1); }
    .hero-title {
        position: relative;
        z-index: 10;
        color: white;
        text-align: center;
    }
    .hero-title h1 { font-size: clamp(3.5rem, 9vw, 6.5rem); line-height: 1; margin-bottom: 20px; font-weight: 400; }
    .hero-subtitle { text-transform: uppercase; letter-spacing: 0.6em; font-size: 0.9rem; font-weight: 300; opacity: 0.8; }

    /* Seksi Label */
    .section-label { 
        text-transform: uppercase; 
        letter-spacing: 0.4em; 
        font-size: 0.75rem; 
        font-weight: 800; 
        color: var(--q-gold); 
        margin-bottom: 30px; 
        display: block;
    }

    /* Blok Sejarah (Milestone) */
    .history-block { padding: 120px 0; position: relative; }
    .big-year { 
        font-size: 14rem; 
        font-weight: 900; 
        color: rgba(26, 20, 69, 0.03); 
        position: absolute; 
        top: 40px; 
        left: -40px; 
        z-index: -1; 
        line-height: 1;
        user-select: none;
    }

    /* Slider "Masa ke Masa" (Visit Qatar Style) */
    .slider-container { background: var(--q-cream); padding: 120px 0; overflow: hidden; }
    .v-slider { 
        display: flex; 
        gap: 32px; 
        overflow-x: auto; 
        scrollbar-width: none; 
        padding-bottom: 60px;
        scroll-padding-left: calc((100vw - 1140px) / 2);
    }
    .v-slider::-webkit-scrollbar { display: none; }
    
    .v-card {
        flex: 0 0 440px;
        height: 600px;
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        cursor: pointer;
    }
    .v-card img { width: 100%; height: 100%; object-fit: cover; transition: 1.5s ease; filter: grayscale(100%); }
    .v-card:hover img { filter: grayscale(0%); transform: scale(1.05); }
    .v-card-content {
        position: absolute;
        inset: 0;
        padding: 45px;
        background: linear-gradient(to top, rgba(26, 20, 69, 0.95) 0%, transparent 70%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        color: white;
    }
    .v-card-content h4 { font-size: 1.8rem; margin-bottom: 12px; font-family: 'Libre Baskerville', serif; }
    .v-card-content p { font-size: 0.95rem; opacity: 0.85; line-height: 1.6; font-weight: 300; }
    .v-card-year { color: var(--q-gold); font-weight: 800; letter-spacing: 2px; font-size: 0.8rem; margin-bottom: 10px; display: block; }

    /* Navigasi */
    .q-btn-circle {
        width: 65px; height: 65px;
        border-radius: 50%;
        border: 1px solid #ddd;
        display: flex; align-items: center; justify-content: center;
        transition: 0.3s;
        cursor: pointer;
        background: white;
    }
    .q-btn-circle:hover { background: var(--q-navy); color: white; border-color: var(--q-navy); }

    .q-btn-primary {
        display: inline-block;
        padding: 22px 55px;
        background: var(--q-maroon);
        color: white;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        text-decoration: none;
        transition: 0.4s;
        font-size: 0.85rem;
    }
    .q-btn-primary:hover { background: var(--q-navy); transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }

    @media (max-width: 992px) {
        .v-card { flex: 0 0 320px; height: 480px; }
        .big-year { font-size: 8rem; top: 0; }
        .history-block { padding: 80px 0; }
    }
</style>
@endpush

<!-- 1. HERO UTAMA -->
<section class="hero-history">
    <img src="{{ asset('images/BGUDJOBIO.jpeg') }}" alt="Biografi Udjo Ngalagena">
    <div class="hero-title">
        <p class="hero-subtitle reveal">Mengenal Sang Maestro</p>
        <h1 class="font-serif reveal">Udjo Ngalagena</h1>
    </div>
</section>

<!-- 2. INTRO: NARASI EDITORIAL -->
<section style="padding: 120px 0; border-bottom: 1px solid #f5f5f5;">
    <div class="v-container">
        <div class="reveal">
            <span class="section-label">Warisan Abadi</span>
            <h2 class="font-serif" style="font-size: clamp(2.5rem, 5vw, 3.8rem); line-height: 1.1; margin-bottom: 60px; color: var(--q-navy);">
                Sebuah simfoni hidup dari <br><span style="color: var(--q-gold); font-style: italic; font-weight: 400;">Akar Padasuka.</span>
            </h2>
            <div class="grid md:grid-cols-2 gap-x-24 gap-y-12">
                <p style="font-size: 1.25rem; line-height: 2; color: #555; font-weight: 300;">
                    <strong>Udjo Ngalagena</strong> (lahir di Bandung, 5 Maret 1929 – wafat 3 Mei 2001), atau akrab disapa Mang Udjo Ngalagena, bukan sekadar seniman. Ia adalah visioner yang mengubah bambu menjadi bahasa musik universal. Sebagai putra keenam pasangan Wiranta dan Imi, ia tumbuh di tengah rimbunnya pohon bambu Bandung Timur, meresapi harmoni laras Pelog dan Salendro sejak usia belia.
                </p>
                <p style="font-size: 1.25rem; line-height: 2; color: #555; font-weight: 300;">
                    Bakatnya diasah oleh bimbingan maestro legendaris; dari Mang Koko, Rd. Machjar Angga Koesoemadinata, hingga pionir Angklung Diatonis, Daeng Soetigna. Kini, semangatnya terus bergetar, melampaui waktu dan generasi di panggung yang ia bangun dengan cinta.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- 3. BLOK MILESTONE: AWAL PERJALANAN -->
<section class="history-block">
    <div class="v-container">
        <div class="grid md:grid-cols-12 gap-16 items-center">
            <div class="md:col-span-5 reveal">
                <div style="position: relative; border-radius: 12px; overflow: hidden; box-shadow: 0 30px 60px rgba(0,0,0,0.08); aspect-ratio: 4/5;">
                    <img src="{{ asset('images/udjo-history-bg.jpg') }}" alt="Masa Kecil Udjo" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
            <div class="md:col-span-7 reveal">
                <span class="big-year">1929</span>
                <span class="section-label">Akar Tradisi</span>
                <h3 class="font-serif" style="font-size: 3rem; margin-bottom: 30px; color: var(--q-navy);">Gemuruh Bambu di <br>Masa Kecil.</h3>
                <p style="font-size: 1.15rem; line-height: 1.9; color: #666; margin-bottom: 30px;">
                    Sejak usia 4 tahun, Udjo kecil telah akrab dengan angklung dalam berbagai acara adat desa. Pendidikan formalnya di HIS memberikan wawasan nada diatonis, yang nantinya menjadi jembatan bagi Angklung untuk merambah telinga masyarakat dunia.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- 4. SLIDER TIMELINE: MASA KE MASA (Khas Visit Qatar) -->
<section class="slider-container">
    <div class="v-container">
        <div class="reveal" style="margin-bottom: 70px;">
            <span class="section-label">Garis Waktu</span>
            <h2 class="font-serif" style="font-size: 3.5rem; color: var(--q-navy);">Perjalanan Sang Maestro</h2>
            <p style="color: #777; font-size: 1.2rem; margin-top: 15px; font-weight: 300;">Menelusuri jejak hidup Udjo Ngalagena dari masa ke masa.</p>
        </div>
    </div>
    
    <div id="udjoSlider" class="v-slider" style="padding-left: calc((100vw - 1140px) / 2);">
        @php
        $timeline = [
            ['year' => '1929 - 1940', 'img' => 'udjo-1.jpg', 'title' => 'Akar Padasuka', 'desc' => 'Masa kecil Udjo yang akrab dengan kesenian angklung pelog dan salendro di lingkungannya.'],
            ['year' => '1945 - 1960', 'img' => 'udjo-2.jpg', 'title' => 'Masa Pembelajaran', 'desc' => 'Berguru kepada para maestro besar: Mang Koko, Rd. Machjar, hingga Daeng Soetigna.'],
            ['year' => '1966', 'img' => 'udjo-3.jpg', 'title' => 'Pendirian Sanggar', 'desc' => 'Membangun Saung Angklung Udjo sebagai sarana pengabdian budaya bersama istri, Uum Sumiati.'],
            ['year' => '1980 - 2000', 'img' => 'udjo-4.jpg', 'title' => 'Puncak Pengakuan', 'desc' => 'Menjadi duta budaya internasional dan menyapa dunia melalui harmoni angklung.'],
            ['year' => '2001 - Kini', 'img' => 'udjo-5.jpg', 'title' => 'Warisan Abadi', 'desc' => 'Semangatnya tetap hidup melalui sepuluh putra-putrinya yang menjaga nyala api SAU.'],
        ];
        @endphp

        @foreach($timeline as $t)
        <div class="v-card reveal shadow-sm">
            <img src="{{ asset('images/' . $t['img']) }}" onerror="this.src='https://images.unsplash.com/photo-1544967082-d9d25d867d66?q=80&w=1000'">
            <div class="v-card-content">
                <span class="v-card-year">{{ $t['year'] }}</span>
                <h4>{{ $t['title'] }}</h4>
                <p>{{ $t['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="v-container">
        <div class="flex gap-4 mt-10">
            <div onclick="scrollSlider('left')" class="q-btn-circle">←</div>
            <div onclick="scrollSlider('right')" class="q-btn-circle">→</div>
        </div>
    </div>
</section>

<!-- 5. SEKSI AKHIR: MANIFESTO -->
<section style="padding: 140px 0; text-align: center; background: white;">
    <div class="v-container">
        <div class="reveal" style="max-width: 900px; margin: 0 auto;">
            <span class="section-label">Pesan Maestro</span>
            <h2 class="font-serif" style="font-size: 3.8rem; margin-bottom: 40px; color: var(--q-navy);">"Lakukanlah dengan Cinta"</h2>
            <p style="font-size: 1.35rem; line-height: 2; color: #555; margin-bottom: 60px; font-weight: 300; font-style: italic;">
                "Apa pun dirimu, pekerjaan apa pun yang kamu pilih, lakukanlah dengan cinta. Tanpa cinta, kamu telah mati sebelum ajal menjemput."
            </p>
            <a href="{{ route('experience.performances') }}" class="q-btn-primary">Lihat Warisan Beliau</a>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Reveal Animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // Slider Logic
    function scrollSlider(direction) {
        const slider = document.getElementById('udjoSlider');
        const cardWidth = 472; // Card + gap
        slider.scrollBy({
            left: direction === 'left' ? -cardWidth : cardWidth,
            behavior: 'smooth'
        });
    }

    // Touch Drag Support
    const slider = document.getElementById('udjoSlider');
    let isDown = false; let startX; let scrollLeft;
    slider.addEventListener('mousedown', (e) => { isDown = true; startX = e.pageX - slider.offsetLeft; scrollLeft = slider.scrollLeft; });
    slider.addEventListener('mouseleave', () => isDown = false);
    slider.addEventListener('mouseup', () => isDown = false);
    slider.addEventListener('mousemove', (e) => { if (!isDown) return; e.preventDefault(); const x = e.pageX - slider.offsetLeft; const walk = (x - startX) * 2; slider.scrollLeft = scrollLeft - walk; });
</script>
@endpush

@endsection