<?php

include '../qrlib.php';

$PNG_TEMP_DIR = 'temp/';
$PNG_WEB_DIR  = 'temp/';

$file = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email   = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $body    = trim($_POST['body']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $data = 'mailto:' . $email;

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

        $file = $PNG_TEMP_DIR . md5($data) . '.png';

        QRcode::png($data, $file, 'M', 5, 2);
    }
}

include 'includes/header.php';
?>

<div class="panel">

    <h2>📧 Email</h2>

    <form method="post">

        <input
            type="email"
            name="email"
            placeholder="correo@ejemplo.com"
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

    <?php if ($file): ?>

    <div class="qr">

        <img src="<?= $PNG_WEB_DIR . basename($file) ?>">

        <p style="margin-top:15px;">
            Al escanear se abrirá el cliente de correo.
        </p>

    </div>

    <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>
