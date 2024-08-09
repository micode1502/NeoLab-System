
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>views/dashboard/css/styleForms.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>views/dashboard/css/styleBtn.css">
    <title>Log In</title>
    <link rel="icon" type="image/x-icon" href="">
</head>

<body>
    <div class="container">
        <label class="switch my-2">
            <input id="a-dark" type="checkbox" onclick="changeTheme()">
            <span class="slider"></span>
        </label>
        <!-- Evita el salto bruzco de cambio de modo al inicio -->
        <script src="<?php echo BASE_URL ?>views/dashboard/js/administration.js"></script>
        <script>changeDarkMode();</script>

        <div class="cont">
            <div class="cont-left">
                <img src="<?php echo BASE_URL ?>views/dashboard/img/login/1.svg" alt="Imagen representativa de un diagnóstico médico">
            </div>
            <div class="cont-right">
                <div class="cont-login">
                    <h1 class="title">¡Hola! Bienvenido de vuelta</h1>
                    <form class="form" action="<?php echo BASE_URL; ?>login/validate" method="post" autocomplete="off">
                        <label class="nameInputBox" for="">Usuario</label>
                        <input class="inputBox inputBoxUser" type="text" placeholder="Usuario" name="txtUsername" id="txtUsername" value="<?php echo isset($_SESSION['session']['username']) ? $_SESSION['session']['username'] : ''; ?>">
                        <?php if (isset($data["errors"]["username"])) : ?>
                            <div style="color:var(--color-danger);font-family:Arial;">
                                <?php echo $data["errors"]["username"] ?>
                            </div>
                        <?php endif; ?>
                        <label class="nameInputBox" for="">Contraseña</label>
                        <div class="boxPass">
                            <input class="inputBox inputTextPass" type="password" placeholder="Contraseña" id="txtPassword" name="txtPassword">
                            <div class="backBtn" id="iconPassBtn">
                                <svg class="iconPassBtn" fill="#000000" width="800px" height="800px" viewBox="0 0 32 32" id="icon" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;}</style></defs><title>view</title><path d="M30.94,15.66A16.69,16.69,0,0,0,16,5,16.69,16.69,0,0,0,1.06,15.66a1,1,0,0,0,0,.68A16.69,16.69,0,0,0,16,27,16.69,16.69,0,0,0,30.94,16.34,1,1,0,0,0,30.94,15.66ZM16,25c-5.3,0-10.9-3.93-12.93-9C5.1,10.93,10.7,7,16,7s10.9,3.93,12.93,9C26.9,21.07,21.3,25,16,25Z" transform="translate(0 0)"/><path d="M16,10a6,6,0,1,0,6,6A6,6,0,0,0,16,10Zm0,10a4,4,0,1,1,4-4A4,4,0,0,1,16,20Z" transform="translate(0 0)"/><rect id="_Transparent_Rectangle_" data-name="&lt;Transparent Rectangle&gt;" class="cls-1" width="32" height="32"/></svg>
                            </div>
                        </div>
                        <?php if (isset($data["errors"]["password"])) : ?>
                            <div style="color:var(--color-danger); font-family:Arial;">
                                <?php echo $data["errors"]["password"] ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($data["msj_login"])) : ?>
                            <div style="color:var(--color-danger); font-family:Arial;">
                                <?php echo $data["msj_login"]?>
                            </div>
                        <?php endif; ?>
                        <div class="rememberme">
                            <label class="labelCheckBox">
                                <input class="sr-only" type="checkbox" name="cboxRememberMe" id="cboxRememberMe" />
                                <div class="slider-2"></div>
                                <span class="label">Recuérdame</span>
                            </label>
                        </div>
                        <!-- Token CSRF a traves del operador ternario verifico si el token es existente -->
                        <input type="hidden" name="csrf_token" value="<?php echo isset($data['csrf_token']) ? $data['csrf_token'] : ''; ?>">
                        <input class="submit disabled inputBox" type="submit" id="btnSubmit" value="Iniciar Sesión"/>
                    </form>
                    <!-- <div class="line-or-line">o</div>
                    <div class="alt-login">
                        <a class="cont-alt-login" href="#">
                            <div class="cont-alt"><img src="<?php echo BASE_URL ?>views/dashboard/img/login/g.svg" alt=""></div>
                        </a>
                        <a class="cont-alt-login" href="#">
                            <div class="cont-alt"><img src="<?php echo BASE_URL ?>views/dashboard/img/login/f.svg" alt=""></div>
                        </a>
                        <a class="cont-alt-login" href="#">
                            <div class="cont-alt a"><img src="<?php echo BASE_URL ?>views/dashboard/img/login/a.svg" alt=""></div>
                        </a>

                    </div>
                    <div class="text">
                        <p>¿No tienes cuenta? <a class="hover-underline-animation" href="<?php echo BASE_URL ?>">Regístrate</a></p>
                    </div> -->
                </div>
            </div>

            <img class="element svg-4" src="<?php echo BASE_URL ?>views/dashboard/img/login/4.svg" alt="">
            <img class="element svg-5" src="<?php echo BASE_URL ?>views/dashboard/img/login/5.svg" alt="">
            <img class="element svg-6" src="<?php echo BASE_URL ?>views/dashboard/img/login/6.svg" alt="">
            <img class="element svg-7" src="<?php echo BASE_URL ?>views/dashboard/img/login/7.svg" alt="">
            <img class="element svg-8" src="<?php echo BASE_URL ?>views/dashboard/img/login/8.svg" alt="">
            <img class="element svg-9" src="<?php echo BASE_URL ?>views/dashboard/img/login/9.svg" alt="">
            <img class="element svg-10" src="<?php echo BASE_URL ?>views/dashboard/img/login/10.svg" alt="">
            <img class="element svg-11" src="<?php echo BASE_URL ?>views/dashboard/img/login/11.svg" alt="">
            <img class="element svg-12" src="<?php echo BASE_URL ?>views/dashboard/img/login/g1.svg" alt="">
        </div>
        <img class="element-o svg-2" src="<?php echo BASE_URL ?>views/dashboard/img/login/2.svg" alt="">
        <img class="element-o svg-3" src="<?php echo BASE_URL ?>views/dashboard/img/login/3.svg" alt="">
    </div>
    <aside>
        <div id="menu-btn"></div>
        <div id="close-btn"></div>
    </aside>
    <script src="<?php echo BASE_URL ?>views/dashboard/js/administration.js"></script>
    <script>
        /* document.addEventListener("DOMContentLoaded", function() {
            changeDarkMode();
        }); */
    </script>
</body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        //Campo de username y boton
        const txtUsername = document.getElementById('txtUsername');
        const txtPassword = document.getElementById('txtPassword');
        const btnSubmit = document.getElementById('btnSubmit');

        //Deshabilitar el boton si el campo txtUsername no tiene caracteres
        if (txtUsername.value.length === 0) {
            btnSubmit.disabled = true;
        }
        //addEventListener responde para el evento input
        txtUsername.addEventListener('input', function() {toggleDisabledSubmit();});
        txtPassword.addEventListener('input', function(){toggleDisabledSubmit();} );

        function toggleDisabledSubmit(){
            if (txtUsername.value.length > 0 && txtPassword.value.length > 0) {
                //El boton se habilita
                btnSubmit.classList.remove('disabled');
                btnSubmit.disabled = false;
            } else {
                //Si es lo contrario, se deshabilita
                btnSubmit.classList.add('disabled');
                btnSubmit.disabled = true;
            }
        }
    });

</script>
<script>
    const inputs = document.getElementsByClassName("inputTextPass");
    const pass = inputs[0];

    const icon = document.querySelector(".backBtn");

    icon.addEventListener("click", () => {
        icon.innerHTML = "";

        if (pass.type === "password") {
            pass.type = "text";
            icon.innerHTML = `
            <svg class="iconPassBtn" fill="#000000" width="800px" height="800px" viewBox="0 0 32 32" id="icon" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;}</style></defs><title>view--off</title><path d="M5.24,22.51l1.43-1.42A14.06,14.06,0,0,1,3.07,16C5.1,10.93,10.7,7,16,7a12.38,12.38,0,0,1,4,.72l1.55-1.56A14.72,14.72,0,0,0,16,5,16.69,16.69,0,0,0,1.06,15.66a1,1,0,0,0,0,.68A16,16,0,0,0,5.24,22.51Z"/><path d="M12,15.73a4,4,0,0,1,3.7-3.7l1.81-1.82a6,6,0,0,0-7.33,7.33Z"/><path d="M30.94,15.66A16.4,16.4,0,0,0,25.2,8.22L30,3.41,28.59,2,2,28.59,3.41,30l5.1-5.1A15.29,15.29,0,0,0,16,27,16.69,16.69,0,0,0,30.94,16.34,1,1,0,0,0,30.94,15.66ZM20,16a4,4,0,0,1-6,3.44L19.44,14A4,4,0,0,1,20,16Zm-4,9a13.05,13.05,0,0,1-6-1.58l2.54-2.54a6,6,0,0,0,8.35-8.35l2.87-2.87A14.54,14.54,0,0,1,28.93,16C26.9,21.07,21.3,25,16,25Z"/><rect id="_Transparent_Rectangle_" data-name="&lt;Transparent Rectangle&gt;" class="cls-1" width="32" height="32"/></svg>            `;
        } else {
            pass.type = "password";
            icon.innerHTML = `
            <svg class="iconPassBtn" fill="#000000" width="800px" height="800px" viewBox="0 0 32 32" id="icon" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;}</style></defs><title>view</title><path d="M30.94,15.66A16.69,16.69,0,0,0,16,5,16.69,16.69,0,0,0,1.06,15.66a1,1,0,0,0,0,.68A16.69,16.69,0,0,0,16,27,16.69,16.69,0,0,0,30.94,16.34,1,1,0,0,0,30.94,15.66ZM16,25c-5.3,0-10.9-3.93-12.93-9C5.1,10.93,10.7,7,16,7s10.9,3.93,12.93,9C26.9,21.07,21.3,25,16,25Z" transform="translate(0 0)"/><path d="M16,10a6,6,0,1,0,6,6A6,6,0,0,0,16,10Zm0,10a4,4,0,1,1,4-4A4,4,0,0,1,16,20Z" transform="translate(0 0)"/><rect id="_Transparent_Rectangle_" data-name="&lt;Transparent Rectangle&gt;" class="cls-1" width="32" height="32"/></svg>            `;
        }
    });
</script>








