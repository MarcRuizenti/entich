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

require_once("db_config.php");

$query = <<<EOD
 
SELECT DISTINCT comments.comment, comments.dateComment, comments.id_creator, comments.id_game
FROM creators
JOIN creators_games ON creators.id_creator = creators_games.id_creator
JOIN games ON creators_games.id_game = games.id_game
JOIN games_comments ON games_comments.id_game=games.id_game
JOIN comments ON comments.id_comment=games_comments.id_comment
WHERE creators.id_creator = {$creator["id_creator"]}; 
EOD;

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$result = mysqli_query($conn, $query);

while ($c = mysqli_fetch_row($result)){
$query = "SELECT * FROM creators WHERE id_creator=".$c[2];
$result2 = mysqli_query($conn, $query);
$creator = mysqli_fetch_array($result2);

$query = "SELECT * FROM games WHERE id_game=".$c[3];
$result3 = mysqli_query($conn, $query);
$game = mysqli_fetch_array($result3);
echo <<<EOD
<h3>{$game["title"]}</h3>
<h4>{$creator["username"]}</h4><p>{$c[1]}</p>
<p>{$c[0]}</p>
<hr></hr>
EOD;
}

closeDashboard();

closeBody("footer");

?>

