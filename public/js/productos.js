$('#productsTable').DataTable();
getProducts('filter');

//Obtener los productos de acuerdo al filtro seleccionado
function getProducts(action) {
  $("#filtrar").prop('disabled', true);
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
  let clave = $("#clave").val();
  let nombre = $("#nombre").val();
  let marca = $("#marca").val();
  $.ajax({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: { "clave": clave, "nombre": nombre, "marca": marca },
      url: '/obtener_productos',
      type: 'post',
      success: function(response) {
          renderProducts(response, $('#productsTable'));
          $("#filtrar").prop('disabled', false);
          $("#productsRow").removeClass("d-none");
          if(action == 'filter') {
            Swal.close();
          } else if(action == 'added') {
            Swal.fire({
                title: 'Ok',
                text: 'Producto agregado con éxito',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
          } else if(action == 'edited') {
            Swal.fire({
                title: 'Ok',
                text: 'Producto actualizado con éxito',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
          } else if(action == 'deleted') {
            Swal.fire({
                title: 'Ok',
                text: 'Producto eliminado con éxito',
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
        $("#filtrar").prop('disabled', false);
    }
  });
}

//Renderizar los productos obtenidos
function renderProducts(datajson, table) {
  table.DataTable().destroy();
  let vartable = table.dataTable(tableConfigurationProducts);
  vartable.fnClearTable();
  $.each(datajson, function(index, value) {
      vartable.fnAddData([
          value.clave,
          value.nombre,
          value.marca,
          '<button id="editar~'+value.id+'~'+value.clave+'~'+value.nombre+'~'+value.marca_id+'" type="button" class="btn btn-warning mr-3 editar">Editar</button>'+
          '<button id="eliminar-'+value.id+'" type="button" class="btn btn-danger eliminar">Eliminar</button>'
      ]);
  });
}

//Añadir un nuevo producto
$("#addProductForm").on("submit", function(e) {
  e.preventDefault();
  $('#addProduct').modal('hide');
  Swal.fire({
      title: 'Agregando',
      html: 'Por favor espere',
      allowOutsideClick: false,
      didOpen: () => {
          Swal.showLoading()
      }
  });
  const form = $('#addProductForm')[0];
  let formData = new FormData(form);
  $.ajax({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: formData,
      url: '/agregar_producto',
      type: 'post',
      success: function(response) {
        if(response == 1) {
          getProducts('added');
        } else {
          Swal.fire({
              title: 'Error',
              text: 'Ya existe un producto con esa clave',
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
  $('#editProduct').modal('show');
  let producto = $(this)[0].id.split("~");
  $("#editId").val(producto[1]);
  $("#editClave").val(producto[2]);
  $("#editNombre").val(producto[3]);
  $("#editMarca").val(producto[4]);
});

//Editar un producto
$("#editProductForm").on("submit", function(e) {
  e.preventDefault();
  $('#editProduct').modal('hide');
  Swal.fire({
      title: 'Actualizando',
      html: 'Por favor espere',
      allowOutsideClick: false,
      didOpen: () => {
          Swal.showLoading()
      }
  });
  const form = $('#editProductForm')[0];
  let formData = new FormData(form);
  $.ajax({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: formData,
      url: '/editar_producto',
      type: 'post',
      success: function(response) {
        if(response == 1) {
          getProducts('edited');
        } else {
          Swal.fire({
              title: 'Error',
              text: 'Ya existe un producto con esa clave',
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

//Eliminar un producto
$(document).on("click", ".eliminar", function() {
  let producto = $(this)[0].id.split("-");
  let product_id = producto[1];
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
          data: { "product_id": product_id},
          url: '/eliminar_producto',
          type: 'post',
          success: function(response) {
            getProducts('deleted');
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
