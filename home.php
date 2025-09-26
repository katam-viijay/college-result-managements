<?php
$notifications = [
    "Admissions open for 2025 batch!",
    "Placement drive scheduled on May 10th.",
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DRK College - Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f8f9fa;
            color: #222;
        }

        .header {
            background: linear-gradient(90deg, #f59609 60%, #f7b733 100%);
            color: #fff;
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            border-bottom-left-radius: 18px;
            border-bottom-right-radius: 18px;
        }

        .college-info {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .college-info img {
            height: 48px;
            width: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.10);
        }

        .college-name {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .menu-icon {
            font-size: 30px;
            color: #fff;
            cursor: pointer;
            margin-left: 18px;
            transition: color 0.2s;
        }
        .menu-icon:hover {
            color: #ffe082;
        }

        .top-buttons {
            display: flex;
            gap: 10px;
        }

        .top-buttons a {
            padding: 7px 18px;
            background: #fff;
            color: #f59609;
            border-radius: 6px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            box-shadow: 0 1px 4px rgba(0,0,0,0.07);
            transition: background 0.2s, color 0.2s;
            border: 1px solid #f7b733;
        }
        .top-buttons a:hover {
            background: #f7b733;
            color: #fff;
        }

        .slider {
            width: 100%;
            height: 260px;
            background: url('https://assets.onecompiler.app/43ayxdwd6/43f9dtmh2/drk-pica.png') no-repeat center center;
            background-size: cover;
            color: #fff;
            display: flex;
            align-items: flex-end;
            padding: 32px 24px;
            font-size: 20px;
            border-radius: 0 0 18px 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.10);
        }
        .slider h3 {
            margin: 0 0 6px 0;
            font-size: 28px;
            font-weight: 700;
            text-shadow: 0 2px 8px rgba(0,0,0,0.18);
        }
        .slider p {
            margin: 0;
            font-size: 18px;
            text-shadow: 0 2px 8px rgba(0,0,0,0.18);
        }

        .notifications-bar {
            background-color: #f76c00;
            color: white;
            padding: 14px 0;
            font-size: 20px;
            text-align: center;
            font-weight: 600;
            letter-spacing: 1px;
            margin-top: 10px;
            border-radius: 10px 10px 0 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }

        .notification-list {
            background-color: #fff;
            padding: 16px 24px;
            margin: 0;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 24px;
        }

        .notification-list li {
            padding: 8px 0;
            list-style: none;
            border-bottom: 1px solid #f0f0f0;
            font-size: 16px;
        }
        .notification-list li:last-child {
            border-bottom: none;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            display: flex;
            justify-content: space-around;
            background: #fff;
            box-shadow: 0 -1px 8px rgba(0,0,0,0.10);
            z-index: 100;
        }

        .bottom-nav a {
            padding: 12px 0;
            text-align: center;
            flex: 1;
            font-size: 15px;
            text-decoration: none;
            color: #fff;
            font-weight: 600;
            transition: background 0.2s, color 0.2s;
            border-right: 1px solid #eee;
        }
        .bottom-nav a:last-child {
            border-right: none;
        }

        .phone { background-color: #28a745; }
        .email { background-color: #dc3545; }
        .facebook { background-color: #3b5998; }
        .youtube { background-color: #ff0000; }
        .apply { background-color: #ffc107; color: #222 !important; }

        /* Responsive Design */
        @media (max-width: 700px) {
            .header, .slider, .notification-list {
                padding-left: 10px;
                padding-right: 10px;
            }
            .slider {
                height: 160px;
                font-size: 15px;
                padding: 16px 10px;
            }
            .slider h3 {
                font-size: 18px;
            }
            .slider p {
                font-size: 13px;
            }
            .college-name {
                font-size: 15px;
            }
            .college-info img {
                height: 32px;
            }
            .top-buttons a {
                padding: 5px 10px;
                font-size: 12px;
            }
            .notifications-bar {
                font-size: 15px;
                padding: 10px 0;
            }
            .notification-list {
                font-size: 13px;
                padding: 10px 10px;
            }
            .bottom-nav a {
                font-size: 12px;
                padding: 10px 0;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <div class="college-info">
        <img src="https://assets.onecompiler.app/43ayxdwd6/43gttevsg/logo-pica.png" alt="DRK Logo">
        <div class="college-name">DRK College of Engineering and Technology</div>
    </div>

    <div class="top-buttons">
        <a href="dashboard.php">Admin</a>
        <a href="index.php">Student</a>
    </div>

    <div class="menu-icon">&#9776;</div>
</div>

<div class="slider">
    <div>
        <h3>Brand of Excellence in Campus Placements</h3>
        <p>2025 Pass Out Batch - 1100+ Student Offers</p>
    </div>
</div>

<div class="notifications-bar">Notifications</div>

<ul class="notification-list">
    <?php foreach ($notifications as $note): ?>
        <li><?php echo $note; ?></li>
    <?php endforeach; ?>
</ul>

<div class="bottom-nav">
    <a href="tel:+919999999999" class="phone">Phone</a>
    <a href="mailto:info@mru.com" class="email">Email</a>
    <a href="https://facebook.com" class="facebook">Facebook</a>
    <a href="https://youtube.com" class="youtube">YouTube</a>
    <a href="apply.php" class="apply">Apply</a>
</div>

</body>
</html>