<!-- Sidebar -->
<div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
                <a href="{{ route('profile.show') }}" class="nav-link"><i
                        class="nav-icon fa fa-address-book"></i>{{ Auth::user()->first_name }}
                    {{ Auth::user()->last_name }}</a>

            </li>

            <hr style="background-color: white;">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        {{ __('Dashboard') }}
                    </p>
                </a>
            </li>


            <li class="nav-item">
                <a href="{{ route('projects') }}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        {{ __('Projects') }}
                    </p>
                </a>
            </li>


            {{-- List of Material Sidebar Navigation --}}
            <li class="nav-item">
                <a href="{{ route('list_of_materials') }}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        {{ __('List Of Materials') }}
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('list_of_labors') }}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        {{ __('Labor Rates') }}
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('particular') }}" class="nav-link">
                    <i class="nav-icon far fa-address-card"></i>
                    <p>
                        {{ __('Particular') }}
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="nav-icon fas fa-circle nav-icon"></i>
                    <p>
                        Project Particulars
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">

                    <li class="nav-item">
                        <a href="{{ route('project_particular') }}" class="nav-link">
                            <i class="nav-icon far fa-address-card"></i>
                            <p>
                                {{ __('Project Particular') }}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Particulal Material </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Particulal Labor</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Particulal Equipment</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
