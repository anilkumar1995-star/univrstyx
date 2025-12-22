<?php
header("Content-type: text/css; charset: UTF-8");

$primaryColor = '#eb263d';

$envFile = __DIR__ . '/../../../.env';

if (file_exists($envFile)) {
    $content = file_get_contents($envFile);
    if (preg_match('/PRIMARY_COLOR=([^\n]+)/', $content, $matches)) {
        $primaryColor = trim($matches[1], " \t\n\r\0\x0B'\"");
    }
}
?>

:root {
--bs-primary: <?= $primaryColor ?>;
--bs-primary-dark: <?= $primaryColor ?>;
}

body {
--bs-primary: <?= $primaryColor ?> !important;
}