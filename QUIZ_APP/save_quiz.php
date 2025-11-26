<?php
session_start();
include("../conn/conn.php");
$conn = getPDOConnection();

// 🚫 If quiz already completed, block resubmit
if (isset($_SESSION['quiz_completed']) && $_SESSION['quiz_completed'] === true) {
    echo "
    <script>
        alert('You have already submitted the quiz.');
        window.location.href = 'http://localhost:8080/QUIZ_APP/student.php';
    </script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['quiz_taker'], $_POST['year_section'])) {
        $quizTaker = $_POST['quiz_taker'];
        $yearSection = $_POST['year_section'];
        $totalScore = $_POST['total_score'];
        $dateTaken = date("Y-m-d H:i:s"); 

        try {
            $stmt = $conn->prepare("INSERT INTO tbl_result (quiz_taker, year_section, total_score, date_taken) 
                                    VALUES (:quiz_taker, :year_section, :total_score, :date_taken)");

            $stmt->bindParam(':quiz_taker', $quizTaker);
            $stmt->bindParam(':year_section', $yearSection);
            $stmt->bindParam(':total_score', $totalScore);
            $stmt->bindParam(':date_taken', $dateTaken);

            $stmt->execute();

            // 🔒 Lock quiz after submission
            unset($_SESSION['quiz_in_progress']);
            $_SESSION['quiz_completed'] = true;

            echo "
            <script>
                alert('Submitted Successfully!');
                window.location.href = 'http://localhost:8080/QUIZ_APP/student.php';
            </script>
            ";
            exit();
        } catch (PDOException $e) {
            echo 'Database Error: ' . $e->getMessage();
        }
    } else {
        echo "
        <script>
            alert('Please fill in all required fields.');
            window.location.href = 'http://localhost:8080/QUIZ_APP/take-quiz.php';
        </script>
        ";
    }
}
?>
