<table id="tabladetalledeuda" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>NRO</th>
      <th>FECHA</th>
      <th>MONTO</th>
      <th>ESTADO</th>
    </tr>
  </thead>
  <tbody>
      @foreach ($orden->detallesdeuda as $item)
          <tr>
              <td>{{$item->orden}}</td>
              <td>{{$item->fecha}}</td>
              <td>{{$item->monto}}</td>
              <td>{{$item->estado}}</td>
          </tr>
      @endforeach
  </tbody>
  <tfoot>
    <tr>
      <th>NRO</th>
      <th>FECHA</th>
      <th>MONTO</th>
      <th>ESTADO</th>
    </tr>
  </tfoot>
</table>