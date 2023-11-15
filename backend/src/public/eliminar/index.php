<?php
include('../cors.php');
require('../conexion.php');

// Verificar si se recibieron datos por GET para eliminar
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["id"])) {
        $id = $_POST["id"];

        try {
			$conn=dameConexion();
            // Realizar la eliminación en la tabla demo por el ID
            $sql = "DELETE FROM demo WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $rpta=['status'=>'OK',
					'message'=>'Registro eliminado correctamente'];
        } catch (PDOException $e) {
            $rpta=['status'=>'ERROR',
				'message'=>'Error al eliminar registro.',
				'error'=>$e->getMessage()];
        }
        echo json_encode($rpta);
    }
}
?>
