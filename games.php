		<?php
		session_start();
$haySesion= false;
if (!isset($_SESSION["id_creator"])){
	$haySesion=true;
}

require_once("template.php");
$game;

if (isset($_GET["id_game"])){

$id_game = $_GET["id_game"];

$query = "SELECT * FROM games WHERE id_game=".$id_game;

require_once("db_config.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$result = mysqli_query($conn, $query);

$game = mysqli_fetch_array($result);

}else{
	die("ERROR: No hay ID de juego");
}
printHead($game["title"]);
openBody($game["title"]);

echo <<<EOD
<article>
<figure>
<img src="imgs/{$game["header"]}" alt="Trulli" style="width:100%">
</figure>

<p><strong>Price: </strong>{$game["price"]}€</p>
<p><strong>Link:</strong><a href="{$game["link"]}">Steam</a></p>
<p><strong>Trailer:</strong><a href="{$game["trailer"]}">{$game["title"]}</a></p>
EOD;
if (!$haySesion){
echo "<h2>Comments</h2>";

echo <<<EOD
<form method="POST" action="comment_insert.php">
<input type="hidden" name="id_game" value="{$game["id_game"]}" />

<p><label for="comment">Comment:</label><textarea name="comment" id="comment"></textarea></p>

<p><input type="submit" value="Add" /></p>

</form>
EOD;
}



$query = <<<EOD
   

SELECT DISTINCT comments.comment, comments.dateComment, comments.id_creator
FROM games 
JOIN games_comments ON games_comments.id_game=games.id_game
JOIN comments ON comments.id_comment=games_comments.id_comment
WHERE games.id_game = {$game["id_game"]};

EOD;

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$result = mysqli_query($conn, $query);

while ($c = mysqli_fetch_row($result)){
$query = "SELECT * FROM creators WHERE id_creator=".$c[2];
$result2 = mysqli_query($conn, $query);
$creator = mysqli_fetch_array($result2);

echo <<<EOD
<h3>{$creator["username"]}</h3><p>{$c[1]}</p>
<p>{$c[0]}</p>
<hr></hr>
EOD;
}


echo <<<EOD

</article>

EOD;
closeBody("footer");

?>
