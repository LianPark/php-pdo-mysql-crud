<?php
include 'Db.class.php';
include 'dbconfig.php';

$table_name = 'contacts';

$db = new DB($DATABASE_HOST, $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASS);

$persons = $db->query("SELECT * FROM contacts");
print_r($persons);
echo "<br><br>";

$persons = $db->query("SELECT * FROM contacts WHERE id > 5");
print_r($persons);
echo "<br><br>";

$db->bind("id","6");
$person = $db->query("SELECT * FROM contacts WHERE id = :id");
print_r($person);
echo "<br><br>";

$ages = $db->row("SELECT * FROM contacts WHERE id = :id", array("id"=>"3"));
print_r($ages);
echo "<br><br>";

$array = array(0 => 100, "color" => "red");
print_r(array_keys($array));

$array = array("blue", "red", "green", "blue", "blue");
print_r(array_keys($array));




//$db->bindMore(array("firstname"=>"John","id"=>"1"));
$params = array('1'=>'1','Gildong','aaa@gmail.com','2135459665','CEO','2024-10-01 11:12:13');
$rows = $db->query("INSERT INTO ".$table_name."(id,name,email,phone,title,created) VALUES (?, ?, ?, ?, ?, ?)", $params);


echo '<br>end<br>';