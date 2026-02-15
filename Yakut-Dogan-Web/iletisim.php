<?php
// sezon kont
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'header.php';
?>

<div class="container mt-5 mb-5">
    
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 20px; min-height: 500px;">
                <div class="row g-0 h-100">
                    
                    <div class="col-md-6 d-none d-md-block" 
                         style="background: url('https://images.unsplash.com/photo-1534536281715-e28d76689b4d?q=80&w=1470&auto=format&fit=crop') no-repeat center center; background-size: cover; min-height: 500px;">
                        
                        <div class="h-100 w-100 d-flex flex-column justify-content-end p-4" 
                             style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                            <h3 class="text-white fw-bold">Size Nasıl Yardımcı Olabiliriz?</h3>
                            <p class="text-white-50">Teknoloji tutkunları için buradayız.</p>
                        </div>
                    </div>

                    <div class="col-md-6 bg-white p-5 d-flex flex-column justify-content-center">
                        
                        <div class="text-center text-md-start mb-4">
                            <h2 class="fw-bold text-primary mb-3">Bize Ulaşın</h2>
                            <p class="text-muted">
                                YakutDoğan olarak 2. el bilgisayar parçalarında güvenin adresiyiz. 
                                Aklınıza takılan her türlü soru için aşağıdaki kanallardan bize ulaşabilirsiniz.
                            </p>
                        </div>

                        <div class="d-flex align-items-center mb-4 p-3 rounded shadow-sm bg-light">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas fa-phone-alt fa-2x"></i>
                            </div>
                            <div>
                                <small class="text-uppercase text-muted fw-bold">Müşteri Hizmetleri</small>
                                <h4 class="mb-0 fw-bold text-dark">+90 (232) 488 84 84</h4>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-4 p-3 rounded shadow-sm bg-light">
                            <div class="bg-warning text-dark rounded-circle p-3 me-3">
                                <i class="fas fa-envelope fa-2x"></i>
                            </div>
                            <div>
                                <small class="text-uppercase text-muted fw-bold">E-Posta Destek</small>
                                <h5 class="mb-0 fw-bold text-dark">destek@yakutdogan.com</h5>
                            </div>
                        </div>

                        <div class="d-flex align-items-center p-3 rounded shadow-sm bg-light">
                            <div class="bg-dark text-white rounded-circle p-3 me-3">
                                <i class="fas fa-map-pin fa-2x"></i>
                            </div>
                            <div>
                                <small class="text-uppercase text-muted fw-bold">Merkez Ofis</small>
                                <p class="mb-0 text-dark small">İzmir Ekonomi Üniversitesi<br>Balçova / İZMİR</p>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <small class="text-muted"><i class="fas fa-clock me-1"></i> Çalışma Saatleri: 09:00 - 18:00</small>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>