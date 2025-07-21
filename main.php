<?php
// Retrieve message and icon
$message = isset($_GET['message']) ? $_GET['message'] : "";
$icon = isset($_GET['icon']) ? $_GET['icon'] : "";

// Display the message with appropriate icon
if (!empty($message)) {
    echo "<div class='message'>";
    echo "<span class='icon " . $icon . "'></span>"; // Assuming you have CSS classes for icons
    echo "<p>" . $message . "</p>";
    echo "</div>";
}
?>

<!-- Your HTML form and other content -->

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="css/style2.css">
		<title>MyDPS</title>
		<link rel="icon" type="image/png" sizes="16x16" href="LogoKastam.png">
	</head>
	
	<body>
		<div class="container2">
			<h3>Masukkan Data Pembayaran Deposit
				<span>
					<span style="font-family: Arial, sans-serif; font-size: 14px;">
						<a href="logout.php" style="
							text-decoration: none; 
							color: #ffffff; 
							background-color: #007bff; 
							padding: 10px 14px; 
							border-radius: 4px;
						">
							Logout
						</a>
					</span>

					<button onclick="document.location='display.php'" style="font-weight: bold; background-color: #328da8;">Rekod</button>
				</span>
			</h3>
			<hr>
			<form method="post" action="record.php">
				<div class="form-container">
					<div class="form-group">
						<label for="fname">Nama Pendeposit(Individu) /Syarikat :</label>
						<input type="text" id="fname" name="fname">
					</div>
					
					<div class="form-group">
						<label for="jenis">Jenis Akaun Deposit : <span style="color: red;">*</span></label>
						<select id="jenis" name="jenis" required>
							<option value="">Sila Pilih</option>
							<option value="Am">DEPOSIT AM (L1111101)</option>
							<option value="Cagaran">DEPOSIT CAGARAN (L1111103)</option>
							<option value="Kuarters">DEPOSIT KUARTERS KERAJAAN (L1111111)</option>
						</select>
					</div>
					
					<div class="form-group">
						<label for="rujukan">No. Rujukan :</label>
						<input type="text" id="rujukan" name="rujukan">
					</div>
					
					<div class="form-group">
						<label for="subsidiasi">ID Subsidiari :</label>
						<input type="number" id="subsidiasi" name="subsidiasi">
					</div>
					
					<div class="form-group">
						<label for="tarikh">Tarikh Deposit:<span style="color: red;">*</span></label>
						<input type="date" id="tarikh" name="tarikh" required>
					</div>
					
					<div class="form-group">
						<label for="tempoh">Tempoh Pegangan (Bulan):</label>
						<input type="number" id="tempoh" name="tempoh">
					</div>
					
					<div class="form-group">
						<label for="kontrak">No. Kontrak / No. Kad Pengenalan :</label>
						<input type="text" id="kontrak" name="kontrak">
					</div>
					
					<div class="form-group">
						<label for="amaun">Amaun (<strong>RM</strong>) :</label>
						<input type="number" id="amaun" name="amaun" step="0.01" min="0" placeholder="0.00">
					</div>
					
					<div class="form-group">
						<label for="emel">Email :<span style="color: red;">*</span></label>
						<input type="email" id="emel" name="emel" placeholder="e.g you@gmail.com" required>
					</div>
					
					<div class="form-group">
						<label for="phone">Nombor Tel/Pej :</label>
						<input type="text" id="phone" name="phone">
					</div>
					
					<div class="form-group">
						<label for="myfail">Pilih Fail :</label>
						<input type="file" id="myfile" name="myfile" style="background-color:white;">
					</div>
					
					<div class="form-group button-group">
						<button type="reset"><b>Semula</b>&nbsp;<span class="margin-top: 5px;"><ion-icon name="reload-outline"></ion-icon></span></button>&nbsp;&nbsp;
						<button type="submit"><b>Hantar</b>&nbsp;&nbsp;<span class="margin-top: 5px;"><ion-icon name="send"></ion-icon></span></button>
					</div>
					
				</div>
				<hr>
			</form>
		</div>
		<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
		<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
		<script>
		$(document).ready(function(){
		  $('[data-toggle="popover"]').popover();
		});
		$(document).ready(function() {

		if(window.location.href.indexOf('#login') != -1) {
		  $('#login').modal('show');
		}

		});
		</script>
	</body>
</html>
