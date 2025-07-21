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

// Function to fetch data with countdown and optional filtering
function fetchData($conn, $tableName, $highlightRows = false, $filterByDays = false) {
    // Get the current date
    $currentDate = date('Y-m-d');

    // Adjust the SQL query based on whether we need to filter by days
    if ($filterByDays) {
        // Only select rows where days_diff is less than or equal to 365
        $sql = "SELECT *, DATEDIFF(?, tarikh) AS days_diff FROM $tableName HAVING days_diff <= 365";
    } else {
        // Select all data regardless of the date
        $sql = "SELECT *, DATEDIFF(?, tarikh) AS days_diff FROM $tableName";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $currentDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
		// Read the content from the text file
		$bodyContent = file_get_contents('email_body.txt');

		// URL encode the content to ensure it works properly in the mailto link
		$bodyContentEncoded = urlencode($bodyContent);
		
		// Replace '+' with '%20' if needed
		$bodyContentEncoded = str_replace('+', '%20', $bodyContentEncoded);	
		
        echo "<div class='container2'><table><tr><th>Nama</th><th>No. Rujukan</th><th>ID Subsidiari</th><th>Tarikh Deposit</th><th>Tempoh Pegangan (Bulan)</th><th>No. Kontrak / No. Kad Pengenalan</th><th>Amaun (RM)</th><th>Email</th><th>No. Tel</th><th>File</th><th>Days Left/Overdue</th><th>Action</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $rowClass = '';
            $daysLeftOrOverdue = 365 - $row['days_diff'];
            $overdueText = '';

            if ($highlightRows && $row['days_diff'] > 365) {
                $rowClass = 'style="background-color: red;"';
                $daysLeftOrOverdue = -($row['days_diff'] - 365);
                $overdueText = "Overdue by " . abs($daysLeftOrOverdue) . " days";
            } else {
                $overdueText = "$daysLeftOrOverdue baki hari";
            }

            echo "<tr $rowClass>
        <td>{$row['fname']}</td>
        <td>{$row['rujukan']}</td>
        <td>{$row['subsidiasi']}</td>
        <td>{$row['tarikh']}</td>
        <td>{$row['tempoh']}</td>
        <td>{$row['kontrak']}</td>
        <td>{$row['amaun']}</td>
        <td>
            <a href='mailto:{$row['emel']}?subject=PELARASAN%20DEPOSIT&body=$bodyContentEncoded'>
                {$row['emel']}
            </a>
        </td>
        <td>{$row['phone']}</td>
        <td><a href='{$row['myfile']}'><ion-icon name='document-outline'></ion-icon></a></td>
        <td class='countdown' data-days-left='$daysLeftOrOverdue'>$overdueText</td>
        <td>
            <form method='post' action='display.php?jenis=$tableName'>
                <input type='hidden' name='delete_id' value='{$row['id']}'>
                <button type='submit' name='delete'>Hapus</button>
            </form>
            <form method='get' action='editdata.php'>
                <input type='hidden' name='edit_id' value='{$row['id']}'>
                <input type='hidden' name='jenis' value='$tableName'>
                <button type='submit' name='edit'>Edit</button>
            </form>
        </td>
      </tr>";


        }
        echo "</table></div>";
    } else {
        echo "0 rekod";
    }
    $stmt->close();
}

// Handle delete requests
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];
    $jenis = $_GET['jenis'];

    if ($delete_id && $jenis) {
        $sql = "DELETE FROM $jenis WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            $message = "Data berjaya dihapus";
        } else {
            $message = "Error dalam menghapus data: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Determine which subpage to show
$jenis = isset($_GET['jenis']) ? $_GET['jenis'] : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style4.css">
    <title>MyDPS</title>
    <link rel="icon" type="image/png" sizes="16x16" href="LogoKastam.png">
    <style>
        tr[style*="background-color: red;"] {
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div>
        <button id="kembali-btn" onclick="document.location='main.php'" style="font-weight: bold; background-color: #328da8;"><ion-icon name="caret-back-outline"></ion-icon>Kembali</button>
    </div>
    <div class="container">
        <h1 align="center">Data Deposit yang Direkodkan</h1>
        <nav>
            <ul>
                <li data-jenis="deposit_am"><a href="#">DEPOSIT AM (L1111101)</a></li>
                <li data-jenis="deposit_cagaran"><a href="#">DEPOSIT CAGARAN (L1111103)</a></li>
                <li data-jenis="deposit_kuarters"><a href="#">DEPOSIT KUARTERS KERAJAAN (L1111111)</a></li>
                <li data-jenis="all_deposits"><a href="#">365 hari</a></li>
                <li class="history-btn"><a href="history.php">SEJARAH</a></li>
            </ul>
        </nav>
        <div class="content">
            <?php if ($message) { echo "<div class='message'>$message</div>"; } ?>
            <div id="data-container">
                <?php
                switch ($jenis) {
                    case 'deposit_am':
                        echo "<h2>DEPOSIT AM (L1111101)</h2>";
                        fetchData($conn, 'deposit_am', false, true); // No highlight, filter by 365 days
                        break;
                    case 'deposit_cagaran':
                        echo "<h2>DEPOSIT CAGARAN (L1111103)</h2>";
                        fetchData($conn, 'deposit_cagaran', false, true); // No highlight, filter by 365 days
                        break;
                    case 'deposit_kuarters':
                        echo "<h2>DEPOSIT KUARTERS KERAJAAN (L1111111)</h2>";
                        fetchData($conn, 'deposit_kuarters', false, true); // No highlight, filter by 365 days
                        break;
                    case 'all_deposits':
                        echo "<h2>365 hari</h2>";
                        echo "";
                        fetchData($conn, 'deposit_am', true); // Highlight overdue rows
                        fetchData($conn, 'deposit_cagaran', true); // Highlight overdue rows
                        fetchData($conn, 'deposit_kuarters', true); // Highlight overdue rows
                        break;
                    default:
                        echo "<br><h2 align='center'> Sila pilih jenis deposit daripada menu diatas.</h2>";
                }
                ?>
            </div>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        // Hide message after 5 seconds
        setTimeout(() => {
            const messageDiv = document.querySelector('.message');
            if (messageDiv) {
                messageDiv.style.display = 'none';
            }
        }, 5000); // 5000 milliseconds = 5 seconds

        // Handle navigation clicks
        document.querySelectorAll('nav ul li').forEach(item => {
            item.addEventListener('click', () => {
                const jenis = item.getAttribute('data-jenis');
                fetch(`display.php?jenis=${jenis}`)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        document.getElementById('data-container').innerHTML = doc.querySelector('#data-container').innerHTML;
                    });
            });
        });

        // Countdown update script
        function updateCountdowns() {
            const countdownElements = document.querySelectorAll('.countdown');
            countdownElements.forEach(element => {
                let daysLeft = parseInt(element.getAttribute('data-days-left'), 10);
                if (daysLeft < 0) {
                    element.textContent = `Overdue by ${Math.abs(daysLeft)} days`;
                } else {
                    element.textContent = `${daysLeft} days left`;
                }
                daysLeft--;
                element.setAttribute('data-days-left', daysLeft);
            });
        }

        // Update countdown every 24 hours
        setInterval(updateCountdowns, 24 * 60 * 60 * 1000); // 24 hours

        // Initial countdown update on page load
        updateCountdowns();
    </script>
</body>
</html>

<?php
$conn->close();
?>
