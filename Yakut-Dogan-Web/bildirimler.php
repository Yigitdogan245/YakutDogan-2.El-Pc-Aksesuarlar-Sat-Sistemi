<?php
//GENEL NOT BURASI TAM ISLEVLI CALISMAMAKTADIR KAPSAM DISINI ALINMISTIR 
// sezon baslat
if (session_status() === PHP_SESSION_NONE) { session_start(); }


include 'header.php';
?>

<div class="container mt-5" style="min-height: 400px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="mb-4"><i class="fas fa-bell text-warning"></i> Bildirimlerim</h3>
            
            <div class="card shadow-sm">
                <div class="card-body text-center p-5">
                    <i class="far fa-envelope-open fa-4x text-muted mb-3"></i>
                    <h5 class="card-title">Henüz yeni bir bildiriminiz yok.</h5>
                    <p class="card-text text-muted">
                        Alım-satım işlemleri veya hesap hareketleriniz olduğunda burada göreceksiniz.
                    </p>
                    <a href="listele.php" class="btn btn-primary mt-3">Alışverişe Başla</a>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>