{{-- 
  ============================================
  FILE: resources/views/partials/analytics.blade.php
  ============================================
--}}

@php
    // Daftarkan ketiga ID kamu di sini 🚀
    $GA_ID_1 = 'G-Q9GR6FVD56'; // ID Pertama
    $GA_ID_2 = 'G-T2YEH5S9S8'; // ID Kedua
    $GA_ID_3 = 'G-JPVMLCSDNY'; // ID Ketiga (Baru)
    $isProduction = app()->environment('production');
@endphp

@if($isProduction)
{{-- ✅ STEP 1: Definisikan gtag() secara global --}}
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){ dataLayer.push(arguments); }

  // Consent default: otomatis berlaku untuk ketiga properti
  gtag('consent', 'default', {
    analytics_storage: 'denied',
    ad_storage: 'denied',
    wait_for_update: 2000
  });
  gtag('js', new Date());
</script>

{{-- ✅ STEP 2: Cukup load 1 library script utama saja --}}
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $GA_ID_1 }}"></script>

{{-- ✅ STEP 3: Config KETIGA ID agar aktif bersamaan --}}
<script>
  // Konek ke Dashboard 1
  gtag('config', '{{ $GA_ID_1 }}', {
    anonymize_ip: true,
    send_page_view: true
  });

  // Konek ke Dashboard 2
  gtag('config', '{{ $GA_ID_2 }}', {
    anonymize_ip: true,
    send_page_view: true
  });

  // Konek ke Dashboard 3
  gtag('config', '{{ $GA_ID_3 }}', {
    anonymize_ip: true,
    send_page_view: true
  });

  // Jika user sudah pernah accept cookies, aktifkan izin untuk ketiganya
  (function() {
    try {
      var choice = localStorage.getItem('sauCookieChoice');
      if (choice === 'accepted') {
        gtag('consent', 'update', { analytics_storage: 'granted' });
      }
    } catch(e) {}
  })();
</script>
@endif

{{-- ===== EVENT TRACKING DI BAWAHNYA JANGAN DIUBAH, BIARKAN SAJA ===== --}}

{{-- ===== EVENT TRACKING ===== --}}
<script>
  function sauTrack(eventName, params) {
    try {
      if (typeof gtag !== 'undefined') {
        gtag('event', eventName, params || {});
      }
    } catch(e) {}
  }

  document.addEventListener('DOMContentLoaded', function() {

    // 1. KLIK WHATSAPP FLOAT
    var waFloat = document.getElementById('wa-float');
    if (waFloat) {
      waFloat.addEventListener('click', function() {
        sauTrack('klik_whatsapp', { event_category: 'Kontak', event_label: 'WA Float Button', value: 1 });
      });
    }

    // 2. KLIK LINK WA DI POPUP
    document.querySelectorAll('a[href^="https://wa.me/"]').forEach(function(el) {
      el.addEventListener('click', function() {
        sauTrack('klik_whatsapp', { event_category: 'Kontak', event_label: el.querySelector('p')?.innerText || 'WhatsApp Link', value: 1 });
      });
    });

    // 3. KLIK CONTACT NOW
    var navCta = document.getElementById('nav-cta');
    if (navCta) {
      navCta.addEventListener('click', function() {
        sauTrack('klik_contact_now', { event_category: 'CTA', event_label: 'Navbar Contact Now', value: 1 });
      });
    }

    // 4. KLIK RESERVASI / BOOKING
    document.querySelectorAll('a[href*="reservasi"], a[href*="booking"], a[href*="kontak"]').forEach(function(el) {
      el.addEventListener('click', function() {
        sauTrack('klik_reservasi', { event_category: 'Booking', event_label: el.innerText?.trim() || 'Reservasi Button', value: 1 });
      });
    });

    // 5. SCROLL DEPTH
    var scrollMilestones = { 25: false, 50: false, 75: false, 90: false };
    window.addEventListener('scroll', function() {
      var scrollTop = window.scrollY || document.documentElement.scrollTop;
      var docHeight = document.documentElement.scrollHeight - window.innerHeight;
      var scrollPercent = Math.round((scrollTop / docHeight) * 100);
      Object.keys(scrollMilestones).forEach(function(milestone) {
        if (!scrollMilestones[milestone] && scrollPercent >= parseInt(milestone)) {
          scrollMilestones[milestone] = true;
          sauTrack('scroll_depth', { event_category: 'Engagement', event_label: milestone + '% halaman', value: parseInt(milestone) });
        }
      });
    }, { passive: true });

    // 6. TIME ON PAGE
    var startTime = Date.now();
    var timeMilestones = { 30: false, 60: false, 180: false, 300: false };
    setInterval(function() {
      var elapsed = Math.round((Date.now() - startTime) / 1000);
      Object.keys(timeMilestones).forEach(function(seconds) {
        if (!timeMilestones[seconds] && elapsed >= parseInt(seconds)) {
          timeMilestones[seconds] = true;
          sauTrack('time_on_page', { event_category: 'Engagement', event_label: seconds + ' detik di halaman', non_interaction: true, value: parseInt(seconds) });
        }
      });
    }, 5000);

    // 7. KLIK SLIDER PERTUNJUKAN
    document.querySelectorAll('.qatar-card').forEach(function(card) {
      card.addEventListener('click', function() {
        sauTrack('lihat_pertunjukan', { event_category: 'Konten', event_label: card.querySelector('h3')?.innerText || 'Pertunjukan', value: 1 });
      });
    });

    // 8. GANTI BAHASA
    document.querySelectorAll('a[href*="/language/"]').forEach(function(el) {
      el.addEventListener('click', function() {
        sauTrack('ganti_bahasa', { event_category: 'UX', event_label: el.href.includes('/en') ? 'English' : 'Bahasa Indonesia', value: 1 });
      });
    });

    // 9. KLIK ARTIKEL
    document.querySelectorAll('a[href*="/artikel/"]').forEach(function(el) {
      el.addEventListener('click', function() {
        sauTrack('baca_artikel', { event_category: 'Konten', event_label: el.querySelector('h3')?.innerText || el.innerText?.trim() || 'Artikel', value: 1 });
      });
    });

  }); // END DOMContentLoaded
</script>