<?php
ini_set('display_errors', 1);

/** Denied access app directories */
define('ROOTPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Start the app.
$DS = DIRECTORY_SEPARATOR;
include __DIR__ . $DS . 'app' . $DS . 'core' . $DS . 'init.php';

$app = new App;
$app->startApp();