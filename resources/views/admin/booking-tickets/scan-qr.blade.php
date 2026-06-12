@extends('admin.layouts.app')
@section('title', 'Scan QR Tiket')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Scan QR Tiket</h1>
        <div class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;display:inline-block;vertical-align:middle;margin:0 4px;">
                <path d="M9 18l6-6-6-6" />
            </svg>
            <span>Ticket Scan</span>
        </div>
    </div>
</div>

<div class="card" style="padding:24px;background:#ffffff;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.05);margin-top:20px;">
    <div style="display:grid;gap:24px;">
        <div>
            <h2 style="margin:0;font-size:20px;font-weight:700;color:#1a1445;">Scan QR Tiket dengan Kamera</h2>
            <p style="margin:8px 0 0;color:var(--text-muted);max-width:720px;">
                Arahkan kamera ke QR code tiket pengunjung. Jika kamera tidak tersedia, Anda dapat memasukkan kode pesanan secara manual.
            </p>
        </div>

        <div style="display:grid;gap:16px;">
            <div style="display:flex;flex-wrap:wrap;gap:12px;align-items:center;">
                <button id="startCamera" type="button" class="btn btn-primary" style="padding:12px 20px;font-weight:600;">Mulai Kamera</button>
                <button id="stopCamera" type="button" class="btn btn-outline" style="padding:12px 20px;font-weight:600;" disabled>Hentikan Kamera</button>
                <span id="cameraStatus" style="font-size:14px;color:var(--text-muted);min-width:180px;">Status kamera: berhenti</span>
            </div>

            <div id="cameraWrapper" style="position:relative;max-width:720px;margin: 0 auto;width:100%;">
                <video id="preview" playsinline style="width:100%;border-radius:16px;background:#000;display:none;"></video>
                <canvas id="overlay" width="640" height="480" style="position:absolute;top:0;left:0;width:100%;height:100%;display:none;pointer-events:none;"></canvas>
            </div>

            <div style="display:grid;gap:12px;margin-top:10px;">
                <label for="order_code" style="font-weight:700;color:#1a1445;">Masukkan kode pesanan manual</label>
                <div style="display:flex;flex-wrap:wrap;gap:12px;">
                    <input type="text" id="order_code" name="order_code" placeholder="Masukkan kode pesanan atau scan QR"
                        style="flex:1;min-width:240px;padding:14px 16px;border:1px solid var(--border-strong);border-radius:12px;font-size:15px;color:var(--text);text-transform:uppercase;font-weight:600;">
                    <button id="validateManual" type="button" class="btn btn-primary" style="padding:12px 20px;font-weight:600;">Validasi Manual</button>
                </div>
            </div>
        </div>

        <div id="scanResult" style="margin-top:12px;padding:20px;border-radius:16px;display:none;"></div>
    </div>
</div>

<style>
    #scanResult p {
        margin:0 0 12px;
    }
    #scanResult p:last-child {
        margin:0;
    }
    #scanResult strong {
        display:inline-block;
        min-width:140px;
    }
    #scanResult.result-success {
        background:#e6f7ef;
        border:1px solid #b6ebc9;
        color:#1f6c3a;
        display:block !important;
    }
    #scanResult.result-warning {
        background:#fff6d9;
        border:1px solid #ffe5a4;
        color:#7b6100;
        display:block !important;
    }
    #scanResult.result-error {
        background:#fde8ea;
        border:1px solid #f4c0c8;
        color:#8d1f2b;
        display:block !important;
    }
    #scanResult .result-details {
        margin-top:12px;
        font-size:14px;
        line-height:1.75;
        border-top: 1px solid rgba(0,0,0,0.06);
        padding-top: 12px;
    }

    #cameraWrapper video,
    #cameraWrapper canvas {
        min-height:280px;
        background:#000;
    }

    @media (max-width: 768px) {
        body {
            overflow-x: hidden;
        }

        .sidebar {
            transform: translateX(-100%) !important;
        }

        .sidebar-overlay {
            display: none !important;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
<script>
    const csrfToken = '{{ csrf_token() }}';
    const preview = document.getElementById('preview');
    const overlay = document.getElementById('overlay');
    const orderCodeInput = document.getElementById('order_code');
    const scanResultDiv = document.getElementById('scanResult');
    const manualButton = document.getElementById('validateManual');
    const startButton = document.getElementById('startCamera');
    const stopButton = document.getElementById('stopCamera');
    const cameraStatus = document.getElementById('cameraStatus');

    const overlayCtx = overlay.getContext('2d');
    const getUserMedia = (
        navigator.mediaDevices?.getUserMedia?.bind(navigator.mediaDevices) ||
        navigator.getUserMedia?.bind(navigator) ||
        navigator.webkitGetUserMedia?.bind(navigator) ||
        navigator.mozGetUserMedia?.bind(navigator)
    );

    let scanning = false;
    let stream = null;
    let requestId = null;

    startButton.addEventListener('click', startCamera);
    stopButton.addEventListener('click', stopCamera);
    manualButton.addEventListener('click', () => validateCode(orderCodeInput.value.trim()));
    orderCodeInput.addEventListener('keyup', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            validateCode(orderCodeInput.value.trim());
        }
    });

    async function startCamera() {
        ensureMobileSidebarHidden();

        if (!getUserMedia) {
            cameraStatus.textContent = 'Status kamera: tidak didukung.';
            showMessage('error', '<p>Browser Anda tidak mendukung akses kamera. Coba buka dengan Chrome atau browser modern terbaru.</p><p>Pastikan juga halaman dibuka dengan protokol aman (HTTPS) atau alamat IP lokal yang valid.</p>');
            return;
        }

        cameraStatus.textContent = 'Status kamera: meminta izin...';
        startButton.disabled = true;

        try {
            stream = await getUserMedia({ video: { facingMode: { ideal: 'environment' } } });
            preview.srcObject = stream;
            preview.style.display = 'block';
            overlay.style.display = 'block';
            preview.play();
            scanning = true;
            cameraStatus.textContent = 'Status kamera: aktif, arahkan QR ke kamera.';
            stopButton.disabled = false;
            scanResultDiv.style.display = 'none';
            requestAnimationFrame(tick);
        } catch (error) {
            cameraStatus.textContent = 'Status kamera: tidak tersedia.';
            let message = `<p>Gagal mengakses kamera: ${error.message}</p>`;

            if (error.name === 'NotAllowedError' || error.name === 'PermissionDeniedError') {
                message = '<p>Izin kamera ditolak. Izinkan kamera di browser Anda dan coba lagi.</p>';
            } else if (error.name === 'NotFoundError' || error.name === 'DevicesNotFoundError') {
                message = '<p>Perangkat kamera tidak ditemukan. Pastikan perangkat Anda memiliki kamera dan tidak sedang digunakan oleh aplikasi lain.</p>';
            } else if (error.name === 'NotReadableError' || error.name === 'TrackStartError') {
                message = '<p>Kamera tidak dapat diakses. Tutup aplikasi lain yang mungkin menggunakan kamera lalu coba lagi.</p>';
            } else if (error.name === 'SecurityError') {
                message = '<p>Browser memblokir akses kamera karena konteks tidak aman. Pastikan halaman dibuka dengan HTTPS atau alamat IP lokal yang valid.</p>';
            }

            showMessage('error', message);
            startButton.disabled = false;
            stopButton.disabled = true;
        }
    }

    function stopCamera() {
        scanning = false;
        if (requestId) {
            cancelAnimationFrame(requestId);
            requestId = null;
        }
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        preview.pause();
        preview.srcObject = null;
        preview.style.display = 'none';
        overlay.style.display = 'none';
        cameraStatus.textContent = 'Status kamera: berhenti';
        startButton.disabled = false;
        stopButton.disabled = true;
    }

    function tick() {
        if (!scanning) {
            return;
        }

        if (preview.readyState === preview.HAVE_ENOUGH_DATA) {
            overlay.width = preview.videoWidth;
            overlay.height = preview.videoHeight;
            overlayCtx.drawImage(preview, 0, 0, overlay.width, overlay.height);

            const imageData = overlayCtx.getImageData(0, 0, overlay.width, overlay.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: 'attemptBoth',
            });

            if (code) {
                // HENTIKAN scanning secara instan sebelum memanggil ajax untuk mencegah loop CPU
                scanning = false;
                if (requestId) {
                    cancelAnimationFrame(requestId);
                    requestId = null;
                }

                drawLine(code.location.topLeftCorner, code.location.topRightCorner, '#4ade80');
                drawLine(code.location.topRightCorner, code.location.bottomRightCorner, '#4ade80');
                drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, '#4ade80');
                drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, '#4ade80');
                
                // bersihkan URL jika format QR berisi link URL lengkap
                let cleanCode = code.data;
                if (code.data.includes('/')) {
                    const parts = code.data.split('/');
                    cleanCode = parts[parts.length - 1];
                }
                
                stopCamera();
                validateCode(cleanCode.trim());
                return;
            }
        }

        requestId = requestAnimationFrame(tick);
    }

    function drawLine(begin, end, color) {
        overlayCtx.beginPath();
        overlayCtx.moveTo(begin.x, begin.y);
        overlayCtx.lineTo(end.x, end.y);
        overlayCtx.lineWidth = 4;
        overlayCtx.strokeStyle = color;
        overlayCtx.stroke();
    }

    function ensureMobileSidebarHidden() {
        const sidebar = document.getElementById('sidebar');
        const overlayElem = document.getElementById('sidebar-overlay');
        const closeBtn = document.getElementById('close-sidebar');

        if (!sidebar) {
            return;
        }

        if (window.innerWidth <= 768) {
            sidebar.classList.add('hidden-mobile');
            sidebar.style.transform = 'translateX(-100%)';
            if (overlayElem) {
                overlayElem.classList.remove('active');
                overlayElem.style.display = 'none';
            }
            if (closeBtn) {
                closeBtn.style.display = 'none';
            }
        }
    }

    async function validateCode(orderCode) {
        if (!orderCode) {
            playTone('error');
            showMessage('error', '<p>Mohon masukkan kode pesanan atau scan QR terlebih dahulu.</p>');
            return;
        }

        try {
            // Map endpoint ke route yang sama
            const response = await fetch('{{ route('admin.booking.ticket.checkin') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ booking_code: orderCode })
            });

            const data = await response.json();
            if (response.ok) {
                playTone('success');
                showMessage('success', `<p><strong>${data.message}</strong></p>${buildDetails(data.data)}`);
            } else {
                playTone('error');
                showMessage('error', `<p><strong>Error:</strong> ${data.message || 'Terjadi kesalahan saat validasi.'}</p>`);
            }
        } catch (error) {
            playTone('error');
            showMessage('error', `<p><strong>Error:</strong> Gagal terhubung ke server.</p>`);
            console.error(error);
        } finally {
            orderCodeInput.value = '';
            orderCodeInput.focus();
        }
    }

    function showMessage(type, html) {
        scanResultDiv.style.display = 'block';
        scanResultDiv.className = '';
        scanResultDiv.classList.add(`result-${type}`);
        scanResultDiv.innerHTML = html;
    }

    function buildDetails(order) {
        if (!order) {
            return '';
        }

        return `<div class="result-details">
            <p><strong>Kode Booking:</strong> ${order.booking_code}</p>
            <p><strong>Nama Pengunjung:</strong> ${order.nama}</p>
            <p><strong>Tanggal Kunjungan:</strong> ${order.tanggal_kunjungan}</p>
            <p><strong>Sesi Jam:</strong> ${order.session_time}</p>
            <p><strong>Rincian Tiket:</strong> ${order.ticket_detail}</p>
            <p><strong>Waktu Scan Masuk:</strong> ${order.checked_in_at ?? '-'}</p>
        </div>`;
    }

    function playTone(type) {
        try {
            const context = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = context.createOscillator();
            const gain = context.createGain();
            oscillator.connect(gain);
            gain.connect(context.destination);

            if (type === 'success') {
                oscillator.frequency.value = 880;
                gain.gain.value = 0.08;
            } else if (type === 'warning') {
                oscillator.frequency.value = 440;
                gain.gain.value = 0.08;
            } else {
                oscillator.frequency.value = 220;
                gain.gain.value = 0.1;
            }

            oscillator.type = 'sine';
            oscillator.start();
            oscillator.stop(context.currentTime + 0.12);
        } catch (error) {
            // AudioContext may be blocked by browser until user interaction.
        }
    }

    window.addEventListener('load', ensureMobileSidebarHidden);
    window.addEventListener('resize', ensureMobileSidebarHidden);
</script>

@endsection
