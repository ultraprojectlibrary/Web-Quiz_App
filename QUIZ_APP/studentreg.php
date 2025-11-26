




<?php
require_once('./conn/conn.php'); // Make sure file path is correct
$pdo = getPDOConnection(); // get PDO instance

$message = ""; // feedback message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['user_name'] ?? '';
    $password = $_POST['user_password'] ?? '';
    $email = $_POST['user_email'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $department = $_POST['user_department'] ?? '';
    $mat_no = $_POST['mat_no'] ?? '';

    // Sanitize input
    $username = filter_var($username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $fullname = filter_var($fullname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $department = filter_var($department, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $mat_no = filter_var($mat_no, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cleaned_password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    try {
        $stmt = $pdo->prepare("INSERT INTO user_detail (user_name, user_password, user_email, user_fullname, user_department, mat_no)
                               VALUES (:username, :password, :email, :fullname, :department, :mat_no)");

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $cleaned_password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':mat_no', $mat_no);

        $stmt->execute();

        // ✅ Store success message with student details
        $message = "
            <div style='background: #d4edda; color: #155724; padding: 15px; border: 1px solid #c3e6cb; border-radius: 5px; margin-bottom: 20px;'>
                <h3>✅ Student Registered Successfully!</h3>
                <p><strong>Full Name:</strong> {$fullname}</p>
                <p><strong>Username:</strong> {$username}</p>
                <p><strong>Email:</strong> {$email}</p>
                <p><strong>Department:</strong> {$department}</p>
                <p><strong>Matric Number:</strong> {$mat_no}</p>
            </div>
        ";
    } catch (PDOException $e) {
        $message = "<div style='background: #f8d7da; color: #721c24; padding: 15px; border: 1px solid #f5c6cb; border-radius: 5px;'>
                        Registration failed: " . $e->getMessage() . "
                    </div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Register</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="assets/qstyles.css">
    <style>
        .login-forms form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .login-forms .btn, .login-forms .btn2 {
            padding: 10px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-forms .btn2 {
            background-color: #007bff;
            margin-top: 10px;
            width: 100%;
        }
        .body2 {
            background-image: url(/QUIZ_APP/assets/image1.png);
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin-top: 100px;
            background-color: rgba(0, 0, 0, 0.7);
            font-family: Arial, sans-serif;
            color: #333;
        }
    </style>
</head>
<body class="body2">
    <div class="login-forms">
        <!-- ✅ Display success or error message -->
        <?php if (!empty($message)) echo $message; ?>

        <form action="" method="post">
            <h5>STUDENT REGISTRATION FORM</h5>

            <input type="text" id="username" name="user_name" placeholder="Username" required>
            <input type="password" id="password" name="user_password" placeholder="Password" required>
            <input type="email" id="email" name="user_email" placeholder="Email" required>
            <input type="text" id="full_name" name="fullname" placeholder="Fullname" required>
            <input type="text" id="department" name="user_department" placeholder="Department" required>
            <input type="text" id="mat_no" name="mat_no" placeholder="Matric Number" required>

            <button type="submit" class="btn">Submit</button>
        </form>

        <a href="studentlogin.php">
            <button class="btn2" type="button">Login</button>
        </a>
    </div>
</body>
</html>
