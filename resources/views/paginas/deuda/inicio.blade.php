@extends('layout')
@section('maincontent')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Detalle de Deuda por Orden {{$orden->tipo}}</h3>
      </div>
      <div class="card-body">
          <div class="row">
            <div class="col">
              <dl>
                <dt>ENTIDAD</dt>
                <dd>{{$orden->entidad->nombre}}</dd>
                <dt>MONTO</dt>
                <dd>{{$deuda->orden->total}}</dd>
              </dl>              
            </div>
            <div class="col">
              <dl>
                <dt>NRO DE CUOTAS</dt>
                <dd>{{$deuda->nrocuotas}}</dd>
              </dl>    
              <button type="button" id="btnmodalformpago" class="btn btn-primary">
                REALIZAR PAGO
              </button>
            </div>
          </div>
          <h3>DETALLES DE DEUDA</h3>
        <br>
        @include('paginas.deuda.modalpago')
        @include('paginas.deuda.vistadetalle')
        <h3>DETALLES DE PAGOS</h3>
        <table id="tabladetallepagos" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>MONTO</th>
              <th>FECHA HORA</th>
              <th>RESPONSABLE</th>
              <th>USUARIO</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
          <tfoot>
            <tr>
              <th>MONTO</th>
              <th>FECHA HORA</th>
              <th>RESPONSABLE</th>
              <th>USUARIO</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<!-- SweetAlert2 -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script>
  let csrf_token = $('meta[name="csrf-token"]').attr('content');
  function limpiarformusuario(){
    $('input[name=nrocuotas]').val(0)
    $('input[name=monto]').val('')
  }
  carga_inicial();
  function carga_inicial(){ 
    $('#tabladetallepagos').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "responsive": false,
    });
    cargarpagos();
  }
  function cargarpagos(){
    var table = $('#tabladetallepagos').DataTable();
    table.clear().draw();
    $.ajax({
      url: '/pagos/listapagos',
      method: 'GET',
      data: {id : {{$orden->id}} },
      dataType: 'json',
      success: function(respuesta) {
          (respuesta.pagos).forEach(function(repo) {
              table.row.add([
              repo.monto,
              repo.fechahora,
              repo.responsable,
              repo.usuario.name
            ]).draw();
          });
      },
      error: function(xhr, status, error) {
        var mensajeError = "Ocurrió un error en la solicitud AJAX.";
        var mensajeDetallado = "Error: " + error + ", Estado: " + status + ", Descripción: " + xhr.statusText;
        $('#mensaje-error').text(mensajeError);
        console.log(mensajeDetallado);
      }
    })
  }

$('#nrocuotas').on('input', function() {
      let cuota = parseFloat($('#cuota').val());
      //let monto = parseFloat($('#monto').val());
      let nrocuotas = parseFloat($('#nrocuotas').val());
      let monto = (nrocuotas * cuota).toFixed(1);
      $('input[name=monto]').val(monto);
    });   

$("#btnmodalformpago").on("click", function() {
  $("#modalformpago").modal('show');
});

document.getElementById('pagoform').addEventListener('submit', function (event) {
    event.preventDefault(); // Evita que el formulario se envíe normalmente
    var form = document.getElementById('pagoform');
    $('.alert-danger').remove();
    $.ajax({
        type:'POST',
        url: this.action,
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function(data) {
          form.reset();
          $("#modalformpago").modal('hide');
          toastr.success(data.mensaje)
          cargarpagos();
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

</script>
@endsection





