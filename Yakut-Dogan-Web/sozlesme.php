<?php
// sezon baslat
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'header.php';
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white p-4">
                    <h3 class="mb-0"><i class="fas fa-file-contract"></i> Kullanıcı Sözleşmesi ve Gizlilik Politikası</h3>
                </div>
                <div class="card-body p-5 text-secondary">
                    
                    <h5 class="fw-bold text-dark">1. Taraflar</h5>
                    <p>İşbu sözleşme, YakutDoğan 2. El Sistemleri (bundan sonra "Platform" olarak anılacaktır) ile bu platforma üye olan kullanıcı (bundan sonra "Üye" olarak anılacaktır) arasında düzenlenmiştir.</p>

                    <h5 class="fw-bold text-dark mt-4">2. Platformun Sorumlulukları</h5>
                    <p>YakutDoğan, satıcılar ve alıcıları bir araya getiren bir yer sağlayıcıdır. Platform, listelenen ürünlerin kalitesi, güvenliği veya yasallığı konusunda herhangi bir garanti vermez.</p>

                    <hr>

                    <div class="alert alert-warning border-0 shadow-sm text-dark">
                        <h5 class="fw-bold"><i class="fas fa-exclamation-triangle"></i> 3. Takas ve Alışveriş Sorumluluğu (ÖNEMLİ)</h5>
                        <ul class="mb-0">
                            <li class="mb-2"><strong>Takas İşlemleri:</strong> Platform üzerinden yapılan takas (swap) veya nakit alışveriş görüşmeleri tamamen alıcı ve satıcının inisiyatifindedir. Takas sırasında oluşabilecek anlaşmazlıklardan, dolandırıcılık girişimlerinden veya maddi kayıplardan <u>YakutDoğan sorumlu tutulamaz.</u></li>
                            <li><strong>Ürün Kontrolü:</strong> Alıcı, ürünü teslim almadan önce fiziksel ve donanımsal kontrollerini yapmakla yükümlüdür. "Çalışıyor" denilen ancak bozuk çıkan ürünlerde sorumluluk tamamen satıcıya aittir; platform sadece aracı konumundadır.</li>
                        </ul>
                    </div>

                    <h5 class="fw-bold text-dark mt-4">4. Satıcının Yükümlülükleri</h5>
                    <p>Satıcı, listelediği ürünün durumu (Sıfır, Az Kullanılmış, Hasarlı vb.) hakkında doğru bilgi vermekle yükümlüdür. Yanıltıcı görsel veya açıklama kullanılması durumunda, Üye'nin hesabı askıya alınabilir.</p>

                    <h5 class="fw-bold text-dark mt-4">5. Gizlilik</h5>
                    <p>Üyelerin e-posta ve şifre bilgileri şifrelenmiş veritabanlarında saklanmaktadır. Ancak kullanıcı, kendi hesap güvenliğini sağlamakla (şifresini kimseyle paylaşmamakla) yükümlüdür.</p>

                    <h5 class="fw-bold text-dark mt-4">6. Yürürlük</h5>
                    <p>Üye, kayıt formunu doldurup onayladığı andan itibaren bu sözleşmenin tüm maddelerini kabul etmiş sayılır.</p>
                    
                    <div class="text-center mt-5">
                        <button onclick="window.close();" class="btn btn-outline-dark px-5">Pencereyi Kapat</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>