<?php
session_start();
include ('./conn/conn.php');
include ('./partials/header.php');
include ('./partials/modal.php');
$conn = getPDOConnection();

// 🔔 Start timer if not already started
if (!isset($_SESSION['quiz_start'])) {
    $_SESSION['quiz_start'] = time();   // store quiz start timestamp
    $_SESSION['quiz_duration'] = 60;   // 1 minutes
}

// Calculate time left
$elapsed = time() - $_SESSION['quiz_start'];
$timeLeft = $_SESSION['quiz_duration'] - $elapsed;

// If time is up, destroy session and redirect
if ($timeLeft <= 0) {
    session_unset();
    session_destroy();
    header("Location: index.php?timeout=1");
    exit();
}
?>

<div class="main">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand ml-4" href="#">PTI Online Quiz System</a>
    </nav>

    <div class="take-quiz-area">
        <!-- 🔔 Timer Display -->
        <div id="timer" style="font-size: 1.5em; font-weight: bold; margin-bottom: 10px; color: red;">
            Time Left: <?= gmdate("i:s", $timeLeft) ?>
        </div>

        <h3 class="mt-4">Multiple Choice!</h3>
        <small>Put the letter of the correct answer in the blank input provided.</small>

        <div class="questions">
            <?php
            $stmt = $conn->prepare('SELECT * FROM `tbl_quiz`');
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach ($result as $row) {
                $quizID = $row['tbl_quiz_id'];
                $quizQuestion = $row['quiz_question'];
                $optionA = $row['option_a'];
                $optionB = $row['option_b'];
                $optionC = $row['option_c'];
                $optionD = $row['option_d'];
                ?>
                <div class="question">
                    <p><?= $quizID ?>. <?= $quizQuestion ?></p>
                    <ol class="choices">
                        <li><?= $optionA ?></li>
                        <li><?= $optionB ?></li>
                        <li><?= $optionC ?></li>
                        <li><?= $optionD ?></li>
                    </ol>
                    <div class="answer-input">
                        <label for="answer">Answer:</label>
                        <input class="col-1" type="text" maxlength="1">
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <button type="button" class="btn btn-secondary" id="submitAnswer">
            Submit <i class="fa-sharp fa-solid fa-share"></i>
        </button>
    </div>
</div>

<?php
// Pass quiz data + remaining time + fullname to JS
$stmt = $conn->prepare('SELECT * FROM `tbl_quiz`');
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<script>';
echo 'var quizData = ' . json_encode($result) . ';';
echo 'var timeLeft = ' . $timeLeft . ';';  // Pass remaining time
echo '</script>';
?>

<!-- ✅ Result Modal -->
<div class="modal fade" id="resultModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="endpoint/add-result.php">
        <div class="modal-header">
          <h5 class="modal-title">Quiz Result</h5>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Student Fullname</label>
            <input type="text" name="quiz_taker" class="form-control"
                   value="<?= $_SESSION['fullname'] ?>" readonly>
          </div>
          <div class="form-group">
            <label>Year/Section</label>
            <input type="text" name="year_section" class="form-control"
                   value="<?= $_SESSION['year_section'] ?>" readonly>
          </div>
          <div class="form-group">
            <label>Total Score</label>
            <input type="text" name="total_score" id="totalScore" class="form-control" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit Result</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.getElementById("submitAnswer").addEventListener("click", function() {
    var questions = document.querySelectorAll(".question");
    var correctAnswers = 0;

    questions.forEach(function(question, index) {
        var answerInput = question.querySelector("input");
        if (answerInput) {
            var userAnswer = answerInput.value.toUpperCase();
            var correctAnswer = quizData[index].correct_answer;

            if (userAnswer === correctAnswer) {
                correctAnswers++;
                question.classList.add("correct");
            }
        }
    });

    $("#resultModal").modal("show");
    $("#totalScore").val(correctAnswers);
});

// 🔔 Timer functionality (from PHP session)
let timerDisplay = document.getElementById("timer");

function updateTimer() {
    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;

    timerDisplay.textContent = `Time Left: ${minutes.toString().padStart(2,'0')}:${seconds.toString().padStart(2,'0')}`;

    if (timeLeft <= 0) {
        clearInterval(timerInterval);
        alert("⏰ Time is up! You will be logged out.");
        window.location.href = "index.php?timeout=1";
    }
    timeLeft--;
}

let timerInterval = setInterval(updateTimer, 1000);
updateTimer();
</script>

<?php include ('./partials/footer.php'); ?>
