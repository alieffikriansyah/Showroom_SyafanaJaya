<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-between align-items-center px-3">
        <a class="navbar-brand brand-logo d-none d-lg-block font-weight-bold text-white text-decoration-none" href="{{ route('home') }}" style="font-size: 1.15rem; letter-spacing: 0.5px;">
            <i class="typcn typcn-th-large mr-1"></i> Syafana Motor
        </a>
        <a class="navbar-brand brand-logo-mini d-lg-none font-weight-bold text-white text-decoration-none" href="{{ route('home') }}" style="font-size: 1.1rem;">
            <i class="typcn typcn-th-large"></i> SJM
        </a>
        <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-block" type="button" data-toggle="minimize">
            <span class="typcn typcn-th-menu text-white"></span>
        </button>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between px-3">
        <div class="d-flex align-items-center">
            <h4 class="mb-0 font-weight-bold d-none d-md-block text-dark" style="letter-spacing: -0.2px;">
                Syafana Jaya Motor
            </h4>
        </div>

        <ul class="navbar-nav navbar-nav-right d-flex align-items-center">
            <li class="nav-item d-flex align-items-center mr-2 mr-md-3">
                <div class="badge badge-pill badge-primary px-2 px-md-3 py-2 d-flex align-items-center" style="font-size: 0.8rem; font-weight: 600; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                    <i class="typcn typcn-user mr-1"></i>
                    <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                    <span class="d-sm-none">{{ Str::limit(Auth::user()->name, 8) }}</span>
                    &nbsp;<span class="opacity-75" style="opacity: 0.85;">(@if (Auth::user()->karyawan)Karyawan @elseif(Auth::user()->admin){{ Auth::user()->admin->role }}@else Admin @endif)</span>
                </div>
            </li>
            <li class="nav-item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <a class="btn btn-sm btn-outline-danger d-flex align-items-center px-2 px-md-3 py-1 font-weight-bold" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="border-radius: 20px; font-size: 0.78rem;">
                    <i class="typcn typcn-eject mr-1"></i>
                    <span class="d-none d-sm-inline">Logout</span>
                </a>
            </li>
            <li class="nav-item d-lg-none ml-2">
                <button class="navbar-toggler navbar-toggler-right p-0 border-0 bg-transparent align-self-center" type="button" data-toggle="offcanvas">
                    <span class="typcn typcn-th-menu" style="font-size: 1.5rem; color: #5a5a5a;"></span>
                </button>
            </li>
        </ul>
    </div>
</nav>
<!-- partial -->
{{-- <nav class="navbar-breadcrumb col-xl-12 col-12 d-flex flex-row p-0">
    <div class="navbar-links-wrapper d-flex align-items-stretch" style="opacity: 0">
        <div class="nav-link">
            <a href="javascript:;"><i class="typcn typcn-calendar-outline"></i></a>
        </div>
        <div class="nav-link">
            <a href="javascript:;"><i class="typcn typcn-mail"></i></a>
        </div>
        <div class="nav-link">
            <a href="javascript:;"><i class="typcn typcn-folder"></i></a>
        </div>
        <div class="nav-link">
            <a href="javascript:;"><i class="typcn typcn-document-text"></i></a>
        </div>
    </div> --}}
    {{-- <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item ml-0">
                <h4 class="mb-0">Dashboard</h4>
            </li>
            <li class="nav-item">
            <div class="d-flex align-items-baseline">
              <p class="mb-0">Home</p>
              <i class="typcn typcn-chevron-right"></i>
              <p class="mb-0">Main Dahboard</p>
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-search d-none d-md-block mr-0">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search..." aria-label="search" aria-describedby="search">
              <div class="input-group-prepend">
                <span class="input-group-text" id="search">
                  <i class="typcn typcn-zoom"></i>
                </span>
              </div>
            </div>
          </li>
        </ul>
    </div> --}}
{{-- </nav> --}}
