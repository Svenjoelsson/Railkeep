@if(Auth::user()->role == 'user')
<li class="nav-item">
    <a href="{{ route('dashboard') }}"
       class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}">
       <i class="fas fa-home right"></i> <p>Dashboard</p>
    </a>
</li>
<hr>
<li class="nav-item">
    <a href="{{ route('customers.index') }}"
       class="nav-link {{ Request::is('customers*') ? 'active' : '' }}">
       <i class="fas fa-address-card right"></i> <p>Customers</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('contacts.index') }}"
       class="nav-link {{ Request::is('contacts*') ? 'active' : '' }}">
       <i class="fas fa-id-badge right"></i> <p>Contacts</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('vendors.index') }}"
       class="nav-link {{ Request::is('vendors*') ? 'active' : '' }}">
       <i class="fas fa-warehouse right"></i> <p>Vendors</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('units.index') }}"
       class="nav-link {{ Request::is('units*') ? 'active' : '' }}">
       <i class="fas fa-train right"></i><p>Units</p>
    </a>
</li>
<hr>





@endif
@if(Auth::user()->role != '')
<li class="nav-item">
    <a href="{{ route('services.index') }}"
       class="nav-link {{ Request::is('services*') ? 'active' : '' }}">
       <i class="fas fa-tools right"></i> <p>Services</p>
    </a>
</li>
@endif
@if(Auth::user()->role == 'user')
@if(Auth::user()->is_admin == '1')
<li class="nav-item">
    <a href="{{ route('activities.index') }}"
       class="nav-link {{ Request::is('activities*') ? 'active' : '' }}">
        <i class="fas fa-bell right"></i><p>Activities</p>
    </a>
</li>
@endif

<li class="nav-item">
    <a href="{{ route('rents.index') }}"
       class="nav-link {{ Request::is('rents*') ? 'active' : '' }}">
        <p>Rental</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('inventories.index') }}"
       class="nav-link {{ Request::is('inventories*') ? 'active' : '' }}">
        <p>Inventories</p>
    </a>
</li>
@endif



