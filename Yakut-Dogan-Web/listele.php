<?php
    // sezon u kontrol eden kod
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    
    // 1. Veritabanını Bağla
    include 'db.php'; 
    include 'header.php'; 

 
    // 2. categoriees veritabanıdan veri çekme kodi
    
    $stmt_cat = $pdo->query("SELECT * FROM categories");
    $kategoriler = $stmt_cat->fetchAll(PDO::FETCH_KEY_PAIR); // ID  İsim seklinde ceker

    // URL'den gelen filtreleri al
    $secilen_kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'hepsi';
    $secilen_durum    = isset($_GET['durum']) ? $_GET['durum'] : 'hepsi';
    $arama_terimi     = isset($_GET['arama']) ? trim($_GET['arama']) : '';

    // Baslık yapma kodi
    if($secilen_kategori != 'hepsi' && isset($kategoriler[$secilen_kategori])) {
        $gosterilen_baslik = $kategoriler[$secilen_kategori];
    } else {
        $gosterilen_baslik = "Tüm Ürünler";
    }

    
    // 3.ürünleri filtreleme sql kodi
    
    
    
    $sql = "SELECT * FROM products WHERE 1=1";
    $params = [];

    
    if ($secilen_kategori != 'hepsi') {
        $sql .= " AND CategoryID = :cat";
        $params[':cat'] = $secilen_kategori;
    }

    
    if ($secilen_durum != 'hepsi') {
        $sql .= " AND Status = :stat";
        $params[':stat'] = $secilen_durum;
    }

     
    if (!empty($arama_terimi)) {
        
        $sql .= " AND (ProductName LIKE :ara_ad OR Description LIKE :ara_desc)";
        $params[':ara_ad']   = "%$arama_terimi%";
        $params[':ara_desc'] = "%$arama_terimi%";
    }

    
    $sql .= " ORDER BY CreatedAt DESC";

    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $urunler = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Veritabanı hatası: " . $e->getMessage() . "</div>";
        $urunler = [];
    }

   
    $durum_secenekleri = [
        'Sıfır Ayarında' => "Sıfır Ayarında",
        'Az Kullanılmış' => "Az Kullanılmış",
        'Hasarlı' => "Hasarlı",
        'Arızalı' => "Arızalı"
    ];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Kategori: <?php echo htmlspecialchars($gosterilen_baslik); ?></h4> 
    <div class="d-flex align-items-center gap-3">
        <span class="text-muted"><?php echo count($urunler); ?> ürün bulundu</span>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">FİLTRELE</div>
            <div class="card-body">
                <form action="listele.php" method="GET">
                    
                    <?php if(!empty($arama_terimi)): ?>
                        <input type="hidden" name="arama" value="<?php echo htmlspecialchars($arama_terimi); ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select class="form-select" name="kategori">
                            <option value="hepsi">Tümü</option>
                            <?php foreach ($kategoriler as $id => $ad): ?>
                                <option value="<?php echo $id; ?>" <?php if($secilen_kategori == $id) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($ad); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Durum</label>
                        <select class="form-select" name="durum">
                            <option value="hepsi">Tümü</option>
                            <?php foreach ($durum_secenekleri as $key => $value): ?>
                                <option value="<?php echo $key; ?>" <?php if($secilen_durum == $key) echo 'selected'; ?>>
                                    <?php echo $value; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 mt-3">Uygula</button>
                    
                    <?php if($secilen_kategori != 'hepsi' || $secilen_durum != 'hepsi' || !empty($arama_terimi)): ?>
                        <a href="listele.php" class="btn btn-outline-secondary w-100 mt-2">Filtreyi Temizle</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            
            <?php if(empty($urunler)): ?>
                <div class="col-12">
                    <div class="alert alert-warning">
                        Aradığınız kriterlere uygun ürün bulunamadı. <a href="listele.php">Tüm ürünleri gör.</a>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php foreach ($urunler as $urun): ?>
            
            <?php 
                $cookie_sepet = isset($_COOKIE['sepet']) ? json_decode($_COOKIE['sepet'], true) : [];
                $sepette_var_mi = in_array($urun['ProductID'], $cookie_sepet);
            ?>

            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div style="height: 200px; display: flex; align-items: center; justify-content: center; background-color: #fff; border-bottom: 1px solid #eee; overflow: hidden;">
                        <?php 
                            $resimDosyasi = !empty($urun['ImagePath']) ? "Parcalar/" . $urun['ImagePath'] : "https://via.placeholder.com/200?text=Resim+Yok";
                        ?>
                        <img src="<?php echo htmlspecialchars($resimDosyasi); ?>" 
                             class="card-img-top" 
                             alt="<?php echo htmlspecialchars($urun['ProductName']); ?>" 
                             style="max-height: 100%; max-width: 100%; object-fit: contain; padding: 10px;">
                    </div>
                    
                    <div class="card-body">
                        <h6 class="card-title text-truncate" title="<?php echo htmlspecialchars($urun['ProductName']); ?>">
                            <?php echo htmlspecialchars($urun['ProductName']); ?>
                        </h6>
                        
                        <p class="mb-1">
                            <?php if($urun['IsSold'] == 1): ?>
                                <span class="badge bg-danger fs-5">SATILDI</span>
                            <?php else: ?>
                                <span class="fs-5 fw-bold text-danger">
                                    <?php echo number_format($urun['Price'], 2, ',', '.'); ?> TL
                                </span>
                            <?php endif; ?>
                        </p>
                        
                        <p class="mb-1">
                            <span class="badge bg-info text-dark">
                                <?php echo htmlspecialchars($urun['Status']); ?>
                            </span>
                        </p>
                        
                        <p class="small text-muted mb-1">
                            <i class="far fa-clock"></i> <?php echo date("d.m.Y", strtotime($urun['CreatedAt'])); ?>
                        </p>
                        
                        <div class="mb-3">
                            <?php if ($urun['IsSwapAvailable']): ?>
                                <span class="badge bg-success"><i class="fas fa-check"></i> Takas Olur</span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><i class="fas fa-times"></i> Takas Yok</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="d-flex gap-2 mt-2">
                            <a href="urun_detay.php?id=<?php echo $urun['ProductID']; ?>" class="btn btn-outline-primary w-50 btn-sm">
                                İncele
                            </a>
                            
                            <?php if($urun['IsSold'] == 0): ?>
                                <?php if($sepette_var_mi): ?>
                                    <a href="sepet.php" class="btn btn-success w-50 btn-sm">
                                        <i class="fas fa-check"></i> Sepette
                                    </a>
                                <?php else: ?>
                                    <a href="sepet_islem.php?islem=ekle&id=<?php echo $urun['ProductID']; ?>" class="btn btn-outline-secondary w-50 btn-sm">
                                        <i class="fas fa-cart-plus"></i> Ekle
                                    </a>
                                <?php endif; ?>
                            <?php else: ?>
                                <button class="btn btn-light w-50 btn-sm text-muted" disabled>Tükendi</button>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>