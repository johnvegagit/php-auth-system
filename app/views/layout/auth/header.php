<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= $_ENV['BASEURL'] ?>public/assets/style/index.css">
    <script src="<?= $_ENV['BASEURL'] ?>public/assets/script/signup.js" defer></script>
    <script src="<?= $_ENV['BASEURL'] ?>public/assets/script/login.js" defer></script>
    <script src="<?= $_ENV['BASEURL'] ?>public/assets/script/index.js" defer></script>
    <title>
        <?= $data['title'] ?>
    </title>
</head>

<body>
    <div id="modalMessageContainer"></div>