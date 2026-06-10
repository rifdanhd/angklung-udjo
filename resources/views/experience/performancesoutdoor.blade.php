{{-- resources/views/experience/outdoor-performances.blade.php --}}
@extends('layouts.app')

@section('title', 'Global Performances - Saung Angklung Udjo')

@section('content')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,500;1,300&family=Inter:wght@200;400;700&family=Spirax&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

<style>
:root {
    --indigo: #1a1445;
    --gold: #c4a47c;
    --bg: #F7F7F2;
    --serif: 'Cormorant Garamond', serif;
    --spirax: 'Spirax', cursive;
}

#op-page {
    background-color: var(--bg);
    color: var(--indigo);
    font-family: 'Inter', sans-serif;
    overflow-x: hidden;
}

/* ═════ 1. HERO: THE VAST OPENING ═════ */
.op-hero-vast {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    background: #0a081e;
    overflow: hidden;
}

.op-hero-img-bg {
    position: absolute;
    inset: 0;
    opacity: 0.4;
    transform: scale(1.1);
}
.op-hero-img-bg img { width: 100%; height: 100%; object-fit: cover; }

.op-hero-content {
    position: relative;
    z-index: 10;
    text-align: center;
    color: white;
}

.op-hero-eyebrow {
    font-size: 10px;
    letter-spacing: 1em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 2rem;
    display: block;
}

.op-hero-title {
    font-family: var(--spirax);
    font-size: clamp(4rem, 12vw, 10rem);
    line-height: 0.8;
}

/* ═════ 2. TIGA PILAR: EDITORIAL SPREAD ═════ */
.pillar-section {
    padding: 15rem 0;
}

.pillar-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 5%;
}

.editorial-spread {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12rem;
    align-items: center;
    margin-bottom: 20rem;
}

.editorial-spread.reverse {
    grid-template-columns: 1fr 1.2fr;
}

.editorial-spread.reverse .editorial-text {
    order: 2;
}

.editorial-img-frame {
    position: relative;
    height: 80vh;
    width: 100%;
}

.editorial-img-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: grayscale(0.2);
    transition: 1s cubic-bezier(0.16, 1, 0.3, 1);
}

.editorial-img-frame:hover img {
    filter: grayscale(0);
    transform: scale(1.02);
}

.pillar-num {
    font-family: var(--serif);
    font-size: 6rem;
    color: var(--gold);
    line-height: 1;
    opacity: 0.3;
    margin-bottom: 1rem;
    display: block;
}

.editorial-text h2 {
    font-family: var(--serif);
    font-size: clamp(3rem, 5vw, 5rem);
    line-height: 1;
    margin-bottom: 2.5rem;
    font-weight: 300;
}

.editorial-text p {
    font-size: 1.1rem;
    line-height: 2;
    opacity: 0.7;
    font-weight: 300;
    max-width: 400px;
}

/* ═════ 3. STATS: WORLDWIDE FOOTPRINT ═════ */
.op-stats-vast {
    background: var(--indigo);
    padding: 10rem 0;
    color: white;
}

.vast-stats-grid {
    display: flex;
    justify-content: space-around;
    max-width: 1200px;
    margin: 0 auto;
}

.stat-vast-item text-align: center;
.stat-vast-num {
    font-family: var(--serif);
    font-size: 6rem;
    color: var(--gold);
}
.stat-vast-label {
    font-size: 10px;
    letter-spacing: 0.5em;
    text-transform: uppercase;
    opacity: 0.5;
}

/* ═════ 4. CTA: FINAL HARMONY ═════ */
.final-cta-vast {
    padding: 20rem 0;
    text-align: center;
}

.final-cta-vast h2 {
    font-family: var(--serif);
    font-size: clamp(3rem, 8vw, 8rem);
    font-style: italic;
    line-height: 0.9;
    margin-bottom: 5rem;
}

.btn-vast {
    padding: 1.5rem 5rem;
    background: var(--indigo);
    color: white;
    text-decoration: none;
    font-size: 11px;
    letter-spacing: 0.5em;
    text-transform: uppercase;
    transition: 0.5s;
}

.btn-vast:hover {
    background: var(--gold);
    letter-spacing: 0.7em;
}

@media (max-width: 1024px) {
    .editorial-spread { grid-template-columns: 1fr !important; gap: 4rem; }
    .editorial-spread.reverse .editorial-text { order: 0; }
    .editorial-img-frame { height: 50vh; }
    .vast-stats-grid { flex-direction: column; gap: 5rem; }
}
</style>
@endpush

<div id="op-page">

    <!-- HERO SECTION -->
    <section class="op-hero-vast">
        <div class="op-hero-img-bg" id="heroImg">
            <img src="{{ asset('img/France.jpg') }}" alt="UNESCO Heritage">
        </div>
        <div class="op-hero-content">
            <span class="op-hero-eyebrow">A World Heritage Legacy</span>
            <h1 class="op-hero-title">Harmoni</h1>
            <p style="letter-spacing: 0.5em; text-transform: uppercase; font-size: 12px; margin-top: 2rem;">Beyond The Saung</p>
        </div>
    </section>

    <!-- PILAR 1: ARUMBA -->
    <section class="pillar-section">
        <div class="pillar-container">
            
            <div class="editorial-spread reveal">
                <div class="editorial-img-frame">
                    <img src="{{ asset('img/arumba222.webp') }}" alt="Arumba Performance">
                </div>
                <div class="editorial-text">
                    <span class="pillar-num">01</span>
                    <h2 class="font-editorial">Arumba <br><i>Performance</i></h2>
                    <p>Musik bambu kontemporer yang dinamis. Paduan unik antara tradisi dan modernitas, dirancang khusus untuk panggung gala dan korporat internasional.</p>
                    <div style="margin-top: 3rem; width: 50px; height: 1px; background: var(--gold);"></div>
                </div>
            </div>

            <!-- PILAR 2: INTERAKTIF (REVERSE) -->
            <div class="editorial-spread reverse reveal">
                <div class="editorial-img-frame">
                    <img src="{{ asset('img/Interaksi.webp') }}" alt="Interactive Performance">
                </div>
                <div class="editorial-text">
                    <span class="pillar-num">02</span>
                    <h2 class="font-editorial">Angklung <br><i>Interaktif</i></h2>
                    <p>Pengalaman magis yang menyatukan ribuan orang dalam satu harmoni. Dari festival budaya hingga diplomasi kenegaraan di lima benua.</p>
                    <div style="margin-top: 3rem; width: 50px; height: 1px; background: var(--gold);"></div>
                </div>
            </div>

            <!-- PILAR 3: ORKESTRA -->
            <div class="editorial-spread reveal">
                <div class="editorial-img-frame">
                    <img src="{{ asset('img/France.jpg') }}" alt="Orchestra Collaboration">
                </div>
                <div class="editorial-text">
                    <span class="pillar-num">03</span>
                    <h2 class="font-editorial">Kolaborasi <br><i>Orkestra</i></h2>
                    <p>Pertunjukan megah di mana bambu bersanding dengan instrumen klasik barat. Sebuah pembuktian bahwa angklung adalah bahasa universal dunia.</p>
                    <div style="margin-top: 3rem; width: 50px; height: 1px; background: var(--gold);"></div>
                </div>
            </div>

        </div>
    </section>

    <!-- STATS VAST -->
    <section class="op-stats-vast">
        <div class="vast-stats-grid">
            <div class="stat-vast-item reveal">
                <p class="stat-vast-num">55+</p>
                <p class="stat-vast-label">Negara</p>
            </div>
            <div class="stat-vast-item reveal" style="transition-delay: 0.2s;">
                <p class="stat-vast-num">5</p>
                <p class="stat-vast-label">Benua</p>
            </div>
            <div class="stat-vast-item reveal" style="transition-delay: 0.4s;">
                <p class="stat-vast-num">UNESCO</p>
                <p class="stat-vast-label">Heritage Status</p>
            </div>
        </div>
    </section>


<!-- FINAL CTA -->
<section class="final-cta-vast">
    <div class="reveal">
        <p style="letter-spacing: 0.6em; text-transform: uppercase; font-size: 10px; margin-bottom: 3rem; color: var(--gold); font-weight: 700;">Global Partnership</p>
        
        <!-- Kalimat ajakan yang lebih menggetarkan -->
        <h2>Hadirkan denting bambu <br><i>di panggung Anda.</i></h2>
        
        <div style="margin-top: 8rem;">
            <!-- Tombol dengan teks baru yang lebih elegan -->
            <a href="https://wa.me/6282182821200" class="btn-vast">Reservasi Kolaborasi Budaya</a>
        </div>
        
        <p style="margin-top: 4rem; font-size: 11px; opacity: 0.4; letter-spacing: 0.2em;">SAUNG ANGKLUNG UDJO • BANDUNG, INDONESIA</p>
    </div>
</section>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    gsap.registerPlugin(ScrollTrigger);

    // Hero Zoom Out Effect on Scroll
    gsap.to("#heroImg", {
        scrollTrigger: {
            trigger: ".op-hero-vast",
            start: "top top",
            scrub: true
        },
        scale: 1,
        opacity: 0.2
    });

    // Reveal elements
    const reveals = document.querySelectorAll('.reveal');
    reveals.forEach((el) => {
        gsap.from(el, {
            scrollTrigger: {
                trigger: el,
                start: "top 85%",
            },
            y: 100,
            opacity: 0,
            duration: 1.5,
            ease: "expo.out"
        });
    });
});
</script>
@endpush

@endsection