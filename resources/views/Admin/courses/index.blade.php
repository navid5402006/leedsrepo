{{-- resources/views/admin/courses/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leeds Academy · Course Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #F5F7FA;
            color: #1E293B;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 280px;
            background: #071B3B;
            color: #fff;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            padding: 24px 18px 30px 18px;
            transition: transform 0.25s ease;
            z-index: 50;
            box-shadow: 4px 0 20px rgba(0,0,0,0.08);
        }
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
            padding-left: 6px;
        }
        .sidebar-brand .logo-icon {
            background: rgba(255,255,255,0.06);
            width: 42px; height: 42px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #6D4AFF;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .sidebar-brand span { font-weight: 700; font-size: 20px; letter-spacing: -0.3px; }
        .sidebar-brand span small { color: #6D4AFF; }
        .sidebar-menu { list-style: none; flex:1; }
        .sidebar-menu li { margin-bottom: 4px; }
        .sidebar-menu li a {
            display: flex; align-items: center; gap: 14px; padding: 12px 16px;
            border-radius: 12px; color: rgba(255,255,255,0.7); font-weight: 500;
            font-size: 15px; text-decoration: none; transition: all 0.15s;
        }
        .sidebar-menu li a i { width: 22px; font-size: 16px; text-align: center; color: rgba(255,255,255,0.5); transition: color 0.15s; }
        .sidebar-menu li a:hover { background: rgba(255,255,255,0.06); color: #fff; }
        .sidebar-menu li a:hover i { color: #fff; }
        .sidebar-menu li.active a {
            background: rgba(109,74,255,0.2);
            color: #fff;
            font-weight: 600;
        }
        .sidebar-menu li.active a i { color: #6D4AFF; }

        .main { flex:1; background: #F5F7FA; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar {
            background: #FFFFFF;
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            border-bottom: 1px solid #F1F5F9;
            position: sticky;
            top: 0;
            z-index: 40;
            box-shadow: 0 1px 4px rgba(0,0,0,0.02);
        }
        .topbar-left { display: flex; align-items: center; gap: 16px; }
        .topbar-left .menu-toggle {
            background: transparent; border: none; font-size: 20px; color: #1E293B;
            cursor: pointer; display: none; padding: 6px 8px; border-radius: 8px;
        }
        .topbar-left .menu-toggle:hover { background: #F1F5F9; }
        .topbar-left .breadcrumb { font-size: 14px; color: #64748B; }
        .topbar-left .breadcrumb span { color: #1E293B; font-weight: 500; }
        .topbar-left h2 { font-weight: 600; font-size: 22px; letter-spacing: -0.3px; color: #1E293B; margin-right: 8px; }
        .topbar-right { display: flex; align-items: center; gap: 18px; }
        .search-box {
            position: relative; background: #F5F7FA; border-radius: 30px;
            padding: 6px 14px 6px 40px; border: 1px solid transparent; transition: all 0.2s;
            display: flex; align-items: center; width: 220px;
        }
        .search-box:focus-within { border-color: #6D4AFF; background: #fff; box-shadow: 0 0 0 3px rgba(109,74,255,0.08); }
        .search-box i { position: absolute; left: 14px; color: #94A3B8; }
        .search-box input { background: transparent; border: none; padding: 8px 0; width: 100%; outline: none; font-size: 14px; font-family: 'Inter', sans-serif; }
        .notif-btn, .profile-btn {
            background: transparent; border: none; font-size: 20px; color: #475569;
            cursor: pointer; padding: 6px; border-radius: 30px; transition: background 0.15s; position: relative;
        }
        .notif-btn:hover, .profile-btn:hover { background: #F1F5F9; }
        .notif-badge {
            position: absolute; top: 2px; right: 2px; background: #6D4AFF; color: #fff;
            font-size: 10px; font-weight: 700; border-radius: 30px; width: 18px; height: 18px;
            display: flex; align-items: center; justify-content: center; border: 2px solid #fff;
        }
        .profile-dropdown-wrap { position: relative; }
        .profile-btn {
            display: flex; align-items: center; gap: 8px; padding: 4px 12px 4px 4px;
            border-radius: 40px; background: #F1F5F9;
        }
        .profile-btn img { width: 34px; height: 34px; border-radius: 50%; background: #6D4AFF; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600; }
        .profile-btn span { font-weight: 500; font-size: 14px; color: #1E293B; }
        .dropdown-menu {
            position: absolute; right: 0; top: 48px; background: #fff; border-radius: 16px;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.15); min-width: 210px; padding: 10px 0;
            opacity: 0; visibility: hidden; transform: translateY(8px); transition: all 0.18s ease;
            border: 1px solid #F1F5F9;
        }
        .dropdown-menu.open { opacity: 1; visibility: visible; transform: translateY(0); }
        .dropdown-menu a {
            display: flex; align-items: center; gap: 12px; padding: 10px 18px;
            color: #1E293B; text-decoration: none; font-size: 14px; font-weight: 500; transition: background 0.1s;
        }
        .dropdown-menu a:hover { background: #F8FAFC; }
        .dropdown-menu a i { width: 20px; color: #64748B; }
        .dropdown-divider { height: 1px; background: #F1F5F9; margin: 6px 12px; }

        .content { padding: 28px 32px 40px 32px; flex:1; }
        .page-header {
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;
        }
        .page-header h3 { font-size: 24px; font-weight: 600; color: #0F172A; }
        .btn-primary {
            background: #6D4AFF; border: none; padding: 10px 24px; border-radius: 40px;
            font-weight: 600; font-size: 14px; color: #fff; display: inline-flex; align-items: center; gap: 10px;
            cursor: pointer; transition: all 0.15s; box-shadow: 0 6px 14px -6px rgba(109,74,255,0.3);
            font-family: 'Inter', sans-serif;
        }
        .btn-primary:hover { background: #5a3de0; transform: translateY(-2px); box-shadow: 0 10px 20px -8px rgba(109,74,255,0.35); }
        .btn-primary:active { transform: scale(0.97); }
        .btn-outline {
            background: transparent; border: 1.5px solid #E2E8F0; padding: 8px 18px;
            border-radius: 40px; font-weight: 600; font-size: 13px; color: #475569;
            cursor: pointer; transition: 0.15s; font-family: 'Inter', sans-serif;
        }
        .btn-outline:hover { background: #F1F5F9; }
        .btn-success {
            background: #10B981; border: none; padding: 10px 24px; border-radius: 40px;
            font-weight: 600; font-size: 14px; color: #fff; display: inline-flex; align-items: center; gap: 8px;
            cursor: pointer; transition: 0.15s; font-family: 'Inter', sans-serif; box-shadow: 0 6px 14px -6px rgba(16,185,129,0.3);
        }
        .btn-success:hover { background: #0ea373; transform: translateY(-2px); }

        .filters-bar {
            display: flex; flex-wrap: wrap; align-items: center; gap: 14px;
            background: #fff; padding: 16px 20px; border-radius: 16px; border: 1px solid #F1F5F9;
            margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        .filters-bar select, .filters-bar input {
            padding: 8px 14px; border-radius: 30px; border: 1px solid #E2E8F0;
            background: #F8FAFC; font-size: 14px; font-family: 'Inter', sans-serif;
            color: #1E293B; outline: none; transition: 0.15s;
        }
        .filters-bar select:focus, .filters-bar input:focus {
            border-color: #6D4AFF; box-shadow: 0 0 0 3px rgba(109,74,255,0.08);
        }
        .btn-reset {
            background: transparent; border: 1px solid #E2E8F0; padding: 8px 18px;
            border-radius: 30px; font-weight: 500; font-size: 13px; color: #475569;
            cursor: pointer; transition: 0.15s;
        }
        .btn-reset:hover { background: #F1F5F9; }

        .table-card {
            background: #fff; border-radius: 16px; border: 1px solid #F1F5F9;
            padding: 20px 24px 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); overflow-x: auto;
        }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th { text-align: left; padding: 12px 8px 12px 0; font-weight: 600; color: #475569; border-bottom: 1px solid #F1F5F9; }
        td { padding: 14px 8px 14px 0; border-bottom: 1px solid #F1F5F9; color: #1E293B; vertical-align: middle; }
        td:last-child { padding-right:0; }
        tr:hover td { background: #F8FAFC; cursor: pointer; }
        .status-badge {
            font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 40px;
            background: #E6F7E6; color: #10B981;
        }
        .status-badge.inactive { background: #FEE2E2; color: #DC2626; }
        .status-badge.warning { background: #FEF3C7; color: #D97706; }
        .avatar-sm {
            width: 36px; height: 36px; border-radius: 30px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: 14px;
            color: #fff;
        }
        .avatar-sm.purple { background: #6D4AFF; }
        .avatar-sm.blue { background: #3B82F6; }
        .avatar-sm.green { background: #10B981; }
        .avatar-sm.orange { background: #F59E0B; }
        .action-dropdown { position: relative; display: inline-block; }
        .action-dropdown .dropdown-trigger {
            background: transparent; border: none; color: #94A3B8;
            padding: 6px 10px; border-radius: 30px; cursor: pointer; transition: 0.1s;
        }
        .action-dropdown .dropdown-trigger:hover { background: #F1F5F9; color:#1E293B; }
        .action-dropdown .dd-menu {
            position: absolute; right: 0; top: 30px; background: #fff;
            border-radius: 14px; box-shadow: 0 20px 40px -12px rgba(0,0,0,0.15);
            min-width: 190px; padding: 8px 0; border: 1px solid #F1F5F9;
            opacity: 0; visibility: hidden; transform: translateY(6px);
            transition: all 0.15s; z-index: 20;
        }
        .action-dropdown .dd-menu.open { opacity: 1; visibility: visible; transform: translateY(0); }
        .action-dropdown .dd-menu a {
            display: flex; align-items: center; gap: 10px; padding: 8px 18px;
            font-size: 13px; color: #1E293B; text-decoration: none; transition: 0.1s;
        }
        .action-dropdown .dd-menu a:hover { background: #F8FAFC; }
        .action-dropdown .dd-menu a i { width: 18px; color: #64748B; }

        .modal-overlay {
            position: fixed; inset: 0; background: rgba(15,23,42,0.55);
            backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center;
            z-index: 999; padding: 20px;
        }
        .modal-overlay.active { display: flex; }
        .modal {
            background: #fff; border-radius: 28px; max-width: 720px; width: 100%;
            max-height: 92vh; overflow-y: auto; padding: 32px 36px 36px;
            box-shadow: 0 40px 80px -20px rgba(0,0,0,0.3);
            animation: modalIn 0.25s ease;
        }
        @keyframes modalIn { from { opacity:0; transform: scale(0.96) translateY(20px); } to { opacity:1; transform: scale(1) translateY(0); } }
        .modal-header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;
        }
        .modal-header h2 { font-size: 22px; font-weight: 600; color: #0F172A; }
        .modal-close { background: transparent; border: none; font-size: 24px; color: #94A3B8; cursor: pointer; padding: 6px; }
        .modal-close:hover { color: #1E293B; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px 24px; }
        .form-group { display: flex; flex-direction: column; gap: 4px; }
        .form-group label { font-weight: 500; font-size: 14px; color: #334155; }
        .form-group label .optional { font-weight: 400; color: #94A3B8; font-size: 12px; }
        .form-group input, .form-group select, .form-group textarea {
            padding: 10px 14px; border-radius: 12px; border: 1.5px solid #E2E8F0;
            font-size: 14px; font-family: 'Inter', sans-serif; transition: 0.15s; background: #fff;
            width: 100%;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: #6D4AFF; box-shadow: 0 0 0 3px rgba(109,74,255,0.08); outline: none;
        }
        .full-width { grid-column: 1 / -1; }

        .drawer-overlay {
            position: fixed; inset: 0; background: rgba(15,23,42,0.4); z-index: 100;
            display: none; backdrop-filter: blur(2px);
        }
        .drawer-overlay.active { display: block; }
        .drawer {
            position: fixed; right: -420px; top: 0; width: 420px; height: 100%;
            background: #fff; box-shadow: -8px 0 30px rgba(0,0,0,0.08);
            transition: right 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            z-index: 101; padding: 28px 24px; overflow-y: auto;
            border-radius: 0 0 0 24px;
        }
        .drawer.open { right: 0; }
        .drawer-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .drawer-header h3 { font-size: 20px; font-weight: 600; }
        .drawer-close { background: transparent; border: none; font-size: 24px; color: #94A3B8; cursor: pointer; }

        .toast {
            position: fixed; bottom: 30px; right: 30px; background: #0F172A;
            color: #fff; padding: 16px 28px; border-radius: 60px;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.2);
            display: flex; align-items: center; gap: 12px; font-weight: 500; font-size: 15px;
            transform: translateY(80px); opacity: 0; transition: all 0.3s ease;
            z-index: 9999; border-left: 5px solid #6D4AFF;
        }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast i { color: #6D4AFF; font-size: 20px; }

        .teacher-tag {
            display: inline-block;
            background: #EDE7FF;
            color: #6D4AFF;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            margin: 2px 4px 2px 0;
        }
        .teacher-tag i { margin-right: 4px; font-size: 10px; }

        @media (max-width: 1024px) {
            .form-grid { grid-template-columns: 1fr; }
            .drawer { width: 360px; right: -380px; }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); width: 270px; position: fixed; top:0; left:0; height:100%; }
            .sidebar.open { transform: translateX(0); }
            .topbar-left .menu-toggle { display: block; }
            .search-box { width: 140px; }
            .content { padding: 20px 16px; }
            .topbar { padding: 12px 16px; }
            .modal { padding: 24px 18px; }
            .drawer { width: 100%; right: -100%; border-radius: 0; }
            .drawer.open { right: 0; }
        }
        .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.2); z-index: 45; }
        .overlay.active { display: block; }
    </style>
</head>
<body>
    <div class="overlay" id="overlay"></div>
    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
            <span>Leeds<small>Academy</small></span>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="#"><i class="fas fa-user-graduate"></i> Students</a></li>
            <li><a href="#"><i class="fas fa-chalkboard-teacher"></i> Teachers</a></li>
            <li class="active"><a href="{{ route('admin.courses.index') }}"><i class="fas fa-book-open"></i> Courses</a></li>
            <li><a href="#"><i class="fas fa-user-plus"></i> Enrollments</a></li>
            <li><a href="#"><i class="fas fa-dollar-sign"></i> Fee Payments</a></li>
            <li><a href="#"><i class="fas fa-id-card"></i> Student Cards</a></li>
            <li><a href="#"><i class="fas fa-certificate"></i> Certificates</a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> Reports</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
        </ul>
    </aside>

    <!-- MAIN -->
    <div class="main">
        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
                <div>
                    <h2>Course Management</h2>
                    <div class="breadcrumb">Dashboard / <span>Courses</span></div>
                </div>
            </div>
            <div class="topbar-right">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search courses..." onkeyup="filterCourses()">
                </div>
                <button class="notif-btn"><i class="fas fa-bell"></i><span class="notif-badge">3</span></button>
                <div class="profile-dropdown-wrap">
                    <button class="profile-btn" id="profileBtn"><img src="#" alt="A" style="background:#6D4AFF; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:600;"> <span>{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span> <i class="fas fa-chevron-down" style="font-size:12px; margin-left:4px;"></i></button>
                    <div class="dropdown-menu" id="profileDropdown">
                        <a href="#"><i class="fas fa-user"></i> View Profile</a>
                        <a href="#"><i class="fas fa-sliders-h"></i> Account Settings</a>
                        <a href="#"><i class="fas fa-key"></i> Change Password</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <a href="#" onclick="this.closest('form').submit(); return false;"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="content">
            <div class="page-header">
                <h3>Course List</h3>
                <button class="btn-primary" id="addCourseBtn"><i class="fas fa-plus"></i> Add New Course</button>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div style="background:#DCFCE7; border:1px solid #BBF7D0; color:#10B981; padding:12px 16px; border-radius:10px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background:#FEE2E2; border:1px solid #FECACA; color:#DC2626; padding:12px 16px; border-radius:10px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <div class="filters-bar">
                <input type="text" id="filterSearch" placeholder="Search course..." style="flex:1; min-width:140px;" onkeyup="filterCourses()">
                <select id="filterStatus" onchange="filterCourses()">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="pending">Pending</option>
                </select>
                <button class="btn-reset" onclick="resetFilters()"><i class="fas fa-redo"></i> Reset</button>
            </div>

            <div class="table-card">
                <table>
                    <thead><tr>
                        <th>#</th>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Original Fee</th>
                        <th>Duration</th>
                        <th>Enrollments</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr></thead>
                    <tbody id="coursesTableBody">
                        @forelse($courses as $index => $course)
                        <tr onclick="viewCourse({{ $course->id }})" style="cursor:pointer;">
                            <td>{{ $courses->firstItem() + $index }}</td>
                            <td><span style="font-size:12px; color:#64748B;">{{ $course->course_code }}</span></td>
                            <td><strong>{{ $course->name }}</strong></td>
                            <td>PKR {{ number_format($course->original_fee, 0) }}</td>
                            <td>{{ $course->duration }}</td>
                            <td>{{ $course->enrollments_count ?? 0 }}</td>
                            <td>
                                @if($course->status == 'active')
                                    <span class="status-badge">Active</span>
                                @elseif($course->status == 'inactive')
                                    <span class="status-badge inactive">Inactive</span>
                                @else
                                    <span class="status-badge warning">Pending</span>
                                @endif
                            </td>
                            <td onclick="event.stopPropagation();">
                                <div class="action-dropdown">
                                    <button class="dropdown-trigger" onclick="toggleDD(this)"><i class="fas fa-ellipsis-v"></i></button>
                                    <div class="dd-menu">
                                        <a href="#" onclick="viewCourse({{ $course->id }}); return false;"><i class="fas fa-eye"></i> View Details</a>
                                        <a href="#" onclick="editCourse({{ $course->id }}); return false;"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="#" onclick="assignTeacher({{ $course->id }}); return false;"><i class="fas fa-user-plus"></i> Assign Teacher</a>
                                        <a href="#" onclick="viewEnrollments({{ $course->id }}); return false;"><i class="fas fa-users"></i> Enrolled Students</a>
                                        <a href="#" onclick="deleteCourse({{ $course->id }}, '{{ $course->name }}'); return false;"><i class="fas fa-trash" style="color:#EF4444;"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:40px 0; color:#94A3B8;">
                                <i class="fas fa-book-open" style="font-size:40px; display:block; margin-bottom:12px; color:#E2E8F0;"></i>
                                No courses found. Click "Add New Course" to create one.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:16px; flex-wrap:wrap; gap:10px;">
                    <span style="font-size:14px; color:#64748B;">Showing {{ $courses->firstItem() ?? 0 }}-{{ $courses->lastItem() ?? 0 }} of {{ $courses->total() }}</span>
                    <div style="display:flex; gap:6px;">
                        {{ $courses->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SIDE DRAWER - View Details -->
    <div class="drawer-overlay" id="drawerOverlay" onclick="closeDrawer()"></div>
    <div class="drawer" id="drawer">
        <div class="drawer-header">
            <h3 id="drawerTitle">Course Details</h3>
            <button class="drawer-close" onclick="closeDrawer()"><i class="fas fa-times"></i></button>
        </div>
        <div id="drawerContent">
            <div style="text-align:center; padding:30px 0; color:#94A3B8;">
                <i class="fas fa-spinner fa-spin" style="font-size:30px;"></i>
                <p style="margin-top:10px;">Loading course details...</p>
            </div>
        </div>
    </div>

    <!-- ADD/EDIT COURSE MODAL - Same Popup -->
    <div class="modal-overlay" id="courseModal">
        <div class="modal">
            <div class="modal-header">
                <h2 id="modalTitle"><i class="fas fa-book-open" style="color:#6D4AFF; margin-right:10px;"></i> Add New Course</h2>
                <button class="modal-close" onclick="closeModal('courseModal')"><i class="fas fa-times"></i></button>
            </div>
            <form id="courseForm" onsubmit="saveCourse(event)">
                @csrf
                <input type="hidden" id="courseId" name="course_id" value="">
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Course Name *</label>
                        <input type="text" placeholder="Enter course name" id="cName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Original Fee (PKR) *</label>
                        <input type="number" placeholder="30000" id="cFee" name="original_fee" required>
                    </div>
                    <div class="form-group">
                        <label>Duration *</label>
                        <select id="cDuration" name="duration" required>
                            <option value="">Select Duration</option>
                            <option value="1 Month">1 Month</option>
                            <option value="1.5 Months">1.5 Months</option>
                            <option value="2 Months">2 Months</option>
                            <option value="3 Months">3 Months</option>
                            <option value="4 Months">4 Months</option>
                            <option value="6 Months">6 Months</option>
                            <option value="1 Year">1 Year</option>
                        </select>
                    </div>
                    <div class="form-group full-width">
                        <label>Description</label>
                        <textarea id="cDescription" name="description" rows="3" placeholder="Course description..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select id="cStatus" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:24px; padding-top:20px; border-top:1px solid #F1F5F9;">
                    <button type="button" class="btn-outline" onclick="closeModal('courseModal')">Cancel</button>
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> <span id="submitBtnText">Save Course</span></button>
                </div>
            </form>
        </div>
    </div>

    <!-- DELETE CONFIRMATION MODAL -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal" style="max-width:450px;">
            <div class="modal-header">
                <h2><i class="fas fa-exclamation-triangle" style="color:#EF4444; margin-right:10px;"></i> Confirm Delete</h2>
                <button class="modal-close" onclick="closeModal('deleteModal')"><i class="fas fa-times"></i></button>
            </div>
            <p style="font-size:15px; color:#1E293B; margin:10px 0;">
                Are you sure you want to delete "<strong id="deleteCourseName"></strong>"?
            </p>
            <p style="font-size:13px; color:#94A3B8; margin-bottom:16px;">This action cannot be undone.</p>
            <form id="deleteForm" method="POST" style="display:flex; justify-content:flex-end; gap:12px;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn-outline" onclick="closeModal('deleteModal')">Cancel</button>
                <button type="submit" class="btn-primary" style="background:#EF4444; box-shadow:0 6px 14px -6px rgba(239,68,68,0.3);">
                    <i class="fas fa-trash"></i> Delete Course
                </button>
            </form>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast"><i class="fas fa-check-circle"></i> <span id="toastMsg">Action completed</span></div>

    <script>
        // ---- Helpers ----
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('overlay').classList.toggle('active');
        }
        document.getElementById('menuToggle').addEventListener('click', toggleSidebar);
        document.getElementById('overlay').addEventListener('click', toggleSidebar);

        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        profileBtn.addEventListener('click', function(e) { e.stopPropagation(); profileDropdown.classList.toggle('open'); });
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.profile-dropdown-wrap')) profileDropdown.classList.remove('open');
        });

        function toggleDD(btn) {
            const menu = btn.nextElementSibling;
            document.querySelectorAll('.dd-menu').forEach(m => { if (m !== menu) m.classList.remove('open'); });
            menu.classList.toggle('open');
        }
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.action-dropdown')) document.querySelectorAll('.dd-menu').forEach(m => m.classList.remove('open'));
        });

        function openModal(id) { document.getElementById(id).classList.add('active'); }
        function closeModal(id) { document.getElementById(id).classList.remove('active'); }
        document.querySelectorAll('.modal-overlay').forEach(el => {
            el.addEventListener('click', function(e) { if (e.target === this) this.classList.remove('active'); });
        });

        function showToast(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            toast.classList.add('show');
            clearTimeout(toast._timer);
            toast._timer = setTimeout(() => toast.classList.remove('show'), 3500);
        }

        // ---- VIEW COURSE - Side Drawer ----
        function viewCourse(id) {
            document.getElementById('drawerTitle').textContent = 'Course Details';
            document.getElementById('drawerOverlay').classList.add('active');
            document.getElementById('drawer').classList.add('open');
            
            // Show loading
            document.getElementById('drawerContent').innerHTML = `
                <div style="text-align:center; padding:30px 0; color:#94A3B8;">
                    <i class="fas fa-spinner fa-spin" style="font-size:30px;"></i>
                    <p style="margin-top:10px;">Loading course details...</p>
                </div>
            `;
            
            fetch('/admin/courses/' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const course = data.data;
                        document.getElementById('drawerContent').innerHTML = `
                            <div style="margin-bottom:20px;">
                                <h4 style="font-size:18px;">${course.name}</h4>
                                <p style="color:#64748B;">Course ID: ${course.course_code}</p>
                            </div>
                            <div style="background:#F8FAFC; border-radius:14px; padding:16px; border:1px solid #F1F5F9; margin-bottom:12px;">
                                <div style="display:flex; justify-content:space-between; padding:4px 0;"><span style="color:#64748B;">Original Fee</span><span style="font-weight:600;">PKR ${Number(course.original_fee).toLocaleString()}</span></div>
                                <div style="display:flex; justify-content:space-between; padding:4px 0;"><span style="color:#64748B;">Duration</span><span>${course.duration}</span></div>
                                <div style="display:flex; justify-content:space-between; padding:4px 0;"><span style="color:#64748B;">Status</span>
                                    <span class="status-badge ${course.status === 'active' ? '' : (course.status === 'inactive' ? 'inactive' : 'warning')}">
                                        ${course.status.charAt(0).toUpperCase() + course.status.slice(1)}
                                    </span>
                                </div>
                                <div style="display:flex; justify-content:space-between; padding:4px 0;"><span style="color:#64748B;">Total Enrollments</span><span>${course.enrollments_count || 0}</span></div>
                                <div style="display:flex; justify-content:space-between; padding:4px 0;"><span style="color:#64748B;">Created At</span><span>${new Date(course.created_at).toLocaleDateString()}</span></div>
                            </div>
                            <div style="background:#F8FAFC; border-radius:14px; padding:16px; border:1px solid #F1F5F9; margin-bottom:12px;">
                                <h5 style="margin-bottom:8px;">Description</h5>
                                <p style="font-size:13px; color:#64748B;">${course.description || 'No description provided.'}</p>
                            </div>
                            <div style="margin-top:20px; display:flex; gap:10px; flex-wrap:wrap;">
                                <button class="btn-outline" style="flex:1;" onclick="editCourse(${course.id})"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn-outline" style="flex:1;" onclick="assignTeacher(${course.id})"><i class="fas fa-user-plus"></i> Assign Teacher</button>
                                <button class="btn-primary" style="flex:1;" onclick="viewEnrollments(${course.id})"><i class="fas fa-users"></i> Enrollments</button>
                            </div>
                        `;
                    } else {
                        document.getElementById('drawerContent').innerHTML = `
                            <div style="text-align:center; padding:30px 0; color:#94A3B8;">
                                <i class="fas fa-exclamation-circle" style="font-size:30px; color:#EF4444;"></i>
                                <p style="margin-top:10px;">Course not found</p>
                            </div>
                        `;
                    }
                })
                .catch(() => {
                    document.getElementById('drawerContent').innerHTML = `
                        <div style="text-align:center; padding:30px 0; color:#94A3B8;">
                            <i class="fas fa-exclamation-circle" style="font-size:30px; color:#EF4444;"></i>
                            <p style="margin-top:10px;">Error loading course details</p>
                        </div>
                    `;
                });
        }

        function closeDrawer() {
            document.getElementById('drawerOverlay').classList.remove('active');
            document.getElementById('drawer').classList.remove('open');
        }

        // ---- ADD COURSE ----
        document.getElementById('addCourseBtn').addEventListener('click', function() {
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-book-open" style="color:#6D4AFF; margin-right:10px;"></i> Add New Course';
            document.getElementById('submitBtnText').textContent = 'Save Course';
            document.getElementById('courseId').value = '';
            document.getElementById('courseForm').reset();
            document.getElementById('courseForm').action = '{{ route("admin.courses.store") }}';
            const methodInput = document.querySelector('input[name="_method"]');
            if (methodInput) methodInput.remove();
            openModal('courseModal');
        });

        // ---- EDIT COURSE - Same Popup Modal ----
        function editCourse(id) {
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit" style="color:#6D4AFF; margin-right:10px;"></i> Edit Course';
            document.getElementById('submitBtnText').textContent = 'Update Course';
            
            // Close drawer if open
            closeDrawer();
            
            fetch('/admin/courses/' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const course = data.data;
                        document.getElementById('courseId').value = course.id;
                        document.getElementById('cName').value = course.name;
                        document.getElementById('cFee').value = course.original_fee;
                        document.getElementById('cDuration').value = course.duration;
                        document.getElementById('cDescription').value = course.description || '';
                        document.getElementById('cStatus').value = course.status;
                        
                        const form = document.getElementById('courseForm');
                        form.action = '/admin/courses/' + course.id;
                        
                        // Add PUT method if not exists
                        if (!document.querySelector('input[name="_method"]')) {
                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'PUT';
                            form.appendChild(methodInput);
                        }
                        openModal('courseModal');
                    }
                })
                .catch(error => {
                    showToast('⚠️ Error loading course data');
                    console.error(error);
                });
        }

        // ---- SAVE COURSE (Create/Update) ----
      // ---- SAVE COURSE (Create/Update) ----
function saveCourse(e) {
    e.preventDefault();
    const form = document.getElementById('courseForm');
    const formData = new FormData(form);
    const courseId = document.getElementById('courseId').value;
    
    // Build the URL properly
    let url = form.action;
    if (courseId) {
        url = '/admin/courses/' + courseId;
    }
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => {
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Server returned non-JSON response');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            closeModal('courseModal');
            showToast('✅ ' + data.message);
            setTimeout(() => window.location.reload(), 1500);
        } else {
            let errorMsg = data.message || 'Error saving course';
            if (data.errors) {
                errorMsg = Object.values(data.errors).flat().join(', ');
            }
            showToast('⚠️ ' + errorMsg);
        }
    })
    .catch(error => {
        showToast('⚠️ Error saving course: ' + error.message);
        console.error(error);
    });
}

        // ---- DELETE COURSE ----
        function deleteCourse(id, name) {
            document.getElementById('deleteCourseName').textContent = name;
            const form = document.getElementById('deleteForm');
            form.action = '/admin/courses/' + id;
            openModal('deleteModal');
        }

        // ---- OTHER FUNCTIONS ----
        function assignTeacher(id) {
            showToast('📋 Assign teacher functionality coming soon');
        }

        function viewEnrollments(id) {
            showToast('📋 View enrollments coming soon');
        }

        // ---- FILTER ----
        function filterCourses() {
            const search = document.getElementById('filterSearch').value.toLowerCase();
            const status = document.getElementById('filterStatus').value;
            const rows = document.querySelectorAll('#coursesTableBody tr');
            
            rows.forEach(row => {
                if (row.cells && row.cells.length > 0) {
                    const name = row.cells[2]?.textContent.toLowerCase() || '';
                    const code = row.cells[1]?.textContent.toLowerCase() || '';
                    const statusCell = row.cells[6]?.textContent.trim() || '';
                    const matchesSearch = name.includes(search) || code.includes(search);
                    const matchesStatus = status === 'all' || statusCell.toLowerCase().includes(status);
                    row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
                }
            });
        }

        function resetFilters() {
            document.getElementById('filterSearch').value = '';
            document.getElementById('filterStatus').value = 'all';
            filterCourses();
        }

        // ---- DELETE FORM SUBMIT ----
        document.getElementById('deleteForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const url = form.action;
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: new FormData(form)
            })
            .then(response => response.json())
            .then(data => {
                closeModal('deleteModal');
                if (data.success) {
                    showToast('✅ ' + data.message);
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showToast('⚠️ ' + data.message);
                }
            })
            .catch(error => {
                showToast('⚠️ Error deleting course');
                console.error(error);
            });
        });

        // ---- AUTO-RUN FILTER ON PAGE LOAD ----
        document.addEventListener('DOMContentLoaded', function() {
            filterCourses();
        });
    </script>
</body>
</html>