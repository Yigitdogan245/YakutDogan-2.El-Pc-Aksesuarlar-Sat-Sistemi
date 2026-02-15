<?php 
    // Sezon baslama
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    
    include 'db.php'; 
    include 'header.php'; 
    
    $hata = "";

    // kayıt sayfasından gelen mesaj kontrolu
    $bildirim = '';
    if (isset($_SESSION['bildirim'])) {
        $bildirim = $_SESSION['bildirim']; 
        unset($_SESSION['bildirim']); 
    }

    // eger fomr gonderme
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $kullanici_adi = htmlspecialchars(trim($_POST['kullanici_adi']));
        $sifre_girilen = htmlspecialchars(trim($_POST['sifre']));

        //!!!!!!VERI TABAINDANDA OLMAYAN ADMIN KULLANICISI BURDA GOMULUUUUU
        if ($kullanici_adi === 'admin' && $sifre_girilen === 'root') {
            
            
            $_SESSION['kullanici_id'] = 0; // DB DE OLMAYAN IDDDD
            $_SESSION['kullanici_adi'] = 'admin';
            $_SESSION['rol'] = 'admin'; // ROLU ADMIN YAPTIRMA KODI
            
            // giriş yaptığında dirket ozel panedle ac
            header("Location: admin.php"); 
            exit;
        }

        //normal kullanıcı gırısı verıtabından
        try {
            $sql = "SELECT * FROM users WHERE Username = :kadi";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':kadi' => $kullanici_adi]);
            
            $uye = $stmt->fetch();

            if ($uye && password_verify($sifre_girilen, $uye['Password'])) {
                
                
                $_SESSION['kullanici_id'] = $uye['UserID'];
                $_SESSION['kullanici_adi'] = $uye['Username'];
                $_SESSION['rol'] = 'user'; // ROL NORMAL
                
                header("Location: index.php"); 
                exit;

            } else {
                $hata = "Kullanıcı adı veya şifre hatalı!";
            }

        } catch (PDOException $e) {
            $hata = "Veritabanı hatası: " . $e->getMessage();
        }
    }
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header bg-dark text-white text-center">
                <h4>Kullanıcı Girişi</h4>
            </div>
            <div class="card-body p-4">
                
                <?php echo $bildirim; ?>
                
                <?php if($hata): ?>
                    <div class="alert alert-danger"><?php echo $hata; ?></div>
                <?php endif; ?>

                <form action="giris.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Kullanıcı Adı</label>
                        <input type="text" name="kullanici_adi" class="form-control" required placeholder="Kullanıcı adınız">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Şifre</label>
                        <input type="password" name="sifre" class="form-control" required placeholder="Şifreniz">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Giriş Yap</button>
                    
                    <div class="mb-3 text-end mt-2">
                        <a href="sifremi_unuttum.php" class="text-decoration-none small">Şifremi Unuttum?</a>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                Hesabın yok mu? <a href="kaydol.php">Kayıt Ol</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>