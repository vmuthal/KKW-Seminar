<?php
$dbh = new PDO("mysql:host=localhost;dbname=todo_db", "root", "", array(PDO::ATTR_PERSISTENT => true));
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>