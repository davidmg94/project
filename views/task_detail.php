<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once '../models/Tarea.php';
require_once '../models/Categoria.php';
require_once '../config/db.php';

$tareaModel = new Tarea($pdo);
$categoriaModel = new Categoria($pdo);
$idUsuario = $_SESSION['usuario']['id'];

if (isset($_GET['id'])) {
    $idTarea = $_GET['id'];
    $tarea = $tareaModel->getTareaPorId($idTarea, $idUsuario);

    if (!$tarea) {
        header('Location: home.php');
        exit;
    }
} else {
    header('Location: home.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="../public/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php include('../views/header.php'); ?>

        <h2>Detalles de la Tarea</h2>

        <div class="card mb-4">
            <div class="card-header">
                <h5><?php echo htmlspecialchars($tarea['nombre']); ?></h5>
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> <?php echo $tarea['id']; ?></p>
                <p><strong>Descripción:</strong> <?php echo htmlspecialchars($tarea['descripcion']); ?></p>
                <p><strong>Fecha de Vencimiento:</strong> <?php echo date('d-m-Y', strtotime($tarea['fecha_vencimiento'])); ?></p>
                <p><strong>Prioridad:</strong>
                    <?php
                    $prioridad = $tarea['prioridad'];
                    switch ($prioridad) {
                        case 3:
                            echo "<span style='color: white; background-color: red;'>Alta</span>";
                            break;
                        case 2:
                            echo "<span style='color: white; background-color: orange;'>Media</span>";
                            break;
                        case 1:
                            echo "<span style='color: white; background-color: green;'>Baja</span>";
                            break;
                        default:
                            echo "<span>Desconocida</span>";
                            break;
                    }
                    ?>
                </p>
                <p><strong>Estado:</strong>
                    <?php
                    if ($tarea['status'] == 1) {
                        echo "<span id='estado-tarea' style='color: orange;'>Pendiente</span>";
                    } else {
                        echo "<span id='estado-tarea' style='color: green;'>Completada</span>";
                    }
                    ?>
                </p>
            </div>
        </div>

        <div class="d-flex justify-content-start gap-2">
            <a href="../views/edit_task.php?id=<?php echo $tarea['id']; ?>" class="btn btn-warning">Editar</a>
            <a href="#" id="toggleStatusBtn" 
            class="btn <?php echo ($tarea['status'] == 1) ? "btn-success" : "btn-secondary"; ?>" 
            data-id="<?php echo $tarea['id']; ?>" data-status="<?php echo $tarea['status']; ?>">
                <?php echo ($tarea['status'] == 1) ? "Completada" : "Pendiente"; ?>
            </a>
            <a href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" class="btn btn-danger delete-task" data-id="<?php echo $tarea['id']; ?>">Eliminar</a>
        </div>
    </div>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que quieres eliminar esta tarea? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <?php include('../views/footer.php'); ?>

    <script src="../public/js/modals.js"></script>
    <script src="../public/js/status.js"></script>
</body>
</html>
