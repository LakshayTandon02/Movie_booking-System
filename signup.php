<?php
session_start();
require_once 'database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Validate input
    if ((!empty($email) || !empty($phone)) && !empty($password)) {
        // Check if user already exists
        if (!empty($email)) {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
        } else {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE phone = ?");
            $stmt->execute([$phone]);
        }
        
        if ($stmt->rowCount() > 0) {
            $error = "User already exists!";
        } else {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert user
            $stmt = $pdo->prepare("INSERT INTO users (email, phone, password) VALUES (?, ?, ?)");
            $stmt->execute([$email, $phone, $hashedPassword]);
            
            // Generate OTP
            $otp = rand(100000, 999999);
            $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            
            // Store OTP
            $stmt = $pdo->prepare("INSERT INTO otp_tokens (email, phone, otp_code, expires_at) VALUES (?, ?, ?, ?)");
            $stmt->execute([$email, $phone, $otp, $expires]);
            
            // Send OTP (in a real application, you would implement email/SMS sending)
            $_SESSION['otp_email'] = $email;
            $_SESSION['otp_phone'] = $phone;
            $_SESSION['otp_type'] = 'signup';
            
            // In a real app, you would send the OTP via email or SMS here
            // For demo purposes, we'll just show it
            $success = "OTP sent successfully! Your OTP is: $otp";
            
            header("Location: verify-otp.php");
            exit();
        }
    } else {
        $error = "Please provide either email or phone and a password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>
        
        <?php if ($error): ?>
            <div class="alert error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email (optional):</label>
                <input type="email" id="email" name="email">
            </div>
            
            <div class="form-group">
                <label for="phone">Phone (optional):</label>
                <input type="text" id="phone" name="phone" placeholder="Format: 1234567890">
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Sign Up</button>
        </form>
        
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>