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

// Verificar que el ID de la tarea esté presente en la URL
if (isset($_GET['id'])) {
    $tareaId = $_GET['id'];

    // Obtener la tarea desde la base de datos
    $tarea = $tareaModel->getTareaPorId($tareaId);

    // Verificar si la tarea existe
    if (!$tarea) {
        echo "Tarea no encontrada.";
        exit;
    }

    // Obtener las categorías del usuario autenticado
    $categorias = $categoriaModel->getCategoriasPorUsuario($_SESSION['usuario']['id']);
}

// Procesar el formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria_id = $_POST['categoria_id'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];  // Fecha ingresada por el usuario
    $prioridad = $_POST['prioridad'];

    // Actualizar la tarea en la base de datos
    $tareaModel->actualizarTarea($tareaId, $nombre, $descripcion, $categoria_id, $fecha_vencimiento, $prioridad);

    // Obtener la tarea actualizada después de la actualización
    $tarea = $tareaModel->getTareaPorId($tareaId);
    $mostrarModal = true;
} else {
    $mostrarModal = false;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <?php include('../views/header.php'); ?>

        <h2>Editar Tarea</h2>
        <form action="edit_task.php?id=<?php echo $tareaId; ?>" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Título</label>
                <input type="text" name="nombre" id="nombre" class="form-control"
                    value="<?php echo htmlspecialchars($tarea['nombre']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control"
                    required><?php echo htmlspecialchars($tarea['descripcion']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="categoria_id" class="form-label">Categoría</label>
                <select name="categoria_id" id="categoria_id" class="form-control" required>
                    <option value="">Seleccionar categoría</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria['id']; ?>" <?php echo ($categoria['id'] == $tarea['id_categoria']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($categoria['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
                <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control"
                    value="<?php echo $tarea['fecha_vencimiento']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="prioridad" class="form-label">Prioridad</label>
                <select name="prioridad" id="prioridad" class="form-control" required>
                    <option value="1" <?php echo $tarea['prioridad'] == 1 ? 'selected' : ''; ?>>Baja</option>
                    <option value="2" <?php echo $tarea['prioridad'] == 2 ? 'selected' : ''; ?>>Media</option>
                    <option value="3" <?php echo $tarea['prioridad'] == 3 ? 'selected' : ''; ?>>Alta</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
            <a href="task_detail.php?id=<?php echo $tareaId; ?>" class="btn btn-secondary">Ver Detalles</a>

        </form>
        <!-- Modal -->
        <?php if ($mostrarModal): ?>
        <div class="modal fade" id="modalSuccess" tabindex="-1" aria-labelledby="modalSuccessLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSuccessLabel">Tarea Actualizada</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        La tarea se ha actualizado con éxito.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php include('../views/footer.php'); ?>
<script src="../public/js/modals.js"></script>
</body>
</html>
