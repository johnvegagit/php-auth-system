<main id="authContainer">
    <form id="loginForm">

        <div class="auth-header">
            <div class="logo-cont"><img src="" alt=""></div>
            <h2>Forget your password?</h2>
            <span>Please entre your Email to recieve a link to reset your password.</span>
        </div>

        <div id="formInputCont">
            <div class="form-input-cont">
                <label for="email">Email</label>
                <input class="FORM-INPUT-email" required type="mail" placeholder="Email" minlength="10"
                    autocomplete="off">
                <div id="INPUT-msg--mail" class="input-msg-cont"></div>
            </div>
        </div>

        <button type="button" id="sendLinkData" class="auth-button">Send Link</button>

        <div class="auth-link-cont">
            <span class="auth-link">Remember your credencial just!
                <a href="login">Login</a>
            </span> <br>
            <span class="auth-link">Or create a new account!
                <a href="signup">Signup</a>
            </span>
        </div>
    </form>

</main>