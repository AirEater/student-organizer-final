<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/login.css">
</head>

<body>
    <div class="container">

        <div class="form-container">
            <form id="loginForm" action="process_login.php" method="post">
                <?php
                if (isset($_SESSION['logout_message'])) {
                    echo '<div class="success-message">' . htmlspecialchars($_SESSION['logout_message']) . '</div>';
                    unset($_SESSION['logout_message']); // Clear the message after displaying
                }
                ?>
                <h2>User Login</h2>
                <div class="form-group">
                    <label class="input-label">Email</label>
                    <input type="email" name="email" placeholder="abc@email.com" required>
                </div>
                <div class="form-group">
                    <label class="input-label">Password</label>
                    <input type="password" name="password" placeholder="password" required>
                </div>
                <div id="error-message" class="error-message"></div>

                <div class="options-row">
                    <label class="remember-me">
                        <input type="checkbox" name="remember_me"> Remember me
                    </label>
                    <a href="/student_organizer/forgot_password.php" class="forgot-password-link">Forget Your Password?</a>
                </div>

                <div class="signin-container">
                    <button type="submit" class="sign-in">Sign In</button>
                </div>
            </form>
        </div>

        <div class="signup-container">
            <h2>New User?</h2>
            <p>Get your new account!</p>
            <a href="registration.php" class="sign-up">Sign Up</a>
        </div>

    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const errorMessageDiv = document.getElementById('error-message');
            errorMessageDiv.textContent = ''; // Clear previous errors

            const formData = new FormData(this);

            fetch('process_login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // parse JSON
            .then(data => {
                if (data.success) {
                    window.location.href = '../index.php';
                } else {
                    errorMessageDiv.textContent = data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorMessageDiv.textContent = 'An unexpected error occurred. Please try again.';
            });
        });
    </script>
</body>

</html>