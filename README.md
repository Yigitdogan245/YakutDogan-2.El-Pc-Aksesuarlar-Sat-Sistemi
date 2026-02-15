 💻 YakutDoğan - C2C PC Aksesuarları ve Donanım Pazaryeri

Bu platform, bireysel kullanıcıların bilgisayar donanımı ve aksesuarları özelinde ilan verebildiği, **PHP 8+** ve **MySQL** mimarisi üzerine kurgulanmış profesyonel bir **C2C (Consumer-to-Consumer)** web uygulamasıdır.
 🎯 Proje Vizyonu & Akademik Temel
İzmir Ekonomi Üniversitesi **MBP 281 İnternet Programcılığı II** dersi kapsamında geliştirilen bu proje; teknolojik sürdürülebilirliği desteklemek ve donanım pazarında güvenli bir ilan döngüsü oluşturmak amacıyla tasarlanmıştır. Proje, modern web standartlarına uygun olarak veri güvenliği ve kullanıcı deneyimi odaklı inşa edilmiştir.

🛠 Teknik Mimari ve Yetkinlikler

 🏗️ Backend Mühendisliği
* **Güvenli Veri Katmanı (PDO):** Tüm veritabanı etkileşimleri `db.php` üzerinden PDO altyapısı ve hazırlanmış ifadeler (Prepared Statements) ile yönetilerek SQL Injection riskleri tamamen bertaraf edilmiştir.
* **CRUD Operasyonları:** Ürünlerin teknik spesifikasyonlarla kaydedilmesi (`urun_ekle.php`), güncellenmesi ve yönetimi için optimize edilmiş bir mimari kurulmuştur.
* **İlişkisel Veritabanı:** `yakutdogandb.sql` üzerinde normalizasyon kurallarına uygun olarak tasarlanmış tablo yapıları.
# 🔐 Güvenlik ve Kimlik Doğrulama
* **Oturum Yönetimi (Session Management):** `Giris.php` ve `cikis.php` modülleri ile kullanıcı oturumları global sunucu değişkenleri üzerinden güvenli bir şekilde takip edilmektedir.
* **Veri Sanitasyonu:** Kullanıcıdan gelen veriler üzerinde XSS koruması (Cross-Site Scripting) ve gelişmiş doğrulama algoritmaları uygulanmıştır.
* **Yönetim Konsolu:** Sistem yöneticisinin tüm ekosistemi denetleyebildiği merkezi bir `admin.php` yönetim paneli mevcuttur.

 🖥️ Modüler Frontend Altyapısı
* **Yeniden Kullanılabilir Bileşenler:** `footer.php` gibi modüler dosyalarla DRY (Don't Repeat Yourself) prensibi uygulanmış, daha hızlı yüklenen ve kolay yönetilen bir yapı oluşturulmuştur.
* **Etkileşimli Geri Bildirimler:** İşlem sonuçlarının ve sistem duyurularının anlık olarak kullanıcıya iletildiği `bildirimler.php` arayüzü.

 📂 Dosya Organizasyonu
* `/` (Root): Çekirdek PHP dosyaları ve sistem mantığı.
* `/Database`: MySQL veritabanı şeması ve başlangıç verileri.
* `/Documentation`: Proje analizini, veritabanı diyagramlarını ve geliştirme süreçlerini içeren teknik rapor.
