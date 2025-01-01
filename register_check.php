<?php

if (!isset ($_POST["name"]) ||
	!isset ($_POST["username"]) ||
	!isset ($_POST["email"]) ||
	!isset ($_POST["password"]) ||
	!isset ($_POST["repassword"])) {

	die("ERROR 1: Formulario no enviado");
}

$name = trim($_POST["name"]);
$username = trim($_POST["username"]);
$email = trim($_POST["email"]);
$password = trim($_POST["password"]);
$repassword = trim($_POST["repassword"]);

if (strlen($name) <= 2){
	die("ERROR 2: Nombre demasiado corto");
}

if (strlen($username) <= 4){
	die("ERROR 3: Nombre de usuario demasiado corto");
}

if (strlen($email) <= 11){
	die("ERROR 4: Mail muy corto");
}

if (strlen($password) <= 6){
	die("ERROR 5: Contraseña muy corta");
}

if (strlen($repassword) <= 6){
	die("ERROR 6: confirmación de contraseña muy corta");
}

$name_temp = addslashes($name);
if ($name_temp != $name){
	die("ERROR 7: No se admite / en el campo de name");
}

$email_temp = addslashes($email); 
if ($email_temp != $email){
	die("ERROR 8: No se admite / en el campo de email");
}

$pass = md5($password);

$query = <<<EOD
INSERT INTO creators (name, username, password, email)
VALUES('${name}', '${username}','${pass}', '${email}')

EOD;

require_once("db_config.php");

//echo $query;

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$result = mysqli_query($conn, $query);

if (!$result){
	die("ERROR 9: No se ha insertado en la base de datos");
}

$id_creator = mysqli_insert_id($conn);

session_start();

$_SESSION["id_creator"] = $id_creator;

header("Location: dashboard.php");

exit();
?>
