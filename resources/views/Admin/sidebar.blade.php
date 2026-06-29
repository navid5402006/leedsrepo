{{-- resources/views/partials/sidebar.blade.php --}}
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
        <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
            <a href="{{ url('/dashboard') }}"><i class="fas fa-th-large"></i> Dashboard</a>
        </li>
        <li class="{{ request()->is('admin/students*') ? 'active' : '' }}">
            <a href="{{ url('/admin/students') }}"><i class="fas fa-user-graduate"></i> Students</a>
        </li>
        <li class="{{ request()->is('admin/teachers*') ? 'active' : '' }}">
            <a href="{{ url('/admin/teachers') }}"><i class="fas fa-chalkboard-teacher"></i> Teachers</a>
        </li>
        <li class="{{ request()->is('admin/courses*') ? 'active' : '' }}">
            <a href="{{ url('/admin/courses') }}"><i class="fas fa-book-open"></i> Courses</a>
        </li>

        <li class="menu-label">Management</li>
        <li class="{{ request()->is('admin/enrollments*') ? 'active' : '' }}">
            <a href="{{ url('/admin/enrollments') }}"><i class="fas fa-user-plus"></i> Enrollments</a>
        </li>
        <li class="{{ request()->is('admin/fee-payments*') ? 'active' : '' }}">
            <a href="{{ url('/admin/fee-payments') }}"><i class="fas fa-dollar-sign"></i> Fee Payments</a>
        </li>
        <li class="{{ request()->is('admin/student-cards*') ? 'active' : '' }}">
            <a href="{{ url('/admin/student-cards') }}"><i class="fas fa-id-card"></i> Student Cards</a>
        </li>
        <li class="{{ request()->is('admin/certificates*') ? 'active' : '' }}">
            <a href="{{ url('/admin/certificates') }}"><i class="fas fa-certificate"></i> Certificates</a>
        </li>
        <li class="{{ request()->is('admin/talent-test*') ? 'active' : '' }}">
            <a href="{{ url('/admin/talent-test') }}"><i class="fas fa-clipboard-list"></i> Talent Test</a>
        </li>

        <li class="menu-label">Reports</li>
        <li class="{{ request()->is('admin/reports*') ? 'active' : '' }}">
            <a href="{{ url('/admin/reports') }}"><i class="fas fa-chart-bar"></i> Reports</a>
        </li>
        <li class="{{ request()->is('admin/enquiries*') ? 'active' : '' }}">
            <a href="{{ url('/admin/enquiries') }}"><i class="fas fa-envelope"></i> Enquiries</a>
        </li>

        <li class="menu-label">Website</li>
        <li class="{{ request()->is('admin/gallery*') ? 'active' : '' }}">
            <a href="{{ url('/admin/gallery') }}"><i class="fas fa-images"></i> Gallery</a>
        </li>

        <li class="menu-label">System</li>
        <li class="{{ request()->is('admin/settings*') ? 'active' : '' }}">
            <a href="{{ url('/admin/settings') }}"><i class="fas fa-cog"></i> Settings</a>
        </li>
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


<style>
/* ─── Premium Sidebar with Leeds Colors (Red & Yellow Dominant) ─── */
.sidebar {
    width: 280px;
    background: linear-gradient(180deg, #0A1628 0%, #1A2A4A 100%);
    color: #fff;
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
    padding: 24px 18px 30px;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 50;
    box-shadow: 4px 0 30px rgba(0,0,0,0.15);
}
.sidebar::-webkit-scrollbar { width: 4px; }
.sidebar::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); }
.sidebar::-webkit-scrollbar-thumb { background: #FFC107; border-radius: 10px; }

.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 40px;
    padding: 4px 6px;
    position: relative;
}
.sidebar-brand .logo-icon {
    background: linear-gradient(135deg, #E53935, #FFC107, #E53935);
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: #fff;
    box-shadow: 0 4px 20px rgba(229,57,53,0.4);
    transition: all 0.3s;
    border: 2px solid rgba(255,193,7,0.3);
}
.sidebar-brand .logo-icon:hover {
    transform: scale(1.05) rotate(-5deg);
    box-shadow: 0 8px 30px rgba(229,57,53,0.5);
    border-color: #FFC107;
}
.sidebar-brand .brand-text .name {
    font-weight: 800;
    font-size: 22px;
    letter-spacing: -0.5px;
    color: #fff;
    text-shadow: 0 2px 10px rgba(255,193,7,0.1);
}
.sidebar-brand .brand-text .name span {
    color: #FFC107;
    position: relative;
    text-shadow: 0 0 30px rgba(255,193,7,0.3);
}
.sidebar-brand .brand-text .name span::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #E53935, #FFC107, #E53935);
    border-radius: 2px;
}
.sidebar-brand .brand-text .tagline {
    font-size: 10px;
    font-weight: 500;
    color: rgba(255,193,7,0.6);
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-top: 2px;
}

.sidebar-menu {
    list-style: none;
    flex: 1;
    margin-top: 8px;
}
.sidebar-menu .menu-label {
    font-size: 11px;
    font-weight: 600;
    color: rgba(255,193,7,0.4);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    padding: 16px 12px 8px;
    position: relative;
}
.sidebar-menu .menu-label::before {
    content: '';
    position: absolute;
    left: 12px;
    bottom: 0;
    width: 30px;
    height: 2px;
    background: linear-gradient(90deg, #FFC107, #E53935);
    border-radius: 2px;
}
.sidebar-menu li { margin-bottom: 2px; }
.sidebar-menu li a {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 11px 16px;
    border-radius: 12px;
    color: rgba(255,255,255,0.65);
    font-weight: 500;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.25s;
    position: relative;
}
.sidebar-menu li a i {
    width: 20px;
    font-size: 16px;
    text-align: center;
    color: rgba(255,255,255,0.35);
    transition: color 0.3s;
}
.sidebar-menu li a:hover {
    background: rgba(255,193,7,0.1);
    color: #FFC107;
    transform: translateX(4px);
}
.sidebar-menu li a:hover i { 
    color: #E53935; 
}
.sidebar-menu li.active a {
    background: rgba(255,193,7,0.15);
    color: #FFC107;
    font-weight: 600;
    border-left: 4px solid #E53935;
    box-shadow: inset 0 0 20px rgba(229,57,53,0.05);
}
.sidebar-menu li.active a i { 
    color: #E53935;
    text-shadow: 0 0 20px rgba(229,57,53,0.3);
}
.sidebar-menu li.active a::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 30px;
    background: linear-gradient(180deg, #E53935, #FFC107);
    border-radius: 0 3px 3px 0;
}

/* ─── Hover state with red/yellow glow ─── */
.sidebar-menu li a:hover {
    background: rgba(255,193,7,0.08);
    color: #FFC107;
    box-shadow: 0 0 20px rgba(255,193,7,0.02);
}
.sidebar-menu li a:hover i {
    color: #E53935;
}

/* ─── Active state with red/yellow accent ─── */
.sidebar-menu li.active a {
    background: rgba(229,57,53,0.08);
    color: #FFC107;
    border-left: 4px solid #FFC107;
}
.sidebar-menu li.active a i { 
    color: #FFC107; 
}
.sidebar-menu li.active a::before {
    background: linear-gradient(180deg, #FFC107, #E53935);
}

/* ─── Menu label with red/yellow gradient ─── */
.sidebar-menu .menu-label {
    color: rgba(255,193,7,0.5);
}
.sidebar-menu .menu-label::before {
    background: linear-gradient(90deg, #E53935, #FFC107);
}

.sidebar-footer {
    border-top: 1px solid rgba(255,193,7,0.1);
    padding-top: 16px;
    margin-top: 8px;
}
.sidebar-footer .user-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 12px;
    background: rgba(255,193,7,0.04);
    transition: background 0.2s;
    cursor: pointer;
    border: 1px solid rgba(255,193,7,0.05);
}
.sidebar-footer .user-card:hover { 
    background: rgba(255,193,7,0.1);
    border: 1px solid rgba(255,193,7,0.2);
}
.sidebar-footer .user-card .avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, #E53935, #FFC107);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 17px;
    color: #fff;
    flex-shrink: 0;
    box-shadow: 0 2px 15px rgba(229,57,53,0.3);
}
.sidebar-footer .user-card .info .name {
    font-weight: 600;
    font-size: 14px;
    color: #fff;
}
.sidebar-footer .user-card .info .role {
    font-size: 12px;
    color: rgba(255,193,7,0.5);
}
.sidebar-footer .user-card .badge {
    background: #E53935;
    color: #fff;
    font-size: 9px;
    font-weight: 700;
    padding: 2px 10px;
    border-radius: 30px;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 10px rgba(229,57,53,0.3);
}

/* ─── Responsive Sidebar ─── */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        width: 270px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        z-index: 60;
    }
    .sidebar.open {
        transform: translateX(0);
    }
}
</style>