<?php
session_start();
	$username = $_SESSION['username'];
	$password = $_SESSION['password'];
	
	if (!isset($username))
	{
		?>
		<script>
			alert('Session Habis');
			document.location='index.php';
		</script>
		<?php
		exit;
	}
	
	include "apaini.php";
	$id = $_GET['id'];
	
	$queryinfo = mysqli_query($connect, "SELECT * FROM user WHERE md5(id)='$id'");
	$info = mysqli_fetch_array($queryinfo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  	<title>Take a Photo - Profil</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/main.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="css/bootstrap.css">
<script src="jquery.min.js"></script>
<script src="bootstrap.min.js"></script>
</head>
<body>
<div class="topnav">
<div class= "row">
<br>
<div class="column side1">
  <ul>
  <li><a href="kuda.php"><font size="5">Pengguna</font></a></li>
  <li><a href="beranda1.php"><font size="5">Beranda</font></a></li>
</ul>
  </div>
  
  <div class="column middle1">
  <form class="form-horizontal" method="post" action="logout.php">
		<div class="form-group">        
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary" name="logout">
						Logout
						</button>
						</div>
  </div>
  </form>
  <br>
  </div>
</div>

</div>

	<div class="container">
		<h2>Edit Data Pengguna</h2>
 		<form class="form-horizontal" method="post" enctype="multipart/form-data" action="edit1.php">
    			<input type='hidden' name='id' value='<?=$id?>'>
				
				<div class="form-group">
      				<label class="control-label col-sm-2" for="nama">Username:</label>
      				<div class="col-sm-4">
        				<input type="text" class="form-control" placeholder="Masukkan Username" name="username2" value="<?=$info['username']?>">
      				</div>
    			</div>
				
				<div class="form-group">
		<label class="control-label col-sm-2" for="password">Password:</label>
      	<div class="col-sm-4">
        <input type="password" class="form-control" placeholder="Masukkan Password" name="password2" value="<?=$info['password']?>">
      	</div>
    </div>
				
				<div class="form-group">
		<label class="control-label col-sm-2" for="nama">Nama Lengkap:</label>
      	<div class="col-sm-4">
        <input type="text" class="form-control" placeholder="Masukkan Nama" name="nama" value="<?=$info['nama']?>">
      	</div>
    </div>
	
	<div class="form-group">
		<label class="control-label col-sm-2" for="email">Email:</label>
      	<div class="col-sm-4">
        <input type="email" class="form-control" placeholder="Masukkan Email" name="email" value="<?=$info['email']?>">
      	</div>
    </div>
	
	<div class="form-group">
	<label class="control-label col-sm-2" for="tanggal">Tanggal Lahir:</label>
		<div class="col-sm-4">
		<input type="date" class="form-control" placeholder="Masukkan Tanggal Lahir" name="tanggal" value="<?=$info['tanggal']?>">
		</div>
	</div>
	
	<div class="form-group">        
    <label class="control-label col-sm-2" for="jk">Jenis Kelamin:</label>
      	<div class="col-sm-4">          
        <label class="radio-inline" ><input type="radio" id="jk" name="jk" value="Pria" <?php if ($info['jk'] == "Pria") echo "checked"; ?>> Pria</label>
						<label class="radio-inline"><input type="radio" id="jk" name="jk" value="Wanita" <?php if ($info['jk'] == "Wanita") echo "checked"; ?>> Wanita</label>
      	</div>
     </div>
	
	<div class="form-group">
	<div class="col-sm-offset-2 col-sm-5">
	<input type="file" class="btn btn-primary" name="files">
	</div>
	</div>
				
    			
				<div class="form-group">        
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-success" name="edit">Edit</button>
						<button type="reset" class="btn btn-warning">Reset</button>
					</div>
				</div>
		</form>
    		</div>
		<div class="col-sm-10 col-sm-offset-1">
		<?php
			if (isset($_POST['edit']))
			{	
				$id = $_POST['id'];
				$username2 = $_POST['username2'];
				$password2 = $_POST['password2'];
				$nama = $_POST['nama'];
				$email = $_POST['email'];
				$tanggal = $_POST['tanggal'];
				$jk = $_POST['jk'];
				
				$temp   = $_FILES['files']['tmp_name'];
				$name   = $_FILES['files']['name'];
				$size   = $_FILES['files']['size'];
				$type   = $_FILES['files']['type'];
				$folder = "images/";
				
				move_uploaded_file($temp, $folder.$name);
				
				$queryedit = mysqli_query($connect, "UPDATE user SET username='$username2', password='$password2', nama='$nama', email='$email',tanggal='$tanggal',jk='$jk',img='$name',type_img='$type' WHERE id='$id'");
				
				if ($queryedit)
				{
					?>
					<div class="alert alert-success alert-dismissable">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Success!</strong> Data Pengguna Berhasil Diedit. Klik <a href="admin.php">disini</a> untuk ke profil.
					</div>
					<?php
				}
				else
				{
					?>
					<div class="alert alert-ddanger alert-dismissable">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Failed!</strong> Data Pengguna Gagal Diedit.
					</div>
					<?php
				}	
				
			}
		?>
		</div>
	
</body>
</html>