<?php
// Database connection
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

// Get student ID from URL
$student_id = $_GET['student_id'] ?? null;
if (!$student_id) die("Invalid student ID.");

// Fetch student details
$stmt = $conn->prepare("SELECT name, hallticketno FROM Students WHERE id = :id");
$stmt->execute([':id' => $student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$student) die("Student not found.");

$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_names = $_POST['subject_name'];
    $total_marks = $_POST['total_marks'];
    $obtained_marks = $_POST['obtained_marks'];
    $grades = $_POST['grade'];
    $semester = $_POST['semester'];
    $midterm = $_POST['midterm'];

    $insert = $conn->prepare("INSERT INTO StudentResults 
        (student_id, subject_name, total_marks, obtained_marks, grade, semester, midterm)
        VALUES (:student_id, :subject_name, :total_marks, :obtained_marks, :grade, :semester, :midterm)");

    try {
        for ($i = 0; $i < count($subject_names); $i++) {
            if (trim($subject_names[$i]) === '') continue;

            $insert->execute([
                ':student_id' => $student_id,
                ':subject_name' => $subject_names[$i],
                ':total_marks' => $total_marks[$i],
                ':obtained_marks' => $obtained_marks[$i],
                ':grade' => $grades[$i],
                ':semester' => $semester,
                ':midterm' => $midterm
            ]);
        }

        $message = "All results added successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Multiple Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            max-width: 900px;
            margin: auto;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 6px;
            box-sizing: border-box;
        }

        .btn {
            padding: 10px 15px;
            background-color: #007BFF;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            border-radius: 5px;
        }

        .message {
            background-color: #d4edda;
            padding: 10px;
            color: #155724;
            border: 1px solid #c3e6cb;
            margin-bottom: 20px;
        }

        .info {
            background-color: #f8f9fa;
            padding: 10px;
            border-left: 4px solid #007BFF;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
    </style>
    <script>
        function addRow() {
            const table = document.getElementById("resultsTable").getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();

            const cells = ['subject_name', 'total_marks', 'obtained_marks', 'grade'];
            cells.forEach((name) => {
                const cell = newRow.insertCell();
                const input = document.createElement("input");
                input.name = name + "[]";
                input.required = true;
                input.type = (name === 'grade' || name === 'subject_name') ? "text" : "number";
                cell.appendChild(input);
            });
        }
    </script>
</head>
<body>

<h2>Add Results for <?= htmlspecialchars($student['name']) ?> (<?= htmlspecialchars($student['hallticketno']) ?>)</h2>

<?php if (!empty($message)): ?>
    <div class="message"><?= $message ?></div>
<?php endif; ?>

<div class="info">
    <strong>Name:</strong> <?= htmlspecialchars($student['name']) ?><br>
    <strong>Hall Ticket No:</strong> <?= htmlspecialchars($student['hallticketno']) ?>
</div>

<form method="POST">
    <label for="semester">Semester:</label>
    <select name="semester" id="semester" required>
        <option value="">Select Semester</option>
        <option value="1-1">1-1</option>
        <option value="1-2">1-2</option>
        <option value="2-1">2-1</option>
        <option value="2-2">2-2</option>
        <option value="3-1">3-1</option>
        <option value="3-2">3-2</option>
        <option value="4-1">4-1</option>
        <option value="4-2">4-2</option>
    </select>

    <label for="midterm">Midterm:</label>
    <select name="midterm" id="midterm" required>
        <option value="">Select Midterm</option>
        <option value="MID-1">MID-1</option>
        <option value="MID-2">MID-2</option>
    </select>

    <br><br>

    <table id="resultsTable">
        <thead>
            <tr>
                <th>Subject Name</th>
                <th>Total Marks</th>
                <th>Obtained Marks</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input name="subject_name[]" required></td>
                <td><input name="total_marks[]" type="number" required></td>
                <td><input name="obtained_marks[]" type="number" required></td>
                <td><input name="grade[]" required></td>
            </tr>
        </tbody>
    </table>

    <button type="button" class="btn" onclick="addRow()">+ Add Subject</button>
    <br>
    <input type="submit" class="btn" value="Submit Results">
</form>

</body>
</html>
