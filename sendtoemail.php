<?php
// sendtoemail.php

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydps";

// Admin email addresses
$admin1_email = "admin1@example.com";
$admin2_email = "admin2@example.com";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch data based on ID
function fetchDataById($conn, $tableName, $id) {
    $sql = "SELECT * FROM $tableName WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    return $data;
}

// Function to send email
function sendEmail($to, $subject, $message) {
    $headers = "From: noreply@example.com\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    return mail($to, $subject, $message, $headers);
}

// Handle delete request
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];
    $jenis = $_GET['jenis'];
    $user_email = $_POST['user_email'];

    if ($delete_id && $jenis && $user_email) {
        // Fetch the data before deletion
        $data = fetchDataById($conn, $jenis, $delete_id);

        $sql = "DELETE FROM $jenis WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            $message = "Data berjaya dihapus";
            $email_subject = "Data Deleted Notification";
            $email_body = "The following data has been deleted:<br>";
            foreach ($data as $key => $value) {
                $email_body .= "<b>$key:</b> $value<br>";
            }

            // Send email to user
            sendEmail($user_email, $email_subject, $email_body);
            // Send email to admins
            sendEmail($admin1_email, $email_subject, $email_body);
            sendEmail($admin2_email, $email_subject, $email_body);
        } else {
            $message = "Error dalam menghapus data: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style4.css">
    <title>MyDPS</title>
</head>
<body>
    <div class="container">
        <h1 align="center">Delete Data and Send Email</h1>
        <?php if ($message) { echo "<div class='message'>$message</div>"; } ?>
        <form method="post" action="sendtoemail.php?jenis=<?php echo htmlspecialchars($_GET['jenis']); ?>">
            <label for="delete_id">ID to Delete:</label>
            <input type="number" id="delete_id" name="delete_id" required>
            <label for="user_email">Your Email:</label>
            <input type="email" id="user_email" name="user_email" required>
            <button type="submit" name="delete">Delete and Send Email</button>
        </form>
    </div>
    <script>
        // Hide message after 5 seconds
        setTimeout(() => {
            const messageDiv = document.querySelector('.message');
            if (messageDiv) {
                messageDiv.style.display = 'none';
            }
        }, 5000); // 5000 milliseconds = 5 seconds
    </script>
</body>
</html>
