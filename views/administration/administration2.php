<!-- Fix for now until investigate -->
<?php require_once __DIR__ . "/../../config/config.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TW-Grupo2</title>
    <!--  Material CDN-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/964e3512fa.js" crossorigin="anonymous"></script>
    <script src="<?php echo BASE_URL ?>views/dashboard/js/jquery.min.js"></script>
    <script src="<?php echo BASE_URL ?>views/dashboard/js/sweetAlert2.js"></script>

    <!--  Stylesheet-->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>views/dashboard/css/styleAdministration2.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>views/dashboard/css/sweetAlert2.css">
</head>

<body>
    <div class="container">
        <!--            START OF ASIDE            -->
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="<?php echo BASE_URL ?>views/dashboard/img/logb.png" alt="Logo NeoLap">
                </div>
                <div class="close" id="close-btn">
                    <i class="fa-solid fa-x"></i>
                </div>
            </div>

            <div class="sidebar">
                <h2 class="menu text-center py-3 fs-6">
                    Menú Principal
                </h2>

                <!-- ==== Generated by Modules ==== -->
                <?php echo $_SESSION["session"]["user_modules"] ?>


                <a href="<?php echo BASE_URL ?>logintwo/logout">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <h3>Cerrar Sesión</h3>
                </a>
            </div>
        </aside>
        <!--            END OF ASIDE            -->
        <main>
            <h1>Panel de control</h1>
            <?php require_once $data["content"]; ?>
        </main>
        <!--        END MAIN        -->

        <div class="right">
            <!-- START OF TOP -->
            <div class="top">
                <button id="menu-btn">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <label class="switch my-2">
                    <input id="a-dark" type="checkbox" onclick="changeTheme()">
                    <span class="slider"></span>
                </label>
                <div class="theme-toggler d-none">
                    <i class="fa-regular fa-sun"></i>
                    <i class="fa-regular fa-moon"></i>
                </div>
                <div class="profile">
                    <div class="info">
                        <p><b><?php echo $_SESSION["session"]["username"] ?></b></p>
                        <small class="text-muted"><?php echo  $_SESSION["session"]["role"] ?></small>
                    </div>
                    <div class="profile-photo">
                        <a href="<?php BASE_URL ?>profile"><img src="public/users/<?php echo $_SESSION["session"]["avatar"] ?>"></a>
                    </div>
                </div>
            </div>
            <!-- END OF TOP -->
        </div>
    </div>
    <script src="<?php echo BASE_URL ?>views/dashboard/js/administration.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            display();
            changeDarkMode();
        });

        function display() {
            $(document).ready(function() {
                $(".item-menu").on("click", function() {
                    /* if($(this).find(".sub").hasClass) */
                    $(this).find(".item-sub").toggleClass("fw-bold");
                    $(this).find(".sub").toggleClass("d-flex");
                    $(this).find(".sub").toggleClass("sub-d");
                });
            })
        }
    </script>
</body>

</html>