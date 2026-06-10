{{-- 
  ============================================
  FILE: resources/views/partials/cookie-consent.blade.php
  
  Cara pakai: tambahkan di resources/views/layouts/app.blade.php
  tepat sebelum tag </body>:

  @include('partials.cookie-consent')
  ============================================
--}}

@php
    $cookieChoice = request()->cookie('cookie_choice');
@endphp

@if(!$cookieChoice)
<style>
  #sau-cookie-banner {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #22185d;
    border-top: 1px solid rgba(196, 164, 124, 0.25);
    padding: 22px 48px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 32px;
    z-index: 99998;
    transform: translateY(100%);
    animation: cookieSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) 2.5s forwards;
    flex-wrap: wrap;
    font-family: 'Inter', sans-serif;
    box-shadow: 0 -10px 50px rgba(34, 24, 93, 0.35);
  }

  #sau-cookie-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 48px;
    right: 48px;
    height: 1px;
    background: linear-gradient(to right, transparent, rgba(196, 164, 124, 0.6), transparent);
    pointer-events: none;
  }

  @keyframes cookieSlideUp {
    to { transform: translateY(0); }
  }

  .sau-cookie-left {
    display: flex;
    align-items: flex-start;
    gap: 18px;
    flex: 1;
    min-width: 260px;
  }

  .sau-cookie-badge {
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    padding-top: 2px;
  }

  .sau-cookie-badge-icon { font-size: 1.35rem; line-height: 1; }

  .sau-cookie-badge-label {
    font-size: 7px;
    font-weight: 800;
    letter-spacing: 0.3em;
    text-transform: uppercase;
    color: rgba(196, 164, 124, 0.55);
    white-space: nowrap;
    font-family: 'Inter', sans-serif;
  }

  .sau-cookie-text h3 {
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.4em;
    text-transform: uppercase;
    color: #c4a47c;
    margin: 0 0 7px 0;
    font-family: 'Inter', sans-serif;
  }

  .sau-cookie-text p {
    font-size: 0.78rem;
    color: rgba(255, 255, 255, 0.5);
    line-height: 1.75;
    margin: 0;
    max-width: 480px;
    font-weight: 300;
  }

  .sau-cookie-text p a {
    color: rgba(196, 164, 124, 0.85);
    text-decoration: underline;
    text-underline-offset: 3px;
    transition: color 0.2s;
    font-weight: 400;
  }

  .sau-cookie-text p a:hover { color: #c4a47c; }

  .sau-cookie-divider {
    width: 1px;
    height: 48px;
    background: rgba(196, 164, 124, 0.18);
    flex-shrink: 0;
  }

  .sau-cookie-actions {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-shrink: 0;
    flex-wrap: wrap;
  }

  .sau-btn-reject {
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.12);
    color: rgba(255, 255, 255, 0.3);
    padding: 11px 20px;
    font-family: 'Inter', sans-serif;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 0.3em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.3s ease;
    border-radius: 0;
  }

  .sau-btn-reject:hover {
    border-color: rgba(255, 255, 255, 0.25);
    color: rgba(255, 255, 255, 0.55);
  }

  .sau-btn-settings {
    background: transparent;
    border: 1px solid rgba(196, 164, 124, 0.3);
    color: rgba(196, 164, 124, 0.65);
    padding: 11px 20px;
    font-family: 'Inter', sans-serif;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 0.3em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.3s ease;
    border-radius: 0;
  }

  .sau-btn-settings:hover {
    border-color: #c4a47c;
    color: #c4a47c;
  }

  .sau-btn-accept {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 11px 28px;
    background: #F7F7F2;
    color: #22185d;
    border: 1px solid rgba(247, 247, 242, 0.3);
    font-family: 'Inter', sans-serif;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 0.3em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    border-radius: 0;
    overflow: hidden;
  }

  .sau-btn-accept::after {
    content: '';
    position: absolute;
    inset: 3px;
    border: 1px solid rgba(34, 24, 93, 0.15);
    pointer-events: none;
    transition: all 0.4s ease;
  }

  .sau-btn-accept:hover {
    background: #c4a47c;
    color: #22185d;
    border-color: #c4a47c;
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(196, 164, 124, 0.25);
  }

  .sau-btn-accept:hover::after {
    inset: 0;
    border-color: rgba(34, 24, 93, 0.12);
  }

  @media (max-width: 768px) {
    #sau-cookie-banner {
      padding: 20px;
      flex-direction: column;
      align-items: flex-start;
      gap: 18px;
    }
    #sau-cookie-banner::before { left: 20px; right: 20px; }
    .sau-cookie-divider { display: none; }
    .sau-cookie-actions { width: 100%; justify-content: flex-end; }
    .sau-btn-reject, .sau-btn-settings, .sau-btn-accept {
      padding: 10px 14px;
      font-size: 8px;
    }
  }
</style>

<div id="sau-cookie-banner" role="dialog" aria-label="Cookie Consent">
  <div class="sau-cookie-left">
    <div class="sau-cookie-badge">
      <span class="sau-cookie-badge-icon">🍪</span>
      <span class="sau-cookie-badge-label">Cookies</span>
    </div>
    <div class="sau-cookie-text">
      <h3>Penggunaan Cookies</h3>
      <p>
        Kami menggunakan cookies untuk meningkatkan pengalaman Anda menjelajahi warisan budaya Saung Angklung Udjo.
        Dengan melanjutkan, Anda menyetujui
        <a href="/kebijakan-privasi">Kebijakan Privasi</a> kami.
      </p>
    </div>
  </div>

  <div class="sau-cookie-divider"></div>

  <div class="sau-cookie-actions">
    <button class="sau-btn-reject" onclick="sauRejectCookies()">Tolak</button>
    <button class="sau-btn-settings" onclick="window.location.href='/kebijakan-privasi'">Pengaturan</button>
    <button class="sau-btn-accept" onclick="sauAcceptCookies()">Terima Semua</button>
  </div>
</div>

<script>
  // Sembunyikan jika user sudah pernah memilih
  (function() {
    try {
      if (localStorage.getItem('sauCookieChoice')) {
        var b = document.getElementById('sau-cookie-banner');
        if (b) b.style.display = 'none';
      }
    } catch(e) {}
  })();

  function sauAcceptCookies() {
    localStorage.setItem('sauCookieChoice', 'accepted');
    sauHideBanner();
    // Aktifkan Google Analytics setelah user setuju
    if (typeof gtag !== 'undefined') {
      gtag('consent', 'update', { analytics_storage: 'granted' });
    }
  } // ✅ tutup sauAcceptCookies

  function sauRejectCookies() {
    localStorage.setItem('sauCookieChoice', 'rejected');
    sauHideBanner();
  } // ✅ tutup sauRejectCookies

  function sauHideBanner() {
    var banner = document.getElementById('sau-cookie-banner');
    if (!banner) return;
    banner.style.transition = 'transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.4s ease';
    banner.style.transform = 'translateY(100%)';
    banner.style.opacity = '0';
    setTimeout(function() { banner.style.display = 'none'; }, 500);
  } // ✅ tutup sauHideBanner
</script>
@endif