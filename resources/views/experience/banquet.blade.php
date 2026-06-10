@extends('layouts.app')

@section('title', 'SAU Banquet - Hospitality & Taste')

@section('content')

    @push('styles')
        <style>
            :root {
                --indigo-deep: #1a1445;
                --gold-premium: #c4a47c;
                --v-bg-cream: #FAF8F4;
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

            .text-spacing-lg {
                text-transform: uppercase;
                letter-spacing: 0.5em;
                font-size: 0.75rem;
                font-weight: 800;
            }

            /* Hero Enhancements */
            .hero-banquet {
                height: 75vh;
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
                opacity: 0.6;
                transform: scale(1.1);
                transition: transform 10s ease;
            }

            .hero-banquet:hover .hero-bg {
                transform: scale(1);
            }

            .hero-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(to bottom, transparent 20%, var(--indigo-deep) 100%);
            }

            /* Card Enhancements */
            .package-card {
                background: white;
                border: 1px solid rgba(196, 164, 124, 0.15);
                transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
                position: relative;
            }

            .package-card:hover {
                border-color: var(--gold-premium);
                transform: translateY(-12px);
                box-shadow: 0 20px 40px rgba(26, 20, 69, 0.05);
            }

            .package-card::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 4px;
                background: var(--gold-premium);
                transform: scaleX(0);
                transition: transform 0.5s ease;
            }

            .package-card:hover::before {
                transform: scaleX(1);
            }

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

            .price-tag {
                font-variant-numeric: tabular-nums;
            }
        </style>
    @endpush

    <!-- Hero Section -->
    <section class="hero-banquet">
        <img src="https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?q=80&w=2000" class="hero-bg"
            alt="Sundanese Banquet">
        <div class="hero-overlay"></div>
        <div class="relative z-10 text-center text-white px-6">
            <p class="reveal text-spacing-lg text-gold-premium mb-8 uppercase">Authentic Hospitality</p>
            <h1 class="reveal font-editorial text-5xl md:text-[7rem] leading-none italic">Dapoer Angklung</h1>
            <p class="reveal text-gray-300 mt-6 max-w-2xl mx-auto font-light tracking-wide text-lg">Menciptakan harmoni rasa
                dan tradisi untuk perjamuan istimewa Anda.</p>
        </div>
    </section>

    <!-- Intro Section -->
    <section class="py-24">
        <div class="max-w-[1300px] mx-auto px-10 grid lg:grid-cols-2 gap-16 items-center">
            <div class="reveal">
                <p class="text-spacing-lg text-gray-400 mb-6 font-bold uppercase tracking-[0.3em]">The Heritage</p>
                <h2 class="font-editorial text-5xl md:text-7xl text-indigo-950 leading-tight mb-8 italic">
                    Tradisi <br> <span class="text-gold-premium not-italic">Tanah Pasundan.</span>
                </h2>
                <div class="w-24 h-1 bg-gold-premium"></div>
            </div>
            <div class="reveal">
                <p class="text-gray-600 text-xl leading-relaxed font-light mb-8">
                    Dapoer Angklung Udjo bukan sekadar tempat makan; kami adalah perayaan budaya. Terletak di kawasan
                    legendaris Padasuka, kami menyajikan kehangatan perjamuan Sunda dengan sentuhan profesional untuk
                    kebutuhan korporasi maupun keluarga.
                </p>
                <div class="grid grid-cols-2 gap-4 text-sm font-bold uppercase tracking-wider text-indigo-900">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-gold-premium"></div> Wedding & Gala
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-gold-premium"></div> Corporate Meeting
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Packages Section -->
    <section class="py-32">
        <div class="max-w-[1400px] mx-auto px-10">
            <div class="text-center mb-24 reveal">
                <p class="text-spacing-lg text-gray-400 mb-6 uppercase">Curated Menu</p>
                <h3 class="font-editorial text-5xl text-indigo-950 italic">Seri Paket Unggulan</h3>
            </div>

            <div class="grid md:grid-cols-3 gap-10">
                <!-- Paket Awi Gombong -->
                <div class="reveal package-card p-10 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-6">
                            <h4 class="font-editorial text-3xl italic">Awi Gombong</h4>
                            <span
                                class="text-[10px] border border-gold-premium text-gold-premium px-2 py-1 uppercase tracking-widest">Most
                                Popular</span>
                        </div>
                        <p class="text-gold-premium font-bold text-2xl mb-8 price-tag">Rp. 75.000 <span
                                class="text-xs text-gray-400 font-normal">/ net pax</span></p>

                        <div class="space-y-6 mb-10">
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-3 font-bold">Pilihan Menu
                                    Utama</p>
                                <ul class="text-sm text-gray-600 space-y-2">
                                    <li class="flex items-start gap-2">• <span>Nasi Putih / Nasi Liwet</span></li>
                                    <li class="flex items-start gap-2">• <span>Ayam Bumbu Cobek / Cabe Ijo</span></li>
                                    <li class="flex items-start gap-2">• <span>Ikan Bumbu Kecombrang</span></li>
                                    <li class="flex items-start gap-2">• <span>Tahu Bacem & Lalaban</span></li>
                                </ul>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-3 font-bold">Pelengkap</p>
                                <ul class="text-sm text-gray-600 space-y-2">
                                    <li>• Sambal Goreng & Kerupuk Kampung</li>
                                    <li>• Irisan Buah Segar</li>
                                    <li>• Mineral Water & Teh Tawar</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paket Awi Bitung (Highlighted) -->
                <div class="reveal package-card p-10 bg-indigo-950 text-white" style="transition-delay: 200ms;">
                    <div>
                        <div class="flex justify-between items-start mb-6 text-white">
                            <h4 class="font-editorial text-3xl italic">Awi Bitung</h4>
                        </div>
                        <p class="text-gold-premium font-bold text-2xl mb-8 price-tag">Rp. 85.000 <span
                                class="text-xs text-gray-300 font-normal">/ net pax</span></p>

                        <div class="space-y-6 mb-10">
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-gold-premium mb-3 font-bold">Premium
                                    Selection</p>
                                <ul class="text-sm text-gray-200 space-y-2">
                                    <li class="flex items-start gap-2">• <span>Nasi Putih / Nasi Liwet</span></li>
                                    <li class="flex items-start gap-2">• <span>Ayam Tulang Lunak / Rica-Rica</span></li>
                                    <li class="flex items-start gap-2">• <span>Ikan Fillet / Gepuk Suir</span></li>
                                    <li class="flex items-start gap-2">• <span>Urab Sayur / Pencok Kacang</span></li>
                                </ul>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-gold-premium mb-3 font-bold">Included
                                </p>
                                <ul class="text-sm text-gray-200 space-y-2">
                                    <li>• Gendar & Sambal Dadak</li>
                                    <li>• Dessert (Buah Segar)</li>
                                    <li>• Free Flow Teh Tawar & Mineral</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paket Angklung (Nasional) -->
                <div class="reveal package-card p-10 flex flex-col justify-between" style="transition-delay: 400ms;">
                    <div>
                        <div class="flex justify-between items-start mb-6">
                            <h4 class="font-editorial text-3xl italic">Paket Angklung</h4>
                        </div>
                        <p class="text-gold-premium font-bold text-2xl mb-8 price-tag">Rp. 95.000 <span
                                class="text-xs text-gray-400 font-normal">/ net pax</span></p>

                        <div class="space-y-6 mb-10">
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-3 font-bold">National
                                    Buffet Selection</p>
                                <ul class="text-sm text-gray-600 space-y-2">
                                    <li class="flex items-start gap-2">• <span>Nasi Putih & Nasi Goreng</span></li>
                                    <li class="flex items-start gap-2">• <span>Ayam Saos Lemon / Teriyaki</span></li>
                                    <li class="flex items-start gap-2">• <span>Kakap Bakar / Sambal Matah</span></li>
                                    <li class="flex items-start gap-2">• <span>Cah Daging Sapi / Beef Teriyaki</span></li>
                                </ul>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-3 font-bold">Exotic
                                    Desserts</p>
                                <ul class="text-sm text-gray-600 space-y-2">
                                    <li>• Es Kelapa Muda / Sarang Burung</li>
                                    <li>• Salad Buah Segar</li>
                                    <li>• Kerupuk Udang & Acar</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Stalls & Boxes Section -->
    <section class="py-24 bg-[#1a1445] text-white overflow-hidden relative">
        <!-- Background Decoration yang lebih halus -->
        <div class="absolute right-0 top-1/2 -translate-y-1/2 opacity-[0.03] pointer-events-none select-none">
            <h2 class="text-[25rem] font-bold leading-none tracking-tighter">MENU</h2>
        </div>

        <div class="max-w-[1300px] mx-auto px-10 relative z-10">
            <div class="grid lg:grid-cols-12 gap-16 items-center">

                <!-- Left Side: Stalls -->
                <div class="lg:col-span-7 reveal">
                    <p class="text-spacing-lg text-gold-premium mb-6 font-bold tracking-[0.3em]">SIDE DISHES & STALLS</p>
                    <h2 class="font-editorial text-5xl md:text-6xl italic mb-14 leading-[1.1]">Lengkapi Momen <br> Dengan
                        Menu Stall.</h2>

                    <div class="grid sm:grid-cols-2 gap-12">
                        <div
                            class="border-l-[3px] border-gold-premium pl-8 py-2 group hover:bg-white/5 transition-all duration-300">
                            <h5 class="text-gold-premium font-bold uppercase tracking-[0.2em] text-[11px] mb-3">ANEKA
                                GUBUKAN</h5>
                            <p class="text-2xl italic font-editorial leading-snug mb-2">Mie Kocok / Batagor / Cuankie</p>
                            <p class="text-sm text-gray-400 font-light">Rp. 25.000 <span class="text-[10px] ml-1">/
                                    PAX</span></p>
                        </div>
                        <div
                            class="border-l-[3px] border-gold-premium pl-8 py-2 group hover:bg-white/5 transition-all duration-300">
                            <h5 class="text-gold-premium font-bold uppercase tracking-[0.2em] text-[11px] mb-3">TRADISI
                                MANIS</h5>
                            <p class="text-2xl italic font-editorial leading-snug mb-2">Es Cendol / Es Cingcau</p>
                            <p class="text-sm text-gray-400 font-light">Rp. 15.000 <span class="text-[10px] ml-1">/
                                    PAX</span></p>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Glassmorphism Card -->
                <div class="lg:col-span-5 reveal" style="transition-delay: 200ms;">
                    <div class="bg-white/[0.07] backdrop-blur-xl p-10 md:p-12 border border-white/10 shadow-2xl rounded-sm">
                        <h3 class="font-editorial text-3xl italic mb-6 border-b border-gold-premium/30 pb-4">Paket Leueuteun
                            <span class="text-sm not-italic font-sans opacity-60 ml-2">(Nasi Box)</span></h3>
                        <p class="text-gray-100 text-sm mb-10 leading-relaxed font-light opacity-80">
                            Solusi praktis untuk acara meeting atau gathering luar ruangan dengan cita rasa yang tetap
                            terjaga.
                        </p>

                        <div class="space-y-6">
                            <div class="flex justify-between items-end group">
                                <span
                                    class="text-lg font-light tracking-wide group-hover:text-gold-premium transition-colors">Paket
                                    Tradisional</span>
                                <div class="flex-grow border-b border-white/10 mx-4 mb-1 border-dotted"></div>
                                <span class="text-gold-premium font-bold font-sans">Rp 23.000</span>
                            </div>
                            <div class="flex justify-between items-end group">
                                <span
                                    class="text-lg font-light tracking-wide group-hover:text-gold-premium transition-colors">Paket
                                    Nasional</span>
                                <div class="flex-grow border-b border-white/10 mx-4 mb-1 border-dotted"></div>
                                <span class="text-gold-premium font-bold font-sans">Rp 34.000</span>
                            </div>
                            <div class="flex justify-between items-end group">
                                <span
                                    class="text-lg font-light tracking-wide group-hover:text-gold-premium transition-colors">Paket
                                    Pelajar</span>
                                <div class="flex-grow border-b border-white/10 mx-4 mb-1 border-dotted"></div>
                                <div class="text-right">
                                    <span class="block text-[9px] uppercase tracking-tighter opacity-50 mb-1">MULAI
                                        DARI</span>
                                    <span class="text-gold-premium font-bold font-sans">Rp 34.000</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tambahan Tombol Pesan Kecil di dalam box (Optional) -->
                        <button
                            class="w-full mt-10 py-4 border border-white/20 text-[10px] tracking-[0.3em] font-bold uppercase hover:bg-gold-premium hover:border-gold-premium transition-all duration-300">
                            Pesan Nasi Box
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Final Call to Action -->
    <section class="relative py-32 bg-[#FAF8F4] text-center overflow-hidden">
        <div class="max-w-4xl mx-auto px-6">
            <p class="reveal text-spacing-lg text-gray-400 mb-8 uppercase tracking-[0.4em]">Reservations</p>
            <h2 class="reveal font-editorial text-5xl md:text-6xl mb-12 italic leading-tight text-indigo-950">Rencanakan
                Perjamuan Anda Bersama Kami</h2>
            <div class="reveal flex flex-col md:flex-row gap-6 justify-center items-center">
                <a href="https://wa.me/6285853504711"
                    class="inline-block bg-indigo-950 text-white px-12 py-5 text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-gold-premium transition-all duration-500">
                    Hubungi Sales Executive
                </a>
                <a href="#"
                    class="inline-block border border-indigo-950 text-indigo-950 px-12 py-5 text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-indigo-950 hover:text-white transition-all duration-500">
                    Unduh Katalog Menu (PDF)
                </a>
            </div>
            <p class="mt-16 text-[10px] text-gray-400 uppercase tracking-widest">Dapoer Angklung - Jl. Padasuka No. 118
                Bandung</p>
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
