{{-- resources/views/ramadhan.blade.php --}}
@extends('layouts.app')
@section('title', 'Ngabuburit Rasa Liburan – Ramadhan 1447H | Saung Angklung Udjo')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,600;0,9..144,700;0,9..144,900;1,9..144,300;1,9..144,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
/* ══════════════════════════════════════════════════
   DESIGN TOKENS  —  Forest Green + Gold
══════════════════════════════════════════════════ */
:root{
  --night:   #040e08;
  --forest:  #071a0f;
  --mid:     #0a2014;
  --deep:    #050f08;
  --gold:    #d4a53e;
  --gold-l:  #f0c96a;
  --gold-d:  #9e7422;
  --cream:   #f5ede0;
  --sand:    #ede4cc;
  --text:    #1c2b1e;
  --muted:   #5c6e55;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:'DM Sans',system-ui,sans-serif;background:var(--cream);color:var(--text);overflow-x:hidden}
.container{max-width:1140px;margin:0 auto;padding:0 1.5rem}

/* grain */
body::after{
  content:'';position:fixed;inset:0;pointer-events:none;z-index:9999;opacity:.4;mix-blend-mode:overlay;
  background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
}

/* custom cursor */
#cursor-dot{position:fixed;width:7px;height:7px;border-radius:50%;background:var(--gold);pointer-events:none;z-index:99999;transform:translate(-50%,-50%);mix-blend-mode:difference}
#cursor-ring{position:fixed;width:36px;height:36px;border-radius:50%;border:1px solid rgba(212,165,62,.4);pointer-events:none;z-index:99998;transform:translate(-50%,-50%)}
@media(hover:none){#cursor-dot,#cursor-ring{display:none}}

.will-fade{visibility:hidden}

/* progress */
#prog{position:fixed;top:0;left:0;z-index:9998;height:2px;width:0;background:linear-gradient(90deg,var(--gold-d),var(--gold),var(--gold-l))}

/* ══ HERO ══ */
.hero{position:relative;min-height:100svh;display:grid;place-items:center;background:var(--night);overflow:hidden}
.hero__bg{position:absolute;inset:0;width:100%;height:110%;object-fit:cover;object-position:center 30%;opacity:.32;will-change:transform}
.hero__veil{
  position:absolute;inset:0;
  background:
    radial-gradient(ellipse 70% 60% at 50% 52%,transparent 28%,rgba(4,14,8,.72) 70%),
    linear-gradient(to top,rgba(4,14,8,.98) 0%,rgba(4,14,8,.44) 38%,rgba(4,14,8,.1) 60%),
    linear-gradient(to bottom,rgba(4,14,8,.88) 0%,transparent 25%);
}
.hero__glow{
  position:absolute;width:640px;height:640px;border-radius:50%;
  background:radial-gradient(circle,rgba(212,165,62,.1),transparent 68%);
  top:50%;left:50%;transform:translate(-50%,-42%);pointer-events:none;will-change:transform;
}
.hero__geo{
  position:absolute;inset:0;pointer-events:none;opacity:.55;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cg fill='none' stroke='%23d4a53e' stroke-width='0.28' opacity='0.1'%3E%3Cpolygon points='30,2 38,12 50,12 42,22 46,34 30,28 14,34 18,22 10,12 22,12'/%3E%3Ccircle cx='30' cy='30' r='10'/%3E%3C/g%3E%3C/svg%3E");
  background-size:60px 60px;
}

/* moon */
.hero__moon{position:absolute;top:8%;right:13%;width:180px;height:180px;pointer-events:none;z-index:2;opacity:0}

/* lanterns */
.lantern{position:absolute;pointer-events:none;z-index:3;opacity:0}
.lantern--l{top:6%;left:5%}
.lantern--r{top:4%;right:6%}

/* arch */
.hero__arch{position:absolute;top:0;left:50%;transform:translateX(-50%);width:min(600px,90vw);pointer-events:none;z-index:2}
.arch-svg path{stroke:rgba(212,165,62,.26);stroke-width:1;fill:none}

/* content */
.hero__content{position:relative;z-index:5;text-align:center;padding:7rem 1.5rem 8rem;max-width:820px;width:100%}
.hero__top-badge{
  display:inline-flex;align-items:center;gap:.7rem;
  font-size:.65rem;font-weight:600;letter-spacing:.28em;text-transform:uppercase;
  color:rgba(212,165,62,.65);margin-bottom:1.8rem;
}
.hero__top-badge::before,.hero__top-badge::after{content:'';display:block;width:26px;height:1px;background:rgba(212,165,62,.3)}
.hero__arabic{font-size:clamp(1.4rem,3.5vw,2.2rem);color:rgba(212,165,62,.32);font-family:'Fraunces',serif;font-style:italic;margin-bottom:.8rem}
.hero__h1{font-family:'Fraunces',serif;font-size:clamp(3.8rem,10vw,8rem);font-weight:900;font-optical-sizing:auto;line-height:.92;color:#fff;letter-spacing:-.02em;margin-bottom:.5rem}
.hero__h1 em{display:block;font-style:italic;font-weight:300;font-size:.62em;color:var(--gold-l);line-height:1.1}
.tw{display:inline-block;overflow:hidden;vertical-align:top}
.tw-i{display:inline-block}
.hero__rule{display:flex;align-items:center;justify-content:center;gap:1rem;margin:1.6rem auto;max-width:220px;color:rgba(212,165,62,.2)}
.hero__rule hr{flex:1;border:none;border-top:1px solid currentColor}
.hero__rule-star{color:var(--gold);font-size:.55rem;opacity:.5}
.hero__sub{font-size:clamp(.88rem,1.8vw,1.05rem);color:rgba(255,255,255,.36);line-height:1.85;max-width:420px;margin:0 auto 2.8rem;font-weight:300}
.hero__cta{display:flex;flex-wrap:wrap;gap:.9rem;justify-content:center}

/* strip */
.hero__strip{
  position:absolute;bottom:0;left:0;right:0;z-index:6;
  background:rgba(3,9,5,.94);border-top:1px solid rgba(212,165,62,.12);
  backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);
  display:flex;align-items:center;justify-content:center;gap:0;flex-wrap:nowrap;overflow:hidden;
}
.strip-seg{display:flex;align-items:center;justify-content:center;gap:.65rem;padding:.95rem 2.2rem;border-right:1px solid rgba(212,165,62,.07);flex:1;min-width:0}
.strip-seg:last-child{border-right:none}
.strip-seg__icon{color:var(--gold);flex-shrink:0;opacity:.8}
.strip-seg__text{font-size:.68rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:rgba(212,165,62,.58);white-space:nowrap}
@media(max-width:580px){.strip-seg{padding:.8rem 1rem}.strip-seg__text{font-size:.58rem;letter-spacing:.08em}}

/* scroll hint */
.hero__scroll{position:absolute;bottom:5rem;right:2rem;z-index:6;display:flex;flex-direction:column;align-items:center;gap:.5rem}
.hero__scroll span{font-size:.55rem;font-weight:600;letter-spacing:.3em;text-transform:uppercase;color:rgba(212,165,62,.28);writing-mode:vertical-rl}
.hero__scroll-line{width:1px;height:52px;background:linear-gradient(to bottom,rgba(212,165,62,.45),transparent);transform-origin:top}

/* ══ BUTTONS ══ */
.btn-primary{
  display:inline-flex;align-items:center;gap:.7rem;padding:.95rem 2.2rem;
  background:linear-gradient(135deg,var(--gold-l) 0%,var(--gold) 50%,var(--gold-d) 100%);
  color:var(--night);font-size:.78rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
  text-decoration:none;border-radius:2px;position:relative;overflow:hidden;
  transition:transform .35s,box-shadow .35s;box-shadow:0 4px 20px rgba(212,165,62,.22);will-change:transform;
}
.btn-primary::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,.2),transparent 55%);opacity:0;transition:opacity .3s}
.btn-primary:hover{transform:translateY(-3px);box-shadow:0 16px 40px rgba(212,165,62,.32)}
.btn-primary:hover::before{opacity:1}
.btn-ghost{
  display:inline-flex;align-items:center;gap:.7rem;padding:.95rem 2.2rem;
  background:transparent;color:rgba(212,165,62,.7);
  font-size:.78rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;
  text-decoration:none;border-radius:2px;border:1px solid rgba(212,165,62,.22);transition:all .35s;will-change:transform;
}
.btn-ghost:hover{background:rgba(212,165,62,.08);border-color:rgba(212,165,62,.48);color:var(--gold-l)}
.btn-outline-dark{
  display:inline-flex;align-items:center;gap:.7rem;padding:.95rem 2.2rem;
  background:transparent;color:var(--gold-d);
  font-size:.78rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;
  text-decoration:none;border-radius:2px;border:1px solid rgba(158,116,34,.22);transition:all .35s;will-change:transform;
}
.btn-outline-dark:hover{background:rgba(158,116,34,.06);border-color:rgba(158,116,34,.4)}

/* ══ CHIP + SECTION TITLE ══ */
.chip{
  display:inline-flex;align-items:center;gap:.6rem;
  font-size:.62rem;font-weight:700;letter-spacing:.28em;text-transform:uppercase;
  color:var(--gold-d);margin-bottom:.9rem;
}
.chip::before,.chip::after{content:'';display:block;width:0;height:1px;background:var(--gold-d);transition:width .55s ease}
.chip.grown::before,.chip.grown::after{width:20px}
.chip--light{color:rgba(212,165,62,.42)}
.chip--light::before,.chip--light::after{background:rgba(212,165,62,.3)}
.chip--light.grown::before,.chip--light.grown::after{width:20px}
.disp{font-family:'Fraunces',serif;font-optical-sizing:auto;font-size:clamp(2rem,5vw,3.6rem);font-weight:700;line-height:1.06}
.disp em{font-style:italic;font-weight:300;color:var(--gold-d)}
.disp--light{color:#fff}
.disp--light em{color:var(--gold-l)}

/* ══ INTRO ══ */
.intro{background:var(--cream);padding:6.5rem 0;overflow:hidden}
.intro__grid{display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center}
@media(max-width:820px){.intro__grid{grid-template-columns:1fr;gap:3rem}}
.intro__media{position:relative}
.intro__accent{position:absolute;top:2rem;left:-1rem;bottom:2rem;width:2px;background:linear-gradient(to bottom,transparent,var(--gold),transparent);z-index:0}
.intro__frame{position:relative;z-index:1;aspect-ratio:1/1;display:flex;align-items:center;justify-content:center}
.intro__frame img{width:100%;height:100%;object-fit:contain;filter:drop-shadow(0 24px 48px rgba(0,0,0,.18))}
.intro__copy p{font-size:.95rem;color:var(--muted);line-height:1.9;margin-bottom:1rem;font-weight:300}
.intro__stats{display:flex;gap:2.5rem;margin:2rem 0 2.5rem;flex-wrap:wrap}
.stat{border-left:2px solid rgba(212,165,62,.22);padding-left:1rem}
.stat__num{font-family:'Fraunces',serif;font-size:2rem;font-weight:700;color:var(--text);font-optical-sizing:auto;line-height:1}
.stat__label{font-size:.68rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--muted);margin-top:.2rem}

/* ══ MARQUEE ══ */
.marquee{overflow:hidden;background:var(--gold);padding:.72rem 0}
.marquee--dark{background:var(--forest);border-top:1px solid rgba(212,165,62,.08)}
.marquee__track{display:flex;width:max-content}
.marquee__item{display:flex;align-items:center;gap:1.5rem;padding:0 2rem;font-size:.62rem;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:var(--night);white-space:nowrap}
.marquee--dark .marquee__item{color:rgba(212,165,62,.3)}
.marquee__item span{color:rgba(4,14,8,.35)}
.marquee--dark .marquee__item span{color:rgba(212,165,62,.15)}

/* ══ PROGRAM ══ */
.program{background:var(--forest);padding:6.5rem 0;overflow:hidden;position:relative}
.program::before{
  content:'';position:absolute;inset:0;pointer-events:none;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cg fill='none' stroke='%23d4a53e' stroke-width='0.25' opacity='0.07'%3E%3Cpolygon points='30,2 38,12 50,12 42,22 46,34 30,28 14,34 18,22 10,12 22,12'/%3E%3C/g%3E%3C/svg%3E");
  background-size:60px 60px;
}
.program__header{margin-bottom:4rem;text-align:center}
.program__flow{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5px;background:rgba(212,165,62,.07)}
@media(max-width:768px){.program__flow{grid-template-columns:1fr}}

.pf-card{
  background:var(--forest);padding:3rem 2.5rem 2.8rem;
  position:relative;overflow:hidden;transition:background .4s;
  clip-path:inset(0 100% 0 0);
}
.pf-card.revealed{clip-path:inset(0 0% 0 0)}
.pf-card:hover{background:rgba(10,28,18,.9)}
.pf-card::before{
  content:'';position:absolute;top:0;left:0;right:0;height:2px;
  background:linear-gradient(90deg,transparent,rgba(212,165,62,.55),transparent);
  transform:scaleX(0);transform-origin:left;transition:transform .5s ease;
}
.pf-card:hover::before{transform:scaleX(1)}

.pf-num{font-family:'Fraunces',serif;font-size:5rem;font-weight:900;line-height:1;color:rgba(212,165,62,.05);display:block;margin-bottom:-.6rem;transition:color .4s}
.pf-card:hover .pf-num{color:rgba(212,165,62,.12)}

.pf-icon{
  width:52px;height:52px;border:1px solid rgba(212,165,62,.22);border-radius:50%;
  display:flex;align-items:center;justify-content:center;
  margin-bottom:1.8rem;background:rgba(212,165,62,.06);
  transition:background .3s,transform .4s cubic-bezier(.34,1.56,.64,1);
}
.pf-card:hover .pf-icon{background:rgba(212,165,62,.14);transform:scale(1.12)rotate(8deg)}
.pf-title{font-family:'Fraunces',serif;font-optical-sizing:auto;font-size:1.4rem;font-weight:700;color:#fff;margin-bottom:.8rem;line-height:1.15}
.pf-desc{font-size:.86rem;color:rgba(255,255,255,.42);line-height:1.78;font-weight:300}

/* ══ ACTIVITIES ══ */
.activities{background:var(--deep);padding:6rem 0;overflow:hidden}
.act__header{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:3rem;flex-wrap:wrap;gap:1rem}
.act__hint{font-size:.72rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:rgba(212,165,62,.3);display:flex;align-items:center;gap:.6rem}
.act-rail{
  display:grid;grid-template-columns:repeat(5,min(300px,72vw));gap:1rem;
  overflow-x:auto;scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch;
  padding-bottom:1rem;cursor:grab;
}
.act-rail:active{cursor:grabbing}
.act-rail::-webkit-scrollbar{height:2px}
.act-rail::-webkit-scrollbar-track{background:rgba(255,255,255,.02)}
.act-rail::-webkit-scrollbar-thumb{background:rgba(212,165,62,.2);border-radius:1px}
.act-card{scroll-snap-align:start;position:relative;aspect-ratio:3/4;border-radius:4px;overflow:hidden;border:1px solid rgba(212,165,62,.07);cursor:pointer}
.act-card img{width:100%;height:100%;object-fit:cover;filter:saturate(.6)brightness(.68);transition:transform 1.1s ease,filter .5s}
.act-card:hover img{transform:scale(1.08);filter:saturate(.9)brightness(.82)}
.act-card__overlay{
  position:absolute;inset:0;
  background:linear-gradient(to top,rgba(4,14,8,.97) 0%,rgba(4,14,8,.18) 50%,transparent 100%);
  padding:1.6rem 1.4rem 1.4rem;display:flex;flex-direction:column;justify-content:flex-end;color:#fff;
}
.act-card__cat{font-size:.58rem;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);margin-bottom:.5rem;display:flex;align-items:center;gap:.5rem}
.act-card__cat::before{content:'';display:block;width:12px;height:1px;background:var(--gold);opacity:.6}
.act-card__title{font-family:'Fraunces',serif;font-optical-sizing:auto;font-size:1.1rem;font-weight:600;line-height:1.25}
.act-card__border{position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--gold),transparent);transform:scaleX(0);transform-origin:center;transition:transform .5s}
.act-card:hover .act-card__border{transform:scaleX(1)}

/* ══ RUNDOWN ══ */
.rundown{
  background:var(--forest);
  padding:6.5rem 0;
  overflow:hidden;
  position:relative;
}
.rundown::before{
  content:'';position:absolute;inset:0;pointer-events:none;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cg fill='none' stroke='%23d4a53e' stroke-width='0.25' opacity='0.06'%3E%3Cpolygon points='30,2 38,12 50,12 42,22 46,34 30,28 14,34 18,22 10,12 22,12'/%3E%3C/g%3E%3C/svg%3E");
  background-size:60px 60px;
}
.rundown::after{
  content:'';position:absolute;top:0;left:0;right:0;height:120px;pointer-events:none;
  background:linear-gradient(to bottom,rgba(4,14,8,.55),transparent);
}
.rundown__header{text-align:center;margin-bottom:4rem;position:relative;z-index:2;}
.rd-timeline{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:1.5rem;
  position:relative;
  z-index:2;
}
@media(max-width:900px){.rd-timeline{grid-template-columns:repeat(2,1fr)}}
@media(max-width:560px){.rd-timeline{grid-template-columns:1fr}}
.rd-timeline::before{
  content:'';
  position:absolute;
  top:3.8rem;
  left:calc(1/6*100%);
  right:calc(1/6*100%);
  height:1px;
  background:linear-gradient(90deg,transparent,rgba(212,165,62,.18) 10%,rgba(212,165,62,.18) 90%,transparent);
  pointer-events:none;
}
@media(max-width:900px){.rd-timeline::before{display:none}}

/* ── FIX UTAMA: hapus opacity:0 dari CSS, biarkan GSAP yang kontrol ── */
.rd-card{
  background:rgba(7,26,15,.55);
  border:1px solid rgba(212,165,62,.09);
  border-radius:6px;
  padding:2rem 1.8rem 2rem;
  position:relative;
  overflow:hidden;
  transition:border-color .4s,background .35s,transform .45s cubic-bezier(.16,1,.3,1);
  will-change:transform;
}
.rd-card::before{
  content:'';position:absolute;top:0;left:0;right:0;height:1px;
  background:linear-gradient(90deg,transparent,rgba(212,165,62,.4),transparent);
  transform:scaleX(0);transform-origin:left;transition:transform .55s ease;
}
.rd-card:hover{
  border-color:rgba(212,165,62,.24);
  background:rgba(10,28,18,.88);
  transform:translateY(-6px);
}
.rd-card:hover::before{transform:scaleX(1);}
.rd-card__glow{
  position:absolute;bottom:-40px;right:-40px;
  width:140px;height:140px;border-radius:50%;
  background:radial-gradient(circle,rgba(212,165,62,.06),transparent 68%);
  pointer-events:none;transition:opacity .4s;opacity:0;
}
.rd-card:hover .rd-card__glow{opacity:1;}
.rd-clock{
  width:56px;height:56px;border-radius:50%;
  border:1px solid rgba(212,165,62,.22);
  background:rgba(212,165,62,.07);
  display:flex;align-items:center;justify-content:center;
  margin-bottom:1.4rem;
  position:relative;z-index:1;
  transition:background .3s,transform .45s cubic-bezier(.34,1.56,.64,1),border-color .35s;
  flex-shrink:0;
}
.rd-card:hover .rd-clock{
  background:rgba(212,165,62,.16);
  border-color:rgba(212,165,62,.45);
  transform:scale(1.1) rotate(10deg);
}
.rd-clock svg{color:var(--gold);flex-shrink:0;}
.rd-card__dot{
  display:none;
  position:absolute;left:2.4rem;top:-1px;
  width:8px;height:8px;border-radius:50%;
  background:var(--gold);
  box-shadow:0 0 0 3px rgba(212,165,62,.18);
}
@media(max-width:560px){
  .rd-card__dot{display:block;}
  .rd-timeline{padding-left:1.8rem;border-left:1px solid rgba(212,165,62,.12);gap:.9rem;}
  .rd-timeline::before{display:none;}
  .rd-card{padding:1.6rem 1.5rem 1.6rem;}
}
.rd-time{
  display:inline-flex;align-items:center;gap:.45rem;
  font-size:.6rem;font-weight:700;letter-spacing:.2em;text-transform:uppercase;
  color:var(--gold);margin-bottom:.55rem;
  background:rgba(212,165,62,.08);border:1px solid rgba(212,165,62,.14);
  padding:.22rem .75rem;border-radius:100px;
}
.rd-title{
  font-family:'Fraunces',serif;font-optical-sizing:auto;
  font-size:1.1rem;font-weight:700;
  color:#fff;line-height:1.25;margin-bottom:.65rem;
}
.rd-body{font-size:.8rem;color:rgba(255,255,255,.4);line-height:1.78;font-weight:300;}
.rd-step{
  position:absolute;bottom:.6rem;right:1.2rem;
  font-family:'Fraunces',serif;font-size:4.5rem;font-weight:900;
  color:rgba(212,165,62,.04);line-height:1;pointer-events:none;transition:color .4s;
}
.rd-card:hover .rd-step{color:rgba(212,165,62,.09);}
.rd-card--iftar{
  border-color:rgba(212,165,62,.18);
  background:linear-gradient(135deg,rgba(10,28,18,.8) 60%,rgba(212,165,62,.06));
}
.rd-card--iftar .rd-clock{background:rgba(212,165,62,.14);border-color:rgba(212,165,62,.38);}

/* ══ SEGMENTS ══ */
.segments{background:var(--cream);padding:6.5rem 0}
.seg-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;margin-top:3.5rem}
@media(max-width:820px){.seg-grid{grid-template-columns:1fr;gap:1rem}}
.seg-card{
  background:#fff;border:1px solid rgba(212,165,62,.1);border-radius:4px;padding:2.5rem 2rem;
  position:relative;overflow:hidden;
  transition:border-color .4s,transform .45s cubic-bezier(.16,1,.3,1),box-shadow .4s;
  will-change:transform;
}
.seg-card::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(212,165,62,.32),transparent)}
.seg-card:hover{border-color:rgba(212,165,62,.26);transform:translateY(-6px);box-shadow:0 24px 55px rgba(7,26,15,.06)}
.seg-icon{
  width:50px;height:50px;border:1px solid rgba(212,165,62,.14);border-radius:50%;
  display:flex;align-items:center;justify-content:center;
  background:rgba(212,165,62,.05);margin-bottom:1.3rem;
  transition:background .3s,transform .4s cubic-bezier(.34,1.56,.64,1);
}
.seg-card:hover .seg-icon{background:rgba(212,165,62,.1);transform:rotate(8deg)scale(1.1)}
.seg-title{font-family:'Fraunces',serif;font-optical-sizing:auto;font-size:1.15rem;font-weight:600;color:var(--text);margin-bottom:.75rem}
.seg-body{font-size:.84rem;color:var(--muted);line-height:1.82;font-weight:300}

/* ══ GALLERY ══ */
.gallery{background:var(--night);overflow:hidden}
.gallery__head{padding:5rem 1.5rem 3.5rem;text-align:center}
.gallery__duo{display:grid;grid-template-columns:1fr 1fr;gap:3px}
@media(max-width:640px){.gallery__duo{grid-template-columns:1fr}}
.gp{position:relative;height:65vmin;min-height:360px;overflow:hidden;cursor:pointer}
.gp__inner{position:absolute;inset:0;overflow:hidden}
.gp__img{width:100%;height:115%;object-fit:cover;filter:saturate(.6)brightness(.65);transition:filter .65s}
.gp:hover .gp__img{filter:saturate(.88)brightness(.8)}
.gp__veil{position:absolute;inset:0;background:linear-gradient(to top,rgba(4,14,8,.97) 0%,rgba(4,14,8,.16) 55%,transparent 100%);z-index:1}
.gp__body{position:absolute;bottom:0;left:0;right:0;z-index:2;padding:2.8rem 2.5rem 2.5rem}
.gp__tag{font-size:.6rem;font-weight:700;letter-spacing:.24em;text-transform:uppercase;color:var(--gold);margin-bottom:.8rem;display:flex;align-items:center;gap:.7rem}
.gp__tag::before{content:'';display:block;width:0;height:1px;background:var(--gold);transition:width .5s ease}
.gp:hover .gp__tag::before{width:28px}
.gp__title{font-family:'Fraunces',serif;font-optical-sizing:auto;font-size:clamp(1.6rem,3.2vw,2.6rem);font-weight:700;color:#fff;line-height:1.08;margin-bottom:.5rem;transition:transform .4s ease}
.gp:hover .gp__title{transform:translateY(-4px)}
.gp__sub{font-family:'Fraunces',serif;font-optical-sizing:auto;font-size:clamp(.9rem,1.6vw,1.2rem);font-style:italic;font-weight:300;color:var(--gold-l);opacity:.7;margin-bottom:1rem}
.gp__desc{font-size:.8rem;color:rgba(255,255,255,.35);line-height:1.75;max-width:300px;font-weight:300;opacity:0;transform:translateY(8px);transition:opacity .45s .05s,transform .45s .05s}
.gp:hover .gp__desc{opacity:1;transform:none}
.gp__bar{position:absolute;bottom:0;left:0;right:0;height:2px;z-index:3;background:linear-gradient(90deg,transparent,var(--gold),var(--gold-l),var(--gold),transparent);transform:scaleX(0);transform-origin:left;transition:transform .6s cubic-bezier(.16,1,.3,1)}
.gp:hover .gp__bar{transform:scaleX(1)}
.gallery__caption{padding:1.3rem;text-align:center;border-top:1px solid rgba(212,165,62,.06);font-size:.6rem;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:rgba(212,165,62,.16)}

/* ══ PRICING ══ */
.pricing{background:var(--sand);padding:6.5rem 0;overflow:hidden}
.pricing__grid{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-top:3.5rem}
@media(max-width:640px){.pricing__grid{grid-template-columns:1fr}}
.pc{border-radius:4px;padding:2.8rem 2.4rem;border:1px solid rgba(212,165,62,.14);position:relative;overflow:hidden;transition:box-shadow .4s,border-color .35s,transform .45s cubic-bezier(.16,1,.3,1);will-change:transform}
.pc:hover{box-shadow:0 28px 70px rgba(7,26,15,.08);border-color:rgba(212,165,62,.28);transform:translateY(-6px)}
.pc--light{background:#fff}
.pc--dark{background:var(--forest)}
.pc__ribbon{position:absolute;top:1.4rem;right:-2.8rem;width:140px;text-align:center;background:var(--gold);color:var(--night);font-size:.58rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;padding:5px 0;transform:rotate(45deg)}
.pc::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,rgba(212,165,62,.28),transparent)}
.pc--dark::before{background:linear-gradient(90deg,transparent,var(--gold),var(--gold-l),var(--gold),transparent)}
.pc__badge{display:inline-flex;align-items:center;gap:.4rem;font-size:.66rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:.32rem .9rem;border-radius:100px;margin-bottom:1.8rem}
.pc__badge--forest{background:rgba(7,26,15,.06);color:#2d5c3a;border:1px solid rgba(7,26,15,.1)}
.pc__badge--gold{background:rgba(212,165,62,.1);color:var(--gold-d);border:1px solid rgba(212,165,62,.2)}
.pc__price{font-family:'Fraunces',serif;font-optical-sizing:auto;font-size:clamp(2.2rem,5vw,3.2rem);font-weight:900;line-height:1;margin-bottom:.3rem}
.pc--light .pc__price{color:var(--text)}
.pc--dark  .pc__price{color:var(--gold-l)}
.pc__per{font-size:.68rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;margin-bottom:1.8rem}
.pc--light .pc__per{color:rgba(28,43,30,.28)}
.pc--dark  .pc__per{color:rgba(255,255,255,.22)}
.pc__div{height:1px;margin-bottom:1.5rem}
.pc--light .pc__div{background:rgba(212,165,62,.1)}
.pc--dark  .pc__div{background:rgba(255,255,255,.06)}
.pc__list{list-style:none;display:flex;flex-direction:column;gap:.7rem;margin-bottom:1.8rem}
.pc__item{display:flex;align-items:center;gap:.8rem;font-size:.88rem;font-weight:300}
.pc--light .pc__item{color:rgba(28,43,30,.62)}
.pc--dark  .pc__item{color:rgba(255,255,255,.5)}
.pc__chk{flex-shrink:0;width:17px;height:17px;background:rgba(212,165,62,.08);border-radius:50%;display:flex;align-items:center;justify-content:center}
.pc__chk svg{width:9px;height:9px}
.pc__min{font-size:.65rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;margin-bottom:1.5rem}
.pc--light .pc__min{color:rgba(28,43,30,.2)}
.pc--dark  .pc__min{color:rgba(255,255,255,.16)}
.pc__cta{display:inline-flex;align-items:center;gap:.7rem;font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;transition:gap .35s}
.pc--light .pc__cta{color:var(--text)}
.pc--dark  .pc__cta{color:var(--gold-l)}
.pc__cta-line{display:inline-block;width:28px;height:1px;background:currentColor;transition:width .4s}
.pc__cta:hover{gap:1.1rem}
.pc__cta:hover .pc__cta-line{width:50px}
.pricing__note{max-width:680px;margin:2.2rem auto 0;border:1px solid rgba(212,165,62,.1);border-radius:4px;padding:1.3rem 2rem;text-align:center;font-size:.84rem;color:var(--muted);line-height:1.82;font-weight:300}

/* ══ CTA ══ */
.cta{background:var(--mid);padding:7rem 0 6rem;text-align:center;position:relative;overflow:hidden}
.cta__bg-arch{position:absolute;top:-60px;left:50%;transform:translateX(-50%);width:min(700px,95vw);opacity:.04;pointer-events:none;z-index:0}
.cta__ring{position:absolute;border-radius:50%;border:1px solid rgba(212,165,62,.07);top:50%;left:50%;transform:translate(-50%,-50%)scale(0);opacity:0;pointer-events:none}
.cta h2{font-family:'Fraunces',serif;font-optical-sizing:auto;font-size:clamp(2.4rem,7vw,5rem);font-weight:700;color:#fff;line-height:1.08;margin-bottom:1.2rem;position:relative;z-index:1}
.cta h2 em{font-style:italic;font-weight:300;color:var(--gold-l)}
.cta__arabic{font-size:1.2rem;color:rgba(212,165,62,.25);font-family:'Fraunces',serif;font-style:italic;margin-bottom:1.2rem;position:relative;z-index:1}
.cta__sub{font-size:.95rem;color:rgba(255,255,255,.3);line-height:1.85;max-width:380px;margin:0 auto 3rem;font-weight:300;position:relative;z-index:1}
.cta__btns{display:flex;flex-wrap:wrap;gap:.9rem;justify-content:center;position:relative;z-index:1}
.cta__social{display:flex;align-items:center;justify-content:center;gap:2rem;margin-top:3.5rem;flex-wrap:wrap;position:relative;z-index:1}
.cta__social a{display:flex;align-items:center;gap:.5rem;font-size:.66rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.18);text-decoration:none;transition:color .3s}
.cta__social a:hover{color:var(--gold)}
.cta__social__sep{width:1px;height:14px;background:rgba(255,255,255,.06)}

/* ══ RESPONSIVE ══ */
@media(max-width:480px){
  .pc{padding:2rem 1.5rem}
  .gp__body{padding:1.8rem 1.5rem}
  .hero__content{padding:6rem 1.25rem 7rem}
  .hero__scroll{display:none}
  .hero__strip{flex-wrap:wrap}
  .strip-seg{padding:.7rem 1.2rem;flex:0 0 50%}
  .lantern{display:none}
  .hero__moon{display:none}
}
@media(max-width:380px){
  .strip-seg{flex:0 0 100%;border-right:none;border-bottom:1px solid rgba(212,165,62,.06)}
  .strip-seg:last-child{border-bottom:none}
}
</style>
@endpush

@section('content')

{{-- Cursor --}}
<div id="cursor-dot"></div>
<div id="cursor-ring"></div>

<div id="prog"></div>

{{-- ════════════ 01 · HERO ════════════ --}}
<section class="hero" id="hero">
  <img src="{{ asset('img/BANDROS.png') }}" class="hero__bg" id="heroBg" alt="" aria-hidden="true">
  <div class="hero__veil"></div>
  <div class="hero__glow" id="heroGlow"></div>
  <div class="hero__geo"></div>

  <div class="hero__moon" id="heroMoon" aria-hidden="true">
    <svg viewBox="0 0 180 180" fill="none" xmlns="http://www.w3.org/2000/svg" width="180" height="180">
      <path d="M90 18 A72 72 0 1 1 90 162 A50 50 0 1 0 90 18Z" fill="rgba(212,165,62,0.1)" stroke="rgba(212,165,62,0.2)" stroke-width="1"/>
      <circle cx="90" cy="90" r="5" fill="rgba(212,165,62,0.32)"/>
      <circle cx="114" cy="56" r="2.5" fill="rgba(212,165,62,0.18)"/>
    </svg>
  </div>

  <svg class="lantern lantern--l" id="lanternL" width="54" height="100" viewBox="0 0 54 100" fill="none" xmlns="http://www.w3.org/2000/svg">
    <line x1="27" y1="0" x2="27" y2="13" stroke="rgba(212,165,62,0.45)" stroke-width="1.5"/>
    <path d="M15,13 Q7,34 7,54 Q7,78 27,82 Q47,78 47,54 Q47,34 39,13Z" fill="rgba(212,165,62,0.06)" stroke="rgba(212,165,62,0.28)" stroke-width="1.2"/>
    <line x1="17" y1="36" x2="37" y2="36" stroke="rgba(212,165,62,0.12)" stroke-width="1"/>
    <line x1="13" y1="54" x2="41" y2="54" stroke="rgba(212,165,62,0.12)" stroke-width="1"/>
    <line x1="17" y1="70" x2="37" y2="70" stroke="rgba(212,165,62,0.12)" stroke-width="1"/>
    <line x1="27" y1="82" x2="27" y2="96" stroke="rgba(212,165,62,0.3)" stroke-width="1"/>
    <ellipse cx="27" cy="97" rx="6" ry="2.5" fill="rgba(212,165,62,0.18)"/>
    <circle cx="27" cy="46" r="5" fill="rgba(240,201,106,0.5)"/>
  </svg>
  <svg class="lantern lantern--r" id="lanternR" width="42" height="82" viewBox="0 0 42 82" fill="none" xmlns="http://www.w3.org/2000/svg">
    <line x1="21" y1="0" x2="21" y2="10" stroke="rgba(212,165,62,0.45)" stroke-width="1.5"/>
    <path d="M11,10 Q4,29 4,45 Q4,65 21,68 Q38,65 38,45 Q38,29 31,10Z" fill="rgba(212,165,62,0.06)" stroke="rgba(212,165,62,0.26)" stroke-width="1.2"/>
    <line x1="21" y1="68" x2="21" y2="79" stroke="rgba(212,165,62,0.28)" stroke-width="1"/>
    <ellipse cx="21" cy="80" rx="5" ry="2" fill="rgba(212,165,62,0.16)"/>
    <circle cx="21" cy="38" r="4" fill="rgba(240,201,106,0.45)"/>
  </svg>

  <div class="hero__arch" id="heroArch" aria-hidden="true">
    <svg class="arch-svg" viewBox="0 0 600 320" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet">
      <path id="archPath" d="M30,310 L30,200 Q30,60 300,30 Q570,60 570,200 L570,310 M60,310 L60,205 Q60,90 300,60 Q540,90 540,205 L540,310 M300,30 L300,2 M270,38 L270,8 M330,38 L330,8 M240,55 L235,26 M360,55 L365,26 M210,82 L200,56 M390,82 L400,56" stroke="rgba(212,165,62,0.26)" stroke-width="1" fill="none" stroke-dasharray="2200" stroke-dashoffset="2200"/>
      <path id="archDots" d="M300,48 m-4,0 a4,4 0 1,0 8,0 a4,4 0 1,0 -8,0 M268,58 m-3,0 a3,3 0 1,0 6,0 a3,3 0 1,0 -6,0 M332,58 m-3,0 a3,3 0 1,0 6,0 a3,3 0 1,0 -6,0" stroke="rgba(212,165,62,0.32)" stroke-width="1" fill="rgba(212,165,62,0.06)" stroke-dasharray="500" stroke-dashoffset="500"/>
    </svg>
  </div>

  <div class="hero__content will-fade" id="heroContent">
    <div class="hero__top-badge">Saung Angklung Udjo &nbsp;·&nbsp; Ramadhan 1447H</div>
    <p class="hero__arabic" id="heroArabic">رَمَضَانُ كَرِيْم</p>
    <h1 class="hero__h1" id="heroH1">
      <span class="tw"><span class="tw-i">Bandrosan</span></span>
      <span class="tw"><span class="tw-i"> Dulu</span></span>
      <em>
        <span class="tw"><span class="tw-i">Bukanya</span></span>
        <span class="tw"><span class="tw-i"> Di</span></span>
        <span class="tw"><span class="tw-i"> Udjo</span></span>
      </em>
    </h1>
    <div class="hero__rule"><hr><span class="hero__rule-star">✦</span><hr></div>
    <p class="hero__sub" id="heroSub">City tour bersama Bandros, pertunjukan angklung, dan buka puasa bersama — dalam satu hari penuh budaya Sunda yang autentik.</p>
    <div class="hero__cta" id="heroCta">
      <a href="https://wa.me/6282182821200" target="_blank" class="btn-primary">
        <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.558 4.116 1.535 5.847L.058 23.486l5.801-1.522A11.95 11.95 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.79 9.79 0 01-5.031-1.388l-.361-.214-3.743.982.999-3.648-.235-.374A9.79 9.79 0 012.182 12C2.182 6.57 6.57 2.182 12 2.182S21.818 6.57 21.818 12 17.43 21.818 12 21.818z"/></svg>
        Reservasi Sekarang
      </a>
      <a href="#kegiatan" class="btn-ghost">Jelajahi Program</a>
    </div>
  </div>

  <div class="hero__scroll" id="heroScroll">
    <div class="hero__scroll-line" id="scrollLine"></div>
    <span>Scroll</span>
  </div>

  <div class="hero__strip">
    <div class="strip-seg">
      <span class="strip-seg__icon"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg></span>
      <span class="strip-seg__text">1 – 25 Ramadhan 2026</span>
    </div>
    <div class="strip-seg">
      <span class="strip-seg__icon"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg></span>
      <span class="strip-seg__text">Min. 25 Peserta</span>
    </div>
    <div class="strip-seg">
      <span class="strip-seg__icon"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12V22H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg></span>
      <span class="strip-seg__text">Free Ta'jil</span>
    </div>
  </div>
</section>

{{-- ════════════ 02 · INTRO ════════════ --}}
<section class="intro" id="sectionIntro">
  <div class="container">
    <div class="intro__grid">
      <div class="intro__media will-fade" id="introMedia">
        <div class="intro__accent"></div>
        <div class="intro__frame">
          <img src="{{ asset('img/Bandros Peng.png') }}" id="introImg" alt="Bandros City Tour">
        </div>
      </div>
      <div class="will-fade" id="introCopy">
        <div class="chip" id="introChip">Tentang Program</div>
        <h2 class="disp" id="introTitle" style="color:var(--text);margin-bottom:1.5rem">Ngabuburit <em>Rasa Liburan</em></h2>
        <div class="intro__copy">
          <p>Program wisata budaya tematik Ramadhan yang mengintegrasikan city tour bersama Bandros, pertunjukan seni angklung interaktif, dan momen berbuka puasa dalam satu rangkaian terkurasi.</p>
          <p>Cocok untuk komunitas, sekolah, yayasan, panti asuhan, instansi pemerintah, maupun perusahaan yang ingin mengisi Ramadhan dengan pengalaman bermakna.</p>
        </div>
        <a href="#paket-harga" class="btn-outline-dark">
          Lihat Paket Harga
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
      </div>
    </div>
  </div>
</section>

{{-- Marquee gold --}}
<div class="marquee" aria-hidden="true">
  <div class="marquee__track" id="marqueeTrack">
    @for($i=0;$i<4;$i++)
    <div class="marquee__item">Ngabuburit Rasa Liburan <span>✦</span> Saung Angklung Udjo <span>✦</span> Ramadhan 1447H <span>✦</span> City Tour Bandros <span>✦</span> Pertunjukan Bambu <span>✦</span> Buka Puasa Bersama <span>✦</span></div>
    @endfor
  </div>
</div>

{{-- ════════════ 04 · ACTIVITIES ════════════ --}}
<section class="activities" id="actSec">
  <div class="container">
    <div class="act__header">
      <div>
        <div class="chip chip--light" id="actChip">Aktivitas</div>
        <h2 class="disp disp--light will-fade" id="actTitle" style="margin:0">Rangkaian <em>Kegiatan</em></h2>
      </div>
      <div class="act__hint">Geser untuk lihat semua <span style="color:rgba(212,165,62,.15)">→</span></div>
    </div>
    <div class="act-rail" id="actRail">
      @php
      $acts = [
        ['img'=>'img/PROGRAM RAMADHAN 1447H - SAU_page-0001.webp','cat'=>'CITY TOUR',  'title'=>'Bandrosan Keliling Bandung'],
        ['img'=>'img/Interaktif_Angklung.webp',                   'cat'=>'MUSIK',      'title'=>'Angklung Interaktif'],
        ['img'=>'img/Angklungmasal.webp',                         'cat'=>'PERTUNJUKAN','title'=>'Pertunjukan Bambu Sore'],
        ['img'=>'img/MenariBersama.webp',                         'cat'=>'PENGALAMAN', 'title'=>'Menari Bersama'],
        ['img'=>'img/BUKBER.jpg',                                  'cat'=>'IFTAR',      'title'=>'Buka Puasa Bersama'],
      ];
      @endphp
      @foreach($acts as $a)
      <div class="act-card will-fade act-item">
        <img src="{{ asset($a['img']) }}" onerror="this.src='https://images.unsplash.com/photo-1544967082-d9d25d867d66?q=80&w=600'" alt="{{ $a['title'] }}">
        <div class="act-card__overlay">
          <p class="act-card__cat">{{ $a['cat'] }}</p>
          <h3 class="act-card__title">{{ $a['title'] }}</h3>
        </div>
        <div class="act-card__border"></div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ════════════ 04.5 · RUNDOWN ════════════ --}}
<section class="rundown" id="sectionRundown">
  <div class="container" style="position:relative;z-index:2">
    <div class="rundown__header">
      <div class="chip chip--light" id="rdChip" style="justify-content:center">Rundown</div>
      <h2 class="disp disp--light will-fade" id="rdTitle">Alur <em>Hari Ini</em></h2>
      <p class="will-fade" id="rdSub" style="margin-top:.75rem;font-size:.85rem;color:rgba(255,255,255,.3);font-weight:300">
        Satu hari penuh aktivitas — dari jemput hingga buka puasa bersama
      </p>
    </div>
    <div class="rd-timeline" id="rdTimeline">

      <div class="rd-card rd-item">
        <div class="rd-card__dot"></div>
        <div class="rd-card__glow"></div>
        <div class="rd-clock">
          <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 15 14"/></svg>
        </div>
        <div class="rd-time">12.00 WIB</div>
        <h3 class="rd-title">Penjemputan Peserta</h3>
        <p class="rd-body">Bus menjemput rombongan di titik jemput yang telah disepakati. Pastikan seluruh peserta sudah siap tepat waktu.</p>
        <span class="rd-step">01</span>
      </div>

      <div class="rd-card rd-item">
        <div class="rd-card__dot"></div>
        <div class="rd-card__glow"></div>
        <div class="rd-clock">
          <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 15 14"/></svg>
        </div>
        <div class="rd-time">13.00 – 14.30 WIB</div>
        <h3 class="rd-title">Bandrosan Keliling Bandung</h3>
        <p class="rd-body">City tour seru menyusuri ikon-ikon Kota Bandung menggunakan Bandros — bus pariwisata atap terbuka yang ikonik.</p>
        <span class="rd-step">02</span>
      </div>

      <div class="rd-card rd-item">
        <div class="rd-card__dot"></div>
        <div class="rd-card__glow"></div>
        <div class="rd-clock">
          <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 15 14"/></svg>
        </div>
        <div class="rd-time">15.00 WIB</div>
        <h3 class="rd-title">Tiba di Saung Angklung Udjo</h3>
        <p class="rd-body">Rombongan tiba di Saung Angklung Udjo. Disambut hangat dan diarahkan menuju area pertunjukan.</p>
        <span class="rd-step">03</span>
      </div>

      <div class="rd-card rd-item">
        <div class="rd-card__dot"></div>
        <div class="rd-card__glow"></div>
        <div class="rd-clock">
          <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 15 14"/></svg>
        </div>
        <div class="rd-time">15.30 – 17.00 WIB</div>
        <h3 class="rd-title">Pertunjukan Bambu Petang</h3>
        <p class="rd-body">Saksikan dan rasakan langsung pertunjukan angklung interaktif, tari tradisional, dan seni bambu Sunda yang memukau.</p>
        <span class="rd-step">04</span>
      </div>

      <div class="rd-card rd-item">
        <div class="rd-card__dot"></div>
        <div class="rd-card__glow"></div>
        <div class="rd-clock">
          <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 15 14"/></svg>
        </div>
        <div class="rd-time">17.00 – 18.30 WIB</div>
        <h3 class="rd-title">Persiapan Buka Puasa & Maghrib</h3>
        <p class="rd-body">Waktu istirahat, menikmati ta'jil gratis, dan sholat Maghrib bersama sebelum makan berbuka.</p>
        <span class="rd-step">05</span>
      </div>

      <div class="rd-card rd-card--iftar rd-item">
        <div class="rd-card__dot"></div>
        <div class="rd-card__glow"></div>
        <div class="rd-clock">
          <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 002-2V2"/><path d="M7 2v20"/><path d="M21 15V2a5 5 0 00-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/></svg>
        </div>
        <div class="rd-time">Waktu Maghrib</div>
        <h3 class="rd-title">Buka Puasa Bersama 🌙</h3>
        <p class="rd-body">Puncak acara — makan berbuka puasa bersama dalam suasana budaya Sunda yang autentik dan penuh kehangatan silaturahmi.</p>
        <span class="rd-step">06</span>
      </div>

    </div>
  </div>
</section>

{{-- ════════════ 05 · SEGMENTS ════════════ --}}
<section class="segments" id="sectionSeg">
  <div class="container">
    <div style="text-align:center">
      <div class="chip" id="segChip" style="justify-content:center">Untuk Siapa</div>
      <h2 class="disp will-fade" id="segTitle" style="color:var(--text)">Segmentasi <em>Peserta</em></h2>
    </div>
    <div class="seg-grid">
      @php
      $segs = [
        ['path'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z','title'=>'Komunitas & Organisasi','body'=>'Komunitas hobi, organisasi kemasyarakatan, atau kelompok arisan yang ingin ngabuburit dengan cara berbeda dan berkesan.'],
        ['path'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4','title'=>'Pemerintah & Perusahaan','body'=>'Instansi pemerintah dan perusahaan yang ingin gathering atau buka bersama tim dalam suasana budaya yang autentik.'],
        ['path'=>'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z','title'=>'Sekolah & Panti Asuhan','body'=>'Pengalaman edukatif berbalut budaya yang memperkaya wawasan siswa dan menciptakan kenangan Ramadhan yang bermakna.'],
      ];
      @endphp
      @foreach($segs as $s)
      <div class="seg-card will-fade seg-item">
        <div class="seg-icon">
          <svg width="22" height="22" fill="none" stroke="var(--gold-d)" stroke-width="1.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $s['path'] }}"/></svg>
        </div>
        <h3 class="seg-title">{{ $s['title'] }}</h3>
        <p class="seg-body">{{ $s['body'] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ════════════ 06 · GALLERY ════════════ --}}
<section class="gallery" id="sectionGallery">
  <div class="gallery__head">
    <div class="chip chip--light" id="galChip" style="justify-content:center">Galeri</div>
    <h2 class="disp disp--light will-fade" id="galTitle">Suasana <em>Berbuka Puasa</em></h2>
  </div>
  <div class="gallery__duo">
    <div class="gp will-fade" id="gp1">
      <div class="gp__inner">
        <img class="gp__img" id="gp1Img" src="{{ asset('img/PROGRAM RAMADHAN 1447H - NGABUBURIT DI SAU2.jpg') }}" onerror="this.src='https://images.unsplash.com/photo-1594608661623-aa0bd3a69799?q=80&w=1200'" alt="Sesi Angklung">
      </div>
      <div class="gp__veil"></div>
      <div class="gp__body">
        <p class="gp__tag">Kegiatan · 01</p>
        <h3 class="gp__title">Sesi Angklung</h3>
        <p class="gp__sub">& Pertunjukan Bambu Sunda</p>
        <p class="gp__desc">Bermain angklung bersama dan menyaksikan pertunjukan seni bambu yang memukau di sore Ramadhan.</p>
      </div>
      <div class="gp__bar"></div>
    </div>
    <div class="gp will-fade" id="gp2">
      <div class="gp__inner">
        <img class="gp__img" id="gp2Img" src="{{ asset('img/PROGRAM RAMADHAN 1447H - NGABUBURIT DI SAU.jpg') }}" onerror="this.src='https://images.unsplash.com/photo-1567016376408-0226e4d0c1ea?q=80&w=1200'" alt="Buka Puasa">
      </div>
      <div class="gp__veil"></div>
      <div class="gp__body">
        <p class="gp__tag">Iftar · 02</p>
        <h3 class="gp__title">Buka Puasa Bersama</h3>
        <p class="gp__sub">dalam Nuansa Sunda yang Hangat</p>
        <p class="gp__desc">Silaturahmi dan berbuka puasa dalam suasana budaya Sunda yang autentik dan penuh kehangatan.</p>
      </div>
      <div class="gp__bar"></div>
    </div>
  </div>
  <div class="gallery__caption">Dokumentasi Ngabuburit Rasa Liburan &nbsp;✦&nbsp; Saung Angklung Udjo &nbsp;✦&nbsp; Ramadhan 1447H</div>
</section>

{{-- ════════════ 07 · PRICING ════════════ --}}
<section class="pricing" id="paket-harga">
  <div class="container">
    <div style="text-align:center">
      <div class="chip" id="priceChip" style="justify-content:center">Harga Paket</div>
      <h2 class="disp will-fade" id="priceTitle" style="color:var(--text)">Pilih <em>Paket Anda</em></h2>
      <p class="will-fade" id="priceSub" style="margin-top:.75rem;font-size:.85rem;color:var(--muted)">Minimum 25 peserta · Ta'jil gratis untuk semua</p>
    </div>
    <div class="pricing__grid">
      <div class="pc pc--light will-fade" id="pc1">
        <div class="pc__badge pc__badge--forest">Paket Dasar</div>
        <div class="pc__price">Rp 98.000</div>
        <div class="pc__per">per orang</div>
        <div class="pc__div"></div>
        <ul class="pc__list">
          @foreach(['Tiket Pertunjukan','Makan Berbuka Puasa',"Ta'jil Gratis",'Sesi Angklung Interaktif','Guide Saung Udjo'] as $item)
          <li class="pc__item"><span class="pc__chk"><svg fill="none" stroke="var(--gold-d)" stroke-width="2.5" viewBox="0 0 12 12"><path d="M2 6l3 3 5-5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>{{ $item }}</li>
          @endforeach
        </ul>
        <p class="pc__min">Minimum 25 Pax</p>
        <a href="https://wa.me/6282182821200?text=Halo,%20saya%20ingin%20reservasi%20Paket%20Dasar%20Ngabuburit%20Ramadhan%20di%20Saung%20Udjo" target="_blank" class="pc__cta">Reservasi <span class="pc__cta-line"></span></a>
      </div>
      <div class="pc pc--dark will-fade" id="pc2">
        <div class="pc__ribbon">Terlengkap</div>
        <div class="pc__badge pc__badge--gold">Paket Lengkap</div>
        <div class="pc__price">Rp 139.000</div>
        <div class="pc__per">per orang</div>
        <div class="pc__div"></div>
        <ul class="pc__list">
          @foreach(['Bandros City Tour','Tiket Pertunjukan','Makan Berbuka Puasa',"Ta'jil Gratis",'Sesi Angklung Interaktif','Guide Saung Udjo'] as $item)
          <li class="pc__item"><span class="pc__chk"><svg fill="none" stroke="var(--gold)" stroke-width="2.5" viewBox="0 0 12 12"><path d="M2 6l3 3 5-5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>{{ $item }}</li>
          @endforeach
        </ul>
        <p class="pc__min">Minimum 25 Pax</p>
        <a href="https://wa.me/6282182821200?text=Halo,%20saya%20ingin%20reservasi%20Paket%20Lengkap%20Ngabuburit%20Ramadhan%20di%20Saung%20Udjo" target="_blank" class="pc__cta">Reservasi <span class="pc__cta-line"></span></a>
      </div>
    </div>
    <div class="pricing__note will-fade" id="priceNote">Harga sudah termasuk ta'jil gratis untuk setiap peserta. Hubungi Admin untuk informasi lebih lanjut.</div>
  </div>
</section>

{{-- ════════════ 08 · CTA ════════════ --}}
<section class="cta" id="sectionCta">
  <svg class="cta__bg-arch" viewBox="0 0 600 320" xmlns="http://www.w3.org/2000/svg">
    <path d="M30,310 L30,200 Q30,60 300,30 Q570,60 570,200 L570,310 M60,310 L60,205 Q60,90 300,60 Q540,90 540,205 L540,310" stroke="rgba(212,165,62,1)" stroke-width="1" fill="none"/>
  </svg>
  <div class="cta__ring" id="ring1" style="width:320px;height:320px"></div>
  <div class="cta__ring" id="ring2" style="width:560px;height:560px"></div>
  <div class="cta__ring" id="ring3" style="width:800px;height:800px"></div>
  <div class="container" style="position:relative;z-index:2">
    <div class="chip chip--light" id="ctaChip" style="justify-content:center">Reservasi</div>
    <h2 class="will-fade" id="ctaH2">Jadikan Ramadhan<br>Ini <em>Tak Terlupakan</em></h2>
    <p class="cta__arabic will-fade" id="ctaArabic">بِسْمِ اللهِ الرَّحْمٰنِ الرَّحِيْمِ</p>
    <p class="cta__sub will-fade" id="ctaSub">Hubungi tim kami untuk reservasi dan informasi grup. Tersedia untuk minimum 25 peserta.</p>
    <div class="cta__btns will-fade" id="ctaBtns">
      <a href="https://wa.me/6282182821200" target="_blank" class="btn-primary">
        <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.558 4.116 1.535 5.847L.058 23.486l5.801-1.522A11.95 11.95 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.79 9.79 0 01-5.031-1.388l-.361-.214-3.743.982.999-3.648-.235-.374A9.79 9.79 0 012.182 12C2.182 6.57 6.57 2.182 12 2.182S21.818 6.57 21.818 12 17.43 21.818 12 21.818z"/></svg>
        082182821200
      </a>
      <a href="{{ route('home') }}" class="btn-ghost">Kembali ke Beranda</a>
    </div>
    <div class="cta__social will-fade" id="ctaSocial">
      <a href="https://instagram.com/angklungudjo" target="_blank">
        <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
        @angklungudjo
      </a>
      <div class="cta__social__sep"></div>
      <a href="https://tiktok.com/@saungangklungudjo" target="_blank">
        <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.77 1.52V6.75a4.85 4.85 0 01-1-.06z"/></svg>
        @saungangklungudjo
      </a>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script>
(function(){
'use strict';
gsap.registerPlugin(ScrollTrigger);

const $  = s => document.querySelector(s);
const $$ = s => [...document.querySelectorAll(s)];
const E4 = 'power4.out';
const E3 = 'power3.out';

/* ══ CUSTOM CURSOR ══ */
const curDot  = $('#cursor-dot');
const curRing = $('#cursor-ring');
if(curDot && window.matchMedia('(hover:hover)').matches){
  let mx=0,my=0,rx=0,ry=0;
  document.addEventListener('mousemove',e=>{ mx=e.clientX; my=e.clientY; gsap.set(curDot,{x:mx,y:my}); });
  (function ringTick(){ rx+=(mx-rx)*.11; ry+=(my-ry)*.11; gsap.set(curRing,{x:rx,y:ry}); requestAnimationFrame(ringTick); })();
  $$('a,button').forEach(el=>{
    el.addEventListener('mouseenter',()=>gsap.to(curRing,{width:60,height:60,duration:.28}));
    el.addEventListener('mouseleave',()=>gsap.to(curRing,{width:36,height:36,duration:.28}));
  });
}

/* ══ PROGRESS BAR ══ */
ScrollTrigger.create({ trigger:'body',start:'top top',end:'bottom bottom',
  onUpdate:s=>{ $('#prog').style.width=(s.progress*100)+'%'; }
});

/* show .will-fade */
$$('.will-fade').forEach(el=>el.style.visibility='visible');

/* ══ MARQUEES ══ */
function runMarquee(id,speed,dir){
  const tr=$(id); if(!tr)return;
  let x=0; const w=tr.scrollWidth/2;
  (function tick(){
    x-=speed*dir;
    if(dir>0&&x<=-w)x=0;
    if(dir<0&&x>=0) x=-w;
    tr.style.transform=`translateX(${x}px)`;
    requestAnimationFrame(tick);
  })();
}
runMarquee('#marqueeTrack',  .55,  1);
runMarquee('#marqueeTrack2', .45, -1);

/* ══ HERO ══ */
const htl = gsap.timeline({defaults:{ease:E4}});
htl
  .from('#heroBg',     {scale:1.22,duration:3.2,ease:'power2.out'},0)
  .fromTo('#heroMoon', {opacity:0,x:50,y:-30},{opacity:1,x:0,y:0,duration:2.2,ease:'power2.out'},0.5)
  .fromTo(['#lanternL','#lanternR'],{opacity:0,y:-45},{opacity:1,y:0,stagger:.2,duration:1.4,ease:'bounce.out'},1.2)
  .to('#archPath',     {strokeDashoffset:0,duration:2.4,ease:'power2.inOut'},0.4)
  .to('#archDots',     {strokeDashoffset:0,duration:1.5,ease:'power2.out'},1.4)
  .from('#heroGlow',   {scale:0,opacity:0,duration:2,ease:'power2.out'},0.6)
  .from('#heroContent .hero__top-badge',{opacity:0,y:16,duration:.72},1.6)
  .from('#heroArabic', {opacity:0,y:14,duration:.68},1.85)
  .from('.tw-i',       {y:'115%',opacity:0,duration:.92,stagger:.1,ease:E4},2.0)
  .from('.hero__rule', {opacity:0,scaleX:.3,duration:.72},2.5)
  .from('#heroSub',    {opacity:0,y:20,duration:.7},2.65)
  .from('#heroCta',    {opacity:0,y:18,duration:.66},2.82)
  .from('#heroScroll', {opacity:0,duration:.6},3.0)
  .from('.strip-seg',  {opacity:0,y:18,stagger:.12,duration:.6},2.82);

gsap.to('#scrollLine',{scaleY:0,transformOrigin:'bottom',duration:.95,ease:'power2.inOut',repeat:-1,repeatDelay:.4});
gsap.to('#lanternL',{rotation:5,transformOrigin:'50% 0%',duration:3.8,ease:'sine.inOut',repeat:-1,yoyo:true,delay:2.5});
gsap.to('#lanternR',{rotation:-5,transformOrigin:'50% 0%',duration:4.5,ease:'sine.inOut',repeat:-1,yoyo:true,delay:3});
gsap.to('#heroMoon',{y:'+=16',duration:5.5,ease:'sine.inOut',repeat:-1,yoyo:true,delay:2});

ScrollTrigger.create({
  trigger:'#hero',start:'top top',end:'bottom top',scrub:.9,
  onUpdate:s=>{
    gsap.set('#heroBg',    {y:s.progress*140});
    gsap.set('#heroGlow',  {y:s.progress*85});
    gsap.set('#heroArch',  {y:s.progress*65});
    gsap.set('#heroMoon',  {y:s.progress*55});
    gsap.set('#heroContent',{y:s.progress*58,opacity:1-s.progress*1.7});
  }
});

document.addEventListener('mousemove',e=>{
  const nx=(e.clientX/innerWidth-.5), ny=(e.clientY/innerHeight-.5);
  gsap.to('#heroGlow', {x:nx*55,y:ny*42,duration:2,ease:'power2.out',overwrite:true});
  gsap.to('#heroMoon', {x:nx*28,duration:2.5,ease:'power2.out',overwrite:true});
  gsap.to(['#lanternL','#lanternR'],{x:nx*18,duration:3,ease:'power2.out',overwrite:true});
});

/* ══ SCROLL REVEAL HELPER ══ */
function sr(el,from={},opts={}){
  if(!el)return;
  gsap.fromTo(el,{opacity:0,...from},{
    opacity:1,x:0,y:0,scale:1,rotation:0,
    duration:opts.d||.9,ease:opts.ease||E4,delay:opts.delay||0,
    scrollTrigger:{trigger:el,start:opts.start||'top 88%',toggleActions:'play none none none'}
  });
}
function chipGrow(id){ ScrollTrigger.create({trigger:id,start:'top 90%',once:true,onEnter:()=>$(id)&&$(id).classList.add('grown')}); }

/* ══ 02 · INTRO ══ */
chipGrow('#introChip');
sr('#introMedia',{x:-60,rotation:-1},{d:1.05});
sr('#introCopy', {x:55},{d:.92});
ScrollTrigger.create({
  trigger:'#sectionIntro',start:'top bottom',end:'bottom top',scrub:.75,
  onUpdate:s=>gsap.set('#introImg',{y:s.progress*35-17})
});
$$('.stat__num').forEach(el=>{
  const t=+el.dataset.target;
  ScrollTrigger.create({trigger:el,start:'top 88%',once:true,onEnter:()=>{
    let n=0; const step=t/44;
    const iv=setInterval(()=>{ n=Math.min(n+step,t); el.textContent=Math.round(n)+(t===3?'':'+'); if(n>=t)clearInterval(iv); },26);
  }});
});

/* ══ 03 · PROGRAM ══ */
chipGrow('#progChip');
sr('#progTitle',{y:45},{d:1});
$$('.pf-item').forEach((el,i)=>{
  ScrollTrigger.create({trigger:el,start:'top 88%',once:true,onEnter:()=>{
    el.style.transition=`clip-path .88s cubic-bezier(.16,1,.3,1) ${i*.14}s, background .4s`;
    el.classList.add('revealed');
    gsap.fromTo(el.querySelectorAll('.pf-num,.pf-icon,.pf-title,.pf-desc'),
      {opacity:0,y:22},{opacity:1,y:0,duration:.72,stagger:.08,delay:.32+i*.14,ease:E3});
  }});
});

/* ══ 04 · ACTIVITIES ══ */
chipGrow('#actChip');
sr('#actTitle',{y:40},{d:1});
$$('.act-item').forEach((el,i)=>{
  gsap.fromTo(el,{opacity:0,y:35,scale:.92},
    {opacity:1,y:0,scale:1,duration:.75,ease:E4,delay:i*.09,
     scrollTrigger:{trigger:'#actRail',start:'top 85%',toggleActions:'play none none none'}});
});
(()=>{
  const rail=$('#actRail'); if(!rail)return;
  let dn=false,sx,sl;
  rail.addEventListener('mousedown',e=>{dn=true;sx=e.pageX-rail.offsetLeft;sl=rail.scrollLeft});
  rail.addEventListener('mouseleave',()=>dn=false);
  rail.addEventListener('mouseup',()=>dn=false);
  rail.addEventListener('mousemove',e=>{if(!dn)return;e.preventDefault();rail.scrollLeft=sl-(e.pageX-rail.offsetLeft-sx)*1.45;});
})();

/* ══════════════════════════════
   04.5 · RUNDOWN  ← FIX DI SINI
   GSAP mengontrol opacity & y,
   tidak ada CSS opacity:0 lagi
══════════════════════════════ */
chipGrow('#rdChip');
sr('#rdTitle',{y:45},{d:1});
sr('#rdSub',  {y:28},{d:.72,delay:.08});
$$('.rd-item').forEach((el,i)=>{
  gsap.fromTo(el,
    {opacity:0, y:45},
    {
      opacity:1, y:0,
      duration:.82,
      ease:E4,
      delay:i*.11,
      scrollTrigger:{
        trigger:'#rdTimeline',
        start:'top 86%',
        toggleActions:'play none none none'
      }
    }
  );
});

/* ══ 05 · SEGMENTS ══ */
chipGrow('#segChip');
sr('#segTitle',{y:45},{d:1});
$$('.seg-item').forEach((el,i)=>{
  gsap.fromTo(el,{opacity:0,y:55},
    {opacity:1,y:0,duration:.88,ease:E4,delay:i*.14,
     scrollTrigger:{trigger:el,start:'top 88%',toggleActions:'play none none none'}});
  el.addEventListener('mousemove',e=>{
    const r=el.getBoundingClientRect();
    gsap.to(el,{rotationY:(e.clientX-r.left)/r.width*12-6,rotationX:-((e.clientY-r.top)/r.height*10-5),transformPerspective:700,ease:'power2.out',duration:.38});
  });
  el.addEventListener('mouseleave',()=>gsap.to(el,{rotationY:0,rotationX:0,duration:.7,ease:'elastic.out(1,.55)'}));
});

/* ══ 06 · GALLERY ══ */
chipGrow('#galChip');
sr('#galTitle',{y:40},{d:1});
sr('#gp1',{x:-70,rotation:-1.5},{d:1.05});
sr('#gp2',{x: 70,rotation: 1.5},{d:1.05});
[['#gp1','#gp1Img'],['#gp2','#gp2Img']].forEach(([t,img])=>{
  ScrollTrigger.create({trigger:t,start:'top bottom',end:'bottom top',scrub:.65,
    onUpdate:s=>gsap.set(img,{y:s.progress*60-30})});
});

/* ══ 07 · PRICING ══ */
chipGrow('#priceChip');
sr('#priceTitle',{y:42},{d:1});
sr('#priceSub',  {y:28},{d:.72,delay:.1});
sr('#pc1',{x:-58,rotation:-1.5},{d:.95,ease:'back.out(1.6)'});
sr('#pc2',{x: 58,rotation: 1.5},{d:.95,ease:'back.out(1.6)'});
sr('#priceNote', {y:26},{d:.75,delay:.14});

$$('.btn-primary,.btn-ghost,.btn-outline-dark').forEach(btn=>{
  btn.addEventListener('mousemove',e=>{
    const r=btn.getBoundingClientRect();
    gsap.to(btn,{x:(e.clientX-r.left-r.width/2)*.28,y:(e.clientY-r.top-r.height/2)*.3,duration:.36,ease:'power2.out'});
  });
  btn.addEventListener('mouseleave',()=>gsap.to(btn,{x:0,y:0,duration:.7,ease:'elastic.out(1,.5)'}));
});

/* ══ 08 · CTA ══ */
chipGrow('#ctaChip');
sr('#ctaH2',    {y:50},{d:1.05});
sr('#ctaArabic',{y:30},{d:.7,delay:.1});
sr('#ctaSub',   {y:28},{d:.7,delay:.18});
sr('#ctaBtns',  {y:24},{d:.72,delay:.26});
sr('#ctaSocial',{y:20},{d:.68,delay:.34});
ScrollTrigger.create({
  trigger:'#sectionCta',start:'top 72%',once:true,
  onEnter:()=>{
    gsap.to(['#ring1','#ring2','#ring3'],{scale:1,opacity:1,duration:1.5,stagger:.28,ease:'back.out(1.6)'});
    gsap.to(['#ring1','#ring2','#ring3'],{scale:1.08,opacity:.35,duration:4,repeat:-1,yoyo:true,ease:'power1.inOut',stagger:.6,delay:2});
  }
});

})();
</script>
@endpush