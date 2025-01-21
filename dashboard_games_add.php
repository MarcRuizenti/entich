<?php

session_start();

if (!isset($_SESSION["id_creator"])){
	header("Location: login.php");
	exit();
}

if (!isset($_POST["name_game"]) ||
	!isset($_POST["link_game"]) ||
	!isset($_POST["price_game"]) ||
	!isset($_POST["trailer_game"]) ||
	!isset($_FILES["header"]))
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

$fileTmpPath = $_FILES['header']['tmp_name'];
$fileName = $_FILES['header']['name'];

$uploadFolder = 'imgs/';
if (!is_dir($uploadFolder)) {
    mkdir($uploadFolder, 0777, true);
}

$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

if (!in_array($fileExtension, $allowedExtensions)) {
	die("ERROR: Tipo de archivo no permitido.");
}

$uniqueFileName = uniqid('img_', true) . '.' . $fileExtension;
$destPath = $uploadFolder . $uniqueFileName;

if (move_uploaded_file($fileTmpPath, $destPath)) {
	
} else {
	die("ERROR: No se pudo mover el archivo subido.");
}

$query = <<<EOD

INSERT INTO games (title, link, header, price, trailer) 
VALUES ('{$name}', '{$link}', '{$uniqueFileName}', '{$price}', '{$trailer}')

EOD;

require_once("db_config.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$result = mysqli_query($conn, $query);

if (!$result){
	die("ERROR 9: No se ha insertado en la base de datos");
}

$id_game = mysqli_insert_id($conn);
$id_creator = $_SESSION["id_creator"];
$query2 = <<<EOD
INSERT INTO creators_games (id_creator, id_game)
VALUES ('$id_creator', '$id_game')
EOD;

$result = mysqli_query($conn, $query2);

if (!$result){
	die("ERROR 10: No se ha insertado en la base de datos");
}

header("Location: dashboard_games.php");


?>
