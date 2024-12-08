<?php if (isset($_SESSION['customerId']) && isset($_SESSION['customerToken'])): ?>
    <script type="text/javascript">
        window.location.href = "<?= $_ENV['BASEURL'] ?>";
    </script>
    <?php die(); ?>
<?php else: ?>
    <main id="authContainer">

        <form id="resetpwdForm" class="auth-form-container">

            <div class="auth-header">
                <div class="logo-cont"><img src="" alt=""></div>
                <h2>Reset your password</h2>
                <span>Please entre your new password and make shure that it have minimun 8 character.</span>
            </div>

            <input hidden type="text" class="FORM-INPUT-auth" value="<?= $_GET['auth'] ?>">

            <!-- password -->
            <div class="form-input-cont">
                <label for="password">password</label>
                <button type="button" class="show-pwd-btn">
                    <i title="show password" class="bi bi-eye"></i>
                </button>
                <input class="FORM-INPUT-pwd auth-input-pwd" required type="password" placeholder="Password">
                <div id="inputMsg--pwd" class="input-msg-cont"></div>
            </div>

            <!-- confirm password -->
            <div class="form-input-cont">
                <label for="confirmpassword">confirm password</label>
                <button type="button" class="show-pwd-btn">
                    <i title="show password" class="bi bi-eye"></i>
                </button>
                <input class="FORM-INPUT-confrpwd auth-input-pwd" required type="password" placeholder="Confirm password">
                <div id="inputMsg--cnfrpwd" class="input-msg-cont"></div>
            </div>
            <br><br>
            <button type="button" id="resetpwdData" class="auth-button">Confirm Changes</button>
        </form>

    </main>
<?php endif;