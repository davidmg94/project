<?php
// Configura la dirección de correo del administrador
$adminEmail = "davidmedina11394@gmail.com"; // Cambia esto a la dirección de tu administrador

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    // Validar datos
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Correo electrónico no válido.";
        exit;
    }

    // Configurar el mensaje de correo
    $subject = "Nuevo mensaje de contacto de $nombre";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $body = "Nombre: $nombre\n";
    $body .= "Correo Electrónico: $email\n\n";
    $body .= "Mensaje:\n$mensaje\n";

    // Enviar correo
    if (mail($adminEmail, $subject, $body, $headers)) {
        echo "Mensaje enviado exitosamente. ¡Gracias por contactarnos!";
    } else {
        echo "Hubo un error al enviar tu mensaje. Por favor, intenta nuevamente.";
    }
} else {
    echo "Método no permitido.";
}
?>