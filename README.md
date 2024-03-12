# School Management System
 ## Proje  öyküsü
 Php ile hazırlanmış, Okul yönetim sistemi sunan bir sitedir. Bu yönetim sisteminde 5 farklı tipte kullanıcı vardır.

Rol idsi 1 olan **admin** sisteme kayıt birimi ekleme ve düzenleme yetkisi vardır.

Rol idsi 2 olan **kayıt birimi** oluşturduğu okula öğretmen,öğrenci,sınıf,ders,duyuru,okul bilgileri ve yemek listesi ekleyebilir ve düzenleme yetkisine sahiptir.

Rol idsi 3 olan **öğretmen** kullanıcısı,sınav ekleyip düzenleme yetkisine sahiptir.Ayrıca yoklama yetkisine de sahiptir.

Rol idsi 4 olan **öğrenci** kullanıcısı, sınav listesinden sınava girebiliyor ve duyru,yemek listesi gibi bilgilendirici içerikleri görebilmektedir.

Rol idsi 5 olan **Veli** kullanıcısı, velisi olduğu öğrencisinin sınav sonuçlarını, notlarını, yoklama durumunu gibi bilgileri görebilmektedir.

 ## Projede Kullandığım Teknolojiler
Projenin **Front-end** kısmnında [Bootstrap](https://getbootstrap.com/) kullandım.

Projede **iconlar** için [icons8](https://icons8.com/) kullandım.

Projedeki bilgilendirici **grafikler** için [highcharts](https://www.highcharts.com/) kullandım.

Projenin genelinde hem verileri listelediğim **tabloları** hem de bu tabloları **pdf,excel,cvs** gibi türlerde export alabildiğim [Datatables](https://datatables.net/) kullandım.

 > **Note:** Genel olarak php ile geliştirdiğim projelerde kullandığım faydali uygulamaların örnekleri [burada](https://github.com/kaankaltakkiran/ornekler) ayrıntılı bir şekilde yer almaktadır.

 ## Proje nasıl kullanılır?
- [ ] Proje clone edilir.
- [ ] Database klasöründe ki sql dosyası database import edilir.
- [ ] Projedeki db.php dosyasındaki bilgiler doğru şekilde doldurulur.
- [X] Kullanıma hazır.
      
   > **Note:**  Bu web sitesini, bu dosyadaki **kullanıcı giriş bilgileriyle**  veya **kendiniz oluşturduğunuz hesap bilgileri**  ile kullanabilirsiniz.
   
 ## Kullanıcı Bilgileri
 

| Users               |Email                          |Password                         |
|----------------|-------------------------------|-----------------------------|
|Admin User       |         `admin@gmail.com`              |`admin`          |
|Register Units User     |`kaan_fb_aslan@hotmail.com`          |`123`           |
|Teacher User          |`veli@gmail.com	`                   |`123`
|Student User          |`ali@gmail.com		`                   |`123`
|Parent User          |`alifather@gmail.com		`                   |`123`

   > **Note:**  Hangi tipte kullanıcı ile giriş yapılıcaksa **rol** tipini ona göre seçilmelidir.

   > **Note:**  Giriş yaptıktan sonra **profil** ve **çıkış** yapma butonları navbarda en sağ bölümünde yer almaktadır.

 ## Proje eksikleri
 - [X] Sınav sistemi eklendi fakat daha sistemli ve güzel hale gelebilir(kullanışlık ve mantık olarak.)
  - [X] Öğretmen sınav oluşturur sonra öğrenci sınavı görür ve sınava girer. Sonra öğrenci sınav notunu görür. Sonra öğretmen sınav notuna göre geçti geçmedi diye belirler. Daha sonra bu notu öğrenci ve veli görür.Sınav notu gördüğü yer güncellenir ve  geçtiyse yeşil, geçemediyse kırmızı renkte gözükür.
  - [X] Devamsızlık sistemi eklendi fakat daha sistemli ve güzel hale gelebilir. Toptalam kaç devamsızlık kaç devamsızlık yaptı, kaç devamsızlık hakkı kaldı gibi bilgiler eklenebilir.(Özet tablo eklendi buna yakın)


 ## Yapılan Temel Geliştirmeler
 - [X] Ekleme,güncelleme,silme ve listeleme işlemleri doğru ve güvenli hale getirildi.
 - [X] Navbarda en sağ kısımında kullanıcının profil resmi bulunduğu kısımda dropdown menu bulunmakadır. Bu menu kısmında Password değiştirme ekranı, profil ekranı(Öğretmen, öğrenci ve veli için), ve çıkış yapma butonu bulunmaktadır.
 - [X] Öğretmen kullanıcısı için not giriş işlemi ve devamsızlık ekle sistemi ekleni.
 - [X] Duyuru,sınav gibi listelerde kullanıcıya neden yayınlanmadığını sebebiyle bildirildi.
 - [X] Öğretmen, öğrenci ve veli kullanıcısı için not listeleme ve devamsızlık listeleme eklendi.Devamsızlık listeleme sisteminde öğrenci ismine göre, tarihe göre ve ders ismine göre filtre eklendi. Ek olarak bu işlemlerin güvenliği ve mantığı doğru bir şekilde sağlandı.
 - [X] Eğer geçersiz bir sayfa ismi veya geçerli olamyan bir urlye gidilirse diye 404 hatası sağlandı.
 - [X] Ekleme işlemlerinde validation eklendi. Kullanıcı bir inputu boş geçerse uyarı yazısı çıkıyor.
 - [X] Ekleme ve güncelleme işlemlerinde eğer veritabanında aynı isimde bir kayıt varsa işlem gerçekleşmiyor. 
 - [X] Duyru kısmında, Duyuru ekleyen kullanıcı duyru listeleme sayfasında duyruyu güncelleme ve silme butonlarını görmekteidr. Extra olarak duyrunun yayınlanıp yayınlanmadığını görebilmektedir.
 - [X] Öğretmen sınav ekleme sayfasında, soruları ekleyip, anında görebiliyor. Bu soruları isterse güncelleyebilir ve silebilir. 
 - [X] Öğretmen listesi,öğrenci listesi, yemek menüsü gibi bir çok listeyi ister pdf ister excel export olarak alınabilmektedir.
 - [X] Kayıt birimi okulda kaç öğrenci kaç öğretmen var gibi sayıları görebilmektedir.
 - [X] Tek kayıt silme işlemi gözden geçirldi ve toplu kayıt silme işlemi eklendi.Eğer kayıt yok ise toplu kayıt silme butonu gözükmeyecek şekilde ayarlandı. Ek olarak eğer table da kayıt yoksa uyarı mesajı verildi.

      
## Site Resimleri Ve Export Örnekleri
https://github.com/kaankaltakkiran/php-proje-resimleri/tree/main/school_management_resimler
## Video Link
https://www.youtube.com/playlist?list=PL9Q-b9EF1JqQ9G6fg7dePuOzWcNzqZqBU
