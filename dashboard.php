<?php
session_start();

// Example session auth protection
// if (!isset($_SESSION['admin_logged_in'])) {
//     header("Location: login.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('https://assets.onecompiler.app/43ayxdwd6/43f9dtmh2/drk-pica.png') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dashboard-container {
            background: rgba(197, 235, 238, 0.18);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(148, 133, 133, 0.25);
            text-align: center;
            width: 90%;
            max-width: 500px;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: #5d26c1;
            margin-bottom: 30px;
            font-size: 28px;
        }

        .button {
            display: inline-block;
            padding: 14px 28px;
            margin: 12px;
            font-size: 16px;
            text-decoration: none;
            background: linear-gradient(to right, #36d1dc, #5b86e5);
            color: white;
            border-radius: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .logout {
            background: linear-gradient(to right, #f85032, #e73827);
        }

        .logout:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h2>Welcome to Admin Dashboard</h2>

    <a class="button" href="add_student.php">Add Student</a>
    <a class="button" href="manage.php">Manage Students</a>
    <a class="button logout" href="logout.php">Logout</a>
</div>

</body>
</html>
