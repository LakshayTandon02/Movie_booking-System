<?php
session_start();
require_once 'database.php';

$error = '';

if (!isset($_SESSION['otp_email']) && !isset($_SESSION['otp_phone'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = $_POST['otp'] ?? '';
    
    if (!empty($otp)) {
        $email = $_SESSION['otp_email'] ?? '';
        $phone = $_SESSION['otp_phone'] ?? '';
        
        // Verify OTP
        $stmt = $pdo->prepare("SELECT * FROM otp_tokens WHERE (email = ? OR phone = ?) AND otp_code = ? AND expires_at > NOW() ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$email, $phone, $otp]);
        $otpRecord = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($otpRecord) {
            if ($_SESSION['otp_type'] === 'signup') {
                // Mark user as verified
                if (!empty($email)) {
                    $stmt = $pdo->prepare("UPDATE users SET is_verified = TRUE WHERE email = ?");
                    $stmt->execute([$email]);
                } else {
                    $stmt = $pdo->prepare("UPDATE users SET is_verified = TRUE WHERE phone = ?");
                    $stmt->execute([$phone]);
                }
                
                // Get user ID
                if (!empty($email)) {
                    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                    $stmt->execute([$email]);
                } else {
                    $stmt = $pdo->prepare("SELECT id FROM users WHERE phone = ?");
                    $stmt->execute([$phone]);
                }
                
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_id'] = $user['id'];
                
                // Clear OTP session
                unset($_SESSION['otp_email']);
                unset($_SESSION['otp_phone']);
                unset($_SESSION['otp_type']);
                
                header("Location: index.php");
                exit();
            } else if ($_SESSION['otp_type'] === 'login') {
                // Get user ID
                if (!empty($email)) {
                    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                    $stmt->execute([$email]);
                } else {
                    $stmt = $pdo->prepare("SELECT id FROM users WHERE phone = ?");
                    $stmt->execute([$phone]);
                }
                
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_id'] = $user['id'];
                
                // Clear OTP session
                unset($_SESSION['otp_email']);
                unset($_SESSION['otp_phone']);
                unset($_SESSION['otp_type']);
                
                header("Location: index.php");
                exit();
            }
        } else {
            $error = "Invalid or expired OTP!";
        }
    } else {
        $error = "Please enter the OTP!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Verify OTP</h1>
        
        <?php if ($error): ?>
            <div class="alert error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="otp">Enter OTP:</label>
                <input type="text" id="otp" name="otp" required>
            </div>
            
            <button type="submit" class="btn">Verify OTP</button>
        </form>
    </div>
</body>
</html>