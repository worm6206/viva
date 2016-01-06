<?php
$dir    = './';
$files = scandir($dir);
unset($files[0]);
unset($files[1]);
// echo "$files[2]";
echo '<span style="color:#F00;text-align:center;">Reload before drawing next graph</span>';
?>

<?php foreach($files as $key=>$value): 
if (strpos($value,'mtx') !== false) {
?>
    <a target="main" href="./all.html#<?php echo $value; ?>"><?php echo "[".filesize($value). "]<br>" . $value ; ?></a><br>
    <?php } endforeach; ?>
