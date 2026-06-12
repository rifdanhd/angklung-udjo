@extends('admin.layouts.app')

@section('title', 'Scan QR Check-In E-Ticket')

@push('styles')
<style>
    .scanner-container {
        max-width: 650px;
        margin: 2rem auto;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(26, 20, 69, 0.08);
        padding: 2.5rem;
        text-align: center;
    }
    .scanner-title {
        color: #1a1445;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .scanner-desc {
        color: #64748b;
        font-size: 0.95rem;
        margin-bottom: 2rem;
    }
    #interactive {
        width: 100%;
        max-width: 450px;
        height: auto;
        margin: 0 auto 1.5rem;
        border-radius: 12px;
        overflow: hidden;
        border: 4px solid #1a1445;
        position: relative;
        background: #000;
    }
    #interactive video {
        width: 100%;
        height: auto;
        display: block;
    }
    .scan-feedback {
        margin: 1.5rem 0;
        padding: 1rem;
        border-radius: 8px;
        font-weight: 600;
        display: none;
    }
    .scan-feedback.success {
        background-color: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }
    .scan-feedback.error {
        background-color: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fca5a5;
    }
    .manual-input-box {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }
    .input-group {
        display: flex;
        gap: 0.5rem;
        max-width: 400px;
        margin: 1rem auto 0;
    }
    .input-control {
        flex: 1;
        padding: 0.75rem 1rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.95rem;
        text-transform: uppercase;
        font-weight: 600;
    }
    .btn-submit {
        background: #1a1445;
        color: #fff;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-submit:hover {
        background: #2a1c7a;
    }
    .ticket-details-box {
        margin-top: 1.5rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 1.25rem;
        text-align: left;
        display: none;
    }
    .ticket-details-box h4 {
        margin-top: 0;
        color: #1a1445;
        border-bottom: 1px solid #cbd5e1;
        padding-bottom: 0.5rem;
        margin-bottom: 0.75rem;
    }
    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.4rem;
        font-size: 0.9rem;
    }
    .detail-label {
        color: #64748b;
        font-weight: 500;
    }
    .detail-value {
        font-weight: 600;
        color: #1a1445;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">E-Ticket Scan Check-In</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.booking.online') }}">Booking Online</a></li>
        <li class="breadcrumb-item active">Scan QR</li>
    </ol>

    <div class="scanner-container">
        <h2 class="scanner-title">Arahkan Kamera ke QR Code E-Ticket</h2>
        <p class="scanner-desc">Gunakan kamera ponsel/laptop Anda untuk memindai kode QR yang tertera pada e-ticket pengunjung.</p>

        {{-- Tempat Kamera --}}
        <div id="interactive"></div>

        {{-- Umpan Balik Scanner --}}
        <div id="scan-feedback" class="scan-feedback"></div>

        {{-- Box Detil Tiket setelah scan --}}
        <div id="ticket-details" class="ticket-details-box">
            <h4>📄 Informasi E-Ticket:</h4>
            <div class="detail-row">
                <span class="detail-label">Kode Booking:</span>
                <span class="detail-value" id="detail-code">-</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Nama Pengunjung:</span>
                <span class="detail-value" id="detail-name">-</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal Kunjungan:</span>
                <span class="detail-value" id="detail-date">-</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Sesi Jam:</span>
                <span class="detail-value" id="detail-session">-</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Rincian Tiket:</span>
                <span class="detail-value" id="detail-tickets">-</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Waktu Scan Masuk:</span>
                <span class="detail-value" id="detail-time">-</span>
            </div>
        </div>

        {{-- Input Manual Kode Booking --}}
        <div class="manual-input-box">
            <p class="mb-1 text-muted" style="font-size: 0.9rem;">Kamera bermasalah? Input Kode Booking secara manual:</p>
            <form id="manual-form" onsubmit="submitManual(event)">
                @csrf
                <div class="input-group">
                    <input type="text" id="manual-code" class="input-control" placeholder="Contoh: UDJO-XXXXXX" required autocomplete="off">
                    <button type="submit" class="btn-submit">Check-In</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Library QR Scanner Html5-Qrcode yang andal & ringan --}}
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    let html5QrcodeScanner;
    
    function showFeedback(success, message) {
        const fb = document.getElementById('scan-feedback');
        fb.textContent = message;
        fb.className = 'scan-feedback ' + (success ? 'success' : 'error');
        fb.style.display = 'block';
    }

    function processCheckin(bookingCode) {
        // Hentikan sementara scanner agar tidak double trigger
        if (html5QrcodeScanner) {
            html5QrcodeScanner.pause(true);
        }

        const token = document.querySelector('input[name="_token"]').value;

        fetch('{{ route("admin.booking.ticket.checkin") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ booking_code: bookingCode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showFeedback(true, data.message);
                
                // Isi rincian data tiket ke UI
                document.getElementById('detail-code').textContent = data.data.booking_code;
                document.getElementById('detail-name').textContent = data.data.nama;
                document.getElementById('detail-date').textContent = data.data.tanggal_kunjungan;
                document.getElementById('detail-session').textContent = data.data.session_time;
                document.getElementById('detail-tickets').textContent = data.data.ticket_detail;
                document.getElementById('detail-time').textContent = data.data.checked_in_at;
                document.getElementById('ticket-details').style.display = 'block';
                
                // Mainkan suara checkin sukses (opsional)
                try {
                    let audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                    let osc = audioCtx.createOscillator();
                    let gain = audioCtx.createGain();
                    osc.connect(gain);
                    gain.connect(audioCtx.destination);
                    osc.frequency.setValueAtTime(880, audioCtx.currentTime); // Sound pitch
                    osc.start();
                    osc.stop(audioCtx.currentTime + 0.15);
                } catch(e) {}
            } else {
                showFeedback(false, data.message);
                document.getElementById('ticket-details').style.display = 'none';
            }
        })
        .catch(err => {
            showFeedback(false, 'Terjadi kesalahan jaringan.');
            document.getElementById('ticket-details').style.display = 'none';
        })
        .finally(() => {
            // Jalankan kembali scanner setelah 3.5 detik jeda
            setTimeout(() => {
                if (html5QrcodeScanner) {
                    html5QrcodeScanner.resume();
                }
            }, 3500);
        });
    }

    function submitManual(e) {
        e.preventDefault();
        const codeInput = document.getElementById('manual-code');
        const code = codeInput.value.trim().toUpperCase();
        if (code) {
            processCheckin(code);
            codeInput.value = '';
        }
    }

    // Inisialisasi scanner saat halaman siap
    document.addEventListener("DOMContentLoaded", function () {
        html5QrcodeScanner = new Html5Qrcode("interactive");
        
        const config = { 
            fps: 10, 
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0
        };

        // Mulai kamera belakang (environment) secara default
        html5QrcodeScanner.start(
            { facingMode: "environment" }, 
            config,
            (decodedText, decodedResult) => {
                // Di sini ketika QR ter-scan, bersihkan URL jika format QR berisi link URL lengkap
                let cleanCode = decodedText;
                if (decodedText.includes('/')) {
                    const parts = decodedText.split('/');
                    cleanCode = parts[parts.length - 1]; // Ambil bagian kode booking saja
                }
                processCheckin(cleanCode.trim());
            },
            (errorMessage) => {
                // Biarkan silent error log
            }
        ).catch(err => {
            showFeedback(false, "Gagal mengakses kamera. Pastikan izin kamera telah diberikan.");
        });
    });
</script>
@endpush
