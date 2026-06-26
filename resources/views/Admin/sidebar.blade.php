<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
      <div class="brand-text">
        <span class="name">Leeds<span>Institute</span></span>
        <span class="tagline">Excellence in Education</span>
      </div>
    </div>

    <ul class="sidebar-menu">
      <li class="menu-label">Main</li>
      <li class="active"><a href="{{ url('/dashboard') }}"><i class="fas fa-th-large"></i> Dashboard</a></li>
      <li><a href="{{ url('/admin/students') }}"><i class="fas fa-user-graduate"></i> Students</a></li>
      <li><a href="{{ url('/admin/teachers') }}"><i class="fas fa-chalkboard-teacher"></i> Teachers</a></li>
      <li><a href="{{ url('/admin/courses') }}"><i class="fas fa-book-open"></i> Courses</a></li>

      <li class="menu-label">Management</li>
      <li><a href="{{ url('/admin/enrollments') }}"><i class="fas fa-user-plus"></i> Enrollments</a></li>
      <li><a href="{{ url('/admin/fee-payments') }}"><i class="fas fa-dollar-sign"></i> Fee Payments</a></li>
      <li><a href="{{ url('/admin/student-cards') }}"><i class="fas fa-id-card"></i> Student Cards</a></li>
      <li><a href="{{ url('/admin/certificates') }}"><i class="fas fa-certificate"></i> Certificates</a></li>

      <li class="menu-label">Reports</li>
      <li><a href="{{ url('/admin/reports') }}"><i class="fas fa-chart-bar"></i> Reports</a></li>
      <li><a href="{{ url('/admin/enquiries') }}"><i class="fas fa-envelope"></i> Enquiries</a></li>

      <li class="menu-label">System</li>
      <li><a href="{{ url('/admin/settings') }}"><i class="fas fa-cog"></i> Settings</a></li>
    </ul>

    <div class="sidebar-footer">
      <div class="user-card" onclick="window.location.href='{{ url('/admin/profile') }}'">
        <div class="avatar">{{ substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1) }}</div>
        <div class="info">
          <div class="name">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</div>
          <div class="role">Super Admin</div>
        </div>
        <span class="badge">Online</span>
      </div>
    </div>
  </aside>
