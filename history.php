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

// Function to fetch and display data from history table with search functionality
function fetchHistoryData($conn, $searchTerm = '') {
    $sql = "SELECT * FROM history";
    if ($searchTerm != '') {
        $sql .= " WHERE (fname LIKE '%$searchTerm%' OR rujukan LIKE '%$searchTerm%' OR subsidiasi LIKE '%$searchTerm%' OR tarikh LIKE '%$searchTerm%' OR tempoh LIKE '%$searchTerm%' OR kontrak LIKE '%$searchTerm%' OR amaun LIKE '%$searchTerm%' OR emel LIKE '%$searchTerm%' OR phone LIKE '%$searchTerm%' OR source_table LIKE '%$searchTerm%')";
    }
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<form method='POST' action='history.php' id='historyForm'>";
        echo "<input type='submit' name='delete' value='Hapus' id='deleteButton' style='display:none; margin-bottom: 10px;'>";
        echo "<table border='1'>
                <thead>
                    <tr>
                        <th><input type='checkbox' id='select-all' title='Select All'></th>
                        <th>Nama</th>
                        <th>No. Rujukan</th>
                        <th>ID Subsidiari</th>
                        <th>Tarikh Deposit</th>
                        <th>Tempoh Pegangan (Bulan)</th>
                        <th>No. Kontrak / No. Kad Pengenalan</th>
                        <th>Amaun (RM)</th>
                        <th>Email</th>
                        <th>No. Tel</th>
                        <th>File</th>
                        <th>Source Table</th>
                    </tr>
                </thead>
                <tbody>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td><input type='checkbox' name='delete_ids[]' value='{$row['id']}' class='record-checkbox'></td>
                    <td>{$row['fname']}</td>
                    <td>{$row['rujukan']}</td>
                    <td>{$row['subsidiasi']}</td>
                    <td>{$row['tarikh']}</td>
                    <td>{$row['tempoh']}</td>
                    <td>{$row['kontrak']}</td>
                    <td>{$row['amaun']}</td>
                    <td>{$row['emel']}</td>
                    <td>{$row['phone']}</td>
                    <td><a href='uploads/{$row['myfile']}'><ion-icon name='document-outline'></ion-icon></a></td>
                    <td>{$row['source_table']}</td>
                  </tr>";
        }
        echo "</tbody></table>";
        echo "</form>";
    } else {
        echo "Tiada rekod dijumpai.";
    }
}

// Handle deletion of selected records
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
        $delete_ids = $_POST['delete_ids'];
        $delete_ids_string = implode(',', array_map('intval', $delete_ids));

        // Delete records from the history table
        $conn->query("DELETE FROM history WHERE id IN ($delete_ids_string)");

        echo "<script>alert('Rekod Berjaya Dipadam');</script>";
        echo "<script>window.location = 'history.php';</script>";
        exit;
    } else {
        echo "<script>alert('Tiada Rekod Dipilih untuk Dipadam');</script>";
    }
}

// Get the search term if it exists
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style3.css">
    <title>MyDPS</title>
    <link rel="icon" type="image/png" sizes="16x16" href="LogoKastam.png">
</head>
<body>
	<div class="nav-buttons-wrapper">
		<div class="nav-buttons" style="margin-top: 20px;">
			<button onclick="document.location='main.php'"><ion-icon name="home" title="Balik Ke Paparan Utama"></ion-icon></button>
			<button onclick="document.location='display.php'"><ion-icon name="caret-back" title="Kembali ke rekod"></ion-icon>&nbsp;&nbsp;Kembali</button>
		</div>
	</div>
    <h1>Sejarah Data Yang Direkodkan</h1>
    <form method="get" action="history.php">
        <input type="text" name="search" placeholder="Cari..." value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit">Cari &nbsp;&nbsp;<span><ion-icon name="search"></ion-icon></span></button>
    </form>
    <div>
        <?php fetchHistoryData($conn, $searchTerm); ?>
    </div>
    <script>
        // Show or hide the delete button based on checkbox selection
        const checkboxes = document.querySelectorAll('.record-checkbox');
        const deleteButton = document.getElementById('deleteButton');
        const selectAllCheckbox = document.getElementById('select-all');

        function toggleDeleteButton() {
            const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
            deleteButton.style.display = anyChecked ? 'inline-block' : 'none';
        }

        // Toggle individual checkboxes
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', toggleDeleteButton);
        });

        // Toggle all checkboxes and update delete button state
        selectAllCheckbox.addEventListener('change', function() {
            checkboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
            toggleDeleteButton();
        });
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

<?php
$conn->close();
?>
