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
                <a href="" class="nav-link">
                    <i class="nav-icon fas fa-circle nav-icon"></i>
                    <p>
                        Master List
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">

                    {{-- List of Material Sidebar Navigation --}}
                    <li class="nav-item">
                        <a href="{{ route('particular') }}" class="nav-link">
                            <i class="nav-icon far fa-address-card"></i>
                            <p>
                                {{ __('List of Particular') }}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('list_of_materials') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                {{ __('List of Materials') }}
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('list_of_labors') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                {{ __('List of Labor Rates') }}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('list_of_equipments') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                {{ __('List of Equipments') }}
                            </p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
<script>
    $(document).ready(function() {
        // Add 'active' class to 'Dashboard', 'Projects', and 'Master List' sections if any of their children are active
        var path = window.location.href;
        $('ul.nav-sidebar a').each(function() {
            if (this.href === path) {
                $(this).addClass('active');
                $(this).parents('li').addClass('menu-open');
                $(this).closest('ul').css('display', 'block');

            }
        });

        // Change background color and text color of dashboard and projects if they are active
        if ($('#dashboard').hasClass('active')) {
            $('#dashboard').css('background-color', '#ffc001');
            $('#dashboard').css('color', 'black');
        }
        if ($('#projects').hasClass('active')) {
            $('#projects').css('background-color', '#ffc001');
            $('#projects').css('color', 'black');
        }
    });
</script>
