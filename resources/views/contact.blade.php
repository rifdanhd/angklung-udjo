{{-- resources/views/contact.blade.php --}}
@extends('layouts.app', [
    'seoTitle'       => 'Kontak Saung Angklung Udjo — Bandung',
    'seoDescription' => 'Hubungi Saung Angklung Udjo di Jl. Padasuka 118, Bandung. Telepon/WA +62 821 8282 1200 untuk reservasi grup, info pertunjukan, atau partnership.',
    'seoKeywords'    => 'kontak saung angklung udjo, alamat sau bandung, telepon saung angklung udjo, padasuka 118, reservasi grup angklung',
    'seoType'        => 'website',
])

@section('title', 'Kontak Saung Angklung Udjo — Bandung')

@section('content')

    {{-- 1. STYLES: CONTACT LUXURY STYLE --}}
    @push('styles')
        <style>
            :root {
                --indigo-deep: #22185d;
                /* Warna ungu yang disesuaikan */
                --gold-premium: #c4a47c;
                --text-dark: #1a1445;
                --bg-light: #f5f3ed;
                /* Background krem lembut agar serasi */
            }

            body {
                font-family: 'Inter', sans-serif;
                color: var(--indigo-deep);
                background-color: #fff;
            }

            .font-editorial {
                font-family: 'Libre Baskerville', serif;
            }

            .text-spacing-sm {
                text-transform: uppercase;
                letter-spacing: 0.25em;
                font-size: 0.65rem;
                font-weight: 700;
            }

            .text-spacing-lg {
                text-transform: uppercase;
                letter-spacing: 0.35em;
                font-size: 0.75rem;
                font-weight: 800;
            }

            /* Hero Cinematic */
            .hero-contact {
                height: 60vh;
                position: relative;
                overflow: hidden;
                background: #22185d;
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
                transition: transform 10s ease;
            }

            .hero-contact:hover .hero-bg {
                transform: scale(1.05);
            }

            /* Gradient Overlay yang serasi dengan section sebelumnya */
            .hero-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(to bottom, rgba(34, 24, 93, 0.4) 0%, var(--indigo-deep) 100%);
            }

            /* Info Box Style */
            .contact-info-step {
                border-left: 1px solid rgba(34, 24, 93, 0.15);
                padding: 5px 0 30px 30px;
                position: relative;
                transition: all 0.3s ease;
            }

            .contact-info-step:hover {
                border-left-color: var(--gold-premium);
                padding-left: 35px;
            }

            .contact-info-step::before {
                content: '';
                position: absolute;
                left: -5px;
                top: 0;
                width: 9px;
                height: 9px;
                background: var(--gold-premium);
                border-radius: 50%;
            }

            /* Social Icons Button */
            .social-btn {
                width: 45px;
                height: 45px;
                display: flex;
                align-items: center;
                justify-content: center;
                border: 1px solid rgba(34, 24, 93, 0.2);
                border-radius: 50%;
                color: var(--indigo-deep);
                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                background: transparent;
            }

            .social-btn:hover {
                background: var(--indigo-deep);
                color: var(--gold-premium);
                border-color: var(--indigo-deep);
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(34, 24, 93, 0.15);
            }

            .social-btn svg {
                width: 20px;
                height: 20px;
                fill: currentColor;
            }

            /* Reveal System */
            .reveal {
                opacity: 0;
                transform: translateY(30px);
                transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
                visibility: hidden;
            }

            .reveal.active {
                opacity: 1 !important;
                transform: translateY(0) !important;
                visibility: visible !important;
            }

            section {
                margin: 0 !important;
            }
        </style>
    @endpush

    <section class="hero-contact">
        <img src="{{ asset('img/performance.jpg') }}" class="hero-bg"
            alt="Saung Angklung Udjo Contact">
        <div class="hero-overlay"></div>

        <div class="container mx-auto px-6 relative z-10 text-white text-center">
            <div class="max-w-4xl mx-auto">
                <p class="reveal text-spacing-lg text-[#c4a47c] mb-6">Connect with Us</p>
                <h1 class="reveal font-editorial text-5xl md:text-7xl leading-tight" style="transition-delay: 150ms;">
                    Hubungi Kami
                </h1>
            </div>
        </div>
    </section>


    <section class="py-24 md:py-32 bg-white relative">
        <div class="absolute top-0 right-0 w-64 h-64 bg-[#22185d] opacity-[0.03] rounded-full blur-3xl pointer-events-none">
        </div>

        <div class="max-w-[1200px] mx-auto px-6 md:px-10">
            <div class="grid lg:grid-cols-12 gap-16 lg:gap-24">

                <div class="lg:col-span-5 reveal">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-[1px] bg-[#c4a47c]"></div>
                        <p class="text-spacing-sm text-gray-400 font-bold">Layanan Pelanggan</p>
                    </div>

                    <h2 class="font-editorial text-4xl md:text-5xl text-[#22185d] leading-[1.2] mb-8">
                        Kami Siap <br> <span class="italic text-[#c4a47c]">Membantu Anda</span>
                    </h2>

                    <p class="text-gray-600 text-lg leading-loose font-light mb-10">
                        Tim kami berdedikasi untuk membantu Anda merencanakan kunjungan budaya yang tak terlupakan. Dari
                        pertanyaan tiket hingga reservasi acara khusus, kami menantikan kehadiran Anda.
                    </p>

                    <a href="https://wa.me/{{ site_setting('whatsapp_number', '6282182821200') }}" target="_blank"
                        class="inline-flex items-center gap-3 px-8 py-4 bg-[#22185d] text-white hover:bg-[#1a1445] transition-all group">
                        <span class="text-xs font-bold tracking-[0.2em] uppercase">Chat WhatsApp</span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                <div class="lg:col-span-7 reveal" style="transition-delay: 200ms;">
                    <div class="grid md:grid-cols-2 gap-x-8 gap-y-12">

                        <div class="contact-info-step">
                            <span class="text-spacing-sm text-[#c4a47c] mb-3 block font-bold">Lokasi Utama</span>
                            <p class="font-editorial text-xl text-[#22185d] mb-3">Saung Angklung Udjo</p>
                            <p class="text-gray-500 text-sm font-light leading-relaxed">
                                {!! nl2br(e(site_setting('address'))) !!}
                            </p>
                        </div>

                        <div class="contact-info-step">
                            <span class="text-spacing-sm text-[#c4a47c] mb-3 block font-bold">Komunikasi</span>
                            <a href="tel:+{{ site_setting('whatsapp_number', '6282182821200') }}"
                                class="block font-editorial text-xl text-[#22185d] mb-1 hover:text-[#c4a47c] transition-colors">{{ site_setting('contact_phone', '0821-8282-1200') }}</a>
                            @if(site_setting('contact_email'))
                            <a href="mailto:{{ site_setting('contact_email') }}"
                                class="text-gray-500 text-sm font-light hover:text-[#22185d]">{{ site_setting('contact_email') }}</a>
                            @endif
                            <p class="text-[10px] text-[#22185d] mt-4 uppercase tracking-[0.15em] font-bold opacity-60">
                                Buka: {{ site_setting('opening_hours', '08:00 - 17:00 WIB') }}
                            </p>
                        </div>

                        <div class="contact-info-step md:col-span-2">
                            <span class="text-spacing-sm text-[#c4a47c] mb-4 block font-bold">Ikuti Kami</span>
                            <div class="flex items-center gap-4 mt-2">

                                <a href="https://instagram.com/angklungudjo" target="_blank" class="social-btn"
                                    aria-label="Instagram">
                                    <svg viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                </a>
<a href="https://tiktok.com/@saungangklungudjo" target="_blank" class="social-btn"
                                    aria-label="TikTok">
    <svg viewBox="0 0 24 24" fill="none">
        <g>
            <!-- Shadow merah -->
            <path d="M9.37,23.5a7.468,7.468,0,0,1,0-14.936.537.537,0,0,1,.538.5v3.8a.542.542,0,0,1-.5.5,2.671,2.671,0,1,0,2.645,2.669.432.432,0,0,1,0-.05V1a.5.5,0,0,1,.5-.5h3.787a.5.5,0,0,1,.5.5A4.759,4.759,0,0,0,21.59,5.76a.5.5,0,0,1,.5.5L22.1,10a.533.533,0,0,1-.519.515,9.427,9.427,0,0,1-4.741-1.268v6.789A7.476,7.476,0,0,1,9.37,23.5Z" 
                  fill="#FF004F" transform="translate(-0.8, 0.8)"/>
            <!-- Shadow cyan -->
            <path d="M9.37,23.5a7.468,7.468,0,0,1,0-14.936.537.537,0,0,1,.538.5v3.8a.542.542,0,0,1-.5.5,2.671,2.671,0,1,0,2.645,2.669.432.432,0,0,1,0-.05V1a.5.5,0,0,1,.5-.5h3.787a.5.5,0,0,1,.5.5A4.759,4.759,0,0,0,21.59,5.76a.5.5,0,0,1,.5.5L22.1,10a.533.533,0,0,1-.519.515,9.427,9.427,0,0,1-4.741-1.268v6.789A7.476,7.476,0,0,1,9.37,23.5Z" 
                  fill="#00F2EA" transform="translate(0.8, -0.8)"/>
            <!-- Path utama putih -->
            <path d="M9.37,23.5a7.468,7.468,0,0,1,0-14.936.537.537,0,0,1,.538.5v3.8a.542.542,0,0,1-.5.5,2.671,2.671,0,1,0,2.645,2.669.432.432,0,0,1,0-.05V1a.5.5,0,0,1,.5-.5h3.787a.5.5,0,0,1,.5.5A4.759,4.759,0,0,0,21.59,5.76a.5.5,0,0,1,.5.5L22.1,10a.533.533,0,0,1-.519.515,9.427,9.427,0,0,1-4.741-1.268v6.789A7.476,7.476,0,0,1,9.37,23.5Z" 
                  fill="currentColor"/>
        </g>
    </svg>
</a>

                                <a href="https://youtube.com/saungangklungudjo" target="_blank" class="social-btn"
                                    aria-label="YouTube">
                                    <svg viewBox="0 0 24 24">
                                        <path
                                            d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.498-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                    </svg>
                                </a>

                            </div>
                        </div>

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
                            observer.unobserve(entry.target); // Hanya animasi sekali
                        }
                    });
                }, {
                    threshold: 0.15
                });
                document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
            });
        </script>
    @endpush

@endsection
