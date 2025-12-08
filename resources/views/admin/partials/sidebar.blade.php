@php $active = collect(explode('/', url()->current()))->last(); @endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a class="app-brand-link" href="{{ url('/dashboard') }}"><img
        src="{{ asset('assets/img/logo.svg') }}" alt="" height="40"></a>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Dashboard -->
      <li class="menu-item {{ @$active == 'dashboard' ? 'active' : '' }}">
        <a href="{{ url('dashboard') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div data-i18n="Analytics">Dashboard</div>
        </a>
      </li>

      <!-- Layouts -->
      <li class="menu-item {{ @$active == 'categories' ? 'active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-collection"></i>
          <div data-i18n="Trip Categories">Trip Categories</div>
        </a>

        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{ url('admin/categories') }}" class="menu-link">
              <div data-i18n="All Categories">Categories</div>
            </a>
          </li>

          <li class="menu-item">
            <a href="{{ url('admin/sub-categories') }}" class="menu-link">
              <div data-i18n="Sub Categories">Sub Categories</div>
            </a>
          </li>

        </ul>
      </li>

      <!-- Layouts -->
      <li class="menu-item {{ @$active == 'packages' ? 'active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-crown"></i>
          <div data-i18n="Packages">Packages</div>
        </a>

        <ul class="menu-sub">

          <li class="menu-item">
            <a href="{{ url('admin/packages') }}" class="menu-link">
              <div data-i18n="All Packages">All Packages</div>
            </a>
          </li>

          @foreach(\App\Enums\CategoryType::getValues() as $item)
          <li class="menu-item">
            <a href="{{ url('admin/packages/?type='.$item) }}" class="menu-link">
              <div data-i18n="{{ucfirst(strtolower($item))}}">{{ucfirst(strtolower($item))}}</div>
            </a>
          </li>
          @endforeach
        </ul>
      </li>

      <li class="menu-item {{ @$active == 'customers' ? 'active' : '' }}">
        <a href="icons-boxicons.html" class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Customers">Customers</div>
        </a>
      </li>

      <li class="menu-item {{ @$active == 'bookings' ? 'active' : '' }}">
        <a href="icons-boxicons.html" class="menu-link">
          <i class="menu-icon tf-icons bx bx-box"></i>
          <div data-i18n="Bookings">Bookings</div>
        </a>
      </li>

      <li class="menu-item {{ @$active == 'guides' ? 'active' : '' }}">
        <a href="icons-boxicons.html" class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Guides">Guides</div>
        </a>
      </li>

      <li class="menu-item {{ @$active == 'settings' ? 'active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-cog"></i>
          <div data-i18n="Settings">Settings</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="pages-account-settings-account.html" class="menu-link">
              <div data-i18n="Account">Account</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="pages-account-settings-notifications.html" class="menu-link">
              <div data-i18n="Notifications">Notifications</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="pages-account-settings-connections.html" class="menu-link">
              <div data-i18n="Connections">Connections</div>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </aside>
  <!-- / Menu -->