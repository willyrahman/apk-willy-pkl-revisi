<nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <div class="navbar-toggle">
        <button type="button" class="navbar-toggler" onclick="document.body.classList.toggle('sidebar-closed')">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </button>
      </div>

      {{-- LOGIKA DINAMIS UNTUK JUDUL NAVBAR --}}
      <a class="navbar-brand" href="javascript:;">
        @if(request()->routeIs('ibuHamil.*'))
        Data Ibu Hamil
        @elseif(request()->routeIs('lansia.*'))
        Data Lansia
        @elseif(request()->routeIs('odgj.*'))
        Data Pasien ODGJ
        @elseif(request()->routeIs('hipertensi.*'))
        Data Pasien Hipertensi
        @elseif(request()->routeIs('balita.*'))
        Data Balita
        @elseif(request()->routeIs('petugas.*'))
        Manajemen Petugas
        {{-- LOGIKA KHUSUS UNTUK SUB-MENU LAPORAN --}}
        @elseif(request()->routeIs('laporan.ibuHamil'))
        Laporan Ibu Hamil
        @elseif(request()->routeIs('laporan.odgj'))
        Laporan ODGJ
        @elseif(request()->routeIs('laporan.hipertensi'))
        Laporan Hipertensi
        @elseif(request()->routeIs('laporan.balita'))
        Laporan Balita
        @elseif(request()->routeIs('laporan.lansia'))
        Laporan Lansia
        @elseif(request()->routeIs('laporan.*'))
        Laporan Sistem
        @else
        Dashboard
        @endif
      </a>
    </div>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-bar navbar-kebab"></span>
      <span class="navbar-toggler-bar navbar-kebab"></span>
      <span class="navbar-toggler-bar navbar-kebab"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navigation">
      <form>
        <div class="input-group no-border">
          <input type="text" value="" class="form-control" placeholder="Search...">
          <div class="input-group-append">
            <div class="input-group-text">
              <i class="nc-icon nc-zoom-split"></i>
            </div>
          </div>
        </div>
      </form>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link btn-magnify" href="javascript:;">
            <i class="nc-icon nc-layout-11"></i>
            <p><span class="d-lg-none d-md-block">Stats</span></p>
          </a>
        </li>
        <li class="nav-item btn-rotate dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="nc-icon nc-bell-55"></i>
            <p><span class="d-lg-none d-md-block">Some Actions</span></p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link btn-rotate" href="javascript:;">
            <i class="nc-icon nc-single-02"></i>
            <p><span class="d-lg-none d-md-block">Account</span></p>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link btn-rotate text-danger" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="nc-icon nc-button-power"></i>
            <p><span class="d-lg-none d-md-block">Logout</span></p>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>