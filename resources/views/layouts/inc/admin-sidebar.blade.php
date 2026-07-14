<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <!-- Core Section -->
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ url('admin/dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <!-- Interface Section -->
                <div class="sb-sidenav-menu-heading">Interface</div>

                <!-- program Section -->
                <a class="nav-link {{ Request::is('admin/program', 'admin/add-program', 'admin/edit-program/*') ? 'active' : '' }}" href="{{ url('admin/program/') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-graduation-cap"></i></div>
                    Program
                </a>

                <!-- Posts Section -->
                <a class="nav-link {{ Request::is('admin/post', 'admin/add-post', 'admin/edit-post/*') ? 'active' : '' }}" href="{{ url('admin/post') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Posts
                </a>

                <!-- Users Section -->
                <a class="nav-link {{ Request::is('admin/users', 'admin/edit-users/*') ? 'active' : '' }}" href="{{ url('admin/users') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Users
                </a>



                <!-- Addons Section -->
                <div class="sb-sidenav-menu-heading">Addons</div>
                <a class="nav-link {{ Request::is('admin/settings') ? 'active' : '' }}" href="{{ url('admin/settings') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                    Settings
                </a>

                <a class="nav-link" href="{{url('/home')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                    Home
                </a>

            </div>
        </div>

        <!-- Footer -->
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            @auth
                {{ Auth::user()->name }} | Admin
            @endauth
        </div>
    </nav>
</div>
