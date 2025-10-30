<?php
function getConnection(): mysqli {
    $servername = "localhost"; // usually "localhost"
    $username = "root";        // your MySQL username
    $password = "1234";        // your MySQL password
    $dbname = "db_hotel";      // your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn; // Return connection object for reuse
}
?>
