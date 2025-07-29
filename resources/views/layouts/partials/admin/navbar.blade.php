<nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
        {{ Breadcrumbs::render() }}
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 align-items-center justify-content-end" id="navbar">
            <ul class="navbar-nav d-flex align-items-center justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <button class="btn btn-outline-primary btn-sm mb-0 me-3">{{Auth::user()->role}}</button>
                </li>
            </ul>
        </div>
    </div>
</nav>