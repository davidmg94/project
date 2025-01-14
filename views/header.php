<!-- header.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Mi Proyecto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../public/home.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../views/tasks.php">Tareas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../views/categories.php">Categorías</a>
                    </li>
                    <!-- Enlace de Contacto -->
                    <li class="nav-item">
                        <a class="nav-link" href="../views/contact.php">Contacto</a>
                    </li>
                    <!-- Enlace Sobre Nosotros -->
                    <li class="nav-item">
                        <a class="nav-link" href="../views/about.php">Sobre Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Cerrar sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Header -->

</body>
</html>
