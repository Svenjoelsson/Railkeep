<aside class="main-sidebar sidebar-light-primary ">
    <a href="{{ url('/') }}" class="brand-link solidRK navbar-dark">
        <span class="brand-text font-weight-light" style="color:white;">{{ config('app.name') }}</span><span class="font-weight-light" style="font-size:10px; color:white;"> {{ env('APP_ENV') }}</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>
</aside>
