# School Management System öğrenci-hizmet veri tabanı kurgusu. 
 ## Öğrenci hizmet abone sistemi

 ### Öğrenci  Bilgileri
 
| öğrenci_id   |öğrenci_adı  |öğrenci_email     |öğrenci_parola       |
|------|---------------------|-------------------|-----------------|
|1     |         `Kaan `      |`kaan@gmail.com`   |`123`          |
|2     |         `Veli `      |`veli@gmail.com`   |`123`          |
|3     |         `Selin `      |`selin@gmail.com`   |`123`          |
|4     |         `Fatma `      |`fatma@gmail.com`   |`123`          |


 ### Görevli  Bilgileri
 
| görevli_id  |görevli_adı |hizmet_id   |görevli_email         |görevli_parola      |
|-------|----------------------|----|---------------|------------------------|
|1     |         `Ahmet  `     |`1` |`ahmet@gmail.com`   |`123`          |
|2     |         `Murat  `     |`1` |`murat@gmail.com`   |`123`          |
|3     |         `Serkan  `    |`2` |`serkan@gmail.com`   |`123`          |


 ### Hizmet   Bilgileri
 
| hizmet_id    |hizmet_adı   |bitiş_tarihi |  hakkında   |
|-------|-------------------|---------------|--------------------------------|
|1     |  `Spor Salonu `    |`10.05.2024`   |`Spor salonu 500 kişiliktir.` |
|2     |  `Kütüphane `     |`28.09.2024`   |`Kütüphanede 5.000 kitap bulunmaktadır.` |

 ### Tahsilat  Bilgileri
 
| tahsilat_id  |student_id |hizmet_id| görevli_id  |ücret  |aktif_abone    |
|------|-----------------|--------|---|---------|-----------------------------|
|1     |         `1 `      |`1`            |`1`   |`500`      |1
|2     |         `2 `      |`1`            |`2`   |`500`      |1
|3     |         `3 `      |`2`            |`2`   |`700`      |1
|4     |         `4 `      |`1`            |`2`   |`500`      |1

