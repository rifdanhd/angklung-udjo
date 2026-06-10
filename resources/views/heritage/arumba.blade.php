{{-- resources/views/heritage/arumba.blade.php --}}
@extends('layouts.app')

@section('title', 'Ansambel Arumba - Melodi Modern Bambu')

@section('content')

    {{-- 1. STYLES: CONTEMPORARY EDITORIAL STYLE --}}
    @push('styles')
        <style>
            :root {
                --indigo-deep: #1a1445;
                --gold-premium: #c4a47c;
                --v-gray: #f8f8f7;
            }

            body { font-family: 'Inter', sans-serif; color: var(--indigo-deep); background-color: #fff; }
            .font-editorial { font-family: 'Libre Baskerville', serif; }
            .font-spirax { font-family: 'Spirax', cursive; }
            
            .text-spacing-sm { text-transform: uppercase; letter-spacing: 0.3em; font-size: 0.65rem; font-weight: 700; }
            .text-spacing-lg { text-transform: uppercase; letter-spacing: 0.5em; font-size: 0.75rem; font-weight: 800; }

            /* Hero Layout */
            .hero-arumba { height: 65vh; position: relative; overflow: hidden; background: #000; display: flex; align-items: center; justify-content: center; }
            .hero-bg { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.5; }
            .hero-overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, transparent 0%, var(--indigo-deep) 100%); }

            /* Reveal System */
            .reveal { opacity: 0; transform: translateY(20px); transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1); visibility: hidden; }
            .reveal.active { opacity: 1 !important; transform: translateY(0) !important; visibility: visible !important; }

            /* Instrument Display */
            .instrument-card {
                position: relative;
                padding-bottom: 2rem;
                border-bottom: 1px solid rgba(26, 20, 69, 0.1);
                transition: all 0.5s ease;
            }
            .instrument-card:hover { border-bottom-color: var(--gold-premium); }

            section { margin: 0 !important; }
        </style>
    @endpush

    <!-- 1. HERO SECTION -->
    <section class="hero-arumba">
        <img src="{{ asset('img/calung.jpg') }}" onerror="this.src='https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=2000'" class="hero-bg">
        <div class="hero-overlay"></div>
        <div class="relative z-10 text-center text-white">
            <p class="reveal text-spacing-lg text-gold-premium mb-6 uppercase">The Contemporary Sound</p>
            <h1 class="reveal font-spirax text-6xl md:text-9xl leading-none italic">Arumba</h1>
        </div>
    </section>

    <!-- 2. DEFINISI ARUMBA (EDITORIAL STORY) -->
    <section class="py-32 bg-white">
        <div class="max-w-[1300px] mx-auto px-10">
            <div class="grid lg:grid-cols-2 gap-24 items-center">
                <div class="reveal">
                    <p class="text-spacing-lg text-gray-400 mb-8 font-bold uppercase">Alunan Rumpun Bambu</p>
                    <h2 class="font-editorial text-4xl md:text-6xl text-indigo-950 leading-tight mb-10">
                        Evolusi Musik <br> <span class="text-gold-premium italic font-normal">Tanah Pasundan.</span>
                    </h2>
                    <div class="w-24 h-0.5 bg-gold-premium"></div>
                </div>
                <div class="reveal" style="transition-delay: 200ms;">
                    <p class="text-gray-500 text-lg leading-loose mb-8 font-light italic">
                        Lahir dari semangat inovasi, Arumba adalah ansambel musik yang terdiri dari berbagai instrumen bambu bernada diatonis. Jika Angklung adalah jiwa, maka Arumba adalah raga musik kontemporer yang membawa nada-nada tradisional ke ranah musik populer dunia.
                    </p>
                    <p class="text-gray-500 text-lg leading-loose font-light">
                        Keindahan Arumba terletak pada kemampuannya membawakan berbagai genre lagu—mulai dari pop, jazz, hingga klasik—tanpa menghilangkan identitas suara bambu yang hangat dan organik.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. INSTRUMENTATION (THE ANATOMY OF ARUMBA) -->
    <section class="py-32 bg-v-gray">
        <div class="max-w-[1400px] mx-auto px-10">
            <div class="text-center mb-24 reveal">
                <p class="text-spacing-lg text-gray-400 mb-6 uppercase font-bold">Komponen Ensembel</p>
                <h3 class="font-editorial text-5xl text-indigo-950 italic">Keluarga Arumba</h3>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-20 gap-y-16">
                <!-- Gambang Melodi -->
                <div class="reveal instrument-card">
                    <span class="font-editorial text-gold-premium text-3xl mb-4 block">01</span>
                    <h4 class="font-bold text-indigo-950 uppercase tracking-widest text-sm mb-4">Gambang Melodi</h4>
                    <p class="text-gray-500 text-sm leading-relaxed font-light">Inti dari Arumba yang membawakan garis melodi utama. Memiliki rentang nada yang luas untuk mengekspresikan komposisi musik yang kompleks.</p>
                </div>
                <!-- Gambang Pengiring -->
                <div class="reveal instrument-card" style="transition-delay: 100ms;">
                    <span class="font-editorial text-gold-premium text-3xl mb-4 block">02</span>
                    <h4 class="font-bold text-indigo-950 uppercase tracking-widest text-sm mb-4">Gambang Pengiring</h4>
                    <p class="text-gray-500 text-sm leading-relaxed font-light">Berperan memberikan irama dan harmoni (chord), mengisi kekosongan antara melodi dan bass untuk tekstur suara yang penuh.</p>
                </div>
                <!-- Bass Bambu -->
                <div class="reveal instrument-card" style="transition-delay: 200ms;">
                    <span class="font-editorial text-gold-premium text-3xl mb-4 block">03</span>
                    <h4 class="font-bold text-indigo-950 uppercase tracking-widest text-sm mb-4">Bass Bambu</h4>
                    <p class="text-gray-500 text-sm leading-relaxed font-light">Tabung bambu raksasa yang menghasilkan dentuman rendah yang dalam, memberikan nyawa ritem pada setiap pertunjukan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. VISUAL SHOWCASE (EDITORIAL MOSAIC) -->
    <section class="py-32 bg-white overflow-hidden">
        <div class="max-w-[1300px] mx-auto px-10 grid lg:grid-cols-2 gap-24 items-center">
            <div class="reveal order-2 lg:order-1">
                <p class="text-spacing-lg text-gray-400 mb-8 font-bold uppercase">Keunggulan</p>
                <h3 class="font-editorial text-4xl md:text-5xl text-indigo-950 leading-tight mb-10 italic">Resonansi yang <br> Menggugah Jiwa</h3>
                <p class="text-gray-500 text-lg leading-loose mb-10 font-light">
                    Instrumen Arumba di Saung Angklung Udjo dibuat dengan presisi tinggi oleh para pengrajin berpengalaman. Penggunaan bambu hitam pilihan memastikan setiap ketukan Gambang menghasilkan suara yang bulat, jernih, dan penuh kehangatan.
                </p>
                <div class="p-8 bg-v-gray border-l-4 border-indigo-950">
                    <p class="text-indigo-950 font-editorial text-xl italic">"Arumba membawa musik bambu melampaui batas tradisional, menjadi bahasa universal bagi semua generasi."</p>
                </div>
            </div>
            <div class="reveal order-1 lg:order-2" style="transition-delay: 300ms;">
                <img src="https://images.unsplash.com/photo-1465821508027-567382d22a0a?q=80&w=1500" class="w-full h-auto shadow-2xl rounded-[3rem]">
            </div>
        </div>
    </section>

    <!-- 5. FINAL CTA -->
    <section class="relative h-[60vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('img/performance.jpg') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-[#1a1445]/85 backdrop-blur-[1px]"></div>
        </div>
        <div class="relative z-10 text-center text-white px-6">
            <p class="reveal text-spacing-lg text-amber-500 mb-8 font-bold uppercase">Saksikan Sekarang</p>
            <h2 class="reveal font-editorial text-5xl md:text-7xl leading-tight mb-14 italic">Dengarkan harmoni <br> Arumba di panggung.</h2>
            <div class="reveal" style="transition-delay: 400ms;">
                <a href="{{ route('experience.performances') }}" class="inline-block bg-white text-indigo-950 px-14 py-5 text-[10px] font-bold uppercase tracking-[0.3em] hover:bg-gold-premium hover:text-white transition-all shadow-2xl border-none">Lihat Jadwal Pertunjukan</a>
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
            }, { threshold: 0.15 });
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });
    </script>
    @endpush

@endsection