<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once '../config.php';

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Helper function to generate OTP
function generateOTP() {
    return rand(100000, 999999);
}

// Helper function to send email (placeholder)
function sendEmailOTP($email, $otp) {
    // In a real application, you would use PHPMailer or a transactional email service
    $subject = "Your MovieBooking OTP Code";
    $message = "Your OTP code is: $otp\nThis code will expire in 10 minutes.";
    $headers = "From: no-reply@moviebooking.com";
    
    // For demo purposes, we'll just log this
    error_log("Email OTP sent to $email: $otp");
    return mail($email, $subject, $message, $headers);
}

// Helper function to send SMS (placeholder)
function sendSMSOTP($phone, $otp) {
    // In a real application, you would use an SMS gateway like Twilio
    error_log("SMS OTP sent to $phone: $otp");
    return true;
}

// Register endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    try {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $password = $_POST['password'];
        $via = $_POST['via']; // 'email' or 'phone'

        // Validate input
        if (empty($name) || empty($email) || empty($password) || empty($via)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required']);
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Invalid email format']);
            exit();
        }

        // Check if user already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email OR phone = :phone");
        $stmt->execute([':email' => $email, ':phone' => $phone]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            echo json_encode(['success' => false, 'message' => 'User already exists with this email or phone']);
            exit();
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Generate OTP
        $otp = generateOTP();
        $otpExpires = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Insert user
        $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, password, otp_code, otp_expires) 
                              VALUES (:name, :email, :phone, :password, :otp, :otp_expires)");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':password' => $hashedPassword,
            ':otp' => $otp,
            ':otp_expires' => $otpExpires
        ]);

        // Send OTP
        if ($via === 'email') {
            sendEmailOTP($email, $otp);
            $message = "OTP sent to your email";
        } else {
            sendSMSOTP($phone, $otp);
            $message = "OTP sent to your phone";
        }

        echo json_encode([
            'success' => true, 
            'message' => $message,
            'user_id' => $pdo->lastInsertId(),
            'via' => $via
        ]);

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}

// Verify OTP endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'verify_otp') {
    try {
        $user_id = $_POST['user_id'];
        $otp = $_POST['otp'];
        $via = $_POST['via'];

        // Check OTP
        $stmt = $pdo->prepare("SELECT otp_code, otp_expires FROM users WHERE id = :id");
        $stmt->execute([':id' => $user_id]);
        $user = $stmt->fetch();

        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'User not found']);
            exit();
        }

        if ($user['otp_code'] !== $otp) {
            echo json_encode(['success' => false, 'message' => 'Invalid OTP']);
            exit();
        }

        if (strtotime($user['otp_expires']) < time()) {
            echo json_encode(['success' => false, 'message' => 'OTP has expired']);
            exit();
        }

        // Update verification status
        if ($via === 'email') {
            $stmt = $pdo->prepare("UPDATE users SET email_verified = 1, otp_code = NULL, otp_expires = NULL WHERE id = :id");
        } else {
            $stmt = $pdo->prepare("UPDATE users SET phone_verified = 1, otp_code = NULL, otp_expires = NULL WHERE id = :id");
        }
        
        $stmt->execute([':id' => $user_id]);

        echo json_encode(['success' => true, 'message' => 'Account verified successfully']);

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}

// Login endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    try {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // Find user
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
            exit();
        }

        if (!$user['email_verified']) {
            echo json_encode(['success' => false, 'message' => 'Please verify your email first']);
            exit();
        }

        // Generate session token
        $sessionToken = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));

        // Store session
        $stmt = $pdo->prepare("INSERT INTO user_sessions (user_id, session_token, expires_at) 
                              VALUES (:user_id, :token, :expires_at)");
        $stmt->execute([
            ':user_id' => $user['id'],
            ':token' => $sessionToken,
            ':expires_at' => $expiresAt
        ]);

        // Return success with session token
        echo json_encode([
            'success' => true, 
            'message' => 'Login successful',
            'session_token' => $sessionToken,
            'user' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ]
        ]);

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}

// Resend OTP endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'resend_otp') {
    try {
        $user_id = $_POST['user_id'];
        $via = $_POST['via'];

        // Get user details
        $stmt = $pdo->prepare("SELECT email, phone FROM users WHERE id = :id");
        $stmt->execute([':id' => $user_id]);
        $user = $stmt->fetch();

        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'User not found']);
            exit();
        }

        // Generate new OTP
        $otp = generateOTP();
        $otpExpires = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Update OTP in database
        $stmt = $pdo->prepare("UPDATE users SET otp_code = :otp, otp_expires = :expires WHERE id = :id");
        $stmt->execute([
            ':otp' => $otp,
            ':expires' => $otpExpires,
            ':id' => $user_id
        ]);

        // Send OTP
        if ($via === 'email') {
            sendEmailOTP($user['email'], $otp);
            $message = "New OTP sent to your email";
        } else {
            sendSMSOTP($user['phone'], $otp);
            $message = "New OTP sent to your phone";
        }

        echo json_encode(['success' => true, 'message' => $message]);

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>