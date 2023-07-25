@extends('layout')

@section('maincontent')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">ORDEN DE COMPRA</h3>
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
        @include('paginas.entidades.vistatabla')
      </div>
      <!-- /.card-body -->
    </div>
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

@include('paginas.entidades.modalentidad')
@endsection


@section('script')
<!-- SweetAlert2 -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script>
  let csrf_token = $('meta[name="csrf-token"]').attr('content');
    document.getElementById('entidadform').addEventListener('submit', function (event) {
        event.preventDefault(); // Evita que el formulario se envíe normalmente
        var form = document.getElementById('entidadform');
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
              $("#modalentidad").modal('hide');
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
      $("#tablaentidades").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#tablaentidades_wrapper .col-md-6:eq(0)');
      cargar_datatable();
    }
    function cargar_datatable(){
      var table = $('#tablaentidades').DataTable();
      table.clear();
      $.ajax({
          dataType:'json',
          url: '{{$tipoentidad}}-todos',
          success: function(data) {
            let numero_orden = 1;
              (data.entidades).forEach(function(repo) {
                  table.row.add([
                  numero_orden,
                  repo.ruc_dni,
                  repo.nombre,
                  repo.representante,
                  repo.correo,
                  repo.telefono,
                  repo.direccion,
                  repo.tipo,
                  '<div class="btn-group" role="group" aria-label="Basic mixed styles example">'+
                    '<a id="'+repo.id+'" class="btn btn-danger btn_eliminar_producto mr-1"><i class="fa fa-trash" aria-hidden="true"></i></a>'+
                    '<a id="'+repo.id+'" class="btn btn-warning btn_modificar_entidad mr-1"><i class="fa fa-pencil" aria-hidden="true"></i></a>' +
                  '</div>'
                ]).draw();
                  numero_orden++;
              });
          }
      })
    }
    $("#tablaentidades").on('click', '.btn_eliminar_producto', function() {            
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
                url: 'eliminar',
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
    'ruc_dni', 'nombre', 'representante', 'correo', 'telefono', 'direccion', 'tipo'
    function limpiarformusuario(){
      $('input[name=ruc_dni]').val('');  
      $('input[name=nombre]').val('')
      $('input[name=representante]').val('')
      $('input[name=correo]').val('')
      $('input[name=telefono]').val('')
      $('input[name=direccion]').val('')
    }

$('#btn-nuevo-producto').click(function (){
  limpiarformusuario();
  $("#titulo-modal").text('Nuevo {{$tipoentidad}}');
  $("#modalentidad").modal('show');
});

$("#tablaentidades").on('click', '.btn_modificar_entidad', function() { 
  $('.alert-danger').remove();
  $("#titulo-modal").text('Modificar Docente');
  var entidad_id = $(this).attr('id'); 
  $.ajax({
    url: 'obtener',
    method: 'GET', // o GET, PUT, DELETE, según tus necesidades
    data: {id : entidad_id},
    dataType: 'json', // o 'text', 'html', según el tipo de respuesta esperada
    success: function(respuesta) {
      $('input[name=id]').val(respuesta.id); 
      $('input[name=ruc_dni]').val(respuesta.ruc_dni);  
      $('input[name=nombre]').val(respuesta.nombre)
      $('input[name=representante]').val(respuesta.representante)
      $('input[name=correo]').val(respuesta.correo)
      $('input[name=telefono]').val(respuesta.telefono)
      $('input[name=direccion]').val(respuesta.direccion)
      $('input[name=tipo]').val(respuesta.tipo)
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
  $("#modalentidad").modal('show');
});
</script>
@endsection





