<?php
include "../qrlib.php";

$PNG_TEMP_DIR = __DIR__ . '/temp/';
$PNG_WEB_DIR  = 'temp/';

if (!file_exists($PNG_TEMP_DIR)) {
    mkdir($PNG_TEMP_DIR, 0777, true);
}

$fileName = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email   = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $body    = trim($_POST['body']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email inválido");
    }

    $data = "mailto:" . $email;

    $params = [];

    if ($subject !== '') {
        $params[] = 'subject=' . rawurlencode($subject);
    }

    if ($body !== '') {
        $params[] = 'body=' . rawurlencode($body);
    }

    if (!empty($params)) {
        $data .= '?' . implode('&', $params);
    }

    $fileName = $PNG_TEMP_DIR . 'email_' . md5($data) . '.png';

    QRcode::png($data, $fileName, 'M', 5, 2);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Email QR Generator</title>

<style>
body{
    margin:0;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#0f172a;
    font-family:Arial,sans-serif;
}

.card{
    width:450px;
    background:#111827;
    color:white;
    padding:25px;
    border-radius:15px;
}

h2{
    text-align:center;
    margin-top:0;
}

input,textarea{
    width:100%;
    box-sizing:border-box;
    padding:10px;
    margin:8px 0;
    border-radius:8px;
    border:1px solid #374151;
    background:#1f2937;
    color:white;
}

textarea{
    height:120px;
    resize:vertical;
}

button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#3b82f6;
    color:white;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    opacity:.9;
}

.qr{
    text-align:center;
    margin-top:20px;
}

.qr img{
    background:white;
    padding:10px;
    border-radius:10px;
}

.back{
    text-align:center;
    margin-top:15px;
}

.back a{
    color:#60a5fa;
    text-decoration:none;
}
</style>

</head>
<body>

<div class="card">

<h2>📧 Email QR Generator</h2>

<form method="post">

    <input
        type="email"
        name="email"
        placeholder="destino@correo.com"
        required>

    <input
        type="text"
        name="subject"
        placeholder="Asunto">

    <textarea
        name="body"
        placeholder="Mensaje predeterminado"></textarea>

    <button type="submit">
        Generar QR
    </button>

</form>

<?php if ($fileName): ?>

<div class="qr">
    <h3>QR generado</h3>
    <img src="<?= $PNG_WEB_DIR . basename($fileName) ?>">
</div>

<?php endif; ?>

<div class="back">
    <a href="index.php">← Volver</a>
</div>

</div>

</body>
</html>