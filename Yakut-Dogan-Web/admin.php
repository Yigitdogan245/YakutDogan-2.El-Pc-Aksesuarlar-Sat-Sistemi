<?php
// sezon baglantı kodı
session_start(); 
include 'db.php'; 

//guvenlık kontrol sadece admın sıfrelı gormesını saglayan kod
if (!isset($_SESSION['kullanici_adi']) || $_SESSION['kullanici_adi'] !== 'admin') {
    header("Location: index.php"); // eger yetkısınse fırlat kısıyı
    exit; 
}

// bılgılerı cekme sıteyle ılgılı
$stmt_urun = $pdo->prepare("SELECT COUNT(*) FROM products");
$stmt_urun->execute();
$toplam_urun = $stmt_urun->fetchColumn(); 

$stmt_uye = $pdo->prepare("SELECT COUNT(*) FROM users");
$stmt_uye->execute();
$toplam_uye = $stmt_uye->fetchColumn();

// urunlerı lıstleme sql 
$sql_listele = "SELECT products.*, users.Username 
                FROM products 
                JOIN users ON products.UserID = users.UserID 
                ORDER BY products.CreatedAt DESC"; 
$stmt_liste = $pdo->prepare($sql_listele);
$stmt_liste->execute();
$urunler = $stmt_liste->fetchAll(PDO::FETCH_ASSOC); 
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetici Paneli | YakutDoğan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .admin-header { background: #dc3545; color: white; } 
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark admin-header mb-4 shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="admin.php">
        <i class="fas fa-user-shield me-2"></i> Yönetici Paneli
    </a>
    <div class="d-flex align-items-center">
        <span class="text-white me-3">Hoşgeldin, Admin</span>
        <a href="index.php" class="btn btn-light btn-sm fw-bold text-danger">Siteye Dön</a>
    </div>
  </div>
</nav>

<div class="container">
    
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-white bg-primary mb-3 shadow h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <h5 class="card-title"><i class="fas fa-box-open fa-2x mb-2"></i><br>Toplam Ürün</h5>
                    <p class="card-text display-4 fw-bold mb-0"><?php echo $toplam_urun; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-success mb-3 shadow h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <h5 class="card-title"><i class="fas fa-users fa-2x mb-2"></i><br>Toplam Üye</h5>
                    <p class="card-text display-4 fw-bold mb-0"><?php echo $toplam_uye; ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['mesaj']) && $_GET['mesaj'] == 'silindi'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> İlan başarıyla silindi.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i> Yayındaki İlanlar</h5>
            <small>En yeniden eskiye sıralanmıştır</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="80">Görsel</th>
                            <th>Ürün Adı</th>
                            <th>Fiyat</th>
                            <th>Satıcı</th>
                            <th>Durum</th>
                            <th width="100">İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($urunler) > 0): ?>
                            <?php foreach ($urunler as $urun): ?>
                            <tr>
                                <td class="text-center">
                                    <?php 
                                        $resimYolu = !empty($urun['ImagePath']) ? "Parcalar/" . $urun['ImagePath'] : "assets/no-image.png";
                                    ?>
                                    <img src="<?php echo htmlspecialchars($resimYolu); ?>" 
                                         width="50" height="50" 
                                         style="object-fit: cover; border-radius: 5px; border: 1px solid #ddd;"
                                         alt="Ürün">
                                </td>
                                <td class="fw-bold text-primary">
                                    <?php echo htmlspecialchars($urun['ProductName']); ?>
                                </td>
                                <td>
                                    <?php echo number_format($urun['Price'], 0, ',', '.'); ?> TL
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($urun['Username']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if($urun['Status'] == 'Satıldı'): ?>
                                        <span class="badge bg-danger">Satıldı</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Satışta</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="admin_sil.php?id=<?php echo $urun['ProductID']; ?>" 
                                       class="btn btn-outline-danger btn-sm"
                                       onclick="return confirm('BU İLANI KALICI OLARAK SİLMEK İSTEDİĞİNİZE EMİN MİSİNİZ?');">
                                        <i class="fas fa-trash-alt"></i> Sil
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Henüz hiç ilan eklenmemiş.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>