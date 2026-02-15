<?php
// sezon kont ve bagnatı
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'db.php';
include 'header.php';

// giris yapmadıysa anasayfaya at
if (!isset($_SESSION['kullanici_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['kullanici_id'];

// users dan veri cek db
$sql = "SELECT * FROM products WHERE UserID = :uid ORDER BY CreatedAt DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([':uid' => $user_id]);
$ilanlar = $stmt->fetchAll();
?>

<div class="container mt-5 mb-5">
    <h2 class="mb-4">İlan Yönetim Paneli</h2>

    <?php if (isset($_GET['mesaj'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['mesaj']); ?></div>
    <?php endif; ?>

    <?php if (count($ilanlar) == 0): ?>
        <div class="alert alert-warning">
            Henüz hiç ilan vermediniz. <a href="urun_ekle.php">Hemen Satışa Başla!</a>
        </div>
    <?php else: ?>
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Ürün Görseli</th>
                            <th>Ürün Adı</th>
                            <th>Fiyat</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ilanlar as $ilan): ?>
                        <tr class="<?php echo $ilan['IsSold'] ? 'table-secondary' : ''; ?>">
                            <td style="width: 100px;">
                                <?php $resim = !empty($ilan['ImagePath']) ? "Parcalar/" . $ilan['ImagePath'] : "https://via.placeholder.com/100"; ?>
                                <img src="<?php echo $resim; ?>" alt="Ürün" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                            </td>
                            <td class="fw-bold">
                                <?php echo htmlspecialchars($ilan['ProductName']); ?>
                                <br>
                                <small class="text-muted text-truncate" style="max-width: 200px; display:inline-block;">
                                    <?php echo htmlspecialchars($ilan['Description']); ?>
                                </small>
                            </td>
                            <td><?php echo number_format($ilan['Price'], 0, ',', '.'); ?> TL</td>
                            <td>
                                <?php if ($ilan['IsSold'] == 1): ?>
                                    <span class="badge bg-danger">SATILDI</span>
                                <?php else: ?>
                                    <span class="badge bg-success">YAYINDA</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    
                                    <?php if ($ilan['IsSold'] == 0): ?>
                                        <a href="ilan_islem.php?islem=satildi&id=<?php echo $ilan['ProductID']; ?>" 
                                           class="btn btn-outline-secondary" title="Satıldı Olarak İşaretle">
                                            <i class="fas fa-handshake"></i> Satıldı Yap
                                        </a>
                                    <?php else: ?>
                                        <a href="ilan_islem.php?islem=yayina_al&id=<?php echo $ilan['ProductID']; ?>" 
                                           class="btn btn-outline-success" title="Tekrar Yayına Al">
                                            <i class="fas fa-undo"></i> Yayına Al
                                        </a>
                                    <?php endif; ?>

                                    <a href="ilan_islem.php?islem=sil&id=<?php echo $ilan['ProductID']; ?>" 
                                       class="btn btn-danger" 
                                       onclick="return confirm('Bu ilanı tamamen silmek istediğinize emin misiniz?');">
                                        <i class="fas fa-trash"></i> Sil
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>