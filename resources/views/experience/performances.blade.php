{{-- resources/views/experience/performances.blade.php --}}
@extends('layouts.app')

@section('title', 'Rangkaian Pertunjukan Seni - Saung Angklung Udjo')

@section('content')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Spirax&family=Libre+Baskerville:italic,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --indigo-deep: #1a1445;
            --gold-premium: #c4a47c;
            --bg-premium: #F7F7F2;
            --maroon: #7d002a;
        }

        body { 
            background-color: var(--bg-premium); 
            color: var(--indigo-deep);
            overflow-x: hidden;
        }

        .font-editorial { font-family: 'Libre Baskerville', serif; }
        .font-spirax { font-family: 'Spirax', cursive; }

        /* ── GSAP Layout ── */
        .perf-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            padding: 10vh 0;
            border-bottom: 1px solid rgba(26,20,69,0.05);
        }

        .perf-container {
            display: flex;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 5%;
            align-items: center;
            gap: 5%;
        }

        .perf-visual {
            flex: 1;
            position: relative;
            height: 80vh;
            border-radius: 30px;
            overflow: hidden;
            clip-path: inset(100% 0 0 0);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2);
        }

        .perf-info {
            flex: 0 0 45%;
            z-index: 2;
        }

        .perf-row-even .perf-container {
            flex-direction: row-reverse;
        }

       

      

        /* Swiper Fix */
        .perfSwiper { width: 100%; height: 100%; }
        .swiper-slide img { width: 100%; height: 100%; object-fit: cover; }
        .swiper-pagination-bullet-active { background: var(--gold-premium) !important; }

        /* ── Read More — smooth max-height approach ── */
        .desc-wrapper {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .perf-description {
            font-size: 1.0625rem;
            font-weight: 300;
            color: rgba(26, 20, 69, 0.6);
            line-height: 1.85;
            overflow: hidden;
            /* 5 lines clamped by default */
            max-height: calc(1.85em * 5);
            transition: max-height 0.75s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .perf-description.is-open {
            /* large enough for any content — overridden by JS with exact px */
            max-height: 2000px;
            transition: max-height 0.9s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Bottom fade-out gradient */
        .desc-fade {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 3.5rem;
            background: linear-gradient(to bottom, transparent, var(--bg-premium));
            pointer-events: none;
            transition: opacity 0.4s ease;
        }
        .desc-fade.is-hidden { opacity: 0; }

        /* Toggle button */
        .read-more-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.35em;
            text-transform: uppercase;
            color: var(--gold-premium);
            margin-bottom: 2.5rem;
            transition: opacity 0.2s;
        }
        .read-more-btn:hover { opacity: 0.6; }

        .read-more-btn .btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 17px;
            height: 17px;
            border: 1px solid currentColor;
            border-radius: 50%;
            font-size: 9px;
            transition: transform 0.45s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .read-more-btn.is-open .btn-icon {
            transform: rotate(180deg);
        }

        @media (max-width: 1024px) {
            .perf-container { flex-direction: column !important; }
            .perf-visual { width: 100%; height: 50vh; order: 1; }
            .perf-info { width: 100%; order: 2; margin-top: 3rem; text-align: center; }
            .read-more-btn { margin: 0 auto 2.5rem; }
            .perf-section { min-height: auto; padding: 5rem 0; }
            .perf-number { font-size: 30vw; opacity: 0.05; }
        }
    </style>
@endpush

{{-- 1. HERO SECTION --}}
<section class="hero-perf h-screen relative flex items-center justify-center overflow-hidden bg-black">
    <div class="video-container absolute inset-0 w-full h-full">

       <div id="heroBg" style="position:absolute;inset:0;
    background-image:url('{{ asset('img/Angklungmasal.webp') }}');
    background-size:cover;background-position:center;
    opacity:0; transition: opacity 0.5s;"></div>

<video autoplay muted loop playsinline 
       class="w-full h-full object-cover opacity-50 scale-110"
       onerror="document.getElementById('heroBg').style.opacity='0.5'">
    <source src="{{ asset('Video/HIGHLIGHT_no_cta.mp4') }}" type="video/mp4">
</video>
     </div> 
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-[var(--bg-premium)]"></div>
    
    <div class="relative z-10 text-center px-6">
       
       
    </div>
</section>
<div style="height: 60px;"></div>

{{-- 2. SINOPSIS --}}
<section class="py-40 bg-[var(--bg-premium)]">
    <div class="max-w-6xl mx-auto px-8">
        <div class="grid lg:grid-cols-2 gap-20 items-center sinopsis-trigger">
            <div class="visual-reveal rounded-[3rem] overflow-hidden aspect-[4/3] shadow-2xl">
                <img src="{{ asset('images/awal pertunjukan.jpg') }}" class="w-full h-full object-cover scale-110">
            </div>
            <div>
                <p class="text-gold-premium font-bold tracking-[0.4em] uppercase text-xs mb-6">Introduction</p>
                <h2 class="font-editorial text-4xl md:text-6xl italic mb-8 reveal-text">Sinopsis Pertunjukan</h2>
                <div class="space-y-6 text-xl font-light leading-relaxed text-indigo-950/70 reveal-text-p">
                    <p>Selamat datang di <strong>Saung Angklung Udjo</strong>, rumah seni yang mempersembahkan keharmonisan alunan musik Angklung. Didirikan tahun 1966 oleh Bapak Udjo Ngalagena dan Ibu Uum Sumiati.</p>
                    <p>Abah Udjo bercita-cita menjadikan alat musik bambu ini sebagai simbol kebanggaan budaya Indonesia dan alat menyebarkan pesan damai ke seluruh penjuru dunia.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div style="height: 60px;"></div>

{{-- 3. PERFORMANCES LOOP (9 Items) --}}
@php
    $performances = [
        [
            'title'  => 'Wayang Golek',
            'cat'    => 'Puppetry',
            'imgs'   => ['Wayanggolek.webp', 'Wayang2.webp', 'wayang3.webp'],
            'desc'   => 'Wayang Golek adalah seni pertunjukan tradisional yang memperagakan boneka kayu yang dikenal dengan sebutan "wayang". Wayang ini dibuat dengan bentuk yang menyerupai manusia dan masing-masing bonekanya memiliki karakteristik tersendiri yang mencerminkan beragam sifat manusia. Pada pementasan Wayang Golek, peran penting dipegang oleh seorang Dalang yang memandu cerita dan menggerakkan boneka dengan keterampilan yang tinggi. Setiap adegan yang ditampilkan dalam pertunjukan ini bukan sekedar hiburan, melainkan juga berisi pesan moral yang mendalam. Pertunjukan Wayang Golek biasanya berlangsung sangat lama, yakni lebih dari tujuh jam, namun di Saung Angklung Udjo, penonton akan mendapatkan pengalaman istimewa melalui demonstrasi singkat. Demonstrasi ini menampilkan kisah cinta epik Ramayana: Rama dan Dewi Shinta yang ditemani Laksmana sedang berburu rusa di hutan, lalu Shinta dilirik oleh Prabu Rahwana yang tergila-gila padanya. Rahwana pun menyamar menjadi kakek renta untuk merebut Shinta dari Rama. Terjadilah peperangan dahsyat di Tegal Maliawan—Rama dibantu pasukan monyet pimpinan Hanoman sang monyet putih—melawan Rahwana dan pasukan Alengka. Di akhir peperangan, Rama meraih kemenangan dan Shinta kembali kepadanya.',
        ],
        [
            'title'  => 'Helaran',
            'cat'    => 'Parade',
            'imgs'   => ['Helaran.webp', 'Helaran2.webp'],
            'desc'   => 'Helaran adalah tradisi arak-arakan penuh makna yang kerap mengiringi berbagai upacara adat, seperti khitanan dan upacara panen padi. Helaran dipentaskan dengan nada salendro atau pentatonis dan melodi yang riang dan gembira. Ini sejalan dengan tujuan utama Helaran, yaitu sebagai bentuk hiburan dan ungkapan rasa syukur kepada Tuhan Yang Maha Esa atas segala limpahan berkat-Nya. Dalam pertunjukan ini, Helaran didemonstrasikan oleh anak-anak yang dengan lincah menari dan memainkan angklung, menggambarkan keceriaan dan rasa syukur yang tulus, sekaligus mempersembahkan warna khas budaya Sunda.',
        ],
        [
            'title'  => 'Tari Tradisional',
            'cat'    => 'Dance',
            'imgs'   => ['TariTopeng1.webp', 'TariTopeng2.webp', 'taritopeng3.webp'],
            'desc'   => 'Tari Topeng yang dikreasikan oleh Saung Angklung Udjo merupakan persembahan tari tradisional dengan latar belakang cerita sebuah kisah klasik tentang Ratu Kencana Wungu. Ratu yang memiliki keanggunan ini dikejar-kejar oleh Prabu Menakjingga yang sangat terpesona oleh kecantikannya. Tidak hanya menjadi saksi kisah romantis, penonton juga akan diajak merasakan transisi karakter melalui tarian. Para penari yang berperan sebagai Layang Kumintir memperagakan perubahan karakter yang dramatis. Sebelum memakai topeng, mereka menampilkan sosok wanita yang penuh dengan keanggunan. Namun, saat topeng dikenakan, karakter mereka berubah menjadi sosok pria yang penuh dengan kegagahan dan ketegasan. Melalui pertunjukan ini, Saung Angklung Udjo ingin menyampaikan bahwa seni tari tidak hanya sekedar gerakan, namun juga penuh dengan pesan dan cerita.',
        ],
        [
            'title'  => 'Angklung Mini',
            'cat'    => 'Modern Performance',
            'imgs'   => ['Angklungmini1.webp', 'Angklungmini2.webp'],
            'desc'   => 'Beralih ke tangga nada diatonis/modern, di sesi Angklung Mini, murid-murid junior dari Saung Angklung Udjo menyuguhkan pertunjukan yang mengesankan dengan memainkan lagu anak-anak "Boneka Abdi"—dari versi bahasa Sunda—dan terdapat pula beragam versi dari berbagai negara. Alunan melodinya dipersembahkan dengan menggunakan Angklung berukuran mini yang hanya memiliki satu tangga nada diatonis. Set Angklung ini lebih sederhana, namun tetap menyajikan harmoni dan melodi yang menarik dan indah.',
        ],
        [
            'title'  => 'Arumba',
            'cat'    => 'Bamboo Ensemble',
            'imgs'   => ['Arumbaa.webp', 'Arumba.webp', 'Arumba2.webp'],
            'desc'   => 'ARUMBA adalah singkatan dari "Alunan Rumpun Bambu" yang merupakan satu set alat musik (band) tradisional yang terbuat dari bambu. ARUMBA memiliki tangga nada diatonis yang dapat memainkan berbagai genre musik, termasuk Dangdut, genre musik yang sangat populer di Indonesia. Dalam sesi ini, pemain ARUMBA akan mempersembahkan sebuah lagu Dangdut untuk memeriahkan suasana. Penonton diajak untuk tidak hanya menikmati, namun juga bernyanyi bersama, menciptakan momen interaktif yang mengesankan.',
        ],
        [
            'title'  => 'Angklung Masal Nusantara',
            'cat'    => 'Heritage Experience',
            'imgs'   => ['Angklungmasal.webp', 'ANGKLUNGMASSAL.webp'],
            'desc'   => 'Angklung Massal Nusantara adalah representasi kecil dari keanekaragaman kebudayaan yang dimiliki Indonesia. Dalam sesi ini, Saung Angklung Udjo menghadirkan beragam tarian yang mencerminkan tradisi masing-masing daerah, dilengkapi dengan pakaian adat yang otentik, dan dipersembahkan dengan iringan alunan melodis dari angklung. Bagi penonton, ini akan menjadi pengalaman yang tak terlupakan, seakan-akan sedang berkeliling Nusantara dan merasakan keharmonisan budaya Indonesia melalui musik dan tarian.',
        ],
        [
            'title'  => 'Angklung Interaktif',
            'cat'    => 'Interactive',
            'imgs'   => ['Interaktif_Angklung.webp', 'Interaktifangklung2.jpg', 'Interaktifangklung3.jpg'],
            'desc'   => 'Bermain Angklung Bersama adalah sesi yang akan mengajak penonton untuk menyelami keajaiban dari memainkan angklung. Instruktur Angklung yang berpengalaman akan mengajarkan dasar-dasar cara bermain angklung, mulai dari mengenali nada-nada yang ada, cara menggoyangkan angklung untuk menghasilkan suara, hingga memainkan beberapa lagu menggunakan angklung, sehingga penonton dapat merasakan langsung keunikan dari alat musik tradisional ini. Diharapkan, melalui sesi Bermain Angklung Bersama ini, setiap orang yang hadir dapat merasakan keharmonisan yang tercipta dan mempersatukan segala perbedaan budaya dan perbedaan negara yang ada.',
        ],
        [
            'title'  => 'Trio Angklung',
            'cat'    => 'Modern Innovation',
            'imgs'   => ['Trioangklung.webp', 'trioangklung2.webp', 'trioangklung3.webp'],
            'desc'   => 'Trio Angklung merupakan penampilan khusus yang dipersembahkan oleh murid-murid senior Saung Angklung Udjo. Trio Angklung menggabungkan Arumba dan inovasi instrumen "Angklung Toel" yakni set Angklung tepuk/pukul. Kolaborasi ini menciptakan aransemen musik yang indah, menonjolkan keunikan bunyi Angklung yang resonan dan harmonis. Penampilan ini mencerminkan bagaimana tradisi dapat disatukan dengan modernitas, menghasilkan kreasi musik yang segar dan menarik.',
        ],
        [
            'title'  => 'Menari Bersama',
            'cat'    => 'Finale',
            'imgs'   => ['MenariBersama.webp'],
            'desc'   => 'Di akhir pertunjukan, murid-murid Saung Angklung Udjo tidak sekadar menampilkan kepiawaian mereka bermain angklung. Mereka juga akan membagi kebahagiaan dengan mengajak para penonton untuk berdiri dan menari bersama. Kehangatan dan keakraban dalam sesi ini menjadi penutup yang sempurna untuk petualangan budaya di Saung Angklung Udjo.',
        ],
    ];
@endphp

@foreach ($performances as $index => $item)
@php $isLong = mb_strlen($item['desc']) > 300; @endphp
<section class="perf-section {{ ($index + 1) % 2 == 0 ? 'perf-row-even' : '' }}">
    <div class="perf-container">
        
        <div class="perf-info">
            <span class="overflow-hidden block">
                <span class="perf-eyebrow block text-gold-premium font-bold tracking-[0.4em] uppercase text-[10px] mb-4">
                    {{ $item['cat'] }}
                </span>
            </span>
            <h2 class="perf-title-text font-editorial text-5xl md:text-7xl italic mb-8 leading-tight">
                {{ $item['title'] }}
            </h2>
            <div class="w-16 h-1 bg-gold-premium mb-8 origin-left perf-line"></div>

            {{-- Description wrapper --}}
            <div class="desc-wrapper">
                <p class="perf-description {{ $isLong ? '' : 'is-open' }}">
                    {{ $item['desc'] }}
                </p>
                @if($isLong)
                    <div class="desc-fade"></div>
                @endif
            </div>

            @if($isLong)
            <button class="read-more-btn" onclick="toggleDesc(this)" aria-expanded="false">
                <span class="btn-label">Baca Selengkapnya</span>
                <span class="btn-icon">↓</span>
            </button>
            @endif
        </div>

        <div class="perf-visual">
           
            <div class="swiper perfSwiper">
                <div class="swiper-wrapper">
                    @foreach($item['imgs'] as $img)
                    <div class="swiper-slide">
                        <img src="{{ asset('img/' . $img) }}" alt="{{ $item['title'] }}">
                    </div>
                    @endforeach
                </div>
                @if(count($item['imgs']) > 1)
                    <div class="swiper-pagination"></div>
                @endif
            </div>
        </div>

    </div>
</section>
@endforeach
<div style="height: 60px;"></div>

<!-- FINAL CTA -->
<section
    style="position: relative; width: 100%; overflow: hidden; min-height: 420px; display: flex; align-items: center; justify-content: center;">
    <img src="{{ asset('img/Angklungmasal.webp') }}"
        style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: center;"
        loading="lazy" decoding="async" width="1920" height="800" alt="Pertunjukan Angklung Masal">
    <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.65);"></div>
    <div
        style="position: relative; z-index: 10; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 60px 1.5rem;">
        <h2 class="font-editorial"
            style="font-size: clamp(2.5rem, 6vw, 5rem); color: white; line-height: 1.15; margin-bottom: 2.5rem; max-width: 800px; text-shadow: 0 2px 20px rgba(0,0,0,0.4);">
            Jadilah saksi <br>
            <em>harmoni berikutnya.</em>
        </h2>
        <a href="https://angklung-udjo.co.id/tickets/buy" target="_blank" rel="noopener noreferrer"
            style="display: inline-block; padding: 1rem 3rem; background: transparent; color: white;
                  border: 1px solid white; font-size: 11px; font-weight: 700;
                  text-transform: uppercase; letter-spacing: 0.3em; text-decoration: none;
                  transition: all 0.3s ease;"
            onmouseover="this.style.background='white'; this.style.color='#1a1445';"
            onmouseout="this.style.background='transparent'; this.style.color='white';">
            Booking Sekarang Juga
        </a>
    </div>
</section>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    /* ── Smooth Read More ── */
    function toggleDesc(btn) {
        const wrapper = btn.previousElementSibling;       // .desc-wrapper
        const p       = wrapper.querySelector('.perf-description');
        const fade    = wrapper.querySelector('.desc-fade');
        const label   = btn.querySelector('.btn-label');
        const isOpen  = p.classList.contains('is-open');

        if (isOpen) {
            // ── Collapse ──
            // Lock to current scrollHeight first so transition has a start point
            p.style.maxHeight = p.scrollHeight + 'px';
            // Force reflow so browser registers the value
            p.getBoundingClientRect();

            p.style.transition = 'max-height 0.65s cubic-bezier(0.4, 0, 0.2, 1)';
            p.style.maxHeight  = 'calc(1.85em * 5)';
            p.classList.remove('is-open');

            if (fade) {
                fade.style.transition = 'opacity 0.3s ease 0.3s';
                fade.classList.remove('is-hidden');
            }
            label.textContent = 'Baca Selengkapnya';
            btn.classList.remove('is-open');
            btn.setAttribute('aria-expanded', 'false');

        } else {
            // ── Expand ──
            const fullH = p.scrollHeight;
            p.style.transition = 'max-height 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
            p.style.maxHeight  = fullH + 'px';
            p.classList.add('is-open');

            if (fade) {
                fade.style.transition = 'opacity 0.3s ease';
                fade.classList.add('is-hidden');
            }
            label.textContent = 'Tutup';
            btn.classList.add('is-open');
            btn.setAttribute('aria-expanded', 'true');

            // Once expanded, remove inline maxHeight so text reflows freely
            p.addEventListener('transitionend', () => {
                if (p.classList.contains('is-open')) p.style.maxHeight = 'none';
            }, { once: true });
        }
    }

    gsap.registerPlugin(ScrollTrigger);

    document.addEventListener('DOMContentLoaded', () => {
        
        // --- 1. Hero Animation ---
        const heroTl = gsap.timeline();
        heroTl.to('.hero-eyebrow', { opacity: 1, y: 0, duration: 1, delay: 0.5 })
              .from('.hero-title span span', { y: "100%", duration: 1, stagger: 0.2, ease: "power4.out" }, "-=0.5")
              .to('.video-container video', { scale: 1, duration: 2.5, ease: "power2.out" }, 0);

        // --- 2. Sinopsis Reveal ---
        gsap.timeline({
            scrollTrigger: {
                trigger: '.sinopsis-trigger',
                start: "top 70%",
            }
        })
        .from('.visual-reveal img', { scale: 1.4, duration: 2, ease: "power2.out" })
        .from('.reveal-text', { y: 50, opacity: 0, duration: 1 }, 0.5)
        .from('.reveal-text-p p', { y: 30, opacity: 0, duration: 1, stagger: 0.3 }, "-=0.5");

        // --- 3. Performances Section Animations ---
        const sections = gsap.utils.toArray('.perf-section');
        sections.forEach((section) => {
            const visual = section.querySelector('.perf-visual');
            const info = section.querySelector('.perf-info');
            const line = section.querySelector('.perf-line');
          
            gsap.to(visual, {
                clipPath: 'inset(0% 0 0 0)',
                duration: 1.8,
                ease: "expo.out",
                scrollTrigger: { trigger: section, start: "top 65%" }
            });

            gsap.from(info, {
                y: 60, opacity: 0, duration: 1.2,
                scrollTrigger: { trigger: section, start: "top 70%" }
            });

            gsap.from(line, {
                scaleX: 0, duration: 1.5, ease: "power3.inOut",
                scrollTrigger: { trigger: section, start: "top 70%" }
            });

           
        });

        // --- 4. Initialize Swipers ---
        new Swiper('.perfSwiper', {
            effect: 'fade',
            fadeEffect: { crossFade: true },
            autoplay: { delay: 4000, disableOnInteraction: false },
            loop: true,
            speed: 1200,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    });
</script>
@endpush

@endsection