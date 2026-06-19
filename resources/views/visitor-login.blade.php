@extends('layouts.app')

@section('title', 'Masuk / Daftar')

@push('styles')
    <style>
        :root {
            --indigo: #1a1445;
            --indigo-2: #22185d;
            --gold: #c4a47c;
            --gold-lt: rgba(196, 164, 124, .12);
            --bg: #F7F7F2;
            --white: #ffffff;
            --gray-soft: rgba(26, 20, 69, .06);
            --gray-mid: rgba(26, 20, 69, .12);
            --gray-text: rgba(26, 20, 69, .5);
            --success: #2d9f6a;
            --danger: #e05252;
            --wa: #25D366;
            --radius-sm: 6px;
            --radius-md: 14px;
            --radius-lg: 24px;
            --shadow-card: 0 12px 48px rgba(26, 20, 69, .07);
            --shadow-hover: 0 24px 60px rgba(26, 20, 69, .14)
        }

        .page {
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 100px 1.5rem 2rem;
        }

        /* Background foto full screen */
        .page-bg {
            position: absolute; /* ganti dari fixed */
            inset: 0;
            background-image: url('{{ asset('img/Angklungmasal.webp') }}');
            background-size: cover;
            background-position: center center;
            z-index: 0;
        }

        /* Overlay gelap */
        .page-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(26,20,69,.78) 0%, rgba(26,20,69,.55) 100%);
        }

        /* Eyebrow label di pojok kiri bawah */
        .page-eyebrow {
            position: absolute;
            bottom: 2.5rem;
            left: 3rem;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .55em;
            text-transform: uppercase;
            color: var(--gold);
        }

        .page-eyebrow::before {
            content: '';
            display: inline-block;
            width: 24px;
            height: 1px;
            background: var(--gold);
        }

        /* Auth box mengambang di tengah */
        .auth-box {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 440px;
        }

        .mode-switch {
            display: flex;
            background: rgba(255,255,255,.12);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 10px;
            padding: 4px;
            margin-bottom: 1.2rem;
        }

        .mode-btn {
            flex: 1;
            padding: 9px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .22em;
            text-transform: uppercase;
            border: none;
            background: transparent;
            border-radius: 7px;
            cursor: pointer;
            color: rgba(255,255,255,.6);
            transition: all .25s;
        }

        .mode-btn.active {
            background: var(--white);
            color: var(--indigo);
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
        }

        .auth-card {
            background: rgba(255,255,255,.96);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,.4);
            border-radius: var(--radius-lg);
            padding: 2rem 2.2rem;
            box-shadow: 0 24px 60px rgba(26,20,69,.25);
            animation: slideUp .6s cubic-bezier(.16, 1, .3, 1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px) }
            to   { opacity: 1; transform: none }
        }

        .auth-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.3rem;
            font-weight: 400;
            color: var(--indigo);
            margin-bottom: 4px;
        }

        .auth-sub {
            font-size: 11px;
            color: var(--gray-text);
            margin-bottom: 1.6rem;
            line-height: 1.6;
        }

        .tabs {
            display: flex;
            border-bottom: 1px solid var(--gray-mid);
            margin-bottom: 1.6rem;
        }

        .tab {
            flex: 1;
            padding: 11px 6px;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--gray-text);
            border: none;
            background: transparent;
            cursor: pointer;
            transition: all .22s;
            border-bottom: 2px solid transparent;
        }

        .tab:hover { color: var(--indigo) }

        .tab.active {
            color: var(--indigo);
            border-bottom-color: var(--gold);
        }

        .panel { display: none }

        .panel.active {
            display: block;
            animation: fadeIn .3s ease both;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px) }
            to   { opacity: 1; transform: none }
        }

        .btn-google {
            width: 100%;
            padding: 13px;
            background: #fff;
            color: var(--indigo);
            border: 1.5px solid var(--gray-mid);
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all .25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: 1rem;
        }

        .btn-google:hover {
            border-color: var(--gold);
            box-shadow: 0 4px 16px rgba(26,20,69,.08);
            transform: translateY(-1px);
        }

        .btn-google svg { width: 18px; height: 18px; flex-shrink: 0 }

        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 1.2rem 0;
            color: var(--gray-text);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .22em;
            text-transform: uppercase;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--gray-mid);
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 12px;
        }

        .field label {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .32em;
            text-transform: uppercase;
            color: var(--gray-text);
        }

        .field input {
            padding: 11px 13px;
            border: 1.5px solid var(--gray-mid);
            border-radius: var(--radius-sm);
            background: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            color: var(--indigo);
            outline: none;
            transition: border-color .22s;
        }

        .field input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(196,164,124,.1);
        }

        .field input::placeholder { color: rgba(26,20,69,.22) }

        .field.has-err input { border-color: var(--danger) }

        .field-err {
            font-size: 10px;
            color: var(--danger);
            display: none;
        }

        .field.has-err .field-err { display: block }

        .otp-row { display: flex; gap: 8px; align-items: flex-end }
        .otp-row .field { flex: 1; margin-bottom: 0 }

        .otp-send-btn {
            padding: 11px 14px;
            background: var(--indigo);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .18em;
            text-transform: uppercase;
            cursor: pointer;
            white-space: nowrap;
            transition: all .22s;
            flex-shrink: 0;
        }

        .otp-send-btn:hover { background: var(--indigo-2) }

        .otp-send-btn:disabled {
            background: var(--gray-mid);
            color: var(--gray-text);
            cursor: not-allowed;
        }

        .otp-hint {
            font-size: 10px;
            color: var(--gray-text);
            margin-top: 6px;
            margin-bottom: 12px;
            min-height: 16px;
            text-align: center;
        }

        .btn-primary {
            width: 100%;
            padding: 13px;
            background: var(--gold);
            color: var(--indigo);
            border: none;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .25em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .3s cubic-bezier(.16,1,.3,1);
            box-shadow: 0 6px 20px rgba(196,164,124,.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 4px;
        }

        .btn-primary:hover {
            background: #b89240;
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(196,164,124,.35);
        }

        .btn-primary:disabled {
            background: var(--gray-mid);
            color: var(--gray-text);
            box-shadow: none;
            cursor: not-allowed;
            transform: none;
        }

        .btn-spinner {
            width: 13px;
            height: 13px;
            border: 2px solid rgba(26,20,69,.2);
            border-top-color: var(--indigo);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: none;
        }

        .btn-primary.loading .btn-spinner { display: block }
        .btn-primary.loading .btn-label  { display: none }

        @keyframes spin { to { transform: rotate(360deg) } }

        .forgot {
            font-size: 11px;
            color: var(--gray-text);
            text-align: right;
            display: block;
            text-decoration: none;
            margin-bottom: 12px;
            transition: color .2s;
        }

        .forgot:hover { color: var(--gold) }

        .secure-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: rgba(255,255,255,.4);
            margin-top: 1rem;
        }

        .secure-note svg { width: 10px; height: 10px; opacity: .6 }

        .toast {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%) translateY(80px);
            background: var(--indigo);
            padding: 11px 20px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .1em;
            color: #fff;
            z-index: 9999;
            transition: transform .35s cubic-bezier(.16,1,.3,1);
            border: 1px solid rgba(196,164,124,.2);
            box-shadow: 0 16px 40px rgba(26,20,69,.3);
            white-space: nowrap;
            pointer-events: none;
        }

        .toast.show  { transform: translateX(-50%) translateY(0) }
        .toast.err   { border-color: rgba(224,82,82,.4) }
        .toast.ok    { border-color: rgba(45,159,106,.4) }

        @media(max-width:480px) {
            .auth-card { padding: 1.5rem 1.4rem }
            .page-eyebrow { display: none }
        }
    </style>
@endpush

@section('content')

    {{-- Background foto full screen --}}
    <div class="page-bg"></div>

    <div class="page">
        <div class="auth-box">

            <div class="mode-switch">
                <button class="mode-btn active" onclick="switchMode('login')" id="mode-login">Masuk</button>
                <button class="mode-btn" onclick="switchMode('register')" id="mode-register">Daftar</button>
            </div>

            {{-- LOGIN CARD --}}
            <div class="auth-card" id="card-login">
                <h2 class="auth-title">Selamat Datang</h2>
                <p class="auth-sub">Masuk ke akun pengunjung kamu</p>
                <div class="tabs">
                    <button class="tab active" onclick="switchTab('login','google')" id="ltab-google">Google</button>
                    <button class="tab" onclick="switchTab('login','wa')" id="ltab-wa">WhatsApp</button>
                    <button class="tab" onclick="switchTab('login','email')" id="ltab-email">Email</button>
                </div>

                <div class="panel active" id="lpanel-google">
                    <p style="font-size:12px;color:var(--gray-text);line-height:1.75;margin-bottom:1.2rem">Cara paling
                        mudah — nama &amp; email langsung dari akun Google kamu.</p>
                    <a href="{{ route('auth.google.redirect') }}" class="btn-google">
                        <svg viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        Lanjutkan dengan Google
                    </a>
                    <div class="divider">atau</div>
                    <div style="display:flex;gap:8px">
                        <button onclick="switchTab('login','wa')"
                            style="flex:1;padding:10px;border:1.5px solid var(--gray-mid);border-radius:8px;background:transparent;font-size:9px;font-weight:800;letter-spacing:.2em;text-transform:uppercase;color:var(--gray-text);cursor:pointer;transition:all .2s"
                            onmouseover="this.style.borderColor='#25D366'"
                            onmouseout="this.style.borderColor='var(--gray-mid)'">WhatsApp</button>
                        <button onclick="switchTab('login','email')"
                            style="flex:1;padding:10px;border:1.5px solid var(--gray-mid);border-radius:8px;background:transparent;font-size:9px;font-weight:800;letter-spacing:.2em;text-transform:uppercase;color:var(--gray-text);cursor:pointer;transition:all .2s"
                            onmouseover="this.style.borderColor='var(--gold)'"
                            onmouseout="this.style.borderColor='var(--gray-mid)'">Email</button>
                    </div>
                </div>

                <div class="panel" id="lpanel-wa">
                    <div id="lwa-step1">
                        <div class="otp-row">
                            <div class="field" id="lfield-phone">
                                <label>Nomor WhatsApp</label>
                                <input type="tel" id="lf-phone" placeholder="08xxxxxxxxxx" autocomplete="tel">
                                <span class="field-err">Nomor WA tidak valid</span>
                            </div>
                            <button class="otp-send-btn" id="lbtn-otp" onclick="sendOTP('login')">Kirim OTP</button>
                        </div>
                        <div class="otp-hint" id="lotp-hint"></div>
                    </div>
                    <div id="lwa-step2" style="display:none">
                        <div class="field" id="lfield-otp">
                            <label>Kode OTP (6 digit)</label>
                            <input type="text" id="lf-otp" placeholder="• • • • • •" maxlength="6"
                                inputmode="numeric" autocomplete="one-time-code"
                                style="letter-spacing:.3em;font-size:1.2rem;text-align:center">
                            <span class="field-err">OTP tidak valid atau kadaluarsa</span>
                        </div>
                        <p style="font-size:11px;color:var(--gray-text);text-align:center;margin-bottom:14px">Cek WA
                            nomor <strong id="lwa-hint" style="color:var(--indigo)"></strong></p>
                        <button class="btn-primary" onclick="verifyOTP('login')">
                            <div class="btn-spinner"></div><span class="btn-label">Verifikasi &amp; Masuk</span>
                        </button>
                        <button onclick="resetOTP('login')"
                            style="width:100%;padding:9px;margin-top:8px;border:none;background:transparent;font-size:11px;color:var(--gray-text);cursor:pointer;text-decoration:underline">Ganti nomor</button>
                    </div>
                </div>

                <div class="panel" id="lpanel-email">
                    <div class="field" id="lfield-email">
                        <label>Email</label>
                        <input type="email" id="lf-email" placeholder="email@contoh.com" autocomplete="email">
                        <span class="field-err">Email tidak valid</span>
                    </div>
                    <div class="field" id="lfield-pass">
                        <label>Password</label>
                        <input type="password" id="lf-pass" placeholder="••••••••" autocomplete="current-password">
                        <span class="field-err">Password wajib diisi</span>
                    </div>
                    <a href="#" class="forgot">Lupa password?</a>
                    <button class="btn-primary" onclick="loginEmail()">
                        <div class="btn-spinner"></div><span class="btn-label">Masuk</span>
                    </button>
                </div>
            </div>

            {{-- REGISTER CARD --}}
            <div class="auth-card" id="card-register" style="display:none">
                <h2 class="auth-title">Buat Akun Baru</h2>
                <p class="auth-sub">Daftar gratis, nikmati semua fitur pengunjung</p>
                <div class="tabs">
                    <button class="tab active" onclick="switchTab('reg','google')" id="rtab-google">Google</button>
                    <button class="tab" onclick="switchTab('reg','wa')" id="rtab-wa">WhatsApp</button>
                    <button class="tab" onclick="switchTab('reg','email')" id="rtab-email">Email</button>
                </div>

                <div class="panel active" id="rpanel-google">
                    <p style="font-size:12px;color:var(--gray-text);line-height:1.75;margin-bottom:1.2rem">Daftar
                        instan pakai akun Google — tidak perlu isi form panjang.</p>
                    <a href="{{ route('auth.google.redirect') }}" class="btn-google">
                        <svg viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        Daftar dengan Google
                    </a>
                </div>

                <div class="panel" id="rpanel-wa">
                    <div id="rwa-step1">
                        <div class="field" id="rfield-name-wa">
                            <label>Nama Lengkap</label>
                            <input type="text" id="rf-name-wa" placeholder="Nama kamu" autocomplete="name">
                            <span class="field-err">Nama wajib diisi</span>
                        </div>
                        <div class="otp-row">
                            <div class="field" id="rfield-phone">
                                <label>Nomor WhatsApp</label>
                                <input type="tel" id="rf-phone" placeholder="08xxxxxxxxxx" autocomplete="tel">
                                <span class="field-err">Nomor WA tidak valid</span>
                            </div>
                            <button class="otp-send-btn" id="rbtn-otp" onclick="sendOTP('reg')">Kirim OTP</button>
                        </div>
                        <div class="otp-hint" id="rotp-hint"></div>
                    </div>
                    <div id="rwa-step2" style="display:none">
                        <div class="field" id="rfield-otp">
                            <label>Kode OTP (6 digit)</label>
                            <input type="text" id="rf-otp" placeholder="• • • • • •" maxlength="6"
                                inputmode="numeric" autocomplete="one-time-code"
                                style="letter-spacing:.3em;font-size:1.2rem;text-align:center">
                            <span class="field-err">OTP tidak valid atau kadaluarsa</span>
                        </div>
                        <p style="font-size:11px;color:var(--gray-text);text-align:center;margin-bottom:14px">Cek WA
                            nomor <strong id="rwa-hint" style="color:var(--indigo)"></strong></p>
                        <button class="btn-primary" onclick="verifyOTP('reg')">
                            <div class="btn-spinner"></div><span class="btn-label">Verifikasi &amp; Daftar</span>
                        </button>
                        <button onclick="resetOTP('reg')"
                            style="width:100%;padding:9px;margin-top:8px;border:none;background:transparent;font-size:11px;color:var(--gray-text);cursor:pointer;text-decoration:underline">Ganti nomor</button>
                    </div>
                </div>

                <div class="panel" id="rpanel-email">
                    <div class="field" id="rfield-name">
                        <label>Nama Lengkap</label>
                        <input type="text" id="rf-name" placeholder="Nama lengkap kamu" autocomplete="name">
                        <span class="field-err">Nama wajib diisi</span>
                    </div>
                    <div class="field" id="rfield-email">
                        <label>Email</label>
                        <input type="email" id="rf-email" placeholder="email@contoh.com" autocomplete="email">
                        <span class="field-err">Email tidak valid</span>
                    </div>
                    <div class="field" id="rfield-pass">
                        <label>Password</label>
                        <input type="password" id="rf-pass" placeholder="Min. 8 karakter" autocomplete="new-password">
                        <span class="field-err">Min. 8 karakter</span>
                    </div>
                    <div class="field" id="rfield-pass2">
                        <label>Konfirmasi Password</label>
                        <input type="password" id="rf-pass2" placeholder="Ulangi password" autocomplete="new-password">
                        <span class="field-err">Password tidak cocok</span>
                    </div>
                    <button class="btn-primary" onclick="registerEmail()" style="margin-top:4px">
                        <div class="btn-spinner"></div><span class="btn-label">Buat Akun</span>
                    </button>
                </div>
            </div>

            <div class="secure-note">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Data kamu aman &amp; tidak dibagikan ke pihak ketiga
            </div>

        </div>
    </div>

    {{-- Label pojok kiri bawah --}}
    <div class="page-eyebrow">Area Pengunjung</div>

    <div class="toast" id="toast"><span id="toast-msg"></span></div>
@endsection

@push('scripts')
    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

        function switchMode(mode) {
            const isLogin = mode === 'login';
            document.getElementById('mode-login').classList.toggle('active', isLogin);
            document.getElementById('mode-register').classList.toggle('active', !isLogin);
            document.getElementById('card-login').style.display = isLogin ? 'block' : 'none';
            document.getElementById('card-register').style.display = isLogin ? 'none' : 'block';
        }

        function switchTab(card, tab) {
            const prefix = card === 'login' ? 'l' : 'r';
            document.querySelectorAll(`[id^="${prefix}tab-"]`).forEach(t => t.classList.remove('active'));
            document.querySelectorAll(`[id^="${prefix}panel-"]`).forEach(p => p.classList.remove('active'));
            document.getElementById(`${prefix}tab-${tab}`).classList.add('active');
            document.getElementById(`${prefix}panel-${tab}`).classList.add('active');
        }

        let otpTimers = { login: null, reg: null };

        async function sendOTP(ctx) {
            const isReg = ctx === 'reg';
            const phone = document.getElementById(isReg ? 'rf-phone' : 'lf-phone').value.trim().replace(/[^0-9]/g, '');
            const btnId = isReg ? 'rbtn-otp' : 'lbtn-otp';
            const hintId = isReg ? 'rotp-hint' : 'lotp-hint';
            const fid = isReg ? 'rfield-phone' : 'lfield-phone';

            if (phone.length < 10) {
                document.getElementById(fid).classList.add('has-err');
                showToast('⚠ Masukkan nomor WA yang valid', 'err');
                return;
            }
            document.getElementById(fid).classList.remove('has-err');

            if (isReg) {
                const name = document.getElementById('rf-name-wa').value.trim();
                if (!name) { document.getElementById('rfield-name-wa').classList.add('has-err'); return; }
                document.getElementById('rfield-name-wa').classList.remove('has-err');
            }

            const btn = document.getElementById(btnId);
            btn.disabled = true; btn.textContent = '...';

            try {
                const res = await fetch('{{ route('auth.wa.sendOtp') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify({ phone }),
                });
                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'Gagal kirim OTP');
                document.getElementById(isReg ? 'rwa-hint' : 'lwa-hint').textContent = phone;
                document.getElementById(isReg ? 'rwa-step1' : 'lwa-step1').style.display = 'none';
                document.getElementById(isReg ? 'rwa-step2' : 'lwa-step2').style.display = 'block';
                showToast('✅ OTP dikirim ke WhatsApp kamu!', 'ok');
                startCountdown(btnId, hintId, ctx);
            } catch (e) {
                btn.disabled = false; btn.textContent = 'Kirim OTP';
                showToast('❌ ' + e.message, 'err');
            }
        }

        function startCountdown(btnId, hintId, ctx) {
            let s = 60;
            clearInterval(otpTimers[ctx]);
            otpTimers[ctx] = setInterval(() => {
                s--;
                document.getElementById(hintId).textContent = s > 0 ? `Kirim ulang dalam ${s} detik` : '';
                if (s <= 0) {
                    clearInterval(otpTimers[ctx]);
                    const btn = document.getElementById(btnId);
                    btn.disabled = false; btn.textContent = 'Kirim Ulang';
                }
            }, 1000);
        }

        async function verifyOTP(ctx) {
            const isReg = ctx === 'reg';
            const phone = document.getElementById(isReg ? 'rf-phone' : 'lf-phone').value.trim().replace(/[^0-9]/g, '');
            const otp   = document.getElementById(isReg ? 'rf-otp' : 'lf-otp').value.trim();
            const name  = isReg ? document.getElementById('rf-name-wa').value.trim() : null;
            const fid   = isReg ? 'rfield-otp' : 'lfield-otp';

            if (otp.length !== 6) { document.getElementById(fid).classList.add('has-err'); return; }
            document.getElementById(fid).classList.remove('has-err');

            const btn = document.querySelector(`#${isReg ? 'rpanel-wa' : 'lpanel-wa'} .btn-primary`);
            if (btn.disabled) return;
            btn.classList.add('loading'); btn.disabled = true;

            try {
                const res = await fetch('{{ route('auth.wa.verifyOtp') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify({ phone, otp, name }),
                });
                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'OTP tidak valid');
                showToast('✅ Berhasil! Mengalihkan...', 'ok');
                setTimeout(() => window.location.href = data.redirect || '{{ route('visitor.dashboard') }}', 1200);
            } catch (e) {
                btn.classList.remove('loading'); btn.disabled = false;
                document.getElementById(fid).classList.add('has-err');
                showToast('❌ ' + e.message, 'err');
            }
        }

        function resetOTP(ctx) {
            const isReg = ctx === 'reg';
            clearInterval(otpTimers[ctx]);
            document.getElementById(isReg ? 'rwa-step2' : 'lwa-step2').style.display = 'none';
            document.getElementById(isReg ? 'rwa-step1' : 'lwa-step1').style.display = 'block';
            document.getElementById(isReg ? 'rf-phone' : 'lf-phone').value = '';
            document.getElementById(isReg ? 'rf-otp' : 'lf-otp').value = '';
            document.getElementById(isReg ? 'rotp-hint' : 'lotp-hint').textContent = '';
            const btn = document.getElementById(isReg ? 'rbtn-otp' : 'lbtn-otp');
            btn.disabled = false; btn.textContent = 'Kirim OTP';
        }

        async function loginEmail() {
            const email = document.getElementById('lf-email').value.trim();
            const pass  = document.getElementById('lf-pass').value;
            let ok = true;
            const se = (id, err) => { document.getElementById(id).classList.toggle('has-err', err); if (err) ok = false; };
            se('lfield-email', !email || !email.includes('@'));
            se('lfield-pass',  !pass);
            if (!ok) return;
            const btn = document.querySelector('#lpanel-email .btn-primary');
            btn.classList.add('loading'); btn.disabled = true;
            try {
                const res = await fetch('{{ route('auth.email.login') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify({ email, password: pass })
                });
                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'Login gagal');
                showToast('✅ Login berhasil!', 'ok');
                setTimeout(() => window.location.href = data.redirect || '{{ route('visitor.dashboard') }}', 1200);
            } catch (e) {
                btn.classList.remove('loading'); btn.disabled = false;
                showToast('❌ ' + e.message, 'err');
            }
        }

        async function registerEmail() {
            const name  = document.getElementById('rf-name').value.trim();
            const email = document.getElementById('rf-email').value.trim();
            const pass  = document.getElementById('rf-pass').value;
            const pass2 = document.getElementById('rf-pass2').value;
            let ok = true;
            const se = (id, err) => { document.getElementById(id).classList.toggle('has-err', err); if (err) ok = false; };
            se('rfield-name',  !name);
            se('rfield-email', !email || !email.includes('@'));
            se('rfield-pass',  pass.length < 8);
            se('rfield-pass2', pass !== pass2);
            if (!ok) return;
            const btn = document.querySelector('#rpanel-email .btn-primary');
            btn.classList.add('loading'); btn.disabled = true;
            try {
                const res = await fetch('{{ route('auth.email.register') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify({ name, email, password: pass, password_confirmation: pass2 })
                });
                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'Gagal daftar');
                showToast('✅ Akun berhasil dibuat!', 'ok');
                setTimeout(() => window.location.href = data.redirect || '{{ route('visitor.dashboard') }}', 1200);
            } catch (e) {
                btn.classList.remove('loading'); btn.disabled = false;
                showToast('❌ ' + e.message, 'err');
            }
        }

        let tt;
        function showToast(msg, type = '') {
            const t = document.getElementById('toast');
            document.getElementById('toast-msg').textContent = msg;
            t.className = `toast ${type} show`;
            clearTimeout(tt);
            tt = setTimeout(() => t.classList.remove('show'), 3800);
        }

        document.addEventListener('keydown', e => {
            if (e.key !== 'Enter') return;
            const activeTab = document.querySelector('[id^="ltab-"].active, [id^="rtab-"].active');
            if (!activeTab) return;
            if (activeTab.id === 'ltab-email') loginEmail();
            if (activeTab.id === 'rtab-email') registerEmail();
        });
    </script>
@endpush
