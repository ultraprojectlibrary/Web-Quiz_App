<?php
session_start();
include ('./conn/conn.php');
$conn = getPDOConnection();

$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        // Prepare query
        $stmt = $conn->prepare("SELECT * FROM admin_detail WHERE admin_username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify the password against stored hash
            if ($password === $user['admin_password']) {
                $_SESSION['user'] = $user['admin_username'];
                header("Location: teacher.php");
                exit;
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>AdminLogin</title>
    <link rel="stylesheet" href="assets/qstyles.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="body2">

    <div class="login-form">
        <form action="" method="post">
            <h4 style="color:white; text align:center">Admin Login_Page</h4>
            <br><br>
            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <input type="text" name="username" placeholder="Username" required>
            <br>
            <input type="password" name="password" placeholder="Password" required>
            <br>
            <button type="submit" class="btn">Login</button>
        </form>
        
    </div>

</body>
</html>

