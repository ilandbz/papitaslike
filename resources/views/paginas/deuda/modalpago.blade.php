<form name="pagoform" id="pagoform" action="/pagos/guardar" method="POST">
    <div class="modal fade" id="modalformpago">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h4 class="modal-title tex-dark" id="titulo-modal">Registro de Pago</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="responsable">Responsable</label>
                  <input type="text" step="1" class="form-control" name="responsable" min="0" id="responsable" placeholder="Responsable">
                  <input type="hidden" name="fechahora" id="fechahora" value="{{date('Y-m-d H:i:s')}}">
                </div>                
                <div class="form-group">
                  <label for="nrocuotas">Nro Cuotas</label>
                  <input type="hidden" name="orden_id" id="orden_id" value="{{$orden->id}}">
                  <input type="number" step="1" class="form-control" name="nrocuotas" min="0" id="nrocuotas" placeholder="0">
                </div>
                <div class="form-group">
                  <input type="hidden" name="cuota" id="cuota" value="{{$deuda->orden->total/$deuda->nrocuotas}}">
                  <label for="monto">Monto</label>
                  <input type="text" class="form-control" name="monto" id="monto" value="" placeholder="0.00">
                </div>
              </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline-dark">Guardar</button>
          </div>
        </div>
      </div>
    </div>
</form>  