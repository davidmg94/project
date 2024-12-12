<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autenticado']);
    exit;
}

require_once '../models/Tarea.php';
require_once '../config/db.php';

$tareaModel = new Tarea($pdo);

if (isset($_POST['id']) && isset($_POST['status'])) {
    $idTarea = $_POST['id'];
    $status = $_POST['status'];

    $tarea = $tareaModel->getTareaPorId($idTarea);

    if ($tarea) {
        if ($tareaModel->actualizarEstadoTarea($idTarea, $status)) {
            echo json_encode(['status' => 'success', 'new_status' => $status]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar el estado']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Tarea no encontrada o no pertenece al usuario']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
}
?>
