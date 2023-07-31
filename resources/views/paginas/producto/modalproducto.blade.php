<form name="productoform" id="productoform" action="productos" method="POST">
    <div class="modal fade" id="modalproducto">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h4 class="modal-title tex-dark" id="titulo-modal">Nuevo Producto</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input type="hidden" name="id" value="">
                  <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombres">
                </div>
                <div class="form-group">
                  <label for="tipo">Tipo</label>
                  <select name="tipo" id="tipo" class="form-control">
                    <option value="INSUMO">INSUMO</option>
                    <option value="PRODUCTO">PRODUCTO</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="precio">Precio</label>
                  <input type="text" class="form-control" id="precio" name="precio" placeholder="S/. 0.00">
                </div>  
                <div class="form-group">
                  <label>Unidad de Medida</label>
                  <select name="unidad_medida" class="form-control">
                    @foreach ($unidades as $item)
                        <option value="{{$item->nombre}}" {{($item->codigo_sunat=='BG' ? 'selected' : '')}}>{{$item->nombre}}</option>
                    @endforeach
                  </select>
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