<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Authentication System</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to OTP Authentication System</h1>
        <div class="button-group">
            <a href="signup.php" class="btn">Sign Up</a>
            <a href="login.php" class="btn">Login</a>
        </div>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="welcome-message">
                <p>Welcome! You are logged in.</p>
                <a href="logout.php" class="btn">Logout</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>