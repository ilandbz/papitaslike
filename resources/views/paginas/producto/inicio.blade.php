@extends('layout')
@section('maincontent')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Lista General de Productos</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
          @if (session('success'))
              <div class="alert alert-success">
                  {{ session('success') }}
              </div>
          @endif
          @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
          @endif
          <div class="input-group">
              <div class="input-group-append pull-right">
                  <button class="btn btn-lg btn-warning" id="btn-nuevo-producto">
                      Nuevo Registro <i class="fas fa-user-plus"></i>
                  </button>
              </div>
          </div>
        <br>
        @include('paginas.producto.vistatabla')
      </div>
      <!-- /.card-body -->
    </div>
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

@include('paginas.producto.modalproducto')
@endsection

@section('script')
<!-- SweetAlert2 -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script>
  let csrf_token = $('meta[name="csrf-token"]').attr('content');
    document.getElementById('productoform').addEventListener('submit', function (event) {
        event.preventDefault(); // Evita que el formulario se envíe normalmente
        var form = document.getElementById('productoform');
        $('.alert-danger').remove();
        $.ajax({
            type:'POST',
            // datatype: 'json',
            url: this.action,
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(data) {
              form.reset();
              $("#modalproducto").modal('hide');
              cargar_datatable();
              toastr.success(data.mensaje)
            },
            error: function(xhr) {
              let res = xhr.responseJSON
              if($.isEmptyObject(res) === false) {
                  $.each(res.errors,function (key, value){
                      $("input[name='"+key+"']").closest('.form-group')
                      .append('<div class="alert alert-danger" role="alert">'+ value+ '</div>')
                  });
              }

          }
        });
    });

    carga_inicial();
    function carga_inicial(){ 
      $("#tablaproductos").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#tablaproductos_wrapper .col-md-6:eq(0)');
      cargar_datatable();
    }
    function cargar_datatable(){
      var table = $('#tablaproductos').DataTable();
      table.clear();
      $.ajax({
          dataType:'json',
          url: 'productos/todos',
          success: function(data) {
            let numero_orden = 1;
              (data.productos).forEach(function(repo) {
                  table.row.add([
                  numero_orden,
                  repo.nombre,
                  repo.tipo,
                  repo.precio,
                  repo.unidad_medida,
                  '<div class="btn-group" role="group" aria-label="Basic mixed styles example">'+
                    '<a id="'+repo.id+'" class="btn btn-danger btn_eliminar_producto mr-1"><i class="fa fa-trash" aria-hidden="true"></i></a>'+
                    '<a id="'+repo.id+'" class="btn btn-warning btn_modificar_producto mr-1"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                  '</div>'
                  
                ]).draw();
                  numero_orden++;
              });
          }
      })
    }
    $("#tablaproductos").on('click', '.btn_eliminar_producto', function() {            
        var usuario_id = $(this).attr('id');       
        Swal.fire({
          icon: 'question',
          title: 'Usuario',
          text: 'Esta Seguro de Eliminar el Registro?',
          toast: true,
          position: 'center',
          showConfirmButton: true,
          confirmButtonText: 'Si',
          showCancelButton: true,
          cancelButtonText: 'No',
          cancelButtonColor: '#bd2130'
        }).then(respuesta=>{
          if(respuesta.isConfirmed){
            $.ajax({
                type:'POST',
                dataType:'json',
                url: 'producto/eliminar',
                data: {
                  id: usuario_id,
                  _token: csrf_token
                },
                success: function(data) {
                    if(data.ok==1)
                    {
                      toastr.success(data.mensaje)
                      cargar_datatable();
                    }
                }
            })
            
          }
        });
    });

    function limpiarformusuario(){
      $('input[name=id]').val('');  
      $('input[name=nombre]').val('')
      $('select[name=tipo]').val('INSUMO')
      $('input[name=precio]').val('')
    }

$('#btn-nuevo-producto').click(function (){
  limpiarformusuario();
  $("#titulo-modal").text('Nuevo Producto');
  $("#modalproducto").modal('show');
});

$("#tablaproductos").on('click', '.btn_modificar_producto', function() { 
  $('.alert-danger').remove();
  $("#titulo-modal").text('Modificar Docente');
  var usuario_id = $(this).attr('id'); 
  $.ajax({
    url: 'usuarios/obtener',
    method: 'GET', // o GET, PUT, DELETE, según tus necesidades
    data: {id : usuario_id},
    dataType: 'json', // o 'text', 'html', según el tipo de respuesta esperada
    success: function(respuesta) {
      $('input[name=id]').val(respuesta.id)
      $('input[name=nombre]').val(respuesta.nombre)
      $('select[name=tipo]').val(respuesta.tipo)
      $('input[name=precio]').val(respuesta.precio)
      $('select[name=unidad_medida]').val(respuesta.unidad_medida)
    },
    error: function(xhr, status, error) {
      var mensajeError = "Ocurrió un error en la solicitud AJAX.";
    
    // Obtener información detallada del error
    var mensajeDetallado = "Error: " + error + ", Estado: " + status + ", Descripción: " + xhr.statusText;

    // Mostrar mensaje de error en algún elemento HTML
    $('#mensaje-error').text(mensajeError);
    
    // Mostrar mensaje detallado en la consola
    console.log(mensajeDetallado);
    }
  })
  $("#modalproducto").modal('show');
});
</script>
@endsection





