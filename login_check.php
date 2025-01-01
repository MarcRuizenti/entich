<?php

if (!isset ($_POST["username"]) ||
	!isset ($_POST["password"])) {

	die("ERROR 1: Formulario no enviado");
}

$username = trim($_POST["username"]);
if (strlen($username) <= 4){
	die("ERROR 2: Nombre de usuario demasiado corto");
}

$tmp = addslashes($username);
if ($username != $tmp){
	die("ERROR 3: Nombre de usuario mal formado");
}

$pass = addslashes($_POST["password"]);
if ($pass != $_POST["password"]){
	die("ERROR 6: Password con caracteres no validos");
}

$password = trim($_POST["password"]);
if (strlen($password) <= 6){
	die("ERROR 7: Contraseña muy corta");
}

$pass = md5($pass);

$query = "SELECT * FROM creators WHERE username='$username' AND password='$pass'";

//echo $query;

require_once("db_config.php");;

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) != 1){
	die("ERROR 8: Usuario y/o password incorrectos");
}

$creator = mysqli_fetch_array($result);

session_start();

$_SESSION["id_creator"] = $creator["id_creator"];

header("Location: dashboard.php");

exit();

?>
