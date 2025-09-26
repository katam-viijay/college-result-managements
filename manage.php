<?php
// db_connection
$host = 'localhost';
$dbname = 'college_result';
$user = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch all students
$stmt = $conn->prepare("SELECT id, name, hallticketno FROM Students");
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('https://assets.onecompiler.app/43ayxdwd6/43f9dtmh2/drk-pica.png') no-repeat center center fixed;
            background-size: cover;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .content-wrapper {
            background: rgba(197, 235, 238, 0.18);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 40px 32px;
            box-shadow: rgba(197, 235, 238, 0.18);
            width: 100%;
            max-width: 960px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            font-size: 30px;
            margin-bottom: 30px;
            color: #222;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        thead {
            background-color:rgb(160, 160, 179);
            font-weight: 600;
        }

        th, td {
            padding: 14px 20px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        tbody tr:nth-child(odd) {
            background-color: #fafafa;
        }

        tbody tr:hover {
            background-color: #e9f7fd;
        }

        a.btn {
            padding: 8px 16px;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .edit-btn {
            background-color: #28a745;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        a.btn:hover {
            opacity: 0.9;
            transform: scale(1.05);
        }

        @media (max-width: 600px) {
            .content-wrapper {
                padding: 25px 20px;
            }

            h2 {
                font-size: 24px;
            }

            th, td {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<div class="content-wrapper">
    <h2>Manage Students</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Hall Ticket No</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
            <tr>
                <td><?= $student['id'] ?></td>
                <td><?= htmlspecialchars($student['name']) ?></td>
                <td><?= htmlspecialchars($student['hallticketno']) ?></td>
                <td>
                    <a href="edit_student.php?id=<?= $student['id'] ?>" class="btn edit-btn">Edit</a>
                    <a href="delete_student.php?id=<?= $student['id'] ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
