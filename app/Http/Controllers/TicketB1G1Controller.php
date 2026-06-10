<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketB1G1Controller extends Controller
{
    // Harga tiket reguler (ubah sesuai kebutuhan)
    const HARGA_TIKET = 60000;

    /**
     * Tampilkan halaman form pembelian
     */
  public function buy() 
{
    return view('tickets.buy', [
        'harga_tiket' => self::HARGA_TIKET,
    ]);
}

    /**
     * Simpan order & redirect ke halaman pembayaran
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pemesan'      => 'required|string|max:100',
            'email'             => 'required|email|max:100',
            'no_telepon'        => 'required|string|max:20',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jumlah_tiket'      => 'required|integer|min:1|max:20',
        ], [
            'nama_pemesan.required'      => 'Nama pemesan wajib diisi.',
            'email.required'             => 'Email wajib diisi.',
            'email.email'                => 'Format email tidak valid.',
            'no_telepon.required'        => 'Nomor telepon wajib diisi.',
            'tanggal_kunjungan.required' => 'Tanggal kunjungan wajib dipilih.',
            'tanggal_kunjungan.after_or_equal' => 'Tanggal kunjungan tidak boleh di masa lalu.',
            'jumlah_tiket.required'      => 'Jumlah tiket wajib diisi.',
            'jumlah_tiket.min'           => 'Minimal pembelian 1 tiket.',
        ]);

        $jumlah      = (int) $validated['jumlah_tiket'];
        $gratis      = $jumlah; // B1G1 → dapat tiket gratis sebanyak tiket yang dibeli
        $totalBayar  = $jumlah * self::HARGA_TIKET;

        $order = Order::create([
            'order_code'          => Order::generateOrderCode(),
            'nama_pemesan'        => $validated['nama_pemesan'],
            'email'               => $validated['email'],
            'no_telepon'          => $validated['no_telepon'],
            'tanggal_kunjungan'   => $validated['tanggal_kunjungan'],
            'jumlah_tiket'        => $jumlah,
            'jumlah_tiket_gratis' => $gratis,
            'total_tiket'         => $jumlah + $gratis,
            'harga_per_tiket'     => self::HARGA_TIKET,
            'total_bayar'         => $totalBayar,
            'status'              => 'pending',
        ]);

        return redirect()->route('ticket.payment', $order->order_code);
    }

    /**
     * Halaman pembayaran QRIS
     */
    public function payment(string $order)
    {
        $order = Order::where('order_code', $order)
                      ->where('status', 'pending')
                      ->firstOrFail();

        // Path gambar QRIS — taruh file di storage/app/public/qris.png
        // lalu jalankan: php artisan storage:link
        $qrisImage = asset('storage/qris.png');

        return view('tickets.payment', compact('order', 'qrisImage'));
    }

    /**
     * Upload bukti pembayaran
     */
    public function confirm(Request $request, string $order)
    {
        $order = Order::where('order_code', $order)
                      ->where('status', 'pending')
                      ->firstOrFail();

        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'bukti_bayar.required' => 'Bukti pembayaran wajib diupload.',
            'bukti_bayar.image'    => 'File harus berupa gambar.',
            'bukti_bayar.max'      => 'Ukuran file maksimal 2MB.',
        ]);

        $path = $request->file('bukti_bayar')
                        ->store('bukti_bayar', 'public');

        $order->update([
            'bukti_bayar' => $path,
            'status'      => 'paid',
            'paid_at'     => now(),
        ]);

        return redirect()->route('ticket.success', $order->order_code);
    }

    /**
     * Halaman sukses
     */
    public function success(string $order)
    {
        $order = Order::where('order_code', $order)
                      ->whereIn('status', ['paid'])
                      ->firstOrFail();

        return view('tickets.success', compact('order'));
    }
}