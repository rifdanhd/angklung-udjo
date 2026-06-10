{{-- resources/views/heritage/jenis-angklung.blade.php --}}
@extends('layouts.app')

@section('title', 'Ragam Jenis Angklung - Saung Angklung Udjo')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap');

    :root {
        --navy: #1a1a2e;
        --gold: #c5a059;
        --cream: #f8f5f0;
        --text-muted: #555;
    }

    body {
        background-color: var(--cream);
        font-family: 'Inter', sans-serif;
        color: var(--navy);
        overflow-x: hidden;
    }

    /* ── TEXTURE OVERLAY ── */
    /* FIX: z-index dinaikkan ke -1 agar tidak menimpa konten apapun */
    .bg-texture {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background-image: url('https://www.transparenttextures.com/patterns/paper-fibers.png');
        opacity: 0.4;
        pointer-events: none;
        z-index: -1;
    }

    /* ── HERO ── */
    .hero {
        height: 70vh;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
        padding: 0 20px;
        background: url('/img/Angklungmasal.webp') no-repeat center center;
        background-size: cover;
        overflow: hidden;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(26,26,46,0.7), rgba(26,26,46,0.4));
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-label {
        font-size: 0.75rem;
        letter-spacing: 0.5em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 20px;
        display: block;
    }

    .hero-title {
        font-family: 'Libre Baskerville', serif;
        font-size: clamp(2.5rem, 8vw, 5rem);
        line-height: 1.1;
    }

    .hero-title em {
        font-style: italic;
        font-weight: 400;
        color: var(--gold);
    }

    /* ── LIST SECTION ── */
    /* FIX: z-index: 1 cukup, tidak perlu besar */
    .angklung-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 100px 20px;
        position: relative;
        z-index: 1;
    }

    .angklung-row {
        display: flex;
        align-items: center;
        margin-bottom: 180px;
        position: relative;
        gap: 50px;
    }

    .angklung-row:nth-child(even) { flex-direction: row-reverse; }

    .item-image-container {
        flex: 1;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .item-image-container img {
        width: 100%;
        max-width: 480px;
        height: auto;
        filter: drop-shadow(15px 25px 45px rgba(0,0,0,0.12));
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .angklung-row:hover .item-image-container img {
        transform: scale(1.04) translateY(-10px);
    }

    .image-blob {
        position: absolute;
        width: 80%;
        height: 80%;
        background: radial-gradient(circle, rgba(197, 160, 89, 0.1) 0%, rgba(248, 245, 240, 0) 70%);
        border-radius: 50%;
        z-index: -1;
    }

    .item-text {
        flex: 1;
        padding: 0;
    }

    .item-num {
        font-family: 'Libre Baskerville', serif;
        font-size: 0.9rem;
        color: var(--gold);
        display: block;
        margin-bottom: 15px;
    }

    .item-title {
        font-family: 'Libre Baskerville', serif;
        font-size: clamp(2rem, 4vw, 3.2rem);
        margin-bottom: 15px;
        color: var(--navy);
        line-height: 1.2;
    }

    .item-meta {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 20px;
        display: block;
    }

    .item-description {
        font-size: 1.05rem;
        line-height: 1.8;
        color: var(--text-muted);
        max-width: 500px;
    }

    /* ── REVEAL ANIMATION ── */
    .reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: all 1s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }

    /* ── CTA FOOTER ── */
    /* FIX: tambah position: relative + z-index: 1 agar tidak tertimpa .bg-texture */
    .cta-footer {
        padding: 120px 20px;
        text-align: center;
        background-color: var(--navy);
        color: white;
        position: relative;
        z-index: 1;
    }

    .cta-footer h2 {
        font-family: 'Libre Baskerville', serif;
        font-size: clamp(2rem, 5vw, 3rem);
        margin-bottom: 40px;
    }

    /* FIX: tambah display: inline-block agar padding vertikal bekerja */
    .btn-visit {
        display: inline-block;
        padding: 18px 45px;
        border: 1px solid var(--gold);
        color: var(--gold);
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.3em;
        font-size: 0.75rem;
        transition: background 0.4s, color 0.4s;
    }
    .btn-visit:hover {
        background: var(--gold);
        color: var(--navy);
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 991px) {
        .hero { height: 60vh; }
        .angklung-row,
        .angklung-row:nth-child(even) {
            flex-direction: column;
            text-align: center;
            margin-bottom: 100px;
        }
        .item-description { margin: 0 auto; }
        .item-image-container img { max-width: 300px; }
    }
</style>
@endpush

@section('content')

<div class="bg-texture"></div>

{{-- HERO --}}
<section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <span class="hero-label reveal">Eksplorasi Budaya Sunda</span>
        <h1 class="hero-title reveal" style="transition-delay: 200ms;">
            Ragam Suara <em>Bambu</em>
        </h1>
    </div>
</section>

{{-- LIST --}}
<div class="angklung-section">
    @php
    $list = [
        [
            'num' => '01',
            'name' => 'Angklung Gubrag',
            'loc' => 'Jasinga, Bogor',
            'desc' => 'Angklung Gubrag merupakan instrumen angklung yang dipergunakan oleh masyarakat Sunda di wilayah Bogor dalam prosesi persembahan bagi dewi padi, atau Dewi Sri. Berbeda dengan angklung buhun, angklung gubrag terbuat dari bambu hitam dengan ukuran yang cenderung lebih besar. Diberikan hiasan daun aren muda yang memiliki nilai filosofis dan spiritual bagi masyarakat sunda jaman dahulu.',
            'img' => asset('img/Angklung-Gubrag.webp'),
        ],
        [
            'num' => '02',
            'name' => 'Angklung Badeng',
            'loc' => 'Baduy, Banten',
            'desc' => 'Angklung Badeng merupakan instrumen angklung yang dipergunakan oleh masyarakat Sanding-Malangbong Garut dalam kesenian Badeng, sebuah seni pertunjukan yang memiliki fungsi "syiar" agama Islam. Angklung badeng tempo dulu berlaraskan pentatonik dan berfungsi sebangai rhytm dalam mengiringi syair-syair yang bernafaskan islam. Secara bentuk, Angklung badeng selalu memiliki palang penutup dibagian atas dan dihiasi kain satin berbeda warna ataupun bulu dari ayam hutan.',
            'img' => asset('img/Angklung-badeng.webp'),
        ],
        [
            'num' => '03',
            'name' => 'Angklung Bungko',
            'loc' => 'Cirebon, Jawa Barat',
            'desc' => 'Angklung Bungko merupakan insrument untuk mengiringi tarian perang diwilayah kekeratonan Cirebonan. Angklung Bungko pertama diciptakan oleh Ki Buyut Bungko setelah memenangkan peperangan disekitar abad ke 14. Secara fisik angklung Bungko terbuat dari bambu wulung dan dihiasi rajutan kain serta bunga melati yang dipercaya dapat bersemayang kekuatan-kekuatan mistis yang akan menyertai dimedan laga.',
            'img' => asset('img/Angklung-Bungko.webp'),
        ],
        [
            'num' => '04',
            'name' => 'Angklung Buncis',
            'loc' => 'Bandung, Jawa Barat',
            'desc' => 'Angklung Buncis adalah jenis seni pertunjukan musik angklung tradisional yang memiliki banyak varian. Dikatakan bahwa, menurut sejarah yang diturunkan dari generasi ke generasi, nama dari seni buncis dikaitkan dengan salah satu lirik lagu yang terkenal di kalangan masyarakat, yaitu "cis bean bean nyengcle..." Berdasarkan hal ini, masyarakat menyebut seni ini bean bean. Seni ini merupakan ciri khas Jawa Barat, terutama daerah-daerah yang memiliki gaya hidup agraris (seperti Baduy, Cigugur Kuningan, Baros Arjasari). Beberapa angklung buncis terdiri dari tiga tabung (nada), yang lainnya terdiri dari empat tabung. Sebuah angklung yang terdiri dari tiga tabung dapat menghasilkan satu nada dengan dua oktaf.',
            'img' => asset('img/Angklung--Buncis.webp'),
        ],
        [
            'num' => '05',
            'name' => 'Angklung Gandalia',
            'loc' => 'Kabupaten Banyumas, Jawa Tengah',
            'desc' => 'Angklung Gandalia merupakan angklung yang dipergunakan dalam kesenian Gandalia dari di agraris Tambaknegara, Kecamatan Rawalo, Banyumas, Jawa Tengah. Angklung Gandalia berukuran besar dan umumnya memiliki 4 tabung suara untuk memainkan nada rendah yang bernadakan pentatonik salendro.',
            'img' => asset('img/Angklung-Gandalia.webp'),
        ],
        [
          'num' => '06',
            'name' => 'Bilah Angklung Toel',
            'loc' => 'Bandung, Jawa Barat',
            'desc' => 'Angklung Toel merupakan instrument yang diciptakan oleh Yayan Mulayana Udjo pada tahun 2008. Angklung toel dimainkan secara terbalik, dibunyikan secara menyentuh dan menghasilkan suara harmoni. Angklung toel didesaign jadi satu set perangkat yang memungkinkan pemain memainkan instrument angklung dalam rangkaian nada.',
            'img' => asset('img/Baby Grand Angklung Atas.webp'),
        ],
        
         [
          'num' => '07',
            'name' => 'Bilah Angklung Grand',
            'loc' => 'Bandung, Jawa Barat',
            'desc' => 'Angklung Grand merupakan instrument yang diciptakan oleh Taufik Hidayat Udjo. Angklung Grand dimainkan secara terbalik sama seperti Angklung Toel namun berbeda, karena biasanya tabung angklung berurutan dari yang terkecil sampai terbesar tapi kalau  Angklung Grand posisi tabungnya dibuat secara acak, dan dimainkan sama seperti Angklung Toel',
            'img' => asset('img/grndddd.webp'),
        ],
        
     
           
    ];
    @endphp

    @foreach($list as $i => $item)
    <div class="angklung-row">
        <div class="item-image-container reveal">
            <div class="image-blob"></div>
            <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}" onerror="this.style.opacity='0.3'">
        </div>

        <div class="item-text reveal" style="transition-delay: 200ms;">
            <span class="item-num">{{ $item['num'] }}</span>
            <span class="item-meta">{{ $item['loc'] }}</span>
            <h2 class="item-title">{{ $item['name'] }}</h2>
            <p class="item-description">{{ $item['desc'] }}</p>
        </div>
    </div>
    @endforeach

</div>

{{-- CTA FOOTER --}}
    <!-- 4. FINAL CALL TO ACTION -->
  <section class="py-32 bg-indigo-950 text-center text-white relative overflow-hidden">
  <!-- Background Image -->
  <div class="absolute inset-0">
    <img 
      src="{{ asset('img/performance.jpg') }}" 
      alt="Bamboo background" 
      class="w-full h-full object-cover opacity-100"
    />
    <!-- Overlay gradient untuk readability -->
    <div class="absolute inset-0 bg-gradient-to-b from-indigo-950/80 via-indigo-950/60 to-indigo-950/80"></div>
  </div>
  
  <div class="reveal px-6 relative z-10">
    <h2 class="font-editorial text-4xl md:text-6xl lg:text-7xl italic mb-12 leading-tight drop-shadow-2xl">
      Siap untuk merasakan <br>keharmonisan bambu?
    </h2>
    <button class="bg-white text-indigo-950 px-10 py-4 rounded-full font-semibold text-lg hover:bg-amber-300 hover:scale-105 transition-all shadow-2xl">
      Hubungi Kami Sekarang
    </button>
  </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    });
</script>
@endpush