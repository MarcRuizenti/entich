<?php

session_start();

if (!isset ($_POST["profile_name"]) ||
	!isset ($_POST["profile_username"]) ||
	!isset ($_POST["profile_email"]) ||
	!isset ($_POST["profile_description"]))
{
	die("ERROR 1: Formulario no enviado");
}

$name = trim($_POST["profile_name"]);
$username = trim($_POST["profile_username"]);
$email = trim($_POST["profile_email"]);
$description = trim($_POST["profile_description"]);

if (strlen($name) <= 2){
	die("ERROR 2: Nombre demasiado corto");
}

if (strlen($username) <= 4){
	die("ERROR 3: Nombre de usuario demasiado corto");
}

if (strlen($email) <= 11){
	die("ERROR 4: Mail muy corto");
}

$name_temp = addslashes($name);
if ($name_temp != $name){
	die("ERROR 5: No se admite / en el campo de name");
}

$email_temp = addslashes($email); 
if ($email_temp != $email){
	die("ERROR 6: No se admite / en el campo de email");
}


$username_temp = addslashes($username);
if ($username_temp != $username){
	die("ERROR 8: No se admite / en el campo de username");
}



if (!isset($_SESSION["id_creator"])){
	header("Location: login.php");
	exit();
}

require_once("db_config.php");

$query = <<<EOD
	UPDATE creators 
	SET 
	name='{$name}',
	username='{$username}',
	email='{$email}',
	description='{$description}'
	WHERE id_creator={$_SESSION["id_creator"]}
EOD;

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$result = mysqli_query($conn, $query);

if (!$result){
	header("Location: login.php");
	exit();
}

header("Location: dashboard.php");
exit();

?>
