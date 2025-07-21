<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="css/style2.css">
		<title>MyDPS</title>
		<link rel="icon" type="image/png" sizes="16x16" href="LogoKastam.png">
		
		<style>
			body{
				background-image: url('images/bg.png');
				background-repeat: no-repeat;
				background-position: center;
				background-attachment: fixed;
				background-size: cover;
			}
			ion-icon {
				font-size: 50px;
				color: yellow;
			}
			.container1{
				
				padding: 20px;
				border-radius: 8px;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
				text-align: center;
			}
			.container1{
				background-color: #303030;
				border: 2px solid #303030;
			}
		</style>
	</head>
	
	<body>
		<div style="text-align: center;">
			<div class="container1">
				<div align="center">
					<h1 style="font-size: 25px; color:white;"><b>Selamat Datang ke Sistem</b></h1>
					<h1 style="font-size: 60px; color:white;"><b>MyDPS</b> <a href="login.php"><ion-icon name="arrow-forward-circle-sharp" title="Masuk"></ion-icon></a></h1>
					<div align="center" style="border: 1px solid white; width: 850px">
                    <img src="images/LogoKastam.png" height="79;">&nbsp;&nbsp;<br>
					<b style="font-size:20px; color:white;">Jabatan Kastam DiRaja Malaysia, Cawangan Lahad Datu</b>
					</div><br>
				</div>
			</div>
		</div>
		<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
		<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
		<script>
			document.addEventListener('keydown', function(event){
				if (event.key === 'Enter'){
					window.location.href = 'login.php';
				}
			});
		</script>
	</body>
</html>