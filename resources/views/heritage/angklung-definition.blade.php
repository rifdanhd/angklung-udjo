{{-- resources/views/heritage/angklung-definition.blade.php --}}
@extends('layouts.app')

@section('title', 'Definisi & Karakter Angklung - Warisan Dunia')

@section('content')

    {{-- 1. STYLES: EDITORIAL ENCYCLOPEDIA STYLE --}}
    @push('styles')
        <style>
            :root {
                --indigo-deep: #1a1445;
                --gold-premium: #c4a47c;
                --v-bg-cream: #FAF8F4;
                --v-gray: #f8f8f7;
            }

            body { font-family: 'Inter', sans-serif; color: var(--indigo-deep); background-color: var(--v-bg-cream); }
            .font-editorial { font-family: 'Libre Baskerville', serif; }
            .font-spirax { font-family: 'Spirax', cursive; }
            
            .text-spacing-sm { text-transform: uppercase; letter-spacing: 0.35em; font-size: 0.65rem; font-weight: 800; }
            .text-spacing-lg { text-transform: uppercase; letter-spacing: 0.5em; font-size: 0.75rem; font-weight: 800; }

            /* Hero Layout */
            .hero-def { height: 60vh; position: relative; overflow: hidden; background: #000; display: flex; align-items: center; justify-content: center; }
            .hero-bg { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.45; }
            .hero-overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, transparent 0%, var(--indigo-deep) 100%); }

            /* Reveal System */
            .reveal { opacity: 0; transform: translateY(20px); transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1); visibility: hidden; }
            .reveal.active { opacity: 1 !important; transform: translateY(0) !important; visibility: visible !important; }

            /* Custom UI Elements */
            .philosophy-box { border-left: 1px solid rgba(26, 20, 69, 0.1); padding: 0 0 30px 40px; position: relative; }
            .philosophy-box::before { content: ''; position: absolute; left: -5px; top: 0; width: 10px; height: 10px; background: var(--gold-premium); border-radius: 50%; }
            
            section { margin: 0 !important; }
        </style>
    @endpush

    <!-- 1. CINEMATIC HERO -->
    <section class="hero-def">
        <img src="https://images.unsplash.com/photo-1590054030480-2c92bed2199b?q=80&w=2000" class="hero-bg" alt="Bamboo Detail">
        <div class="hero-overlay"></div>
        <div class="relative z-10 text-center text-white">
            <p class="reveal text-spacing-lg text-gold-premium mb-8 uppercase tracking-[0.6em]">The Masterpiece</p>
            <h1 class="reveal font-editorial text-5xl md:text-[7rem] leading-none italic">Definisi & Karakter</h1>
        </div>
    </section>

    <!-- 2. ETIMOLOGI & MAKNA (CHAPTER 1) -->
    <section class="py-32 bg-[#FAF8F4]">
        <div class="max-w-[1300px] mx-auto px-10">
            <div class="grid lg:grid-cols-2 gap-24 items-start border-b border-gray-100 pb-32">
                <div class="reveal">
                    <p class="text-spacing-lg text-gray-400 mb-8 font-bold">Terminologi</p>
                    <h2 class="font-editorial text-5xl md:text-7xl text-indigo-950 leading-tight mb-10 italic">Angka Nada <br> <span class="text-gold-premium not-italic">Yang Bergetar.</span></h2>
                    <div class="w-32 h-0.5 bg-gold-premium mb-12"></div>
                    <p class="text-gray-500 text-lg leading-loose font-light">
                        Secara etimologis, Angklung berasal dari kata <strong>“angka”</strong> (nada) dan <strong>“lung”</strong> (pecah), merujuk pada nada yang tidak lengkap namun menyatu dalam harmoni. Nama ini terinspirasi dari istilah Sunda <em>“angkleung-angkleungan”</em>—gerakan ritmis pemain yang menghasilkan suara “klung” yang ikonik.
                    </p>
                </div>
                <div class="reveal" style="transition-delay: 300ms;">
                    <p class="text-gray-600 text-xl leading-loose font-light italic mb-12">
                        "Tabung angklung mempersonifikasikan manusia. Ia tidak bisa berdiri sendiri; keindahan harmoni hanya tercapai saat kita bergerak bersama dalam gotong royong."
                    </p>
                    <div class="grid grid-cols-2 gap-10">
                        <div>
                            <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Social</h4>
                            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Makhluk Hidup Bersama</p>
                        </div>
                        <div>
                            <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Harmony</h4>
                            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Simfoni Kebersamaan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. ANATOMI INSTRUMEN (CHAPTER 2) -->
    <section class="py-32 bg-white">
        <div class="max-w-[1400px] mx-auto px-10 text-center mb-24">
            <div class="reveal">
                <p class="text-spacing-lg text-gray-400 mb-6 font-bold uppercase">Struktur Fisik</p>
                <h3 class="font-editorial text-5xl text-indigo-950 italic">Bagian-Bagian Angklung</h3>
            </div>
        </div>

        <div class="max-w-[1200px] mx-auto px-10 grid md:grid-cols-3 gap-20">
            <!-- Part 1 -->
            <div class="reveal philosophy-box">
                <h4 class="font-editorial text-2xl text-indigo-950 mb-4">Tabung Sora</h4>
                <p class="text-gray-500 text-sm leading-relaxed font-light">Terdiri dari tabung besar dan kecil. Tabung kecil melambangkan cita-cita, sedangkan tabung besar melambangkan upaya manusia untuk tumbuh menjadi besar.</p>
            </div>
            <!-- Part 2 -->
            <div class="reveal philosophy-box" style="transition-delay: 200ms;">
                <h4 class="font-editorial text-2xl text-indigo-950 mb-4">Ancak (Rangka)</h4>
                <p class="text-gray-500 text-sm leading-relaxed font-light">Penyangga utama yang mengunci seluruh bagian. Melambangkan prinsip hidup dan batasan diri yang harus dipahami oleh setiap manusia.</p>
            </div>
            <!-- Part 3 -->
            <div class="reveal philosophy-box" style="transition-delay: 400ms;">
                <h4 class="font-editorial text-2xl text-indigo-950 mb-4">Palang Gantung</h4>
                <p class="text-gray-500 text-sm leading-relaxed font-light">Bagian yang menjaga tabung suara agar tetap pada posisinya, memberikan kestabilan dalam menciptakan resonansi nada.</p>
            </div>
        </div>
    </section>

    <!-- 4. SAINS DI BALIK BAMBU (CHAPTER 3) -->
    <section class="py-32 bg-v-gray">
        <div class="max-w-[1300px] mx-auto px-10 grid lg:grid-cols-2 gap-24 items-center">
            <div class="reveal">
                <div class="relative p-6 bg-white shadow-2xl rounded-sm">
                    <img src="https://images.unsplash.com/photo-1582132333163-270a44638a2e?q=80&w=1200" class="w-full h-auto grayscale hover:grayscale-0 transition-all duration-[2s]">
                    <div class="absolute -bottom-6 -right-6 bg-gold-premium p-8 text-white hidden md:block">
                        <p class="font-editorial text-lg italic uppercase">Tanaman Ajaib</p>
                        <p class="text-[9px] uppercase tracking-widest mt-2">Famili Gramineae</p>
                    </div>
                </div>
            </div>
            <div class="reveal" style="transition-delay: 300ms;">
                <p class="text-spacing-lg text-gray-400 mb-8 font-bold uppercase tracking-[0.5em]">Karakteristik Materi</p>
                <h3 class="font-editorial text-4xl md:text-6xl text-indigo-950 leading-tight mb-10 italic">Bambu Hitam <br> <span class="text-gold-premium not-italic">& Resonansi.</span></h3>
                <p class="text-gray-500 text-lg leading-loose mb-10 font-light">
                    Bambu adalah penghuni bumi tertua sejak 200 juta tahun lalu. Kami menggunakan spesies terbaik seperti <strong>Bambu Hitam (Awi Hideung)</strong> dan <strong>Bambu Tali</strong> karena kepadatan seratnya yang mampu meminimalkan perubahan nada akibat cuaca.
                </p>
                <ul class="space-y-6">
                    <li class="flex items-center gap-4 text-xs font-bold text-indigo-950 uppercase tracking-widest"><span class="w-6 h-px bg-gold-premium"></span> Elastisitas Terukur</li>
                    <li class="flex items-center gap-4 text-xs font-bold text-indigo-950 uppercase tracking-widest"><span class="w-6 h-px bg-gold-premium"></span> Adaptasi Iklim Tropis</li>
                    <li class="flex items-center gap-4 text-xs font-bold text-indigo-950 uppercase tracking-widest"><span class="w-6 h-px bg-gold-premium"></span> Ketahanan Organik</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- 5. ABAH UDJO PHILOSOPHY (BBC) -->
    <section class="py-32 bg-[#1a1445] text-white overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-10 grid lg:grid-cols-2 gap-24 items-center">
            <div class="reveal">
                <p class="text-spacing-lg text-gold-premium mb-8 font-bold">Visi Maestro</p>
                <h2 class="font-editorial text-5xl md:text-7xl leading-[1.1] mb-12 italic">Bambu, Pisang, <br> & Kelapa.</h2>
                <p class="text-white/50 text-xl leading-loose font-light italic mb-10">
                    "Abah Udjo mewujudkan cintanya pada alam melalui konsep BBC (Bamboo, Banana, Coconut). Tiga tanaman yang tak boleh sembarangan ditebang demi menjaga keseimbangan desa."
                </p>
                <div class="w-20 h-px bg-gold-premium"></div>
            </div>
            <div class="reveal" style="transition-delay: 300ms;">
                <div class="p-12 border border-white/10 bg-black/20 backdrop-blur-sm shadow-2xl">
                    <h4 class="font-editorial text-3xl mb-8 text-gold-premium italic">Karakteristik Bambu</h4>
                    <ul class="space-y-8 text-white/70 text-sm font-light leading-relaxed">
                        <li class="flex items-start gap-4"><span class="text-gold-premium font-bold italic">01.</span> Bersifat lentur, berbuku-buku, dan tumbuh berkelompok melambangkan kekuatan masyarakat.</li>
                        <li class="flex items-start gap-4"><span class="text-gold-premium font-bold italic">02.</span> Mampu tumbuh hingga 121 cm dalam 24 jam—tanaman dengan pertumbuhan tercepat di dunia.</li>
                        <li class="flex items-start gap-4"><span class="text-gold-premium font-bold italic">03.</span> Panen dilakukan pada umur 3-4 tahun untuk mendapatkan kepadatan suara yang jernih.</li>
                    </ul>
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
            }, { threshold: 0.15 });
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });
    </script>
    @endpush

@endsection