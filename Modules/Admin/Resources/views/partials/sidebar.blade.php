<aside class="main-sidebar">
    <header class="main-header clearfix">
        <span class="logo" href="#">
            <span class="logo-lg">{{ $currentUser->firstRoles() }} Dashboard</span>
        </soa>

        <a href="javascript:void(0);" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <i aria-hidden="true" class="fa fa-bars"></i>
        </a>
    </header>

    <section class="sidebar">
        {!! $sidebar !!}
    </section>
</aside>
