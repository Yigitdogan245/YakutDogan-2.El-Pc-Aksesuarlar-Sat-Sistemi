<?php
// sezon knotolu
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'header.php';
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary mb-3">Biz Kimiz?</h2>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">
                    YakutDoğan, teknoloji tutkunlarını bir araya getiren, güvenli ve hızlı bir ikinci el donanım alım-satım platformudur.
                </p>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center p-4">
                        <div class="text-primary mb-3">
                            <i class="fas fa-university fa-3x"></i>
                        </div>
                        <h5 class="fw-bold">Üniversite Projesi</h5>
                        <p class="text-muted small">
                            İzmir Ekonomi Üniversitesi, Bilgisayar Programcılığı bölümü öğrencileri tarafından geliştirilmiş bir dönem projesidir.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center p-4">
                        <div class="text-success mb-3">
                            <i class="fas fa-recycle fa-3x"></i>
                        </div>
                        <h5 class="fw-bold">Sürdürülebilirlik</h5>
                        <p class="text-muted small">
                            Kullanılmayan bilgisayar parçalarını ekonomiye geri kazandırarak elektronik atığı azaltmayı hedefliyoruz.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center p-4">
                        <div class="text-warning mb-3">
                            <i class="fas fa-shield-alt fa-3x"></i>
                        </div>
                        <h5 class="fw-bold">Güvenli Ortam</h5>
                        <p class="text-muted small">
                            Donanım parçalarından anlayan, ne aldığını ve sattığını bilen bilinçli bir topluluk oluşturuyoruz.
                        </p>
                    </div>
                </div>
            </div>

            <div class="card bg-light border-0 rounded-3 p-5">
                <h3 class="fw-bold text-center mb-4">Geliştirici Ekip</h3>
                <div class="row justify-content-center text-center">
                    
                    <div class="col-md-5 mb-3 mb-md-0">
                        <div class="bg-white p-4 rounded shadow-sm">
                            <i class="fas fa-user-graduate fa-2x text-secondary mb-3"></i>
                            <h5 class="fw-bold mb-1">Yiğit Doğan</h5>
                            <p class="text-muted mb-0">Frontend & Tasarım</p>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="bg-white p-4 rounded shadow-sm">
                            <i class="fas fa-code fa-2x text-secondary mb-3"></i>
                            <h5 class="fw-bold mb-1">Ahmet Eren Yakut</h5>
                            <p class="text-muted mb-0">Backend & Veritabanı</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>