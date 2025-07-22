<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
            <img src="{{ asset('assets/img/logo-ct-dark.png') }}" class="navbar-brand-img" width="26" height="26" alt="main_logo">
            <span class="ms-1 text-sm text-dark">Pn Binjai</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active bg-gradient-dark text-white' : '' }} text-dark" href="{{ route('admin.dashboard') }}">
                    <i class="material-symbols-rounded opacity-5">dashboard</i>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.manajemen-pengguna.*') ? 'active bg-gradient-dark text-white' : '' }} text-dark" href="{{ route('admin.manajemen-pengguna.index') }}">
                    <i class="material-symbols-rounded opacity-5">account_circle</i>
                    <span class="nav-link-text ms-1">Manajemen Pengguna</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.manajemen-karyawan.*') ? 'active bg-gradient-dark text-white' : '' }} text-dark" href="{{ route('admin.manajemen-karyawan.index') }}">
                    <i class="material-symbols-rounded opacity-5">groups</i>
                    <span class="nav-link-text ms-1">Manajemen Karyawan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.manajemen-tugas.*') ? 'active bg-gradient-dark text-white' : '' }} text-dark" href="{{ route('admin.manajemen-tugas.index') }}">
                    <i class="material-symbols-rounded opacity-5">table_view</i>
                    <span class="nav-link-text ms-1">Manajemen Tugas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="#">
                    <i class="material-symbols-rounded opacity-5">table_view</i>
                    <span class="nav-link-text ms-1">Manajemen Laporan Kinerja</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="#">
                    <i class="material-symbols-rounded opacity-5">table_view</i>
                    <span class="nav-link-text ms-1">Manajemen Evaluasi Kinerja</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn bg-gradient-dark w-100">
                    <span class="d-sm-inline d-none">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>