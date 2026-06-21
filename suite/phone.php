<?php

include '../qrlib.php';

$PNG_TEMP_DIR='temp/';
$PNG_WEB_DIR='temp/';

$file=null;

if($_SERVER['REQUEST_METHOD']==='POST'){

    $phone=trim($_POST['phone']);

    $data='tel:'.$phone;

    $file=$PNG_TEMP_DIR.md5($data).'.png';

    QRcode::png($data,$file,'M',5,2);
}

include 'includes/header.php';
?>

<div class="panel">

<h2>📞 Teléfono</h2>

<form method="post">

<input
type="text"
name="phone"
placeholder="+59170000000"
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