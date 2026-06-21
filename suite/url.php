<?php

include '../qrlib.php';

$PNG_TEMP_DIR='temp/';
$PNG_WEB_DIR='temp/';

$file=null;

if($_SERVER['REQUEST_METHOD']==='POST'){

    $url=trim($_POST['url']);

    if(!preg_match('/^https?:\/\//',$url)){
        $url='https://'.$url;
    }

    $file=$PNG_TEMP_DIR.md5($url).'.png';

    QRcode::png($url,$file,'M',5,2);
}

include 'includes/header.php';
?>

<div class="panel">

<h2>🌍 URL</h2>

<form method="post">

<input
type="text"
name="url"
placeholder="https://ejemplo.com"
required>

<button type="submit">
Generar QR
</button>

</form>

<?php if($file): ?>

<div class="qr">
<img src="<?= $PNG_WEB_DIR.basename($file) ?>">
</div>

<?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>