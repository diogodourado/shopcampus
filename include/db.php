<?php
define('DB_SERVER', 'INSIRA');
define('DB_USERNAME', 'INSIRA');
define('DB_PASSWORD', 'INSIRA');
define('DB_DATABASE', 'INSIRA');

$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$database = mysql_select_db(DB_DATABASE) or die(mysql_error());

?>