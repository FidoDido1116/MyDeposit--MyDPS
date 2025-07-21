<?php
// record.php

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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Collect form data with isset() checks
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : '';
    $rujukan = isset($_POST['rujukan']) ? $_POST['rujukan'] : '';
    $subsidiasi = isset($_POST['subsidiasi']) ? $_POST['subsidiasi'] : null;
    $tarikh = isset($_POST['tarikh']) ? $_POST['tarikh'] : null;
    $tempoh = isset($_POST['tempoh']) ? $_POST['tempoh'] : null;
    $kontrak = isset($_POST['kontrak']) ? $_POST['kontrak'] : '';
    $amaun = isset($_POST['amaun']) ? $_POST['amaun'] : null;
    $emel = isset($_POST['emel']) ? $_POST['emel'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';

    // File upload handling
    $file_uploaded = false;
    $myfile = null;

    if (isset($_FILES["myfile"]) && $_FILES["myfile"]["error"] == 0) {
        $target_dir = "uploads/";
        $myfile = $target_dir . basename($_FILES["myfile"]["name"]);
        if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $myfile)) {
            $file_uploaded = true;
        }
    }

    // Default status is 'Belum Disahkan'
    $status = 'Belum Disahkan';

    // Prepare and bind
    if ($jenis) {
        switch ($jenis) {
            case 'Am':
                $stmt = $conn->prepare("INSERT INTO deposit_am (fname, rujukan, subsidiasi, tarikh, tempoh, kontrak, amaun, emel, phone, myfile, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                break;
            case 'Cagaran':
                $stmt = $conn->prepare("INSERT INTO deposit_cagaran (fname, rujukan, subsidiasi, tarikh, tempoh, kontrak, amaun, emel, phone, myfile, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                break;
            case 'Kuarters':
                $stmt = $conn->prepare("INSERT INTO deposit_kuarters (fname, rujukan, subsidiasi, tarikh, tempoh, kontrak, amaun, emel, phone, myfile, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                break;
            default:
                die("Jenis Deposit Yang Dipilih Tidak Valid");
        }

        $stmt->bind_param("ssisssdssss", $fname, $rujukan, $subsidiasi, $tarikh, $tempoh, $kontrak, $amaun, $emel, $phone, $myfile, $status);

        // Execute the statement
        if ($stmt->execute()) {
            // Insert into history table
            $history_stmt = $conn->prepare("INSERT INTO history (fname, rujukan, subsidiasi, tarikh, tempoh, kontrak, amaun, emel, phone, myfile, source_table) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $history_stmt->bind_param("ssisssdssss", $fname, $rujukan, $subsidiasi, $tarikh, $tempoh, $kontrak, $amaun, $emel, $phone, $myfile, $jenis);
            $history_stmt->execute();
            $history_stmt->close();

            echo "<script>alert('Rekod Berjaya Disimpan');</script>";
            echo "<script>window.location = 'main.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<script>alert('Rekod Tidak Valid');</script>";
        echo "<script>window.location = 'main.php';</script>";
    }
}

$conn->close();
?>
