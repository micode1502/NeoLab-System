<?php require_once __DIR__ . "/../../config/config.php"; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab NL</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>views/dashboard/css/stylesInicio.css">
    <!--Iconos-->
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
</head>

<body>
    <!--Navbar - Menu-->
    <header class="navbar">
        <div class="logo">
            <img src="<?php echo BASE_URL; ?>views/dashboard/img/index/Neo_Lab.png">
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="<?php echo BASE_URL; ?>login" class="btn"><button>Iniciar Sesión</button></a></li>
            </ul>
        </nav>
    </header>
    <!--Texto de Bienvenida-->
    <div class="bienvenido">
        <div class="titulo">
            <p id="negro">BIENVENIDOS A "NEO - LAB"</p>
            <p id="verde">LABORATORIO CLÍNICO</p>
        </div>
        <div class="subtitulo">
            En el laboratorio Neo Lab nos encargamos de realizar todo tipo de exámenes abarcando de un perfil de coagulación, checkeo pediátrico hasta marcadores pulmonares; ofreciendo mayor rapidez en la atención, asi como también en la entrega de los resultados.
        </div>
    </div>
    <!--Portada de Inicio-->
    <div class="seccion1">
        <div class="presentacion">
            <img src="<?php echo BASE_URL; ?>views/dashboard/img/index/presentacion.jpg">
        </div>
        <div class="cartas">
            <div class="circulo-wrap">
                <div class="circulo">
                    <div class="mask full-1">
                        <div class="fill-1"></div>
                    </div>
                    <div class="mask half">
                        <div class="fill-1"></div>
                    </div>
                    <div class="inside-circulo">95%</div>
                </div>
                <div class="texto">
                    <p id="plomo">Mayor tasa de éxito en</p>
                    <p id="verde">rapidez de atención</p>
                </div>
            </div>
            <div class="seguimiento">
                <p id="verde">¡Revisa el seguimiento!</p>
                <!-- solo puse imagen del gráfico de barras -->
                <img src="<?php echo BASE_URL; ?>views/dashboard/img/index/grafico-barras.jpg" id="grafico-barras">
            </div>
            <div class="encargados">
                <p id="verde">Encargados</p>
                <div class="perfil">
                    <img src="<?php echo BASE_URL; ?>views/dashboard/img/index/cita1.jpg">
                    <div class="texto">
                        <p>Mg. Sanchez</p>
                        <p>Cargo: Pediatra</p>
                    </div>
                </div>
                <div class="perfil">
                    <img src="<?php echo BASE_URL; ?>views/dashboard/img/index/cita2.jpg">
                    <div class="texto">
                        <p>Dra. Magdalena</p>
                        <p>Cargo: Ginecóloga</p>
                    </div>
                </div>
                <div class="perfil">
                    <img src="<?php echo BASE_URL; ?>views/dashboard/img/index/yoAnimado.jpeg">
                    <div class="texto">
                        <p>Dr. Rodas</p>
                        <p>Cargo: Doctor</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Separador-->
    <hr id="separador1">
    <!--Banner-->
    <div class="banner1">
        <img src="<?php echo BASE_URL; ?>views/dashboard/img/index/banner.png">
    </div>
    <!--Banner-->
    <div class="banner">
        <img src="<?php echo BASE_URL; ?>views/dashboard/img/index/banner.svg">
        <div class="iconos">
            <p>Medicamentos</p>
            <p>Microbiología</p>
            <p>Terapia Neural</p>
            <p>Asistencia Medica</p>
        </div>
        <div id="list-ico">
            <img id="ico1" src="<?php echo BASE_URL; ?>views/dashboard/img/index/tubo-de-ensayo.png">
            <img id="ico2" src="<?php echo BASE_URL; ?>views/dashboard/img/index/microscopio.png">
        </div>
        <div id="list-ico2">
            <img id="ico1" src="<?php echo BASE_URL; ?>views/dashboard/img/index/cerebro.png">
            <img id="ico2" src="<?php echo BASE_URL; ?>views/dashboard/img/index/mujeres.png">
        </div>
    </div>
    <!--Separador-->
    <hr>
    <!--Slider de medicos-->
    <div class="seccion2">
        <div class="caja1">
            <div class="texto">
                <h1>Contamos con Profesionales de Calidad</h1>
            </div>
            <div class="animacion">
                <img src="<?php echo BASE_URL; ?>views/dashboard/img/index/animacion1.jpg">
                <img src="<?php echo BASE_URL; ?>views/dashboard/img/index/animacion2.jpg">
                <img src="<?php echo BASE_URL; ?>views/dashboard/img/index/animacion3.jpg">
                <img src="<?php echo BASE_URL; ?>views/dashboard/img/index/animacion4.jfif">
            </div>
        </div>
        <div class="caja2">
            <h1> Personal Médico</h1>
            <p>Nos enorgullece afirmar que contamos con los mejores especialistas
                en nuestra organización. Nuestra dedicación constante a la excelencia y la calidad nos ha
                permitido reunir un equipo de profesionales altamente capacitado</p>
        </div>
    </div>
    <!--Separador-->
    <hr id="separador2">
    <!--Columnas-->
    <div class="slid">
        <h1>Porque la salud y el tiempo son nuestra prioridad.</h1>
    </div>
    <div class="subtitulo">
        En el laboratorio Neo Lab nos encargamos de realizar todo tipo de exámenes abarcando de un perfil de coagulación, checkeo pedriatico hasta marcadores pulmonares; ofreciendo maryor rapidez en la atención, asi como también en la entrega de los resultados.
    </div>
    <div class="contenido">
        <p>.Perfil coagulación</p>
        <p>.Perfil Anemia</p>
        <p>.Torch</p>
        <p>.Microbiología</p>
        <p>.Hematología</p>
        <p>.Perfil Hepático</p>
        <p>.Perfil Lipídico</p>
        <p>.Chequeo Pediátrico</p>
        <p>.Inmunología</p>
        <p>.Perfil Pre-Operatorio</p>
        <p>.Perfil Prenatal</p>
        <p>.Perfil Renal</p>
        <p>.Perfil Tiroideo</p>
        <p>.Marcadores Tumorales</p>
        <p>.Hormonal Femenino</p>
    </div>
    <!--Footer - Pie de pagina-->
    <footer class="pie-pag">
        <div class="grupo-1">
            <div class="box">
                <h2>SERVICIOS</h2>
                <ul>
                    <li>Inicio</li>
                    <li>Registrar</li>
                    <li>Iniciar Sesión</li>
                    <li>Nosotros</li>
                    <li>Términos y condiciones</li>
                </ul>
            </div>
            <div class="box">
                <h2>SOBRE NOSOTROS</h2>
                <p>
                    En el laboratorio Neo Lab nos encargamos de realizar todo tipo de exámenes abarcando de un perfil de coagulación,
                    checkeo pediátrico hasta marcadores pulmonares; ofreciendo mayor rapidez en la atención,
                    asi como también en la entrega de los resultados.
                </p>
                <h2>SÍGUENOS</h2>
                <div class="red-social">
                    <a href="#" class="fa fa-facebook"></a>
                    <a href="#" class="fa fa-instagram"></a>
                    <a href="#" class="fa fa-twitter"></a>
                    <a href="#" class="fa fa-youtube"></a>
                </div>
            </div>
            <div class="box">
                <img id="logoP" src="<?php echo BASE_URL; ?>views/dashboard/img/index/Logo.png">
            </div>
        </div>
        <div class="grupo-2">
            <small>&copy; 2023 <b>Grupo - 02</b> - Todos los Derechos Reservados.</small>
        </div>
    </footer>
</body>

</html>