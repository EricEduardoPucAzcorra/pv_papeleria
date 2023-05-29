<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{asset('dist/img/Papelería.png')}}" alt="Logo D|S" class="brand-image elevation-3"
            style="opacity: .8;">
        <span class="brand-text font-weight-light">SPVS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            @if(Auth::user()->imagen=="")
                <div class="image">
                    <img src="{{asset('dist/img/user.png')}}" class="img-circle elevation-2" alt="Imagen de usuario">
                </div>
            @else
                <div class="image">
                    <img src="{{ Auth::user()->imagen }}" class="img-circle elevation-2" alt="Imagen de usuario">
                </div>
            @endif
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->nombre}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-header" style="background-color: #dbd6d6; color: rgb(8, 8, 8)"><b>PRINCIPAL</b></li>
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link {{!Route::is('dashboard') ?: 'active' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>
                            Tablero
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('ventas')}}" class="nav-link {{!Route::is('ventas') ?: 'active' }}">
                        <i class="fas fa-cash-register"></i>
                        <p>
                            Ventas
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('precios')}}" class="nav-link {{!Route::is('precios') ?: 'active' }}">
                        <i class="fas fa-dollar-sign"></i>
                        <p>
                            Calcular precio
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                    </a>
                </li>

                <li class="nav-header" style="background-color: #dbd6d6; color: rgb(8, 8, 8)"><b>INVENTARIO</b></li>

                <li class="nav-item">
                    <a href="{{route('categorias')}}" class="nav-link {{!Route::is('categorias') ?: 'active' }}">
                        <i class="fas fa-duotone fa-list nav-icon"></i>
                        <p>
                            Categorias
                            {{-- <span class="badge badge-info right">2</span> --}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('productos')}}" class="nav-link {{!Route::is('productos') ?: 'active' }}">
                        {{-- <img src="{{asset('icons/cut-outline.svg')}}" class="nav-icon" style="color:white"> --}}
                        <i class="fas fa-sharp fa-regular fa-paperclip nav-icon"></i>
                        <p>
                            Productos
                        </p>
                    </a>
                </li>

                <li class="nav-header" style="background-color: #dbd6d6; color: rgb(8, 8, 8)"><b>REPORTES</b></li>

                <li class="nav-item">
                    <a href="{{route('deudas.index')}}" class="nav-link {{!Route::is('deudas.*') ?: 'active'}}">
                        <i class="nav-icon fas fa-money-bill-alt"></i>
                        <p>
                            Deudas
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('reportes')}}" class="nav-link {{!Route::is('reportes') ?: 'active'}}">
                        <i class="fas fa-sharp fa-regular fa-clipboard nav-icon"></i>
                        <p>
                            Reportes
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('cancelacion')}}" class="nav-link {{!Route::is('cancelacion') ?: 'active'}}">
                        <i class="nav-icon fas fa-calendar-times"></i>
                        <p>
                            Cancelar Venta
                        </p>
                    </a>
                </li>

                <li class="nav-header" style="background-color: #dbd6d6; color: rgb(8, 8, 8)"><b>CUENTA</b></li>

                {{-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>
                            Perfil
                        </p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="javascript:void(0);" onclick="document.getElementById('logout').submit()" class="nav-link">
                        <i class="nav-icon fas fa-user-times"></i>
                        <p>
                            Cerrar sesión
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        <form action="{{route('logout')}}" method="POST" id="logout">
            @csrf
        </form>
    </div>
    <!-- /.sidebar -->
</aside>
