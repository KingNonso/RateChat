<?php /* Model View Controller */?>
<?php 
//use an autoloader
require 'config/core/ini.php';

    define('URL', 'http://localhost/www/doing/ratechats/');
    define('UPLOAD_PATH', __DIR__.'/public/uploads/');


    $app = new Bootstrap();

    $app->run();


?>

