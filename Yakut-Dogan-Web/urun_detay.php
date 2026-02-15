<?php
// 1. sezon ve veri tabanı bağlantısı açma
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'db.php'; 
include 'header.php'; 

// 2. linkteki id yi yakalama işlemi
// kontrol kosulu
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>window.location.href='listele.php';</script>";
    exit;
}

$urun_id = intval($_GET['id']); // Gelen sayıyı al (Güvenlik için intval)

// 3. veritabanında ürün tablosunda veri çekme
// JOIN sorgusu işlemi kullanma ile veri çekme
$sql = "SELECT p.*, u.Username, u.Email, c.CategoryName 
        FROM products p 
        JOIN users u ON p.UserID = u.UserID 
        JOIN categories c ON p.CategoryID = c.CategoryID
        WHERE p.ProductID = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $urun_id]);
$urun = $stmt->fetch();

// ürün varlılğı kontrolu
if (!$urun) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Aradığınız ürün bulunamadı.</div></div>";
    include 'footer.php';
    exit;
}
?>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm p-3">
                <?php 
                    // resim var ise yok ise kontrol
                    $resimYolu = !empty($urun['ImagePath']) ? "Parcalar/" . $urun['ImagePath'] : "https://via.placeholder.com/600x400?text=Resim+Yok";
                ?>
                <img src="<?php echo htmlspecialchars($resimYolu); ?>" 
                     class="img-fluid rounded" 
                     alt="Ürün Resmi" 
                     style="width: 100%; max-height: 500px; object-fit: contain;">
            </div>
        </div>

        <div class="col-md-6">
            <h4 class="text-muted"><?php echo htmlspecialchars($urun['CategoryName']); ?></h4>
            <h1 class="fw-bold mb-3"><?php echo htmlspecialchars($urun['ProductName']); ?></h1>
            
            <h2 class="text-danger fw-bold display-6 mb-4">
                <?php echo number_format($urun['Price'], 2, ',', '.'); ?> TL
            </h2>

            <div class="mb-4">
                <span class="badge bg-info text-dark p-2 fs-6">
                    <i class="fas fa-tag"></i> <?php echo htmlspecialchars($urun['Status']); ?>
                </span>
                <?php if ($urun['IsSwapAvailable']): ?>
                    <span class="badge bg-success p-2 fs-6 ms-2">
                        <i class="fas fa-sync-alt"></i> Takas Olur
                    </span>
                <?php else: ?>
                    <span class="badge bg-secondary p-2 fs-6 ms-2">Takas Yok</span>
                <?php endif; ?>
            </div>

            <hr>

            <div class="card bg-light mb-4 border-0">
                <div class="card-body">
                    <h5 class="card-title fw-bold"><i class="fas fa-user-circle"></i> Satıcı Bilgileri</h5>
                    <p class="mb-1 fs-5"><?php echo htmlspecialchars($urun['Username']); ?></p>
                    <p class="mb-0 text-muted small">
                        İlan Tarihi: <?php echo date("d.m.Y", strtotime($urun['CreatedAt'])); ?>
                    </p>
                </div>
            </div>

            <h5 class="fw-bold">Ürün Açıklaması:</h5>
            <div class="p-3 border rounded bg-white mb-4">
                <p class="mb-0" style="white-space: pre-line; color: #555;">
                    <?php echo htmlspecialchars($urun['Description']); ?>
                </p>
            </div>

            <div class="d-grid gap-2">
                <a href="mailto:<?php echo htmlspecialchars($urun['Email']); ?>?subject=<?php echo urlencode($urun['ProductName']); ?> İlanı Hakkında" class="btn btn-primary btn-lg">
                    <i class="fas fa-envelope me-2"></i> Satıcıya E-Posta Gönder
                </a>
                
                <a href="listele.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Listeye Geri Dön
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>