<?php
define('APP_DIR', realpath(__DIR__));
define('CONFIG_DIR', APP_DIR . '/config');
define('VENDOR_DIR', APP_DIR . '/vendor');

$loader = require_once VENDOR_DIR . '/autoload.php';
$loader->add('Helpers\\', APP_DIR);
require_once CONFIG_DIR . '/config.php';

?>
<html>
<head>
    <title>Test task</title>
</head>
<body>
<div style="width: 800px; margin: 0 auto;">
    <h1>Welcome!</h1>
    <?php include 'templates/search_form.php'; ?>
</div>
</body>
</html>
