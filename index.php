<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hallticket = $_POST["hallticket"];
    $dob = $_POST["dob"];
    $semester = $_POST["semester"];
    $midterm = $_POST["midterm"];

    // Redirect to result.php with query params
    header("Location: result.php?hallticket=$hallticket&dob=$dob&semester=$semester&midterm=$midterm");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>DRK College of Engineering and Technology - Results</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap');

    body {
      font-family: 'Nunito', Arial, sans-serif;
      margin: 0;
      background: linear-gradient(120deg, #f7b733 0%, #fc4a1a 100%);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    header {
      background: rgba(34, 34, 34, 0.92);
      color: #fff;
      padding: 18px 24px;
      width: 100%;
      display: flex;
      align-items: center;
      box-shadow: 0 4px 16px rgba(0,0,0,0.13);
      border-bottom-left-radius: 18px;
      border-bottom-right-radius: 18px;
    }

    header img {
      height: 48px;
      margin-right: 18px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.10);
    }

    header h1 {
      font-size: 22px;
      margin: 0;
      font-weight: 700;
      letter-spacing: 0.5px;
    }

    .container {
      max-width: 420px;
      margin: 48px auto 0 auto;
      padding: 36px 28px 28px 28px;
      background: rgba(255,255,255,0.97);
      border-radius: 18px;
      box-shadow: 0 8px 32px rgba(68, 64, 64, 0.13);
      animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px);}
      to { opacity: 1; transform: translateY(0);}
    }

    .container h2 {
      text-align: center;
      color: #fc4a1a;
      margin-bottom: 28px;
      font-size: 25px;
      font-weight: 700;
      letter-spacing: 1px;
    }

    form label {
      font-weight: 600;
      color: #222;
      margin-top: 12px;
      display: block;
      font-size: 15px;
    }

    input[type="text"],
    input[type="date"],
    select {
      width: 100%;
      padding: 12px;
      margin-top: 7px;
      margin-bottom: 18px;
      border: 1.5px solid #f7b733;
      border-radius: 8px;
      font-size: 15px;
      background-color: #f9f6f2;
      transition: border-color 0.3s, box-shadow 0.3s;
      box-shadow: 0 1px 4px rgba(252, 74, 26, 0.04);
    }

    input[type="text"]:focus,
    input[type="date"]:focus,
    select:focus {
      border-color: #fc4a1a;
      outline: none;
      box-shadow: 0 0 0 2px #fc4a1a33;
    }

    input[type="submit"] {
      width: 100%;
      padding: 14px;
      background: linear-gradient(90deg, #fc4a1a 0%, #f7b733 100%);
      color: #fff;
      border: none;
      border-radius: 30px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
      box-shadow: 0 2px 8px rgba(252, 74, 26, 0.08);
      letter-spacing: 1px;
    }

    input[type="submit"]:hover {
      background: linear-gradient(90deg, #f7b733 0%, #fc4a1a 100%);
      transform: translateY(-2px) scale(1.01);
    }

    @media (max-width: 600px) {
      .container {
        margin: 20px;
        padding: 24px 10px 18px 10px;
      }

      header h1 {
        font-size: 16px;
      }

      header img {
        height: 32px;
      }
    }
  </style>
</head>
<body>

<header>
  <img src="https://assets.onecompiler.app/43ayxdwd6/43ebnby83/logo.jpg" alt="College Logo">
  <h1>DRK College of Engineering and Technology</h1>
</header>

<div class="container">
  <h2>Student Result Portal</h2>
  <form method="post">
    <label for="hallticket">Hall Ticket Number:</label>
    <input type="text" id="hallticket" name="hallticket" required>

    <label for="dob">Date of Birth:</label>
    <input type="date" id="dob" name="dob" required>

    <label for="semester">Semester:</label>
    <select id="semester" name="semester" required>
      <option value="">Select Semester</option>
      <option>1-1</option>
      <option>1-2</option>
      <option>2-1</option>
      <option>2-2</option>
      <option>3-1</option>
      <option>3-2</option>
      <option>4-1</option>
      <option>4-2</option>
    </select>

    <label for="midterm">Midterm:</label>
    <select id="midterm" name="midterm" required>
      <option value="">Select Midterm</option>
      <option>MID-1</option>
      <option>MID-2</option>
    </select>

    <input type="submit" value="Check Result">
  </form>
</div>

</body>
</html>