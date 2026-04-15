<?php
require "includes/connect.php";

try {


    $pdo->exec("
        CREATE TABLE IF NOT EXISTS photo_storage (
            id INT AUTO_INCREMENT PRIMARY KEY,  
            photo_name VARCHAR(100),
            photo VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    echo "Tables created successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>