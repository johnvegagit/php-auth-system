<?php if (isset($_SESSION["customerId"])): ?>
    <main id="homePageStyle">
        <h1>Welcome: <?= ucfirst($_SESSION["customerName"]) . ' ' . ucfirst($_SESSION["customerSurname"]) ?></h1>
        <ul>
            <li><a class="share-linkto" href="logout">logout</a></li>
        </ul>
    </main>
<?php else: ?>
    <main id="homePageStyle">
        <h1>Welcome</h1>
        <ul>
            <li><a class="share-linkto" href="login">login</a></li>
            <li><a class="share-linkto" href="signup">signup</a></li>
            <li><a class="share-linkto" href="forgetpwd">forgetpwd</a></li>
            <li><a class="share-linkto" href="resetpwd">resetpwd</a></li>
        </ul>
    </main>
<?php endif;