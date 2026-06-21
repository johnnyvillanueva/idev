<?php
include "../qrlib.php";

$PNG_TEMP_DIR = __DIR__ . '/temp/';
$PNG_WEB_DIR  = 'temp/';

if (!file_exists($PNG_TEMP_DIR)) {
    mkdir($PNG_TEMP_DIR, 0777, true);
}

$errorCorrectionLevel = $_POST['level'] ?? 'M';
$matrixPointSize = $_POST['size'] ?? 5;

$fileName = null;

/* =========================
   GENERAR VCARD
========================= */
if (isset($_POST['first_name'])) {

    $first = trim($_POST['first_name']);
    $last  = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    if ($first === '' || $phone === '') {
        die("Nombre y teléfono son obligatorios");
    }

    $vcard = [
        "BEGIN:VCARD",
        "VERSION:3.0",
        "N:$last;$first;;;",
        "FN:$first $last",
        "TEL;TYPE=CELL:$phone"
    ];

    if ($email !== '') {
        $vcard[] = "EMAIL:$email";
    }

    $vcard[] = "END:VCARD";

    $data = implode("\r\n", $vcard);

    $fileName = $PNG_TEMP_DIR . 'vcard_' . md5($data) . '.png';

    QRcode::png($data, $fileName, $errorCorrectionLevel, $matrixPointSize, 2);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>vCard QR Generator</title>

<style>
    body {
        margin: 0;
        font-family: system-ui, Arial;
        background: linear-gradient(135deg, #0f172a, #1e293b);
        color: #e2e8f0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .card {
        width: 420px;
        background: #111827;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    h2 {
        margin: 0 0 15px;
        font-size: 20px;
        text-align: center;
    }

    .subtitle {
        text-align: center;
        font-size: 13px;
        color: #94a3b8;
        margin-bottom: 20px;
    }

    input, select {
        width: 100%;
        padding: 10px;
        margin: 6px 0;
        border-radius: 8px;
        border: 1px solid #334155;
        background: #0b1220;
        color: white;
        outline: none;
    }

    input:focus {
        border-color: #38bdf8;
    }

    button {
        width: 100%;
        padding: 12px;
        margin-top: 10px;
        background: #38bdf8;
        border: none;
        border-radius: 10px;
        font-weight: bold;
        cursor: pointer;
        color: #0f172a;
        transition: 0.2s;
    }

    button:hover {
        background: #0ea5e9;
    }

    .qr {
        margin-top: 20px;
        text-align: center;
    }

    .qr img {
        background: white;
        padding: 10px;
        border-radius: 10px;
        width: 200px;
    }

    .back {
        text-align: center;
        margin-top: 15px;
        font-size: 13px;
        color: #94a3b8;
    }

    .back a {
        color: #38bdf8;
        text-decoration: none;
    }
</style>
</head>

<body>

<div class="card">

    <h2>📇 vCard QR Generator</h2>
    <div class="subtitle">Crea un contacto escaneable en segundos</div>

    <form method="POST">

        <input name="first_name" placeholder="Nombre" required>
        <input name="last_name" placeholder="Apellido">
        <input name="phone" placeholder="Teléfono" required>
        <input name="email" placeholder="Email">

        <select name="level">
            <option value="L">ECC L</option>
            <option value="M" selected>ECC M</option>
            <option value="Q">ECC Q</option>
            <option value="H">ECC H</option>
        </select>

        <select name="size">
            <?php for ($i=3;$i<=10;$i++): ?>
                <option value="<?= $i ?>">Tamaño <?= $i ?></option>
            <?php endfor; ?>
        </select>

        <button type="submit">Generar QR</button>
    </form>

    <?php if ($fileName): ?>
        <div class="qr">
            <h3>Tu QR</h3>
            <img src="<?= $PNG_WEB_DIR . basename($fileName) ?>">
        </div>
    <?php endif; ?>

    <div class="back">
        <a href="index.php">← Volver</a>
    </div>

</div>

</body>
</html>