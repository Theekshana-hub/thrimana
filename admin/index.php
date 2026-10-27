<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

// If already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Thrimana</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #050505;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }
        .login-box {
            background: #121212;
            border: 1px solid #1f1f1f;
            border-radius: 16px;
            padding: 48px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }
        .login-logo {
            text-align: center;
            margin-bottom: 32px;
        }
        .login-logo img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            margin: 0 auto 16px;
            box-shadow: 0 0 30px rgba(245,184,0,0.3);
        }
        .login-logo h1 {
            font-size: 1.5rem;
            background: linear-gradient(90deg, #f5b800, #ffd700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 2px;
        }
        .login-logo p {
            color: #888;
            font-size: 0.85rem;
            margin-top: 6px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.9rem;
            color: #aaa;
        }
        .form-group input {
            width: 100%;
            padding: 14px 16px;
            background: #0a0a0a;
            border: 1px solid #2a2a2a;
            border-radius: 10px;
            color: #fff;
            font-size: 0.95rem;
            font-family: inherit;
        }
        .form-group input:focus {
            outline: none;
            border-color: #f5b800;
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #f5b800, #d4a000);
            border: none;
            border-radius: 10px;
            color: #111;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245,184,0,0.4);
        }
        .error {
            background: rgba(230,57,70,0.15);
            border: 1px solid rgba(230,57,70,0.3);
            color: #ff8a80;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .back-link {
            text-align: center;
            margin-top: 24px;
        }
        .back-link a {
            color: #888;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .back-link a:hover { color: #f5b800; }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="login-logo">
            <img src="../assets/images/logo.png" alt="Logo">
            <h1>THRIMANA</h1>
            <p>Admin Panel</p>
        </div>
        
        <?php if ($error): ?>
        <div class="error"><i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required autofocus value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-login"><i class="fas fa-sign-in-alt"></i> Login</button>
        </form>
        
        <div class="back-link">
            <a href="../index.php"><i class="fas fa-arrow-left"></i> Back to Website</a>
        </div>
    </div>
</body>
</html>
