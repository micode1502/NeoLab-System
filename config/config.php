<?php

$local = require_once __DIR__ . '/../locals.php';

define("DEFAULT_CONTROLLER", "cpanel");
define("DEFAULT_ACTION", "index");
define("BASE_URL", $local['BASE_URL']);
define("TEMPLATE", "views/dashboard/index.php");
define("ERROR_404", "views/errors/404.php");
