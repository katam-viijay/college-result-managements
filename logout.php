<?php
session_start();
session_destroy();
header("Location: login.php"); // or index.php
exit();
