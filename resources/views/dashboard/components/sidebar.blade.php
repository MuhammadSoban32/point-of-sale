<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
        <a class="nav-link " href="/">
            <i class="fas fa-fw fa-table"></i>
            <span>Inventory</span></a>
    </li>
    <li class="nav-item  {{ request()->is('bills') || request()->is('bills_create_page') ? 'active' : '' }}">
        {{-- || request()->segment(1)   --}}
        <a class="nav-link " href="/bills">
            <i class="fas fa-fw fa-table"></i>
            <span>Bill Generate</span></a>
    </li>
    <li class="nav-item @yield('booking')">
        <a class="nav-link " href="/booking">
            <i class="fas fa-fw fa-table"></i>
            <span>Bookings</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>