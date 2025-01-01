<?php

session_start();

require_once("template.php");

printHead("ENTIch: Home");

openBody();

echo "<p>Esto es el main</p>";

$query = <<<EOD


SELECT DISTINCT games.*
FROM creators 
JOIN creators_games ON creators.id_creator = creators_games.id_creator 
JOIN games ON creators_games.id_game = games.id_game


EOD;

require_once("db_config.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$result = mysqli_query($conn, $query);


echo <<<EOD
<article>

EOD;
while ($r = mysqli_fetch_row($result)){

echo <<<EOD
<div>
<h3> {$r[1]} </h3>

<p><strong>Price:</strong> {$r[4]}</p>
<p><a href="games.php?id_game={$r[0]}">View More</a></p>
<hr></hr>
</div>
EOD;
}

echo <<<EOD
</article>

EOD;

closeBody("footei");

?>
