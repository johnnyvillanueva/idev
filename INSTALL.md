# REQUIREMENTS

- PHP 5
- Extensión PHP GD2 con soporte para JPEG y PNG

# INSTALLATION

Si deseas recrear la caché manualmente, asegúrate de que el directorio `cache` tenga permisos de escritura y que el servidor pueda escribir en él. También verifica que los archivos almacenados en dicho directorio puedan ser leídos si la opción de caché está habilitada.

# CONFIGURATION

Puedes modificar las constantes de configuración en el archivo `qrconfig.php`.

Consulta los comentarios incluidos en el código y la documentación del proyecto para más detalles.

# QUICK START

> **Nota:** Probablemente no deberías utilizar todos estos ejemplos dentro del mismo script.

```php
<?php

// Incluye únicamente este archivo.
// El resto de dependencias se cargarán automáticamente.
include "qrlib.php";

// Genera un código QR y lo guarda en un archivo.
// Nivel de corrección de errores: L, M, Q o H.
// Cada módulo tendrá un tamaño de 4x4 píxeles.
// El código tendrá un borde blanco de 2 módulos.

QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);

// Igual que el ejemplo anterior, pero envía la imagen
// directamente al navegador con las cabeceras adecuadas.
//
// ¡IMPORTANTE!
// Debe ser la PRIMERA y ÚNICA salida del script.
// Cualquier otra salida corromperá la imagen PNG.

QRcode::png('PHP QR Code :)');

// Mostrar benchmark
QRtools::timeBenchmark();

// Reconstruir caché
QRtools::buildCache();

// Generar el código en modo texto (matriz binaria)
// y mostrarlo como HTML usando caracteres Unicode.

$tab = $qr->encode('PHP QR Code :)');
QRspec::debug($tab, true);
```

TCPDF INTEGRATION

Dentro de bindings/tcpdf encontrarás una versión ligeramente modificada del archivo 2dbarcodes.php.

Instala la librería PHP QR Code dentro de la carpeta de TCPDF y reemplaza (o fusiona) el archivo 2dbarcodes.php.

Luego podrás utilizarla de forma similar al ejemplo #50 incluido en TCPDF:

```php
<?php

$style = array(
    'border'  => true,
    'padding' => 4,
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false // array(255,255,255)
);

// Nombre del código: QR
// Nivel de corrección de errores: L, M, Q o H

$pdf->write2DBarcode(
    'PHP QR Code :)',
    'QR,L',
    '',
    '',
    30,
    30,
    $style,
    'N'
);
```