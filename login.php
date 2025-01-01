<?php

require_once("template.php");

printHead("ENTIch: Home");

openBody();

echo <<<EOD

<form method="POST" action="login_check.php">
<h2>Login</h2>

<p>
	<label for="username">Nombre de Usuario:</label>
	<input type="text" id="username" name="username" />
</p>

<p>
	<label for="password">Contraseña:</label>
	<input type="password" id="password" name="password" />
</p>

<p class="button">
	<button type="submit">Envíe su mensaje</button>
</p>

</form>

<form method="POST" action="register_check.php">
<h2>Registro</h2>
<p>
	<label for="name">Nombre:</label>
	<input type="text" id="name" name="name" />
</p>

<p>
	<label for="username">Nombre de Usuario:</label>
	<input type="text" id="username" name="username" />
</p>

<p>
	<label for="email">Correo electronico:</labe>
	<input type="email" id="email" name="email" />
</p>

<p>
	<label for="password">Contraseña:</label>
	<input type="password" id="password" name="password" />
</p>

<p>
	<label for="repassword">Confirm password:</label>
	<input type="password" id="repassword" name="repassword" />
</p>

<p class="button">
	<button type="submit">Envíe su mensaje</button>
</p>
</form>

EOD;

closeBody("footer");

?>
