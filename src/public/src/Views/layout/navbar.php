<nav class="navbar navbar-expand-xl sticky-top shadow w-100">
  <div class="container-fluid">

    <a class="navbar-brand d-none d-xl-block" id="sidebarCollapse" href="javascript:void(0)">
      <i class="fa fa-bars pr-2"></i>
      <span class="font-weight-bold"><?php echo $system_name  ?></span>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu">
      <i class="fas fa-bars pr-2"></i>
      <span class="font-weight-bold"><?php echo $system_name ?></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar-menu">

      <ul class="navbar-nav ml-3 d-xl-none">
        <li class=" nav-item">
          <a class="nav-link" href="/home">
            <i class="fa fa-home pr-2"></i>
            <span class="font-weight-bold">รายงาน</span>
          </a>
        </li>
        <li class=" nav-item dropdown">
          <a class="nav-link" href="javascript:void(0)" data-toggle="dropdown">
            <i class="fa fa-list pr-2"></i>
            <span class="font-weight-bold">ข้อมูลส่วนตัว</span>
            <i class="fas fa-caret-down pl-2"></i>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="/user/profile">
              <i class="fa fa-address-book pr-2"></i>
              <span class="font-weight-bold">รายละเอียด</span>
            </a>
            <a class="dropdown-item" href="/user/change">
              <i class="fa fa-key pr-2"></i>
              <span class="font-weight-bold">เปลี่ยนรหัสผ่าน</span>
            </a>
          </div>
        </li>
        <li class=" nav-item dropdown">
          <a class="nav-link" href="javascript:void(0)" data-toggle="dropdown">
            <i class="fa fa-list pr-2"></i>
            <span class="font-weight-bold">บริการ</span>
            <i class="fas fa-caret-down pl-2"></i>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="/visit">
              <i class="fa fa-bars pr-2"></i>
              <span class="font-weight-bold">Visit</span>
            </a>
          </div>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto d-none d-xl-block">
        <li class="nav-item dropdown">
          <a class="nav-link" href="javascript:void(0)" data-toggle="dropdown">
            <span class="font-weight-bold"><?php echo $firstname ?></span>
            <i class="fas fa-caret-down pl-3"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="/user/profile">
              <i class="fa fa-address-book pr-2"></i>
              <span class="font-weight-bold">รายละเอียด</span>
            </a>
            <a class="dropdown-item" href="/user/change">
              <i class="fa fa-key pr-2"></i>
              <span class="font-weight-bold">เปลี่ยนรหัสผ่าน</span>
            </a>
            <a class="dropdown-item logout-btn" href="javascript:void(0)">
              <i class="fa fa-sign-out pr-2"></i>
              <span class="font-weight-bold">ออกจากระบบ</span>
            </a>
          </div>
        </li>
      </ul>

    </div>
  </div>
</nav>