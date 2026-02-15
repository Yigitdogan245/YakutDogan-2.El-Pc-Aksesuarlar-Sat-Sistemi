<?php
// sezon basla
session_start();

//hafızadakı sezon bılgılerını sıl
$_SESSION = array();

// oturumu tamamen parcala yok et
session_destroy();

// kullanıcıyı baslangıc sayfasına fırlat kodı
header("Location: index.php");
exit;
?>