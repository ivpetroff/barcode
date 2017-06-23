<?php
define ("DB_HOST", "localhost"); // Your database host name
define ("DB_USER", "root"); // Your database user
define ("DB_PASS",""); // Your database password
define ("DB_NAME","mercari"); // Your database name

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
?>