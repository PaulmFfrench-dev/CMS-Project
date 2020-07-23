<?php //Connecting to the DB that's locally hosted using MySQL
$DSN='mysql:host = localhost; dbname=cms4.2.1'; //Specifying mySQL as being the host locally with schema name
$ConnectingDB = new PDO($DSN,'root','');  //Logging in as root, no password
?>