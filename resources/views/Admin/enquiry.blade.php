<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leeds Academy · Enquiries Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #F5F7FA;
            color: #1E293B;
            display: flex;
            min-height: 100vh;
        }
        /* ─── SIDEBAR ─── */
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
        .sidebar-menu li { margin-bottom: 2px; }
        .sidebar-menu li a {
            display: flex; align-items: center; gap: 14px; padding: 10px 16px;
            border-radius: 12px; color: rgba(255,255,255,0.7); font-weight: 500;
            font-size: 14px; text-decoration: none; transition: all 0.15s;
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
        .sidebar-menu .sub-menu { padding-left: 24px; }
        .sidebar-menu .sub-menu li a { font-size: 13px; padding: 6px 16px; }

        .main { flex:1; background: #F5F7FA; min-height: 100vh; display: flex; flex-direction: column; }

        /* ─── TOP HEADER ─── */
        .topbar {
            background: #FFFFFF;
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
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
        .topbar-left h2 { font-weight: 600; font-size: 20px; color: #0F172A; }
        .topbar-left .breadcrumb { font-size: 13px; color: #94A3B8; margin-top: 1px; }
        .topbar-left .breadcrumb span { color: #1E293B; font-weight: 500; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .search-box {
            position: relative; background: #F5F7FA; border-radius: 30px;
            padding: 6px 14px 6px 40px; border: 1px solid transparent; transition: all 0.2s;
            display: flex; align-items: center; width: 200px;
        }
        .search-box:focus-within { border-color: #6D4AFF; background: #fff; box-shadow: 0 0 0 3px rgba(109,74,255,0.08); }
        .search-box i { position: absolute; left: 14px; color: #94A3B8; font-size: 14px; }
        .search-box input { background: transparent; border: none; padding: 6px 0; width: 100%; outline: none; font-size: 13px; font-family: 'Inter', sans-serif; }
        .notif-btn, .profile-btn {
            background: transparent; border: none; font-size: 18px; color: #64748B;
            cursor: pointer; padding: 6px; border-radius: 30px; transition: background 0.15s; position: relative;
        }
        .notif-btn:hover, .profile-btn:hover { background: #F1F5F9; }
        .notif-badge {
            position: absolute; top: 0; right: 0; background: #6D4AFF; color: #fff;
            font-size: 9px; font-weight: 700; border-radius: 30px; width: 18px; height: 18px;
            display: flex; align-items: center; justify-content: center; border: 2px solid #fff;
        }
        .profile-dropdown-wrap { position: relative; }
        .profile-btn {
            display: flex; align-items: center; gap: 8px; padding: 4px 10px 4px 4px;
            border-radius: 40px; background: #F1F5F9;
        }
        .profile-btn img { width: 32px; height: 32px; border-radius: 50%; background: #6D4AFF; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600; font-size: 12px; }
        .profile-btn span { font-weight: 500; font-size: 13px; color: #1E293B; }
        .dropdown-menu {
            position: absolute; right: 0; top: 44px; background: #fff; border-radius: 14px;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.15); min-width: 200px; padding: 8px 0;
            opacity: 0; visibility: hidden; transform: translateY(8px); transition: all 0.18s ease;
            border: 1px solid #F1F5F9;
        }
        .dropdown-menu.open { opacity: 1; visibility: visible; transform: translateY(0); }
        .dropdown-menu a {
            display: flex; align-items: center; gap: 12px; padding: 9px 18px;
            color: #1E293B; text-decoration: none; font-size: 13px; font-weight: 500; transition: background 0.1s;
        }
        .dropdown-menu a:hover { background: #F8FAFC; }
        .dropdown-menu a i { width: 18px; color: #64748B; font-size: 14px; }
        .dropdown-divider { height: 1px; background: #F1F5F9; margin: 4px 12px; }

        .content { padding: 24px 32px 40px 32px; flex:1; }

        /* ─── STATS CARDS ─── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 18px 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            border: 1px solid #F1F5F9;
            transition: all 0.2s;
            cursor: default;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .stat-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.05); transform: translateY(-2px); }
        .stat-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: #fff; flex-shrink: 0;
        }
        .stat-icon.purple { background: #6D4AFF; }
        .stat-icon.blue { background: #3B82F6; }
        .stat-icon.green { background: #10B981; }
        .stat-icon.orange { background: #F59E0B; }
        .stat-icon.teal { background: #14B8A6; }
        .stat-info h4 { font-size: 12px; font-weight: 500; color: #94A3B8; letter-spacing: 0.2px; }
        .stat-info .number { font-size: 22px; font-weight: 700; color: #0F172A; letter-spacing: -0.3px; }

        /* ─── FILTERS ─── */
        .filters-bar {
            background: #fff;
            border-radius: 14px;
            padding: 14px 20px;
            border: 1px solid #F1F5F9;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        .filters-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }
        .filters-row select, .filters-row input {
            padding: 8px 14px;
            border-radius: 30px;
            border: 1.5px solid #E2E8F0;
            background: #F8FAFC;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            color: #1E293B;
            outline: none;
            transition: 0.15s;
            min-width: 130px;
            flex: 1 1 auto;
        }
        .filters-row select:focus, .filters-row input:focus {
            border-color: #6D4AFF;
            box-shadow: 0 0 0 3px rgba(109,74,255,0.08);
        }
        .filter-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .btn-filter {
            padding: 8px 22px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 13px;
            border: none;
            cursor: pointer;
            transition: 0.15s;
            font-family: 'Inter', sans-serif;
        }
        .btn-filter.primary { background: #6D4AFF; color: #fff; }
        .btn-filter.primary:hover { background: #5a3de0; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(109,74,255,0.25); }
        .btn-filter.outline { background: transparent; border: 1.5px solid #E2E8F0; color: #475569; }
        .btn-filter.outline:hover { background: #F1F5F9; }

        /* ─── TABLE ─── */
        .table-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #F1F5F9;
            padding: 20px 24px 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            overflow-x: auto;
            margin-bottom: 24px;
        }
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
        }
        .table-header h4 { font-size: 16px; font-weight: 600; color: #0F172A; }
        .table-header .actions { display: flex; gap: 6px; flex-wrap: wrap; }
        .table-header .actions button {
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: 0.15s;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .table-header .actions .btn-refresh { background: #F1F5F9; color: #1E293B; }
        .table-header .actions .btn-refresh:hover { background: #E2E8F0; }

        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th {
            text-align: left;
            padding: 10px 8px 10px 0;
            font-weight: 600;
            color: #475569;
            border-bottom: 2px solid #E2E8F0;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        td { padding: 11px 8px 11px 0; border-bottom: 1px solid #F1F5F9; color: #1E293B; vertical-align: middle; }
        td:last-child { padding-right:0; }
        tr:hover td { background: #F8FAFC; }

        .status-badge {
            font-size: 11px; font-weight: 600; padding: 3px 14px; border-radius: 30px;
            display: inline-block;
        }
        .status-badge.new { background: #DBEAFE; color: #2563EB; }
        .status-badge.contacted { background: #FEF3C7; color: #D97706; }
        .status-badge.interested { background: #DCFCE7; color: #10B981; }
        .status-badge.converted { background: #EDE7FF; color: #6D4AFF; }
        .status-badge.closed { background: #F1F5F9; color: #64748B; }

        .action-btn {
            background: transparent; border: none; color: #94A3B8;
            padding: 4px 8px; border-radius: 6px; cursor: pointer; transition: 0.1s;
            font-size: 14px;
        }
        .action-btn:hover { background: #F1F5F9; color: #1E293B; }

        /* ─── EMPTY STATE ─── */
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #94A3B8;
        }
        .empty-state i { font-size: 60px; color: #E2E8F0; display: block; margin-bottom: 16px; }
        .empty-state h4 { font-size: 18px; color: #1E293B; margin-bottom: 4px; }
        .empty-state p { font-size: 14px; }

        /* ─── MODAL ─── */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(15,23,42,0.55);
            backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center;
            z-index: 999; padding: 20px;
        }
        .modal-overlay.active { display: flex; }
        .modal {
            background: #fff; border-radius: 24px; max-width: 820px; width: 100%;
            max-height: 92vh; overflow-y: auto; padding: 32px 36px 36px;
            box-shadow: 0 40px 80px -20px rgba(0,0,0,0.3);
            animation: modalIn 0.25s ease;
        }
        @keyframes modalIn { from { opacity:0; transform: scale(0.96) translateY(20px); } to { opacity:1; transform: scale(1) translateY(0); } }
        .modal-header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;
        }
        .modal-header h2 { font-size: 22px; font-weight: 600; color: #0F172A; }
        .modal-close { background: transparent; border: none; font-size: 24px; color: #94A3B8; cursor: pointer; padding: 6px; }
        .modal-close:hover { color: #1E293B; }

        .modal-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }
        .modal-left { /* details */ }
        .modal-right { /* timeline */ }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid #F1F5F9;
            font-size: 14px;
        }
        .detail-row .label { color: #64748B; font-weight: 500; }
        .detail-row .value { font-weight: 500; color: #1E293B; }

        .message-card {
            background: #F8FAFC;
            border-radius: 12px;
            padding: 16px 18px;
            border: 1px solid #F1F5F9;
            margin-top: 12px;
        }
        .message-card .label { font-size: 12px; color: #94A3B8; font-weight: 500; margin-bottom: 4px; }
        .message-card .text { font-size: 14px; color: #1E293B; line-height: 1.6; }

        .modal-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #F1F5F9;
        }
        .modal-actions .btn {
            padding: 8px 18px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 13px;
            border: none;
            cursor: pointer;
            transition: 0.15s;
            font-family: 'Inter', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .modal-actions .btn-primary { background: #6D4AFF; color: #fff; }
        .modal-actions .btn-primary:hover { background: #5a3de0; }
        .modal-actions .btn-success { background: #10B981; color: #fff; }
        .modal-actions .btn-success:hover { background: #0ea373; }
        .modal-actions .btn-warning { background: #F59E0B; color: #fff; }
        .modal-actions .btn-warning:hover { background: #D97706; }
        .modal-actions .btn-outline { background: transparent; border: 1.5px solid #E2E8F0; color: #475569; }
        .modal-actions .btn-outline:hover { background: #F1F5F9; }
        .modal-actions .btn-danger { background: #EF4444; color: #fff; }
        .modal-actions .btn-danger:hover { background: #DC2626; }

        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 20px;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 6px;
            top: 4px;
            bottom: 4px;
            width: 2px;
            background: #E2E8F0;
        }
        .timeline-item {
            position: relative;
            padding-bottom: 16px;
            padding-left: 20px;
        }
        .timeline-item:last-child { padding-bottom: 0; }
        .timeline-item .dot {
            position: absolute;
            left: -14px;
            top: 2px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #E2E8F0;
            border: 2px solid #fff;
        }
        .timeline-item .dot.purple { background: #6D4AFF; }
        .timeline-item .dot.green { background: #10B981; }
        .timeline-item .dot.yellow { background: #F59E0B; }
        .timeline-item .dot.blue { background: #3B82F6; }
        .timeline-item .time { font-size: 11px; color: #94A3B8; }
        .timeline-item .desc { font-size: 13px; color: #1E293B; }

        /* ─── TOAST ─── */
        .toast {
            position: fixed; bottom: 30px; right: 30px; background: #0F172A;
            color: #fff; padding: 14px 28px; border-radius: 60px;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.2);
            display: flex; align-items: center; gap: 12px; font-weight: 500; font-size: 14px;
            transform: translateY(80px); opacity: 0; transition: all 0.3s ease;
            z-index: 9999; border-left: 5px solid #6D4AFF;
        }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast i { color: #6D4AFF; font-size: 18px; }

        .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.2); z-index: 45; }
        .overlay.active { display: block; }

        @media (max-width: 992px) {
            .modal-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); width: 270px; position: fixed; top:0; left:0; height:100%; }
            .sidebar.open { transform: translateX(0); }
            .topbar-left .menu-toggle { display: block; }
            .search-box { width: 140px; }
            .content { padding: 16px; }
            .topbar { padding: 10px 16px; }
            .stats-grid { grid-template-columns: 1fr; }
            .filters-row select, .filters-row input { min-width: 100%; flex: 1 1 100%; }
            .modal { padding: 20px; }
            .modal-actions { flex-direction: column; }
            .modal-actions .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

    <div class="overlay" id="overlay"></div>

    <!-- ─── SIDEBAR ─── -->
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

    <!-- ─── MAIN ─── -->
    <div class="main">

        <!-- TOP HEADER -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
                <div>
                    <h2>Enquiries Management</h2>
                    <div class="breadcrumb">Dashboard / <span>Enquiries</span></div>
                </div>
            </div>
            <div class="topbar-right">
                <div class="search-box"><i class="fas fa-search"></i><input type="text" placeholder="Search enquiries..." /></div>
                <button class="notif-btn"><i class="fas fa-bell"></i><span class="notif-badge">3</span></button>
                <div class="profile-dropdown-wrap">
                    <button class="profile-btn" id="profileBtn"><img src="#" alt="A" style="background:#6D4AFF; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:600;"> <span>Admin</span> <i class="fas fa-chevron-down" style="font-size:11px; margin-left:4px;"></i></button>
                    <div class="dropdown-menu" id="profileDropdown">
                        <a href="#"><i class="fas fa-user"></i> My Profile</a>
                        <a href="#"><i class="fas fa-sliders-h"></i> Settings</a>
                        <a href="#"><i class="fas fa-key"></i> Change Password</a>
                        <div class="dropdown-divider"></div>
                        <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- ─── CONTENT ─── -->
        <div class="content">

            <!-- STATS -->
            <div class="stats-grid">
                <div class="stat-card"><div class="stat-icon purple"><i class="fas fa-envelope"></i></div><div class="stat-info"><h4>Total Enquiries</h4><div class="number">247</div></div></div>
                <div class="stat-card"><div class="stat-icon blue"><i class="fas fa-clock"></i></div><div class="stat-info"><h4>New Enquiries</h4><div class="number">18</div></div></div>
                <div class="stat-card"><div class="stat-icon orange"><i class="fas fa-phone"></i></div><div class="stat-info"><h4>Contacted</h4><div class="number">42</div></div></div>
                <div class="stat-card"><div class="stat-icon green"><i class="fas fa-user-check"></i></div><div class="stat-info"><h4>Converted to Student</h4><div class="number">89</div></div></div>
            </div>

            <!-- FILTERS -->
            <div class="filters-bar">
                <div class="filters-row">
                    <input type="text" placeholder="Search by name, phone or email..." style="flex:1.5; min-width:180px;">
                    <select><option>All Status</option><option>New</option><option>Contacted</option><option>Interested</option><option>Converted</option><option>Closed</option></select>
                    <input type="date" placeholder="From" style="min-width:130px;">
                    <select><option>All Courses</option><option>Web Development</option><option>Graphic Design</option><option>MS Office</option></select>
                    <div class="filter-actions">
                        <button class="btn-filter primary">Apply Filters</button>
                        <button class="btn-filter outline">Reset</button>
                    </div>
                </div>
            </div>

            <!-- TABLE -->
            <div class="table-card">
                <div class="table-header">
                    <h4><i class="fas fa-list" style="color:#6D4AFF;"></i> Enquiry List</h4>
                    <div class="actions">
                        <button class="btn-refresh" onclick="showToast('🔄 Refreshed')"><i class="fas fa-sync-alt"></i> Refresh</button>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th><th>Name</th><th>Phone</th><th>Email</th><th>Course Interest</th><th>Inquiry Date</th><th>Status</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="enquiryTableBody">
                        <tr>
                            <td>#ENQ-001</td><td><strong>Ahmed Hassan</strong></td><td>+92 300 1234</td><td>ahmed@email.com</td><td>Web Development</td><td>15 Apr 2026</td>
                            <td><span class="status-badge new">New</span></td>
                            <td>
                                <button class="action-btn" onclick="openEnquiryModal(0)" title="View Details"><i class="fas fa-eye"></i></button>
                                <button class="action-btn" onclick="showToast('📝 Edit status')" title="Edit Status"><i class="fas fa-edit"></i></button>
                                <button class="action-btn" onclick="showToast('🔄 Converting to student...')" title="Convert to Student"><i class="fas fa-user-plus"></i></button>
                                <button class="action-btn" onclick="showToast('🗑️ Deleted')" title="Delete"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#ENQ-002</td><td><strong>Fatima Noor</strong></td><td>+92 312 5678</td><td>fatima@email.com</td><td>Graphic Design</td><td>14 Apr 2026</td>
                            <td><span class="status-badge contacted">Contacted</span></td>
                            <td>
                                <button class="action-btn" onclick="openEnquiryModal(1)" title="View Details"><i class="fas fa-eye"></i></button>
                                <button class="action-btn" onclick="showToast('📝 Edit status')" title="Edit Status"><i class="fas fa-edit"></i></button>
                                <button class="action-btn" onclick="showToast('🔄 Converting to student...')" title="Convert to Student"><i class="fas fa-user-plus"></i></button>
                                <button class="action-btn" onclick="showToast('🗑️ Deleted')" title="Delete"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#ENQ-003</td><td><strong>Usman Raza</strong></td><td>+92 321 9012</td><td>usman@email.com</td><td>MS Office</td><td>12 Apr 2026</td>
                            <td><span class="status-badge interested">Interested</span></td>
                            <td>
                                <button class="action-btn" onclick="openEnquiryModal(2)" title="View Details"><i class="fas fa-eye"></i></button>
                                <button class="action-btn" onclick="showToast('📝 Edit status')" title="Edit Status"><i class="fas fa-edit"></i></button>
                                <button class="action-btn" onclick="showToast('🔄 Converting to student...')" title="Convert to Student"><i class="fas fa-user-plus"></i></button>
                                <button class="action-btn" onclick="showToast('🗑️ Deleted')" title="Delete"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#ENQ-004</td><td><strong>Sara Khan</strong></td><td>+92 334 4567</td><td>sara@email.com</td><td>SEO</td><td>10 Apr 2026</td>
                            <td><span class="status-badge converted">Converted</span></td>
                            <td>
                                <button class="action-btn" onclick="openEnquiryModal(3)" title="View Details"><i class="fas fa-eye"></i></button>
                                <button class="action-btn" onclick="showToast('📝 Edit status')" title="Edit Status"><i class="fas fa-edit"></i></button>
                                <button class="action-btn" onclick="showToast('🔄 Converting to student...')" title="Convert to Student"><i class="fas fa-user-plus"></i></button>
                                <button class="action-btn" onclick="showToast('🗑️ Deleted')" title="Delete"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#ENQ-005</td><td><strong>Navid Khan</strong></td><td>+92 345 7890</td><td>navid@email.com</td><td>Web Development</td><td>08 Apr 2026</td>
                            <td><span class="status-badge closed">Closed</span></td>
                            <td>
                                <button class="action-btn" onclick="openEnquiryModal(4)" title="View Details"><i class="fas fa-eye"></i></button>
                                <button class="action-btn" onclick="showToast('📝 Edit status')" title="Edit Status"><i class="fas fa-edit"></i></button>
                                <button class="action-btn" onclick="showToast('🔄 Converting to student...')" title="Convert to Student"><i class="fas fa-user-plus"></i></button>
                                <button class="action-btn" onclick="showToast('🗑️ Deleted')" title="Delete"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:14px; flex-wrap:wrap; gap:8px;">
                    <span style="font-size:13px; color:#94A3B8;">Showing 1-5 of 247 enquiries</span>
                    <div style="display:flex; gap:4px;">
                        <button class="btn-filter outline" style="padding:4px 14px; font-size:12px;">Prev</button>
                        <button class="btn-filter primary" style="padding:4px 14px; font-size:12px;">1</button>
                        <button class="btn-filter outline" style="padding:4px 14px; font-size:12px;">2</button>
                        <button class="btn-filter outline" style="padding:4px 14px; font-size:12px;">3</button>
                        <button class="btn-filter outline" style="padding:4px 14px; font-size:12px;">Next</button>
                    </div>
                </div>
            </div>

        </div><!-- /content -->
    </div><!-- /main -->

    <!-- ─── ENQUIRY DETAILS MODAL ─── -->
    <div class="modal-overlay" id="enquiryModal">
        <div class="modal">
            <div class="modal-header">
                <h2><i class="fas fa-user-circle" style="color:#6D4AFF;"></i> Enquiry Details</h2>
                <button class="modal-close" onclick="closeModal('enquiryModal')"><i class="fas fa-times"></i></button>
            </div>

            <div class="modal-grid">
                <!-- LEFT: Details -->
                <div class="modal-left">
                    <div class="detail-row"><span class="label">Full Name</span><span class="value" id="modalName">Ahmed Hassan</span></div>
                    <div class="detail-row"><span class="label">Phone Number</span><span class="value" id="modalPhone">+92 300 1234</span></div>
                    <div class="detail-row"><span class="label">Email Address</span><span class="value" id="modalEmail">ahmed@email.com</span></div>
                    <div class="detail-row"><span class="label">Interested Course</span><span class="value" id="modalCourse">Web Development</span></div>
                    <div class="detail-row"><span class="label">Inquiry Date</span><span class="value" id="modalDate">15 Apr 2026</span></div>
                    <div class="detail-row"><span class="label">Source</span><span class="value">Website Contact Form</span></div>
                    <div class="detail-row"><span class="label">Status</span><span class="value" id="modalStatus"><span class="status-badge new">New</span></span></div>

                    <div class="message-card">
                        <div class="label">Message</div>
                        <div class="text" id="modalMessage">
                            "I want to join the Web Development course. Please provide details about fee structure, duration and class timings."
                        </div>
                    </div>

                    <div class="modal-actions">
                        <button class="btn btn-warning" onclick="updateStatus('contacted')"><i class="fas fa-phone"></i> Mark Contacted</button>
                        <button class="btn btn-success" onclick="updateStatus('interested')"><i class="fas fa-star"></i> Mark Interested</button>
                        <button class="btn btn-primary" onclick="convertToStudent()"><i class="fas fa-user-plus"></i> Convert to Student</button>
                        <button class="btn btn-outline" onclick="updateStatus('closed')"><i class="fas fa-check-circle"></i> Close</button>
                        <button class="btn btn-danger" onclick="showToast('🗑️ Deleted')"><i class="fas fa-trash"></i> Delete</button>
                    </div>
                </div>

                <!-- RIGHT: Timeline -->
                <div class="modal-right">
                    <h4 style="font-size:15px; font-weight:600; margin-bottom:14px; color:#0F172A;"><i class="fas fa-history" style="color:#6D4AFF;"></i> Activity Timeline</h4>
                    <div class="timeline" id="modalTimeline">
                        <div class="timeline-item">
                            <div class="dot blue"></div>
                            <div class="time">15 Apr 2026, 10:30 AM</div>
                            <div class="desc">Inquiry Received via Website</div>
                        </div>
                        <div class="timeline-item">
                            <div class="dot yellow"></div>
                            <div class="time">15 Apr 2026, 02:15 PM</div>
                            <div class="desc">Contacted by Admin</div>
                        </div>
                        <div class="timeline-item">
                            <div class="dot purple"></div>
                            <div class="time">16 Apr 2026, 11:00 AM</div>
                            <div class="desc">Marked as Interested</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ─── TOAST ─── -->
    <div class="toast" id="toast"><i class="fas fa-check-circle"></i> <span id="toastMsg">Action completed</span></div>

    <script>
        // ─── Enquiry Data ───
        const enquiryData = [
            { name: 'Ahmed Hassan', phone: '+92 300 1234', email: 'ahmed@email.com', course: 'Web Development', date: '15 Apr 2026', status: 'new', message: '"I want to join the Web Development course. Please provide details about fee structure, duration and class timings."', timeline: [
                { time: '15 Apr 2026, 10:30 AM', desc: 'Inquiry Received via Website', dot: 'blue' },
                { time: '15 Apr 2026, 02:15 PM', desc: 'Contacted by Admin', dot: 'yellow' }
            ]},
            { name: 'Fatima Noor', phone: '+92 312 5678', email: 'fatima@email.com', course: 'Graphic Design', date: '14 Apr 2026', status: 'contacted', message: '"I am interested in the Graphic Design course. Please send me the course outline and fee details."', timeline: [
                { time: '14 Apr 2026, 09:00 AM', desc: 'Inquiry Received via Website', dot: 'blue' },
                { time: '14 Apr 2026, 11:30 AM', desc: 'Contacted by Admin', dot: 'yellow' }
            ]},
            { name: 'Usman Raza', phone: '+92 321 9012', email: 'usman@email.com', course: 'MS Office', date: '12 Apr 2026', status: 'interested', message: '"I need to learn MS Office for my job. Please tell me about the schedule and fees."', timeline: [
                { time: '12 Apr 2026, 08:45 AM', desc: 'Inquiry Received via Website', dot: 'blue' },
                { time: '12 Apr 2026, 01:00 PM', desc: 'Contacted by Admin', dot: 'yellow' },
                { time: '13 Apr 2026, 10:00 AM', desc: 'Marked as Interested', dot: 'purple' }
            ]},
            { name: 'Sara Khan', phone: '+92 334 4567', email: 'sara@email.com', course: 'SEO', date: '10 Apr 2026', status: 'converted', message: '"I want to learn SEO and Digital Marketing. Please provide complete details."', timeline: [
                { time: '10 Apr 2026, 11:20 AM', desc: 'Inquiry Received via Website', dot: 'blue' },
                { time: '10 Apr 2026, 03:00 PM', desc: 'Contacted by Admin', dot: 'yellow' },
                { time: '11 Apr 2026, 09:00 AM', desc: 'Marked as Interested', dot: 'purple' },
                { time: '12 Apr 2026, 02:00 PM', desc: 'Converted to Student', dot: 'green' }
            ]},
            { name: 'Navid Khan', phone: '+92 345 7890', email: 'navid@email.com', course: 'Web Development', date: '08 Apr 2026', status: 'closed', message: '"I would like to join the Web Development course but need to confirm my schedule."', timeline: [
                { time: '08 Apr 2026, 10:00 AM', desc: 'Inquiry Received via Website', dot: 'blue' },
                { time: '08 Apr 2026, 12:30 PM', desc: 'Contacted by Admin', dot: 'yellow' },
                { time: '09 Apr 2026, 11:00 AM', desc: 'Enquiry Closed', dot: 'gray' }
            ]}
        ];

        let currentEnquiryIndex = 0;

        // ─── Open Enquiry Modal ───
        function openEnquiryModal(index) {
            currentEnquiryIndex = index;
            const data = enquiryData[index];
            if (!data) return;

            document.getElementById('modalName').textContent = data.name;
            document.getElementById('modalPhone').textContent = data.phone;
            document.getElementById('modalEmail').textContent = data.email;
            document.getElementById('modalCourse').textContent = data.course;
            document.getElementById('modalDate').textContent = data.date;
            document.getElementById('modalMessage').textContent = data.message;

            // Status badge
            const statusMap = {
                new: '<span class="status-badge new">New</span>',
                contacted: '<span class="status-badge contacted">Contacted</span>',
                interested: '<span class="status-badge interested">Interested</span>',
                converted: '<span class="status-badge converted">Converted</span>',
                closed: '<span class="status-badge closed">Closed</span>'
            };
            document.getElementById('modalStatus').innerHTML = statusMap[data.status] || statusMap.new;

            // Timeline
            const timelineContainer = document.getElementById('modalTimeline');
            timelineContainer.innerHTML = data.timeline.map(item => `
                <div class="timeline-item">
                    <div class="dot ${item.dot}"></div>
                    <div class="time">${item.time}</div>
                    <div class="desc">${item.desc}</div>
                </div>
            `).join('');

            document.getElementById('enquiryModal').classList.add('active');
        }

        // ─── Close Modal ───
        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        // ─── Update Status ───
        function updateStatus(status) {
            const data = enquiryData[currentEnquiryIndex];
            if (!data) return;
            data.status = status;
            
            // Add timeline entry
            const statusLabels = {
                contacted: 'Contacted by Admin',
                interested: 'Marked as Interested',
                converted: 'Converted to Student',
                closed: 'Enquiry Closed'
            };
            const dotColors = {
                contacted: 'yellow',
                interested: 'purple',
                converted: 'green',
                closed: 'gray'
            };
            const now = new Date();
            const timeStr = now.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) + ', ' + 
                           now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
            
            data.timeline.push({
                time: timeStr,
                desc: statusLabels[status] || status,
                dot: dotColors[status] || 'blue'
            });

            // Reopen modal to refresh
            closeModal('enquiryModal');
            setTimeout(() => openEnquiryModal(currentEnquiryIndex), 200);
            showToast('✅ Status updated to ' + status.charAt(0).toUpperCase() + status.slice(1));
            
            // Update table row status
            updateTableRow(currentEnquiryIndex, status);
        }

        // ─── Update Table Row ───
        function updateTableRow(index, status) {
            const rows = document.querySelectorAll('#enquiryTableBody tr');
            if (rows[index]) {
                const statusCell = rows[index].querySelectorAll('td')[6];
                const statusMap = {
                    new: '<span class="status-badge new">New</span>',
                    contacted: '<span class="status-badge contacted">Contacted</span>',
                    interested: '<span class="status-badge interested">Interested</span>',
                    converted: '<span class="status-badge converted">Converted</span>',
                    closed: '<span class="status-badge closed">Closed</span>'
                };
                statusCell.innerHTML = statusMap[status] || statusMap.new;
            }
        }

        // ─── Convert to Student ───
        function convertToStudent() {
            const data = enquiryData[currentEnquiryIndex];
            if (!data) return;
            
            // Update status
            updateStatus('converted');
            
            // Auto-fill student registration (simulated)
            setTimeout(() => {
                showToast('🎓 Student registration opened with pre-filled data from enquiry!');
                // In a real system, this would open the student registration modal
            }, 500);
        }

        // ─── Toast ───
        function showToast(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            toast.classList.add('show');
            clearTimeout(toast._timer);
            toast._timer = setTimeout(() => toast.classList.remove('show'), 3500);
        }

        // ─── Sidebar Toggle ───
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

        // ─── Filter Buttons ───
        document.querySelectorAll('.btn-filter.primary').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.textContent.includes('Apply')) {
                    showToast('✅ Filters applied successfully');
                }
            });
        });
        document.querySelectorAll('.btn-filter.outline').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.textContent.includes('Reset')) {
                    showToast('🔄 Filters reset');
                }
            });
        });

        // ─── Modal Overlay Close ───
        document.getElementById('enquiryModal').addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('active');
        });
    </script>

</body>
</html>