#include <iostream>  //library untuk operasi input dan output (cin, cout)
#include <vector>    //library vector untuk menyimpan sekumpulan data dinamis
#include <string>    //library string untuk memanipulasi teks
#include "Bioskop.cpp" //mngimpor file implementasi/definisi class Bioskop dari luar

using namespace std; //ini agar tidak perlu menuliskan 'std::' di setiap fungsi

vector<Bioskop> dataBioskop; //membentuk kontainer vector global bertipe 'Bioskop' untuk menyimpan daftar bioskop

//ini untuk mengecek apakah ID bioskop sudah ada di dalam dataBioskop atau belum
bool cekId(string Id_bioskop){
    for (const auto &Bioskop : dataBioskop){ //melakukan iterasi pada setiap objek Bioskop di dalam vector
        if (Bioskop.getId() == Id_bioskop){  //membandingkan ID bioskop saat ini dengan ID yang dicari
            return true; //mengembalikan nilai true jika ID ditemukan (sudah terpakai)
        }
    }
    return false;//mengembalikan nilai false jika ID belum pernah digunakan
}

// Fungsi untuk menambahkan data bioskop baru ke dalam vector
void tambahinData(){
    string Id;     //untuk menyimpan input ID bioskop
    string nama;   //untuk menyimpan input nama bioskop
    string alamat; //untuk menyimpan input alamat bioskop
    string snack;  //untuk menyimpan input jenis snack
    int studio;    //untuk menyimpan input jumlah studio

    cout << "\n <<<<<<<<<< Tambah Data >>>>>>>>>>" << endl; //menampilkan judul menu tambah data
    cout << "Masukan Id Bioskop : ";//instruksi input ID
    cin >> Id; //digunakan untuk membaca input ID dari user

    //ini untuk pengecekan apakah ada ID ganda atau engga
    while(cekId(Id)){ //melakukan perulangan selama si ID yang dimasukkan sudah ada di dalam vector
        cout << "Alahh Id Bioskop Sudah Digunakan. Coba Ganti Id Yaa" << endl; //pesan jika terdapat ID ganda
        cout << "Masukkan Id Bioskop : "; //meminta kembali masukan ID
        cin >> Id; //membaca masukan ID yang baru
    }

    cin.ignore(); //membersihkan karakter newline ('\n') dari buffer input setelah perintah 'cin >>'

    cout << "Masukkan Nama Bioskop : "; //instruksi input nama bioskop
    getline(cin, nama); //membaca seluruh baris string nama (termasuk spasi)

    //ini untuk cek ada input nama yang kosong atau engga
    while(nama.empty()){ //melakukan perulangan selama string nama itu kosong
        cout << "Alahh Nama Bioskop Tidak Boleh Kosong" << endl; //jika terdapat nama kosong, maka akan ada pesan peringatan
        cout << "Masukkan Nama Bioskop Kembali : "; //meminta masukan nama ulang
        getline(cin, nama); //membaca kembali masukan nama baru
    }

    cout << "Masukkan Alamat : "; //instruksi input alamat
    getline(cin, alamat); //membaca seluruh baris string alamat

    //pengecekan input alamat kosong
    while(alamat.empty()){ //melakukan perulangan selama string alamat bernilai kosong
        cout << "Alahh alamat Bioskop Tidak Boleh Kosong" << endl; // pesan peringatan jika alamat kosong
        cout << "Masukkan Alamat Kembali : "; //meminta masukan alamat ulang
        getline(cin, alamat); //membaca kembali masukan alamat baru
    }

    cout << "Masukkan Snack yang Dijual : "; //instruksi input snack
    getline(cin, snack); //membaca seluruh baris string snack

    //pengecekan input snack kosong
    while(snack.empty()){ //melakukan perulangan selama string snack bernilai kosong
        cout << "Alahh Snack Bioskop Tidak Boleh Kosong" << endl; //pesan peringatan jika terdapat snack kosong
        cout << "Masukkan Snack yang Dijual Kembali : "; //meminta masukan snack ulang
        getline(cin, snack); //membaca kembali masukan snack baru
    }

    cout << "Masukkan Jumlah Studio : "; //instruksi input jumlah studio
    cin >> studio; //membaca nilai integer jumlah studio

    //ini pengecekan untuk input angka studio (mencegah salah tipe data atau angka <= 0)
    while (cin.fail() || studio <= 0){ //berjalan jika input bukan angka atau nilainya <= 0
        if (cin.fail()){ //pengecekan jika terjadi kegagalan pembacaan tipe data
            cout << "Etss Input Harus Berupa Angka Yaa" << endl; //pesan peringatan jika salah tipe data
        }
        else if (studio <= 0){ //pengecekan jika nilai angka studio kurang dari atau sama dengan nol
            cout << "Etss Input Jumlah Studio Tidak Boleh 0 atau Minus Yaa" << endl; //pesan peringatan jika angka tidak valid
        }
        cin.clear(); //memulihkan flag error pada stream cin ke kondisi normal
        cin.ignore(1000, '\n'); //mengabaikan hingga 1000 karakter sisa di buffer sampai karakter newline

        cout << "Masukkan Jumlah Studio Kembali : "; //meminta masukan angka studio ulang
        cin >> studio; //membaca kembali nilai studio yang baru
    }

    Bioskop baru(Id, nama, alamat, snack, studio); //membuat objek 'baru' dari class Bioskop menggunakan konstruktor
    dataBioskop.push_back(baru); //memasukkan objek bioskop baru ke bagian belakang vector

    cout << "Yeyy Data Berhasil Ditambahkan Nih :)" << endl; //pesan sukses tambah data
}

// Fungsi untuk memperbarui/mengubah data bioskop berdasarkan ID
void UpdateData(){
    string Id_ubah; //untuk menyimpan ID yang ingin diubah

    string Id_baru; //untuk nilai ID baru
    string nama_baru; //untuk nilai nama baru
    string alamat_baru; //untuk nilai alamat baru
    string snack_baru; //untuk nilai snack baru
    int studio_baru;  //untuk nilai studio baru

    cout << "\n <<<<<<<<<< UPDATE DATA >>>>>>>>>>" << endl; //menampilkan header menu update
    cout << "Masukkan Id yang Akan di Update Bioskop : "; //meminta ID yang ingin dicari untuk diubah
    cin >> Id_ubah; //membaca input ID sasaran
    cin.ignore(); //membersihkan sisa karakter newline di buffer

    for (auto &Bioskop : dataBioskop){ //melakukan perulangan dengan referensi ('&') agar data asli bisa diubah
        if (Bioskop.getId() == Id_ubah){ //mengecek apakah ID pada data cocok dengan ID sasaran

            cout << "Id Baru [" << Bioskop.getId() << "]: "; //menampilkan nilai ID saat ini sebagai petunjuk
            getline(cin, Id_baru); //membaca masukan ID baru dari pengguna
            if(Id_baru.empty() == false){ //mengecek apakah input ID baru tidak kosong
                if(Id_baru != Bioskop.getId() && cekId(Id_baru)){ //mengecek jika ID diubah dan ternyata ID baru sudah dipakai
                    cout << "Id Gagal Diubah, Id Sudah Digunakan" << endl; // Pesan gagal melakukan pengubahan ID
                }
                else{
                    Bioskop.setId(Id_baru); //memperbarui nilai ID bioskop jika valid
                }
            }

            cout << "Nama Baru [" << Bioskop.getNama() << "]: "; //menampilkan nilai nama saat ini
            getline(cin, nama_baru);// Membaca input nama baru

            if(nama_baru.empty() == false){ // Mengecek jika masukan nama baru tidak kosong
                Bioskop.setNama(nama_baru); // Memperbarui nama bioskop
            }

            cout << "Alamat Baru [" << Bioskop.getAlamat() << "]: "; // Menampilkan nilai alamat saat ini
            getline(cin, alamat_baru);  // Membaca input alamat baru

            if(alamat_baru.empty() == false){ // Mengecek jika masukan alamat baru tidak kosong
                Bioskop.setAlamat(alamat_baru); // Memperbarui alamat bioskop
            }

            cout << "Snack Baru [" << Bioskop.getSnack() << "]: "; // Menampilkan nilai snack saat ini
            getline(cin, snack_baru); // Membaca input snack baru

            if(snack_baru.empty() == false){ // Mengecek jika masukan snack baru tidak kosong
                Bioskop.setSnack(snack_baru); // Memperbarui daftar snack bioskop
            }

            cout << "Jumlah Studio Baru [" << Bioskop.getStudio() << "]: "; // Menampilkan nilai studio saat ini
            cin >> studio_baru; // Membaca masukan angka studio baru

            if ((cin.fail() == false) && (studio_baru > 0)){ // Memastikan input studio angka valid dan bernilai positif
                Bioskop.setStudio(studio_baru); // Memperbarui jumlah studio
            }
            else{
                cout << "Jumlah studio tidak valid, data tidak diubah." << endl; // Pesan pembatalan ubah studio
                cin.clear(); // Membersihkan penanda error pada stream cin
                cin.ignore(1000, '\n'); // Mengabaikan sisa input buruk di buffer
            }
            cin.ignore(1000, '\n'); // Membersihkan karakter newline dari buffer sebelum keluar fungsi

            cout << "Yeyy Data Berhasil Diupdate Nih :)" << endl; // Menampilkan pesan sukses update
            return; // Menghentikan fungsi karena data sudah diperbarui
        }
    }
    cout << "Yahh Id [" << Id_ubah << "] Tidak Ditemukan. Coba Ganti Id Lain" << endl; // Pesan jika ID sasaran tidak ditemukan
}

// Fungsi untuk menghapus data bioskop berdasarkan ID
void hapusData() {
    string Id_hapus; // Deklarasi variabel untuk ID yang akan dihapus
    cout << "\n <<<<<<<<<< HAPUS DATA >>>>>>>>>>" << endl; // Menampilkan header menu hapus
    cout << "Masukkan Id yang Akan di Hapus : "; // Meminta input ID sasaran
    cin >> Id_hapus; // Membaca nilai ID sasaran

    // Perulangan menggunakan iterator untuk melintasi elemen-elemen vector
    for (auto it = dataBioskop.begin(); it != dataBioskop.end(); ++it) {
        if (it->getId() == Id_hapus) { // Mengecek jika ID pada iterator cocok dengan ID sasaran
            dataBioskop.erase(it); // Menghapus elemen pada posisi iterator saat ini dari vector
            cout << "Yeyy Data Bioskop Berhasil Dihapus Nih :)" << endl; // Pesan pemberitahuan sukses hapus
            return;  // Menghentikan fungsi setelah menghapus elemen
        }
    }

    cout << "Yahh Bioskop Dengan Id [" << Id_hapus << "] Tidak Ditemukan. Gagal Menghapus Data!" << endl; // Pesan jika ID tidak ada
}

// Fungsi untuk mencari dan menampilkan detail bioskop berdasarkan ID
void cariData() {
    string id_cari; // Deklarasi variabel untuk ID yang dicari
    
    cout << "\n <<<<<<<<<< CARI DATA BIOSKOP >>>>>>>>>>" << endl; // Menampilkan header menu pencarian
    cout << "Masukkan Id yang dicari: "; // Meminta masukan ID pencarian
    cin >> id_cari;                // Membaca ID yang dicari

    // Perulangan untuk menelusuri seluruh data di dalam vector
    for (const auto& Bioskop : dataBioskop) {
        if (Bioskop.getId() == id_cari) { // Pengecekan kecocokan ID
            cout << "\n Data Ditemukan! Berikut infonya:" << endl; // Menampilkan teks keberhasilan
            Bioskop.tampil(); // Memanggil method 'tampil' dari kelas Bioskop
            return; // Hentikan eksekusi fungsi karena data sudah ditemukan
        }
    }

    // Dieksekusi jika perulangan selesai tanpa menemukan ID yang sesuai
    cout << "Yahh, Bioskop Dengan Id [" << id_cari << "] Tidak Ditemukan. Coba Ganti Id Lain" << endl;
}

// Fungsi pembantu untuk mencetak daftar menu utama
void menuPilihan() { // Method untuk menampilkan daftar pilihan menu pada konsol
    cout << "\n===== MENU BIOSKOP =====" << endl; // Menampilkan judul utama menu
    cout << "1. Tambah Data" << endl; //Menambah data baru
    cout << "2. Tampilkan Data" << endl; // Menampilkan seluruh data
    cout << "3. Update Data" << endl; //Mengedit data yang ada
    cout << "4. Hapus Data" << endl; //Menghapus data
    cout << "5. Cari Data" << endl;//Mencari data
    cout << "0. Keluar" << endl;//Keluar dari program
    cout << "Pilih : ";//meminta input nomor opsi pilihan
}

//untuk menampilkan seluruh daftar data bioskop yang tersimpan
void tampilData() {
    cout << "\n <<<<<<<<<< DAFTAR DATA BIOSKOP >>>>>>>>>>" << endl; //Menampilkan header daftar data

    //Pengecekan apakah kontainer vector masih dalam kondisi kosong
    if (dataBioskop.empty()) {
        cout << "Yahh, Data Bioskop Masih Kosong Nih. Isi Dulu Yuk! :)" << endl; // Pesan jika data kosong
        return;
    }

    // Menampilkan seluruh data menggunakan perulangan berurutan
    int nomor = 1; // Variabel penghitung urutan nomor data
    for (const auto& Bioskop : dataBioskop) { // Melakukan iterasi membaca setiap objek di dalam vector
        cout << "\n[ Data Bioskop Ke-" << nomor << " ]" << endl; // Menampilkan nomor urut tampilan
        Bioskop.tampil();                                        // Memanggil fungsi cetak informasi dari class Bioskop
        cout << "------------------------------------------" << endl; // Pembatas antar baris data
        nomor++; // Menambahkan angka nomor urut
    }
}


int main() {
    int pilihan; //Deklarasi variabel lokal untuk menyimpan opsi pilihan menu pengguna

    while (true) { // Melakukan perulangan tak terbatas untuk menjaga program tetap berjalan
        menuPilihan(); // Memanggil fungsi cetak daftar menu
        cin >> pilihan; // Membaca angka pilihan pengguna

        // Penanganan input bukan berupa angka pada pemilihan menu utama
        if (cin.fail()) {
            cin.clear();            // Mereset status eror pada cin
            cin.ignore(1000, '\n'); // Menghapus input invalid dari buffer pembacaan
            cout << "Pilihan Harus Berupa Angka (0-5) Yaa!\n" << endl; // Menampilkan instruksi perbaikan
            continue;               // Melompati alur switch dan kembali ke awal loop perulangan
        }

        // Percabangan switch-case berdasarkan masukan pilihan menu
        switch (pilihan) {
            case 1:
                tambahinData(); // Memanggil fungsi untuk menambah data bioskop
                break;          // Keluar dari blok switch
            case 2:
                tampilData();   // Memanggil fungsi untuk menampilkan daftar bioskop
                break;          // Keluar dari blok switch
            case 3:
                UpdateData();   // Memanggil fungsi untuk mengubah data bioskop
                break;          // Keluar dari blok switch
            case 4:
                hapusData();    // Memanggil fungsi untuk menghapus data bioskop
                break;          // Keluar dari blok switch
            case 5:
                cariData();     // Memanggil fungsi untuk mencari data bioskop
                break;          // Keluar dari blok switch
            case 0:
                cout << "\nTerima Kasih Sudah Menggunakan Program Ini. Sampai Jumpa Lagi" << endl; // Pesan perpisahan
                return 0;       // Menghentikan fungsi main dan mengakhiri eksekusi program
            default:
                cout << "Aduhh Pilihan Tidak Tersedia. Silakan Masukkan Angka 0 Sampai 5 Yaa\n" << endl; // Pesan jika angka out-of-range
                break;          // Keluar dari blok switch
        }
    }
    return 0; // Mengembalikan status 0 saat fungsi main berakhir normal
}