<?php
$dir    = './';
// $files = scandir($dir);
// unset($files[0]);
// unset($files[1]);

if(isset($_POST['btn-upload']))
{
     $pic = rand(1000,100000)."-".$_FILES['pic']['name'];
     $passin = $_POST["inputPassword"];
    $pic_loc = $_FILES['pic']['tmp_name'];
     $folder="";
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

function scan_dir($dir) {
    $ignored = array('.', '..', '.svn', '.htaccess');

    $files = array();    
    foreach (scandir($dir) as $file) {
        if (in_array($file, $ignored)) continue;
        $files[$file] = filesize($file);
    }

    arsort($files);
    $files = array_keys($files);

    return ($files) ? $files : false;
}

$files = scan_dir($dir);

?>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<hr>
<a type="button" class="btn btn-primary btn-xs" role="button" target="_blank" href="https://github.com/worm6206/viva/blob/master/mtx/all.js">Javascript Code</a>
<hr>
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
<hr>
<!-- <a type="button" class="btn btn-primary btn-xs" role="button" target="_self" href="allp.php">Use Precompute</a>
<br>
<br> -->

<?php 

foreach(array_reverse($files) as $key=>$value): 
if (strpos($value,'mtx') !== false) {
?>
    <a type="button" class="btn btn-default btn-sm" target="main" href="./all.html?<?php echo $value; ?>"><?php echo "[".filesize($value). "]<br>" . $value ; ?></a><br><br>
    <?php } endforeach; ?>
