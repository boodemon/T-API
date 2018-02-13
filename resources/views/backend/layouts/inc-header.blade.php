<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
      <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="nav navbar-nav d-md-down-none">
      <li class="nav-item px-3">
        <a class="nav-link" href="{{ url('dashboard') }}">Dashboard</a>
      </li>
      <li class="nav-item px-3">
        <a class="nav-link" href="{{ url('user') }}">Users</a>
      </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">
      <li class="nav-item d-md-down-none">
        <a class="nav-link" href="{{ url('order?status=new') }}"><i class="icon-bell"></i><span class="badge badge-pill badge-danger">0</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user fa-lg img-avatar"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="dropdown-header text-center">
            <strong>Account</strong>
          </div>
          <a class="dropdown-item" href="{{ url('user/profile') }}"><i class="fa fa-user"></i> Profile</a>
          <a class="dropdown-item" href="{{ url('logout') }}"><i class="fa fa-lock"></i> Logout</a>
        </div>
      </li>
    </ul>

  </header>