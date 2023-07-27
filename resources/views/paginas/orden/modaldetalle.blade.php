<form name="modaldetalleform" id="modaldetalleform" action="guardar" method="POST">
    <div class="modal fade" id="modaldetalle">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h4 class="modal-title tex-dark" id="titulo-modal">Nuevo Docente</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              @csrf
              <div class="card-body">
                <!-- Formulario para los detalles de la orden -->
                <div class="detalle-form" id="detalle-form">
                    <div class="mb-3">
                        <label for="producto_id" class="form-label">Producto ID</label>
                        <select name="producto_id" id="producto_id" class="form-control">
                          <option value="">Seleccione</option>
                          @foreach ($productos as $item)
                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                          @endforeach
                        </select>
                        <input type="hidden" name="nombreproducto" value="">
                    </div>
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" name="cantidad" id="cantidad" value="0" step="1" required>
                    </div>
                    <div class="mb-3">
                      <label for="precio" class="form-label">Precio</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            S/.
                          </span>
                        </div>
                        <input type="text" class="form-control" name="precio" id="precio" placeholder="0.00"> 
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="subtotal" class="form-label">Subtotal</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            S/.
                          </span>
                        </div>
                        <input type="text" class="form-control" name="subtotal" id="subtotal" placeholder="0.00"> 
                      </div>
                    </div>
                    <!-- Botón para agregar detalles de la orden -->
                    
                    <hr>
                </div>               
              </div>
              <!-- /.card-body -->
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="agregar-detalle">Guardar Detalle</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->    
  </form>  