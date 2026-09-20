# Mengimpor module sys dari library standar Python untuk keperluan menghentikan program
import sys
# Mengimpor class Bioskop dari file/module Bioskop.py
from Bioskop import Bioskop

# Menginisialisasi list kosong bernama dataBioskop untuk menyimpan seluruh objek Bioskop
dataBioskop = []

# Fungsi untuk memeriksa apakah ID bioskop sudah terdaftar di dalam list dataBioskop
def cekId(id_bioskop: str) -> bool:
    # Melakukan perulangan untuk setiap objek bioskop yang ada di dalam list dataBioskop
    for bioskop in dataBioskop:
        # Memeriksa apakah ID objek bioskop sama dengan ID yang dicari
        if bioskop.getId() == id_bioskop:
            # Mengembalikan nilai True jika ID ditemukan
            return True
    # Mengembalikan nilai False jika seluruh perulangan selesai dan ID tidak ditemukan
    return False

# Fungsi untuk menambah data bioskop baru ke dalam list
def tambahinData():
    # Menampilkan header menu penambahan data
    print("\n <<<<<<<<<< Tambah Data >>>>>>>>>>")
    # Meminta pengguna memasukkan ID bioskop
    id_input = input("Masukan Id Bioskop : ")

    # Perulangan akan terus berjalan jika ID yang dimasukkan sudah ada di list (mencegah duplikasi)
    while cekId(id_input):
        # Menampilkan pesan peringatan bahwa ID sudah digunakan
        print("Alahh Id Bioskop Sudah Digunakan. Coba Ganti Id Yaa")
        # Meminta pengguna memasukkan kembali ID bioskop yang baru
        id_input = input("Masukkan Id Bioskop : ")

    # Meminta pengguna memasukkan nama bioskop
    nama = input("Masukkan Nama Bioskop : ")
    # Perulangan untuk memastikan input nama tidak boleh berupa string kosong
    while not nama:
        # Menampilkan pesan kesalahan jika nama kosong
        print("Alahh Nama Bioskop Tidak Boleh Kosong")
        # Meminta pengguna memasukkan kembali nama bioskop
        nama = input("Masukkan Nama Bioskop Kembali : ")

    # Meminta pengguna memasukkan alamat bioskop
    alamat = input("Masukkan Alamat : ")
    # Perulangan untuk memastikan input alamat tidak boleh kosong
    while not alamat:
        # Menampilkan pesan kesalahan jika alamat kosong
        print("Alahh alamat Bioskop Tidak Boleh Kosong")
        # Meminta pengguna memasukkan kembali alamat bioskop
        alamat = input("Masukkan Alamat Kembali : ")

    # Meminta pengguna memasukkan nama snack yang dijual
    snack = input("Masukkan Snack yang Dijual : ")
    # Perulangan untuk memastikan input snack tidak boleh kosong
    while not snack:
        # Menampilkan pesan kesalahan jika snack kosong
        print("Alahh Snack Bioskop Tidak Boleh Kosong")
        # Meminta pengguna memasukkan kembali nama snack
        snack = input("Masukkan Snack yang Dijual Kembali : ")

    # Perulangan untuk memvalidasi input jumlah studio agar berupa angka positif
    while True:
        # Blok try untuk menangkap error konversi tipe data
        try:
            # Meminta input jumlah studio dan mengonversinya menjadi tipe data integer
            studio = int(input("Masukkan Jumlah Studio : "))
            # Memeriksa apakah jumlah studio kurang dari atau sama dengan 0
            if studio <= 0:
                # Menampilkan pesan bahwa studio tidak boleh 0 atau minus
                print("Etss Input Jumlah Studio Tidak Boleh 0 atau Minus Yaa")
                # Mengulang loop dari awal
                continue
            # Keluar dari loop jika input angka valid dan lebih besar dari 0
            break
        # Menangkap error jika input pengguna bukan merupakan angka (misal: huruf/simbol)
        except ValueError:
            # Menampilkan pesan kesalahan tipe data
            print("Etss Input Harus Berupa Angka Yaa")

    # Membuat instance/objek baru dari class Bioskop dengan data yang telah diinputkan
    baru = Bioskop(id_input, nama, alamat, snack, studio)
    # Menambahkan objek Bioskop baru tersebut ke dalam list dataBioskop
    dataBioskop.append(baru)

    # Menampilkan pesan sukses penambahan data
    print("Yeyy Data Berhasil Ditambahkan Nih :)")

# Fungsi untuk memperbarui data bioskop yang sudah ada
def UpdateData():
    # Menampilkan header menu update data
    print("\n <<<<<<<<<< UPDATE DATA >>>>>>>>>>")
    # Meminta pengguna memasukkan ID bioskop yang hendak diubah
    id_ubah = input("Masukkan Id yang Akan di Update Bioskop : ")

    # Melakukan perulangan untuk mencari objek bioskop di dalam list
    for bioskop in dataBioskop:
        # Memeriksa apakah ID objek cocok dengan ID yang akan diubah
        if bioskop.getId() == id_ubah:

            # Meminta input ID baru (menampilkan ID saat ini sebagai referensi)
            id_baru = input(f"Id Baru [{bioskop.getId()}]: ")
            # Memeriksa apakah pengguna menginputkan nilai baru (tidak menekan Enter begitu saja)
            if id_baru:
                # Memeriksa apakah ID baru berbeda dengan ID lama DAN ID baru tersebut sudah dipakai oleh bioskop lain
                if id_baru != bioskop.getId() and cekId(id_baru):
                    # Menampilkan pesan gagal jika ID baru ternyata sudah terdaftar
                    print("Id Gagal Diubah, Id Sudah Digunakan")
                else:
                    # Mengubah ID bioskop dengan ID baru
                    bioskop.setId(id_baru)

            # Meminta input nama baru (menampilkan nama saat ini)
            nama_baru = input(f"Nama Baru [{bioskop.getNama()}]: ")
            # Jika input tidak kosong, perbarui nama bioskop
            if nama_baru:
                bioskop.setNama(nama_baru)

            # Meminta input alamat baru (menampilkan alamat saat ini)
            alamat_baru = input(f"Alamat Baru [{bioskop.getAlamat()}]: ")
            # Jika input tidak kosong, perbarui alamat bioskop
            if alamat_baru:
                bioskop.setAlamat(alamat_baru)

            # Meminta input snack baru (menampilkan snack saat ini)
            snack_baru = input(f"Snack Baru [{bioskop.getSnack()}]: ")
            # Jika input tidak kosong, perbarui snack bioskop
            if snack_baru:
                bioskop.setSnack(snack_baru)

            # Meminta input jumlah studio baru (menampilkan jumlah studio saat ini)
            studio_input = input(f"Jumlah Studio Baru [{bioskop.getStudio()}]: ")
            # Memeriksa apakah pengguna menginputkan sesuatu
            if studio_input:
                # Blok try untuk memvalidasi input studio baru
                try:
                    # Mengonversi input studio menjadi integer
                    studio_baru = int(studio_input)
                    # Memeriksa apakah nilai studio lebih besar dari 0
                    if studio_baru > 0:
                        # Memperbarui jumlah studio pada objek bioskop
                        bioskop.setStudio(studio_baru)
                    else:
                        # Menampilkan pesan jika nilai studio <= 0
                        print("Jumlah studio tidak valid, data tidak diubah.")
                # Menangkap error jika input bukan angka
                except ValueError:
                    # Menampilkan pesan kesalahan input
                    print("Jumlah studio tidak valid, data tidak diubah.")

            # Menampilkan pesan bahwa pembaruan data berhasil
            print("Yeyy Data Berhasil Diupdate Nih :)")
            # Keluar dari fungsi UpdateData setelah selesai mengupdate
            return

    # Menampilkan pesan jika ID yang dicari tidak ditemukan di dalam list
    print(f"Yahh Id [{id_ubah}] Tidak Ditemukan. Coba Ganti Id Lain")

# Fungsi untuk menghapus data bioskop dari list
def hapusData():
    # Menampilkan header menu hapus data
    print("\n <<<<<<<<<< HAPUS DATA >>>>>>>>>>")
    # Meminta pengguna memasukkan ID bioskop yang ingin dihapus
    id_hapus = input("Masukkan Id yang Akan di Hapus : ")

    # Melakukan perulangan berdasarkan indeks dari panjang list dataBioskop
    for i in range(len(dataBioskop)):
        # Memeriksa apakah ID pada indeks ke-i cocok dengan ID yang ingin dihapus
        if dataBioskop[i].getId() == id_hapus:
            # Menghapus elemen pada indeks ke-i dari list dataBioskop
            dataBioskop.pop(i)
            # Menampilkan pesan sukses penghapusan
            print("Yeyy Data Bioskop Berhasil Dihapus Nih :)")
            # Keluar dari fungsi hapusData
            return

    # Menampilkan pesan jika data dengan ID tersebut tidak ditemukan
    print(f"Yahh Bioskop Dengan Id [{id_hapus}] Tidak Ditemukan. Gagal Menghapus Data!")

# Fungsi untuk mencari dan menampilkan informasi data bioskop tertentu
def cariData():
    # Menampilkan header menu cari data
    print("\n <<<<<<<<<< CARI DATA BIOSKOP >>>>>>>>>>")
    # Meminta pengguna memasukkan ID bioskop yang ingin dicari
    id_cari = input("Masukkan Id yang dicari: ")

    # Melakukan perulangan untuk setiap objek bioskop di dalam list
    for bioskop in dataBioskop:
        # Memeriksa apakah ID objek cocok dengan ID yang dicari
        if bioskop.getId() == id_cari:
            # Menampilkan pesan bahwa data berhasil ditemukan
            print("\n Data Ditemukan! Berikut infonya:")
            # Memanggil method tampil() milik objek Bioskop untuk menampilkan detailnya
            bioskop.tampil()
            # Keluar dari fungsi cariData
            return

    # Menampilkan pesan jika data tidak ditemukan
    print(f"Yahh, Bioskop Dengan Id [{id_cari}] Tidak Ditemukan. Coba Ganti Id Lain")

# Fungsi untuk menampilkan pilihan menu utama aplikasi
def menuPilihan():
    # Menampilkan daftar opsi menu
    print("\n===== MENU BIOSKOP =====")
    print("1. Tambah Data")
    print("2. Tampilkan Data")
    print("3. Update Data")
    print("4. Hapus Data")
    print("5. Cari Data")
    print("0. Keluar")

# Fungsi untuk menampilkan seluruh data bioskop yang tersimpan
def tampilData():
    # Menampilkan header menu daftar data
    print("\n <<<<<<<<<< DAFTAR DATA BIOSKOP >>>>>>>>>>")

    # Memeriksa apakah list dataBioskop masih kosong
    if not dataBioskop:
        # Menampilkan pesan jika belum ada data sama sekali
        print("Yahh, Data Bioskop Masih Kosong Nih. Isi Dulu Yuk! :)")
        # Keluar dari fungsi tampilData
        return

    # Menginisialisasi penomoran urut tampilan data
    nomor = 1
    # Melakukan perulangan untuk mencetak seluruh objek bioskop
    for bioskop in dataBioskop:
        # Menampilkan nomor urut data
        print(f"\n[ Data Bioskop Ke-{nomor} ]")
        # Memanggil method tampil() dari objek bioskop
        bioskop.tampil()
        # Menampilkan garis pemisah antar data
        print("------------------------------------------")
        # Menambah penomoran urut sebanyak 1
        nomor += 1

# Fungsi utama pengendali jalan alur program
def main():
    # Perulangan tak terbatas agar menu terus muncul sampai pengguna memilih keluar (0)
    while True:
        # Memanggil fungsi untuk menampilkan menu
        menuPilihan()
        # Meminta input pilihan menu dari pengguna
        pilihan_input = input("Pilih : ")

        # Blok try-except untuk menangkap kesalahan jika pilihan bukan integer
        try:
            # Mengonversi string pilihan menjadi integer
            pilihan = int(pilihan_input)
        # Menangkap kesalahan konversi nilai (misal input huruf/kata)
        except ValueError:
            # Menampilkan pesan kesalahan input menu
            print("Pilihan Harus Berupa Angka (0-5) Yaa!\n")
            # Mengulang kembali dari awal perulangan while
            continue

        # Memeriksa jika pilihan bernilai 1 (Tambah Data)
        if pilihan == 1:
            tambahinData()
        # Memeriksa jika pilihan bernilai 2 (Tampilkan Data)
        elif pilihan == 2:
            tampilData()
        # Memeriksa jika pilihan bernilai 3 (Update Data)
        elif pilihan == 3:
            UpdateData()
        # Memeriksa jika pilihan bernilai 4 (Hapus Data)
        elif pilihan == 4:
            hapusData()
        # Memeriksa jika pilihan bernilai 5 (Cari Data)
        elif pilihan == 5:
            cariData()
        # Memeriksa jika pilihan bernilai 0 (Keluar)
        elif pilihan == 0:
            # Menampilkan pesan penutup
            print("\nTerima Kasih Sudah Menggunakan Program Ini. Sampai Jumpa Lagi")
            # Menghentikan eksekusi skrip python secara keseluruhan
            sys.exit()
        # Menangani jika angka pilihan yang diinputkan di luar rentang 0-5
        else:
            print("Aduhh Pilihan Tidak Tersedia. Silakan Masukkan Angka 0 Sampai 5 Yaa\n")

# Memeriksa apakah file ini dijalankan secara langsung (bukan diimpor sebagai modul)
if __name__ == "__main__":
    # Memanggil dan menjalankan fungsi utama
    main()