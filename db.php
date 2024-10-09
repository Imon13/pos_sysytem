<?php
$host = 'localhost';  
$dbname = 'Pos_manegment_system';  
$username = 'root';  
$password = '';  

try {
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
   
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
    
} catch (PDOException $e) {
    
    echo "Database connection failed: " . $e->getMessage();
    exit;
}

?>
