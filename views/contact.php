

<!-- contact.php -->
<?php include('header.php'); ?>

<div class="container mt-4">
    <h2>Contacto</h2>
    <p>Si tienes alguna pregunta o necesitas más información, no dudes en ponerte en contacto con nosotros.</p>

    <!-- Formulario de Contacto -->
    <form action="send_contact.php" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="mensaje" class="form-label">Mensaje</label>
            <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>

<?php include('footer.php'); ?>