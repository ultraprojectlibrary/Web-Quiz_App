
<?php
function getPDOConnection() {
    $host = 'localhost';    // Database server name (usually 'localhost' on local machine)
    $dbname = 'QUIZ_APP';   // The name of your database
    $username = 'root';     // Database username (default for XAMPP/MAMP/WAMP)
    $password = '';         // Database password (empty by default on XAMPP)

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    
    } catch (PDOException $e) {
        // If connection fails, catch the exception and show error message
        die("Connection failed: " . $e->getMessage());
    }
}
?>
