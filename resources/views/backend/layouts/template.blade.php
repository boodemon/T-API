<!DOCTYPE html>
<html lang="en">
<head>
@include('backend.layouts.inc-head')
@yield('stylesheet')
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
@include('backend.layouts.inc-header')
<div class="app-body">
    @include('backend.layouts.inc-sidebar')
    <!-- Main content -->
    <main class="main">
      <!-- Breadcrumb -->
      <ol class="breadcrumb">
        @if( $_breadcrumb != 'Dashboard' )
        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $_breadcrumb ? $_breadcrumb : '' }}</li>
        @else
        <li class="breadcrumb-item active">Dashboard</li>
        @endif
      </ol>

      <div class="container-fluid">
        <div class="animated fadeIn">
        @yield('content')
        </div>

      </div>
      <!-- /.conainer-fluid -->
    </main>
  </div>
@include('backend.layouts.inc-footer')
@yield('modal');
@yield('javascript')
</body>
</html>