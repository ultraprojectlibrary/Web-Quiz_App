

<?php
session_start();
include("../conn/conn.php");
$conn = getPDOConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['quiz_taker'], $_POST['year_section'], $_POST['total_score'])) {
        $quizTaker = trim($_POST['quiz_taker']);
        $yearSection = trim($_POST['year_section']);
        $totalScore = intval($_POST['total_score']);
        $dateTaken = date("Y-m-d H:i:s");

        try {
            // ✅ 1. Save result in tbl_result
            $stmt = $conn->prepare("INSERT INTO tbl_result (quiz_taker, year_section, total_score, date_taken) 
                                    VALUES (:quiz_taker, :year_section, :total_score, :date_taken)");

            $stmt->bindParam(':quiz_taker', $quizTaker);
            $stmt->bindParam(':year_section', $yearSection);
            $stmt->bindParam(':total_score', $totalScore);
            $stmt->bindParam(':date_taken', $dateTaken);
            $stmt->execute();

            // ✅ 2. Mark student as having taken quiz
            $stmt2 = $conn->prepare("UPDATE user_detail SET quiz_taken = 1 WHERE user_fullname = :quiz_taker");
            $stmt2->bindParam(':quiz_taker', $quizTaker);
            $stmt2->execute();

            // ✅ 3. Destroy session to prevent re-login
            session_unset();
            session_destroy();

            echo "
            <script>
                alert('Quiz Submitted Successfully! You cannot take the quiz again.');
                window.location.href = 'http://localhost:8080/QUIZ_APP/index.php';
            </script>
            ";
            exit();
        } catch (PDOException $e) {
            echo 'Database Error: ' . $e->getMessage();
        }
    } else {
        echo "
        <script>
            alert('Please fill in all fields.');
            window.location.href = 'http://localhost:8080/QUIZ_APP/take-quiz.php';
        </script>
        ";
    }
}
?>


