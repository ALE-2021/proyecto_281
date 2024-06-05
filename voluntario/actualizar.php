<?php
require_once '../conexion.php';
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id_asignacion']) && isset($data['estado'])) {
    $id_asignacion = $data['id_asignacion'];
    $estado = $data['estado'];

    if ($estado === 'asignado') {
        $sql_actualizar = "UPDATE asignacion_voluntarios SET estado = ?, fecha_asignacion = NOW() WHERE id_asignacion = ?";
        $stmt_actualizar = $conn->prepare($sql_actualizar);
        $stmt_actualizar->bind_param("si", $estado, $id_asignacion);

        if ($stmt_actualizar->execute()) {
            echo json_encode(['message' => 'Asignación aceptada.']);
        } else {
            echo json_encode(['error' => 'Error al aceptar la asignación.']);
        }
    } elseif ($estado === 'disponible') {
        $sql_obtener_voluntario = "SELECT id_voluntario FROM asignacion_voluntarios WHERE id_asignacion = ?";
        $stmt_obtener_voluntario = $conn->prepare($sql_obtener_voluntario);
        $stmt_obtener_voluntario->bind_param("i", $id_asignacion);
        $stmt_obtener_voluntario->execute();
        $result_voluntario = $stmt_obtener_voluntario->get_result();
        if ($result_voluntario->num_rows > 0) {
            $row_voluntario = $result_voluntario->fetch_assoc();
            $id_voluntario = $row_voluntario['id_voluntario'];

            $sql_eliminar = "DELETE FROM asignacion_voluntarios WHERE id_asignacion = ?";
            $stmt_eliminar = $conn->prepare($sql_eliminar);
            $stmt_eliminar->bind_param("i", $id_asignacion);

            if ($stmt_eliminar->execute()) {
                $sql_actualizar_voluntario = "UPDATE voluntario SET estado_asignacion = 'disponible' WHERE id_voluntario = ?";
                $stmt_actualizar_voluntario = $conn->prepare($sql_actualizar_voluntario);
                $stmt_actualizar_voluntario->bind_param("i", $id_voluntario);

                if ($stmt_actualizar_voluntario->execute()) {
                    echo json_encode(['message' => 'Asignación rechazada y voluntario disponible.']);
                } else {
                    echo json_encode(['error' => 'Error al actualizar el estado del voluntario.']);
                }
            } else {
                echo json_encode(['error' => 'Error al eliminar la asignación.']);
            }
        } else {
            echo json_encode(['error' => 'No se encontró el voluntario para esta asignación.']);
        }
    } else {
        echo json_encode(['error' => 'Estado no válido.']);
    }
} else {
    echo json_encode(['error' => 'Datos incompletos.']);
}

$conn->close();
?>
