<?php
if(isset($_POST['btn-upload']))
{
     $pic = rand(1000,100000)."-".$_FILES['pic']['name'];
     $passin = $_POST["inputPassword"];
    $pic_loc = $_FILES['pic']['tmp_name'];
     $folder="data/";
     if(md5($passin) != "d8451360c9eb181a3fbd8e1e4e3e6ea2"){
     	?><script>alert('password incorrect');</script><?php
     }else{
	     if(move_uploaded_file($pic_loc,$folder.$pic))
	     {
	        ?><script>alert('successfully uploaded');</script><?php
	     }
	     else
	     {
	        ?><script>alert('error while uploading file');</script><?php
	     }
     }

}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>File Uploading With PHP and MySql</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<style type="text/css">

</style>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
	<div style="width: 63px;">
		<input type="password" class="form-control input-sm" name="inputPassword" placeholder="PW" size="3">
	</div>
	<div>
		<label class="btn btn-primary btn-sm" for="my-file-selector">
		    <input id="my-file-selector" type="file" style="display:none;" name="pic">
		    Browse
		</label><br>
		<button type="submit" class="btn btn-primary btn-sm" name="btn-upload">Upload</button>
	</div>
</form>
</body>
</html>