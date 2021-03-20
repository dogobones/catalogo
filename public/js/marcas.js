$('#marcasTable').DataTable();
getMarcas('filter');

//Obtener todas las marcas
function getMarcas(action) {
  if(action == 'filter') {
    Swal.fire({
        title: 'Cargando',
        html: 'Por favor espere',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading()
        }
    });
  }
  $.ajax({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/obtener_marcas',
      type: 'post',
      success: function(response) {
          renderMarcas(response, $('#marcasTable'));
          $("#marcasRow").removeClass("d-none");
          if(action == 'filter') {
            Swal.close();
          } else if(action == 'added') {
            Swal.fire({
                title: 'Ok',
                text: 'Marca agregada con éxito',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
          } else if(action == 'edited') {
            Swal.fire({
                title: 'Ok',
                text: 'Marca actualizada con éxito',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
          } else if(action == 'deleted') {
            Swal.fire({
                title: 'Ok',
                text: 'Marca eliminada con éxito',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
          }
      },
      error: function(error) {
        Swal.fire({
            title: 'Error',
            text: 'Ha ocurrido un error inesperado',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
  });
}

//Renderizar las marcas obtenidas
function renderMarcas(datajson, table) {
  table.DataTable().destroy();
  let vartable = table.dataTable(tableConfigurationMarcas);
  vartable.fnClearTable();
  $.each(datajson, function(index, value) {
      vartable.fnAddData([
          value.nombre,
          '<input type="checkbox" '+((value.activa == 1) ? "checked" : "")+' disabled>',
          '<button id="editar~'+value.id+'~'+value.nombre+'~'+value.activa+'" type="button" class="btn btn-warning mr-3 editar">Editar</button>'+
          '<button id="eliminar-'+value.id+'" type="button" class="btn btn-danger eliminar">Eliminar</button>'
      ]);
  });
}

//Añadir una nueva marca
$("#addMarcaForm").on("submit", function(e) {
  e.preventDefault();
  $('#addMarca').modal('hide');
  Swal.fire({
      title: 'Agregando',
      html: 'Por favor espere',
      allowOutsideClick: false,
      didOpen: () => {
          Swal.showLoading()
      }
  });
  const form = $('#addMarcaForm')[0];
  let formData = new FormData(form);
  $.ajax({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: formData,
      url: '/agregar_marca',
      type: 'post',
      success: function(response) {
        if(response == 1) {
          getMarcas('added');
        } else {
          Swal.fire({
              title: 'Error',
              text: 'Ya existe una marca con ese nombre',
              icon: 'error',
              confirmButtonText: 'Aceptar'
          });
        }
      },
      error: function(error) {
        Swal.fire({
            title: 'Error',
            text: 'Ha ocurrido un error inesperado',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    },
    processData: false,
    contentType: false
  });
});

//Llenar los inputs del modal de edición
$(document).on("click", ".editar", function() {
  $('#editMarca').modal('show');
  let marca = $(this)[0].id.split("~");
  $("#editId").val(marca[1]);
  $("#editNombre").val(marca[2]);
  $("#editActiva").val(marca[3]);
  if(marca[3] == 1) {
    $('#editActiva').prop('checked', true);
  } else {
    $('#editActiva').prop('checked', false);
  }
});

//Editar una marca
$("#editMarcaForm").on("submit", function(e) {
  e.preventDefault();
  $('#editMarca').modal('hide');
  Swal.fire({
      title: 'Actualizando',
      html: 'Por favor espere',
      allowOutsideClick: false,
      didOpen: () => {
          Swal.showLoading()
      }
  });
  const form = $('#editMarcaForm')[0];
  let formData = new FormData(form);
  $.ajax({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: formData,
      url: '/editar_marca',
      type: 'post',
      success: function(response) {
        if(response == 1) {
          getMarcas('edited');
        } else {
          Swal.fire({
              title: 'Error',
              text: 'Ya existe una marca con ese nombre',
              icon: 'error',
              confirmButtonText: 'Aceptar'
          });
        }
      },
      error: function(error) {
        Swal.fire({
            title: 'Error',
            text: 'Ha ocurrido un error inesperado',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    },
    processData: false,
    contentType: false
  });
});

//Eliminar una marca
$(document).on("click", ".eliminar", function() {
  let marca = $(this)[0].id.split("-");
  let marca_id = marca[1];
  Swal.fire({
    title: '¿Seguro?',
    text: "Este cambio no podrá ser revertido",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: 'red',
    cancelButtonColor: 'gray',
    confirmButtonText: 'Eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
          title: 'Eliminando',
          html: 'Por favor espere',
          allowOutsideClick: false,
          didOpen: () => {
              Swal.showLoading()
          }
      });
      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: { "marca_id": marca_id},
          url: '/eliminar_marca',
          type: 'post',
          success: function(response) {
            getMarcas('deleted');
          },
          error: function(error) {
            Swal.fire({
                title: 'Error',
                text: 'Ha ocurrido un error inesperado',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
      });
    }
  });
});
