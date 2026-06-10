{{--
    ╔══════════════════════════════════════════════════════════════╗
    ║   SAUNG ANGKLUNG UDJO — HOMEPAGE ENHANCEMENT BUNDLE         ║
    ║   Paste @push('styles') ke bawah @push('styles') existing   ║
    ║   Paste @push('scripts') ke bawah @push('scripts') existing ║
    ╚══════════════════════════════════════════════════════════════╝
--}}

{{-- ═══════════════════ STYLES ═══════════════════ --}}
@push('styles')
<style>

/* ──────────────────────────────────────────
   REVEAL SYSTEM — OVERRIDE & ENHANCED
────────────────────────────────────────── */
.reveal {
    opacity: 0;
    transform: translateY(48px);
    transition: opacity 1s cubic-bezier(0.16,1,0.3,1),
                transform 1s cubic-bezier(0.16,1,0.3,1);
    visibility: hidden;
}

.reveal.active {
    opacity: 1 !important;
    transform: translateY(0) !important;
    visibility: visible !important;
}

.reveal-left  { transform: translateX(-60px) !important; }
.reveal-right { transform: translateX(60px) !important; }
.reveal-scale { transform: scale(.88) !important; opacity: 0 !important; }

.reveal-left.active,
.reveal-right.active,
.reveal-scale.active {
    transform: translateX(0) scale(1) !important;
    opacity: 1 !important;
}

/* ──────────────────────────────────────────
   STAGGER GROUP — anak-anak muncul berurutan
────────────────────────────────────────── */
.stagger-group > * {
    opacity: 0;
    transform: translateY(32px);
    transition: opacity .7s ease, transform .7s ease;
    visibility: hidden;
}
.stagger-group.active > *:nth-child(1) { transition-delay: 0ms; }
.stagger-group.active > *:nth-child(2) { transition-delay: 120ms; }
.stagger-group.active > *:nth-child(3) { transition-delay: 240ms; }
.stagger-group.active > *:nth-child(4) { transition-delay: 360ms; }
.stagger-group.active > *:nth-child(5) { transition-delay: 480ms; }
.stagger-group.active > * {
    opacity: 1;
    transform: translateY(0);
    visibility: visible;
}

/* ──────────────────────────────────────────
   MAGNETIC BUTTON
────────────────────────────────────────── */
.magnetic {
    position: relative;
    display: inline-block;
    transition: transform .4s cubic-bezier(0.16,1,0.3,1);
}

/* ──────────────────────────────────────────
   CARD TILT 3D
────────────────────────────────────────── */
.card-tilt {
    transform-style: preserve-3d;
    transition: transform .1s ease, box-shadow .3s ease;
    will-change: transform;
}

.card-tilt:hover {
    box-shadow: 0 30px 60px rgba(26,20,69,.15);
}

/* ──────────────────────────────────────────
   SPLIT TEXT — Char-by-char reveal
────────────────────────────────────────── */
.split-text .char {
    display: inline-block;
    opacity: 0;
    transform: translateY(110%) rotate(6deg);
    transition: opacity .5s ease, transform .5s ease;
}

.split-text.active .char {
    opacity: 1;
    transform: translateY(0) rotate(0deg);
}

/* ──────────────────────────────────────────
   NUMBER COUNTER
────────────────────────────────────────── */
.count-up {
    transition: all .3s ease;
}

/* ──────────────────────────────────────────
   PARALLAX SECTION
────────────────────────────────────────── */
.parallax-bg {
    will-change: transform;
}

/* ──────────────────────────────────────────
   HOVER LINE WIPE — untuk nav link sub
────────────────────────────────────────── */
.line-wipe {
    position: relative;
    overflow: hidden;
}
.line-wipe::after {
    content: '';
    position: absolute;
    bottom: 0; left: -100%;
    width: 100%; height: 1px;
    background: var(--v-gold);
    transition: left .4s cubic-bezier(0.16,1,0.3,1);
}
.line-wipe:hover::after { left: 0; }

/* ──────────────────────────────────────────
   SECTION LABEL MARQUEE (top of section)
────────────────────────────────────────── */
.marquee-wrap {
    overflow: hidden;
    white-space: nowrap;
}
.marquee-track {
    display: inline-flex;
    animation: marquee 18s linear infinite;
}
.marquee-track span {
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .5em;
    text-transform: uppercase;
    color: rgba(26,20,69,.07);
    padding-right: 4rem;
}

@keyframes marquee {
    from { transform: translateX(0); }
    to   { transform: translateX(-50%); }
}

/* ──────────────────────────────────────────
   EVENT / PERF CARD — shimmer on hover
────────────────────────────────────────── */
.qatar-card::before,
.ev-arch-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,.15) 0%, transparent 60%);
    opacity: 0;
    z-index: 3;
    transition: opacity .5s ease;
    pointer-events: none;
}
.group:hover .qatar-card::before,
.group:hover .ev-arch-card::before { opacity: 1; }

/* ──────────────────────────────────────────
   SCROLL SNAP SLIDER — drag cursor
────────────────────────────────────────── */
.snap-slider {
    cursor: grab;
}
.snap-slider:active {
    cursor: grabbing;
}

/* ──────────────────────────────────────────
   SECTION ENTER DIVIDER
────────────────────────────────────────── */
.section-ornament {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 3rem;
}
.section-ornament::before,
.section-ornament::after {
    content: '';
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(196,164,124,.4));
}
.section-ornament::after {
    background: linear-gradient(90deg, rgba(196,164,124,.4), transparent);
}

/* ──────────────────────────────────────────
   PAGE TRANSITION OVERLAY
────────────────────────────────────────── */
#page-transition {
    position: fixed;
    inset: 0;
    background: var(--v-indigo);
    z-index: 99999;
    transform: translateY(-100%);
    pointer-events: none;
}

/* ──────────────────────────────────────────
   HERO HEADLINE — Slide up on load
────────────────────────────────────────── */
@keyframes heroSlideUp {
    from { opacity: 0; transform: translateY(40px); }
    to   { opacity: 1; transform: translateY(0); }
}

.hero-text-1 { animation: heroSlideUp 1.2s cubic-bezier(0.16,1,0.3,1) .4s both; }
.hero-text-2 { animation: heroSlideUp 1.2s cubic-bezier(0.16,1,0.3,1) .7s both; }
.hero-text-3 { animation: heroSlideUp 1.2s cubic-bezier(0.16,1,0.3,1) 1s both; }

/* ──────────────────────────────────────────
   FLOATING TICKET BADGE
────────────────────────────────────────── */
#floating-ticket {
    position: fixed;
    right: 28px;
    top: 50%;
    transform: translateY(-50%) translateX(120px);
    z-index: 90;
    transition: transform .6s cubic-bezier(0.16,1,0.3,1);
    writing-mode: vertical-lr;
}
#floating-ticket.show {
    transform: translateY(-50%) translateX(0);
}
#floating-ticket a {
    display: flex;
    align-items: center;
    gap: .6rem;
    padding: .8rem .5rem;
    background: var(--v-maroon);
    color: white;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .35em;
    text-transform: uppercase;
    text-decoration: none;
    transition: background .3s ease;
}
#floating-ticket a:hover { background: var(--v-gold); color: var(--v-indigo); }

/* ──────────────────────────────────────────
   SECTION BG ALTERNATING (subtle)
────────────────────────────────────────── */
section:nth-child(even):not(#hero):not(#maestro) {
    background-color: #F7F7F2;
}

/* ──────────────────────────────────────────
   GSAP ScrollTrigger PIN spacer fix
────────────────────────────────────────── */
.pin-spacer { pointer-events: none; }
</style>
@endpush


{{-- ═══════════════════ SCRIPTS ═══════════════════ --}}
@push('scripts')
{{-- GSAP Plugins (tambahkan jika belum ada di layout) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollToPlugin.min.js" defer></script>

<script>
/* ════════════════════════════════════════════════
   UDJO HOMEPAGE — ENHANCEMENT BUNDLE v2.0
   Semua efek interaktif & animasi premium
═════════════════════════════════════════════════ */

document.addEventListener('DOMContentLoaded', () => {

// Hover & click states
document.querySelectorAll('a, button, .nav-group, .qatar-card, .ev-arch-card, input, textarea')
    .forEach(el => {
        el.addEventListener('mouseenter', () => document.body.classList.add('cursor-hover'));
        el.addEventListener('mouseleave', () => document.body.classList.remove('cursor-hover'));
    });

document.addEventListener('mousedown', () => document.body.classList.add('cursor-click'));
document.addEventListener('mouseup',   () => document.body.classList.remove('cursor-click'));

// Hide on mobile
if ('ontouchstart' in window) {
    cursorOuter.style.display = 'none';
    cursorDot.style.display   = 'none';
    document.body.style.cursor = '';
}


/* ── 2. SCROLL PROGRESS BAR ─────────────────── */
const progressBar = document.createElement('div');
progressBar.id = 'scroll-progress';
document.body.prepend(progressBar);

window.addEventListener('scroll', () => {
    const pct = window.scrollY / (document.body.scrollHeight - window.innerHeight);
    progressBar.style.transform = `scaleX(${pct})`;
}, { passive: true });


/* ── 3. ENHANCED INTERSECTION OBSERVER ─────── */
const revealObs = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
            const el    = entry.target;
            const delay = parseFloat(el.dataset.delay || el.style.transitionDelay || 0);
            setTimeout(() => el.classList.add('active'), delay * 1000);
            revealObs.unobserve(el);
        }
    });
}, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });

document.querySelectorAll('.reveal, .stagger-group').forEach(el => revealObs.observe(el));


/* ── 4. SPLIT TEXT ANIMATION ─────────────────
   Tambah class "split-text" ke heading manapun
─────────────────────────────────────────────── */
document.querySelectorAll('.split-text').forEach(el => {
    const text = el.textContent;
    el.innerHTML = text.split('').map((ch, i) =>
        `<span class="char" style="transition-delay:${i * 30}ms">${ch === ' ' ? '&nbsp;' : ch}</span>`
    ).join('');
});


/* ── 5. NUMBER COUNTER ANIMATION ────────────── */
const counterObs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el     = entry.target;
        const target = parseInt(el.dataset.count || el.textContent.replace(/\D/g, ''), 10);
        const suffix = (el.dataset.suffix || '').trim();
        const dur    = 2000;
        const step   = 16;
        const inc    = target / (dur / step);
        let   cur    = 0;

        const t = setInterval(() => {
            cur += inc;
            if (cur >= target) { cur = target; clearInterval(t); }
            el.textContent = Math.floor(cur).toLocaleString() + suffix;
        }, step);

        counterObs.unobserve(el);
    });
}, { threshold: 0.5 });

document.querySelectorAll('.count-up').forEach(el => counterObs.observe(el));


/* ── 6. PARALLAX ON SCROLL (light, no GSAP dep)  */
const parallaxEls = document.querySelectorAll('[data-parallax]');
if (parallaxEls.length) {
    window.addEventListener('scroll', () => {
        const sy = window.scrollY;
        parallaxEls.forEach(el => {
            const speed = parseFloat(el.dataset.parallax || .3);
            const rect  = el.getBoundingClientRect();
            const rel   = sy - (sy + rect.top - window.innerHeight / 2);
            el.style.transform = `translateY(${rel * speed}px)`;
        });
    }, { passive: true });
}

// Apply parallax ke hero background
const heroSlides = document.querySelectorAll('.hero-slide.active img');
heroSlides.forEach(img => img.setAttribute('data-parallax', '0.25'));


/* ── 7. MAGNETIC BUTTON EFFECT ──────────────── */
document.querySelectorAll('#nav-cta, .btn-unesco-premium, [href*="tiket"]').forEach(btn => {
    btn.classList.add('magnetic');

    btn.addEventListener('mousemove', e => {
        const rect   = btn.getBoundingClientRect();
        const cx     = rect.left + rect.width  / 2;
        const cy     = rect.top  + rect.height / 2;
        const dx     = (e.clientX - cx) * .35;
        const dy     = (e.clientY - cy) * .35;
        btn.style.transform = `translate(${dx}px, ${dy}px)`;
    });

    btn.addEventListener('mouseleave', () => {
        btn.style.transform = 'translate(0,0)';
    });
});


/* ── 8. CARD 3D TILT ─────────────────────────── */
document.querySelectorAll('.info-card, .qatar-card').forEach(card => {
    card.classList.add('card-tilt');

    card.addEventListener('mousemove', e => {
        const rect  = card.getBoundingClientRect();
        const x     = (e.clientX - rect.left) / rect.width  - .5;
        const y     = (e.clientY - rect.top)  / rect.height - .5;
        const rotY  =  x * 10;
        const rotX  = -y * 10;
        card.style.transform = `perspective(800px) rotateX(${rotX}deg) rotateY(${rotY}deg) scale(1.02)`;
    });

    card.addEventListener('mouseleave', () => {
        card.style.transform = 'perspective(800px) rotateX(0) rotateY(0) scale(1)';
    });
});


/* ── 9. DRAG-TO-SCROLL SLIDERS ──────────────── */
document.querySelectorAll('.snap-slider').forEach(slider => {
    let isDown = false, startX, scrollLeft;

    slider.addEventListener('mousedown', e => {
        isDown     = true;
        startX     = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
        slider.style.scrollSnapType = 'none';
    });

    slider.addEventListener('mouseleave', () => isDown = false);
    slider.addEventListener('mouseup',    () => {
        isDown = false;
        slider.style.scrollSnapType = 'x mandatory';
    });

    slider.addEventListener('mousemove', e => {
        if (!isDown) return;
        e.preventDefault();
        const x    = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 1.5;
        slider.scrollLeft = scrollLeft - walk;
    });
});

/* ── 11. PAGE TRANSITION (klik link internal) ─ */
const overlay = document.createElement('div');
overlay.id = 'page-transition';
document.body.prepend(overlay);

// Slide in saat halaman muncul
requestAnimationFrame(() => {
    overlay.style.transition = 'transform .8s cubic-bezier(0.16,1,0.3,1)';
    overlay.style.transform  = 'translateY(-100%)';
});

// Slide out saat pindah halaman
document.querySelectorAll('a[href]').forEach(link => {
    const href = link.getAttribute('href');
    // Hanya internal link, bukan anchor atau external
    if (href && !href.startsWith('#') && !href.startsWith('http') &&
        !href.startsWith('javascript') && !href.startsWith('mailto') &&
        !link.hasAttribute('target')) {

        link.addEventListener('click', e => {
            e.preventDefault();
            overlay.style.transition = 'transform .5s cubic-bezier(0.7,0,0.3,1)';
            overlay.style.transform  = 'translateY(0)';
            setTimeout(() => window.location.href = href, 500);
        });
    }
});


/* ── 12. HERO TEXT CLASSES ───────────────────── */
// Tambahkan class animasi ke elemen hero headline
const heroH1 = document.querySelector('#hero-slider-container ~ * h1, section.relative h1');
if (heroH1) {
    heroH1.classList.add('hero-text-1');
    const next = heroH1.nextElementSibling;
    if (next) next.classList.add('hero-text-2');
}


/* ── 13. SMOOTH SCROLLING UTK ANCHOR LINKS ─── */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', e => {
        const target = document.querySelector(anchor.getAttribute('href'));
        if (!target) return;
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});


/* ── 14. COUNTER: Stats di Quick Info Bar ───── */
// Ubah elemen teks angka dengan class .count-up dan data-count
// Contoh: <p class="font-editorial text-xl count-up" data-count="1966">1966</p>


/* ── 15. GSAP SCROLL ANIMATIONS (jika GSAP tersedia) ─ */
window.addEventListener('load', () => {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

    gsap.registerPlugin(ScrollTrigger);

    // Horizontal scroll teks besar di background
    gsap.to('.marquee-track', {
        xPercent: -50,
        ease: 'none',
        duration: 20,
        repeat: -1
    });

    // Hero parallax
    gsap.to('.hero-slide.active img', {
        yPercent: 25,
        ease: 'none',
        scrollTrigger: {
            trigger: 'section.relative.h-screen',
            start: 'top top',
            end: 'bottom top',
            scrub: true
        }
    });

    // Maestro section — image reveal dari kiri
    gsap.from('#maestro .relative.group', {
        x: -80,
        opacity: 0,
        duration: 1.4,
        ease: 'power3.out',
        scrollTrigger: {
            trigger: '#maestro',
            start: 'top 75%',
            once: true
        }
    });

    // Section title — scale dari tengah
    gsap.utils.toArray('.font-editorial.text-5xl, .font-editorial.text-6xl').forEach(el => {
        gsap.from(el, {
            scale: .94,
            opacity: 0,
            y: 30,
            duration: 1.2,
            ease: 'expo.out',
            scrollTrigger: {
                trigger: el,
                start: 'top 85%',
                once: true
            }
        });
    });

    // Schedule cards — stagger masuk dari bawah
    gsap.from('.info-card', {
        y: 50,
        opacity: 0,
        stagger: .1,
        duration: .9,
        ease: 'power3.out',
        scrollTrigger: {
            trigger: '#jadwal-pertunjukan',
            start: 'top 70%',
            once: true
        }
    });

    // Slider cards hover scale
    document.querySelectorAll('.snap-item').forEach(item => {
        item.addEventListener('mouseenter', () => {
            gsap.to(item, { scale: 1.02, duration: .4, ease: 'power2.out' });
        });
        item.addEventListener('mouseleave', () => {
            gsap.to(item, { scale: 1, duration: .4, ease: 'power2.out' });
        });
    });
});


}); // end DOMContentLoaded
</script>
@endpush


{{-- ═══════════════════════════════════════════════════
     CARA PAKAI
     ═══════════════════════════════════════════════════

1.  Simpan file ini sebagai resources/views/partials/enhancements.blade.php

2.  Di resources/views/home.blade.php, setelah @extends('layouts.app')
    tambahkan:
        @include('partials.enhancements')

3.  (Opsional) Tambahkan class helper ke elemen existing:

    ► Animasi huruf per huruf:
        <h1 class="split-text">Saung Angklung Udjo</h1>

    ► Parallax gambar:
        <img data-parallax="0.3" ...>

    ► Counter angka:
        <span class="count-up" data-count="1966" data-suffix="">1966</span>
        <span class="count-up" data-count="16933" data-suffix="+">16.933+</span>

    ► Reveal dari kiri/kanan:
        <div class="reveal reveal-left">...</div>
        <div class="reveal reveal-right">...</div>

    ► Card scale reveal:
        <div class="reveal reveal-scale">...</div>

    ► Stagger group (anak2 muncul berurutan):
        <div class="stagger-group">
            <div>item 1</div>
            <div>item 2</div>
            <div>item 3</div>
        </div>

    ► Marquee teks latar:
        <div class="marquee-wrap">
            <div class="marquee-track">
                <span>Saung Angklung Udjo</span>
                <span>UNESCO Heritage</span>
                <span>Bandung</span>
                <span>Saung Angklung Udjo</span>
                <span>UNESCO Heritage</span>
                <span>Bandung</span>
            </div>
        </div>

═══════════════════════════════════════════════════ --}}