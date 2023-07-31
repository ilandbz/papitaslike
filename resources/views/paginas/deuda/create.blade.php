@extends('layout')
@section('maincontent')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">ORDEN DE PEDIDO</h3>
      </div>
      <div class="card-body">
        <h2>DATOS ORDEN DE SERVICIO</h2>
        <form name="generardeudadform" id="generardeudadform" action="/deuda" method="POST">
          @csrf
          <div class="row">
            <div class="col-2 control">
              <label for="entidad_id">ENTIDAD</label>
              <input type="hidden" name="orden_id" id="orden_id" value="{{$orden->id}}">
              <input type="hidden" name="entidad_id" id="entidad_id" value="{{$orden->entidad_id}}">
              <input type="hidden" name="total" id="total" value="{{$orden->total}}">
              <input type="text" class="form-control" name="nombreentidad" id="nombreentidad" value="{{$orden->entidad->nombre}}" readonly>  
            </div>
            <div class="col-2 control">
              <label for="fecha">Fecha</label>
              <input type="date" class="form-control" name="fecha" id="fecha" placeholder="" value="{{$orden->fecha}}" readonly>               
            </div> 
            <div class="col-2">
              <label for="nombre">Modo de Pago</label>
              <input type="text" name="modopago" class="form-control" value="{{$orden->modopago}}" readonly>          
            </div>
            <div class="col-2 control">
              <label for="total">Total</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    S/.
                  </span>
                </div>
                <input type="text" class="form-control" name="total" id="total" placeholder="0.00" value="{{$orden->total}}" readonly> 
              </div>
            </div>
            <div class="col-1">
              <label for="nrocuotas">Nro de Cuotas</label>
              <input type="number" name="nrocuotas" id="nrocuotas" class="form-control" value="1">  
            </div>
            <div class="col-1">
                <label for="frecuencia">Frecuencia</label>
                <select name="frecuencia" id="frecuencia" class="form-control">
                    <option value="Diario">Diario</option>
                    <option value="Semanal">Semanal</option>
                    <option value="Mensual">Mensual</option>
                </select> 
            </div>
            <div class="col-md-2">
                @php
                    $fechaActual = date('Y-m-d'); // Obtiene la fecha actual en formato 'YYYY-MM-DD'
                $fechaMasUnDia = date('Y-m-d', strtotime('+1 day', strtotime($fechaActual)));
                @endphp
                <label for="frecuencia">Fecha de Vencimiento</label>
                <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" value="{{$fechaMasUnDia}}" class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <br>
              <button type="submit" class="btn btn-sm btn-success">Generar Deuda</button>
              <br>
            </div>
          </div>
        </form>
          <div class="row">
            <div class="col">
              <br>
            <h3>DETALLES</h3>
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
                    @php
                        $fila = 1;
                    @endphp
                    @foreach ($orden->detalles as $item)
                        <td>{{$fila}}</td>
                        <td>{{$item->producto_id}}</td>
                        <td>{{$item->producto->nombre}}</td>
                        <td>{{$item->cantidad}}</td>
                        <td>{{$item->precio}}</td>
                        <td>{{$item->subtotal}}</td>
                        <td></td>    
                    @php
                        $fila++;
                    @endphp                    
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
   
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
    document.getElementById('generardeudadform').addEventListener('submit', function (event) {
        event.preventDefault(); 
        var form = document.getElementById('generardeudadform');
        $('.alert-danger').remove();
        $.ajax({
            type:'POST',
            url: this.action,
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(data) {             
              console.log(data.deuda_id)
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



    $('#nrocuotas, #frecuencia').on('input', function() {
      let nrocuotas = parseFloat($('#nrocuotas').val());
      let frecuencia = $('#frecuencia').val();
      $.ajax({
          url: '/deuda/calcular-fecha-vencimiento',
          method: 'GET',
          data: {nrocuotas : nrocuotas, frecuencia: frecuencia},
          dataType: 'json',
          success: function(respuesta) {
            $('input[name=fecha_vencimiento]').val(respuesta.fecha_vencimiento)
          },
          error: function(xhr, status, error) {
            var mensajeError = "Ocurrió un error en la solicitud AJAX.";
            var mensajeDetallado = "Error: " + error + ", Estado: " + status + ", Descripción: " + xhr.statusText;
            $('#mensaje-error').text(mensajeError);
            console.log(mensajeDetallado);
          }
        })

    });   
</script>
@endsection





