<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login – Saung Angklung Udjo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Spirax&family=Libre+Baskerville:ital,wght@0,400;1,400&family=Inter:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cream:  #F7F7F2;
            --indigo: #1a1445;
            --gold:   #c4a47c;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--cream);
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1.5rem;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed; inset: 0;
            background: radial-gradient(ellipse 70% 60% at 50% 50%, rgba(196,164,124,0.07) 0%, transparent 70%);
            pointer-events: none;
        }

        .card {
            position: relative;
            width: 100%;
            max-width: 380px;
            background: #ffffff;
            border-radius: 20px;
            padding: 2.75rem 2.25rem 2.25rem;
            box-shadow: 0 4px 40px rgba(26,20,69,0.07), 0 1px 4px rgba(26,20,69,0.04);
            animation: fadeUp 0.55s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .header { text-align: center; margin-bottom: 1.75rem; }
        .logo-icon { display: inline-block; margin-bottom: 0.75rem; }

        .brand-name {
            font-family: 'Spirax', cursive;
            font-size: 1.45rem;
            color: var(--indigo);
            display: block;
            line-height: 1.2;
        }

        .brand-sub {
            font-family: 'Libre Baskerville', serif;
            font-style: italic;
            font-size: 0.68rem;
            color: var(--gold);
            letter-spacing: 0.15em;
            display: block;
            margin-top: 0.2rem;
        }

        .divider { display: flex; align-items: center; gap: 0.6rem; margin: 0 0 1.75rem; }
        .divider-line { flex: 1; height: 1px; background: rgba(26,20,69,0.08); }
        .divider-diamond {
            width: 5px; height: 5px;
            background: var(--gold);
            transform: rotate(45deg);
            flex-shrink: 0;
        }

        .session-status {
            background: rgba(196,164,124,0.1);
            border: 1px solid rgba(196,164,124,0.3);
            border-radius: 10px;
            padding: 0.6rem 0.9rem;
            font-size: 0.82rem;
            color: #a07840;
            margin-bottom: 1.25rem;
        }

        .field { margin-bottom: 1rem; }

        label {
            display: block;
            font-size: 0.63rem; font-weight: 700;
            letter-spacing: 0.15em; text-transform: uppercase;
            color: rgba(26,20,69,0.45);
            margin-bottom: 0.4rem;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            background: var(--cream);
            border: 1.5px solid transparent;
            border-radius: 10px;
            padding: 0.7rem 1rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem; font-weight: 400;
            color: var(--indigo);
            outline: none;
            transition: border-color 0.2s, background 0.2s;
            -webkit-appearance: none;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: var(--gold);
            background: #fff;
        }

        input[type="email"]::placeholder,
        input[type="password"]::placeholder { color: rgba(26,20,69,0.25); }

        .error-msg { font-size: 0.75rem; color: #c0504d; margin-top: 0.35rem; }

        .remember-row {
            display: flex; align-items: center; gap: 0.45rem;
            margin: 0.75rem 0 1.5rem;
        }

        input[type="checkbox"] {
            appearance: none; -webkit-appearance: none;
            width: 15px; height: 15px;
            border: 1.5px solid rgba(26,20,69,0.2);
            border-radius: 4px;
            background: var(--cream);
            flex-shrink: 0; cursor: pointer; position: relative;
            transition: border-color 0.2s, background 0.2s;
        }

        input[type="checkbox"]:checked { border-color: var(--gold); background: var(--gold); }
        input[type="checkbox"]:checked::after {
            content: ''; position: absolute; inset: 3px;
            background: #fff;
            clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0, 43% 62%);
        }

        .remember-row label {
            font-size: 0.75rem; font-weight: 400;
            letter-spacing: 0.02em; text-transform: none;
            color: rgba(26,20,69,0.4); cursor: pointer; margin-bottom: 0;
        }

        /* Tombol full width */
        .btn-login {
            display: block; width: 100%;
            padding: 0.75rem;
            background: var(--indigo);
            border: none; border-radius: 10px;
            color: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 0.72rem; font-weight: 700;
            letter-spacing: 0.18em; text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-login:hover {
            background: var(--gold);
            color: var(--indigo);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(196,164,124,0.3);
        }

        .btn-login:active { transform: scale(0.97); }

        .card-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.62rem;
            color: rgba(26,20,69,0.25);
            letter-spacing: 0.04em;
        }
    </style>
</head>
<body>

<div class="card">

    <div class="header">
   <img src="{{ asset('images/UdjoFullColor.png') }}" 
     alt="Logo Udjo" 
     class="logo-icon" 
     style="width: 60px;">
        <span class="brand-name">Saung Angklung Udjo</span>
        <span class="brand-sub">Panel Administrasi</span>
    </div>

    <div class="divider">
        <div class="divider-line"></div>
        <div class="divider-diamond"></div>
        <div class="divider-line"></div>
    </div>

    @if (session('status'))
        <div class="session-status">{{ session('status') }}</div>
    @endif

   <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                 
            @error('email')
                <div class="error-msg">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password"
                   required autocomplete="current-password"
                  
            @error('password')
                <div class="error-msg">{{ $message }}</div>
            @enderror
        </div>

        <div class="remember-row">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me">Ingat saya</label>
        </div>

        <button type="submit" class="btn-login">Masuk</button>
    </form>

    <div class="card-footer">
        &copy; {{ date('Y') }} Saung Angklung Udjo &middot; Bandung
    </div>

</div>

</body>
</html>