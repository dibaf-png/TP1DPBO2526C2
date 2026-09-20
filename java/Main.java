import java.util.ArrayList; // Mengimpor kelas ArrayList dari pustaka util untuk membuat array dinamis
import java.util.Scanner;   // Mengimpor kelas Scanner dari pustaka util untuk membaca input dari pengguna melalui konsol

public class Main { // Deklarasi kelas utama dengan nama Main
    static ArrayList<Bioskop> dataBioskop = new ArrayList<>(); // Deklarasi dan inisialisasi kontainer ArrayList statis bertipe 'Bioskop'
    static Scanner scanner = new Scanner(System.in); // Deklarasi dan inisialisasi objek Scanner statis untuk menangkap input System.in

    // Method untuk mengecek keberadaan ID Bioskop di dalam ArrayList
    public static boolean cekId(String idBioskop) {
        // Melakukan looping read-only pada daftar dataBioskop menggunakan for-each
        for (Bioskop bioskop : dataBioskop) {
            if (bioskop.getId().equals(idBioskop)) { // Membandingkan ID bioskop saat ini dengan parameter idBioskop
                return true; // Mengembalikan nilai true jika ID ditemukan
            }
        }
        return false;// Mengembalikan nilai false jika ID tidak terdaftar
    }

    // Method untuk menginput dan menambahkan data bioskop baru
    public static void tambahinData() {
        String id;     //untuk menyimpan input ID bioskop
        String nama;   //untuk menyimpan input nama bioskop
        String alamat; //untuk menyimpan input alamat bioskop
        String snack;  //untuk menyimpan input snack bioskop
        int studio;    //untuk menyimpan input jumlah studio

        System.out.println("\n <<<<<<<<<< Tambah Data >>>>>>>>>>"); // Menampilkan header menu tambah data
        System.out.print("Masukan Id Bioskop : ");// Meminta input ID dari pengguna
        id = scanner.nextLine();// Membaca satu baris input string ID

        // Validasi penanganan ID unik (cegah ganda)
        while (cekId(id)) { // Melakukan perulangan jika ID yang dimasukkan sudah ada di ArrayList
            System.out.println("Alahh Id Bioskop Sudah Digunakan. Coba Ganti Id Yaa"); // Pesan peringatan ID ganda
            System.out.print("Masukkan Id Bioskop : ");// Meminta masukan ID ulang
            id = scanner.nextLine();// Membaca masukan ID yang baru
        }

        System.out.print("Masukkan Nama Bioskop : "); // Meminta input nama bioskop
        nama = scanner.nextLine(); // Membaca input baris nama bioskop
        // Validasi input nama tidak boleh kosong
        while (nama.isEmpty()) { // Berjalan selama string nama bernilai kosong
            System.out.println("Alahh Nama Bioskop Tidak Boleh Kosong"); // Pesan peringatan nama kosong
            System.out.print("Masukkan Nama Bioskop Kembali: "); // Meminta input nama ulang
            nama = scanner.nextLine(); // Membaca ulang masukan nama
        }

        System.out.print("Masukkan Alamat : "); // Meminta input alamat bioskop
        alamat = scanner.nextLine(); // Membaca input baris alamat
        // Validasi input alamat tidak boleh kosong
        while (alamat.isEmpty()) { // Berjalan selama string alamat bernilai kosong
            System.out.println("Alahh alamat Bioskop Tidak Boleh Kosong"); // Pesan peringatan alamat kosong
            System.out.print("Masukkan Alamat Kembali : "); // Meminta input alamat ulang
            alamat = scanner.nextLine(); // Membaca ulang masukan alamat
        }

        System.out.print("Masukkan Snack yang Dijual : "); // Meminta input jenis snack
        snack = scanner.nextLine(); // Membaca input baris snack
        // Validasi input snack tidak boleh kosong
        while (snack.isEmpty()) { // Berjalan selama string snack bernilai kosong
            System.out.println("Alahh snack Bioskop Tidak Boleh Kosong"); // Pesan peringatan snack kosong
            System.out.print("Masukkan Snack yang Dijual Kembali : ");    // Meminta input snack ulang
            snack = scanner.nextLine(); // Membaca ulang masukan snack
        }

        System.out.print("Masukkan Jumlah Studio : "); // Meminta input jumlah studio
        // Validasi anti-crash jika pengguna menginput karakter selain angka
        while (!scanner.hasNextInt()) { // Berjalan jika input Scanner berikutnya bukan bertipe integer
            System.out.println("Etss Input Harus Berupa Angka Yaa"); // Pesan error tipe data
            System.out.print("Masukkan Jumlah Studio Kembali : ");   // Meminta input ulang
            scanner.next(); // Membuang token input bukan-angka dari buffer
        }
        studio = scanner.nextInt(); // Membaca nilai integer studio dari Scanner
        scanner.nextLine(); // Membersihkan sisa karakter newline/enter dari buffer input

        // Validasi jumlah studio tidak boleh bernilai kurang dari atau sama dengan nol
        while (studio <= 0) { // Berjalan jika nilai integer studio bernilai <= 0
            System.out.println("Etss Input Jumlah Studio Tidak Boleh 0 atau Minus Yaa"); // Pesan error angka minus/nol
            System.out.print("Masukkan Jumlah Studio Kembali : ");                       // Meminta input ulang
            while (!scanner.hasNextInt()) { // Validasi ulang tipe data jika pengguna menginput huruf lagi
                System.out.println("Etss Input Harus Berupa Angka Yaa"); // Pesan error tipe data
                System.out.print("Masukkan Jumlah Studio Kembali : ");   // Meminta input ulang
                scanner.next(); // Membuang token input bukan-angka dari buffer
            }
            studio = scanner.nextInt(); // Membaca ulang masukan angka studio
            scanner.nextLine();// Membersihkan sisa karakter newline/enter dari buffer
        }

        // Instansiasi objek baru dari kelas Bioskop dan menambahkannya ke ArrayList
        Bioskop baru = new Bioskop(id, nama, alamat, snack, studio); // Membuat objek baru dengan konstruktor
        dataBioskop.add(baru); // Menambahkan objek baru ke dalam ArrayList

        System.out.println("Yeyy Data Berhasil Ditambahkan Nih :)"); // Menampilkan pesan sukses
    }

    // Method untuk memperbarui data bioskop yang sudah ada
    public static void updateData() {
        String idUbah;//untuk menyimpan ID sasaran yang ingin diubah
        String idBaru;//untuk nilai ID baru
        String namaBaru;   //untuk nilai nama baru
        String alamatBaru; //untuk nilai alamat baru
        String snackBaru;  //untuk nilai snack baru
        int studioBaru;//untuk nilai studio baru

        System.out.println("\n <<<<<<<<<< UPDATE DATA >>>>>>>>>>"); // Menampilkan header menu update
        System.out.print("Masukkan Id yang Akan di Update Bioskop : "); // Meminta ID sasaran
        idUbah = scanner.nextLine();// Membaca ID sasaran dari input

        for (Bioskop bioskop : dataBioskop) { // Melakukan iterasi membaca setiap objek di dalam ArrayList
            if (bioskop.getId().equals(idUbah)) { // Mengecek jika ID objek saat ini cocok dengan ID sasaran

                System.out.print("Id Baru [" + bioskop.getId() + "]: "); // Menampilkan ID saat ini
                idBaru = scanner.nextLine();// Membaca masukan ID baru
                if (!idBaru.isEmpty()) {    // Jika masukan ID baru tidak kosong
                    if (!idBaru.equals(bioskop.getId()) && cekId(idBaru)) { // Cek jika ID berubah dan ID baru ternyata sudah dipakai
                        System.out.println("Id Gagal Diubah, Id Sudah Digunakan"); // Pesan kegagalan pengubahan ID
                    } 
                    else {
                        bioskop.setId(idBaru); // Mengubah ID bioskop dengan nilai baru
                    }
                }

                System.out.print("Nama Baru [" + bioskop.getNama() + "]: "); // Menampilkan nama saat ini
                namaBaru = scanner.nextLine();  // Membaca masukan nama baru
                if (!namaBaru.isEmpty()) {      // Jika masukan nama baru tidak kosong
                    bioskop.setNama(namaBaru); // Mengubah nama bioskop
                }

                System.out.print("Alamat Baru [" + bioskop.getAlamat() + "]: "); // Menampilkan alamat saat ini
                alamatBaru = scanner.nextLine();  // Membaca masukan alamat baru
                if (!alamatBaru.isEmpty()) {  // Jika masukan alamat baru tidak kosong
                    bioskop.setAlamat(alamatBaru); // Mengubah alamat bioskop
                }

                System.out.print("Snack Baru [" + bioskop.getSnack() + "]: "); // Menampilkan snack saat ini
                snackBaru = scanner.nextLine();  // Membaca masukan snack baru
                if (!snackBaru.isEmpty()) {  // Jika masukan snack baru tidak kosong
                    bioskop.setSnack(snackBaru); // Mengubah data snack bioskop
                }

                System.out.print("Jumlah Studio Baru [" + bioskop.getStudio() + "]: "); // Menampilkan studio saat ini
                // Validasi input angka studio baru
                if (scanner.hasNextInt()) { // Pengecekan apakah pengguna memasukkan integer valid
                    studioBaru = scanner.nextInt(); // Membaca nilai integer studio
                    scanner.nextLine();  // Membersihkan sisa buffer enter
                    if (studioBaru > 0) { // Cek apakah nilai studio lebih dari nol
                        bioskop.setStudio(studioBaru); // Mengubah jumlah studio
                    } 
                    else {
                        System.out.println("Jumlah studio tidak valid, data tidak diubah."); // Pesan studio invalid
                    }
                } else {
                    System.out.println("Jumlah studio tidak valid, data tidak diubah."); // Pesan studio invalid
                    scanner.next();     // Buang masukan berupa teks salah
                    scanner.nextLine(); // Bersihkan sisa buffer baris
                }

                System.out.println("Yeyy Data Berhasil Diupdate Nih :)"); // Pesan sukses update
                return; // Keluar dari method setelah data ditemukan dan diupdate
            }
        }
        System.out.println("Yahh Id [" + idUbah + "] Tidak Ditemukan. Coba Ganti Id Lain"); // Pesan jika ID tidak ditemukan
    }

    // Method untuk menghapus data bioskop berdasarkan ID
    public static void hapusData() {
        String idHapus; // Deklarasi variabel untuk ID yang akan dihapus
        System.out.println("\n <<<<<<<<<< HAPUS DATA >>>>>>>>>>"); // Menampilkan header menu hapus
        System.out.print("Masukkan Id yang Akan di Hapus : ");     // Meminta input ID yang hendak dihapus
        idHapus = scanner.nextLine();                                 // Membaca nilai ID

        for (int i = 0; i < dataBioskop.size(); i++) { // Looping berdasarkan indeks elemen ArrayList
            if (dataBioskop.get(i).getId().equals(idHapus)) { // Mengecek kecocokan ID pada indeks i
                dataBioskop.remove(i); // Menghapus objek bioskop dari ArrayList pada posisi indeks i
                System.out.println("Yeyy Data Bioskop Berhasil Dihapus Nih :)"); // Pesan sukses hapus
                return; // Keluar dari method setelah menghapus data
            }
        }
        System.out.println("Yahh Bioskop Dengan Id [" + idHapus + "] Tidak Ditemukan. Gagal Menghapus Data!"); // Pesan jika ID tidak ada
    }

    // Method untuk mencari data bioskop berdasarkan ID
    public static void cariData() {
        String idCari; // Deklarasi variabel ID yang dicari
        System.out.println("\n <<<<<<<<<< CARI DATA BIOSKOP >>>>>>>>>>"); // Menampilkan header menu pencarian
        System.out.print("Masukkan Id yang dicari: ");// Meminta input ID dicari
        idCari = scanner.nextLine(); // Membaca nilai ID dicari

        for (Bioskop bioskop : dataBioskop) { // Melakukan iterasi membaca setiap objek di ArrayList
            if (bioskop.getId().equals(idCari)) { // Mengecek kecocokan ID
                System.out.println("\n Data Ditemukan! Berikut infonya:"); // Menampilkan teks sukses
                bioskop.tampil(); // Memanggil method tampil() milik objek Bioskop
                return; // Keluar dari method karena data sudah ditemukan
            }
        }
        System.out.println("Yahh, Bioskop Dengan Id [" + idCari + "] Tidak Ditemukan. Coba Ganti Id Lain"); // Pesan jika ID tidak ditemukan
    }

    // Method pembantu untuk menampilkan daftar menu pilihan utama
    public static void menuPilihan() {
        System.out.println("\n===== MENU BIOSKOP ====="); // Cetak judul menu
        System.out.println("1. Tambah Data");// Cetak pilihan menu 1
        System.out.println("2. Tampilkan Data");// Cetak pilihan menu 2
        System.out.println("3. Update Data");  // Cetak pilihan menu 3
        System.out.println("4. Hapus Data");  // Cetak pilihan menu 4
        System.out.println("5. Cari Data");  // Cetak pilihan menu 5
        System.out.println("0. Keluar");  // Cetak pilihan menu 0
        System.out.print("Pilih : ");  // Meminta input pilihan menu
    }

    // Method untuk menampilkan seluruh daftar data bioskop di dalam ArrayList
    public static void tampilData() {
        System.out.println("\n <<<<<<<<<< DAFTAR DATA BIOSKOP >>>>>>>>>>"); // Menampilkan header daftar data

        if (dataBioskop.isEmpty()) { // Pengecekan apakah ArrayList dataBioskop kosong
            System.out.println("Yahh, Data Bioskop Masih Kosong Nih. Isi Dulu Yuk! :)"); // Pesan jika data kosong
            return;
        }

        int nomor = 1; // Variabel penomoran urutan cetak
        for (Bioskop bioskop : dataBioskop) { // Melakukan iterasi untuk setiap objek bioskop di ArrayList
            System.out.println("\n[ Data Bioskop Ke-" + nomor + " ]"); // Menampilkan nomor urut
            bioskop.tampil();                                        // Memanggil method tampil() dari objek Bioskop
            System.out.println("------------------------------------------"); // Menampilkan garis pemisah
            nomor++; // Menambahkan nomor urut
        }
    }

    // Method utama (entry point) program Java
    public static void main(String[] args) {
        int pilihan; // Deklarasi variabel untuk opsi pilihan menu

        while (true) { // Perulangan tak terbatas untuk menjalankan menu program
            menuPilihan(); // Memanggil method untuk mencetak menu pilihan

            // Validasi menu utama anti-crash jika pengguna menginput karakter huruf
            if (!scanner.hasNextInt()) { // Pengecekan apakah input bukan berupa integer
                System.out.println("Pilihan Harus Berupa Angka (0-5) Yaa!\n"); // Menampilkan peringatan
                scanner.next();     // Buang teks input yang salah
                scanner.nextLine(); // Clear sisa buffer
                continue; // Melompati sisa baris kode di perulangan dan kembali ke awal loop
            }

            pilihan = scanner.nextInt(); // Membaca opsi pilihan angka pengguna
            scanner.nextLine(); // Membuang karakter enter dari buffer input

            // Switch expression Java modern untuk percabangan menu
            switch (pilihan) {
                case 1 -> tambahinData(); // Mengeksekusi method tambahinData()
                case 2 -> tampilData();   // Mengeksekusi method tampilData()
                case 3 -> updateData();   // Mengeksekusi method updateData()
                case 4 -> hapusData();    // Mengeksekusi method hapusData()
                case 5 -> cariData();     // Mengeksekusi method cariData()
                case 0 -> {
                    System.out.println("\nTerima Kasih Sudah Menggunakan Program Ini. Sampai Jumpa Lagi"); // Pesan penutup
                    return; // Menghentikan eksekusi method main dan menutup program secara total
                }
                default -> System.out.println("Aduhh Pilihan Tidak Tersedia. Silakan Masukkan Angka 0 Sampai 5 Yaa\n"); // Pesan default menu tidak valid
            }
        }
    }
}