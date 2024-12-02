<main id="authContainer">
    <form id="loginForm">

        <div class="auth-header">
            <div class="logo-cont"><img src="" alt=""></div>
            <h2>Create new account</h2>
            <span>Start your 30-day free. Cancel anytime.</span>
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

        <div class="progress-container">
            <div class="progress-step active">1</div>
            <div class="progress-step">2</div>
            <div class="progress-step">3</div>
            <div class="progress-step">4</div>
        </div>

        <!-- form-step 1 -->
        <div class="form-step active">
            <div class="form-input-cont">
                <label for="email">Email</label>
                <input class="FORM-INPUT-email" required type="mail" placeholder="Email" minlength="10"
                    autocomplete="off">
                <div id="INPUT-msg--mail" class="input-msg-cont"></div>
            </div>
            <button type="button" class="auth-button next-btn">Continue --></button>
        </div>

        <!-- form-step 2 -->
        <div class="form-step">
            <div class="form-input-cont">
                <label for="name">Name</label>
                <input class="FORM-INPUT-name" required type="text" placeholder="Name" minlength="3" autocomplete="off">
                <div id="INPUT-msg--name" class="input-msg-cont"></div>
            </div>
            <div class="form-input-cont">
                <label for="surname">SurName</label>
                <input class="FORM-INPUT-surname" required type="text" placeholder="SurName" minlength="3"
                    autocomplete="off">
                <div id="INPUT-msg--surname" class="input-msg-cont"></div>
            </div>
            <button type="button" class="auth-button next-btn">Continue --></button>
        </div>

        <!-- form-step 3 -->
        <div class="form-step">
            <div class="form-input-cont">
                <label for="username">UserName</label>
                <input class="FORM-INPUT-username" required type="text" placeholder="Username" minlength="10"
                    autocomplete="off">
                <div id="INPUT-msg--username" class="input-msg-cont"></div>
            </div>
            <button type="button" class="auth-button next-btn">Continue --></button>
        </div>

        <!-- form-step 4 -->
        <div class="form-step">
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

            <button type="button" id="sendSignupData" class="auth-button next-btn">Create Account</button>
        </div>

        <span class="auth-link">Already have an account?
            <a href="login">Login</a>
        </span>
    </form>

</main>