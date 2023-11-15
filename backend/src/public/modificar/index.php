<?php
include('../cors.php');
require('../conexion.php');

// Verificar si se recibieron datos por POST para modificar
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["id"]) && isset($_POST["name"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        try {
            $conn=dameConexion();
            // Realizar la modificación en la tabla demo por el ID
            $sql = "UPDATE demo SET name = :name WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $rpta=['status'=>'OK',
					'message'=>'Registro modificado correctamente'];
        } catch (PDOException $e) {
            $rpta=['status'=>'ERROR',
				'message'=>'Error al modificar registro.',
				'error'=>$e->getMessage()];
			
        }
        echo json_encode($rpta);
    }
}
?>
