<ul class="navbar-nav sidebar sidebar-dark accordion bg-primary" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('customer.dashboard')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">HelpDesk</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Ticket -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('customer.dashboard')}}">
            <i class="bi bi bi-speedometer"></i>     
            <span>Dashboard</span></a>
    </li>
    
    <li class="nav-item active">
        <a class="nav-link collapsed" href="/customer/ticket">
            <i class="bi bi-ticket-detailed-fill"></i>
            <span>Ticket</span>
        </a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="/customer/messages">
            <i class="bi bi-chat-dots-fill"></i>
            <span>Message</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

