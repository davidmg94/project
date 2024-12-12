$(document).ready(function () {
   // Manejar el formulario de agregar tarea
   $("#add-task-form").on("submit", function (event) {
      event.preventDefault(); // Evitar recargar la página

      const formData = $(this).serialize();

      $.post("add_task.php", formData, function (response) {
         console.log(response); // Verifica la respuesta

         const data = JSON.parse(response);
         if (data.success) {
            $("#successTaskModal").modal("show"); // Mostrar modal de éxito para tareas
            $("#add-task-form")[0].reset(); // Reiniciar el formulario
         } else {
            alert("Ocurrió un error al agregar la tarea: " + data.message);
         }
      });
   });

   // Manejar el formulario de agregar categoría
   $("#add-category-form").on("submit", function (event) {
      event.preventDefault(); // Evitar recargar la página

      const formData = $(this).serialize();

      $.post("add_category.php", formData, function (response) {
         console.log(response); // Verifica la respuesta

         const data = JSON.parse(response);
         if (data.success) {
            $("#successCategoryModal").modal("show"); // Mostrar modal de éxito para categorías
            $("#add-category-form")[0].reset(); // Reiniciar el formulario
         } else {
            alert("Ocurrió un error al agregar la categoría: " + data.message);
         }
      });
   });
   $(document).ready(function () {
      $("#modalSuccess").modal("show");
   });

   $(document).on('click', '.delete-task', function(e) {
    e.preventDefault(); // Evitar que se siga el enlace inmediatamente
    
    var tareaId = $(this).data('id'); // Obtener el ID de la tarea
    var deleteUrl = "../views/delete_task.php?id=" + tareaId; // Crear la URL para eliminar la tarea
    
    // Establecer la URL en el botón de confirmación
    $('#confirmDeleteBtn').attr('href', deleteUrl);
  });

  // Abrir el modal cuando el usuario confirme
  $('#confirmDeleteBtn').on('click', function() {
    var deleteUrl = $(this).attr('href'); // Obtener la URL de eliminación desde el botón de confirmación
    window.location.href = deleteUrl; // Redirigir al enlace de eliminación
  });
});
