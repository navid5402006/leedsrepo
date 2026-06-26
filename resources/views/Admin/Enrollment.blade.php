{{-- resources/views/admin/enrollment.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leeds Academy · Enrollment Management</title>
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
        .btn-danger {
            background: #EF4444; border: none; padding: 10px 24px; border-radius: 40px;
            font-weight: 600; font-size: 14px; color: #fff; display: inline-flex; align-items: center; gap: 8px;
            cursor: pointer; transition: 0.15s; font-family: 'Inter', sans-serif; box-shadow: 0 6px 14px -6px rgba(239,68,68,0.3);
        }
        .btn-danger:hover { background: #DC2626; transform: translateY(-2px); }

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

        .enrollment-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }
        .table-card {
            background: #fff; border-radius: 16px; border: 1px solid #F1F5F9;
            padding: 20px 24px 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); overflow-x: auto;
        }
        .history-card {
            background: #fff; border-radius: 16px; border: 1px solid #F1F5F9;
            padding: 20px 24px 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            max-height: 500px;
            overflow-y: auto;
        }
        .history-card h4 {
            font-size: 16px;
            font-weight: 600;
            color: #0F172A;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            position: sticky;
            top: 0;
            background: #fff;
            padding-bottom: 8px;
            border-bottom: 2px solid #F1F5F9;
            z-index: 2;
        }
        .history-card h4 i { color: #6D4AFF; }
        .history-item {
            padding: 10px 0;
            border-bottom: 1px solid #F1F5F9;
        }
        .history-item:last-child { border-bottom: none; }
        .history-item .student-name {
            font-weight: 600;
            font-size: 14px;
        }
        .history-item .course-name {
            font-size: 13px;
            color: #64748B;
            display: block;
            margin: 2px 0;
        }
        .history-item .date {
            font-size: 12px;
            color: #94A3B8;
        }
        .history-item .fee {
            font-size: 13px;
            font-weight: 500;
            color: #6D4AFF;
        }
        .history-empty {
            color: #94A3B8;
            text-align: center;
            padding: 30px 0;
            font-size: 14px;
        }

        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th { text-align: left; padding: 12px 8px 12px 0; font-weight: 600; color: #475569; border-bottom: 1px solid #F1F5F9; }
        td { padding: 14px 8px 14px 0; border-bottom: 1px solid #F1F5F9; color: #1E293B; vertical-align: middle; }
        td:last-child { padding-right:0; }
        tr:hover td { background: #F8FAFC; cursor: pointer; }
        .status-badge {
            font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 40px;
        }
        .status-badge.active { background: #E6F7E6; color: #10B981; }
        .status-badge.completed { background: #EDE7FF; color: #6D4AFF; }
        .status-badge.withdrawn { background: #FEE2E2; color: #DC2626; }
        .avatar-sm {
            width: 32px; height: 32px; border-radius: 30px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: 12px;
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
            background: #fff; border-radius: 28px; max-width: 820px; width: 100%;
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
        .form-group label .required { color: #EF4444; }
        .form-group input, .form-group select, .form-group textarea {
            padding: 10px 14px; border-radius: 12px; border: 1.5px solid #E2E8F0;
            font-size: 14px; font-family: 'Inter', sans-serif; transition: 0.15s; background: #fff;
            width: 100%;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: #6D4AFF; box-shadow: 0 0 0 3px rgba(109,74,255,0.08); outline: none;
        }
        .full-width { grid-column: 1 / -1; }

        /* Advanced Search Dropdown */
        .search-select-wrapper {
            position: relative;
        }
        .search-select-wrapper input {
            width: 100%;
            padding: 10px 14px;
            border-radius: 12px;
            border: 1.5px solid #E2E8F0;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: 0.15s;
            background: #fff;
        }
        .search-select-wrapper input:focus {
            border-color: #6D4AFF;
            box-shadow: 0 0 0 3px rgba(109,74,255,0.08);
            outline: none;
        }
        .search-select-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border-radius: 12px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-height: 200px;
            overflow-y: auto;
            display: none;
            z-index: 10;
            margin-top: 4px;
        }
        .search-select-dropdown.show { display: block; }
        .search-select-dropdown .option {
            padding: 10px 14px;
            cursor: pointer;
            transition: 0.1s;
            font-size: 14px;
        }
        .search-select-dropdown .option:hover {
            background: #F8FAFC;
        }
        .search-select-dropdown .option.selected {
            background: #EDE7FF;
            color: #6D4AFF;
        }
        .search-select-dropdown .option .sub {
            font-size: 12px;
            color: #94A3B8;
        }

        .course-option {
            padding: 12px 16px; border: 1.5px solid #E2E8F0; border-radius: 14px;
            cursor: pointer; transition: 0.15s; display: flex; align-items: center; gap: 12px;
            margin-bottom: 8px;
        }
        .course-option:hover { border-color: #6D4AFF; background: #F8FAFC; }
        .course-option.selected { border-color: #6D4AFF; background: #EDE7FF; }
        .course-option input[type="checkbox"] { width: 18px; height: 18px; accent-color: #6D4AFF; }
        .course-option .course-fee { margin-left: auto; color: #6D4AFF; font-weight: 600; }

        .fee-summary {
            background: #F8FAFC; border-radius: 14px; padding: 16px 20px;
            border: 1px solid #F1F5F9; margin-top: 12px;
        }
        .fee-summary .row { display: flex; justify-content: space-between; padding: 4px 0; font-size: 14px; }
        .fee-summary .total { font-weight: 700; font-size: 16px; border-top: 1px solid #E2E8F0; padding-top: 8px; margin-top: 4px; }

        .modal-footer {
            display: flex; justify-content: flex-end; gap: 12px;
            margin-top: 24px; padding-top: 20px; border-top: 1px solid #F1F5F9;
        }

        .delete-modal .modal { max-width: 440px; text-align: center; }
        .delete-modal .modal .icon { font-size: 48px; color: #EF4444; margin-bottom: 12px; }
        .delete-modal .modal h3 { font-size: 20px; font-weight: 600; margin-bottom: 4px; }
        .delete-modal .modal p { color: #64748B; font-size: 14px; }

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

        .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.2); z-index: 45; }
        .overlay.active { display: block; }

        @media (max-width: 1024px) {
            .enrollment-layout { grid-template-columns: 1fr; }
            .form-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); width: 270px; position: fixed; top:0; left:0; height:100%; }
            .sidebar.open { transform: translateX(0); }
            .topbar-left .menu-toggle { display: block; }
            .search-box { width: 140px; }
            .content { padding: 20px 16px; }
            .topbar { padding: 12px 16px; }
            .modal { padding: 24px 18px; }
        }
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
      <li class="active"><a href="{{ route('dashboard') }}"><i class="fas fa-th-large"></i> Dashboard</a></li>
      <li><a href="{{ route('admin.students.index') }}"><i class="fas fa-user-graduate"></i> Students</a></li>
      <li><a href="{{ route('admin.teachers.index') }}"><i class="fas fa-chalkboard-teacher"></i> Teachers</a></li>
      <li><a href="{{ route('admin.courses.index') }}"><i class="fas fa-book-open"></i> Courses</a></li>
      <li><a href="{{ route('admin.enrollments.index') }}"><i class="fas fa-user-plus"></i> Enrollments</a></li>
      <li><a href="{{ route('admin.fee-payments.index') }}"><i class="fas fa-dollar-sign"></i> Fee Payments</a></li>
      <li><a href="{{ route('admin.student-cards.index') }}"><i class="fas fa-id-card"></i> Student Cards</a></li>
      <li><a href="{{ route('admin.certificates.index') }}"><i class="fas fa-certificate"></i> Certificates</a></li>
      <li><a href="{{ route('admin.reports.index') }}"><i class="fas fa-chart-bar"></i> Reports</a></li>
      <li><a href="{{ route('admin.enquiries.index') }}"><i class="fas fa-envelope"></i> Enquiries</a></li>
      <li><a href="{{ route('admin.settings.index') }}"><i class="fas fa-cog"></i> Settings</a></li>
    </ul>
  </aside>

    <!-- MAIN -->
    <div class="main">
        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
                <div>
                    <h2>Enrollment Management</h2>
                    <div class="breadcrumb">Dashboard / <span>Enrollments</span></div>
                </div>
            </div>
            <div class="topbar-right">
                <div class="search-box"><i class="fas fa-search"></i><input type="text" placeholder="Search enrollments..." id="globalSearch" oninput="filterTable()" /></div>
                <button class="notif-btn"><i class="fas fa-bell"></i><span class="notif-badge">3</span></button>
                <div class="profile-dropdown-wrap">
                    <button class="profile-btn" id="profileBtn"><img src="#" alt="A" style="background:#6D4AFF; display:flex; align-items:center; justify-content:center; color:#fff;"> <span>Admin</span> <i class="fas fa-chevron-down" style="font-size:12px; margin-left:4px;"></i></button>
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
                <h3>Enrollment List</h3>
                <button class="btn-primary" id="addEnrollmentBtn"><i class="fas fa-plus"></i> New Enrollment</button>
            </div>

            <div class="filters-bar">
                <input type="text" placeholder="Search student or course..." style="flex:1; min-width:140px;" id="filterSearch" oninput="filterTable()">
                <select id="filterStatus" onchange="filterTable()">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                    <option value="withdrawn">Withdrawn</option>
                </select>
                <button class="btn-reset" onclick="resetFilters()"><i class="fas fa-redo"></i> Reset</button>
            </div>

            <div class="enrollment-layout">
                <!-- Main Table -->
                <div class="table-card">
                    <table>
                        <thead><tr>
                            <th>Student</th><th>Course</th><th>Original Fee</th><th>Discount</th><th>Final Fee</th><th>Enrollment Date</th><th>Status</th><th>Actions</th>
                        </tr></thead>
                        <tbody id="enrollmentTableBody">
                            <tr><td colspan="8" style="text-align:center; padding:40px; color:#94A3B8;">Loading enrollments...</td></tr>
                        </tbody>
                    </table>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:16px; flex-wrap:wrap; gap:10px;">
                        <span style="font-size:14px; color:#64748B;" id="recordCount">Loading...</span>
                        <div style="display:flex; gap:6px;" id="paginationControls"></div>
                    </div>
                </div>

                <!-- Right Side: Enrollment History -->
                <div class="history-card" id="historyCard">
                    <h4><i class="fas fa-history"></i> Enrollment History</h4>
                    <div id="historyList">
                        <div class="history-empty">Loading history...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ADD ENROLLMENT MODAL -->
    <div class="modal-overlay" id="addEnrollmentModal">
        <div class="modal">
            <div class="modal-header">
                <h2><i class="fas fa-user-plus" style="color:#6D4AFF; margin-right:10px;"></i> New Enrollment</h2>
                <button class="modal-close" onclick="closeModal('addEnrollmentModal')"><i class="fas fa-times"></i></button>
            </div>
            <form id="enrollmentForm" onsubmit="saveEnrollment(event)">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Student *</label>
                        <div class="search-select-wrapper">
                            <input type="text" id="studentSearch" placeholder="Search student..." oninput="filterStudents(this.value)" onfocus="document.getElementById('studentDropdown').classList.add('show')">
                            <div class="search-select-dropdown" id="studentDropdown">
                                @foreach($students ?? [] as $student)
                                    <div class="option" data-value="{{ $student->name }}" data-id="{{ $student->id }}" onclick="selectStudent('{{ $student->name }}', '{{ $student->id }}', this)">
                                        {{ $student->name }} <span class="sub">ID: {{ $student->student_id }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" id="selectedStudent" value="">
                        </div>
                    </div>
                    <div class="form-group"><label>Enrollment Date *</label><input type="date" id="eDate" required></div>
                </div>

                <div style="font-weight:600; font-size:15px; margin:16px 0 10px;">Select Courses</div>
                <div id="courseSelection">
                    @foreach($courses ?? [] as $course)
                        <div class="course-option" data-course="{{ $course->name }}" data-fee="{{ $course->original_fee }}" data-id="{{ $course->id }}">
                            <input type="checkbox" value="{{ $course->id }}"> <span>{{ $course->name }}</span>
                            <span class="course-fee">PKR {{ number_format($course->original_fee, 0) }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Discount section per course -->
                <div id="discountSection" style="margin-top:12px;"></div>

                <!-- Fee Summary -->
                <div class="fee-summary" id="feeSummary">
                    <div class="row"><span>Total Original Fee</span><span id="totalOriginalFee">PKR 0</span></div>
                    <div class="row"><span>Total Discount</span><span id="totalDiscount" style="color:#10B981;">PKR 0</span></div>
                    <div class="row total"><span>Total Final Fee</span><span id="totalFinalFee" style="color:#6D4AFF;">PKR 0</span></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-outline" onclick="closeModal('addEnrollmentModal')">Cancel</button>
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Enrollment</button>
                </div>
            </form>
        </div>
    </div>

    <!-- DELETE MODAL -->
    <div class="modal-overlay delete-modal" id="deleteModal">
        <div class="modal">
            <div class="icon"><i class="fas fa-exclamation-circle"></i></div>
            <h3>Delete Enrollment</h3>
            <p>Are you sure you want to delete this enrollment? This action cannot be undone.</p>
            <div style="margin-top:16px; display:flex; gap:12px; justify-content:center;">
                <button class="btn-outline" onclick="closeDeleteModal()">Cancel</button>
                <button class="btn-danger" id="confirmDeleteBtn"><i class="fas fa-trash"></i> Delete</button>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast"><i class="fas fa-check-circle"></i> <span id="toastMsg">Action completed</span></div>

    <script>
        // ─── Global Variables ───
        let enrollments = [];
        let currentPage = 1;
        const perPage = 10;
        let deleteId = null;
        let selectedStudentId = null;
        let selectedCourses = [];
        let courseDiscounts = {};

        // ─── CSRF Token ───
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // ─── Load Enrollments ───
        async function loadEnrollments() {
            try {
                const response = await fetch('{{ route("admin.enrollments.index") }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                enrollments = data.data || [];
                renderTable();
                updateHistory();
            } catch (error) {
                console.error('Error loading enrollments:', error);
                showToast('⚠️ Error loading enrollments');
                document.getElementById('enrollmentTableBody').innerHTML = `
                    <tr><td colspan="8" style="text-align:center; padding:40px; color:#94A3B8;">
                        <i class="fas fa-exclamation-circle" style="font-size:24px; display:block; margin-bottom:8px;"></i>
                        Failed to load enrollments. Please refresh the page.
                    </td></tr>
                `;
            }
        }

        // ─── Render Table ───
        function renderTable() {
            const filtered = getFilteredEnrollments();
            const total = filtered.length;
            const totalPages = Math.ceil(total / perPage);
            if (currentPage > totalPages) currentPage = totalPages || 1;
            const start = (currentPage - 1) * perPage;
            const pageData = filtered.slice(start, start + perPage);

            const tbody = document.getElementById('enrollmentTableBody');
            if (pageData.length === 0) {
                tbody.innerHTML = `<tr><td colspan="8" style="text-align:center; padding:40px; color:#94A3B8;">No enrollments found</td></tr>`;
            } else {
                tbody.innerHTML = pageData.map(e => {
                    const statusClass = e.status || 'active';
                    const studentName = e.student ? e.student.name : 'Unknown';
                    const courseName = e.course ? e.course.name : 'Unknown';
                    const initials = studentName.split(' ').map(w => w[0]).join('').toUpperCase();
                    const colors = ['purple', 'blue', 'green', 'orange'];
                    const colorIndex = (e.id || 0) % colors.length;
                    
                    return `
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div class="avatar-sm ${colors[colorIndex]}">${initials}</div>
                                    ${studentName}
                                </div>
                            </td>
                            <td>${courseName}</td>
                            <td>PKR ${parseFloat(e.original_fee).toLocaleString()}</td>
                            <td>PKR ${parseFloat(e.discount || 0).toLocaleString()}</td>
                            <td>PKR ${parseFloat(e.final_fee).toLocaleString()}</td>
                            <td>${e.enrollment_date ? new Date(e.enrollment_date).toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' }) : '-'}</td>
                            <td><span class="status-badge ${statusClass}">${statusClass.charAt(0).toUpperCase() + statusClass.slice(1)}</span></td>
                            <td>
                                <div class="action-dropdown">
                                    <button class="dropdown-trigger" onclick="toggleDD(this)"><i class="fas fa-ellipsis-v"></i></button>
                                    <div class="dd-menu">
                                        <a href="#" onclick="viewEnrollment(${e.id}); return false;"><i class="fas fa-eye"></i> View Details</a>
                                        <a href="#" onclick="editEnrollment(${e.id}); return false;"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="#" onclick="deleteEnrollment(${e.id}); return false;"><i class="fas fa-trash"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `;
                }).join('');
            }

            document.getElementById('recordCount').textContent = `Showing ${start + 1}-${Math.min(start + perPage, total)} of ${total}`;
            renderPagination(totalPages);
        }

        // ─── Update History ───
        function updateHistory() {
            const historyList = document.getElementById('historyList');
            if (enrollments.length === 0) {
                historyList.innerHTML = '<div class="history-empty">No enrollments found</div>';
                return;
            }
            
            const recent = enrollments.slice(0, 5);
            historyList.innerHTML = recent.map(e => {
                const studentName = e.student ? e.student.name : 'Unknown';
                const courseName = e.course ? e.course.name : 'Unknown';
                const date = e.enrollment_date ? new Date(e.enrollment_date).toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' }) : '-';
                return `
                    <div class="history-item">
                        <div class="student-name">${studentName}</div>
                        <span class="course-name">${courseName}</span>
                        <span class="date">${date} • <span class="fee">PKR ${parseFloat(e.final_fee).toLocaleString()}</span></span>
                    </div>
                `;
            }).join('');
        }

        // ─── Pagination ───
        function renderPagination(totalPages) {
            const container = document.getElementById('paginationControls');
            if (totalPages <= 1) { container.innerHTML = ''; return; }
            let html = '';
            if (currentPage > 1) {
                html += `<button class="btn-reset" style="padding:4px 14px;" onclick="goToPage(${currentPage - 1})">Prev</button>`;
            }
            for (let i = 1; i <= totalPages; i++) {
                const active = i === currentPage ? 'background:#6D4AFF; color:#fff; border-color:#6D4AFF;' : '';
                html += `<button class="btn-reset" style="padding:4px 14px; ${active}" onclick="goToPage(${i})">${i}</button>`;
            }
            if (currentPage < totalPages) {
                html += `<button class="btn-reset" style="padding:4px 14px;" onclick="goToPage(${currentPage + 1})">Next</button>`;
            }
            container.innerHTML = html;
        }

        function goToPage(page) {
            currentPage = page;
            renderTable();
        }

        // ─── Filters ───
        function getFilteredEnrollments() {
            const search = document.getElementById('filterSearch').value.toLowerCase().trim();
            const status = document.getElementById('filterStatus').value;
            return enrollments.filter(e => {
                const studentName = e.student ? e.student.name.toLowerCase() : '';
                const courseName = e.course ? e.course.name.toLowerCase() : '';
                const matchSearch = search === '' || studentName.includes(search) || courseName.includes(search);
                const matchStatus = status === '' || (e.status && e.status === status);
                return matchSearch && matchStatus;
            });
        }

        function filterTable() {
            currentPage = 1;
            renderTable();
        }

        function resetFilters() {
            document.getElementById('filterSearch').value = '';
            document.getElementById('filterStatus').value = '';
            document.getElementById('globalSearch').value = '';
            filterTable();
        }

        // ─── Toggle Dropdown ───
        function toggleDD(btn) {
            const menu = btn.nextElementSibling;
            document.querySelectorAll('.dd-menu').forEach(m => { if (m !== menu) m.classList.remove('open'); });
            menu.classList.toggle('open');
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.action-dropdown')) {
                document.querySelectorAll('.dd-menu').forEach(m => m.classList.remove('open'));
            }
        });

        // ─── Sidebar ───
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('overlay').classList.toggle('active');
        }
        document.getElementById('menuToggle').addEventListener('click', toggleSidebar);
        document.getElementById('overlay').addEventListener('click', toggleSidebar);

        // ─── Profile Dropdown ───
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        profileBtn.addEventListener('click', function(e) { e.stopPropagation(); profileDropdown.classList.toggle('open'); });
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.profile-dropdown-wrap')) profileDropdown.classList.remove('open');
        });

        // ─── Modal Helpers ───
        function openModal(id) { document.getElementById(id).classList.add('active'); }
        function closeModal(id) { document.getElementById(id).classList.remove('active'); }
        document.querySelectorAll('.modal-overlay').forEach(el => {
            el.addEventListener('click', function(e) { if (e.target === this) this.classList.remove('active'); });
        });

        // ─── Student Search ───
        function filterStudents(query) {
            const dropdown = document.getElementById('studentDropdown');
            const options = dropdown.querySelectorAll('.option');
            const search = query.toLowerCase().trim();
            options.forEach(opt => {
                const text = opt.textContent.toLowerCase();
                opt.style.display = (search === '' || text.includes(search)) ? 'block' : 'none';
            });
            dropdown.classList.add('show');
        }

        function selectStudent(name, id, element) {
            selectedStudentId = id;
            document.getElementById('studentSearch').value = name;
            document.getElementById('selectedStudent').value = id;
            document.getElementById('studentDropdown').classList.remove('show');
            document.querySelectorAll('#studentDropdown .option').forEach(opt => opt.classList.remove('selected'));
            if (element) element.classList.add('selected');
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.search-select-wrapper')) {
                document.getElementById('studentDropdown').classList.remove('show');
            }
        });

        // ─── Course Selection ───
        document.querySelectorAll('#courseSelection .course-option').forEach(opt => {
            const cb = opt.querySelector('input[type="checkbox"]');
            cb.addEventListener('change', function() {
                opt.classList.toggle('selected', this.checked);
                updateCourseSelection();
            });
            opt.addEventListener('click', function(e) {
                if (e.target.tagName !== 'INPUT') {
                    const cb = this.querySelector('input[type="checkbox"]');
                    cb.checked = !cb.checked;
                    this.classList.toggle('selected', cb.checked);
                    updateCourseSelection();
                }
            });
        });

        function updateCourseSelection() {
            const checked = document.querySelectorAll('#courseSelection .course-option input:checked');
            selectedCourses = [];
            checked.forEach(cb => {
                const parent = cb.closest('.course-option');
                selectedCourses.push({
                    id: parseInt(cb.value),
                    name: parent.dataset.course,
                    fee: parseInt(parent.dataset.fee)
                });
                if (!courseDiscounts[parent.dataset.course]) courseDiscounts[parent.dataset.course] = 0;
            });
            const selectedNames = selectedCourses.map(c => c.name);
            Object.keys(courseDiscounts).forEach(key => {
                if (!selectedNames.includes(key)) delete courseDiscounts[key];
            });
            renderDiscountInputs();
            updateFeeSummary();
        }

        function renderDiscountInputs() {
            const container = document.getElementById('discountSection');
            if (selectedCourses.length === 0) {
                container.innerHTML = '';
                return;
            }
            let html = '<div style="font-weight:500; font-size:14px; margin-bottom:8px;">Discount per course</div>';
            selectedCourses.forEach(c => {
                const disc = courseDiscounts[c.name] || 0;
                html += `
                    <div style="display:flex; align-items:center; gap:12px; background:#F8FAFC; padding:8px 14px; border-radius:10px; margin-bottom:6px; flex-wrap:wrap;">
                        <span style="font-weight:500; min-width:140px;">${c.name}</span>
                        <span style="color:#64748B; font-size:13px;">Original: PKR ${c.fee.toLocaleString()}</span>
                        <label style="font-size:13px;">Discount:</label>
                        <input type="number" value="${disc}" style="width:80px; padding:4px 8px; border-radius:6px; border:1px solid #E2E8F0; font-size:13px;" 
                            oninput="updateDiscount('${c.name}', this.value)">
                        <span style="font-weight:600; color:#6D4AFF;">Final: PKR ${(c.fee - disc).toLocaleString()}</span>
                    </div>
                `;
            });
            container.innerHTML = html;
        }

        function updateDiscount(name, val) {
            courseDiscounts[name] = parseInt(val) || 0;
            const container = document.getElementById('discountSection');
            const items = container.querySelectorAll('div[style*="background:#F8FAFC;"]');
            selectedCourses.forEach((c, idx) => {
                if (c.name === name) {
                    const disc = courseDiscounts[name] || 0;
                    const span = items[idx]?.querySelector('span[style*="font-weight:600; color:#6D4AFF;"]');
                    if (span) span.textContent = 'Final: PKR ' + (c.fee - disc).toLocaleString();
                }
            });
            updateFeeSummary();
        }

        function updateFeeSummary() {
            let totalOriginal = 0, totalDiscount = 0, totalFinal = 0;
            selectedCourses.forEach(c => {
                const disc = courseDiscounts[c.name] || 0;
                totalOriginal += c.fee;
                totalDiscount += disc;
                totalFinal += (c.fee - disc);
            });
            document.getElementById('totalOriginalFee').textContent = 'PKR ' + totalOriginal.toLocaleString();
            document.getElementById('totalDiscount').textContent = 'PKR ' + totalDiscount.toLocaleString();
            document.getElementById('totalFinalFee').textContent = 'PKR ' + totalFinal.toLocaleString();
        }

        // ─── Add Enrollment ───
        document.getElementById('addEnrollmentBtn').addEventListener('click', () => {
            document.getElementById('enrollmentForm').reset();
            document.getElementById('eDate').value = new Date().toISOString().split('T')[0];
            document.getElementById('studentSearch').value = '';
            document.getElementById('selectedStudent').value = '';
            selectedStudentId = null;
            document.querySelectorAll('#studentDropdown .option').forEach(opt => opt.classList.remove('selected'));
            document.querySelectorAll('#courseSelection .course-option').forEach(opt => {
                opt.querySelector('input[type="checkbox"]').checked = false;
                opt.classList.remove('selected');
            });
            selectedCourses = [];
            courseDiscounts = {};
            renderDiscountInputs();
            updateFeeSummary();
            openModal('addEnrollmentModal');
        });

        // ─── Save Enrollment ───
        async function saveEnrollment(e) {
            e.preventDefault();
            
            const studentId = document.getElementById('selectedStudent').value;
            const date = document.getElementById('eDate').value;
            
            if (!studentId) { showToast('⚠️ Please select a student'); return; }
            if (selectedCourses.length === 0) { showToast('⚠️ Please select at least one course'); return; }
            
            // Save each selected course as a separate enrollment
            let successCount = 0;
            let errorMsg = '';
            
            for (const course of selectedCourses) {
                const disc = courseDiscounts[course.name] || 0;
                const finalFee = course.fee - disc;
                
                try {
                    const response = await fetch('{{ route("admin.enrollments.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            student_id: studentId,
                            course_id: course.id,
                            enrollment_date: date,
                            original_fee: course.fee,
                            discount: disc,
                            final_fee: finalFee,
                            status: 'active'
                        })
                    });
                    
                    const result = await response.json();
                    if (result.success) {
                        successCount++;
                    } else {
                        errorMsg = result.message || 'Error saving enrollment';
                    }
                } catch (error) {
                    errorMsg = 'Error saving enrollment';
                }
            }
            
            if (successCount > 0) {
                showToast(`✅ ${successCount} enrollment(s) completed successfully!`);
                closeModal('addEnrollmentModal');
                loadEnrollments();
            } else {
                showToast('⚠️ ' + errorMsg);
            }
        }

        // ─── View Enrollment ───
        async function viewEnrollment(id) {
            try {
                const response = await fetch(`/admin/enrollments/${id}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                const e = data.data;
                const studentName = e.student ? e.student.name : 'Unknown';
                const courseName = e.course ? e.course.name : 'Unknown';
                alert(`📋 Enrollment Details\n\nStudent: ${studentName}\nCourse: ${courseName}\nOriginal Fee: PKR ${parseFloat(e.original_fee).toLocaleString()}\nDiscount: PKR ${parseFloat(e.discount || 0).toLocaleString()}\nFinal Fee: PKR ${parseFloat(e.final_fee).toLocaleString()}\nDate: ${e.enrollment_date || '-'}\nStatus: ${e.status}`);
            } catch (error) {
                showToast('⚠️ Error loading enrollment details');
            }
        }

        // ─── Edit Enrollment ───
        async function editEnrollment(id) {
            try {
                const response = await fetch(`/admin/enrollments/${id}/edit`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                const enrollment = data.data;

                // Find and select student
                const studentOpt = document.querySelector(`#studentDropdown .option[data-id="${enrollment.student_id}"]`);
                if (studentOpt) {
                    selectStudent(enrollment.student.name, enrollment.student_id, studentOpt);
                }

                // Select course
                document.querySelectorAll('#courseSelection .course-option').forEach(opt => {
                    const cb = opt.querySelector('input[type="checkbox"]');
                    if (parseInt(cb.value) === enrollment.course_id) {
                        cb.checked = true;
                        opt.classList.add('selected');
                    } else {
                        cb.checked = false;
                        opt.classList.remove('selected');
                    }
                });
                updateCourseSelection();

                document.getElementById('eDate').value = enrollment.enrollment_date || '';
                // Set discount for the selected course
                if (enrollment.course) {
                    courseDiscounts[enrollment.course.name] = enrollment.discount || 0;
                    renderDiscountInputs();
                    updateFeeSummary();
                }
                
                // Store enrollment ID for update
                document.getElementById('enrollmentForm').dataset.editId = id;
                document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit" style="color:#6D4AFF; margin-right:10px;"></i> Edit Enrollment';
                document.querySelector('#addEnrollmentModal .btn-primary').innerHTML = '<i class="fas fa-save"></i> Update Enrollment';
                
                openModal('addEnrollmentModal');
            } catch (error) {
                showToast('⚠️ Error loading enrollment data');
            }
        }

        // ─── Delete Enrollment ───
        function deleteEnrollment(id) {
            deleteId = id;
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            deleteId = null;
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', async function() {
            if (deleteId !== null) {
                try {
                    const response = await fetch(`/admin/enrollments/${deleteId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const result = await response.json();
                    if (result.success) {
                        showToast(result.message);
                        closeDeleteModal();
                        loadEnrollments();
                    } else {
                        showToast('⚠️ ' + (result.message || 'Cannot delete enrollment'));
                        closeDeleteModal();
                    }
                } catch (error) {
                    showToast('⚠️ Error deleting enrollment');
                    closeDeleteModal();
                }
            }
        });

        // ─── Toast ───
        function showToast(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            toast.classList.add('show');
            clearTimeout(toast._timer);
            toast._timer = setTimeout(() => toast.classList.remove('show'), 3500);
        }

        // ─── Init ───
        loadEnrollments();
    </script>
</body>
</html>