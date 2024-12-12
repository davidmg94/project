$(document).ready(function () {
    $(document).on("click", "#toggleStatusBtn", function (e) {
       e.preventDefault();

       var $button = $(this);
       var tareaId = $button.data("id");
       var currentStatus = $button.data("status");

       if (!tareaId || typeof currentStatus === 'undefined') {
          alert('Datos incompletos: Asegúrate de que se está pasando el ID de la tarea y el estado actual.');
          return;
       }

       var newStatus = currentStatus == 1 ? 0 : 1;
       var newStatusText = newStatus == 0 ? "Pendiente" : "Completada";
       var newButtonClass = newStatus == 0 ? "btn-secondary" : "btn-success";

       $.ajax({
          url: "change_status.php",
          method: "POST",
          data: {
             id: tareaId,
             status: newStatus,
          },
          success: function (response) {
             try {
                var data = JSON.parse(response);

                if (data.status === "success") {
                   // Actualizar el botón visualmente
                   $button.text(newStatusText)
                          .removeClass("btn-success btn-secondary")
                          .addClass(newButtonClass)
                          .data("status", newStatus);

                   // Actualizar el estado de la tarea visualmente
                   if (newStatus == 0) {
                      $("#estado-tarea").css("color", "green").text("Completada");
                   } else {
                      $("#estado-tarea").css("color", "orange").text("Pendiente");
                   }
                   
                } else {
                   alert("Error: " + data.message);
                }
             } catch (e) {
                console.error("Error al parsear JSON", e);
                alert("Hubo un error al procesar la respuesta del servidor.");
             }
          },
          error: function (xhr, status, error) {
             console.error("Error al actualizar el estado: " + error);
          },
       });
    });
});
