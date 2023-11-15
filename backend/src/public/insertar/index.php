<?php
include('../cors.php');
require('../conexion.php');

// Verificar si se recibieron datos por POST para insertar
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["name"])) {
        $name = $_POST["name"];
		$conn=dameConexion();
        try {
            // Realizar la inserción en la tabla demo
            $sql = "INSERT INTO demo (name) VALUES (:name)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->execute();

			$rpta=['status'=>'OK',
					'message'=>'Registro insertado correctamente',
					'error'=>$e->getMessage()];
        } catch (PDOException $e) {
            $rpta=['status'=>'ERROR',
					'message'=>'Error al insertar registro',
					'error'=>$e->getMessage()];
        }
		echo json_encode($rpta);
    }
}
?>
