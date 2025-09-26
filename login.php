<?php
session_start();

// Database connection
$host = 'localhost';
$db = 'college_result';
$user = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check admin in database
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['fullname'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            background: linear-gradient(135deg, #30cfd0, #330867);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background: rgba(255,255,255,0.95);
            padding: 35px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #222;
            margin-bottom: 25px;
        }
        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
            color: #333;
        }
        input {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
            font-size: 16px;
        }
        button {
            width: 100%;
            background: #30cfd0;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            margin-bottom: 10px;
        }
        button:hover {
            background: #2bc4cb;
        }
        .register-link {
            text-align: center;
        }
        .register-link a {
            color: #330867;
            text-decoration: none;
            font-weight: bold;
        }
        .error {
            color: red;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Admin Login</h2>
    <form method="POST">
        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">Login</button>

        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
    </form>

    <div class="register-link">
        <p>New admin? <a href="register.php">Register here</a></p>
    </div>
</div>

</body>
</html>
