<?php
// DB connection
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

$student_id = $_GET['id'] ?? null;
if (!$student_id) die("Invalid student ID.");

// Fetch student
$stmt = $conn->prepare("SELECT * FROM students WHERE id = :id");
$stmt->execute([':id' => $student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$student) die("Student not found.");

// Update student info
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_student'])) {
    $update = $conn->prepare("UPDATE students SET hallticketno = :hallticketno, name = :name, fathername = :fathername, dateofbirth = :dateofbirth, department = :department WHERE id = :id");
    $update->execute([
        ':hallticketno' => $_POST['hallticketno'],
        ':name' => $_POST['name'],
        ':fathername' => $_POST['fathername'],
        ':dateofbirth' => $_POST['dateofbirth'],
        ':department' => $_POST['department'],
        ':id' => $student_id
    ]);
    header("Location: dashboard.php?id=" . $student_id);
    exit;
}

// Update all results at once
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_all_results'])) {
    foreach ($_POST['results'] as $index => $res) {
        $update_result = $conn->prepare("UPDATE studentresults 
            SET subject_name = :subject_name, 
                total_marks = :total_marks, 
                obtained_marks = :obtained_marks, 
                grade = :grade,
                semester = :semester,
                midterm = :midterm
            WHERE result_id = :result_id AND student_id = :student_id");

        $update_result->execute([
            ':subject_name' => $res['subject_name'],
            ':total_marks' => $res['total_marks'],
            ':obtained_marks' => $res['obtained_marks'],
            ':grade' => $res['grade'],
            ':semester' => $_POST['semester'],
            ':midterm' => $_POST['midterm'],
            ':result_id' => $res['result_id'],
            ':student_id' => $student_id
        ]);
    }
    header("Location: dashboard.php?id=" . $student_id);
    exit;
}

// Fetch student results
$result_stmt = $conn->prepare("SELECT * FROM studentresults WHERE student_id = :id");
$result_stmt->execute([':id' => $student_id]);
$results = $result_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student & Results</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px;
            background: url('https://assets.onecompiler.app/43ayxdwd6/43f9dtmh2/drk-pica.png') no-repeat center center fixed;
            background-size: cover;
            animation: bgScroll 60s linear infinite;
            color: #000;
        }

        @keyframes bgScroll {
            0% {
                background-position: center top;
            }
            100% {
                background-position: center bottom;
            }
        }

        h2, h3 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        form {
            background: rgba(197, 235, 238, 0.18);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
            color: #555;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-size: 16px;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            width: auto;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .inline-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .small {
            width: 120px;
        }

        .section {
            margin-bottom: 20px;
            background-color: #fafafa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .section label {
            margin-bottom: 8px;
        }

        .section select {
            width: 160px;
        }

        .results-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .results-table th, .results-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .results-table th {
            background-color: #f2f2f2;
        }

        .results-table tr:hover {
            background-color: #f7f7f7;
        }
    </style>
</head>
<body>

<h2>Edit Student Info</h2>

<form method="post">
    <label>Hall Ticket No:</label>
    <input type="text" name="hallticketno" value="<?= htmlspecialchars($student['hallticketno']) ?>" required>

    <label>Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>

    <label>Father's Name:</label>
    <input type="text" name="fathername" value="<?= htmlspecialchars($student['fathername']) ?>" required>

    <label>Date of Birth:</label>
    <input type="date" name="dateofbirth" value="<?= $student['dateofbirth'] ?>" required>

    <label>Department:</label>
    <input type="text" name="department" value="<?= htmlspecialchars($student['department']) ?>" required>

    <input type="submit" name="update_student" value="Update Student Info">
</form>

<h3>Update Student Results</h3>

<?php if (count($results) > 0): ?>
    <form method="post">
        <div class="section">
            <label>Semester:</label>
            <select name="semester" required>
                <option value="1-1">1-1</option>
                <option value="1-2">1-2</option>
                <option value="2-1">2-1</option>
                <option value="2-2">2-2</option>
                <option value="3-1">3-1</option>
                <option value="3-2">3-2</option>
                <option value="4-1">4-1</option>
                <option value="4-2">4-2</option>
            </select>

            <label>Midterm:</label>
            <select name="midterm" required>
                <option value="MID-1">MID-1</option>
                <option value="MID-2">MID-2</option>
            </select>
        </div>

        <table class="results-table">
            <thead>
                <tr>
                    <th>Subject Name</th>
                    <th>Total Marks</th>
                    <th>Obtained Marks</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $index => $res): ?>
                <tr>
                    <input type="hidden" name="results[<?= $index ?>][result_id]" value="<?= $res['result_id'] ?>">
                    <td><input type="text" name="results[<?= $index ?>][subject_name]" value="<?= htmlspecialchars($res['subject_name']) ?>" class="small" required></td>
                    <td><input type="number" name="results[<?= $index ?>][total_marks]" value="<?= $res['total_marks'] ?>" class="small" required></td>
                    <td><input type="number" name="results[<?= $index ?>][obtained_marks]" value="<?= $res['obtained_marks'] ?>" class="small" required></td>
                    <td><input type="text" name="results[<?= $index ?>][grade]" value="<?= htmlspecialchars($res['grade']) ?>" class="small" maxlength="2"></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <input type="submit" name="update_all_results" value="Update Result">
    </form>
<?php else: ?>
    <p>No results found for this student.</p>
<?php endif; ?>

</body>
</html>
