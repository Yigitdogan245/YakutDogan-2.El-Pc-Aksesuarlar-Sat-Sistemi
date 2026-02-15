<?php
include 'db.php';
include 'header.php';

$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eposta = htmlspecialchars(trim($_POST['eposta']));

    // 1. veritabaından e posta kontrol
    $stmt = $pdo->prepare("SELECT * FROM users WHERE Email = :mail");
    $stmt->execute([':mail' => $eposta]);
    $user = $stmt->fetch();

    if ($user) {
        // 2. token olusturma  ıslemı
        $token = bin2hex(random_bytes(16)); 

        // 3. token ı verı tabanına kayıtla
        $update = $pdo->prepare("UPDATE users SET reset_token = :token WHERE UserID = :id");
        $update->execute([':token' => $token, ':id' => $user['UserID']]);

        // 4. link olusturma islemi
        $link = "sifre_yenile.php?token=" . $token;

        
        $mesaj = '<div class="alert alert-success border-0 shadow-sm">
                    <h4 class="alert-heading"><i class="fas fa-check-circle"></i> E-Posta Gönderildi!</h4>
                    <p>Şifre sıfırlama talimatları <b>' . $eposta . '</b> adresine başarıyla gönderildi.</p>
                    <p>Lütfen gelen kutunuzu (veya spam klasörünü) kontrol edin.</p>
                    <hr>
                    <p class="mb-0 text-muted small">Aşağıdaki linke devam edebilirsiniz:</p>
                    <a href="'.$link.'" class="btn btn-success mt-2"><i class="fas fa-envelope-open-text"></i> Gelen E-Postayı Aç</a>
                  </div>';
    } else {
        $mesaj = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Bu e-posta adresi sistemimizde kayıtlı değil.</div>';
    }
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow border-0">
            <div class="card-header bg-warning text-dark text-center border-0">
                <h4 class="mb-0 fw-bold"><i class="fas fa-lock"></i> Şifremi Unuttum</h4>
            </div>
            <div class="card-body p-4">
                <?php echo $mesaj; ?>
                
                <?php if(empty($mesaj) || strpos($mesaj, 'alert-danger') !== false): ?>
                <p class="text-muted text-center mb-4">Hesabınıza kayıtlı e-posta adresinizi girin, size sıfırlama bağlantısı gönderelim.</p>
                
                <form method="POST">
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="eposta" class="form-control" required placeholder="ornek@gmail.com">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 fw-bold">Sıfırlama Linki Gönder</button>
                </form>
                <?php endif; ?>
            </div>
            <div class="card-footer text-center bg-white border-0 pb-4">
                <a href="giris.php" class="text-decoration-none text-muted"><i class="fas fa-arrow-left"></i> Giriş Ekranına Dön</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>