{{-- resources/views/heritage/angklung-unit.blade.php --}}
@extends('layouts.app')

@section('title', 'Unit Angklung - Simfoni Harmoni Bangsa')

@section('content')

    {{-- 1. STYLES: MINIMALIST ORCHESTRA STYLE --}}
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
            .hero-unit { height: 60vh; position: relative; overflow: hidden; background: #000; display: flex; align-items: center; justify-content: center; }
            .hero-bg { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.5; }
            .hero-overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, transparent 0%, var(--indigo-deep) 100%); }

            /* Reveal System */
            .reveal { opacity: 0; transform: translateY(20px); transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1); visibility: hidden; }
            .reveal.active { opacity: 1 !important; transform: translateY(0) !important; visibility: visible !important; }

            /* Unit Classification Card */
            .unit-card {
                padding: 3rem;
                border: 1px solid rgba(26, 20, 69, 0.05);
                transition: all 0.5s ease;
                background: white;
            }
            .unit-card:hover { border-color: var(--gold-premium); transform: translateY(-10px); box-shadow: 0 30px 60px rgba(0,0,0,0.05); }

            .instrument-dot { width: 6px; height: 6px; background: var(--gold-premium); border-radius: 50%; display: inline-block; margin-right: 12px; }

            section { margin: 0 !important; }
        </style>
    @endpush

    <!-- 1. HERO SECTION -->
    <section class="hero-unit">
        <img src="{{ asset('img/orkes.jpg') }}" onerror="this.src='https://images.unsplash.com/photo-1516280440614-37939bbacd81?q=80&w=2000'" class="hero-bg">
        <div class="hero-overlay"></div>
        <div class="relative z-10 text-center text-white">
            <p class="reveal text-spacing-lg text-gold-premium mb-6">Orchestration</p>
            <h1 class="reveal font-editorial text-5xl md:text-8xl leading-tight italic">Unit Angklung</h1>
        </div>
    </section>

    <!-- 2. DEFINISI UNIT -->
    <section class="py-32 bg-white">
        <div class="max-w-[1300px] mx-auto px-10">
            <div class="grid lg:grid-cols-2 gap-24 items-start">
                <div class="reveal">
                    <p class="text-spacing-lg text-gray-400 mb-8 font-bold uppercase">Satu Suara, Satu Orkestra</p>
                    <h2 class="font-editorial text-4xl md:text-6xl text-indigo-950 leading-tight mb-10">
                        Kesatuan Dalam <br> <span class="text-gold-premium italic font-normal">Resonansi.</span>
                    </h2>
                    <div class="w-24 h-0.5 bg-gold-premium"></div>
                </div>
                <div class="reveal" style="transition-delay: 200ms;">
                    <p class="text-gray-500 text-lg leading-loose mb-8 font-light italic">
                        Unit Angklung adalah seperangkat instrumen musik yang membentuk sebuah orkestrasi lengkap. Di Saung Angklung Udjo, setiap unit disusun secara matang untuk menghasilkan harmoni yang presisi, mulai dari melodi hingga irama pengiring.
                    </p>
                    <p class="text-gray-500 text-lg leading-loose font-light">
                        Pembagian unit ini didasarkan pada jumlah pemain dan kebutuhan panggung, memastikan getaran bambu tersampaikan dengan kekuatan penuh ke telinga pendengar.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. INSTRUMENT ROLES (THE 4 PILLARS) -->
    <section class="py-32 bg-v-gray">
        <div class="max-w-[1400px] mx-auto px-10">
            <div class="text-center mb-24 reveal">
                <p class="text-spacing-lg text-gray-400 mb-6 uppercase font-bold">Struktur Orkestra</p>
                <h3 class="font-editorial text-5xl text-indigo-950 italic">Komponen Utama Unit</h3>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Melody -->
                <div class="reveal unit-card">
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-4">Angklung Melody</h4>
                    <p class="text-gray-400 text-sm leading-relaxed font-light">Pembawa nada utama dalam lagu. Terdiri dari 2 sampai 3 tabung suara untuk mempernyaring intonasi.</p>
                </div>
                <!-- Accompaniment -->
                <div class="reveal unit-card" style="transition-delay: 100ms;">
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-4">Akompanyemen</h4>
                    <p class="text-gray-400 text-sm leading-relaxed font-light">Bertugas sebagai pengiring lagu (chord). Menggunakan akor Mayor dan Minor yang kompleks.</p>
                </div>
                <!-- Bass -->
                <div class="reveal unit-card" style="transition-delay: 200ms;">
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-4">Bass Party</h4>
                    <p class="text-gray-400 text-sm leading-relaxed font-light">Memberikan pondasi nada rendah (oktaf bawah) yang mantap untuk memperdalam tekstur musik.</p>
                </div>
                <!-- Cuk -->
                <div class="reveal unit-card" style="transition-delay: 300ms;">
                    <h4 class="font-editorial text-2xl text-indigo-950 mb-4">Angklung Cuk</h4>
                    <p class="text-gray-400 text-sm leading-relaxed font-light">Pengiring bernada tinggi yang memberikan ritme dinamis, layaknya fungsi Ukulele.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. CLASSIFICATION (QATAR PLAN STYLE) -->
    <section class="py-32 bg-white">
        <div class="max-w-[1200px] mx-auto px-10">
            <div class="flex flex-col lg:flex-row justify-between items-end mb-20 gap-8 reveal">
                <div class="max-w-2xl">
                    <p class="text-spacing-lg text-gray-400 mb-6 font-bold uppercase">Klasifikasi Unit</p>
                    <h2 class="font-editorial text-4xl md:text-6xl text-indigo-950 leading-tight italic">Pilih Harmoni Anda</h2>
                </div>
            </div>

            <div class="space-y-8">
                <!-- Unit Kecil -->
                <div class="reveal flex flex-col md:flex-row justify-between p-10 bg-v-gray border-l-4 border-amber-600">
                    <div class="mb-6 md:mb-0">
                        <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Unit Kecil</h4>
                        <p class="text-gray-400 text-sm">Ideal untuk edukasi dasar atau grup kecil.</p>
                    </div>
                    <ul class="text-sm space-y-2">
                        <li><span class="instrument-dot"></span>28 Buah Angklung Melody (2 Set)</li>
                        <li><span class="instrument-dot"></span>11 Buah Angklung ACC</li>
                        <li><span class="instrument-dot"></span>6 Buah Bass Party</li>
                    </ul>
                </div>

                <!-- Unit Sedang -->
                <div class="reveal flex flex-col md:flex-row justify-between p-10 bg-v-gray border-l-4 border-indigo-900" style="transition-delay: 200ms;">
                    <div class="mb-6 md:mb-0">
                        <h4 class="font-editorial text-2xl text-indigo-950 mb-2">Unit Sedang</h4>
                        <p class="text-gray-400 text-sm">Pilihan populer untuk pertunjukan sekolah & instansi.</p>
                    </div>
                    <ul class="text-sm space-y-2">
                        <li><span class="instrument-dot"></span>31 Buah Angklung Melody (2 Set)</li>
                        <li><span class="instrument-dot"></span>13 Buah Angklung ACC</li>
                        <li><span class="instrument-dot"></span>11 Buah Bass Party</li>
                    </ul>
                </div>

                <!-- Unit Besar -->
                <div class="reveal flex flex-col md:flex-row justify-between p-10 bg-[#1a1445] text-white" style="transition-delay: 400ms;">
                    <div class="mb-6 md:mb-0">
                        <h4 class="font-editorial text-2xl text-amber-500 mb-2 italic">Unit Besar (Orkestra)</h4>
                        <p class="text-white/40 text-sm">Standar konser internasional dengan resonansi penuh.</p>
                    </div>
                    <ul class="text-sm space-y-2 text-white/70">
                        <li><span class="instrument-dot"></span>31 Buah Angklung Melody (3 Set)</li>
                        <li><span class="instrument-dot"></span>17 Buah Angklung ACC & Cuk</li>
                        <li><span class="instrument-dot"></span>22 Buah Bass Party (2 Set)</li>
                    </ul>
                </div>
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
            <p class="reveal text-spacing-lg text-amber-500 mb-8 font-bold uppercase">Explore Arumba</p>
            <h2 class="reveal font-editorial text-5xl md:text-7xl leading-tight mb-14 italic">Alunan bambu <br> kontemporer.</h2>
            <div class="reveal" style="transition-delay: 400ms;">
                <a href="#" class="inline-block bg-white text-indigo-950 px-14 py-5 text-[10px] font-bold uppercase tracking-[0.3em] hover:bg-gold-premium hover:text-white transition-all shadow-2xl border-none">Mengenal Ensembel Arumba</a>
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