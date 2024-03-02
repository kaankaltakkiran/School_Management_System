# School Management System
 ## Proje  öyküsü
 Php ile hazırlanmış, Okul yönetim sistemi sunan bir sitedir. Bu yönetim sisteminde 4 farklı tipte kullanıcı vardır.

Rol idsi 1 olan **admin** sisteme kayıt birimi ekleme ve düzenleme yetkisi vardır.

Rol idsi 2 olan **kayıt birimi** oluşturduğu okula öğretmen,öğrenci,sınıf,ders,duyuru,okul bilgileri ve yemek listesi ekleyebilir ve düzenleme yetkisine sahiptir.

Rol idsi 3 olan **öğretmen** kullanıcısı,sınav ekleyip düzenleme yetkisine sahiptir.

Rol idsi 4 olan **öğrenci** kullanıcısı, sınav listesinden sınava girebiliyor ve duyru,yemek listesi gibi bilgilendirici içerikleri görebilmektedir.


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

   > **Note:**  Hangi tipte kullanıcı ile giriş yapılıcaksa **rol** tipini ona göre seçilmelidir.

   > **Note:**  Giriş yaptıktan sonra **profil** ve **çıkış** yapma butonları navbarda en sağ bölümünde yer almaktadır.

 ## Proje eksikleri
-  [ ] Öğrencinin velisi kullanıcı olarak sisteme dahil edilmeli.
 - [X] Sınav sistemi eklendi fakat daha sistemli ve güzel hale gelebilir(kullanışlık ve mantık olarak.)
 - [ ] Öğrenci yoklama sistemi.
 - [ ] Öğrenci not sistemi.
 - [ ] Telefon rehberi.
 - [ ] Öğretmen kullanıcısı, öğrenci kullanıcısna ödev, proje gibi görev verebildiği bir sistem eklenmeli.
 - [ ] Kayıt biriminin gördüğü grafik daha da ayrıntılı hale getirebilir.(okuldaki erkek öğrenci sayısı, hangi sınıfta kaç öğrenci var vb...)

   ## Yapılan İyileştirmeler
  - [X] İndex page te kullanıcının son giriş tarihi gösterildi.
  - [X] Teacherın gördüğü list exam sayfasında sınavın hangi nedenden dolayı yayınlanmadığı gösterildi.
  
 ## Yapılan Temel Geliştirmeler
 - [X] Genel olarak web sitesini kullanabilmek için giriş yapmak zorunlu hale getirildi.
 - [X] Ekleme,güncelleme,silme ve listeleme işlemleri doğru ve güvenli hale getirildi.
 - [X] Navbarda en sağ kısımında kullanıcının profil resmi bulunduğu kısımda dropdown menu bulunmakadır. Bu menu kısmında Password değiştirme ekranı, profil ekranı(Öğretmen ve öğrenci için), ve çıkış yapma butonu bulunmaktadır.
 - [X] Ekleme işlemlerinde validation eklendi. Kullanıcı bir inputu boş geçerse uyarı yazısı çıkıyor.
 - [X] Ekleme ve güncelleme işlemlerinde eğer veritabanında aynı isimde bir kayıt varsa işlem gerçekleşmiyor. 
 - [X] Duyru kısmında, Duyuru ekleyen kullanıcı duyru listeleme sayfasında duyruyu güncelleme ve silme butonlarını görmekteidr. Extra olarak duyrunun yayınlanıp yayınlanmadığını görebilmektedir.
 - [X] Öğretmen sınav ekleme sayfasında, soruları ekleyip, anında görebiliyor. Bu soruları isterse güncelleyebilir ve silebilir. 
 - [X] Hem Öğretmenin hem de öğrencinin sınav sonuçlarını listleyebilceği bir ekrana sahiptir.Sınav başarı mantığı eğer doğru sayısı yanlış sayısından fazla ise başarılı olacak şekilde ayarlandı.
 - [X] Öğretmen listesi,öğrenci listesi, yemek menüsü gibi bir çok listeyi ister pdf ister excel export olarak alınabilmektedir.
 - [X] Kayıt birimi okulda kaç öğrenci kaç öğretmen var gibi sayıları görebilmektedir.

      
## Site Resimleri Ve Export Örnekleri
https://github.com/kaankaltakkiran/php-proje-resimleri/tree/main/school_management_resimler
