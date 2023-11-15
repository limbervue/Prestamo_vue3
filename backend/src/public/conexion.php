<?php
	function dameConexion(){
		// Datos de conexión a la base de datos MySQL
		$servername = "mariadbb";
		$username = "root";
		$password = "demo";
		$dbname = "demo";
		// Crear una conexión PDO con la base de datos MySQL
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// Establecer el modo de error PDO a excepción
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	}
?>
