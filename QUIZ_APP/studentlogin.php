




<?php
session_start();
include('./conn/conn.php');
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
        $stmt = $conn->prepare("SELECT * FROM user_detail WHERE user_name = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

       if ($user) {
            if ($user['quiz_taken'] == 1) {
                $error = "You have already taken the quiz. Login disabled.";
            } elseif ($password === $user['user_password']) {
                $_SESSION['user'] = $user['user_name'];
                $_SESSION['fullname'] = $user['user_fullname']; // ✅ store fullname
                header("Location: student.php");
                exit;
            } else {
                $error = "Invalid password.";
            }
        }
        else {
            $error = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <link rel="stylesheet" href="assets/qstyles.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="body2">

    <div class="login-form">
        <form action="" method="post">
            <h1 style="color:whitesmoke; text-align:center;">Welcome Student</h1><br>
            <p style="color:whitesmoke;">Welcome back! Please kindly enter your details</p>
            <br>
            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <input type="text" name="username" placeholder="Username" required>
            <br>
            <input type="password" name="password" placeholder="Password" required>
            <br>
            <button style="width:100%" type="submit" class="btn">Login</button><br>
        </form><br>
        <p style="color:white">Don't have an account? 
            <a style="color:white ;font-weight:bold" href="studentreg.php">Sign Up</a>
        </p>
    </div>

</body>
</html>
