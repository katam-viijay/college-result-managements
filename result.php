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
    die("Database connection failed: " . $e->getMessage());
}

// Get values from URL
$hallticket = $_GET['hallticket'] ?? '';
$dob = $_GET['dob'] ?? '';
$semester = $_GET['semester'] ?? '';
$midterm = $_GET['midterm'] ?? '';

// Fetch student
$stmt = $conn->prepare("SELECT * FROM students WHERE hallticketno = :hallticket AND dateofbirth = :dob");
$stmt->execute([':hallticket' => $hallticket, ':dob' => $dob]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

$results = [];

if ($student) {
    $student_id = $student['id'];

    // Fetch student results (can filter further by semester/midterm)
    $result_stmt = $conn->prepare("SELECT subject_name, total_marks, obtained_marks, grade 
                                   FROM studentresults 
                                   WHERE student_id = :student_id");
    $result_stmt->execute([':student_id' => $student_id]);
    $results = $result_stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Result</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #e0c3fc, #8ec5fc);
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            background: white;
            margin: 40px auto;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            color: #5d26c1;
            font-size: 2em;
            margin-bottom: 25px;
        }

        .info, .results {
            margin-bottom: 30px;
        }

        .info p {
            margin: 8px 0;
            font-size: 1.1em;
        }

        .label {
            font-weight: bold;
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 14px;
            text-align: center;
            font-size: 1em;
        }

        th {
            background: linear-gradient(to right, #5d26c1, #a17fe0);
            color: white;
            font-weight: 600;
        }

        td {
            background-color: #f9f9f9;
            border-bottom: 1px solid #ddd;
        }

        tr:hover td {
            background-color: #f0e6ff;
        }

        .error {
            background: #ffe6e6;
            padding: 16px;
            color: #c0392b;
            border-left: 5px solid #e74c3c;
            margin-bottom: 20px;
            font-weight: bold;
        }

        p {
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Result Details</h2>

    <?php if ($student): ?>
        <div class="info">
            <p><span class="label">Name:</span> <?= htmlspecialchars($student['name']) ?></p>
            <p><span class="label">Hall Ticket No:</span> <?= htmlspecialchars($student['hallticketno']) ?></p>
            <p><span class="label">Father's Name:</span> <?= htmlspecialchars($student['fathername']) ?></p>
            <p><span class="label">Department:</span> <?= htmlspecialchars($student['department']) ?></p>
        </div>

        <?php if (count($results) > 0): ?>
            <div class="results">
                <table>
                    <thead>
                        <tr>
                            <th>Subject Name</th>
                            <th>Total Marks</th>
                            <th>Obtained Marks</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['subject_name']) ?></td>
                                <td><?= htmlspecialchars($row['total_marks']) ?></td>
                                <td><?= htmlspecialchars($row['obtained_marks']) ?></td>
                                <td><?= htmlspecialchars($row['grade']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No results found for this student.</p>
        <?php endif; ?>
    <?php else: ?>
        <div class="error">
            No student found. Please check your Hall Ticket Number and Date of Birth.
        </div>
    <?php endif; ?>
</div>

</body>
</html>
