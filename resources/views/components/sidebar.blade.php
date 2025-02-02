{{-- Cek login if not login header hilang --}}
@if(auth()->user() != null)
<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html"> {{ config('app.name') }} </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.html"> {{ config('app.name_init') }} </a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="nav-item dropdown {{ $type_menu === 'dashboard' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a>
      </li>
      {{-- Cek Akses --}}
      @if(auth()->user()->akses == 'admin' || auth()->user()->akses == 'yayasan')
        <li class="menu-header">Pendataan</li>
        <li class="nav-item dropdown {{ $type_menu === 'data_santri' ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('pendataan/santri') }}"><i class="fas fa-child"></i><span>Santri</span></a>
        </li>
        <li class="nav-item dropdown {{ $type_menu === 'data_alumni' ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('pendataan/alumni') }}"><i class="fas fa-male"></i><span>Alumni</span></a>
        </li>
      @endif
      @if(auth()->user()->akses == 'admin')
        <li class="nav-item dropdown {{ $type_menu === 'data_kamar' ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('pendataan/kamar') }}"><i class="fas fa-bed"></i><span>Kamar</span></a>
        </li>
        <li class="nav-item dropdown {{ $type_menu === 'data_setting' ? 'active' : '' }}">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Setting Data</span></a>
          <ul class="dropdown-menu">
            <li class='{{ Request::is(' pendataan/setting/data') ? 'active' : '' }}'>
              <a class="nav-link" href="{{ url('pendataan/setting/data') }}">Data Induk</a>
            </li>
          </ul>
        </li>
        <li class="menu-header">Akademik</li>
        <li class="nav-item dropdown {{ $type_menu === 'data_kelas' ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('akademik/kelas') }}"><i class="fas fa-university"></i><span>Kelas</span></a>
        </li>
        <li class="nav-item dropdown {{ $type_menu === 'data_mapel' ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('akademik/mapel') }}"><i class="fas fa-book"></i><span> Mata
              Pelajaran</span></a>
        </li>
        <li class="nav-item dropdown {{ $type_menu === 'data_jadwal' ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('akademik/jadwal') }}"><i class="fas fa-calendar"></i><span>Jadwal</span></a>
        </li>
        <li class="nav-item dropdown {{ $type_menu === 'data_pengajar' ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('akademik/pengajar') }}"><i class="fas fa-user"></i><span>Pengajar</span></a>
        </li>
        <li class="nav-item dropdown {{ $type_menu === 'data_presensi' ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('akademik/presensi') }}"><i class="fas fa-archive"></i><span>Rekap
              Perijinan</span></a>
        </li>
        <li class="nav-item dropdown {{ $type_menu === 'data_nilai' ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('akademik/nilai') }}"><i
              class="fas fa-graduation-cap"></i><span>Nilai</span></a>
        </li>
        <li class="menu-header">Super Admin</li>
        <li class="nav-item dropdown {{ $type_menu === 'user_list' ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('user') }}"><i class="fas fa-users"></i><span> Pengguna </span></a>
        </li>
      @endif
      @if(auth()->user()->akses == 'santri')
        <li class="menu-header">Akademik</li>
        <li class="nav-item dropdown {{ $type_menu === 'data_jadwal' ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('jadwal') }}"><i class="fas fa-book"></i><span>Jadwal</span></a>
        </li>
        <li class="nav-item dropdown {{ $type_menu === 'data_nilai' ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('nilai') }}"><i class="fas fa-users"></i><span> Raport </span></a>
        </li>
      @endif
    </ul>
  </aside>
</div>
@endif