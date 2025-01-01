<?php

session_start();

if (!isset ($_POST["name_game"]) ||
	!isset ($_POST["link_game"]) ||
	!isset ($_POST["price_game"]) ||
	!isset ($_POST["trailer_game"]))
{
	die("ERROR 1: Formulario no enviado");
}

$name = trim($_POST["name_game"]);
$link = trim($_POST["link_game"]);
$price = trim($_POST["price_game"]);
$trailer = trim($_POST["trailer_game"]);

if (strlen($name) <= 2){
	die("ERROR 2: Nombre demasiado corto");
}

if (strlen($link) <= 4){
	die("ERROR 3: Nombre de juego demasiado corto");
}

if (strlen($price) <= 1){
	die("ERROR 4: price incorrecto");
}

if (strlen($trailer) <= 5){
	die("ERROR 5: Trailer corto");
}

$name_temp = addslashes($name);
if ($name_temp != $name){
	die("ERROR 5: No se admite / en el campo de name");
}

$link_temp = addslashes($link); 
if ($link_temp != $link){
	die("ERROR 6: No se admite / en el campo de email");
}


$trailer_temp = addslashes($trailer);
if ($trailer_temp != $trailer){
	die("ERROR 8: No se admite / en el campo de username");
}

if (!isset($_POST["id_game"])){
	header("Location: login.php");
	exit();
}

require_once("db_config.php");

$query = <<<EOD
	UPDATE games 
	SET 
	title='{$title}',
	link='{$link}',
	price='{$price}',
	trailer='{$trailer}'
	WHERE id_game={$_POST["id_game"]}
EOD;

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$result = mysqli_query($conn, $query);

if (!$result){
	header("Location: dashboard_games.php ");
	exit();
}

header("Location: dashboard_games.php");
exit();

?>
