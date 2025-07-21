<?php
// Database connection
include('common.php'); // This should define the $conn variable

// Message variable
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verify_deposit'])) {
    $id = $_POST['id'];
    $jenis = $_POST['jenis'];  // Add a hidden input to the form to include the deposit type
    $table = '';

    if ($jenis == 'am') {
        $table = 'deposit_am';
    } elseif ($jenis == 'cagaran') {
        $table = 'deposit_cagaran';
    } elseif ($jenis == 'kuarters') {
        $table = 'deposit_kuarters';
    }

    $sql = "UPDATE $table SET status='Disahkan' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        $successMessage = "Deposit telah disahkan.";
    } else {
        $successMessage = "Error updating record: " . mysqli_error($conn);
    }
}

// Fetch unverified deposits for admin to review
$unverified_result = [];
$verified_result = [];

foreach (['deposit_am', 'deposit_cagaran', 'deposit_kuarters'] as $table) {
    $unverified_sql = "SELECT * FROM $table WHERE status='Belum Disahkan'";
    $unverified_result[$table] = mysqli_query($conn, $unverified_sql);

    $verified_sql = "SELECT * FROM $table WHERE status='Disahkan'";
    $verified_result[$table] = mysqli_query($conn, $verified_sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/adstyle.css">
    <link rel="icon" type="image/png" sizes="16x16" href="LogoKastam.png">
    <script>
        // JavaScript to make the message disappear after a few seconds
        window.onload = function() {
            const messageBox = document.getElementById('success-message');
            if (messageBox) {
                setTimeout(function() {
                    messageBox.style.display = 'none';
                }, 3000); // 3000 milliseconds = 3 seconds
            }
        };
    </script>
</head>
<body>

<div class="container2">
	<hr>
    <h3>Admin Panel</h3>
    <hr>
	<nav>
        <ul>
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Success message that disappears after a few seconds -->
    <?php if ($successMessage): ?>
        <div id="success-message" class="alert alert-success">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>
</div>

<h2>Deposit Belum Disahkan</h2>
<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Jenis Deposit</th>
            <th>No.Rujukan</th>
			<th>ID subsidiari</th>
            <th>Tarikh</th>
			<th>Pegangan (Bulan)</th>
			<th>No. Kontrak/Pengenalan</th>
            <th>Amaun</th>
			<th>Emel</th>
			<th>No. Tel</th>
			<th>status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($unverified_result as $table => $result) { ?>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['fname']; ?></td>
                    <td><?php echo str_replace('deposit_', '', $table); ?></td>
                    <td><?php echo $row['rujukan']; ?></td>
					<td><?php echo $row['subsidiasi']; ?></td>
                    <td><?php echo $row['tarikh']; ?></td>
					<td><?php echo $row['tempoh']; ?></td>
					<td><?php echo $row['kontrak']; ?></td>
                    <td><?php echo $row['amaun']; ?></td>
					<td><?php echo $row['emel']; ?></td>
					<td><?php echo $row['phone']; ?></td>
					<td><?php echo $row['status']; ?></td>
                    <td>
                        <form method="post" action="admin.php">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="jenis" value="<?php echo str_replace('deposit_', '', $table); ?>">
                            <button type="submit" name="verify_deposit">Sahkan</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>

<h2>Telah Disahkan</h2>
<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Jenis Deposit</th>
            <th>No.Rujukan</th>
			<th>ID subsidiari</th>
            <th>Tarikh</th>
			<th>Pegangan (Bulan)</th>
			<th>No. Kontrak/Pengenalan</th>
            <th>Amaun</th>
			<th>Emel</th>
			<th>No. Tel</th>
			<th>File</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($verified_result as $table => $result) { ?>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['fname']; ?></td>
                    <td><?php echo str_replace('deposit_', '', $table); ?></td>
                    <td><?php echo $row['rujukan']; ?></td>
					<td><?php echo $row['subsidiasi']; ?></td>
                    <td><?php echo $row['tarikh']; ?></td>
					<td><?php echo $row['tempoh']; ?></td>
					<td><?php echo $row['kontrak']; ?></td>
                    <td><?php echo $row['amaun']; ?></td>
					<!-- Add mailto with subject and body -->
					<td><a href="mailto:<?php echo $row['emel']; ?>?subject=Predefined%20Subject&body=This%20is%20a%20predefined%20message%20body"><?php echo $row['emel']; ?></a></td>
					<td><?php echo $row['phone']; ?></td>
					<td><?php echo $row['myfile']; ?></td>
                </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
