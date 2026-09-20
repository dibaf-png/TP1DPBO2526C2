<?php
// Memanggil/memuat file Bioskop.php yang berisi definisi Class Bioskop
require_once 'Bioskop.php';

// Memulai atau melanjutkan session untuk menyimpan data sementara selama user membuka aplikasi
session_start();

// Cek apakah tombol "Hapus Semua Data" (reset_data) ditekan melalui metode POST
if (isset($_POST['reset_data'])) {
    // Menghapus semua variabel yang terdaftar pada session
    session_unset();
    // Menghentikan dan menghancurkan seluruh data session
    session_destroy();
    // Mengarahkan kembali halaman browser ke Main.php (refresh halaman)
    header("Location: Main.php");
    // Mematikan eksekusi script selanjutnya
    exit();
}

// Cek apakah array 'daftarBioskop' sudah ada di session, jika belum buat array kosong
if (!isset($_SESSION['daftarBioskop'])) {
    $_SESSION['daftarBioskop'] = [];
}

// Mengambil pesan notifikasi dari session jika ada, jika tidak ada diisi string kosong
$message = $_SESSION['message'] ?? '';

// Mengambil tipe pesan (success/error/warning) dari session jika ada, jika tidak ada diisi string kosong
$message_type = $_SESSION['message_type'] ?? '';

// Menghapus pesan dan tipe pesan dari session agar notifikasi tidak muncul lagi saat halaman direfresh
unset($_SESSION['message'], $_SESSION['message_type']);

// Fungsi bantuan untuk mengecek apakah ID Bioskop sudah terdaftar di dalam list
function isIdExists($id, $list) {
    // Melakukan perulangan untuk mengecek setiap objek bioskop dalam list
    foreach ($list as $item) {
        // Jika ID objek bioskop sama dengan ID yang dicari
        if ($item->getId() === $id) {
            // Mengembalikan nilai true (ID ditemukan / sudah ada)
            return true;
        }
    }
    // Jika tidak ditemukan ID yang sama, mengembalikan false
    return false;
}

// 1. PROSES TAMBAH BIOSKOP
// Cek apakah form tambah bioskop dikirimkan (tombol 'tambah' ditekan)
if (isset($_POST['tambah'])) {
    // Mengambil dan membersihkan spasi di awal/akhir input ID Bioskop
    $id_bioskop    = trim($_POST['id_bioskop']);
    // Mengambil dan membersihkan spasi di awal/akhir input Nama Bioskop
    $nama_bioskop  = trim($_POST['nama_bioskop']);
    // Mengambil dan membersihkan spasi di awal/akhir input Alamat
    $alamat        = trim($_POST['alamat']);
    // Mengambil dan membersihkan spasi di awal/akhir input Snack
    $snack_jual    = trim($_POST['snack_jual']);
    // Mengambil input Jumlah Studio dari form
    $jumlah_studio = $_POST['jumlah_studio'];

    // Validasi: Cek apakah ada field teks yang kosong atau jumlah studio bukan angka / bernilai negatif
    if (empty($id_bioskop) || empty($nama_bioskop) || empty($alamat) || empty($snack_jual) || !is_numeric($jumlah_studio) || $jumlah_studio < 0) {
        // Mengatur pesan error jika inputan tidak valid
        $message = "Input tidak valid. Pastikan semua field terisi dan jumlah studio bernilai positif.";
        // Mengatur tipe pesan menjadi 'error'
        $message_type = 'error';
    // Cek apakah ID bioskop sudah terdaftar sebelumnya
    } elseif (isIdExists($id_bioskop, $_SESSION['daftarBioskop'])) {
        // Mengatur pesan error jika ID duplikat
        $message = "ID Bioskop sudah terdaftar. Gagal menambahkan data.";
        // Mengatur tipe pesan menjadi 'error'
        $message_type = 'error';
    } else {
        // Inisialisasi variabel path gambar dengan string kosong
        $gambar_path = '';
        
        // Cek apakah ada file gambar yang diunggah dan tidak ada error saat upload
        if (!empty($_FILES['gambar']['name']) && $_FILES['gambar']['error'] == 0) {
            // Menentukan direktori tujuan penyimpanan gambar
            $target_dir  = "./images/";

            // OTOMATISASI: Cek apakah folder 'images' sudah ada, jika belum buat foldernya secara otomatis
            if (!file_exists($target_dir)) {
                // Membuat folder 'images' dengan akses permission 0777
                mkdir($target_dir, 0777, true);
            }

            // Membuat nama file unik gabungan dari timestamp dan nama asli file
            $target_file = $target_dir . time() . "_" . basename($_FILES['gambar']['name']);
            
            // Memindahkan file gambar dari direktori sementara ke folder tujuan
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
                // Menyimpan path file jika berhasil diunggah
                $gambar_path = $target_file;
            }
        }

        // Membuat objek baru dari Class Bioskop dengan data dari form
        $bioskop_baru = new Bioskop($id_bioskop, $nama_bioskop, $alamat, $snack_jual, (int)$jumlah_studio, $gambar_path);
        
        // Menambahkan objek bioskop baru ke dalam array session 'daftarBioskop'
        $_SESSION['daftarBioskop'][] = $bioskop_baru;

        // Menyimpan pesan sukses ke dalam session
        $_SESSION['message'] = "Yeyy data Bioskop berhasil ditambahkan!";
        // Menyimpan tipe pesan 'success' ke dalam session
        $_SESSION['message_type'] = 'success';
        
        // Redirect kembali ke Main.php untuk mencegah submit ulang form saat refresh
        header("Location: Main.php");
        // Mematikan eksekusi script
        exit();
    }
}

// 2. PROSES HAPUS BIOSKOP
// Cek apakah ada request GET action 'hapus' dan parameter 'id' pada URL
if (isset($_GET['action']) && $_GET['action'] === 'hapus' && isset($_GET['id'])) {
    // Mengambil ID bioskop yang ingin dihapus dari URL
    $id_hapus = $_GET['id'];
    
    // Menyaring array session dan membuang bioskop yang ID-nya cocok dengan $id_hapus
    $_SESSION['daftarBioskop'] = array_values(array_filter($_SESSION['daftarBioskop'], fn($b) => $b->getId() !== $id_hapus));

    // Menyimpan pesan sukses hapus ke session
    $_SESSION['message'] = "Yeyy data Bioskop berhasil dihapus!";
    // Menyimpan tipe pesan 'success' ke session
    $_SESSION['message_type'] = 'success';
    
    // Redirect kembali ke halaman utama
    header("Location: Main.php");
    // Mematikan eksekusi script
    exit();
}

// 3. PROSES UPDATE BIOSKOP
// Fungsi untuk memproses pembaruan data bioskop berdasarkan ID
function updateBioskop($id_update) {
    // Melakukan perulangan pada setiap elemen objek bioskop dalam session
    foreach ($_SESSION['daftarBioskop'] as $b) {
        // Mengidentifikasi objek bioskop yang ID-nya cocok dengan ID yang ingin diubah
        if ($b->getId() === $id_update) {
            // Mengambil input ID baru dari form dan membersihkan spasi
            $id_baru       = trim($_POST['id_baru']);
            // Mengambil input nama baru dari form dan membersihkan spasi
            $nama_baru     = trim($_POST['nama_bioskop']);
            // Mengambil input alamat baru dari form dan membersihkan spasi
            $alamat_baru   = trim($_POST['alamat']);
            // Mengambil input snack baru dari form dan membersihkan spasi
            $snack_baru    = trim($_POST['snack_jual']);
            // Mengambil input jumlah studio baru dari form
            $studio_baru   = $_POST['jumlah_studio'];

            // Validasi: Cek kelengkapan input dan validitas angka studio
            if (empty($nama_baru) || empty($alamat_baru) || empty($snack_baru) || !is_numeric($studio_baru) || $studio_baru < 0) {
                // Mengembalikan pesan error jika data tidak valid
                return ["Input tidak valid. Pastikan semua teks terisi dan studio bernilai positif.", 'error'];
            }

            // Jika ID diubah dan ID baru tersebut berbeda dari ID lama
            if (!empty($id_baru) && $id_baru !== $b->getId()) {
                // Cek apakah ID baru tersebut sudah dipakai oleh bioskop lain
                if (isIdExists($id_baru, $_SESSION['daftarBioskop'])) {
                    // Mengembalikan pesan peringatan jika ID sudah digunakan
                    return ["ID baru sudah digunakan, coba ganti ID lain yaa.", 'warning'];
                } else {
                    // Mengubah ID bioskop dengan ID baru
                    $b->setId($id_baru);
                }
            }

            // Mengubah nama bioskop pada objek
            $b->setNama($nama_baru);
            // Mengubah alamat bioskop pada objek
            $b->setAlamat($alamat_baru);
            // Mengubah snack bioskop pada objek
            $b->setSnack($snack_baru);
            // Mengubah jumlah studio bioskop pada objek (dikonversi ke tipe integer)
            $b->setStudio((int)$studio_baru);

            // Cek apakah ada file gambar baru yang diunggah saat update
            if (!empty($_FILES['gambar']['name']) && $_FILES['gambar']['error'] == 0) {
                // Menentukan direktori penyimpanan gambar
                $target_dir  = "./images/";

                // OTOMATISASI: Cek apakah folder 'images' sudah ada, jika belum buat foldernya secara otomatis
                if (!file_exists($target_dir)) {
                    // Membuat folder 'images' dengan akses permission 0777
                    mkdir($target_dir, 0777, true);
                }

                // Menentukan nama file unik baru
                $target_file = $target_dir . time() . "_" . basename($_FILES['gambar']['name']);
                
                // Memindahkan file gambar baru dari direktori sementara
                if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
                    // Mengubah atribut path gambar pada objek bioskop
                    $b->setGambar($target_file);
                }
            }

            // Mengembalikan pesan sukses jika proses update berhasil
            return ["Yeyy data bioskop berhasil diupdate!", 'success'];
        }
    }
    // Mengembalikan pesan error jika ID tidak ada di daftar
    return ["Data tidak ditemukan.", 'error'];
}

// Cek apakah form update dikirimkan (tombol 'update' ditekan)
if (isset($_POST['update'])) {
    // Memanggil fungsi updateBioskop dan menerima balasan pesan serta tipenya menggunakan array destructuring
    [$msg, $type] = updateBioskop($_POST['id_bioskop']);
    
    // Menyimpan pesan hasil update ke session
    $_SESSION['message'] = $msg;
    // Menyimpan tipe pesan hasil update ke session
    $_SESSION['message_type'] = $type;
    
    // Redirect kembali ke Main.php
    header("Location: Main.php");
    // Mematikan eksekusi script
    exit();
}

// 4. PROSES CARI BIOSKOP
// Inisialisasi awal variabel hasil pencarian dengan seluruh data dari session
$hasil_cari = $_SESSION['daftarBioskop'];

// Cek apakah tombol pencarian ditekan (parameter GET 'cari' ada)
if (isset($_GET['cari'])) {
    // Mengambil kata kunci pencarian dari URL dan membersihkan spasi
    $id_cari = trim($_GET['cari_id']);
    
    // Jika kata kunci pencarian tidak kosong
    if (!empty($id_cari)) {
        // Menyaring data bioskop berdasarkan kemiripan ID atau Nama (case-insensitive)
        $hasil_cari = array_values(array_filter($_SESSION['daftarBioskop'], function($b) use ($id_cari) {
            // Mencari kata kunci pada ID atau Nama Bioskop
            return (stripos($b->getId(), $id_cari) !== false) || (stripos($b->getNama(), $id_cari) !== false);
        }));

        // Jika data pencarian tidak ada yang cocok
        if (empty($hasil_cari)) {
            // Menampilkan pesan warning data tidak ditemukan
            $message = "Bioskop dengan keyword '$id_cari' tidak ditemukan.";
            // Mengatur tipe pesan warning
            $message_type = 'warning';
        }
    }
}

// Helper: Fungsi untuk mengambil objek bioskop berdasarkan ID
function getBioskopById($id) {
    // Melakukan perulangan pada seluruh data bioskop
    foreach ($_SESSION['daftarBioskop'] as $b) {
        // Jika ID cocok, kembalikan objek bioskop tersebut
        if ($b->getId() === $id) return $b;
    }
    // Jika tidak ditemukan, kembalikan null
    return null;
}

// Inisialisasi variabel untuk menampung data form edit dengan nilai awal kosong
$edit_id = $edit_nama = $edit_alamat = $edit_snack = $edit_studio = $edit_gambar = '';

// Cek apakah ada request mode edit dari tombol 'Edit' di tabel (GET parameter 'edit_id')
if (isset($_GET['edit_id'])) {
    // Cari objek bioskop berdasarkan ID yang dikirim
    $b = getBioskopById($_GET['edit_id']);
    
    // Jika objek bioskop ditemukan
    if ($b !== null) {
        // Isi variabel form edit dengan data dari objek bioskop
        $edit_id     = $b->getId();
        $edit_nama   = $b->getNama();
        $edit_alamat = $b->getAlamat();
        $edit_snack  = $b->getSnack();
        $edit_studio = $b->getStudio();
        $edit_gambar = $b->getGambar();
    }
}
?>

<!DOCTYPE html>
<!-- Menyatakan tipe dokumen sebagai HTML5 -->
<html lang="id">
<head>
    <!-- Pengaturan karakter encoding menjadi UTF-8 -->
    <meta charset="UTF-8">
    <!-- Judul dari halaman web -->
    <title>Sistem Manajemen Bioskop</title>
    <!-- Memanggil Google Fonts Montserrat dan Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Blok Styling CSS Internal -->
    <style>
        /* CSS untuk styling elemen body / tampilan latar belakang */
        body {
            font-family: 'Poppins', 'Montserrat', Arial, sans-serif; /* Mengatur jenis font */
            margin: 0; /* Menghilangkan margin bawaan browser */
            padding: 30px 20px; /* Memberikan jarak dalam pada body */
            min-height: 100vh; /* Memastikan tinggi body minimal seukuran layar laptop */
            background: linear-gradient(135deg, #00a86b 0%, #004b23 100%); /* Latar gradasi hijau */
            display: flex; /* Menggunakan layout flexbox */
            justify-content: center; /* Posisikan elemen tengah secara horizontal */
            align-items: flex-start; /* Posisikan elemen di paling atas */
            color: #2d3748; /* Warna teks utama */
        }

        /* CSS untuk kontainer/kotak utama pembungkus aplikasi */
        .container {
            width: 100%; /* Lebar penuh */
            max-width: 1200px; /* Batas lebar maksimal 1200px */
            background: rgba(255, 255, 255, 0.97); /* Warna latar putih agak transparan */
            padding: 35px; /* Jarak dalam kontainer */
            border-radius: 20px; /* Membuat sudut kotak melengkung */
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2); /* Efek bayangan kotak */
        }

        /* CSS untuk judul H1 dan H2 */
        h1, h2 {
            font-family: 'Montserrat', sans-serif; /* Jenis font judul */
            text-align: center; /* Teks rata tengah */
            color: #004b23; /* Warna hijau tua */
            font-weight: 700; /* Ketebalan font */
            margin-bottom: 25px; /* Jarak bawah */
        }

        /* Styling spesifik untuk H1 */
        h1 { font-size: 2.4rem; margin-top: 0; }
        
        /* Styling spesifik untuk H2 */
        h2 { font-size: 1.4rem; border-bottom: 3px solid #00a86b; padding-bottom: 8px; text-align: left; }

        /* CSS dasar untuk kotak notifikasi pesan */
        .message {
            padding: 14px; /* Jarak dalam kotak pesan */
            margin-bottom: 22px; /* Jarak luar bawah */
            border-radius: 8px; /* Sudut melengkung */
            font-weight: 500; /* Ketebalan font sedang */
            text-align: center; /* Teks rata tengah */
        }
        /* CSS variasi warna kotak notifikasi */
        .success { background: #e6f7ed; color: #1b4332; border: 1px solid #b7e4c7; } /* Warna hijau sukses */
        .error { background: #ffebee; color: #c53030; border: 1px solid #feb2b2; } /* Warna merah gagal */
        .warning { background: #fffaf0; color: #dd6b20; border: 1px solid #fbd38d; } /* Warna oranye peringatan */

        /* CSS grid layout untuk membagi layar menjadi 2 kolom */
        .layout-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Membagi 2 kolom sama lebar */
            gap: 30px; /* Jarak antarkolom */
            margin-bottom: 35px; /* Jarak bawah */
        }

        /* CSS Responsif untuk layar HP/Tablet kecil */
        @media (max-width: 850px) {
            .layout-grid { grid-template-columns: 1fr; } /* Ubah menjadi 1 kolom vertikal */
        }

        /* CSS panel kartu tempat form */
        .card-panel {
            background: #ffffff; /* Latar putih */
            padding: 25px; /* Jarak dalam */
            border-radius: 12px; /* Lengkungan sudut */
            border: 1px solid #e2e8f0; /* Garis tepi tipis */
        }

        /* CSS grup input form */
        .form-group {
            margin-bottom: 18px; /* Jarak bawah antar input form */
        }

        /* CSS label input form */
        .form-group label {
            display: block; /* Agar label tampil di atas kolom input */
            margin-bottom: 6px; /* Jarak bawah label */
            font-weight: 600; /* Font agak tebal */
            color: #1a202c; /* Warna teks label */
            font-size: 0.95rem; /* Ukuran font label */
        }

        /* CSS komponen input teks, angka, dan file */
        .form-control {
            width: 100%; /* Lebar input 100% mengisi kolom */
            padding: 12px; /* Jarak dalam input */
            border: 1.5px solid #cbd5e0; /* Garis tepi input */
            border-radius: 8px; /* Sudut melengkung */
            box-sizing: border-box; /* Memastikan padding tidak melebihi lebar */
            font-family: 'Poppins', sans-serif; /* Jenis font input */
            font-size: 0.95rem; /* Ukuran font */
        }

        /* CSS efek fokus ketika kolom input diklik */
        .form-control:focus {
            outline: none; /* Menghilangkan border outline bawaan browser */
            border-color: #00a86b; /* Ubah warna border jadi hijau */
            box-shadow: 0 0 0 3px rgba(0, 168, 107, 0.15); /* Efek bercahaya halus di luar border */
        }

        /* CSS umum untuk elemen tombol */
        .btn {
            padding: 12px 20px; /* Jarak dalam tombol */
            border: none; /* Tanpa garis tepi bawaan */
            border-radius: 8px; /* Sudut tombol melengkung */
            cursor: pointer; /* Mengubah kursor jadi bentuk tangan saat diarahkan */
            font-weight: 600; /* Font tombol tebal */
            font-family: 'Montserrat', sans-serif; /* Font tombol */
            color: white; /* Teks warna putih */
            text-decoration: none; /* Menghilangkan garis bawah tautan */
            display: inline-block; /* Tampil sebagai elemen inline-block */
            text-align: center; /* Teks tombol rata tengah */
        }

        /* CSS variasi warna tombol */
        .btn-success { background-color: #00a86b; width: 100%; } /* Warna tombol hijau sukses */
        .btn-success:hover { background-color: #008f5a; } /* Efek warna saat kursor menempel di tombol */
        .btn-primary { background-color: #004b23; } /* Warna tombol hijau tua */
        .btn-danger { background-color: #e53e3e; } /* Warna tombol merah */
        .btn-warning { background-color: #d69e2e; } /* Warna tombol kuning/oranye */

        /* CSS pembungkus bagian pencarian */
        .search-container {
            display: flex; /* Menggunakan flexbox horizontal */
            gap: 10px; /* Jarak antara input cari dan tombol */
            margin-bottom: 15px; /* Jarak bawah */
        }

        /* CSS barisan atas (Pencarian dan Tombol Reset) */
        .top-bar {
            display: flex; /* Menggunakan flexbox */
            justify-content: space-between; /* Posisikan elemen paling kiri dan paling kanan */
            align-items: center; /* Posisikan rata secara vertikal */
            margin-bottom: 25px; /* Jarak bawah */
            flex-wrap: wrap; /* Tampilan dapat turun ke bawah jika layar sempit */
            gap: 15px; /* Jarak antar elemen */
        }

        /* CSS pembungkus tabel agar responsif dapat discroll ke samping jika overflow */
        .table-responsive {
            overflow-x: auto; /* Aktifkan scrollbar horizontal jika lebar tabel melebihi layar */
            border-radius: 12px; /* Sudut melengkung */
            border: 1px solid #e2e8f0; /* Garis tepi tipis */
        }

        /* CSS untuk elemen tabel data */
        table {
            width: 100%; /* Lebar tabel memenuhi pembungkus */
            border-collapse: collapse; /* Menghilangkan celah antar garis sel tabel */
            background: #ffffff; /* Warna background putih */
            font-size: 0.95rem; /* Ukuran font tabel */
        }

        /* CSS untuk header tabel (th) */
        th {
            background-color: #004b23; /* Background hijau tua */
            color: white; /* Warna teks putih */
            padding: 14px 16px; /* Jarak dalam sel header */
            text-align: left; /* Teks rata kiri */
            font-weight: 600; /* Font header tebal */
        }

        /* CSS untuk data tabel (td) */
        td {
            padding: 14px 16px; /* Jarak dalam sel data */
            border-bottom: 1px solid #edf2f7; /* Garis pemisah antar baris */
            vertical-align: middle; /* Teks rata tengah secara vertikal */
        }

        /* CSS efek hover pada baris tabel */
        tr:hover { background-color: #f7fafc; } /* Mengubah warna background saat baris disorot kursor */

        /* CSS styling untuk thumbnail gambar foto bioskop di tabel */
        .img-thumb {
            width: 60px; /* Lebar thumbnail foto 60px */
            height: 60px; /* Tinggi thumbnail foto 60px */
            object-fit: cover; /* Menjaga proporsi gambar tanpa distorsi */
            border-radius: 6px; /* Lengkungan sudut gambar */
            border: 1px solid #cbd5e0; /* Garis tepi gambar */
        }
    </style>
</head>
<body>

<!-- Pembungkus Utama Seluruh Konten Aplikasi -->
<div class="container">
    <!-- Judul Utama Aplikasi -->
    <h1>🎬 Sistem Manajemen Bioskop</h1>

    <!-- Blok PHP: Tampilkan pesan notifikasi jika variabel $message tidak kosong -->
    <?php if ($message): ?>
        <!-- Menampilkan pesan notifikasi dengan kelas CSS yang sesuai tipe ($message_type) -->
        <div class="message <?= $message_type; ?>"><?= $message; ?></div>
    <?php endif; ?>

    <!-- Baris Bagian Atas: Form Pencarian dan Tombol Hapus Semua Data -->
    <div class="top-bar">
        <!-- Form Cari Data (menggunakan method GET agar keyword tampil di URL) -->
        <form action="Main.php" method="GET" class="search-container" style="margin:0;">
            <!-- Input Teks untuk Memasukkan Keyword ID / Nama Bioskop -->
            <input type="text" name="cari_id" class="form-control" placeholder="Cari ID / Nama Bioskop..." value="<?= $_GET['cari_id'] ?? ''; ?>">
            <!-- Tombol submit untuk memproses pencarian -->
            <button type="submit" name="cari" class="btn btn-primary">Cari</button>
            <!-- Tampilkan tombol "Reset Cari" jika user sedang dalam kondisi mencari data -->
            <?php if (isset($_GET['cari'])): ?>
                <!-- Tombol tautan untuk membatalkan filter pencarian dan mengembalikan ke Main.php -->
                <a href="Main.php" class="btn btn-warning">Reset Cari</a>
            <?php endif; ?>
        </form>

        <!-- Form Reset Session untuk Menghapus Seluruh Data Bioskop -->
        <form action="Main.php" method="POST" style="margin:0;" onsubmit="return confirm('Apakah kamu yakin ingin mereset seluruh data?');">
            <!-- Tombol submit hapus seluruh data dengan konfirmasi Javascript -->
            <button type="submit" name="reset_data" class="btn btn-danger">Hapus Semua Data</button>
        </form>
    </div>

    <!-- Layout Grid 2 Kolom (Kiri: Form Input, Kanan: Tabel Data) -->
    <div class="layout-grid">
        <!-- Panel Kolom Kiri: Form Tambah / Edit Data Bioskop -->
        <div class="card-panel">
            <!-- Judul Form: Tampilkan "Edit Bioskop" jika $edit_id terisi, jika kosong tampilkan "Tambah Bioskop" -->
            <h2><?= $edit_id ? 'Edit Bioskop' : 'Tambah Bioskop'; ?></h2>
            
            <!-- Form Input Data Bioskop (Gunakan enctype multipart/form-data agar bisa upload gambar) -->
            <form action="Main.php" method="POST" enctype="multipart/form-data">
                
                <!-- Jika sedang mode Edit, simpan ID lama di hidden input -->
                <?php if ($edit_id): ?>
                    <input type="hidden" name="id_bioskop" value="<?= htmlspecialchars($edit_id); ?>">
                <?php endif; ?>

                <!-- Grup Input: ID Bioskop -->
                <div class="form-group">
                    <label>ID Bioskop:</label>
                    <!-- Jika mode edit, gunakan name="id_baru", jika tambah gunakan name="id_bioskop" -->
                    <input type="text" name="<?= $edit_id ? 'id_baru' : 'id_bioskop'; ?>" class="form-control" value="<?= htmlspecialchars($edit_id); ?>" placeholder="Contoh: B01" required>
                </div>

                <!-- Grup Input: Nama Bioskop -->
                <div class="form-group">
                    <label>Nama Bioskop:</label>
                    <input type="text" name="nama_bioskop" class="form-control" value="<?= htmlspecialchars($edit_nama); ?>" placeholder="Contoh: Cinema XXI" required>
                </div>

                <!-- Grup Input: Alamat -->
                <div class="form-group">
                    <label>Alamat:</label>
                    <input type="text" name="alamat" class="form-control" value="<?= htmlspecialchars($edit_alamat); ?>" placeholder="Contoh: Jl. Terbaik No. 187" required>
                </div>

                <!-- Grup Input: Snack -->
                <div class="form-group">
                    <label>Snack yang Dijual:</label>
                    <input type="text" name="snack_jual" class="form-control" value="<?= htmlspecialchars($edit_snack); ?>" placeholder="Contoh: Popcorn" required>
                </div>

                <!-- Grup Input: Upload Gambar -->
                <div class="form-group">
                    <label>Upload Gambar Snack:</label>
                    <!-- Input bertipe file untuk mengunggah gambar -->
                    <input type="file" name="gambar" class="form-control">
                    <!-- Jika sedang edit dan bioskop tersebut sudah punya gambar, tampilkan keterangan path gambar saat ini -->
                    <?php if ($edit_gambar): ?>
                        <small style="color: #718096; display: block; margin-top: 5px;">Gambar terisi: <?= htmlspecialchars($edit_gambar); ?></small>
                    <?php endif; ?>
                </div>

                <!-- Grup Input: Jumlah Studio -->
                <div class="form-group">
                    <label>Jumlah Studio:</label>
                    <input type="number" name="jumlah_studio" class="form-control" value="<?= htmlspecialchars($edit_studio); ?>" placeholder="4" min="0" required>
                </div>

                <!-- Tombol Submit Form (name="update" jika edit, name="tambah" jika tambah baru) -->
                <button type="submit" name="<?= $edit_id ? 'update' : 'tambah'; ?>" class="btn btn-success">
                    <!-- Mengubah teks tombol sesuai mode form -->
                    <?= $edit_id ? 'Simpan Perubahan' : 'Tambah Bioskop'; ?>
                </button>

                <!-- Tampilkan Tombol "Batal Edit" jika sedang dalam mode Edit -->
                <?php if ($edit_id): ?>
                    <a href="Main.php" style="display:block; text-align:center; color:#718096; margin-top:12px; text-decoration:none; font-size:0.9rem;">Batal Edit</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Panel Kolom Kanan: Tabel Menampilkan Daftar Bioskop -->
        <div>
            <h2>Daftar Bioskop</h2>
            <!-- Pembungkus Tabel Responsif -->
            <div class="table-responsive">
                <table>
                    <!-- Header Tabel -->
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>ID</th>
                            <th>Info Bioskop</th>
                            <th>Snack</th>
                            <th>Studio</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <!-- Isi Tabel -->
                    <tbody>
                        <!-- Cek apakah data bioskop (atau hasil pencarian) kosong -->
                        <?php if (empty($hasil_cari)): ?>
                            <tr>
                                <!-- Menampilkan pesan jika tidak ada data bioskop -->
                                <td colspan="6" style="text-align: center; color: #a0aec0; padding: 25px;">
                                    Belum ada data bioskop.
                                </td>
                            </tr>
                        <?php else: ?>
                            <!-- Melakukan perulangan untuk setiap objek bioskop di array $hasil_cari -->
                            <?php foreach ($hasil_cari as $bioskop): ?>
                                <tr>
                                    <!-- Sel 1: Menampilkan Foto -->
                                    <td>
                                        <!-- Cek apakah objek bioskop memiliki path gambar -->
                                        <?php if ($bioskop->getGambar()): ?>
                                            <!-- Tampilkan gambar bioskop -->
                                            <img src="<?= htmlspecialchars($bioskop->getGambar()); ?>" class="img-thumb" alt="Foto Bioskop">
                                        <?php else: ?>
                                            <!-- Tampilkan teks 'Tanpa Foto' jika gambar kosong -->
                                            <span style="color:#a0aec0; font-size:0.8rem;">Tanpa Foto</span>
                                        <?php endif; ?>
                                    </td>
                                    <!-- Sel 2: Menampilkan ID Bioskop -->
                                    <td><strong><?= htmlspecialchars($bioskop->getId()); ?></strong></td>
                                    <!-- Sel 3: Menampilkan Nama dan Alamat Bioskop -->
                                    <td>
                                        <strong><?= htmlspecialchars($bioskop->getNama()); ?></strong><br>
                                        <small style="color: #718096;"><?= htmlspecialchars($bioskop->getAlamat()); ?></small>
                                    </td>
                                    <!-- Sel 4: Menampilkan Snack -->
                                    <td><?= htmlspecialchars($bioskop->getSnack()); ?></td>
                                    <!-- Sel 5: Menampilkan Jumlah Studio -->
                                    <td><?= htmlspecialchars($bioskop->getStudio()); ?> Studio</td>
                                    <!-- Sel 6: Menampilkan Tombol Aksi (Edit & Hapus) -->
                                    <td>
                                        <div style="display: flex; gap: 6px;">
                                            <!-- Tombol untuk menuju ke mode edit berdasarkan ID Bioskop -->
                                            <a href="Main.php?edit_id=<?= urlencode($bioskop->getId()); ?>" class="btn btn-warning" style="padding: 6px 12px; font-size: 0.8rem;">Edit</a>
                                            <!-- Tombol untuk menghapus data bioskop dengan konfirmasi Javascript -->
                                            <a href="Main.php?action=hapus&id=<?= urlencode($bioskop->getId()); ?>" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.8rem;" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>