<?php

include '../qrlib.php';

$PNG_TEMP_DIR = 'temp/';
$PNG_WEB_DIR  = 'temp/';

$file = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first = trim($_POST['first_name']);
    $last  = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $org   = trim($_POST['organization']);
    $title = trim($_POST['title']);

    if ($first !== '' && $phone !== '') {

        $vcard = [
            "BEGIN:VCARD",
            "VERSION:3.0",
            "N:$last;$first;;;",
            "FN:$first $last"
        ];

        if ($org !== '') {
            $vcard[] = "ORG:$org";
        }

        if ($title !== '') {
            $vcard[] = "TITLE:$title";
        }

        $vcard[] = "TEL;TYPE=CELL:$phone";

        if ($email !== '') {
            $vcard[] = "EMAIL:$email";
        }

        $vcard[] = "END:VCARD";

        $data = implode("\r\n", $vcard);

        $file = $PNG_TEMP_DIR . md5($data) . '.png';

        QRcode::png($data, $file, 'M', 5, 2);
    }
}

include 'includes/header.php';
?>

<div class="panel">

    <h2>📇 vCard</h2>

    <form method="post">

        <input
            name="first_name"
            placeholder="Nombre"
            required>

        <input
            name="last_name"
            placeholder="Apellido">

        <input
            name="organization"
            placeholder="Empresa">

        <input
            name="title"
            placeholder="Cargo">

        <input
            name="phone"
            placeholder="+59170000000"
            required>

        <input
            type="email"
            name="email"
            placeholder="correo@ejemplo.com">

        <button type="submit">
            Generar QR
        </button>

    </form>

    <?php if ($file): ?>

    <div class="qr">

        <img src="<?= $PNG_WEB_DIR . basename($file) ?>">

        <p style="margin-top:15px;">
            Compatible con Android y iPhone.
        </p>

    </div>

    <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>
