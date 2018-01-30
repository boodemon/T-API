<div class="sidebar">
      <nav class="sidebar-nav">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="index.html"><i class="icon-speedometer"></i> Dashboard <span class="badge badge-primary">NEW</span></a>
          </li>

          <li class="nav-title">
            UI Elements
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('order') }}"><i class="icon-note"></i> รายการสั่งซื้อ</a>
        </li>

        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-folder-alt"></i> รายการอาหาร</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('foods/category') }}"><i class="icon-arrow-right"></i> หมวดอาหาร</a>
            </li>
            <li class="nav-item">
              <a class="nav-link"  href="{{ url('foods/restourant') }}" ><i class="icon-arrow-right"></i> ร้านค้าสมาชิก</a>
            </li>
            <li class="nav-item">
              <a class="nav-link"  href="{{ url('foods/food') }}"><i class="icon-arrow-right"></i> รายการอาหาร</a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link"  href="{{ url('payment') }}"><i class="icon-wallet"></i> ช่องทางชำระเงิน</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"  href="{{ url('report') }}"><i class="icon-doc"></i> รายงานการขาย</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"  href="{{ url('member') }}"><i class="icon-people"></i> ข้อมูลสมาชิก</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('user') }}"><i class="icon-user"></i> ผู้ดูแลระบบ</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"  href="{{ url('logout') }}"><i class="icon-logout"></i> ออกจากระบบ</a>
        </li>        </ul>
      </nav>
      <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>