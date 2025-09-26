<?php
// Database connection using PDO
$host = 'localhost';
$db = 'college_result';
$user = 'root';
$pass = ''; // Replace with your actual DB password

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

session_start();

if (isset($_POST['register'])) {
    $fullname = $_POST['fullname'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $role = $_POST['role'];

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        echo "<script>alert('Email is already registered!');</script>";
    } else {
        // Insert admin record with sysdate
        $stmt = $conn->prepare("INSERT INTO admin (full_name, contact, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$fullname, $contact, $email, $password, $role]);

        $_SESSION['admin_id'] = $conn->lastInsertId();
        echo "<script>alert('Admin registered successfully!'); window.location.href='dashboard.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        label {
            display: block;
            margin: 12px 0 5px;
            color: #444;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
            font-size: 16px;
        }
        button {
            width: 100%;
            background: #667eea;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s ease;
        }
        button:hover {
            background: #5a67d8;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Admin Registration</h2>
        <form method="POST">
            <label>Full Name</label>
            <input type="text" name="fullname" required>

            <label>Contact</label>
            <input type="text" name="contact" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Role</label>
            <select name="role" required>
                <option value="Super Admin">Super Admin</option>
                <option value="Admin">Admin</option>
                <option value="Faculty">Faculty</option>
            </select>

            <button type="submit" name="register">Register</button>
        </form>
    </div>
</body>
</html>
