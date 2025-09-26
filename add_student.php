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
    echo "Connection failed: " . $e->getMessage();
    die();
}

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hallticketno = $_POST['hallticketno'];
    $name = $_POST['name'];
    $fathername = $_POST['fathername'];
    $dob = $_POST['dob'];
    $department = $_POST['department'];

    $sql = "INSERT INTO Students (hallticketno, name, fathername, dateofbirth, department)
            VALUES (:hallticketno, :name, :fathername, :dob, :department)";

    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute([
            ':hallticketno' => $hallticketno,
            ':name' => $name,
            ':fathername' => $fathername,
            ':dob' => $dob,
            ':department' => $department
        ]);

        $student_id = $conn->lastInsertId();
        header("Location: add_result.php?student_id=" . $student_id);
        exit();

    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap');
        body {
            font-family: 'Nunito', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(120deg, #f7b733 0%, #fc4a1a 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            background: rgba(255,255,255,0.97);
            padding: 36px 28px 28px 28px;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(68, 64, 64, 0.13);
            max-width: 420px;
            width: 100%;
            animation: fadeIn 0.8s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #fc4a1a;
            font-size: 25px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            font-weight: 600;
            color: #222;
            font-size: 15px;
        }
        input[type="text"],
        input[type="date"] {
            margin-bottom: 18px;
            padding: 12px;
            font-size: 15px;
            border: 1.5px solid #f7b733;
            border-radius: 8px;
            background-color: #f9f6f2;
            transition: border-color 0.3s, box-shadow 0.3s;
            box-shadow: 0 1px 4px rgba(252, 74, 26, 0.04);
        }
        input[type="text"]:focus,
        input[type="date"]:focus {
            border-color: #fc4a1a;
            outline: none;
            box-shadow: 0 0 0 2px #fc4a1a33;
        }
        input[type="submit"] {
            background: linear-gradient(90deg, #fc4a1a 0%, #f7b733 100%);
            color: #fff;
            padding: 14px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 30px;
            font-weight: bold;
            transition: background 0.3s, transform 0.2s;
            box-shadow: 0 2px 8px rgba(252, 74, 26, 0.08);
            letter-spacing: 1px;
        }
        input[type="submit"]:hover {
            background: linear-gradient(90deg, #f7b733 0%, #fc4a1a 100%);
            transform: translateY(-2px) scale(1.01);
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 6px;
            font-size: 15px;
        }
        @media (max-width: 600px) {
            .form-container {
                margin: 20px;
                padding: 24px 10px 18px 10px;
            }
            h2 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add New Student</h2>

    <?php if (!empty($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Hall Ticket No</label>
        <input type="text" name="hallticketno" required>

        <label>Name</label>
        <input type="text" name="name" required>

        <label>Father Name</label>
        <input type="text" name="fathername">

        <label>Date of Birth</label>
        <input type="date" name="dob" placeholder="dd/mm/yyyy">

        <label>Department</label>
        <input type="text" name="department">

        <input type="submit" value="Add Student">
    </form>
</div>

</body>
</html>