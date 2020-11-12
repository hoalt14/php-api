<?php
$servername = "ip or domain server database";
$username   = "user";
$password   = "password";
$dbname     = "database name";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


define('BASE_URL',   'http://room.rent.com/admin/');
define('BASE_API',   'http://room.rent.com/api/');
define('BASE_PUBLIC',   'http://room.rent.com/public/');
define('BASE_UPLOAD',   'http://room.rent.com/upload/');
