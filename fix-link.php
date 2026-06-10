<?php
// Script untuk membuat jembatan folder di cPanel
$target = __DIR__ . '/storage/app/public';
$link = __DIR__ . '/public_storage'; // Kita beri nama sementara

if (symlink($target, $link)) {
    echo "Jembatan Berhasil Dibuat!";
} else {
    echo "Gagal. Pastikan file 'public_storage' belum ada.";
}