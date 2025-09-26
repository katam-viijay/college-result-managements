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

// Get student ID
$student_id = $_GET['id'] ?? null;

if ($student_id) {
    // First delete their results (optional, if FK is not ON DELETE CASCADE)
    $conn->prepare("DELETE FROM StudentResults WHERE student_id = :id")->execute([':id' => $student_id]);

    // Then delete student
    $stmt = $conn->prepare("DELETE FROM Students WHERE id = :id");
    $stmt->execute([':id' => $student_id]);
}

// Redirect back to manage page
header("Location: manage.php");
exit;
?>
