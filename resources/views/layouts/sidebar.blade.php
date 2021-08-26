<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{!!route('home')!!}" class="brand-link">
      <img src="{!! asset('img/logo.png') !!}" alt="Logo Spreading" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Spreading System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{!! asset('img/avatar.jpg') !!}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{!!route('home')!!}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Home <span class="right badge badge-danger">New</span></p>
            </a>
          </li>
          <li class="nav-item has-treeview {{ Request::is('Pedidos*') ? 'menu-open':'' }}">
          <a href="#" class="nav-link {{ Request::is('Pedidos*') ? 'active':'' }}">
            <i class="nav-icon fas fa-money-check-alt"></i>
            <p> Pedidos <i class="fas fa-angle-left right"></i></p>
          </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="{{ route('pedidos.create') }}" class="nav-link {{ Request::is('pedidos/create*') ? 'active':'' }}">
                <i class="nav-icon far fa-circle nav-icon"></i>
                <p>Registrar</p>
              </a>
              </li>
              <li class="nav-item">
              <a href="{{ route('pedidos.index') }}" class="nav-link {{ Request::is('pedidos/index*') ? 'active':'' }}">
                <i class="nav-icon far fa-circle nav-icon"></i>
                <p>Buscar</p>
              </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{!!route('estados.index')!!}" class="nav-link">
              <i class="nav-icon fas fa-info-circle"></i>
              <p>Estados</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{!!route('partidos.index')!!}" class="nav-link">
              <i class="nav-icon fas fa-globe-americas"></i>
              <p>Partidos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{!!route('zonas.index')!!}" class="nav-link">
              <i class="nav-icon fas fa-search-location"></i>
              <p>Zonas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{!!route('agencias.index')!!}" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>Agencias</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{!!route('fuentes.index')!!}" class="nav-link">
              <i class="nav-icon fas fa-share-alt-square"></i>
              <p>Fuentes</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{!!route('deliverys.index')!!}" class="nav-link">
              <i class="nav-icon fas fa-motorcycle"></i>
              <p>Deliverys</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{!!route('clientes.index')!!}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>Clientes</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{!!route('productos.index')!!}" class="nav-link">
              <i class="nav-icon fa fa-shopping-basket"></i>
              <p>Productos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{!!route('categorias.index')!!}" class="nav-link">
              <i class="nav-icon fas fa-tag"></i>
              <p>Categorías</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{!!route('iva.index')!!}" class="nav-link">
              <i class="nav-icon fas fa-percent"></i>
              <p>Iva</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{!!route('medios.index')!!}" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>Medios Mercado Pago</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{!!route('stocks.index')!!}" class="nav-link">
              <i class="nav-icon fas fa-tasks"></i>
              <p>Stocks</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{!!route('stocks.historial')!!}" class="nav-link">
              <i class="nav-icon fas fa-history"></i>
              <p>Historial de Stocks</p>
            </a>
          </li>
          

        </ul>

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>