<?php
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    include_once 'db.php'; // db baglantı

    // sepet sayı bel
    $sepet_sayisi = 0;
    if (isset($_SESSION['kullanici_id'])) {
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM cart WHERE UserID = :uid");
            $stmt->execute([':uid' => $_SESSION['kullanici_id']]);
            $sepet_sayisi = $stmt->fetchColumn();
        } catch (Exception $e) { $sepet_sayisi = 0; }
    }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YakutDoğan | 2. El Sistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <style>
        .urun-karti { border: 1px solid #ccc; padding: 10px; margin-bottom: 20px; }
        .resim-alani { background-color: #eee; height: 150px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; border: 1px solid #999; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">
        <i class="fas fa-desktop text-primary"></i> YAKUTDOĞAN
    </a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      
      <form class="d-flex mx-auto" style="width: 45%;" action="listele.php" method="GET">
        <div class="input-group">
            <input class="form-control" type="search" name="arama" 
                   placeholder="Marka, model veya ürün ara..." 
                   value="<?php echo isset($_GET['arama']) ? htmlspecialchars($_GET['arama']) : ''; ?>">
            <button class="btn btn-primary" type="submit">Ara</button>
        </div>
      </form>

      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
        
        <?php if (isset($_SESSION['kullanici_id'])): // gırıs kontrol ?>
            
            <li class="nav-item me-2">
                <?php if (isset($_SESSION['kullanici_adi']) && $_SESSION['kullanici_adi'] == 'admin'): ?>
                    <a class="nav-link btn btn-danger btn-sm text-white px-3" href="admin.php">
                        <i class="fas fa-user-shield"></i> Yönetici
                    </a>
                <?php else: ?>
                    <a class="nav-link btn btn-secondary btn-sm text-white px-3" href="#" 
                       style="opacity: 0.6; cursor: not-allowed;"
                       onclick="alert('⛔ Yetkiniz Yok!\nSadece yönetici giriş yapabilir.'); return false;">
                        <i class="fas fa-lock"></i> Yönetici
                    </a>
                <?php endif; ?>
            </li>

            <li class="nav-item me-2">
                <a class="nav-link" href="bildirimler.php"><i class="fas fa-bell fa-lg text-secondary"></i></a>
            </li>

            <li class="nav-item me-2">
                <span class="nav-link text-dark fw-bold">Merhaba, <?php echo htmlspecialchars($_SESSION['kullanici_adi']); ?></span>
            </li>
            
            <li class="nav-item"><a class="nav-link" href="iletisim.php">İletişim</a></li>
            <li class="nav-item"><a class="nav-link" href="urun_ekle.php">Ürün Ekle</a></li>
            <li class="nav-item"><a class="nav-link" href="ilanlarim.php">İlanlarım</a></li>
            <li class="nav-item"><a class="nav-link btn btn-outline-danger btn-sm ms-2" href="cikis.php">Çıkış</a></li>

            <li class="nav-item ms-3">
                <a class="btn btn-outline-success position-relative" href="sepet.php">
                    <i class="fas fa-shopping-cart me-1"></i> Sepetim
                    <?php if($sepet_sayisi > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php echo $sepet_sayisi; ?>
                        </span>
                    <?php endif; ?>
                </a>
            </li>
            
        <?php else: // mısafır moduna gec ?>
            <li class="nav-item"><a class="nav-link" href="iletisim.php">İletişim</a></li>
            <li class="nav-item"><a class="nav-link" href="kaydol.php">Kaydol</a></li>
            <li class="nav-item"><a class="nav-link" href="giris.php">Giriş</a></li>

            <li class="nav-item ms-3">
                <a class="btn btn-outline-secondary" href="#" onclick="alert('⚠️ Sepeti kullanabilmek için lütfen giriş yapınız!'); window.location.href='giris.php'; return false;">
                    <i class="fas fa-shopping-cart me-1"></i> Sepetim
                </a>
            </li>
        <?php endif; ?>
        
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">