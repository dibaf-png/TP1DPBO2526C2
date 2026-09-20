#include <iostream> //library untuk cout dan endl
#include <string> //library untuk tipe data string

using namespace std; //ini agar tidak perlu menulis std:: pada string dan cout

class Bioskop { //membuat class namanya Bioskop

    private: //hak akses private hanya dapat diakses langsung dari dalam class
        string id_bioskop; //mnyimpan Id unik bioskop
        string nama_bioskop; //menyimpan nama bioskop
        string alamat; //menyimpan alamat bioskop
        string snack_jual; //menyimpan jenis snack yang dijual
        int jumlah_studio; //menyimpan jumlah studio yang dimiliki bioskop

    public: //hak akses public dapat digunakan dari luar class

        Bioskop(string id_bioskop, string nama_bioskop, string alamat, string snack_jual, int jumlah_studio) { //constructor untuk membuat object Bioskop
            this->id_bioskop = id_bioskop; //mengisi atribut ID dengan nilai dari parameter
            this->nama_bioskop = nama_bioskop; //mngisi atribut nama dengan nilai dari parameter
            this->alamat = alamat; //mngisi atribut alamat dengan nilai dari parameter
            this->snack_jual = snack_jual; //mengisi atribut snack dengan nilai dari parameter
            this->jumlah_studio = jumlah_studio; //mngisi atribut jumlah studio dengan nilai dari parameter
        }
    //setter untuk mengubah id
    void setId(string id_bioskop){
        this ->id_bioskop = id_bioskop; //mengubah nilai id
    }
    //getter untuk mengambil id
    string getId() const{
        return id_bioskop; //mengembalikan nilai id
    }

    //setter untuk mengubah nama
    void setNama (string nama_bioskop){
        this -> nama_bioskop = nama_bioskop; //mengubah nilai nama bioskop
    }
    //getter untuk mengambil nama
    string getNama(){
        return nama_bioskop; //mengembalikan nilai nama bioskop
    }

    //setter untuk mengubah alamat
    void setAlamat(string alamat){
        this-> alamat = alamat; //mengubah nilai alamat
    }
    //getter untuk mengambil alamat
    string getAlamat(){
        return alamat; //mengembalikan nilai alamat
    }

    //setter untuk mengubah snack yang dijual
    void setSnack(string snack_jual){
        this ->snack_jual = snack_jual;
    }
    //getter untuk mengambil snack yang dijual
    string getSnack(){
        return snack_jual; //mengembalikan nilai snack_jual
    }

    //setter untuk mengubah jumlah studio
    void setStudio(int jumlah_studio){
        this -> jumlah_studio = jumlah_studio; //mengubah nilai jumlah studio
    }
    //getter untuk mengambil jumlah studio
    int getStudio(){
        return jumlah_studio; //mengembalikan nilai jumlah studio
    }

    void tampil() const { //ini berfungsi untuk menampilkan data bioskopnya
        cout << "Id Bioskop      : " << id_bioskop << endl; //menampilkan id biskop
        cout << "Nama Bioskop    : " << nama_bioskop << endl; //menampilkan nama bioskop
        cout << "Alamat Bioskop  : " << alamat << endl; //menampilkan alamat dari bioskop
        cout << "Snack Dijual    : " << snack_jual << endl; //menampilkan snack yang dijual di bioskop
        cout << "Jumlah Studio   : " << jumlah_studio << endl; //menampilkan jumlah studio
    }
    ~Bioskop(){ //destructor 
        
    }
};
