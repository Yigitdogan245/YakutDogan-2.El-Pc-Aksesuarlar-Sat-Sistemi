<?php
// Session başlatma 
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// 1. Veritabanı bağlantısı
include 'db.php'; 

// Giriş yapmamışsa bu sayfayı göremez, giriş sayfasına atar.
if (!isset($_SESSION['kullanici_id'])) {
    header("Location: giris.php");
    exit;
}

include 'header.php'; 

$mesaj = "";

// 2. form gönderme işlemi 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // veri al ve temizle
    $urun_adi    = htmlspecialchars(trim($_POST['urun_adi']));
    $kategori_id = intval($_POST['kategori_id']); 
    $fiyat       = floatval($_POST['fiyat']); 
    $durum       = htmlspecialchars($_POST['durum']);
    $aciklama    = htmlspecialchars(trim($_POST['aciklama']));
    $takas       = isset($_POST['takas']) ? 1 : 0; // Checkbox işaretliyse 1, değilse 0
    $user_id     = $_SESSION['kullanici_id']; // Şu an giriş yapmış olan kişi

    // 3.resim yükleme
    $resim_yolu = ""; // 
    
    // Klasör yoksa oluştur hatadan kaçınma için
    if (!file_exists('Parcalar')) { mkdir('Parcalar', 0777, true); }

    if (isset($_FILES['resim']) && $_FILES['resim']['error'] == 0) {
        $izinli_uzantilar = ['jpg', 'jpeg', 'png', 'webp'];
        $dosya_adi = $_FILES['resim']['name'];
        $uzanti = strtolower(pathinfo($dosya_adi, PATHINFO_EXTENSION));

        if (in_array($uzanti, $izinli_uzantilar)) {
            // Dosya ismini benzersiz yapma cakısma olmamasi için
            $yeni_ad = uniqid("urun_") . "." . $uzanti;
            $hedef = "Parcalar/" . $yeni_ad;

            if (move_uploaded_file($_FILES['resim']['tmp_name'], $hedef)) {
                $resim_yolu = $yeni_ad; // Veritabanına isim kaydetme
            } else {
                $mesaj = '<div class="alert alert-danger">Resim yüklenirken bir hata oluştu.</div>';
            }
        } else {
            $mesaj = '<div class="alert alert-warning">Sadece JPG, PNG ve WEBP formatları kabul edilir.</div>';
        }
    }

    // Hata yoksa veritabanına kayıt etme kosulu
    if (empty($mesaj)) {
        try {
            $sql = "INSERT INTO products (UserID, CategoryID, ProductName, Price, Description, Status, ImagePath, IsSwapAvailable) 
                    VALUES (:uid, :cid, :pname, :price, :desc, :stat, :img, :swap)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':uid' => $user_id,
                ':cid' => $kategori_id,
                ':pname' => $urun_adi,
                ':price' => $fiyat,
                ':desc' => $aciklama,
                ':stat' => $durum,
                ':img' => $resim_yolu,
                ':swap' => $takas
            ]);

            $mesaj = '<div class="alert alert-success">Ürün başarıyla listelendi!</div>';
            
        } catch (PDOException $e) {
            $mesaj = '<div class="alert alert-danger">Veritabanı hatası: ' . $e->getMessage() . '</div>';
        }
    }
}

// 4. veri tabanı categories e bağlanıp veri çekme

$stmt_kat = $pdo->query("SELECT * FROM categories");
$kategoriler_db = $stmt_kat->fetchAll();


$durumlar = ["Sıfır Ayarında", "Az Kullanılmış", "Hasarlı", "Arızalı"];
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <h2 class="text-center mb-4">Yeni Ürün Listele</h2>
        
        <?php echo $mesaj; ?>

        <form action="urun_ekle.php" method="POST" class="p-4 border rounded shadow-sm" enctype="multipart/form-data">
            
            <div class="mb-3">
                <label for="urun_adi" class="form-label">Ürün Adı *</label>
                <input type="text" class="form-control" id="urun_adi" name="urun_adi" required placeholder="Örn: MSI RTX 3060 Ekran Kartı">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kategori" class="form-label">Kategori *</label>
                    <select class="form-select" id="kategori" name="kategori_id" required>
                        <option value="">Kategori Seçiniz</option>
                        <?php foreach ($kategoriler_db as $kat): ?>
                            <option value="<?php echo $kat['CategoryID']; ?>">
                                <?php echo htmlspecialchars($kat['CategoryName']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="fiyat" class="form-label">Fiyat (TL) *</label>
                    <input type="number" class="form-control" id="fiyat" name="fiyat" step="0.01" required placeholder="0.00">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="durum" class="form-label">Ürün Durumu *</label>
                    <select class="form-select" id="durum" name="durum" required>
                        <option value="">Durum Seçiniz</option>
                        <?php foreach ($durumlar as $d): ?>
                            <option value="<?php echo $d; ?>"><?php echo $d; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="resim" class="form-label">Ürün Resmi</label>
                    <input type="file" class="form-control" id="resim" name="resim"> 
                    <div class="form-text text-muted">Desteklenen: JPG, PNG.</div>
                </div>
            </div>

            <div class="mb-3">
                <label for="aciklama" class="form-label">Açıklama</label>
                <textarea class="form-control" id="aciklama" name="aciklama" rows="4" placeholder="Ürünün özelliklerinden bahsedin..."></textarea>
            </div>
            
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" value="1" id="takas" name="takas">
                <label class="form-check-label" for="takas">
                    Takas tekliflerine açığım.
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">İlanı Yayınla</button>
            
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>