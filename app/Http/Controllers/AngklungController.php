<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AngklungController extends Controller
{
    /**
     * Menampilkan halaman jenis-jenis angklung.
     */
    public function index()
    {
        $angklungData = [
            [
                'category' => 'Angklung Tradisional & Ritual',
                'description' => 'Jenis angklung yang digunakan untuk upacara adat, ritual pertanian, dan penghormatan kepada leluhur.',
                'items' => [
                    [
                        'name' => 'Angklung Kanekes',
                        'origin' => 'Baduy (Kanekes), Banten',
                        'history' => 'Digunakan dalam ritual menanam padi (ngaseuk). Hanya boleh dibuat oleh warga Baduy Dalam (Cibeo, Cikartawana, Cikeusik).',
                        'details' => 'Memiliki 8 jenis instrumen berdasarkan ukuran: indung, ringkung, dongdong, gunjing, engklok, indung leutik, torolok, dan roel.',
                        'image' => 'angklung-kanekes.jpg'
                    ],
                    [
                        'name' => 'Angklung Gubrag',
                        'origin' => 'Cipining, Bogor',
                        'history' => 'Digunakan untuk menghormati Dewi Sri (Dewi Padi) dalam kegiatan melak pare (menanam) hingga ngunjal pare (mengangkut).',
                        'details' => 'Muncul saat masa paceklik di Kampung Cipining sebagai upaya meminta berkah kesuburan.',
                        'image' => 'angklung-gubrag.jpg'
                    ],
                    [
                        'name' => 'Angklung Badeng',
                        'origin' => 'Malangbong, Garut',
                        'history' => 'Berfungsi sebagai alat dakwah penyebaran Islam pada abad ke-16/17 oleh penduduk Sanding.',
                        'details' => 'Menggunakan teks bahasa Sunda dan Arab berisi selawat. Disertai atraksi kesaktian (debus).',
                        'image' => 'angklung-badeng.jpg'
                    ],
                    [
                        'name' => 'Angklung Buncis',
                        'origin' => 'Arjasari, Bandung',
                        'history' => 'Dahulu untuk ritual pertanian, namun sejak 1940-an berubah fungsi menjadi seni hiburan rakyat.',
                        'details' => 'Namanya berasal dari lirik lagu "cis kacang buncis nyengcle...". Menggunakan laras Salendro.',
                        'image' => 'angklung-buncis.jpg'
                    ],
                ]
            ],
            [
                'category' => 'Angklung Modern & Inovasi',
                'description' => 'Evolusi angklung dari nada pentatonis tradisional menjadi diatonis internasional.',
                'items' => [
                    [
                        'name' => 'Angklung Padaeng',
                        'origin' => 'Bandung (Nasional)',
                        'history' => 'Diciptakan oleh Daeng Soetigna pada tahun 1938.',
                        'details' => 'Menggunakan tangga nada Diatonis (musik Barat). Inovasi ini membuat angklung bisa dimainkan secara orkestra bersama alat musik modern lainnya.',
                        'image' => 'angklung-padaeng.jpg'
                    ],
                    [
                        'name' => 'Angklung Sarinande',
                        'origin' => 'Bandung',
                        'history' => 'Variasi dari Angklung Padaeng untuk keperluan pendidikan.',
                        'details' => 'Hanya menggunakan nada bulat (tanpa nada setengah/kromatis). Sangat cocok untuk anak-anak atau pemula.',
                        'image' => 'angklung-sarinande.jpg'
                    ],
                    [
                        'name' => 'Angklung Toel',
                        'origin' => 'Saung Angklung Udjo',
                        'history' => 'Diciptakan oleh Kang Yayan Udjo pada tahun 2008.',
                        'details' => 'Angklung dipasang terbalik pada rak khusus dengan pegas karet. Dimainkan cukup dengan disentuh (toel).',
                        'image' => 'angklung-toel.jpg'
                    ],
                    [
                        'name' => 'Angklung Sri-Murni',
                        'origin' => 'Bandung',
                        'history' => 'Gagasan Eko Mursito Budi untuk teknologi masa depan.',
                        'details' => 'Diciptakan khusus untuk kebutuhan robot angklung agar menghasilkan nada murni (monotonal).',
                        'image' => 'angklung-srimurni.jpg'
                    ],
                ]
            ],
            [
                'category' => 'Angklung Nusantara Lainnya',
                'description' => 'Varian angklung dari luar Jawa Barat yang memiliki karakteristik unik.',
                'items' => [
                    [
                        'name' => 'Angklung Reyog',
                        'origin' => 'Ponorogo, Jawa Timur',
                        'history' => 'Pengiring tari Reyog Ponorogo. Dahulu dianggap sebagai senjata Kerajaan Bantarangin.',
                        'details' => 'Bentuk melengkung dengan hiasan rumbai warna-warni. Suaranya sangat nyaring dan kuat (klong-klok).',
                        'image' => 'angklung-reyog.jpg'
                    ],
                    [
                        'name' => 'Angklung Gong Gumbeng',
                        'origin' => 'Sambit, Ponorogo',
                        'history' => 'Telah ada sejak 1837 M dan merupakan jenis angklung bernada tertua.',
                        'details' => 'Digunakan dalam acara puncak "Bersih Desa" setiap Jumat terakhir bulan Sela.',
                        'image' => 'angklung-gong-gumbeng.jpg'
                    ],
                    [
                        'name' => 'Angklung Bali (Rindik)',
                        'origin' => 'Bali',
                        'history' => 'Berasal dari pengaruh Angklung Reyog yang dibawa pejabat Majapahit.',
                        'details' => 'Dimainkan dengan cara dipukul seperti gamelan, bukan digoyang.',
                        'image' => 'angklung-bali.jpg'
                    ],
                    [
                        'name' => 'Angklung Kongkil',
                        'origin' => 'Bungkal, Ponorogo',
                        'history' => 'Lahir tahun 1933 sebagai alat perlawanan terhadap kolonial Belanda.',
                        'details' => 'Digunakan sebagai kedok untuk berkumpul membahas strategi melawan penjajah.',
                        'image' => 'angklung-kongkil.jpg'
                    ],
                ]
            ]
        ];

        return view('heritage.jenis-angklung', compact('angklungData'));
    }
}