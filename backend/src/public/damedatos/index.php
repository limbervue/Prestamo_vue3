<?php
	include('../cors.php');
	require('../conexion.php');

	try {
		$conn=dameConexion();
		// Realizar la consulta para obtener todos los registros de la tabla demo
		$sql = "SELECT * FROM demo";
		$stmt = $conn->query($sql);
		// Obtener los resultados y convertirlos a formato JSON
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$rpta=['status'=>'OK',
				'message'=>'Se obtuvo los datos correctamente',
				'datos'=>$rows];
	} catch (PDOException $e) {
		// En caso de error en la conexión o consulta
		$rpta=['status'=>'ERROR',
				'message'=>'Error al obtener los datos',
				'error'=>$e->getMessage()];
	}
	echo json_encode($rpta);
?>
