<form name="entidadform" id="entidadform" action="guardar" method="POST">
    <div class="modal fade" id="modalentidad">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h4 class="modal-title tex-dark" id="titulo-modal">Nueva Venta</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="ruc_dni">Nombre</label>
                  <input type="hidden" name="id" value="">
                  <input type="text" class="form-control" name="ruc_dni" id="ruc_dni" placeholder="RUC DNI">
                </div>
                <div class="form-group">
                  <label for="nombre">Nombre o Razon Social</label>
                  <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Razon Social">
                </div>
                <div class="form-group">
                  <label for="representante">Representante</label>
                  <input type="text" class="form-control" id="representante" name="representante" placeholder="Representante">
                </div>
                <div class="form-group">
                  <label for="correo">Correo</label>
                  <input type="text" class="form-control" id="correo" name="correo" placeholder="">
                </div>
                <div class="form-group">
                  <label for="telefono">Telefono</label>
                  <input type="text" class="form-control" id="telefono" name="telefono" placeholder="">
                </div>
                <div class="form-group">
                  <label for="direccion">Direccion</label>
                  <input type="text" class="form-control" id="direccion" name="direccion" placeholder="">
                </div>                
                <div class="form-group">
                  <label for="tipo">Tipo Entidad</label>
                  <input type="text" class="form-control" id="tipo" name="tipo" value="{{$tipoentidad}}" placeholder="" readonly>
                </div>                

              </div>
              <!-- /.card-body -->
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline-dark">Guardar</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->    
  </form>  