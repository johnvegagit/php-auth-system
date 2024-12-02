<main id="authContainer">
    <form id="loginForm">

        <div class="auth-header">
            <div class="logo-cont"><img src="" alt=""></div>
            <h2>Reset your password</h2>
            <span>Please entre your new password and make shure that it have minimun 8 character.</span>
        </div>

        <div id="formInputCont">
            <div class="form-input-cont">
                <label for="password">Password</label>
                <input class="FORM-INPUT-pwd auth-input-pwd" required type="password" placeholder="Password">
                <button type="button" class="show-pwd-btn">
                    <i title="show password" class="bi bi-eye"></i>
                </button>
                <div id="INPUT-msg--pwd" class="input-msg-cont"></div>
            </div>

            <div class="form-input-cont">
                <label for="confirmpassword">Confirm password</label>
                <input class="FORM-INPUT-confrpwd auth-input-pwd" required type="password"
                    placeholder="Confirm password">
                <button type="button" class="show-pwd-btn">
                    <i title="show password" class="bi bi-eye"></i>
                </button>
                <div id="INPUT-msg--pwd" class="input-msg-cont"></div>
            </div>
        </div>

        <button type="button" id="sendLoginData" class="auth-button">Confirm Changes</button>
    </form>

</main>