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



<?php foreach(array_reverse($files) as $key=>$value): 
if (strpos($value,'mtx') !== false) {
?>
    <a target="main" href="./all.html?<?php echo $value; ?>"><?php echo "[".filesize($value). "]<br>" . $value ; ?></a><br>
    <?php } endforeach; ?>
