<div class="sidebar" id="sidebar" data-color="white" data-active-color="danger">
  <div class="logo d-flex justify-content-between align-items-center">
    <a href="https://www.creative-tim.com" class="simple-text logo-mini">
      <div class="logo-image-small">
        {{-- PERUBAHAN DI SINI --}}
        {{-- Mengarah ke public/images/logo.png --}}
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
      </div>
    </a>
    <a href="https://www.creative-tim.com" class="simple-text logo-normal">
      Inventory
    </a>
    {{-- TOMBOL TUTUP SIDEBAR --}}
    <a href="javascript:void(0)" class="simple-text logo-normal mr-3" id="closeSidebarBtn" title="Tutup Sidebar">
      <i class="nc-icon nc-minimal-left"></i>
    </a>
  </div>

  <div class="sidebar-wrapper">
    <ul class="nav">
      {{-- Dashboard --}}
      <li class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
        <a href="{{ route('dashboard.index') }}">
          <i class="nc-icon nc-bank"></i>
          <p>Dashboard</p>
        </a>
      </li>

      {{-- Data Ibu Hamil --}}
      <li class="{{ request()->routeIs('ibuHamil.index') ? 'active' : '' }}">
        <a href="{{ route('ibuHamil.index') }}">
          <i class="nc-icon nc-app"></i>
          <p>Data Ibu Hamil</p>
        </a>
      </li>

      {{-- Data ODGJ --}}
      <li class="{{ request()->routeIs('odgj.index') ? 'active' : '' }}">
        <a href="{{ route('odgj.index') }}">
          <i class="nc-icon nc-badge"></i>
          <p>Data ODGJ</p>
        </a>
      </li>

      {{-- Data Hipertensi --}}
      <li class="{{ request()->routeIs('hipertensi.index') ? 'active' : '' }}">
        <a href="{{ route('hipertensi.index') }}">
          <i class="nc-icon nc-share-66"></i>
          <p>Data Hipertensi</p>
        </a>
      </li>

      {{-- Data Balita --}}
      <li class="{{ request()->routeIs('balita.index') ? 'active' : '' }}">
        <a href="{{ route('balita.index') }}">
          <i class="nc-icon nc-satisfied"></i>
          <p>Data Balita</p>
        </a>
      </li>

      {{-- Data Lansia --}}
      <li class="{{ request()->routeIs('lansia.index') ? 'active' : '' }}">
        <a href="{{ route('lansia.index') }}">
          <i class="nc-icon nc-tap-01"></i>
          <p>Data Lansia</p>
        </a>
      </li>
      @if(auth()->user()->role == 'admin')
      <li class="{{ request()->is('petugas') ? 'active' : '' }}">
        <a href="{{ route('petugas.index') }}">
          <i class="nc-icon nc-settings-gear-65"></i>
          <p>Kelola Petugas</p>
        </a>
      </li>
      @endif

      {{-- MENU DROPDOWN LAPORAN --}}
      <li class="{{ request()->is('laporan*') ? 'active' : '' }}">
        <a data-toggle="collapse" href="#laporanCollapse" aria-expanded="{{ request()->is('laporan*') ? 'true' : 'false' }}">
          <i class="nc-icon nc-single-copy-04"></i>
          <p>
            Laporan <b class="caret"></b>
          </p>
        </a>

        <div class="collapse {{ request()->is('laporan*') ? 'show' : '' }}" id="laporanCollapse">
          <ul class="nav sub-menu">
            <li class="{{ request()->routeIs('laporan.ibuHamil') ? 'active' : '' }}">
              <a href="{{ route('laporan.ibuHamil') }}">
                <span class="sidebar-mini-icon">IH</span>
                <span class="sidebar-normal"> Lap. Ibu Hamil </span>
              </a>
            </li>
            <li class="{{ request()->routeIs('laporan.odgj') ? 'active' : '' }}">
              <a href="{{ route('laporan.odgj') }}">
                <span class="sidebar-mini-icon">OD</span>
                <span class="sidebar-normal"> Lap. ODGJ </span>
              </a>
            </li>
            <li class="{{ request()->routeIs('laporan.hipertensi') ? 'active' : '' }}">
              <a href="{{ route('laporan.hipertensi') }}">
                <span class="sidebar-mini-icon">HP</span>
                <span class="sidebar-normal"> Lap. Hipertensi </span>
              </a>
            </li>
            <li class="{{ request()->routeIs('laporan.balita') ? 'active' : '' }}">
              <a href="{{ route('laporan.balita') }}">
                <span class="sidebar-mini-icon">BA</span>
                <span class="sidebar-normal"> Lap. Balita </span>
              </a>
            </li>
            <li class="{{ request()->routeIs('laporan.lansia') ? 'active' : '' }}">
              <a href="{{ route('laporan.lansia') }}">
                <span class="sidebar-mini-icon">LA</span>
                <span class="sidebar-normal"> Lap. Lansia </span>
              </a>
            </li>

          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>

{{-- JAVASCRIPT UNTUK TOGGLE CLASS --}}
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const closeBtn = document.getElementById('closeSidebarBtn');

    if (closeBtn) {
      closeBtn.addEventListener('click', function() {
        // Menambah/menghapus class 'sidebar-closed' pada body
        document.body.classList.toggle('sidebar-closed');
      });
    }
  });
</script>

{{-- STYLE CSS UNTUK SIDEBAR DAN MINI SIDEBAR --}}
<style>
  /* =========================================
       TRANSISI DASAR
       ========================================= */
  #sidebar,
  .main-panel,
  .sidebar .logo,
  .sidebar .sidebar-wrapper {
    transition: all 0.3s ease-in-out;
    z-index: 1000;
  }

  /* Warna Background Sidebar */
  #sidebar {
    background: #2c3e50 !important;
  }

  /* Styling Link Aktif */
  .sidebar .nav li.active>a {
    color: #aed9e8ff !important;
  }

  .sidebar .nav li.active>a i {
    color: #ADD8E6 !important;
  }

  /* Styling Sub-menu */
  .sub-menu {
    padding-left: 25px;
    background-color: rgba(0, 0, 0, 0.1);
  }

  .sub-menu li a .sidebar-normal {
    font-size: 13px;
    margin-left: 5px;
  }

  .sub-menu li a .sidebar-mini-icon {
    float: left;
    width: 30px;
    text-align: center;
    font-weight: bold;
    font-size: 12px;
  }

  .caret {
    float: right;
    margin-top: 7px;
  }

  /* Tombol Close Hover Effect */
  #closeSidebarBtn {
    cursor: pointer;
    opacity: 0.7;
  }

  #closeSidebarBtn:hover {
    opacity: 1;
    color: #ff6b6b;
  }

  /* =========================================
       LOGIKA MINI SIDEBAR (SAAT DITUTUP)
       ========================================= */

  /* 1. Kecilkan ukuran Sidebar */
  body.sidebar-closed .sidebar {
    width: 80px !important;
    /* Lebar hanya cukup untuk ikon */
    transform: none !important;
    /* Jangan sembunyikan ke luar layar */
    overflow: hidden;
    /* Sembunyikan teks yang panjang */
  }

  /* 2. Lebarkan Main Panel menyesuaikan sisa layar */
  body.sidebar-closed .main-panel {
    width: calc(100% - 80px) !important;
  }

  /* 3. Sembunyikan Teks Menu & Elemen Lain */
  body.sidebar-closed .sidebar .nav p,
  body.sidebar-closed .sidebar .nav .caret,
  body.sidebar-closed .sidebar .logo .logo-normal,
  body.sidebar-closed .sidebar .logo #closeSidebarBtn {
    display: none !important;
    opacity: 0;
  }

  /* 4. Atur Posisi Ikon agar di tengah */
  body.sidebar-closed .sidebar .nav i {
    float: none !important;
    display: block;
    text-align: center;
    margin-right: 0 !important;
    font-size: 24px;
    /* Perbesar sedikit ikonnya */
  }

  body.sidebar-closed .sidebar .nav li>a {
    text-align: center;
    padding: 10px 0;
  }

  /* 5. Atur Logo agar pas di tengah */
  body.sidebar-closed .sidebar .logo {
    display: flex;
    justify-content: center;
    padding-left: 0 !important;
  }

  body.sidebar-closed .sidebar .logo .simple-text.logo-mini {
    margin-right: 0 !important;
    margin-left: 0 !important;
  }

  /* 6. Efek Hover: Sidebar membesar kembali saat mouse di atasnya (Opsional) */
  body.sidebar-closed .sidebar:hover {
    width: 260px !important;
  }

  /* Tampilkan kembali elemen saat di-hover */
  body.sidebar-closed .sidebar:hover .nav p,
  body.sidebar-closed .sidebar:hover .logo .logo-normal {
    display: block !important;
    opacity: 1;
    transition: opacity 0.4s;
  }
</style>