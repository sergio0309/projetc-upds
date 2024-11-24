<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="http://localhost/creative2/public/assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="http://localhost/creative2/public/assets/images/logo-dark.png" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="http://localhost/creative2/public/assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="http://localhost/creative2/public/assets/images/logo-light.png" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>Inicio</span></li>
                <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link">
                        <i class="ri-dashboard-2-line"></i> <span>Panel</span>
                    </a>
                </li>
                <li class="menu-title"><i class="ri-more-fill"></i> <span>Modulos</span></li>
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="ri-bookmark-fill"></i> <span>Clientes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="ri-stack-fill"></i> <span>Reportes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="ri-shopping-bag-fill"></i> <span>Historial</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarCompras" data-bs-toggle="collapse" role="button"
                       aria-expanded="{{ request()->is('compras*') ? 'true' : 'false' }}" aria-controls="sidebarCompras">
                        <i class="ri-shopping-cart-2-fill"></i> <span>Tipoa de Servicio</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->is('compras*') ? 'show' : '' }}" id="sidebarCompras">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    {{-- href="{{ route('compras.index') }}" class="nav-link {{ request()->routeIs('compras.index') ? 'active' : '' }}" --}}

                                    <i class="ri-eye-fill"></i> <span>Ver</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    {{-- href="{{ route('compras.create') }}" class="nav-link {{ request()->routeIs('compras.create') ? 'active' : '' }}" --}}
                                    <i class="ri-add-circle-line"></i> <span>Crear</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="ri-team-fill"></i> <span>Personal</span>
                    </a>
                </li>
                <li class="menu-title"><i class="ri-more-fill"></i> <span>Roles y Usuarios</span></li>
                <li class="nav-item">
                    <a href="dashboard-analytics" class="nav-link">
                        <i class="ri-settings-4-fill"></i> <span>Roles & Permisos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="dashboard-analytics" class="nav-link">
                        <i class="ri-user-3-fill"></i> <span>Usarios</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
