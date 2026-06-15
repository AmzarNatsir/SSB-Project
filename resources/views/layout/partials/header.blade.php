<!-- Topbar Start -->
<header class="navbar-header">
    <div class="page-container topbar-menu">
        <div class="d-flex align-items-center gap-2">

            <!-- Logo -->
            <a href="{{url('index')}}" class="logo">

                <!-- Logo Normal -->
                <span class="logo-light">
                    <span class="logo-lg"><img src="{{URL::asset('build/img/logo.svg')}}" alt="logo"></span>
                    <span class="logo-sm"><img src="{{URL::asset('build/img/logo-small.svg')}}" alt="small logo"></span>
                </span>

                <!-- Logo Dark -->
                <span class="logo-dark">
                    <span class="logo-lg"><img src="{{URL::asset('build/img/logo-white.svg')}}" alt="dark logo"></span>
                </span>
            </a>

            <!-- Sidebar Mobile Button -->
            <a id="mobile_btn" class="mobile-btn" href="#sidebar">
                <i class="ti ti-menu-deep fs-24"></i>
            </a>

            @if (!Route::is(['layout-hidden']))
                <button class="sidenav-toggle-btn btn border-0 p-0" id="toggle_btn2">
                    <i class="ti ti-arrow-bar-to-right"></i>
                </button>
            @endif

            @if (Route::is(['layout-hidden']))
                <button class="sidenav-toggle-btn btn border-0 p-0" id="toggle_btn">
                    <i class="ti ti-arrow-bar-to-right"></i>
                </button>
            @endif

            <!-- Search -->
            <div class="me-auto d-flex align-items-center header-search d-lg-flex d-none">
                <!-- Search -->
                <div class="input-icon position-relative me-2">
                    <input type="text" class="form-control" placeholder="Search Keyword">
                    <span class="input-icon-addon d-inline-flex p-0 header-search-icon"><i
                            class="ti ti-command"></i></span>
                </div>
                <!-- /Search -->
            </div>

        </div>

        <div class="d-flex align-items-center">

            <!-- Search for Mobile -->
            <div class="header-item d-flex d-lg-none me-2">
                <button class="topbar-link btn" data-bs-toggle="modal" data-bs-target="#searchModal" type="button">
                    <i class="ti ti-search fs-16"></i>
                </button>
            </div>


            <!-- Minimize -->
            <div class="header-item">
                <div class="dropdown me-2">
                    <a href="javascript:void(0);" class="btn topbar-link btnFullscreen"><i
                            class="ti ti-maximize"></i></a>
                </div>
            </div>
            <!-- Minimize -->

            @if (!Route::is(['layout-mini', 'layout-hoverview', 'layout-hidden', 'layout-fullwidth', 'layout-rtl', 'layout-dark']))
                <!-- Light/Dark Mode Button -->
                <div class="header-item d-none d-sm-flex me-2">
                    <button class="topbar-link btn topbar-link" id="light-dark-mode" type="button">
                        <i class="ti ti-moon fs-16"></i>
                    </button>
                </div>
            @endif

            <!-- pages -->

            <div class="header-line"></div>
            <!-- User Dropdown -->
            <div class="dropdown profile-dropdown d-flex align-items-center justify-content-center">
                <a href="javascript:void(0);" class="topbar-link dropdown-toggle drop-arrow-none position-relative"
                    data-bs-toggle="dropdown" data-bs-offset="0,22" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ \App\Helpers\MediaHelper::getUserPhotoUrl(auth()->user()->employee_id) }}" width="38" class="rounded-1 d-flex"
                        alt="user-image" onerror="this.src='{{URL::asset('build/img/users/user-40.jpg')}}'">
                    <span class="online text-success"><i
                            class="ti ti-circle-filled d-flex bg-white rounded-circle border border-1 border-white"></i></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-2">

                    <div class="d-flex align-items-center bg-light rounded-3 p-2 mb-2">
                        <img src="{{ \App\Helpers\MediaHelper::getUserPhotoUrl(auth()->user()->employee_id) }}" class="rounded-circle" width="42"
                            height="42" alt="" onerror="this.src='{{URL::asset('build/img/users/user-40.jpg')}}'">
                        <div class="ms-2">
                            <p class="fw-medium text-dark mb-0">{{ auth()->user()->name }}</p>
                            <span class="d-block fs-13">{{ auth()->user()->roles->first()->name ?? '-' }}</span>
                        </div>
                    </div>
                    <!-- Item-->
                    <div class="pt-2 mt-2 border-top">
                        <a href="javascript:void(0);" class="dropdown-item text-danger"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ti ti-logout me-1 fs-17 align-middle"></i>
                            <span class="align-middle">Sign Out</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>
<!-- Topbar End -->
