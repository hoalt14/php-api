<?php
$servername = "localhost";
$username   = "3men";
$password   = "password";
$dbname     = "qlnt";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



define('BASE_URL',   'http://testphp.newpinetech.com/admin/');
define('BASE_API',   'http://testphp.newpinetech.com/api/');
define('BASE_PUBLIC',   'http://testphp.newpinetech.com/public/');
define('BASE_UPLOAD',   'http://testphp.newpinetech.com/upload/');
