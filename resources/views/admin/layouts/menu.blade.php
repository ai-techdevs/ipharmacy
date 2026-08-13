<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
      <li class="nav-item">
          <a href="{{route('admin.dashboard')}}" class="nav-link {{ Request::is('*dashboard*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-paperclip"></i>
              <p>Dashboard</p>
          </a>
      </li>
      @can('user.view')
      <li class="nav-item">
        <a href="{{route('admin.users.index')}}" class="nav-link {{ Request::is('*users*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>Users</p>
        </a>
      </li>
      @endcan
      @can('sub-admin.view')
      <li class="nav-item">
        <a href="{{route('admin.sub-admin.index')}}" class="nav-link {{ Request::is('*sub-admin*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-shield"></i>
            <p>Sub Admin</p>
        </a>
      </li>
      @endcan

      @can('roles.view')
      <li class="nav-item">
        <a href="{{route('admin.roles.index')}}" class="nav-link {{ Request::is('*roles*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>Roles</p>
        </a>
      </li>
      @endcan

      @can('medicines.view')
      <li class="nav-item">
        <a href="{{route('admin.medicines.index')}}" class="nav-link {{ Request::is('*medicines*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-capsules"></i>
            <p>Medicines</p>
        </a>
      </li>
      @endcan
      @can('cdcs.view')
      <li class="nav-item">
        <a href="{{route('admin.cdcs.index')}}" class="nav-link {{ Request::is('*cdcs*') && !Request::is('*temp-cdc-posts*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-blog"></i>
            <p>CDC</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('admin.temp-cdc-posts.index')}}" class="nav-link {{ Request::is('*temp-cdc-posts*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-download"></i>
            <p>Synced CDC Posts</p>
        </a>
      </li>
      @endcan

      @can('faqs.view')
      <li class="nav-item">
        <a href="{{route('admin.faqs.index')}}" class="nav-link {{ Request::is('*faqs*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-list"></i>
            <p>FAQs</p>
        </a>
      </li>
      @endcan


      @can('faqs.view')
      <li class="nav-item">
        <a href="{{route('admin.forums.index')}}" class="nav-link {{ Request::is('*forums*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-bullhorn"></i>
            <p>Forums</p>
        </a>
      </li>
      @endcan

      @can('clinical-trials')
      <li class="nav-item">
        <a href="{{route('admin.clinical-trials.index')}}" class="nav-link {{ Request::is('*clinical-trials*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-notes-medical"></i>
            <p>Clinical Trials</p>
        </a>
      </li>
      @endcan

      @can('working-partners.view')
      <li class="nav-item">
        <a href="{{route('admin.working-partners.index')}}" class="nav-link {{ Request::is('*working-partners*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-hand-holding-usd"></i>
            <p>Working Partner / Sponsors</p>
        </a>
      </li>
      @endcan


      @can('ask-doctor.view')
      <li class="nav-item">
        <a href="{{route('admin.ask-doctors.index')}}" class="nav-link {{ Request::is('*ask-doctors*') ? 'active' : '' }}">
           <i class="nav-icon fas fa-stethoscope"></i>
            <p>Ask Doctors</p>
        </a>
      </li>
      @endcan


        @can('settings.view')
      <li class="nav-item">
        <a href="{{route('admin.settings.index')}}" class="nav-link {{ Request::is('*settings*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-wrench"></i>
            <p>Settings</p>
        </a>
      </li>
      @endcan

         @can('donation.view')
      <li class="nav-item">
        <a href="{{route('admin.donation.index')}}" class="nav-link {{ Request::is('*donation*') ? 'active' : '' }}">
         <i class="nav-icon fas fa-donate"></i> 
            <p>Donation</p>
        </a>
      </li>
      @endcan

       @can('coupon.view')
      <li class="nav-item">
        <a href="{{route('admin.coupon.index')}}" class="nav-link {{ Request::is('*coupon*') ? 'active' : '' }}">
         <i class="nav-icon fas fa-ticket-alt"></i>
            <p>Coupons</p>
        </a>
      </li>
      @endcan
       @can('pages.view')
      <li class="nav-item">
        <a href="{{route('admin.pages.index')}}" class="nav-link {{ Request::is('*pages*') ? 'active' : '' }}">
       <i class="nav-icon fas fa-file-alt"></i>
            <p>Pages</p>
        </a>
      </li>
      @endcan
    </ul>
</nav>
  <!-- /.sidebar-menu -->







