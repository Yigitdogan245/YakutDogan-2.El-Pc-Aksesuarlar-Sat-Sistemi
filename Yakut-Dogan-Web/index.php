<?php 
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    include 'header.php'; 
?>

<div class="p-5 mb-4 bg-light rounded-3 border shadow-sm text-center">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold text-primary">YakutDoğan 2. El Sistemleri</h1>
        <p class="col-md-8 fs-4 mx-auto mt-3">
            Bilgisayar parçalarınızı güvenle satabileceğiniz, ihtiyacınız olan donanımları 
            uygun fiyata bulabileceğiniz İzmir'in en güvenilir platformuna hoş geldiniz.
        </p>
        
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="listele.php" class="btn btn-primary btn-lg px-5 gap-3">
                <i class="fas fa-search"></i> Ürünleri İncele
            </a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>