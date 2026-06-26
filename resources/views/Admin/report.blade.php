<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leeds Academy · Financial Reports</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <style>
        /* All existing styles remain the same */
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

        .report-tabs {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-bottom: 24px;
            background: #fff;
            padding: 6px;
            border-radius: 14px;
            border: 1px solid #F1F5F9;
        }
        .report-tab {
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            border: none;
            cursor: pointer;
            transition: 0.15s;
            font-family: 'Inter', sans-serif;
            background: transparent;
            color: #64748B;
        }
        .report-tab:hover { background: #F1F5F9; color: #1E293B; }
        .report-tab.active { background: #6D4AFF; color: #fff; box-shadow: 0 4px 12px rgba(109,74,255,0.2); }

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
        .stat-icon.red { background: #EF4444; }
        .stat-info h4 { font-size: 12px; font-weight: 500; color: #94A3B8; letter-spacing: 0.2px; }
        .stat-info .number { font-size: 22px; font-weight: 700; color: #0F172A; letter-spacing: -0.3px; }
        .stat-info .number small { font-size: 13px; font-weight: 500; color: #94A3B8; }

        .filters-bar {
            background: #fff;
            border-radius: 14px;
            padding: 16px 20px;
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
            min-width: 120px;
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
        .table-header .actions { display: flex; gap: 8px; flex-wrap: wrap; }
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
        .table-header .actions .btn-print { background: #F1F5F9; color: #1E293B; }
        .table-header .actions .btn-print:hover { background: #E2E8F0; }
        .table-header .actions .btn-pdf { background: #FEE2E2; color: #DC2626; }
        .table-header .actions .btn-pdf:hover { background: #FECACA; }

        .table-wrapper {
            max-height: 500px;
            overflow-y: auto;
            position: relative;
        }
        .table-wrapper table thead {
            position: sticky;
            top: 0;
            z-index: 10;
            background: #fff;
        }
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
            background: #fff;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        td { padding: 11px 8px 11px 0; border-bottom: 1px solid #F1F5F9; color: #1E293B; vertical-align: middle; }
        td:last-child { padding-right:0; }
        tr:hover td { background: #F8FAFC; }

        .status-badge {
            font-size: 11px; font-weight: 600; padding: 3px 14px; border-radius: 30px;
            display: inline-block;
        }
        .status-badge.paid { background: #DCFCE7; color: #10B981; }
        .status-badge.partial { background: #FEF3C7; color: #D97706; }
        .status-badge.unpaid { background: #FEE2E2; color: #DC2626; }
        .status-badge.overdue { background: #FEE2E2; color: #DC2626; }

        .action-btn {
            background: transparent; border: none; color: #94A3B8;
            padding: 4px 8px; border-radius: 6px; cursor: pointer; transition: 0.1s;
            font-size: 14px;
        }
        .action-btn:hover { background: #F1F5F9; color: #1E293B; }

        .report-totals {
            display: flex;
            flex-wrap: wrap;
            gap: 20px 40px;
            padding: 14px 18px;
            background: #F8FAFC;
            border-radius: 12px;
            border: 1px solid #F1F5F9;
            margin-top: 16px;
        }
        .report-totals .item { display: flex; flex-direction: column; }
        .report-totals .item .label { font-size: 12px; color: #94A3B8; font-weight: 500; }
        .report-totals .item .value { font-size: 17px; font-weight: 700; color: #0F172A; }

        .collection-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }
        .collection-card {
            background: #fff;
            border-radius: 14px;
            padding: 18px 20px;
            border: 1px solid #F1F5F9;
            text-align: center;
        }
        .collection-card .number { font-size: 24px; font-weight: 700; color: #0F172A; }
        .collection-card .label { font-size: 12px; color: #94A3B8; margin-top: 2px; }

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

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #6D4AFF;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        @media print {
            body * { visibility: hidden; }
            .print-report, .print-report * { visibility: visible; }
            .print-report {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 20px 30px;
                background: #fff;
            }
            .print-report .print-header {
                text-align: center;
                border-bottom: 2px solid #071B3B;
                padding-bottom: 12px;
                margin-bottom: 16px;
            }
            .print-report .print-header h2 { font-size: 22px; color: #071B3B; }
            .print-report .print-header p { font-size: 12px; color: #64748B; }
            .print-report table { font-size: 11px; }
            .print-report table th { background: #F1F5F9; }
            .print-report .print-footer {
                text-align: center;
                font-size: 10px;
                color: #94A3B8;
                border-top: 1px solid #E2E8F0;
                padding-top: 10px;
                margin-top: 16px;
            }
            .print-report .print-footer .page-number:after { content: " - Page " counter(page); }
            .print-report .no-print { display: none !important; }
            .sidebar, .topbar, .filters-bar, .report-tabs, .stats-grid, .table-header .actions, .action-btn { display: none !important; }
        }

        @media (max-width: 1200px) {
            .collection-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 992px) {
            .stats-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); width: 270px; position: fixed; top:0; left:0; height:100%; }
            .sidebar.open { transform: translateX(0); }
            .topbar-left .menu-toggle { display: block; }
            .search-box { width: 140px; }
            .content { padding: 16px; }
            .topbar { padding: 10px 16px; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .filters-row select, .filters-row input { min-width: 100%; flex: 1 1 100%; }
            .collection-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
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
                    <h2>Financial Reports</h2>
                    <div class="breadcrumb">Dashboard / Reports / <span id="breadcrumbReport">Financial Reports</span></div>
                </div>
            </div>
            <div class="topbar-right">
                <div class="search-box"><i class="fas fa-search"></i><input type="text" id="searchInput" placeholder="Search..." onkeyup="applyFilters()" /></div>
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

            <!-- REPORT TABS -->
            <div class="report-tabs" id="reportTabs">
                <button class="report-tab {{ $reportType == 'fee' ? 'active' : '' }}" data-report="fee" onclick="loadReport('fee')">
                    <i class="fas fa-file-invoice"></i> Student Fee Report
                </button>
                <button class="report-tab {{ $reportType == 'remaining' ? 'active' : '' }}" data-report="remaining" onclick="loadReport('remaining')">
                    <i class="fas fa-exclamation-triangle"></i> Remaining Fee
                </button>
                <button class="report-tab {{ $reportType == 'monthly' ? 'active' : '' }}" data-report="monthly" onclick="loadReport('monthly')">
                    <i class="fas fa-calendar-alt"></i> Monthly Collection
                </button>
                <button class="report-tab {{ $reportType == 'weekly' ? 'active' : '' }}" data-report="weekly" onclick="loadReport('weekly')">
                    <i class="fas fa-calendar-week"></i> Weekly Collection
                </button>
                <button class="report-tab {{ $reportType == 'daily' ? 'active' : '' }}" data-report="daily" onclick="loadReport('daily')">
                    <i class="fas fa-calendar-day"></i> Daily Collection
                </button>
            </div>

            <!-- STATS -->
            <div class="stats-grid" id="statsGrid">
                <div class="stat-card">
                    <div class="stat-icon purple"><i class="fas fa-users"></i></div>
                    <div class="stat-info">
                        <h4>Total Students</h4>
                        <div class="number" id="statStudents">{{ number_format($stats['total_students'] ?? 0) }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fas fa-dollar-sign"></i></div>
                    <div class="stat-info">
                        <h4>Total Fee</h4>
                        <div class="number" id="statTotalFee">PKR {{ number_format($stats['total_fee'] ?? 0) }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-info">
                        <h4>Total Paid</h4>
                        <div class="number" id="statTotalPaid">PKR {{ number_format($stats['total_paid'] ?? 0) }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="stat-info">
                        <h4>Total Remaining</h4>
                        <div class="number" id="statTotalRemaining">PKR {{ number_format($stats['total_remaining'] ?? 0) }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon teal"><i class="fas fa-calendar-alt"></i></div>
                    <div class="stat-info">
                        <h4>Monthly Collection</h4>
                        <div class="number" id="statMonthlyCollection">PKR {{ number_format($stats['monthly_collection'] ?? 0) }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon red"><i class="fas fa-clock"></i></div>
                    <div class="stat-info">
                        <h4>Overdue Students</h4>
                        <div class="number" id="statOverdue">{{ number_format($stats['overdue_students'] ?? 0) }}</div>
                    </div>
                </div>
            </div>

            <!-- FILTERS -->
            <div class="filters-bar">
                <div class="filters-row">
                    <input type="text" id="filterStudent" placeholder="Search Student..." style="flex:1.5; min-width:150px;" onkeyup="applyFilters()">
                    <input type="text" id="filterRegNo" placeholder="Registration No..." style="flex:1; min-width:120px;" onkeyup="applyFilters()">
                    <select id="filterCourse" onchange="applyFilters()">
                        <option value="">All Courses</option>
                        @foreach($courses ?? [] as $course)
                            <option value="{{ $course }}">{{ $course }}</option>
                        @endforeach
                    </select>
                    <select id="filterStatus" onchange="applyFilters()">
                        <option value="">All Status</option>
                        <option value="paid">Paid</option>
                        <option value="partial">Partial</option>
                        <option value="unpaid">Unpaid</option>
                        <option value="overdue">Overdue</option>
                    </select>
                    <div class="filter-actions">
                        <button class="btn-filter primary" onclick="applyFilters()"><i class="fas fa-filter"></i> Apply Filters</button>
                        <button class="btn-filter outline" onclick="resetFilters()"><i class="fas fa-redo"></i> Reset</button>
                    </div>
                </div>
            </div>

            <!-- ===== REPORT TABLE ===== -->
            <div class="table-card print-report" id="reportContent">
                <div class="table-header no-print">
                    <h4><i class="fas fa-file-invoice" style="color:#6D4AFF;"></i> <span id="reportTitle">{{ $reportTitle ?? 'Student Fee Report' }}</span></h4>
                    <div class="actions no-print">
                        <button class="btn-print" onclick="printReport()"><i class="fas fa-print"></i> Print</button>
                        <button class="btn-pdf" onclick="exportPDF()"><i class="fas fa-file-pdf"></i> PDF</button>
                    </div>
                </div>

                <!-- Print Header -->
                <div class="print-header no-print" style="display:none;">
                    <h2>Leeds Academy</h2>
                    <p><span id="printReportTitle">{{ $reportTitle ?? 'Student Fee Report' }}</span> • Generated by: Admin • <span id="printDate"></span> • <span id="printTime"></span></p>
                </div>

                <div id="loadingIndicator" style="display:none; text-align:center; padding:30px;">
                    <div class="loading-spinner"></div>
                    <p style="margin-top:10px; color:#64748B;">Loading report data...</p>
                </div>

                <div class="table-wrapper" id="tableWrapper">
                    <table id="reportTable">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Course</th>
                                <th>Original Fee</th>
                                <th>Discount</th>
                                <th>Final Fee</th>
                                <th>Paid</th>
                                <th>Remaining</th>
                                <th>Last Payment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse($reportData as $row)
                            <tr>
                                <td>{{ $row->student_id ?? 'N/A' }}</td>
                                <td>{{ $row->student_name ?? 'N/A' }}</td>
                                <td>{{ $row->course_name ?? 'N/A' }}</td>
                                <td>PKR {{ number_format($row->original_fee ?? 0) }}</td>
                                <td>PKR {{ number_format($row->discount ?? 0) }}</td>
                                <td>PKR {{ number_format($row->final_fee ?? 0) }}</td>
                                <td>PKR {{ number_format($row->paid ?? 0) }}</td>
                                <td>PKR {{ number_format($row->remaining ?? 0) }}</td>
                                <td>{{ $row->last_payment ?? 'N/A' }}</td>
                                <td>
                                    <span class="status-badge {{ $row->status ?? 'unpaid' }}">
                                        {{ ucfirst($row->status ?? 'Unpaid') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" style="text-align:center; padding:40px; color:#94A3B8;">
                                    <i class="fas fa-inbox" style="font-size:24px; display:block; margin-bottom:8px;"></i>
                                    No records found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- TOTALS -->
                <div class="report-totals" id="reportTotals">
                    <div class="item">
                        <span class="label">Total Students</span>
                        <span class="value" id="totalStudents">{{ $reportData->count() ?? 0 }}</span>
                    </div>
                    <div class="item">
                        <span class="label">Total Final Fee</span>
                        <span class="value" id="totalFinalFee">PKR {{ number_format($totals['final_fee'] ?? 0) }}</span>
                    </div>
                    <div class="item">
                        <span class="label">Total Paid</span>
                        <span class="value" id="totalPaid">PKR {{ number_format($totals['paid'] ?? 0) }}</span>
                    </div>
                    <div class="item">
                        <span class="label">Total Remaining</span>
                        <span class="value" id="totalRemaining">PKR {{ number_format($totals['remaining'] ?? 0) }}</span>
                    </div>
                </div>

                <!-- Print Footer -->
                <div class="print-footer no-print" style="display:none;">
                    <span>Leeds Academy • <span id="printFooterReport">{{ $reportTitle ?? 'Student Fee Report' }}</span> • Generated: <span id="printFooterDate"></span> • <span class="page-number"></span></span>
                </div>
            </div>

            <!-- COLLECTION REPORTS -->
            <div class="collection-grid" id="collectionGrid">
                <div class="collection-card">
                    <div class="number" id="collectionStudents">{{ number_format($stats['total_students'] ?? 0) }}</div>
                    <div class="label">Students</div>
                </div>
                <div class="collection-card">
                    <div class="number" id="collectionTotal">PKR {{ number_format($stats['monthly_collection'] ?? 0) }}</div>
                    <div class="label">Total Collection</div>
                </div>
                <div class="collection-card">
                    <div class="number" id="collectionAverage">PKR {{ number_format($stats['average_collection'] ?? 0) }}</div>
                    <div class="label">Average Collection</div>
                </div>
            </div>

        </div><!-- /content -->
    </div><!-- /main -->

    <!-- ─── TOAST ─── -->
    <div class="toast" id="toast"><i class="fas fa-check-circle"></i> <span id="toastMsg">Action completed</span></div>

    <script>
        // ─── Get CSRF Token ───
        function getCSRFToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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

        // ─── Toast ───
        function showToast(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            toast.classList.add('show');
            clearTimeout(toast._timer);
            toast._timer = setTimeout(() => toast.classList.remove('show'), 3500);
        }

        // ─── Load Report via AJAX ───
        async function loadReport(reportType) {
            const loading = document.getElementById('loadingIndicator');
            loading.style.display = 'block';
            document.getElementById('tableWrapper').style.opacity = '0.3';

            // Update active tab
            document.querySelectorAll('.report-tab').forEach(t => t.classList.remove('active'));
            document.querySelector(`.report-tab[data-report="${reportType}"]`).classList.add('active');

            try {
                const response = await fetch(`/admin/reports/${reportType}/data`, {
                    headers: {
                        'X-CSRF-TOKEN': getCSRFToken(),
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Failed to load report');

                const data = await response.json();

                // Update stats
                if (data.stats) {
                    document.getElementById('statStudents').textContent = data.stats.total_students?.toLocaleString() || '0';
                    document.getElementById('statTotalFee').textContent = 'PKR ' + (data.stats.total_fee?.toLocaleString() || '0');
                    document.getElementById('statTotalPaid').textContent = 'PKR ' + (data.stats.total_paid?.toLocaleString() || '0');
                    document.getElementById('statTotalRemaining').textContent = 'PKR ' + (data.stats.total_remaining?.toLocaleString() || '0');
                    document.getElementById('statMonthlyCollection').textContent = 'PKR ' + (data.stats.monthly_collection?.toLocaleString() || '0');
                    document.getElementById('statOverdue').textContent = data.stats.overdue_students?.toLocaleString() || '0';
                    
                    document.getElementById('collectionStudents').textContent = data.stats.total_students?.toLocaleString() || '0';
                    document.getElementById('collectionTotal').textContent = 'PKR ' + (data.stats.monthly_collection?.toLocaleString() || '0');
                    document.getElementById('collectionAverage').textContent = 'PKR ' + (data.stats.average_collection?.toLocaleString() || '0');
                }

                // Update table
                const tbody = document.getElementById('tableBody');
                tbody.innerHTML = '';

                if (data.reportData && data.reportData.length > 0) {
                    data.reportData.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.student_id || 'N/A'}</td>
                            <td>${row.student_name || 'N/A'}</td>
                            <td>${row.course_name || 'N/A'}</td>
                            <td>PKR ${(row.original_fee || 0).toLocaleString()}</td>
                            <td>PKR ${(row.discount || 0).toLocaleString()}</td>
                            <td>PKR ${(row.final_fee || 0).toLocaleString()}</td>
                            <td>PKR ${(row.paid || 0).toLocaleString()}</td>
                            <td>PKR ${(row.remaining || 0).toLocaleString()}</td>
                            <td>${row.last_payment || 'N/A'}</td>
                            <td><span class="status-badge ${row.status || 'unpaid'}">${(row.status || 'Unpaid').charAt(0).toUpperCase() + (row.status || 'unpaid').slice(1)}</span></td>
                        `;
                        tbody.appendChild(tr);
                    });
                } else {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="10" style="text-align:center; padding:40px; color:#94A3B8;">
                                <i class="fas fa-inbox" style="font-size:24px; display:block; margin-bottom:8px;"></i>
                                No records found
                            </td>
                        </tr>
                    `;
                }

                // Update totals
                if (data.totals) {
                    document.getElementById('totalStudents').textContent = data.reportData?.length || 0;
                    document.getElementById('totalFinalFee').textContent = 'PKR ' + (data.totals.final_fee?.toLocaleString() || '0');
                    document.getElementById('totalPaid').textContent = 'PKR ' + (data.totals.paid?.toLocaleString() || '0');
                    document.getElementById('totalRemaining').textContent = 'PKR ' + (data.totals.remaining?.toLocaleString() || '0');
                }

                // Update title
                const titles = {
                    'fee': 'Student Fee Report',
                    'remaining': 'Remaining Fee Report',
                    'monthly': 'Monthly Collection Report',
                    'weekly': 'Weekly Collection Report',
                    'daily': 'Daily Collection Report'
                };
                document.getElementById('reportTitle').textContent = titles[reportType] || 'Student Fee Report';
                document.getElementById('printReportTitle').textContent = titles[reportType] || 'Student Fee Report';
                document.getElementById('printFooterReport').textContent = titles[reportType] || 'Student Fee Report';
                document.getElementById('breadcrumbReport').textContent = titles[reportType] || 'Financial Reports';

                showToast('✅ ' + (titles[reportType] || 'Report') + ' loaded successfully!');

            } catch (error) {
                console.error('Error:', error);
                showToast('⚠️ Failed to load report data');
            } finally {
                loading.style.display = 'none';
                document.getElementById('tableWrapper').style.opacity = '1';
            }
        }

        // ─── Apply Filters ───
        function applyFilters() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const student = document.getElementById('filterStudent').value.toLowerCase();
            const regNo = document.getElementById('filterRegNo').value.toLowerCase();
            const course = document.getElementById('filterCourse').value;
            const status = document.getElementById('filterStatus').value;

            const rows = document.querySelectorAll('#tableBody tr');
            let visibleCount = 0;

            rows.forEach(row => {
                if (row.querySelector('td[colspan]')) return; // Skip "no records" row
                
                const cells = row.querySelectorAll('td');
                if (cells.length < 10) return;

                const studentName = cells[1]?.textContent?.toLowerCase() || '';
                const studentId = cells[0]?.textContent?.toLowerCase() || '';
                const courseName = cells[2]?.textContent || '';
                const statusText = cells[9]?.textContent?.toLowerCase().trim() || '';

                let show = true;

                if (search && !studentName.includes(search) && !studentId.includes(search)) show = false;
                if (student && !studentName.includes(student)) show = false;
                if (regNo && !studentId.includes(regNo)) show = false;
                if (course && courseName !== course) show = false;
                if (status && statusText !== status) show = false;

                row.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });

            // Update total count
            document.getElementById('totalStudents').textContent = visibleCount;

            // Recalculate totals for visible rows
            let totalFinal = 0, totalPaid = 0, totalRemaining = 0;
            rows.forEach(row => {
                if (row.style.display === 'none' || row.querySelector('td[colspan]')) return;
                const cells = row.querySelectorAll('td');
                if (cells.length < 10) return;
                
                const finalFee = parseInt(cells[5]?.textContent?.replace(/[^0-9]/g, '') || '0');
                const paid = parseInt(cells[6]?.textContent?.replace(/[^0-9]/g, '') || '0');
                const remaining = parseInt(cells[7]?.textContent?.replace(/[^0-9]/g, '') || '0');
                totalFinal += finalFee;
                totalPaid += paid;
                totalRemaining += remaining;
            });

            document.getElementById('totalFinalFee').textContent = 'PKR ' + totalFinal.toLocaleString();
            document.getElementById('totalPaid').textContent = 'PKR ' + totalPaid.toLocaleString();
            document.getElementById('totalRemaining').textContent = 'PKR ' + totalRemaining.toLocaleString();

            showToast('✅ Filters applied');
        }

        // ─── Reset Filters ───
        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('filterStudent').value = '';
            document.getElementById('filterRegNo').value = '';
            document.getElementById('filterCourse').value = '';
            document.getElementById('filterStatus').value = '';
            applyFilters();
            showToast('🔄 Filters reset');
        }

        // ─── Print Report ───
        function printReport() {
            const content = document.getElementById('reportContent');
            const now = new Date();
            const dateStr = now.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            const timeStr = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
            
            document.getElementById('printDate').textContent = dateStr;
            document.getElementById('printTime').textContent = timeStr;
            document.getElementById('printFooterDate').textContent = dateStr + ' ' + timeStr;
            
            document.querySelectorAll('.print-header, .print-footer').forEach(el => el.style.display = 'block');
            document.querySelectorAll('.no-print').forEach(el => el.style.display = 'none');
            
            window.print();
            
            setTimeout(() => {
                document.querySelectorAll('.print-header, .print-footer').forEach(el => el.style.display = 'none');
                document.querySelectorAll('.no-print').forEach(el => el.style.display = '');
            }, 500);
        }

        // ─── PDF Export ───
        function exportPDF() {
            showToast('📄 Generating PDF...');
            const reportType = document.querySelector('.report-tab.active')?.dataset?.report || 'fee';
            window.location.href = `/admin/reports/export/${reportType}`;
            setTimeout(() => showToast('✅ PDF exported successfully!'), 1500);
        }
    </script>

</body>
</html>