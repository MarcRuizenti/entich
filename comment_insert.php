
<?php


if (!isset ($_POST["comment"]) ||
	!isset ($_POST["id_game"])){

	die("ERROR 1: Formulario no enviado");
}

$id_game = $_POST["id_game"];
$comment = trim($_POST["comment"]);
if ($comment == ""){
 die("ERROR 0: Comentario vacio");
}
$temp = addslashes($comment);
if ($temp != $comment){
	die("ERROR 1: No se admiten / en los comentarios");
}

session_start();

if (!isset($_SESSION["id_creator"])){
	header("Location: login.php");
}


$date = date("d/m/Y");

$query = <<<EOD

INSERT INTO comments (comment, dateComment, id_game, id_creator)
VALUES ('{$comment}', '{$date}', '{$id_game}', '{$_SESSION["id_creator"]}')

EOD;

require_once("db_config.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$result = mysqli_query($conn, $query);

if (!$result){
	die("ERROR 2: No se ha insertado en la base de datos");
}

$id_comment = mysqli_insert_id($conn);

$query2 = <<<EOD

INSERT INTO games_comments (id_game, id_comment)
VALUES ('{$id_game}', '{$id_comment}')

EOD;

$result = mysqli_query($conn, $query2);

if (!$result){
	die("ERROR 2: No se ha insertado en la base de datos");
}



header("Location: games.php?id_game=".$id_game);

?>
