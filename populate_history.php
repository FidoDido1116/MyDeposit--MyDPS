<?php
// populate_history.php

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydps";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert existing records into history table
$tables = ['deposit_am', 'deposit_cagaran', 'deposit_kuarters'];

foreach ($tables as $table) {
    $sql = "INSERT INTO history (nama, rujukan, subsidiasi, tarikh, tempoh, kontrak, amaun, emel, file_path, source_table)
            SELECT nama, rujukan, subsidiasi, tarikh, tempoh, kontrak, amaun, emel, file_path, '$table' FROM $table";
    if ($conn->query($sql) === TRUE) {
        echo "Records from $table inserted into history table successfully.<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
