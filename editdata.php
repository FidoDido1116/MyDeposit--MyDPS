<?php
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

// Get the ID and type of deposit
$edit_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;
$jenis = isset($_GET['jenis']) ? $_GET['jenis'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = $_POST['fname'];
    $rujukan = $_POST['rujukan'];
    $subsidiasi = $_POST['subsidiasi'];
    $tarikh = $_POST['tarikh'];
    $tempoh = $_POST['tempoh'];
    $kontrak = $_POST['kontrak'];
    $amaun = $_POST['amaun'];
    $emel = $_POST['emel'];
    $phone = $_POST['phone'];
    $myfile = $_POST['myfile']; // Assuming you handle file uploads separately

    if ($edit_id && $jenis) {
        // Adjust the type specifiers based on your actual data types
        $sql = "UPDATE $jenis SET fname = ?, rujukan = ?, subsidiasi = ?, tarikh = ?, tempoh = ?, kontrak = ?, amaun = ?, emel = ?, phone = ?, myfile = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        // Type specifiers for bind_param
        $stmt->bind_param("ssssssssssi", $fname, $rujukan, $subsidiasi, $tarikh, $tempoh, $kontrak, $amaun, $emel, $phone, $myfile, $edit_id);

        if ($stmt->execute()) {
            $message = "Data berjaya dikemas kini";
        } else {
            $message = "Error dalam mengemas kini data: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Fetch existing data
$sql = "SELECT * FROM $jenis WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $edit_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data tidak dijumpai.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="16x16" href="LogoKastam.png">
    <title>Edit Data</title>
	<style>
		/* Reset some basic styles */
		body, h1, p, label, input, button {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: Arial, sans-serif;
			background-color: #a8b8d0;
			color: #333;
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
			padding: 20px; /* Add padding to avoid content touching edges on small screens */
		}

		.container {
			background-color: #fff;
			padding: 20px;
			border-radius: 8px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			max-width: 100%; /* Set max-width to 100% */
			width: 100%;
			max-width: 800px; /* Keep a max-width for larger screens */
			margin: 0 auto; /* Center container horizontally */
		}

		h1 {
			text-align: center;
			margin-bottom: 20px;
			font-size: 24px;
			color: #328da8;
		}

		form {
			display: flex;
			flex-wrap: wrap;
		}

		.form-group {
			display: flex;
			flex-direction: row;
			align-items: center;
			width: 50%; /* Two items per row */
			padding: 10px;
			box-sizing: border-box; /* Ensure padding is included in width */
		}

		.form-group label {
			width: 30%;
			margin-right: 10px;
			font-weight: bold;
			color: #333;
			text-align: right;
		}

		.form-group input[type="text"],
		.form-group input[type="email"],
		.form-group input[type="date"] {
			width: 70%;
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 4px;
			font-size: 16px;
		}

		input[type="text"]:focus,
		input[type="email"]:focus,
		input[type="date"]:focus {
			border-color: #328da8;
			outline: none;
		}

		button {
			background-color: #328da8;
			color: #fff;
			border: none;
			cursor: pointer;
			font-weight: bold;
			padding: 10px;
			border-radius: 4px;
			margin-top: 20px;
			width: 100%;
		}

		button:hover {
			background-color: #286c7d;
		}

		button:focus {
			outline: none;
		}

		.message {
			background-color: #e0f7fa;
			color: #00796b;
			padding: 10px;
			border-radius: 4px;
			margin-bottom: 20px;
			text-align: center;
		}

		#kembali-btn {
			margin-bottom: 20px;
			padding: 10px 15px;
			background-color: #328da8;
			color: #fff;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			text-align: center;
			display: inline-block;
			text-decoration: none;
			width: 100%; /* Make the button full-width */
		}

		#kembali-btn:hover {
			background-color: #286c7d;
		}

		#kembali-btn:focus {
			outline: none;
		}

		/* Responsive adjustments */
		@media (max-width: 768px) {
			.form-group {
				width: 100%; /* Stack fields vertically on smaller screens */
			}

			h1 {
				font-size: 20px;
			}

			button {
				padding: 10px;
				font-size: 14px;
			}

			.form-group label {
				width: 100%;
				text-align: left;
				margin-bottom: 5px;
			}

			.form-group input[type="text"],
			.form-group input[type="email"],
			.form-group input[type="date"] {
				width: 100%;
			}

			.container {
				padding: 15px; /* Reduce padding in the container for small screens */
			}
		}

	</style>
</head>
<body>
    <div>
        <button id="kembali-btn" onclick="document.location='display.php?jenis=<?php echo htmlspecialchars($jenis); ?>'" style="font-weight: bold; background-color: #328da8;"><ion-icon name="caret-back-outline"></ion-icon>Kembali</button>
    </div>
    <div class="container">
        <h1>Kemas kini Data Deposit</h1>
        <?php if (isset($message)) { echo "<div class='message'>$message</div>"; } ?>
        <form method="post">
    <div class="form-group">
        <label for="fname">Nama:</label>
        <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($data['fname']); ?>">
    </div>
    <div class="form-group">
        <label for="rujukan">No. Rujukan:</label>
        <input type="text" id="rujukan" name="rujukan" value="<?php echo htmlspecialchars($data['rujukan']); ?>">
    </div>
    <div class="form-group">
        <label for="subsidiasi">ID Subsidiari:</label>
        <input type="text" id="subsidiasi" name="subsidiasi" value="<?php echo htmlspecialchars($data['subsidiasi']); ?>">
    </div>
    <div class="form-group">
        <label for="tarikh">Tarikh Deposit:</label>
        <input type="date" id="tarikh" name="tarikh" value="<?php echo htmlspecialchars($data['tarikh']); ?>">
    </div>
    <div class="form-group">
        <label for="tempoh">Tempoh Pegangan (Bulan):</label>
        <input type="text" id="tempoh" name="tempoh" value="<?php echo htmlspecialchars($data['tempoh']); ?>">
    </div>
    <div class="form-group">
        <label for="kontrak">No. Kontrak / No. Kad Pengenalan:</label>
        <input type="text" id="kontrak" name="kontrak" value="<?php echo htmlspecialchars($data['kontrak']); ?>">
    </div>
    <div class="form-group">
        <label for="amaun">Amaun (RM):</label>
        <input type="text" id="amaun" name="amaun" value="<?php echo htmlspecialchars($data['amaun']); ?>">
    </div>
    <div class="form-group">
        <label for="emel">Email:</label>
        <input type="email" id="emel" name="emel" value="<?php echo htmlspecialchars($data['emel']); ?>">
    </div>
    <div class="form-group">
        <label for="phone">No. Tel:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($data['phone']); ?>">
    </div>
    <div class="form-group">
        <label for="myfile">File:</label>
        <input type="file" id="myfile" name="myfile" value="<?php echo htmlspecialchars($data['myfile']); ?>">
    </div>
    <button type="submit">Kemas Kini</button>
</form>

    </div>
</body>
</html>

<?php
$conn->close();
?>
