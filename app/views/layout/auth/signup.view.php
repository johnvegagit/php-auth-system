<?php if (isset($_SESSION['customerId']) && isset($_SESSION['customerToken'])): ?>
    <script type="text/javascript">
        window.location.href = "<?= $_ENV['BASEURL'] ?>";
    </script>
    <?php die(); ?>
<?php else: ?>
    <main id="authContainer">

        <form id="signupForm" class="auth-form-container">

            <div class="auth-header">
                <div class="logo-cont"><img src="" alt=""></div>
                <h2>Create an account</h2>
                <span>Lorem ipsum dolor sit, consectetur elit.</span>
            </div>

            <div id="authWhithCont">
                <button type="button">
                    <img width="30" height="30" src="https://img.icons8.com/color/48/google-logo.png" alt="google-logo" />
                    Signup with Google</button>
                <button type="button">
                    <img width="30" height="30" src="https://img.icons8.com/color/48/microsoft.png" alt="microsoft" />
                    Signup with Microsoft</button>
            </div>

            <div id="ORLine">
                <hr> or
                <hr>
            </div>

            <!-- name surname -->
            <div class="form-input-names-cont">
                <div class="form-input-cont">
                    <label for="name">name</label>
                    <input class="FORM-INPUT-name" required type="text" placeholder="Name" minlength="3" autocomplete="off">
                    <div id="inputMsg--name" class="input-msg-cont"></div>
                </div>
                <div class="form-input-cont">
                    <label for="surname">surname</label>
                    <input class="FORM-INPUT-surname" required type="text" placeholder="Surname" minlength="3"
                        autocomplete="off">
                    <div id="inputMsg--surname" class="input-msg-cont"></div>
                </div>
            </div>

            <!-- username -->
            <div class="form-input-cont">
                <label for="username">username</label>
                <input class="FORM-INPUT-username" required type="text" placeholder="Username" minlength="10"
                    autocomplete="off">
                <div id="inputMsg--username" class="input-msg-cont"></div>
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
            <button type="button" id="singupData" class="auth-button">Create account</button>

            <span id="userConsent">By selecting Create account, you agree to our
                <a href="#" target="_blank" rel="noopener noreferrer">Terms of Service</a>
                and acknowledge that you have read our
                <a href="#" target="_blank" rel="noopener noreferrer">Privacy Policy</a>.</span>

            <span class="auth-link">You have an account?
                <a href="login">Login</a>
            </span>

        </form>

    </main>
<?php endif;