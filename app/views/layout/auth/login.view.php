<main id="authContainer">
    <form id="loginForm">

        <div class="auth-header">
            <div class="logo-cont"><img src="" alt=""></div>
            <h2>Welcome back</h2>
            <span>Please entre your Email & Password.</span>
        </div>

        <div id="authWhithCont">
            <button type="button">
                <img width="30" height="30" src="https://img.icons8.com/color/48/google-logo.png" alt="google-logo" />
                Login with Google</button>
            <button type="button">
                <img width="30" height="30" src="https://img.icons8.com/color/48/microsoft.png" alt="microsoft" />
                Login with Microsoft</button>
        </div>

        <div id="ORLine">
            <hr> or
            <hr>
        </div>

        <div id="formInputCont">
            <div class="form-input-cont">
                <label for="email">Email</label>
                <input class="FORM-INPUT-email" required type="mail" placeholder="Email" minlength="10"
                    autocomplete="off">
                <div id="INPUT-msg--mail" class="input-msg-cont"></div>
            </div>

            <div class="form-input-cont">
                <label for="password">Password</label>
                <input class="FORM-INPUT-pwd auth-input-pwd" required type="password" placeholder="Password">
                <button type="button" class="show-pwd-btn">
                    <i title="show password" class="bi bi-eye"></i>
                </button>
                <div id="INPUT-msg--pwd" class="input-msg-cont"></div>
                <div class="rememberacc-forgetpwd-cont">
                    <div class="remember-acc-cont">
                        <input type="checkbox">Remember account
                    </div>
                    <a href="forgetpwd" target="_blank" rel="noopener noreferrer">Forget password?</a>
                </div>
            </div>
        </div>

        <button type="button" id="sendLoginData" class="auth-button">Login</button>

        <span class="auth-link">Don't have an account?
            <a href="signup">Signup</a>
        </span>
    </form>

</main>