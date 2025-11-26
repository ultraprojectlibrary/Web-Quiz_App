<?php
include ('./partials/header.php');
include ('./conn/conn.php');
?>

<div class="main">
   <p  style="text-align:left; font-size:30px; "><img src="assets/pti_logo_bg-removebg-preview.png" width="100" height="80">PETROLUEM TRAINING INSTITUTE</p>
    <div class="main-container">
    <h1> Welcome To PTI Online Quiz App</h1>
        <div class="border-line"></div>

            <div class="selection-container">
                <h3>Select user type</h3>
                <div class="user-selection-button">
                <a href="studentlogin.php">
                    <button>Student</button>
                </a>
                
                <a href="adminlogin.php">
                    <button>Admin</button>
                </a>

            </div>

        </div>
    </div>

</div>

<?php include ('./partials/footer.php') ?>