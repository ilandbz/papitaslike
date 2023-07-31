<div>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="/" class="nav-link">Home</a>
          </li>
        </ul>
    
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

          <!-- Notifications Dropdown Menu -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-bell"></i>
              <span class="badge badge-danger navbar-badge" id="cantnotificaciones">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header">DEUDAS VENCIDAS</span>
              <div id="notificaciones">
                
              </div>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
          </li>
    
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <img src="{{asset('imagenes/default.jpg')}}"  class="img-circle img-sm mr-1"/>{{Auth::user()->email}}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <!-- <span class="dropdown-item dropdown-header">15 Notifications</span> -->
                <div class="dropdown-divider"></div>   
                <a href="{{ route('logout') }}" class="dropdown-item"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    <i class="fas fa-power-off fa-fw mr-2"></i> Cerrar Sesi&oacute;n
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <!-- <div class="dropdown-divider"></div> -->
                <!-- <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> -->
            </div>
          </li>

        </ul>
    </nav>
</div>
