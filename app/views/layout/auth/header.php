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
    <script src="<?= $_ENV['BASEURL'] ?>public/assets/script/forgetpwd.js" defer></script>
    <script src="<?= $_ENV['BASEURL'] ?>public/assets/script/resetpwd.js" defer></script>
    <script src="<?= $_ENV['BASEURL'] ?>public/assets/script/index.js" defer></script>
    <title><?= $data['title'] ?></title>
</head>

<body>
    <!-- 
    The <div id="modalMessageContainer"></div> element is critical for the proper display of error messages coming from the PHP backend via AJAX.
    Errors, particularly modal error messages, are dynamically inserted into this container.
    For example, in cases where the switch statement in the PHP backend fails, the error response might look like this:
    
    echo json_encode([
    'success' => false,
    'modal_msg' => '<div id="--modal-error-msg" class="--modal-error-msg">
                        <span><i class="bi bi-exclamation-triangle-fill"></i> Error</span>
                        <p>An internal error has occurred. Please try again later.</p>
                        <button id="closeModalMsgBtn" class="--action-button" type="button" title="close modal">Close</button>
                    </div>',
    ]);

    If the modalMessageContainer div is removed, these error messages will not be rendered on the page, causing critical feedback to the user to fail.
    Ensure this container remains in the DOM for proper error handling and user communication.
    -->
    <div id="modalMessageContainer"></div>