<?php
    class Bioskop{ //membuat class namanya itu Bioskop
        private string $id_bioskop; //menyimpan id bioskop
        private string $nama_bioskop; //untuk menyimpan nama bioskop
        private string $alamat; //menyimpan alamat
        private string $snack_jual; //menyimpan snack yang dijual
        private int $jumlah_studio; //menyimpan jumlah studio
        private string $gambar; //menyimpan path gambar

        public function __construct(string $id_bioskop, string $nama_bioskop, string $alamat, string $snack_jual, int $jumlah_studio, string $gambar){ //constructor untuk membuat object Bioskop
            $this->id_bioskop = $id_bioskop; //mengisi atribut ID dengan nilai dari parameter
            $this->nama_bioskop = $nama_bioskop; //mngisi atribut nama dengan nilai dari parameter
            $this->alamat = $alamat; //mwngisi atribut alamat dengan nilai dari parameter
            $this->snack_jual = $snack_jual; //mengisi atribut snack dengan nilai dari parameter
            $this->jumlah_studio = $jumlah_studio; //mngisi atribut jumlah studio dengan nilai dari parameter 
            $this->gambar = $gambar; //mengisi path gambar object
        }

        //setter untuk mengubah id
        public function setId($id_bioskop){
            $this -> id_bioskop = $id_bioskop; //mengubah nilai id
        }
        //getter untuk mengambil id
        public function getId(){
            return $this->id_bioskop; //mengembalikan nilai id
        }

        //setter untuk mengubah nama
        public function setNama ($nama_bioskop){
            $this -> nama_bioskop = $nama_bioskop; //mengubah nilai nama bioskop
        }
        //getter untuk mengambil nama
        public function getNama(){
            return $this->nama_bioskop; //mengembalikan nilai nama bioskop
        }

        //setter untuk mengubah alamat
        public function setAlamat($alamat){
            $this-> alamat = $alamat; //mengubah nilai alamat
        }
        //getter untuk mengambil alamat
        public function getAlamat(){
            return $this ->alamat; //mengembalikan nilai alamat
        }

        //setter untuk mengubah snack yang dijual
        public function setSnack($snack_jual){
            $this ->snack_jual = $snack_jual;
        }
        //getter untuk mengambil snack yang dijual
        public function getSnack(){
            return $this-> snack_jual; //mengembalikan nilai snack_jual
        }

        //setter untuk mengubah jumlah studio
        public function setStudio($jumlah_studio){
            $this -> jumlah_studio = $jumlah_studio; //mengubah nilai jumlah studio
        }
        //getter untuk mengambil jumlah studio
        public function getStudio(){
            return $this -> jumlah_studio; //mengembalikan nilai jumlah studio
        }

        //setter untuk mengubah gambar
        public function setGambar($gambar){
            $this -> gambar = $gambar; //mengubah nilai gambar
        }
        //getter untuk mengambil gambar
        public function getGambar(){
            return $this -> gambar; //mengembalikan nilai gambar
        }
    }
?>