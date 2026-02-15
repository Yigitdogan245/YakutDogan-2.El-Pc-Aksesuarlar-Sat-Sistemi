<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'db.php';
include 'header.php';

// misaafir ile girenleri kontrol etme kodu
if (!isset($_SESSION['kullanici_id'])) {
    echo '<div class="container mt-5"><div class="alert alert-warning text-center">
            <h4><i class="fas fa-lock"></i> Erişim Engellendi</h4>
            <p>Sepetinizi görüntülemek için giriş yapmalısınız.</p>
            <a href="giris.php" class="btn btn-primary">Giriş Yap</a>
          </div></div>';
    include 'footer.php';
    exit;
}

$user_id = $_SESSION['kullanici_id'];

// databse den cart tablosu ile kullanıcya ait sepeti çekme kodu SQL
$sql = "SELECT p.* FROM cart c 
        JOIN products p ON c.ProductID = p.ProductID 
        WHERE c.UserID = :uid";
$stmt = $pdo->prepare($sql);
$stmt->execute([':uid' => $user_id]);
$sepet_urunleri = $stmt->fetchAll();

// tutarı hesapla sepettekı
$toplam = 0;
foreach($sepet_urunleri as $u) { $toplam += $u['Price']; }
?>

<div class="container mt-5 mb-5" style="min-height: 500px;">
    <h2 class="mb-4"><i class="fas fa-shopping-cart"></i> Sepetim</h2>

    <?php if (empty($sepet_urunleri)): ?>
        <div class="alert alert-info text-center p-5">
            <h4>Sepetiniz şu an boş.</h4>
            <p class="text-muted">İlgilendiğiniz ürünleri ekleyerek burada saklayabilirsiniz.</p>
            <a href="listele.php" class="btn btn-outline-primary mt-3">Alışverişe Dön</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <ul class="list-group list-group-flush">
                        <?php foreach ($sepet_urunleri as $urun): ?>
                        <li class="list-group-item p-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <?php $resim = !empty($urun['ImagePath']) ? "Parcalar/" . $urun['ImagePath'] : "https://via.placeholder.com/100"; ?>
                                    <img src="<?php echo $resim; ?>" width="80" class="rounded border">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1 fw-bold"><?php echo htmlspecialchars($urun['ProductName']); ?></h5>
                                    
                                    <?php if($urun['Status'] == 'Satıldı'): ?>
                                        <span class="badge bg-danger">Satıldı</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Stokta</span>
                                    <?php endif; ?>
                                </div>
                                <div class="text-end">
                                    <h5 class="fw-bold text-primary"><?php echo number_format($urun['Price'], 0, ',', '.'); ?> TL</h5>
                                    <a href="sepet_islem.php?islem=sil&id=<?php echo $urun['ProductID']; ?>" 
                                       class="btn btn-sm btn-outline-danger mt-2"
                                       title="Sepetten Kaldır">
                                        <i class="fas fa-trash"></i> Sil
                                    </a>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light border-0 p-4 shadow-sm">
                    <h4 class="fw-bold text-dark border-bottom pb-3">Sipariş Özeti</h4>
                    
                    <div class="d-flex justify-content-between align-items-center my-3">
                        <span class="fs-5">Ara Toplam:</span>
                        <span class="fs-4 fw-bold text-success"><?php echo number_format($toplam, 2, ',', '.'); ?> TL</span>
                    </div>
                    
                    <div class="alert alert-warning small border-0 shadow-sm mt-3">
                        <i class="fas fa-info-circle"></i> Ödeme ve teslimat işlemleri için satıcı ile iletişime geçiniz.
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>