<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('index')}}" class="brand-link">
        <img src="{{asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{env('APP_NAME',trans('index.app_name'))}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset(\Illuminate\Support\Facades\Auth::user()->avatar)}}" class="img-circle elevation-2"
                     alt="User Image">
            </div>
            <div class="info">
                <a href="{{route('users.profile')}}"
                   class="d-block">{{\Illuminate\Support\Facades\Auth::user()->name}}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                @if(auth()->user()->is_admin < 2)
                    <li class="nav-item ">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                {{trans('readers.index')}}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('readers.index')}}" class="nav-link ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{trans('readers.list')}}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('readers.create')}}" class="nav-link ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{trans('readers.create')}}</p>
                                </a>
                            </li>

                        </ul>

                    </li>
                @endif

                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-book-reader"></i>
                        <p>
                            {{trans('books.index')}}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('books.index')}}" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{trans('books.list')}}</p>
                            </a>
                        </li>
                        @if(auth()->user()->is_admin < 2)
                            <li class="nav-item">
                                <a href="{{route('books.create')}}" class="nav-link ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{trans('books.create')}}</p>
                                </a>
                            </li>
                        @endif

                    </ul>

                </li>

                @if(auth()->user()->is_admin < 2)
                    <li class="nav-item ">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon fas fa-sticky-note"></i>
                            <p>
                                {{trans('order.index')}}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('orders.index')}}" class="nav-link ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{trans('order.list')}}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('orders.create')}}" class="nav-link ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{trans('order.create')}}</p>
                                </a>
                            </li>

                        </ul>

                    </li>
                @endif

                @if(\Illuminate\Support\Facades\Auth::user()->is_admin === 1)
                    <li class="nav-item ">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p>
                                {{trans('users.index')}}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('users.index')}}" class="nav-link ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{trans('users.list')}}</p>
                                </a>
                            </li>

                        </ul>

                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
