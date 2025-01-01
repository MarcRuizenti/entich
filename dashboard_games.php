<?php
session_start();

if (!isset($_SESSION["id_creator"])){
	header("Location: login.php");
	exit();
}

require_once("template.php");

$query = "SELECT * FROM creators WHERE id_creator=".$_SESSION["id_creator"];

require_once("db_config.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$result = mysqli_query($conn, $query);

if (!$result){
	header("Location: login.php");
	exit();
}

if (mysqli_num_rows($result) != 1){
	header("Location: login.php");
	exit();
}

$creator = mysqli_fetch_array($result);

printHead("Dashboard de ".$creator["name"]);

openBody("Dashboard de ".$creator["name"]);

require_once("dashboard_template.php");

openDashboard();


if (isset($_GET["add_game"])){

echo "<h2>Nuevo juego</h2>";
echo <<<EOD
<form method="POST" action="dashboard_games_add.php" enctype="multipart/form-data" >

<input type="hidden" name="id_creator" value="{$creator["id_creator"]}" />

<p><label for="name_game">Nombre del juego:</label><input type="text" name="name_game" id="name_game" /></p>

<p><label for="link_game">Link:</label><input type="text" name="link_game" id="link_game" /></p>

<p><label for="price_game">Precio:</label><input type="text" name="price_game" id="price_game" /></p>

<p><label for="trailer_game">Trailer:</label><input type="text" name="trailer_game" id="trailer_game" /></p>

<p><label for="header">Header: </label> <input type="file" name="header" id="header" accept="image/*"></p>

<p><input type="submit" value="Add" /></p>

</form>
EOD;

}
else if (isset($_GET["id_game"])){

$id_game = $_GET["id_game"];

$query = "SELECT * FROM games WHERE id_game=".$id_game;

require_once("db_config.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$result = mysqli_query($conn, $query);

if (!$result){
	header("Location: login.php");
	exit();
}

if (mysqli_num_rows($result) != 1){
	header("Location: login.php");
	exit();
}

$game = mysqli_fetch_array($result);

echo <<<EOD
<form method="POST" action="dashboard_games_update.php">
<input type="hidden" name="id_game" value="{$id_game}" />

<p><label for="name_game">Nombre del juego:</label><input type="text" value="{$game["title"]}" name="name_game" id="name_game" /></p>

<p><label for="link_game">Link:</label><input type="text" value="{$game["link"]}" name="link_game" id="link_game" /></p>

<p><label for="price_game">Price:</label><input type="text" value="{$game["price"]}" name="price_game" id="price_game" /></p>

<p><label for="trailer_game">Trailer:</label><input type="text" value="{$game["trailer"]}" name="trailer_game" id="trailer_game" /></p>

<p><label for="header">Header: </label> <input type="file" name="header" id="header" accept="image/*"></p>

<p><input type="submit" value="Actualizar" /></p>

</form>
EOD;
echo "<h2>Modificar juego</h2>";

}
else{

/*
Listado de juegos con el enlace en el titulo tipo "dashboard_games.php?id_game=ID_JUEGO"
*/
echo "<h1>Tus juegos</h1>";

$query = <<<EOD


SELECT DISTINCT games.*
FROM creators 
JOIN creators_games ON creators.id_creator = creators_games.id_creator 
JOIN games ON creators_games.id_game = games.id_game
WHERE creators.id_creator = {$creator["id_creator"]};

EOD;

require_once("db_config.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$result = mysqli_query($conn, $query);

$none = true;

while ($r = mysqli_fetch_row($result)){
$none = false;
echo <<<EOD
<div>
EOD;

if ($r[3] != null){
echo <<<EOD
<h3 style="background-image: url('imgs/{$r[3]}'); color: white; background-size: contain; background-repeat: no-repeat; background-position: center; min-height: 200px; text-align: center; line-height: 200px;"> {$r[1]}</h3>
EOD;
}else{
echo <<<EOD
<h3>{$r[1]}</h3>
EOD;
}
echo <<<EOD
<p><strong>Link:</strong> {$r[2]}</p>
<p><strong>Price:</strong> {$r[4]}</p>
<p><strong>Trailer:</strong> {$r[5]}</p>
<hr></hr>
</div>
EOD;
}
if ($none){
echo <<<EOD
<p><a href="dashboard_games.php?add_game=true">Add Game</a></p>
EOD;
}
}



closeDashboard();

closeBody("footer");

?>
