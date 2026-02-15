<?php
//AI ILE VERITABANI GENEL BAGLANTI PHP DOSYASI

$host = "localhost";
$dbname = "YakutDoganDB";
$charset = "utf8mb4"; 


$username = "root"; 
$password = "root"; 

try {
    
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,      
        PDO::ATTR_EMULATE_PREPARES   => false,                 
    ];

    
    $pdo = new PDO($dsn, $username, $password, $options);

    

} catch (\PDOException $e) {
    
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
