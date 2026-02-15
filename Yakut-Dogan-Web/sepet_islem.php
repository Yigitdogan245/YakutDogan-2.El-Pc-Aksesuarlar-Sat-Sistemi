<?php
session_start();
include 'db.php';

// eğer misafir ise yani girş yapmadıysa kısıtla ve geri don
if (!isset($_SESSION['kullanici_id'])) {
    $_SESSION['bildirim'] = '<div class="alert alert-warning">Sepeti kullanmak için lütfen giriş yapınız.</div>';
    header("Location: giris.php");
    exit;
}

$user_id = $_SESSION['kullanici_id'];

if (isset($_GET['islem']) && isset($_GET['id'])) {
    
    $islem = $_GET['islem'];
    $urun_id = intval($_GET['id']);
    
    // database insert ıslemi
    if ($islem == 'ekle') {
        try {
            $sql = "INSERT INTO cart (UserID, ProductID) VALUES (:uid, :pid)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':uid' => $user_id, ':pid' => $urun_id]);
            header("Location: listele.php?durum=eklendi");
        } catch (PDOException $e) {
            // zaten insertli ise geri don
            header("Location: listele.php?durum=zaten_var");
        }
    }
    
    // database delete ıslemı 
    elseif ($islem == 'sil') {
        $sql = "DELETE FROM cart WHERE UserID = :uid AND ProductID = :pid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':uid' => $user_id, ':pid' => $urun_id]);
        
        // sepet sayfasına don
        header("Location: sepet.php?durum=silindi");
    }
} else {
    header("Location: listele.php");
}
?>