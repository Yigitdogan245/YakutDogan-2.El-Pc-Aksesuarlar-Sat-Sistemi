<?php 
    // heder getirme
    include 'header.php'; 

    $mesaj = ""; // Kullanıcıya mesaj gostrme
    
    //post ile php server ogrenme kodi
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
       
        
        
        
        $kullanici_adi = htmlspecialchars(trim($_POST['kullanici_adi']));
        $eposta        = htmlspecialchars(trim($_POST['eposta']));
        $sifre         = htmlspecialchars(trim($_POST['sifre']));
        
        // dogrulama ıslem
        if (empty($kullanici_adi) || empty($eposta) || empty($sifre)) {
            $mesaj = '<div class="alert alert-danger">Lütfen tüm alanları doldurun.</div>';
        } elseif (!filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
            //php e posta kontrol
            $mesaj = '<div class="alert alert-warning">Geçerli bir e-posta adresi girin.</div>';
        } else {
            
        
            
            $mesaj = '<div class="alert alert-success">Kayıt simüle edildi. Kullanıcı: ' . $kullanici_adi . '</div>';
            
            //form verı temızle
            unset($kullanici_adi, $eposta, $sifre);
        }
    }
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="text-center">Kullanıcı Kaydı</h2>
        
        <?php echo $mesaj; //mesaj don?>
        
        <form action="kayit.php" method="POST" class="p-4 border rounded shadow-sm">
            
            <div class="mb-3">
                <label for="kullanici_adi" class="form-label">Kullanıcı Adı</label>
                <input type="text" class="form-control" id="kullanici_adi" name="kullanici_adi" required 
                       value="<?php echo isset($kullanici_adi) ? $kullanici_adi : ''; ?>">
            </div>
            
            <div class="mb-3">
                <label for="eposta" class="form-label">E-Posta</label>
                <input type="email" class="form-control" id="eposta" name="eposta" required 
                       value="<?php echo isset($eposta) ? $eposta : ''; ?>">
            </div>
            
            <div class="mb-3">
                <label for="sifre" class="form-label">Şifre</label>
                <input type="password" class="form-control" id="sifre" name="sifre" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Hemen Kaydol</button>
            
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>