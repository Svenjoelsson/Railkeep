@if(auth()->user()->hasPermissionTo('view dashboard'))
<li class="nav-item">
    <a href="{{ route('dashboard') }}"
       class="nav-link {{ Request::is('dashboard*') ? 'activeNav' : '' }}">
       <i class="fas fa-home right"></i> <p>Dashboard</p>
    </a>
</li>
<hr>
@endif
@if(auth()->user()->hasPermissionTo('view customers'))
<li class="nav-item">
    <a href="{{ route('customers.index') }}"
       class="nav-link {{ Request::is('customers*') ? 'activeNav' : '' }}">
       <i class="fas fa-address-card right"></i> <p>Customers</p>
    </a>
</li>
@endif
@if(auth()->user()->hasPermissionTo('view contacts'))
<li class="nav-item">
    <a href="{{ route('contacts.index') }}"
       class="nav-link {{ Request::is('contacts*') ? 'activeNav' : '' }}">
       <i class="fas fa-id-badge right"></i> <p>Contacts</p>
    </a>
</li>
@endif
@if(auth()->user()->hasPermissionTo('view workshops'))
<li class="nav-item">
    <a href="{{ route('vendors.index') }}"
       class="nav-link {{ Request::is('vendors*') ? 'activeNav' : '' }}">
       <i class="fas fa-warehouse right"></i> <p>Workshops</p>
    </a>
</li>
@endif
@if(auth()->user()->hasPermissionTo('view units'))
<li class="nav-item">
    <a href="{{ route('units.index') }}"
       class="nav-link {{ Request::is('units*') ? 'activeNav' : '' }}">
       <i class="fas fa-train right"></i><p>Units</p>
    </a>
</li>
@endif
<hr>
@if(auth()->user()->hasPermissionTo('view agreements'))
<li class="nav-item">
    <a href="{{ route('rents.index') }}"
       class="nav-link {{ Request::is('rents*') ? 'activeNav' : '' }}">
       <i class="fas fa-file-contract right"></i><p>Agreements</p>
    </a>
</li>
@endif
@if(auth()->user()->hasPermissionTo('view parts'))
<li class="nav-item">
    <a href="{{ route('inventories.index') }}"
       class="nav-link {{ Request::is('inventories*') ? 'activeNav' : '' }}">
       <i class="fas fa-cogs right"></i><p>Parts</p>
    </a>
</li>
@endif
@if(auth()->user()->hasPermissionTo('view services'))
<li class="nav-item">
    <a href="{{ route('services.index') }}"
       class="nav-link {{ Request::is('services*') ? 'activeNav' : '' }}">
       <i class="fas fa-tools right"></i> <p>Service log</p>
    </a>
</li>
@endif

@if(auth()->user()->hasPermissionTo('view serviceplan'))
<li class="nav-item">
    <a href="{{ route('makeLists.index') }}"
       class="nav-link {{ Request::is('makeLists*') ? 'activeNav' : '' }}">
        <i class="fas fa-calendar right"></i><p>Service plan</p>
    </a>
</li>
<hr>
@endif


@if(auth()->user()->hasPermissionTo('view activities'))
<li class="nav-item">
    <a href="{{ route('activities.index') }}"
       class="nav-link {{ Request::is('activities*') ? 'activeNav' : '' }}">
        <i class="fas fa-bell right"></i><p>Activity log</p>
    </a>
</li>
@endif

