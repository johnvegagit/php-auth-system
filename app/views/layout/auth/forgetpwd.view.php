<?php if (isset($_SESSION['customerId'])): ?>
    <script type="text/javascript">
        window.location.href = "<?= $_ENV['BASEURL'] ?>";
    </script>
    <?php die(); ?>
<?php else: ?>
    <main id="authContainer">

        <form id="forgetpwdForm" class="auth-form-container">

            <div class="auth-header">
                <div class="logo-cont"><img src="" alt=""></div>
                <h2>Forget your password?</h2>
                <span>Please entre your Email to recieve a link to reset your password.</span>
            </div>

            <!-- email -->
            <div class="form-input-cont">
                <label for="email">email</label>
                <input class="FORM-INPUT-email" required type="mail" placeholder="Email" minlength="10" autocomplete="off">
                <div id="inputMsg--email" class="input-msg-cont"></div>
            </div>

            <button type="button" id="forgetpwdData" class="auth-button">Send Link</button>

            <div id="ORLine">
                <hr> or
                <hr>
            </div>

            <div class="auth-link-cont">
                <span class="auth-link">Remember your account just?
                    <a class="share-linkto" href="login">Login</a>
                </span>
                <span class="auth-link">Create a new account!
                    <a class="share-linkto" href="signup">Signup</a>
                </span>
            </div>
        </form>

    </main>
<?php endif;