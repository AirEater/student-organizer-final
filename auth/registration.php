<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="../assets/registration.css">
</head>
<body>
    <div class="background-blur"></div>
    <div class="container">
        <div class="signin-container">
            <h2>Already have an account?</h2>
            <p>Login here!</p>
            <a href="login.php" class="sign-in">Sign In</a>
        </div>
        <div class="form-container">
            <form id="registrationForm" action="process_registration.php" method="post">
                <h2>Create Account</h2>
                <div class="form-group">
                    <label class="input-label">Username</label>
                    <input type="text" name="username" placeholder="Choose a username" required>
                </div>
                <div class="form-group">
                    <label class="input-label">Email</label>
                    <input type="email" name="email" placeholder="abc@email.com" required>
                </div>
                <div class="form-group">
                    <label class="input-label">Password</label>
                    <input type="password" name="password" placeholder="Create a password" minlength="6" required >
                </div>
                <div class="form-group">
                    <label class="input-label">Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Confirm your password" minlength="6" required>
                </div>
                <div class="register-container">
                    <button type="submit" class="register">Register</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(this);

            fetch('process_registration.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text()) // Get the raw response text
            .then(text => {
                console.log("Server response:", text); // Log the raw response
                try {
                    const data = JSON.parse(text); // Try to parse it as JSON
                    if (data.success) {
                        alert(data.message);
                        window.location.href = 'login.php';
                    } else {
                        alert(data.message);
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    alert('An error occurred while processing the server response.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred. Please try again.');
            });
        });
    </script>
</body>
</html>