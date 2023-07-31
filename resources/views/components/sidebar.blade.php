<div>

    {{-- Administrador --}}
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{url('/')}}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Home
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{url('usuarios')}}" class="nav-link {{ request()->is('usuarios') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Usuarios
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-shopping-cart"></i>
            <p>
              Pedido
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/orden/pedido" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Orden de Pedido</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/pagos/pedido" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Pagos</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-money-bill-alt"></i>
            <p>
              Ventas
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/orden/venta" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Orden de Venta</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/pagos/venta" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Pagos</p>
              </a>
            </li>            
          </ul>
        </li>
        <li class="nav-item">
          <a href="/entidad/distribuidor" class="nav-link {{ request()->is('distribuidor') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <p>
              Distribuidores
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/entidad/proveedor" class="nav-link {{ request()->is('proveedor') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <p>
              Proveedores
            </p>
          </a>
        </li> 
        <li class="nav-item">
          <a href="/productos" class="nav-link {{ request()->is('productos') ? 'active' : '' }}">
            <i class="fas fa-box"></i>
            <p>
              Productos
            </p>
          </a>
        </li>            
        {{-- <li class="nav-item">
          <a href="reporte" class="nav-link {{ request()->is('productos') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i>
            <p>
              Reportes
            </p>
          </a>
        </li>                 --}}
      </ul>
    </nav>
    <!-- /.sidebar-menu -->


</div>