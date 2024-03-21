<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <!-- User Profile -->
            <li class="nav-item dashboard">
                <a href="{{ route('profile.show') }}" class="nav-link">
                    <i class="nav-icon fa fa-address-book"></i>
                    <p>
                        {{ Auth::user()->first_name }}
                        {{ Auth::user()->last_name }}
                    </p>

                </a>
            </li>

            <hr style="background-color: white;">

            <!-- Dashboard -->
            <li class="nav-item dashboard">
                <a href="{{ route('home') }}" class="nav-link" id="dashboard">
                    <i class="nav-icon fas fa-home"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>

            <!-- Projects -->
            <li class="nav-item projects">
                <a href="{{ route('projects') }}" class="nav-link" id="projects">
                    <i class="nav-icon fas fa-th"></i>
                    <p>{{ __('Projects') }}</p>
                </a>
            </li>

            <!-- Master List -->
            <li class="nav-item has-treeview" id="masterList">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>Master List <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <!-- List of Particular -->
                    <li class="nav-item">
                        <a href="{{ route('particular') }}" class="nav-link">
                            <i class="nav-icon far fa-address-card"></i>
                            <p>{{ __('List of Particular') }}</p>
                        </a>
                    </li>
                    <!-- List of Materials -->
                    <li class="nav-item">
                        <a href="{{ route('list_of_materials') }}" class="nav-link">
                            <i class="nav-icon fas fa-tools"></i>
                            <p>{{ __('List of Materials') }}</p>
                        </a>
                    </li>
                    <!-- List of Labor Rates -->
                    <li class="nav-item">
                        <a href="{{ route('list_of_labors') }}" class="nav-link">
                            <i class="nav-icon fas fa-hard-hat"></i>
                            <p>{{ __('List of Labor Rates') }}</p>
                        </a>
                    </li>
                    <!-- List of Equipments -->
                    <li class="nav-item">
                        <a href="{{ route('list_of_equipments') }}" class="nav-link">
                            <i class="nav-icon fas fa-snowplow"></i>
                            <p>{{ __('List of Equipments') }}</p>
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
