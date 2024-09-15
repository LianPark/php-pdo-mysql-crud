<?php
include 'functions.php';
include 'lib.php';
include 'Db.class.php';

$pdo = pdo_connect_mysql();
$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

$db = new DB($DATABASE_HOST, $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);

define('GG_HOME', 'http://127.0.0.1/mysql-phpcrud');