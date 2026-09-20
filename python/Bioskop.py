class Bioskop: #membuat class namanya Bioskop
    #untuk penggunaan (__) atau double underscore untuk membuat attribut tersebut menjadi private 
    def __init__(self, id_bioskop: str, nama_bioskop: str, alamat: str, snack_jual: str, jumlah_studio: int): 
        self.__id_bioskop = id_bioskop  #menyimpan ID bioskop
        self.__nama_bioskop = str(nama_bioskop)  #menyimpan nama bioskop 
        self.__alamat = str(alamat)  #menyimpan alamat bioskop
        self.__snack_jual = str(snack_jual)  #menyimpan snack yang dijual
        self.__jumlah_studio = int(jumlah_studio)  #menyimpan jumlah studio
    
    #setter untuk mengubah id
    def setId(self, id_bioskop: str):
        self.__id_bioskop = id_bioskop #

    #getter untuk mengambil id
    def getId(self) -> str:
        return self.__id_bioskop #mengembalikan nilai id
    
    #setter untuk mengubah nama
    def setNama (self, nama_bioskop: str):
        self.__nama_bioskop = nama_bioskop
    
    #getter untuk mengambil nama
    def getNama(self) -> str:
        return self.__nama_bioskop

    #setter untuk mengubah alamat
    def setAlamat(self, alamat: str):
        self.__alamat = alamat
    
    #getter untuk mengambil alamat
    def getAlamat(self) -> str:
        return self.__alamat
    
    #setter untuk mengubah snack yang dijual
    def setSnack(self, snack_jual: str):
        self.__snack_jual = snack_jual
    
    #getter untuk mengambil snack yang dijual
    def getSnack(self) -> str:
        return self.__snack_jual
    
    #setter untuk mengubah jumlah studio
    def setStudio(self, jumlah_studio: int):
        self.__jumlah_studio = jumlah_studio
    
    #getter untuk mengambil jumlah studio
    def getStudio(self) -> int:
        return self.__jumlah_studio
    
    def tampil(self) : #berfungsi untuk menampilkan data bioskopnya
        print("Id Bioskop      : ",self.__id_bioskop) #menampilkan id bioskop
        print("Nama Bioskop    : ",self.__nama_bioskop) #menampilkan nama bioskop
        print("Alamat Bioskop  : ",self.__alamat) #menampilkan alamat dari bioskop
        print("Snack Dijual    : ",self.__snack_jual) #menampilkan snack yang dijual di bioskop
        print("Jumlah Studio   : ",self.__jumlah_studio) #menampilkan jumlah studio
    
    