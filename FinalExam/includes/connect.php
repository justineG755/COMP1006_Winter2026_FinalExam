<!-- CONNECTING TO DATABASE -->
<?php 
$host = "172.31.22.43"; //hostname
$db = "Justine200641794"; //database name
$user = "Justine200641794"; //username
$password = "xQ8rUyrUlg"; //password

//points to the database
$dsn = "mysql:host=$host;dbname=$db";

//try to connect, if connected echo a yay!
try {
   $pdo = new PDO ($dsn, $user, $password); 
   $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
}
//stop and error message if not connected
catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage()); 
}
?>