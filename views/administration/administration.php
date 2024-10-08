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
    <link rel="stylesheet" href="<?php echo BASE_URL ?>views/dashboard/css/styleAdministration.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/views/dashboard/css/sweetAlert2.css">
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
                <!-- ==== End of Generated by Modules ==== -->
                <a href="<?php echo BASE_URL ?>login/logout">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <h3>Cerrar Sesión</h3>
                </a>
            </div>
        </aside>
        <!--            END OF ASIDE            -->
        <main>
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
            <!--        START OF RECENT UPDATES       -->
            <div class="recent-updates">
                <h2>Actualizaciones recientes</h2>
                <div class="updates" id="updatesLast">

                </div>
            </div>
            <!--        END OF RECENT UPDATES       -->
            <!-- <div class="sales-analytics">
                <h2>Análisis de registros</h2>
                <div class="item online">
                    <span class="icon"><i class="fa-solid fa-cart-shopping"></i></span>
                    <div class="right">
                        <div class="info">
                            <h3>PEDIDOS EN LÍNEA</h3>
                            <small class="text-muted">Últimas 24h</small>
                        </div>
                        <div class="info-n">
                            <h5 class="success">+39%</h5>
                            <h3>3849</h3>
                        </div>

                    </div>
                </div>
                <div class="item offline">
                    <span class="icon"><i class="fa-solid fa-bag-shopping"></i></span>
                    <div class="right">
                        <div class="info">
                            <h3>PEDIDOS PRESENCIALES</h3>
                            <small class="text-muted">Últimas 24h</small>
                        </div>
                        <div class="info-n">
                            <h5 class="danger">-17%</h5>
                            <h3>1100</h3>
                        </div>
                    </div>
                </div>
                <div class="item customers">
                    <span class="icon"><i class="fa-regular fa-user"></i></span>
                    <div class="right">
                        <div class="info">
                            <h3>Nuevos Usuarios</h3>
                            <small class="text-muted">Últimas 24h</small>
                        </div>
                        <div class="info-n">
                            <h5 class="success">+25%</h5>
                            <h3>849</h3>
                        </div>

                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            display();
            changeDarkMode();
            lastLogins();
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

        function convertDateToTimeAgo(dateString) {
            const currentTime = Date.now();
            const loginTime = new Date(dateString).getTime();
            const secondsElapsed = Math.floor((currentTime - loginTime) / 1000);

            if (secondsElapsed < 60) {
                return `Hace ${secondsElapsed} segundos`;
            } else if (secondsElapsed < 3600) {
                const minutes = Math.floor(secondsElapsed / 60);
                return `Hace ${minutes} minutos`;
            } else if (secondsElapsed < 86400) {
                const hours = Math.floor(secondsElapsed / 3600);
                return `Hace ${hours} horas`;
            } else {
                const days = Math.floor(secondsElapsed / 86400);
                return `Hace ${days} días`;
            }
        }

        function lastLogins() {
            $.ajax({
                url: "<?php echo BASE_URL ?>administration/showLastLogins",
                type: "POST",
                success: function(response) {

                    var data = JSON.parse(response);
                    var template = "";
                    $.each(data.lastLogins, function(i, val) {
                        var action = "InIció sesión";
                        if (val.last_login === val.created_at) {
                            action = "Fue registrado";
                        }

                        template += "<div class='update'>" +
                            "<div class='profile-photo'>" +
                            "<img src='public/users/" + val.avatar + "'>" +
                            "</div>" +
                            "<div class='message'>" +
                            "<p><b>" + val.name + " " + val.lastName + " </b>" + action + "</p>" +
                            "<small class='text-muted'>" + convertDateToTimeAgo(val.last_login) + "</small>" +
                            "</div>" +
                            "</div>"
                    });

                    $("#updatesLast").html(template);
                }
            })

        }
    </script>
    <script src="<?php echo BASE_URL ?>views/dashboard/js/administration.js"></script>
    
</body>

</html>