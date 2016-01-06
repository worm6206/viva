<?php
$dir    = './';
// $files = scandir($dir);
// unset($files[0]);
// unset($files[1]);

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
<br>
<a type="button" class="btn btn-primary btn-xs" role="button" target="_self" href="allp.php">Use Precompute</a>
<br>
<br>

<?php 

foreach(array_reverse($files) as $key=>$value): 
if (strpos($value,'mtx') !== false) {
?>
    <a type="button" class="btn btn-default" target="main" href="./all.html?<?php echo $value; ?>"><?php echo "[".filesize($value). "]<br>" . $value ; ?></a><br><br>
    <?php } endforeach; ?>
