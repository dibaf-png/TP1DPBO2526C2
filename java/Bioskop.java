public class Bioskop{ //mmebuat class namanya Bioskop
    private String id_bioskop; //menyimpan id bioskop
    private String nama_bioskop; //untuk menyimpan nama bioskop
    private String alamat; //menyimpan alamat
    private String snack_jual; //menyimpan snack yang dijual
    private int jumlah_studio; //menyimpan jumlah studio

    public Bioskop(String id_bioskop, String nama_bioskop, String alamat, String snack_jual, int jumlah_studio){ //constructor untuk membuat object Bisokop
        this.id_bioskop = id_bioskop; //mengisi atribut ID dengan nilai dari parameter
        this.nama_bioskop = nama_bioskop; //mngisi atribut nama dengan nilai dari parameter
        this.alamat = alamat; //mngisi atribut alamat dengan nilai dari parameter
        this.snack_jual = snack_jual; //mengisi atribut snack dengan nilai dari parameter
        this.jumlah_studio = jumlah_studio; //mngisi atribut jumlah studio dengan nilai dari parameter

    }
    //setter untuk mengubah id
    public void setId(String id_bioskop){
        this. id_bioskop = id_bioskop; //mengubah nilai id
    }
    //getter untuk mengambil id
    public String getId(){
        return id_bioskop; //mengembalikan nilai id
    }

    //setter untuk mengubah nama
    public void setNama (String nama_bioskop){
        this.nama_bioskop = nama_bioskop; //mengubah nilai nama
    }
    //getter untuk mengambil nama
    public String getNama(){
        return nama_bioskop; //mengembalikan nilai nama bioskop
    }

    //setter untuk mengubah alamat
    public void setAlamat(String alamat){
        this.alamat = alamat; //mengubah nilai alamat
    }
    //getter untuk mengambil alamat
    public String getAlamat(){
        return alamat; //mengembalikan nilai alamat
    }

    //setter untuk mengubah snack yang dijual
    public void setSnack(String snack_jual){
        this. snack_jual = snack_jual; //mengubah nilai snack yang dijual
    }
    //getter untuk mengambil snack yang dijual
    public String getSnack(){
        return snack_jual; //mengembalikan nilai snack
    }

    //setter untuk mengubah jumlah studio
    public void setStudio(int jumlah_studio){
        this. jumlah_studio = jumlah_studio; //mengubah nilai jumlah dari studio
    }
    //getter untuk mengambil jumlah studio
    public int getStudio(){
        return jumlah_studio; //mengembalikan nilai jumlah studio
    }

    public void tampil(){ //ini berfungsi untuk menampilkan data bioskopnya
        System.out.println ("Id Bioskop      : " + id_bioskop); //menampilkan id biskop
        System.out.println ("Nama Bioskop    : " + nama_bioskop); //menampilkan nama bioskop
        System.out.println ("Alamat Bioskop  : " + alamat); //menampilkan alamat dari bioskop
        System.out.println ("Snack Dijual    : " + snack_jual); //menampilkan snack yang dijual di bioskop
        System.out.println ("Jumlah Studio   : " + jumlah_studio); //menampilkan jumlah studio
    }
}