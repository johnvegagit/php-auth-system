<?php if (isset($_SESSION['customerId']) && isset($_SESSION['customerToken'])): ?>
    <script type="text/javascript">
        window.location.href = "<?= $_ENV['BASEURL'] ?>";
    </script>
    <?php die(); ?>
<?php else: ?>
    <main id="authContainer">

        <form id="loginForm" class="auth-form-container">

            <div class="auth-header">
                <div class="logo-cont"><img src="" alt=""></div>
                <h2>Welcome</h2>
                <span>Please entre your Email & Password.</span>
            </div>

            <!-- email -->
            <div class="form-input-cont">
                <label for="email">email</label>
                <input class="FORM-INPUT-email" required type="mail" placeholder="Email" minlength="10" autocomplete="off">
                <div id="inputMsg--email" class="input-msg-cont"></div>
            </div>

            <!-- password -->
            <div class="form-input-cont">
                <label for="password">password</label>
                <button type="button" class="show-pwd-btn">
                    <i title="show password" class="bi bi-eye"></i>
                </button>
                <input class="FORM-INPUT-pwd auth-input-pwd" required type="password" placeholder="Password">
                <div id="inputMsg--pwd" class="input-msg-cont"></div>
            </div>

            <!-- forget password -->
            <a class="share-linkto" href="<?= $_ENV['BASEURL'] ?>forgetpwd" target="_blank" rel="noopener noreferrer">Forget
                password?</a>

            <button type="button" id="loginData" class="auth-button">Login</button>

            <div id="ORLine">
                <hr> or
                <hr>
            </div>

            <span class="auth-link">Don't have an account?
                <a class="share-linkto" href="<?= $_ENV['BASEURL'] ?>signup">Signup</a>
            </span>
        </form>

    </main>
<?php endif;