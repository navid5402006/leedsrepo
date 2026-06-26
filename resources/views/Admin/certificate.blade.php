<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Leeds Academy · Certificate Management</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
  <style>
    /* All styles remain the same */
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family: 'Inter', sans-serif; background: #F5F7FA; color: #1E293B; display: flex; min-height: 100vh; }
    .sidebar { width: 280px; background: #071B3B; color: #fff; display: flex; flex-direction: column; flex-shrink: 0; position: sticky; top: 0; height: 100vh; overflow-y: auto; padding: 24px 18px 30px 18px; transition: transform 0.25s ease; z-index: 50; box-shadow: 4px 0 20px rgba(0,0,0,0.08); }
    .sidebar-brand { display: flex; align-items: center; gap: 12px; margin-bottom: 40px; padding-left: 6px; }
    .sidebar-brand .logo-icon { background: rgba(255,255,255,0.06); width: 42px; height: 42px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; color: #6D4AFF; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }
    .sidebar-brand span { font-weight: 700; font-size: 20px; letter-spacing: -0.3px; }
    .sidebar-brand span small { color: #6D4AFF; }
    .sidebar-menu { list-style: none; flex:1; }
    .sidebar-menu li { margin-bottom: 4px; }
    .sidebar-menu li a { display: flex; align-items: center; gap: 14px; padding: 12px 16px; border-radius: 12px; color: rgba(255,255,255,0.7); font-weight: 500; font-size: 15px; text-decoration: none; transition: all 0.15s; }
    .sidebar-menu li a i { width: 22px; font-size: 16px; text-align: center; color: rgba(255,255,255,0.5); transition: color 0.15s; }
    .sidebar-menu li a:hover { background: rgba(255,255,255,0.06); color: #fff; }
    .sidebar-menu li a:hover i { color: #fff; }
    .sidebar-menu li.active a { background: rgba(109,74,255,0.2); color: #fff; font-weight: 600; }
    .sidebar-menu li.active a i { color: #6D4AFF; }

    .main { flex:1; background: #F5F7FA; min-height: 100vh; display: flex; flex-direction: column; }
    .topbar { background: #FFFFFF; padding: 16px 32px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; border-bottom: 1px solid #F1F5F9; position: sticky; top: 0; z-index: 40; box-shadow: 0 1px 4px rgba(0,0,0,0.02); }
    .topbar-left { display: flex; align-items: center; gap: 16px; }
    .topbar-left .menu-toggle { background: transparent; border: none; font-size: 20px; color: #1E293B; cursor: pointer; display: none; padding: 6px 8px; border-radius: 8px; }
    .topbar-left .menu-toggle:hover { background: #F1F5F9; }
    .topbar-left .breadcrumb { font-size: 14px; color: #64748B; }
    .topbar-left .breadcrumb span { color: #1E293B; font-weight: 500; }
    .topbar-left h2 { font-weight: 600; font-size: 22px; letter-spacing: -0.3px; color: #1E293B; margin-right: 8px; }
    .topbar-right { display: flex; align-items: center; gap: 18px; }
    .search-box { position: relative; background: #F5F7FA; border-radius: 30px; padding: 6px 14px 6px 40px; border: 1px solid transparent; transition: all 0.2s; display: flex; align-items: center; width: 220px; }
    .search-box:focus-within { border-color: #6D4AFF; background: #fff; box-shadow: 0 0 0 3px rgba(109,74,255,0.08); }
    .search-box i { position: absolute; left: 14px; color: #94A3B8; }
    .search-box input { background: transparent; border: none; padding: 8px 0; width: 100%; outline: none; font-size: 14px; font-family: 'Inter', sans-serif; }
    .notif-btn, .profile-btn { background: transparent; border: none; font-size: 20px; color: #475569; cursor: pointer; padding: 6px; border-radius: 30px; transition: background 0.15s; position: relative; }
    .notif-btn:hover, .profile-btn:hover { background: #F1F5F9; }
    .notif-badge { position: absolute; top: 2px; right: 2px; background: #6D4AFF; color: #fff; font-size: 10px; font-weight: 700; border-radius: 30px; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; border: 2px solid #fff; }
    .profile-dropdown-wrap { position: relative; }
    .profile-btn { display: flex; align-items: center; gap: 8px; padding: 4px 12px 4px 4px; border-radius: 40px; background: #F1F5F9; }
    .profile-btn img { width: 34px; height: 34px; border-radius: 50%; background: #6D4AFF; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600; }
    .profile-btn span { font-weight: 500; font-size: 14px; color: #1E293B; }
    .dropdown-menu { position: absolute; right: 0; top: 48px; background: #fff; border-radius: 16px; box-shadow: 0 20px 40px -12px rgba(0,0,0,0.15); min-width: 210px; padding: 10px 0; opacity: 0; visibility: hidden; transform: translateY(8px); transition: all 0.18s ease; border: 1px solid #F1F5F9; }
    .dropdown-menu.open { opacity: 1; visibility: visible; transform: translateY(0); }
    .dropdown-menu a { display: flex; align-items: center; gap: 12px; padding: 10px 18px; color: #1E293B; text-decoration: none; font-size: 14px; font-weight: 500; transition: background 0.1s; }
    .dropdown-menu a:hover { background: #F8FAFC; }
    .dropdown-menu a i { width: 20px; color: #64748B; }
    .dropdown-divider { height: 1px; background: #F1F5F9; margin: 6px 12px; }

    .content { padding: 28px 32px 40px 32px; flex:1; }
    .page-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 24px; }
    .page-header h3 { font-size: 24px; font-weight: 600; color: #0F172A; }
    .btn-primary { background: #6D4AFF; border: none; padding: 10px 24px; border-radius: 40px; font-weight: 600; font-size: 14px; color: #fff; display: inline-flex; align-items: center; gap: 10px; cursor: pointer; transition: all 0.15s; box-shadow: 0 6px 14px -6px rgba(109,74,255,0.3); font-family: 'Inter', sans-serif; }
    .btn-primary:hover { background: #5a3de0; transform: translateY(-2px); box-shadow: 0 10px 20px -8px rgba(109,74,255,0.35); }
    .btn-primary:active { transform: scale(0.97); }
    .btn-primary:disabled { opacity: 0.5; cursor: not-allowed; transform: none !important; }
    .btn-outline { background: transparent; border: 1.5px solid #E2E8F0; padding: 8px 18px; border-radius: 40px; font-weight: 600; font-size: 13px; color: #475569; cursor: pointer; transition: 0.15s; font-family: 'Inter', sans-serif; }
    .btn-outline:hover { background: #F1F5F9; }
    .btn-outline:disabled { opacity: 0.5; cursor: not-allowed; }
    .btn-success { background: #10B981; border: none; padding: 10px 24px; border-radius: 40px; font-weight: 600; font-size: 14px; color: #fff; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: 0.15s; font-family: 'Inter', sans-serif; box-shadow: 0 6px 14px -6px rgba(16,185,129,0.3); }
    .btn-success:hover { background: #0ea373; transform: translateY(-2px); }

    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 20px; margin-bottom: 28px; }
    .stat-card { background: #fff; border-radius: 16px; padding: 20px 18px; box-shadow: 0 4px 12px rgba(0,0,0,0.02), 0 1px 2px rgba(0,0,0,0.03); border: 1px solid #F1F5F9; transition: all 0.2s; cursor: pointer; display: flex; align-items: center; gap: 14px; }
    .stat-card:hover { box-shadow: 0 12px 28px -8px rgba(0,0,0,0.06); transform: translateY(-2px); }
    .stat-icon { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #fff; flex-shrink: 0; }
    .stat-icon.purple { background: #6D4AFF; }
    .stat-icon.blue { background: #3B82F6; }
    .stat-icon.green { background: #10B981; }
    .stat-icon.orange { background: #F59E0B; }
    .stat-info h4 { font-size: 14px; font-weight: 500; color: #64748B; letter-spacing: 0.2px; margin-bottom: 2px; }
    .stat-info .number { font-size: 26px; font-weight: 700; color: #1E293B; letter-spacing: -0.3px; }

    .filters-bar { display: flex; flex-wrap: wrap; align-items: center; gap: 14px; background: #fff; padding: 16px 20px; border-radius: 16px; border: 1px solid #F1F5F9; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
    .filters-bar select, .filters-bar input { padding: 8px 14px; border-radius: 30px; border: 1px solid #E2E8F0; background: #F8FAFC; font-size: 14px; font-family: 'Inter', sans-serif; color: #1E293B; outline: none; transition: 0.15s; }
    .filters-bar select:focus, .filters-bar input:focus { border-color: #6D4AFF; box-shadow: 0 0 0 3px rgba(109,74,255,0.08); }
    .btn-reset { background: transparent; border: 1px solid #E2E8F0; padding: 8px 18px; border-radius: 30px; font-weight: 500; font-size: 13px; color: #475569; cursor: pointer; transition: 0.15s; }
    .btn-reset:hover { background: #F1F5F9; }

    .table-card { background: #fff; border-radius: 16px; border: 1px solid #F1F5F9; padding: 20px 24px 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    th { text-align: left; padding: 12px 8px 12px 0; font-weight: 600; color: #475569; border-bottom: 1px solid #F1F5F9; }
    td { padding: 14px 8px 14px 0; border-bottom: 1px solid #F1F5F9; color: #1E293B; vertical-align: middle; }
    td:last-child { padding-right:0; }
    tr:hover td { background: #F8FAFC; cursor: pointer; }
    .status-badge { font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 40px; background: #E6F7E6; color: #10B981; }
    .status-badge.verified { background: #EDE7FF; color: #6D4AFF; }
    .status-badge.pending { background: #FEF3C7; color: #D97706; }
    .action-dropdown { position: relative; display: inline-block; }
    .action-dropdown .dropdown-trigger { background: transparent; border: none; color: #94A3B8; padding: 6px 10px; border-radius: 30px; cursor: pointer; transition: 0.1s; }
    .action-dropdown .dropdown-trigger:hover { background: #F1F5F9; color:#1E293B; }
    .action-dropdown .dd-menu { position: absolute; right: 0; top: 30px; background: #fff; border-radius: 14px; box-shadow: 0 20px 40px -12px rgba(0,0,0,0.15); min-width: 190px; padding: 8px 0; border: 1px solid #F1F5F9; opacity: 0; visibility: hidden; transform: translateY(6px); transition: all 0.15s; z-index: 20; }
    .action-dropdown .dd-menu.open { opacity: 1; visibility: visible; transform: translateY(0); }
    .action-dropdown .dd-menu a { display: flex; align-items: center; gap: 10px; padding: 8px 18px; font-size: 13px; color: #1E293B; text-decoration: none; transition: 0.1s; }
    .action-dropdown .dd-menu a:hover { background: #F8FAFC; }
    .action-dropdown .dd-menu a i { width: 18px; color: #64748B; }

    /* MODAL */
    .modal-overlay { position: fixed; inset: 0; background: rgba(15,23,42,0.55); backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center; z-index: 999; padding: 20px; }
    .modal-overlay.active { display: flex; }
    .modal { background: #fff; border-radius: 28px; max-width: 860px; width: 100%; max-height: 92vh; overflow-y: auto; padding: 32px 36px 36px; box-shadow: 0 40px 80px -20px rgba(0,0,0,0.3); animation: modalIn 0.25s ease; }
    @keyframes modalIn { from { opacity:0; transform: scale(0.96) translateY(20px); } to { opacity:1; transform: scale(1) translateY(0); } }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .modal-header h2 { font-size: 22px; font-weight: 600; color: #0F172A; }
    .modal-close { background: transparent; border: none; font-size: 24px; color: #94A3B8; cursor: pointer; padding: 6px; }
    .modal-close:hover { color: #1E293B; }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px 24px; }
    .form-group { display: flex; flex-direction: column; gap: 4px; }
    .form-group label { font-weight: 500; font-size: 14px; color: #334155; }
    .form-group input, .form-group select, .form-group textarea { padding: 10px 14px; border-radius: 12px; border: 1.5px solid #E2E8F0; font-size: 14px; font-family: 'Inter', sans-serif; transition: 0.15s; background: #fff; width: 100%; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #6D4AFF; box-shadow: 0 0 0 3px rgba(109,74,255,0.08); outline: none; }
    .form-group textarea { resize: vertical; min-height: 60px; }
    .full-width { grid-column: 1 / -1; }

    .preview-card { background: #F8FAFC; border-radius: 14px; padding: 16px 20px; border: 1px solid #F1F5F9; margin: 12px 0; }
    .preview-card .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
    .preview-card .header h5 { font-weight: 600; font-size: 15px; color: #0F172A; }
    .preview-card .header .badge { font-size: 12px; font-weight: 600; padding: 2px 12px; border-radius: 30px; }
    .preview-card .header .badge.existing { background: #FEE2E2; color: #DC2626; }
    .preview-card .header .badge.new { background: #DCFCE7; color: #10B981; }
    .preview-item { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #F1F5F9; font-size: 14px; }
    .preview-item:last-child { border-bottom: none; }
    .preview-item .course { font-weight: 500; }
    .preview-item .status-text { font-size: 12px; font-weight: 500; }
    .preview-item .status-text.existing { color: #DC2626; }
    .preview-item .status-text.new { color: #10B981; }

    .summary-box { background: #EDE7FF; border-radius: 12px; padding: 14px 18px; display: flex; justify-content: space-between; align-items: center; margin-top: 12px; border: 1px solid #6D4AFF; }
    .summary-box .label { font-size: 14px; color: #1E293B; }
    .summary-box .count { font-weight: 700; font-size: 18px; color: #6D4AFF; }

    .search-select-wrapper { position: relative; }
    .search-select-wrapper input[type="text"] { width: 100%; padding: 10px 14px; border-radius: 12px; border: 1.5px solid #E2E8F0; font-size: 14px; font-family: 'Inter', sans-serif; transition: 0.15s; background: #fff; }
    .search-select-wrapper input[type="text"]:focus { border-color: #6D4AFF; box-shadow: 0 0 0 3px rgba(109,74,255,0.08); outline: none; }
    .search-select-dropdown { position: absolute; top: 100%; left: 0; right: 0; background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 10px 30px rgba(0,0,0,0.1); max-height: 200px; overflow-y: auto; display: none; z-index: 10; margin-top: 4px; }
    .search-select-dropdown.show { display: block; }
    .search-select-dropdown .option { padding: 10px 14px; cursor: pointer; transition: 0.1s; font-size: 14px; border-bottom: 1px solid #F8FAFC; }
    .search-select-dropdown .option:hover { background: #F8FAFC; }
    .search-select-dropdown .option.selected { background: #EDE7FF; color: #6D4AFF; }
    .search-select-dropdown .option .sub { font-size: 12px; color: #94A3B8; }

    .toast { position: fixed; bottom: 30px; right: 30px; background: #0F172A; color: #fff; padding: 16px 28px; border-radius: 60px; box-shadow: 0 20px 40px -12px rgba(0,0,0,0.2); display: flex; align-items: center; gap: 12px; font-weight: 500; font-size: 15px; transform: translateY(80px); opacity: 0; transition: all 0.3s ease; z-index: 9999; border-left: 5px solid #6D4AFF; }
    .toast.show { transform: translateY(0); opacity: 1; }
    .toast i { color: #6D4AFF; font-size: 20px; }

    .success-screen { text-align: center; padding: 20px 12px; }
    .success-screen .icon-circle { width: 80px; height: 80px; background: #10B981; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: #fff; font-size: 40px; margin-bottom: 16px; box-shadow: 0 8px 24px rgba(16,185,129,0.25); }
    .success-screen h2 { font-size: 26px; font-weight: 700; color: #0F172A; margin-bottom: 4px; }
    .success-screen p { color: #64748B; font-size: 15px; }
    .success-screen .detail-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px,1fr)); gap: 12px; max-width: 400px; margin: 12px auto; }
    .success-screen .detail-grid .item { background: #F8FAFC; padding: 10px; border-radius: 10px; border: 1px solid #F1F5F9; }
    .success-screen .detail-grid .item .num { font-weight: 700; font-size: 20px; color: #0F172A; }
    .success-screen .detail-grid .item .lbl { font-size: 11px; color: #64748B; }

    .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.2); z-index: 45; }
    .overlay.active { display: block; }

    .loading-spinner { display: inline-block; width: 20px; height: 20px; border: 3px solid #f3f3f3; border-top: 3px solid #6D4AFF; border-radius: 50%; animation: spin 1s linear infinite; }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    @media (max-width: 1024px) { .form-grid { grid-template-columns: 1fr; } }
    @media (max-width: 768px) { .sidebar { transform: translateX(-100%); width: 270px; position: fixed; top:0; left:0; height:100%; } .sidebar.open { transform: translateX(0); } .topbar-left .menu-toggle { display: block; } .search-box { width: 140px; } .content { padding: 20px 16px; } .topbar { padding: 12px 16px; } .modal { padding: 24px 18px; } .stats-grid { grid-template-columns: 1fr 1fr; } }
  </style>
</head>
<body>
<div class="overlay" id="overlay"></div>
<!-- SIDEBAR --><aside class="sidebar" id="sidebar">
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
<div class="main">
  <header class="topbar">
    <div class="topbar-left">
      <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
      <div>
        <h2>Certificate Management</h2>
        <div class="breadcrumb">Dashboard / <span>Certificates</span></div>
      </div>
    </div>
    <div class="topbar-right">
      <div class="search-box"><i class="fas fa-search"></i><input type="text" id="searchInput" placeholder="Search certificates..." oninput="applyFilters()"></div>
      <button class="notif-btn"><i class="fas fa-bell"></i><span class="notif-badge">3</span></button>
      <div class="profile-dropdown-wrap">
        <button class="profile-btn" id="profileBtn"><img src="#" alt="A" style="background:#6D4AFF; display:flex; align-items:center; justify-content:center; color:#fff;"> <span>Admin</span> <i class="fas fa-chevron-down" style="font-size:12px; margin-left:4px;"></i></button>
        <div class="dropdown-menu" id="profileDropdown">
          <a href="#"><i class="fas fa-user"></i> View Profile</a>
          <a href="#"><i class="fas fa-sliders-h"></i> Account Settings</a>
          <a href="#"><i class="fas fa-key"></i> Change Password</a>
          <div class="dropdown-divider"></div>
          <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
      </div>
    </div>
  </header>

  <div class="content">
    <div class="page-header">
      <h3>Certificates</h3>
      <button class="btn-primary" id="generateBtn"><i class="fas fa-plus"></i> Generate Certificate</button>
    </div>

    <!-- Stats -->
    <div class="stats-grid" id="statsGrid">
      <div class="stat-card"><div class="stat-icon purple"><i class="fas fa-certificate"></i></div><div class="stat-info"><h4>Total Certificates</h4><div class="number" id="totalCount">0</div></div></div>
      <div class="stat-card"><div class="stat-icon blue"><i class="fas fa-calendar-check"></i></div><div class="stat-info"><h4>Issued This Month</h4><div class="number" id="monthlyCount">0</div></div></div>
      <div class="stat-card"><div class="stat-icon orange"><i class="fas fa-clock"></i></div><div class="stat-info"><h4>Pending</h4><div class="number" id="pendingCount">0</div></div></div>
      <div class="stat-card"><div class="stat-icon green"><i class="fas fa-check-circle"></i></div><div class="stat-info"><h4>Verified</h4><div class="number" id="verifiedCount">0</div></div></div>
    </div>

    <!-- Filters -->
    <div class="filters-bar">
      <input type="text" id="filterStudent" placeholder="Search student..." style="flex:1; min-width:120px;" oninput="applyFilters()">
      <input type="text" id="filterCertNo" placeholder="Certificate No..." style="flex:1; min-width:120px;" oninput="applyFilters()">
      <select id="filterCourse" onchange="applyFilters()">
        <option value="">All Courses</option>
        @foreach($courses ?? [] as $course)
          <option value="{{ $course }}">{{ $course }}</option>
        @endforeach
      </select>
      <input type="date" id="filterDate" style="width:150px;" onchange="applyFilters()">
      <select id="filterStatus" onchange="applyFilters()">
        <option value="">All Status</option>
        <option value="issued">Issued</option>
        <option value="verified">Verified</option>
        <option value="pending">Pending</option>
      </select>
      <button class="btn-reset" onclick="resetFilters()"><i class="fas fa-redo"></i> Reset</button>
    </div>

    <!-- Table -->
    <div class="table-card">
      <div id="loadingIndicator" style="display:none; text-align:center; padding:20px;">
        <div class="loading-spinner"></div>
        <p style="margin-top:10px; color:#64748B;">Loading certificates...</p>
      </div>
      <table>
        <thead><tr>
          <th>Certificate No</th><th>Student Name</th><th>Student ID</th><th>Course Name</th><th>Issue Date</th><th>Status</th><th>Actions</th>
        </tr></thead>
        <tbody id="certTableBody">
          <!-- Dynamic rows will be inserted here -->
        </tbody>
      </table>
      <div style="display:flex; justify-content:space-between; align-items:center; margin-top:16px; flex-wrap:wrap; gap:10px;">
        <span style="font-size:14px; color:#64748B;" id="tableInfo">Loading...</span>
        <div style="display:flex; gap:6px;" id="paginationControls">
          <!-- Pagination will be rendered here -->
        </div>
      </div>
    </div>
  </div>
</div>

<!-- GENERATE CERTIFICATE MODAL -->
<div class="modal-overlay" id="generateModal">
  <div class="modal">
    <div class="modal-header">
      <h2><i class="fas fa-certificate" style="color:#6D4AFF; margin-right:10px;"></i> Generate Certificates</h2>
      <button class="modal-close" onclick="closeModal('generateModal')"><i class="fas fa-times"></i></button>
    </div>
    <div id="modalContent">
      <div class="form-group" style="margin-bottom:16px;">
        <label>Select Student</label>
        <div class="search-select-wrapper">
          <input type="text" id="studentSearchInput" placeholder="Search by name or father name..." oninput="filterStudentOptions(this.value)" onfocus="loadStudents(this.value)">
          <div class="search-select-dropdown" id="studentDropdown"></div>
          <input type="hidden" id="selectedStudentValue" value="">
          <input type="hidden" id="selectedStudentId" value="">
        </div>
      </div>
      <div id="previewSection" style="display:none;">
        <div class="preview-card">
          <div class="header">
            <h5><i class="fas fa-user-graduate" style="color:#6D4AFF;"></i> Student Information</h5>
            <span class="badge new" id="studentIdDisplay">STU-001</span>
          </div>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px 24px;">
            <div><span style="color:#64748B; font-size:13px;">Student Name</span><div style="font-weight:600;" id="previewStudentName">-</div></div>
            <div><span style="color:#64748B; font-size:13px;">Father Name</span><div style="font-weight:500;" id="previewFatherName">-</div></div>
            <div><span style="color:#64748B; font-size:13px;">Student ID</span><div style="font-weight:500;" id="previewStudentId">-</div></div>
            <div><span style="color:#64748B; font-size:13px;">Registration No</span><div style="font-weight:500;" id="previewRegNo">-</div></div>
          </div>
        </div>
        <div style="font-weight:600; font-size:15px; margin:12px 0 8px;">Certificates to Generate</div>
        <div id="certificatePreviewList"></div>
        <div class="summary-box">
          <span class="label"><i class="fas fa-info-circle"></i> Total Certificates</span>
          <span class="count" id="totalCertCount">0</span>
        </div>
        <div style="font-weight:600; font-size:15px; margin:16px 0 10px;">Certificate Details</div>
        <div class="form-grid">
          <div class="form-group"><label>Issue Date</label><input type="date" id="certIssueDate"></div>
          <div class="form-group"><label>Certificate Title</label><input type="text" id="certTitle" placeholder="Certificate of Completion"></div>
          <div class="form-group full-width"><label>Remarks</label><textarea id="certRemarks" placeholder="Additional remarks..." rows="2"></textarea></div>
        </div>
        <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:24px; padding-top:20px; border-top:1px solid #F1F5F9;">
          <button class="btn-outline" onclick="closeModal('generateModal')">Cancel</button>
          <button class="btn-success" id="generateCertBtn" onclick="generateCertificates()"><i class="fas fa-check"></i> Generate Certificates</button>
        </div>
      </div>
    </div>
    <div id="successScreen" style="display:none;">
      <div class="success-screen">
        <div class="icon-circle"><i class="fas fa-check"></i></div>
        <h2>Certificates Generated Successfully!</h2>
        <p>All certificates have been generated and stored in the system.</p>
        <div class="detail-grid" id="successDetails">
          <div class="item"><div class="num" id="successCount">0</div><div class="lbl">Certificates</div></div>
        </div>
        <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap; margin-top:16px;">
          <button class="btn-primary" onclick="closeModal('generateModal'); fetchCertificates();"><i class="fas fa-eye"></i> View Certificates</button>
          <button class="btn-outline" onclick="closeModal('generateModal')"><i class="fas fa-list"></i> Back to List</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="toast" id="toast"><i class="fas fa-check-circle"></i> <span id="toastMsg">Action completed</span></div>

<script>
// ============================================
// FULL BACKEND INTEGRATION WITH DYNAMIC LINKS
// ============================================

// ---- Helpers ----
function toggleSidebar() { 
  document.getElementById('sidebar').classList.toggle('open'); 
  document.getElementById('overlay').classList.toggle('active'); 
}

document.getElementById('menuToggle').addEventListener('click', toggleSidebar);
document.getElementById('overlay').addEventListener('click', toggleSidebar);

const profileBtn = document.getElementById('profileBtn');
const profileDropdown = document.getElementById('profileDropdown');
profileBtn.addEventListener('click', function(e) { 
  e.stopPropagation(); 
  profileDropdown.classList.toggle('open'); 
});
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

function showToast(msg, type = 'success') {
  const toast = document.getElementById('toast');
  document.getElementById('toastMsg').textContent = msg;
  toast.style.borderLeftColor = type === 'success' ? '#6D4AFF' : '#DC2626';
  toast.classList.add('show');
  clearTimeout(toast._timer);
  toast._timer = setTimeout(() => toast.classList.remove('show'), 3500);
}

function getCSRFToken() {
  return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

// ---- API Functions ----
async function apiRequest(url, options = {}) {
  const defaultOptions = {
    headers: {
      'X-CSRF-TOKEN': getCSRFToken(),
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    }
  };
  const mergedOptions = { ...defaultOptions, ...options };
  
  try {
    const response = await fetch(url, mergedOptions);
    if (!response.ok) {
      const error = await response.json().catch(() => ({ message: 'Request failed' }));
      throw new Error(error.message || 'Request failed');
    }
    return await response.json();
  } catch (error) {
    console.error('API Error:', error);
    showToast('⚠️ ' + error.message, 'error');
    return null;
  }
}

// ---- Fetch Certificates ----
let currentPage = 1;
let totalPages = 1;

async function fetchCertificates(page = 1) {
  const loading = document.getElementById('loadingIndicator');
  loading.style.display = 'block';
  
  const params = new URLSearchParams({
    page: page,
    search: document.getElementById('searchInput').value,
    student: document.getElementById('filterStudent').value,
    cert_no: document.getElementById('filterCertNo').value,
    course: document.getElementById('filterCourse').value,
    date: document.getElementById('filterDate').value,
    status: document.getElementById('filterStatus').value
  });
  
  const result = await apiRequest(`/admin/certificates?${params.toString()}`);
  loading.style.display = 'none';
  
  if (result && result.success !== false) {
    const data = result.certificates || result;
    renderCertificates(data);
    updateStats(result.stats || data.stats);
    renderPagination(data);
    return data;
  }
  return null;
}

function renderCertificates(data) {
  const tbody = document.getElementById('certTableBody');
  tbody.innerHTML = '';
  
  const items = data.data || data || [];
  
  if (items.length === 0) {
    tbody.innerHTML = `<tr><td colspan="7" style="text-align:center; padding:40px; color:#94A3B8;">No certificates found</td></tr>`;
    document.getElementById('tableInfo').textContent = 'Showing 0 certificates';
    return;
  }
  
  items.forEach(cert => {
    const statusClass = cert.status === 'verified' ? 'verified' : cert.status === 'pending' ? 'pending' : '';
    const statusLabel = cert.status.charAt(0).toUpperCase() + cert.status.slice(1);
    const issueDate = cert.issue_date ? new Date(cert.issue_date).toLocaleDateString('en-GB', { 
      day: '2-digit', 
      month: 'short', 
      year: 'numeric' 
    }) : 'N/A';
    
    const row = document.createElement('tr');
    row.innerHTML = `
      <td><strong>${cert.certificate_no || cert.certNo || 'N/A'}</strong></td>
      <td>${cert.student_name || cert.student || 'N/A'}</td>
      <td>${cert.student_id || cert.studentId || 'N/A'}</td>
      <td>${cert.course_name || cert.course || 'N/A'}</td>
      <td>${issueDate}</td>
      <td><span class="status-badge ${statusClass}">${statusLabel}</span></td>
      <td>
        <div class="action-dropdown">
          <button class="dropdown-trigger" onclick="toggleDD(this)"><i class="fas fa-ellipsis-v"></i></button>
          <div class="dd-menu">
            <a href="/admin/certificates/${cert.id}" target="_blank"><i class="fas fa-eye"></i> Preview</a>
            <a href="/admin/certificates/${cert.id}/edit" target="_blank"><i class="fas fa-edit"></i> Edit</a>
            <a href="#" onclick="printCertificate(${cert.id}); return false;"><i class="fas fa-print"></i> Print</a>
            <a href="#" onclick="verifyCertificate(${cert.id}); return false;"><i class="fas fa-check-circle"></i> Verify</a>
            <a href="#" onclick="deleteCertificate(${cert.id}); return false;"><i class="fas fa-trash"></i> Delete</a>
          </div>
        </div>
      </td>
    `;
    tbody.appendChild(row);
  });
  
  const total = data.total || data.length || items.length;
  const from = data.from || 1;
  const to = data.to || items.length;
  document.getElementById('tableInfo').textContent = `Showing ${from}-${to} of ${total}`;
}

function renderPagination(data) {
  const container = document.getElementById('paginationControls');
  container.innerHTML = '';
  
  const current = data.current_page || currentPage;
  const last = data.last_page || totalPages;
  currentPage = current;
  totalPages = last;
  
  if (last <= 1) return;
  
  const prevBtn = document.createElement('button');
  prevBtn.className = 'btn-reset';
  prevBtn.style.padding = '4px 14px';
  prevBtn.textContent = 'Prev';
  prevBtn.disabled = current <= 1;
  prevBtn.onclick = () => { if (current > 1) fetchCertificates(current - 1); };
  container.appendChild(prevBtn);
  
  const start = Math.max(1, current - 2);
  const end = Math.min(last, current + 2);
  
  if (start > 1) {
    const firstBtn = document.createElement('button');
    firstBtn.className = 'btn-reset';
    firstBtn.style.padding = '4px 14px';
    firstBtn.textContent = '1';
    firstBtn.onclick = () => fetchCertificates(1);
    container.appendChild(firstBtn);
    if (start > 2) {
      const dots = document.createElement('span');
      dots.textContent = '...';
      dots.style.padding = '4px 8px';
      container.appendChild(dots);
    }
  }
  
  for (let i = start; i <= end; i++) {
    const btn = document.createElement('button');
    btn.className = 'btn-reset';
    btn.style.padding = '4px 14px';
    if (i === current) {
      btn.style.background = '#6D4AFF';
      btn.style.color = '#fff';
      btn.style.borderColor = '#6D4AFF';
    }
    btn.textContent = i;
    btn.onclick = () => fetchCertificates(i);
    container.appendChild(btn);
  }
  
  if (end < last) {
    if (end < last - 1) {
      const dots = document.createElement('span');
      dots.textContent = '...';
      dots.style.padding = '4px 8px';
      container.appendChild(dots);
    }
    const lastBtn = document.createElement('button');
    lastBtn.className = 'btn-reset';
    lastBtn.style.padding = '4px 14px';
    lastBtn.textContent = last;
    lastBtn.onclick = () => fetchCertificates(last);
    container.appendChild(lastBtn);
  }
  
  const nextBtn = document.createElement('button');
  nextBtn.className = 'btn-reset';
  nextBtn.style.padding = '4px 14px';
  nextBtn.textContent = 'Next';
  nextBtn.disabled = current >= last;
  nextBtn.onclick = () => { if (current < last) fetchCertificates(current + 1); };
  container.appendChild(nextBtn);
}

// ---- Update Stats ----
function updateStats(stats) {
  if (!stats) return;
  document.getElementById('totalCount').textContent = stats.total || 0;
  document.getElementById('monthlyCount').textContent = stats.issued_this_month || 0;
  document.getElementById('pendingCount').textContent = stats.pending || 0;
  document.getElementById('verifiedCount').textContent = stats.verified || 0;
}

// ---- Apply Filters ----
function applyFilters() {
  fetchCertificates(1);
}

function resetFilters() {
  document.getElementById('filterStudent').value = '';
  document.getElementById('filterCertNo').value = '';
  document.getElementById('filterCourse').value = '';
  document.getElementById('filterDate').value = '';
  document.getElementById('filterStatus').value = '';
  document.getElementById('searchInput').value = '';
  fetchCertificates(1);
}

// ---- Print Certificate ----
function printCertificate(id) {
  // Open the certificate preview in a new window and trigger print
  const url = `/admin/certificates/${id}`;
  const printWindow = window.open(url, '_blank', 'width=800,height=600');
  printWindow.onload = function() {
    setTimeout(function() {
      printWindow.print();
    }, 1000);
  };
}

// ---- Load Students for Modal ----
let allStudents = [];

async function loadStudents(search = '') {
  const dropdown = document.getElementById('studentDropdown');
  dropdown.innerHTML = '<div class="option" style="color:#94A3B8;">Loading...</div>';
  dropdown.classList.add('show');
  
  const url = search ? `/admin/certificates/students?search=${encodeURIComponent(search)}` : '/admin/certificates/students';
  const result = await apiRequest(url);
  
  if (result) {
    allStudents = result;
    renderStudentOptions(result);
  } else {
    dropdown.innerHTML = '<div class="option" style="color:#DC2626;">Failed to load students</div>';
  }
}

function renderStudentOptions(students) {
  const dropdown = document.getElementById('studentDropdown');
  dropdown.innerHTML = '';
  
  if (!students || students.length === 0) {
    dropdown.innerHTML = '<div class="option" style="color:#94A3B8;">No students found</div>';
    return;
  }
  
  students.forEach(student => {
    const opt = document.createElement('div');
    opt.className = 'option';
    opt.dataset.value = student.id;
    opt.innerHTML = `${student.name} <span class="sub">Father: ${student.father || 'N/A'} | ID: ${student.student_id}</span>`;
    opt.onclick = function() { selectStudent(student, this); };
    dropdown.appendChild(opt);
  });
}

function filterStudentOptions(query) {
  const dropdown = document.getElementById('studentDropdown');
  const options = dropdown.querySelectorAll('.option');
  const search = query.toLowerCase().trim();
  
  options.forEach(opt => {
    const text = opt.textContent.toLowerCase();
    opt.style.display = (search === '' || text.includes(search)) ? 'block' : 'none';
  });
  dropdown.classList.add('show');
}

let selectedStudent = null;

async function selectStudent(student, element) {
  selectedStudent = student;
  document.getElementById('studentSearchInput').value = student.name;
  document.getElementById('selectedStudentValue').value = student.name;
  document.getElementById('selectedStudentId').value = student.id;
  document.getElementById('studentDropdown').classList.remove('show');
  document.querySelectorAll('#studentDropdown .option').forEach(opt => opt.classList.remove('selected'));
  if (element) element.classList.add('selected');
  
  await loadStudentData(student.id);
}

async function loadStudentData(studentId) {
  const result = await apiRequest(`/admin/certificates/student/${studentId}`);
  if (result) {
    displayStudentPreview(result);
  }
}

function displayStudentPreview(data) {
  document.getElementById('previewSection').style.display = 'block';
  document.getElementById('previewStudentName').textContent = data.name;
  document.getElementById('previewFatherName').textContent = data.father || 'N/A';
  document.getElementById('previewStudentId').textContent = data.student_id || data.id;
  document.getElementById('previewRegNo').textContent = data.regNo || data.registration_no || 'N/A';
  document.getElementById('studentIdDisplay').textContent = data.student_id || data.id;

  let html = '';
  let totalCerts = 0;
  
  (data.enrollments || []).forEach((enroll) => {
    const certExists = enroll.cert_exists || enroll.certExists;
    const status = certExists ? 'existing' : 'new';
    const statusText = certExists ? '✓ Already Issued' : 'New Certificate';
    const statusClass = certExists ? 'existing' : 'new';
    html += `
      <div class="preview-item">
        <span class="course">${enroll.course} <span style="color:#94A3B8; font-size:12px;">(${enroll.duration || 'N/A'})</span></span>
        <span class="status-text ${statusClass}">${statusText} ${certExists ? '🔒' : '📄'}</span>
      </div>
    `;
    totalCerts++;
  });
  
  document.getElementById('certificatePreviewList').innerHTML = html || '<p style="color:#94A3B8;">No enrollments found</p>';
  document.getElementById('totalCertCount').textContent = totalCerts;
  document.getElementById('certIssueDate').value = new Date().toISOString().split('T')[0];
  document.getElementById('certTitle').value = 'Certificate of Completion';
  
  window._selectedStudentData = data;
}

// ---- Generate Certificates ----
async function generateCertificates() {
  const data = window._selectedStudentData;
  if (!data) {
    showToast('⚠️ Please select a student first', 'error');
    return;
  }
  
  const newEnrollments = (data.enrollments || []).filter(e => !(e.cert_exists || e.certExists));
  if (newEnrollments.length === 0) {
    showToast('⚠️ All certificates already exist for this student', 'error');
    return;
  }
  
  const enrollmentIds = newEnrollments.map(e => e.id || e.enrollment_id).filter(id => id);
  if (enrollmentIds.length === 0) {
    showToast('⚠️ No valid enrollments found', 'error');
    return;
  }
  
  const issueDate = document.getElementById('certIssueDate').value;
  const title = document.getElementById('certTitle').value;
  const remarks = document.getElementById('certRemarks').value;
  
  const result = await apiRequest('/admin/certificates/store', {
    method: 'POST',
    body: JSON.stringify({
      student_id: data.id,
      enrollment_ids: enrollmentIds,
      issue_date: issueDate,
      title: title,
      remarks: remarks
    })
  });
  
  if (result && result.success) {
    document.getElementById('modalContent').style.display = 'none';
    document.getElementById('successScreen').style.display = 'block';
    document.getElementById('successCount').textContent = result.count || result.certificates?.length || 0;
    showToast('✅ ' + result.message);
    fetchCertificates(currentPage);
  }
}

// ---- Edit Certificate ----
async function editCertificate(id) {
  // Redirect to edit page
  window.location.href = `/admin/certificates/${id}/edit`;
}

// ---- Verify Certificate ----
async function verifyCertificate(id) {
  if (!confirm('Mark this certificate as verified?')) return;
  
  const result = await apiRequest(`/admin/certificates/${id}/verify`, {
    method: 'POST'
  });
  
  if (result && result.success) {
    showToast('✅ ' + result.message);
    fetchCertificates(currentPage);
  }
}

// ---- Delete Certificate ----
async function deleteCertificate(id) {
  if (!confirm('Delete this certificate permanently?')) return;
  
  const result = await apiRequest(`/admin/certificates/${id}`, {
    method: 'DELETE'
  });
  
  if (result && result.success) {
    showToast('🗑️ ' + result.message);
    fetchCertificates(currentPage);
  }
}

// ---- Generate Button ----
document.getElementById('generateBtn').addEventListener('click', function() {
  document.getElementById('studentSearchInput').value = '';
  document.getElementById('selectedStudentValue').value = '';
  document.getElementById('selectedStudentId').value = '';
  document.getElementById('previewSection').style.display = 'none';
  document.getElementById('modalContent').style.display = 'block';
  document.getElementById('successScreen').style.display = 'none';
  document.querySelectorAll('#studentDropdown .option').forEach(opt => opt.classList.remove('selected'));
  selectedStudent = null;
  window._selectedStudentData = null;
  document.getElementById('certIssueDate').value = new Date().toISOString().split('T')[0];
  
  loadStudents('');
  openModal('generateModal');
});

// ---- Click outside dropdown ----
document.addEventListener('click', function(e) {
  if (!e.target.closest('.search-select-wrapper')) {
    document.getElementById('studentDropdown').classList.remove('show');
  }
});

// ---- Init ----
document.getElementById('certIssueDate').value = new Date().toISOString().split('T')[0];
fetchCertificates(1);

document.getElementById('studentSearchInput').addEventListener('focus', function() {
  if (allStudents.length === 0) {
    loadStudents('');
  } else {
    document.getElementById('studentDropdown').classList.add('show');
  }
});
</script>
</body>
</html>