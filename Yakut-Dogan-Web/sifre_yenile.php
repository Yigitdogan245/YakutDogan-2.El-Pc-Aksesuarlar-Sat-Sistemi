<?php
include 'db.php';
include 'header.php';

$mesaj = "";
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $yeni_sifre = htmlspecialchars(trim($_POST['sifre']));
    $token_post = $_POST['token'];

    // sifre haslemi kodu 
    $sifre_hash = password_hash($yeni_sifre, PASSWORD_DEFAULT);

    // 1. token dogurlama kodu
    // sonra tokın sil
    $sql = "UPDATE users SET Password = :pass, reset_token = NULL WHERE reset_token = :token";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':pass' => $sifre_hash, ':token' => $token_post]);

    if ($stmt->rowCount() > 0) {
        $mesaj = '<div class="alert alert-success">Şifreniz başarıyla güncellendi! <a href="giris.php">Giriş Yap</a></div>';
        $token = ""; // formu gizlemek için blank
    } else {
        $mesaj = '<div class="alert alert-danger">Hata: Geçersiz veya süresi dolmuş link.</div>';
    }
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header bg-success text-white text-center">
                <h4>Yeni Şifre Belirle</h4>
            </div>
            <div class="card-body p-4">
                <?php echo $mesaj; ?>

                <?php if (!empty($token)): ?>
                <form method="POST">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Yeni Şifreniz</label>
                        <input type="text" name="sifre" class="form-control" required placeholder="Yeni şifreyi girin">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Şifreyi Güncelle</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>