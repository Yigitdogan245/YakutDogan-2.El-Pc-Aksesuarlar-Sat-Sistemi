<?php
session_start();
include 'db.php';

// gırıs kontrol et yoksa gerı at
if (!isset($_SESSION['kullanici_id'])) {
    header("Location: index.php");
    exit;
}

if (isset($_GET['islem']) && isset($_GET['id'])) {
    $islem = $_GET['islem'];
    $urun_id = intval($_GET['id']);
    $user_id = $_SESSION['kullanici_id'];

    

    if ($islem == 'sil') {
        
        $stmt_img = $pdo->prepare("SELECT ImagePath FROM products WHERE ProductID = :pid AND UserID = :uid");
        $stmt_img->execute([':pid' => $urun_id, ':uid' => $user_id]);
        $img = $stmt_img->fetchColumn();

        // 2. sql silme islemi
        $sql = "DELETE FROM products WHERE ProductID = :pid AND UserID = :uid";
        $stmt = $pdo->prepare($sql);
        $sonuc = $stmt->execute([':pid' => $urun_id, ':uid' => $user_id]);

        if ($sonuc && $img && file_exists("Parcalar/$img")) {
            unlink("Parcalar/$img"); // resmı kloserden sılme
        }
        $msg = "İlan başarıyla silindi.";

    } elseif ($islem == 'satildi') {
        // durumu satıldı yap
        $sql = "UPDATE products SET IsSold = 1 WHERE ProductID = :pid AND UserID = :uid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':pid' => $urun_id, ':uid' => $user_id]);
        $msg = "Ürün SATILDI olarak güncellendi.";

    } elseif ($islem == 'yayina_al') {
        // durumu yayında yap
        $sql = "UPDATE products SET IsSold = 0 WHERE ProductID = :pid AND UserID = :uid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':pid' => $urun_id, ':uid' => $user_id]);
        $msg = "Ürün tekrar satışa çıkarıldı.";
    }
}

// ılanlara don
header("Location: ilanlarim.php?mesaj=" . urlencode($msg));
exit;
?>