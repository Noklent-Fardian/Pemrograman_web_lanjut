

<div align="center">

# Laporan Pemrogaman WEB Lanjut Jobsheet 4 MODEL dan ELOQUENT ORM

<img src="Photo/zfrhpism.png"
style="width:3.24722in;height:2.43333in" />

## Politeknik Negeri Malang Semester 4 2025

**NIM:** 2341720082

**Nama:** Noklent Fardian Erix

**Kelas:** 2A

**Jurusan:** Teknologi Informasi

**Program Studi:** D-IV Teknik Informatika

</div>

> **1.** **Praktikum**
>
> **1.1** **Praktikum** **1** **\$fillable:**
>
> 1\. Q: Simpan kode program Langkah 1 dan 2, dan jalankan perintah web
> server. Kemudian jalankan link localhostPWL_POS/public/user pada
> browser dan amati apa yang terjadi
>
> <img src="Photo/45mckzsg.png"
> style="width:6.26805in;height:2.0875in" />
A: Kode tersebut akan membuat record baru dengan username : manager_dua pada 
table user 

> 2\.Q: Simpan kode program Langkah 4 dan 5. Kemudian jalankan pada browser
dan amati apa yang terjadi

<img src="Photo/svc2ot30.png"
style="width:6.26805in;height:1.23819in" />

> A:
> Akan terjadi tampilan error karena adanya konflik antara model dan
> controller, di mana dalam kasus ini kolom password pada model tidak
> didefiniskan, namun pada fungsi create terdapat array yang terdapat
> index



> **2.1Praktikum** **2** **–** **Retrieving** **Single** **Models**
>
> 1\. Q: Simpan kode program Langkah 1 dan 2. Kemudian jalankan pada
> browser dan amati apa yang terjadi dan beri penjelasan dalam laporan
<img src="Photo/11kqedlg.png"
style="width:5.54861in;height:1.23819in" />
> A:
>
> Program tersebut akan hanya mengambil data m_user untuk index ke 1
>
> 2\. Q: Simpan kode program Langkah 4. Kemudian jalankan pada browser
> dan amati apa yang terjadi dan beri penjelasan dalam laporan
>
> A:
<img src="Photo/jjvfh0qj.png"
style="width:6.26805in;height:1.38194in" />
Ketiga syntax terbsebut akan mempunyai output yang sama yaitu akan
mengprint record pertama.

> 3\. Q: Simpan kode program Langkah 8. Kemudian pada browser dan amati
> apa yang terjadi dan beri penjelasan dalam laporan
<img src="Photo/3tztztui.png"
style="width:6.26805in;height:1.6993in" />
> A:
>
> Program tersebut akan mencari id 1, jika idnya tidak ditemukan maka
> akan muncul halaman not found.
>
> 4\. Q: Simpan kode program Langkah 10. Kemudian jalankan pada browser
> dan amati apa yang terjadi dan beri penjelasan dalam laporan
>
> A: Akan muncul halaman error 404 karena id 21 tidak ditemukan.

<img src="Photo/bi3sh23n.png"
style="width:3.5375in;height:1.79583in" />

**Praktikum** **2.2** **–** **Not** **Found** **Exceptions**

> 1\. Q: Simpan kode program Langkah 1. Kemudian jalankan pada browser
> dan amati apa yang terjadi dan beri penjelasan dalam laporan
>
> <img src="Photo/xtox3ipm.png" style="width:4.08736in;height:1.45in" />A:
>
> 2\. Q: Simpan kode program Langkah 3. Kemudian jalankan pada browser
> dan amati apa yang terjadi dan beri penjelasan dalam laporan
>
> <img src="Photo/32zqpxsb.png"
style="width:3.27764in;height:1.66458in" />
A:

> Akan muncul halaman erorr 404 karena username manager9 tidak ditemukan



**Praktikum** **2.3** **–** **Retreiving** **Aggregrates**

> 1\. Q: Simpan kode program Langkah 1. Kemudian jalankan pada browser
> dan amati apa yang terjadi dan beri penjelasan dalam laporan
<img src="Photo/bh2lfp1u.png"
style="width:5.7218in;height:0.54097in" />
> A:
>
> Akan mempunyai output dari menghitung berapa record yang mempunyai
> user_level 2
>
> 2\. Q: Buat agar jumlah script pada langkah 1 bisa tampil pada halaman
> browser, sebagai contoh bisa lihat gambar di bawah ini dan ubah script
> pada file view supaya bisa muncul datanya
>
> <img src="Photo/byem1fkk.png"
 style="width:6.26805in;height:2.74028in" />
 A: Ubah kode UserController
> menjadi seperti berikut

<img src="Photo/1oqm2skt.png"
style="width:4.85972in;height:5.11222in" />
<img src="Photo/b5qudc4d.png"
style="width:6.26805in;height:1.925in" />

<img src="Photo/oanjhvoi.png"
style="width:6.26805in;height:2.13056in" />

**Praktikum** **2.4** **–** **Retreiving** **or** **Creating**
**Models**

> 1\. Q: Simpan kode program Langkah 1 dan 2. Kemudian jalankan pada
> browser dan amati apa yang terjadi dan beri penjelasan dalam laporan

> A:
<img src="Photo/c5avsnty.png"
style="width:6.26805in;height:0.73819in" />
<img src="Photo/fhia4j1w.png"
style="width:6.26805in;height:0.91389in" />Akan terjadi error karena
funsgi first tidak dapan mencari username manager dan nama Manager

Karena tidak ketemu fungsi tersebut akan menjalankan fungsi create,
namun karena attribute level id tidak ada value maka akan terjadi error.

> 2\. Q: Simpan kode program Langkah 4. Kemudian jalankan pada browser
> dan amati apa yang terjadi dan cek juga pada phpMyAdmin pada tabel
> m_user serta beri penjelasan dalam laporan
>
> A:
>
 <img src="Photo/srvhntco.png"
 style="width:6.26805in;height:0.92569in" />Dan akan membuat record
> baru dalam database


> 3\. Q: Simpan kode program Langkah 6. Kemudian jalankan pada browser
> dan amati apa yang terjadi dan beri penjelasan dalam laporan

> A: Tetap akan error seperti percobaan 1, namun jika kita tambahkan
> kode yang mendefiniskan user_level, maka tampilan akan menjadi serti
> ini
<img src="Photo/lns3ncy1.png"
style="width:5.91208in;height:2.0993in" />
> 4\. Q: Simpan kode program Langkah 8. Kemudian jalankan pada browser
> dan amati apa yang terjadi dan cek juga pada phpMyAdmin pada tabel
> m_user serta beri penjelasan dalam laporan
>
> A:
<img src="Photo/ljz2ohug.png"
style="width:6.26805in;height:1.90069in" />
> 5\. Q: Simpan kode program Langkah 9. Kemudian jalankan pada browser
> dan amati apa yang terjadi dan cek juga pada phpMyAdmin pada tabel
> m_user serta beri penjelasan dalam laporan
>
><img src="Photo/qs1vgufa.png"
 style="width:6.26805in;height:1.77778in" />A: Akan menyimpan haris
> kode pada Use



**Praktikum** **2.5** **–** **Attribute** **Changes**

> 1\. Q: Simpan kode program Langkah 1. Kemudian jalankan pada browser
> dan amati apa yang terjadi dan beri penjelasan dalam laporan
>
> A:
<img src="Photo/ypd3cmiy.png"
style="width:6.26805in;height:0.83889in" />
> Ini berarti attributenya belum ada yang terganti.
>
> 2\. Q: Simpan kode program Langkah 3. Kemudian jalankan pada browser
> dan amati apa yang terjadi dan beri penjelasan dalam laporan
>
> A: 
<img src="Photo/wfejampw.png"
style="width:6.26805in;height:0.83611in" />
>
> Hasil tersebut menandakan bahwa data telah pernah diubah.

**Praktikum** **2.6** **–** **Create,** **Read,** **Update,** **Delete**
**(CRUD)**

> 1\. Q: Simpan kode program Langkah 1 dan 2. Kemudian jalankan pada
> browser dan amati apa yang terjadi dan beri penjelasan dalam laporan
>
> <img src="Photo/50m4wvyg.png"
> style="width:5.46458in;height:3.32014in" />A: Akan berisikan table
> crud yang berisikan m_user



> 2,. Q: Simpan kode program Langkah 4 s/d 6. Kemudian jalankan pada
> browser dan klik link “+ Tambah User” amati apa yang terjadi dan beri
> penjelasan dalam laporan
<img src="Photo/glz4mv4v.png"
style="width:6.26805in;height:2.25972in" />
> A: Akan muncul halaman untuk mengcreate data baru untuk m_user
>
> 2\. Q: Simpan kode program Langkah 8 dan 9. Kemudian jalankan link
> localhost:8000/user/tambah atau localhost/PWL_POS/public/user/tambah
> pada browser dan input formnya dan simpan, kemudian amati apa yang
> terjadi dan beri penjelasan dalam laporan
>
> <img src="Photo/0vypcmci.png"
> style="width:5.37569in;height:2.24653in" /><img src="Photo/zzudqzyu.png"
> style="width:6.26805in;height:1.43472in" />A: Akan maka jika isisan
> disi dan tombol simpan diklik, maka akan menambahkan record baru


> 3\. Q: Simpan kode program Langkah 11 sd 13. Kemudian jalankan pada
> browser dan klik link “Ubah” amati apa yang terjadi dan beri
> penjelasan dalam laporan
<img src="Photo/4hydprgx.png"
style="width:6.26805in;height:2.01944in" />
> A: Halaman akan berubah menjadi halaman edit yang di mana value
> isiannya akan sama dengan value yang kita pencet edit
>
> 4\. Q: Simpan kode program Langkah 15 dan 16. Kemudian jalankan link
> localhost:8000/user/ubah/1 atau localhost/PWL_POS/public/user/ubah/1
> pada browser dan ubah input formnya dan klik tombol ubah, kemudian
> amati apa yang terjadi dan beri penjelasan dalam laporan
<img src="Photo/34h40wio.png"
style="width:6.26805in;height:1.99097in" />
> A: Akan mengubah value attribute untuk user_id 1 yaitu admin
>
> 5\. Q: Simpan kode program Langkah 18 dan 19. Kemudian jalankan pada
> browser dan klik tombol hapus, kemudian amati apa yang terjadi dan
> beri penjelasan dalam laporan
>
> A: kode tersebut akan berjalan ketika tombol hapus diklik, ketika
> diklik maka akan menghapus bari yang dipencet



**Praktikum** **2.7** **–** **Relationships**

> 1\. Q: Simpan kode program Langkah 2. Kemudian jalankan link pada
> browser, kemudian amati apa yang terjadi dan beri penjelasan dalam
> laporan
>
> A:
<img src="Photo/lkfvmdhk.png"
style="width:6.26805in;height:2.52292in" />
> Kode akan mengambil semua user yang mempunyai level.
>
> 2\. Q: Simpan kode program Langkah 4 dan 5. Kemudian jalankan link
> pada browser, kemudian amati apa yang terjadi dan beri penjelasan
> dalam laporan
>
> <img src="Photo/beykbnwx.png"
> style="width:6.26805in;height:3.43333in" />A: Akan menampilkan value
> dari kode level dan nama level
