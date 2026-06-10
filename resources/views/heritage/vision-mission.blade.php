{{-- resources/views/corporate/vision-mission.blade.php --}}
@extends('layouts.app')

@section('title', 'Visi & Misi - Saung Angklung Udjo')

@section('content')
@section('title', __('vision.meta_title'))

    {{-- 1. STYLES: MANIFESTO STYLE --}}
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

            .font-spirax {
                font-family: 'Spirax', cursive;
            }

            .text-spacing-lg {
                text-transform: uppercase;
                letter-spacing: 0.5em;
                font-size: 0.75rem;
                font-weight: 800;
            }

            /* Hero Layout */
            .hero-vision {
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
                background: linear-gradient(to bottom, transparent 0%, var(--indigo-deep) 100%);
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

            /* Decorative line */
            .manifesto-divider {
                width: 1px;
                height: 100px;
                background: linear-gradient(to bottom, var(--gold-premium), transparent);
                margin: 0 auto;
            }

            section {
                margin: 0 !important;
            }

            /* ✅ MOBILE */
            @media (max-width: 768px) {
                .hero-vision {
                    height: 55vh;
                }

                .hero-vision h1 {
                    font-size: 3rem !important;
                }

                .vm-section {
                    padding-top: 4.5rem !important;
                    padding-bottom: 4.5rem !important;
                }

                .vm-wrap {
                    padding-left: 1.25rem !important;
                    padding-right: 1.25rem !important;
                }

                .vm-grid {
                    grid-template-columns: 1fr !important;
                    gap: 1.25rem !important;
                }

                .vm-card {
                    width: 100% !important;
                    margin: 0 auto !important;
                    padding: 2.25rem 1.5rem !important;
                    text-align: center !important;
                }

                .vm-card p {
                    font-size: 1.35rem !important;
                    line-height: 1.9 !important;
                }

                .vm-card.misi p {
                    font-size: 1.15rem !important;
                    line-height: 2.0 !important;
                }
            }
        </style>
    @endpush

    <!-- 1. CINEMATIC HERO -->
    <section class="hero-vision">
        <img src="{{ asset('img/performance.jpg') }}"
            onerror="this.src='https://images.unsplash.com/photo-1544967082-d9d25d867d66?q=80&w=2000'"
            class="hero-bg" alt="Vision Udjo">
        <div class="hero-overlay"></div>
        <div class="relative z-10 text-center text-white">
            <h1 class="reveal font-editorial text-5xl md:text-8xl leading-none italic">
                {{ __('vision.hero.title') }}
            </h1>
        </div>
    </section>

    <!-- 2. VISI & MISI (CLEAN CARDS) -->
    <section class="vm-section py-32 bg-var(--bg-premium)">
        <div class="vm-wrap max-w-[1200px] mx-auto px-10 grid md:grid-cols-2 gap-16 vm-grid">

            <!-- Vision -->
            <div class="vm-card reveal p-16 border border-gray-100 text-center hover:shadow-2xl transition-all duration-700">
                <h3 class="text-spacing-lg text-gold-premium mb-8">{{ __('vision.vision.label') }}</h3>
                <p class="font-editorial text-3xl text-indigo-950 leading-relaxed italic">
                    {{ __('vision.vision.quote') }}
                </p>
            </div>

            <!-- Mission -->
            <div class="vm-card misi reveal p-16 bg-[#1a1445] text-white text-center shadow-2xl"
                style="transition-delay: 200ms;">
                <h3 class="text-spacing-lg text-gold-premium mb-8">{{ __('vision.mission.label') }}</h3>
                <p class="font-editorial text-2xl leading-loose font-light">
                    {{ __('vision.mission.quote') }}
                </p>
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
                    threshold: 0.15
                });
                document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
            });
        </script>
    @endpush

@endsection