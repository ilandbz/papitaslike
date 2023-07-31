@extends('layout')
@section('maincontent')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">ORDEN DE VENTA</h3>
      </div>
      <div class="card-body">
        <h2>Ingresar Orden de Venta</h2>
        <form name="ordenform" id="ordenform" action="/guardar_orden" method="POST">
          @csrf
          <div class="row">
            <input type="hidden" name="tipo" id="tipo" value="{{$title}}">
            <div class="col-2 control">
              <label for="entidad_id">ENTIDAD</label>
              <select name="entidad_id" id="entidad_id" class="form-control">
                <option value="">Seleccione</option>
                @foreach ($entidades as $item)
                <option value="{{$item->id}}">{{$item->nombre}}</option>
                @endforeach
              </select>   
            </div>
            <div class="col-2 control">
              <label for="fecha">Fecha</label>
              <input type="date" class="form-control" name="fecha" id="fecha" placeholder="" value="{{date('Y-m-d')}}">               
            </div> 
            <div class="col-2">
              <label for="nombre">Modo de Pago</label>
              <select name="modopago" id="modopago" class="form-control">
                <option value="Al Contado">Al Contado</option>
                <option value="Cuotas">Cuotas</option>
              </select>            
            </div>
            <div class="col-2 control">
              <label for="total">Total</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    S/.
                  </span>
                </div>
                <input type="text" class="form-control" name="total" id="total" placeholder="0.00" value="0" readonly> 
              </div>
            </div>
            <div class="col-1">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <br>
              <button type="button" class="btn btn-sm btn-primary" id="nuevo_detalle"><i class="fas fa-plus-circle"></i> Agregar Detalle</button>
              <button type="submit" class="btn btn-sm btn-success">Guardar Orden</button>
              <br>
            </div>
          </div>
        </form>
          <div class="row">
            <div class="col">
              <br>

              <!-- Tabla para mostrar detalles de la orden -->
              <table class="table table-head-fixed text-nowrap" id="detalles-table">
                <thead>
                    <tr>
                        <th>NRO</th>
                        <th>Id Producto</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los detalles de la orden se agregarán dinámicamente aquí -->
                </tbody>
              </table>
            </div>
          </div>
          @include('paginas.orden.modaldetalle')        
      </div>
      <!-- /.card-body -->
    </div>
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@endsection
@section('script')
<!-- SweetAlert2 -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script>
    let csrf_token = $('meta[name="csrf-token"]').attr('content');
    document.getElementById('ordenform').addEventListener('submit', function (event) {
    var table = $('#detalles-table').DataTable();
    $('.alert-danger').remove();
      var fecha = $('#fecha').val();
      var entidad_id = $('#entidad_id').val();
      var total = $('#total').val();
      var tipo = $('#tipo').val();
      var modopago = $('#modopago').val();

      event.preventDefault();
      var form = document.getElementById('ordenform');
      var detalles = [];
      table.rows().every(function() {
          var data = this.data();
          detalles.push({
              producto_id: data[1],
              cantidad: data[3],
              precio: data[4],
              subtotal: data[5]
          });
      });
      $.ajax({
          method: 'POST',
          url: '/orden/detalles',
          data: {
            fecha : fecha,
            entidad_id : entidad_id,
            total : total,
            tipo : tipo,
            modopago : modopago,
            detalles: detalles,  
            _token: csrf_token
          },
          success: function(response) {
            form.reset();
            table.clear().draw();
            toastr.success(response.mensaje)
          },
          error: function(xhr, status, error) {
            let res = xhr.responseJSON
            if($.isEmptyObject(res) === false){
              $.each(res.errors,function (key, value){
                $("input[name='" + key + "'], select[name='" + key + "']").each(function() {
                  $(this).closest('.control')
                    .append('<div class="alert alert-danger" role="alert">'+ value+ '</div>')
                });
              });
            }
          }
      });
    });

    let nroorden=0;
    $("#nuevo_detalle").on("click", function() {
        $("#titulo-modal").text('Nuevo Detalle');
        $("#modaldetalle").modal('show');
    });
    carga_inicial();
    function carga_inicial(){ 
      $('#detalles-table').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
      });
    }
    $("#producto_id").on("change", function() {
      let productoId = $(this).val();
        $.ajax({
          url: '/productos/obtener',
          method: 'GET',
          data: {id : productoId},
          dataType: 'json',
          success: function(respuesta) {
            $('input[name=nombreproducto]').val(respuesta.nombre)
            $('input[name=precio]').val(respuesta.precio)
          },
          error: function(xhr, status, error) {
            var mensajeError = "Ocurrió un error en la solicitud AJAX.";
            var mensajeDetallado = "Error: " + error + ", Estado: " + status + ", Descripción: " + xhr.statusText;
            $('#mensaje-error').text(mensajeError);
            console.log(mensajeDetallado);
          }
        })
    });
    $('#cantidad, #precio').on('input', function() {
      let cantidad = parseFloat($('#cantidad').val());
      let precio = parseFloat($('#precio').val());
      let subtotal = (cantidad * precio).toFixed(1);
      $('input[name=subtotal]').val(subtotal);
    });   
    $("#agregar-detalle").on("click", function() {
        var table = $('#detalles-table').DataTable();
        var detalleForm = $("#detalle-form");
        var nuevoDetalleForm = detalleForm.clone();
        nroorden++;
        // Extrae los valores del formulario del detalle
        var nombre = detalleForm.find("[name='nombreproducto']").val();
        var productoId = detalleForm.find("[name='producto_id']").val();
        var cantidad = detalleForm.find("[name='cantidad'").val();
        var precio = detalleForm.find("[name='precio']").val();
        var subtotal = parseFloat(detalleForm.find("[name='subtotal']").val()); 
        var total = parseFloat($('input[name=total]').val()); 
        total=(total+subtotal);
        $('input[name=total]').val(total.toFixed(2));       
        table.row.add([
          nroorden,
          productoId,
          nombre,
          cantidad,
          precio,
          subtotal.toFixed(2),
          '<div class="btn-group" role="group" aria-label="Basic mixed styles example">'+
            '<a id="'+productoId+'" class="btn btn-danger btn_eliminar_detalle mr-1"><i class="fa fa-trash" aria-hidden="true"></i></a>'+
          '</div>'
          ]).draw();
        detalleForm.find("input").val("");
        $("#modaldetalle").modal('hide');
    });
    // Agregar evento de clic para los botones "Eliminar"
    $('#detalles-table').on('click', '.btn_eliminar_detalle', function() {
      var table = $('#detalles-table').DataTable();
      var productoId = $(this).data('producto-id');
      var row = $(this).closest('tr');
      table.row(row).remove().draw();
      nroorden = 1;
      table.rows().every(function() {
          this.data()[0] = nroorden;
          nroorden++;
      });
      table.draw();
    });


</script>
@endsection





