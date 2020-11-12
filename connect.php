<?php
$servername = "localhost";
$username   = "vinhhyba_mp3zing";
$password   = "QtEDGs68Fmp3zing";
$dbname     = "vinhhyba_mp3zing";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



define('BASE_URL',   'https://zingmp3.tctruyen.com/admin/');
define('BASE_API',   'https://zingmp3.tctruyen.com/api/');
define('BASE_PUBLIC',   'https://zingmp3.tctruyen.com/public/');
define('BASE_UPLOAD',   'https://zingmp3.tctruyen.com/upload/');
?>