<?php 
    // szeon baslat
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    
    // 1. verı tabanı baglama
    include 'db.php'; 
    include 'header.php'; 

    $mesaj = ""; // Hata mesajı degısken
    
    // Form kontrol
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // formdan gelken verı temızle al
        $kullanici_adi = htmlspecialchars(trim($_POST['kullanici_adi']));
        $eposta        = htmlspecialchars(trim($_POST['eposta']));
        $sifre         = htmlspecialchars(trim($_POST['sifre']));
        $sifre_tekrar  = htmlspecialchars(trim($_POST['sifre_tekrar']));
        
        // bos mu komntrol
        if (empty($kullanici_adi) || empty($eposta) || empty($sifre) || empty($sifre_tekrar)) {
            $mesaj = '<div class="alert alert-danger">Lütfen tüm alanları doldurun.</div>';
        } elseif (!filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
            $mesaj = '<div class="alert alert-warning">Geçerli bir e-posta adresi girin.</div>';
        } elseif ($sifre !== $sifre_tekrar) { 
             $mesaj = '<div class="alert alert-warning">Girdiğiniz şifreler eşleşmiyor.</div>';
        } else {
            
            try {
                //has yapma
                $sifre_hash = password_hash($sifre, PASSWORD_DEFAULT);

                //sql insert veri ekle
                $sql = "INSERT INTO users (Username, Email, Password, Role) VALUES (:kadi, :mail, :sifre, 'user')";
                $stmt = $pdo->prepare($sql);
                
                // 3. verı eslestır kayıt yapma
                $kayit_sonuc = $stmt->execute([
                    ':kadi' => $kullanici_adi,
                    ':mail' => $eposta,
                    ':sifre' => $sifre_hash 
                ]);

               
                $_SESSION['bildirim'] = '<div class="alert alert-success">Kayıt başarıyla tamamlandı. Giriş yapabilirsiniz.</div>';
                
                //gırıs sayfa
                header("Location: giris.php");
                exit;

            } catch (PDOException $e) {
                // coklu gırıs yapılmısa kontrol etme kodi
                if ($e->getCode() == 23000) {
                    $mesaj = '<div class="alert alert-danger">Bu Kullanıcı Adı veya E-posta zaten kayıtlı!</div>';
                } else {
                    $mesaj = '<div class="alert alert-danger">Veritabanı hatası oluştu: ' . $e->getMessage() . '</div>';
                }
            }
        }
    }
?>

<div class="row justify-content-center mt-4">
    <div class="col-lg-10"> 
        <div class="card shadow border-0 overflow-hidden">
            <div class="row g-0"> 
                
                <div class="col-md-4 bg-primary text-white p-5 d-flex flex-column justify-content-center">
                    <h3 class="mb-4 fw-bold">Neden YakutDoğan?</h3>
                    <ul class="list-unstyled">
                        <li class="mb-3"><i class="fas fa-check-circle me-2"></i> Güvenli Alım & Satım</li>
                        <li class="mb-3"><i class="fas fa-search me-2"></i> Detaylı Filtreleme</li>
                        <li class="mb-3"><i class="fas fa-exchange-alt me-2"></i> Kolay Takas İmkanı</li>
                    </ul>
                </div>
                
                <div class="col-md-8 p-5">
                    <h2 class="mb-4 fw-bold">Hemen Ücretsiz Kayıt Ol!</h2>
                    
                    <?php echo $mesaj;  ?>

                    <form action="kaydol.php" method="POST" class="row g-3">
                        
                        <div class="col-md-12">
                            <label for="kullanici_adi" class="form-label">Kullanıcı Adı</label>
                            <input type="text" class="form-control" id="kullanici_adi" name="kullanici_adi" required 
                                   placeholder="Sitede görünmesini istediğiniz isim"
                                   value="<?php echo isset($kullanici_adi) ? $kullanici_adi : ''; ?>">
                        </div>
                        
                        <div class="col-md-12">
                            <label for="eposta" class="form-label">E-Posta Adresi</label>
                            <input type="email" class="form-control" id="eposta" name="eposta" required 
                                   placeholder="Bildirimler bu adrese gönderilecektir"
                                   value="<?php echo isset($eposta) ? $eposta : ''; ?>">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="sifre" class="form-label">Şifre</label>
                            <input type="password" class="form-control" id="sifre" name="sifre" required>
                        </div>

                        <div class="col-md-6">
                            <label for="sifre_tekrar" class="form-label">Şifre Tekrar</label>
                            <input type="password" class="form-control" id="sifre_tekrar" name="sifre_tekrar" required>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="kosullar" required>
                               <label class="form-check-label" for="kosullar">
                                    <a href="sozlesme.php" target="_blank" class="text-decoration-underline fw-bold text-primary">Kullanıcı Sözleşmesini</a> okudum, kabul ediyorum.
                                  </label>
                            </div>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Hesap Oluştur</button>
                        </div>
                        
                        <div class="col-12 text-center mt-3">
                            Zaten hesabınız var mı? <a href="giris.php">Giriş Yapın.</a>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>