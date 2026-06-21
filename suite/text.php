<?php

include '../qrlib.php';

$PNG_TEMP_DIR = '../temp/';
$PNG_WEB_DIR = '../temp/';

$file = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $text = trim($_POST['text']);

    if ($text !== '') {

        $file = $PNG_TEMP_DIR . md5($text) . '.png';

        QRcode::png($text, $file, 'M', 5, 2);
    }
}

include 'includes/header.php';
?>

<div class="panel">

<h2>📝 Texto</h2>

<form method="post">

    <textarea name="text" placeholder="Escribe tu texto"></textarea>

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