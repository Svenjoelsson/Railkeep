@if(Auth::user()->role == 'user')
<li class="nav-item">
    <a href="{{ route('dashboard') }}"
       class="nav-link {{ Request::is('dashboard*') ? 'activeNav' : '' }}">
       <i class="fas fa-home right"></i> <p>Dashboard</p>
    </a>
</li>
<hr>
<li class="nav-item">
    <a href="{{ route('customers.index') }}"
       class="nav-link {{ Request::is('customers*') ? 'activeNav' : '' }}">
       <i class="fas fa-address-card right"></i> <p>Customers</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('contacts.index') }}"
       class="nav-link {{ Request::is('contacts*') ? 'activeNav' : '' }}">
       <i class="fas fa-id-badge right"></i> <p>Contacts</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('vendors.index') }}"
       class="nav-link {{ Request::is('vendors*') ? 'activeNav' : '' }}">
       <i class="fas fa-warehouse right"></i> <p>Vendors</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('units.index') }}"
       class="nav-link {{ Request::is('units*') ? 'activeNav' : '' }}">
       <i class="fas fa-train right"></i><p>Units</p>
    </a>
</li>
<hr>





@endif
@if(Auth::user()->role != '')
<li class="nav-item">
    <a href="{{ route('services.index') }}"
       class="nav-link {{ Request::is('services*') ? 'activeNav' : '' }}">
       <i class="fas fa-tools right"></i> <p>Services</p>
    </a>
</li>
@endif
@if(Auth::user()->role == 'user')


<li class="nav-item">
    <a href="{{ route('rents.index') }}"
       class="nav-link {{ Request::is('rents*') ? 'activeNav' : '' }}">
       <i class="fas fa-file-contract right"></i><p>Agreements</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('inventories.index') }}"
       class="nav-link {{ Request::is('inventories*') ? 'activeNav' : '' }}">
       <i class="fas fa-cogs right"></i><p>Inventories</p>
    </a>
</li>

@if(Auth::user()->is_admin == '1')
<li class="nav-item">
    <a href="{{ route('activities.index') }}"
       class="nav-link {{ Request::is('activities*') ? 'activeNav' : '' }}">
        <i class="fas fa-bell right"></i><p>Activities</p>
    </a>
</li>
@endif

@endif



