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
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="#">Admin</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
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