{{-- resources/views/admin/student.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leeds Academy · Student Management</title>
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
        /* Premium Sidebar */
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
    .sidebar::-webkit-scrollbar-thumb { background: #6D4AFF; border-radius: 10px; }

    .sidebar-brand {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 40px;
      padding: 4px 6px;
      position: relative;
    }
    .sidebar-brand .logo-icon {
      background: linear-gradient(135deg, #6D4AFF, #8B6FFF);
      width: 48px;
      height: 48px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      color: #fff;
      box-shadow: 0 4px 15px rgba(109,74,255,0.3);
    }
    .sidebar-brand .brand-text {
      display: flex;
      flex-direction: column;
    }
    .sidebar-brand .brand-text .name {
      font-weight: 800;
      font-size: 20px;
      letter-spacing: -0.5px;
      color: #fff;
    }
    .sidebar-brand .brand-text .name span { color: #8B6FFF; }
    .sidebar-brand .brand-text .tagline {
      font-size: 10px;
      font-weight: 500;
      color: rgba(255,255,255,0.5);
      letter-spacing: 2px;
      text-transform: uppercase;
      margin-top: 0px;
    }

    .sidebar-menu {
      list-style: none;
      flex: 1;
      margin-top: 8px;
    }
    .sidebar-menu .menu-label {
      font-size: 11px;
      font-weight: 600;
      color: rgba(255,255,255,0.3);
      text-transform: uppercase;
      letter-spacing: 1.5px;
      padding: 16px 12px 8px;
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
      transition: all 0.2s;
      position: relative;
    }
    .sidebar-menu li a i {
      width: 20px;
      font-size: 16px;
      text-align: center;
      color: rgba(255,255,255,0.4);
      transition: color 0.2s;
    }
    .sidebar-menu li a:hover {
      background: rgba(255,255,255,0.08);
      color: #fff;
      transform: translateX(3px);
    }
    .sidebar-menu li a:hover i { color: #fff; }
    .sidebar-menu li.active a {
      background: rgba(109,74,255,0.2);
      color: #fff;
      font-weight: 600;
    }
    .sidebar-menu li.active a i { color: #8B6FFF; }
    .sidebar-menu li.active a::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 4px;
      height: 24px;
      background: linear-gradient(180deg, #6D4AFF, #8B6FFF);
      border-radius: 0 4px 4px 0;
    }

    .sidebar-footer {
      border-top: 1px solid rgba(255,255,255,0.06);
      padding-top: 16px;
      margin-top: 8px;
    }
    .sidebar-footer .user-card {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 12px;
      border-radius: 12px;
      background: rgba(255,255,255,0.05);
      transition: background 0.2s;
      cursor: pointer;
    }
    .sidebar-footer .user-card:hover { background: rgba(255,255,255,0.08); }
    .sidebar-footer .user-card .avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, #6D4AFF, #8B6FFF);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 16px;
      color: #fff;
      flex-shrink: 0;
    }
    .sidebar-footer .user-card .info {
      flex: 1;
    }
    .sidebar-footer .user-card .info .name {
      font-weight: 600;
      font-size: 14px;
      color: #fff;
    }
    .sidebar-footer .user-card .info .role {
      font-size: 12px;
      color: rgba(255,255,255,0.5);
    }
    .sidebar-footer .user-card .badge {
      background: #10B981;
      color: #fff;
      font-size: 9px;
      font-weight: 700;
      padding: 2px 10px;
      border-radius: 30px;
      letter-spacing: 0.5px;
    }


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
        }
        .status-badge.active { background: #E6F7E6; color: #10B981; }
        .status-badge.inactive { background: #FEE2E2; color: #DC2626; }
        .status-badge.pending { background: #FEF3C7; color: #D97706; }
        .avatar-sm {
            width: 36px; height: 36px; border-radius: 30px;
            background: #6D4AFF; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: 14px;
        }
        .avatar-sm img {
            width: 36px; height: 36px; border-radius: 50%;
            object-fit: cover;
        }
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
            background: #fff; border-radius: 24px; max-width: 720px; width: 100%;
            max-height: 92vh; overflow-y: auto; padding: 28px 32px 32px;
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
        .form-group textarea { resize: vertical; min-height: 50px; }
        .full-width { grid-column: 1 / -1; }

        .upload-area {
            border: 2px dashed #E2E8F0;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            color: #94A3B8;
            transition: 0.2s;
            cursor: pointer;
        }
        .upload-area:hover { border-color: #6D4AFF; background: #F8FAFC; }
        .upload-area i { font-size: 28px; color: #6D4AFF; display: block; margin-bottom: 6px; }

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

        /* Image preview in table */
        .avatar-img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            background: #6D4AFF;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
        }

        @media (max-width: 1024px) {
            .form-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); width: 270px; position: fixed; top:0; left:0; height:100%; }
            .sidebar.open { transform: translateX(0); }
            .topbar-left .menu-toggle { display: block; }
            .search-box { width: 140px; }
            .content { padding: 20px 16px; }
            .topbar { padding: 12px 16px; }
            .modal { padding: 20px 18px; }
        }
    </style>
</head>
<body>

    <div class="overlay" id="overlay"></div>

    <!-- ─── SIDEBAR ─── -->
   @include('admin.sidebar')

    <!-- ─── MAIN ─── -->
    <div class="main">

        <!-- TOP HEADER -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
                <div>
                    <h2>Students Management</h2>
                    <div class="breadcrumb">Dashboard / <span>Students</span></div>
                </div>
            </div>
            <div class="topbar-right">
                <div class="search-box"><i class="fas fa-search"></i><input type="text" placeholder="Search students..." id="globalSearch" oninput="filterTable()"></div>
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

        <!-- ─── CONTENT ─── -->
        <div class="content">

            <div class="page-header">
                <h3>Student List</h3>
                <button class="btn-primary" id="addStudentBtn"><i class="fas fa-plus"></i> Add New Student</button>
            </div>

            <div class="filters-bar">
                <input type="text" placeholder="Search student..." style="flex:1; min-width:140px;" id="filterSearch" oninput="filterTable()">
                <select id="filterStatus" onchange="filterTable()">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="pending">Pending</option>
                </select>
                <button class="btn-reset" onclick="resetFilters()"><i class="fas fa-redo"></i> Reset</button>
            </div>

            <div class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Father Name</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentTableBody">
                        <tr><td colspan="7" style="text-align:center; padding:40px; color:#94A3B8;">Loading students...</td></tr>
                    </tbody>
                </table>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:16px; flex-wrap:wrap; gap:10px;">
                    <span style="font-size:14px; color:#64748B;" id="recordCount">Loading...</span>
                    <div style="display:flex; gap:6px;" id="paginationControls"></div>
                </div>
            </div>

        </div><!-- /content -->
    </div><!-- /main -->

    <!-- ─── STUDENT MODAL (Add/Edit) ─── -->
    <div class="modal-overlay" id="studentModal">
        <div class="modal">
            <div class="modal-header">
                <h2 id="modalTitle"><i class="fas fa-user-plus" style="color:#6D4AFF; margin-right:10px;"></i> Add New Student</h2>
                <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
            </div>
            <form id="studentForm" onsubmit="saveStudent(event)" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="studentId" value="">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Student Name <span class="required">*</span></label>
                        <input type="text" id="sName" placeholder="Full name" required>
                    </div>
                    <div class="form-group">
                        <label>Father Name</label>
                        <input type="text" id="sFather" placeholder="Father's name">
                    </div>
                    <div class="form-group">
                        <label>Phone <span class="required">*</span></label>
                        <input type="text" id="sPhone" placeholder="+92 300 1234567" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="sEmail" placeholder="student@example.com">
                    </div>
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" id="sDob">
                    </div>
                    <div class="form-group">
                        <label>Nationality</label>
                        <input type="text" id="sNationality" placeholder="Pakistani">
                    </div>
                    <div class="form-group">
                        <label>Qualification</label>
                        <input type="text" id="sQualification" placeholder="Intermediate / Bachelor">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select id="sStatus">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                    <div class="form-group full-width">
                        <label>Address</label>
                        <textarea id="sAddress" placeholder="Residential address" rows="2"></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label>Profile Picture</label>
                        <div class="upload-area" onclick="document.getElementById('sImage').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Click to upload profile picture (JPG, PNG, GIF)</p>
                        </div>
                        <input type="file" id="sImage" name="profile_image" accept="image/*" style="display:none;" onchange="handleImageUpload(this)">
                        <div id="imagePreview" style="display:none; margin-top:8px;">
                            <img id="imagePreviewImg" src="#" alt="Preview" style="max-width:100px; max-height:100px; border-radius:8px; border:1px solid #E2E8F0; padding:4px;">
                            <button type="button" class="btn-outline" style="padding:2px 12px; font-size:12px; margin-left:8px;" onclick="removeImage()">Remove</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-primary" id="saveBtn"><i class="fas fa-save"></i> Save Student</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ─── DELETE MODAL ─── -->
    <div class="modal-overlay delete-modal" id="deleteModal">
        <div class="modal">
            <div class="icon"><i class="fas fa-exclamation-circle"></i></div>
            <h3>Delete Student</h3>
            <p>Are you sure you want to delete this student? This action cannot be undone.</p>
            <div style="margin-top:16px; display:flex; gap:12px; justify-content:center;">
                <button class="btn-outline" onclick="closeDeleteModal()">Cancel</button>
                <button class="btn-danger" id="confirmDeleteBtn"><i class="fas fa-trash"></i> Delete</button>
            </div>
        </div>
    </div>

    <!-- ─── TOAST ─── -->
    <div class="toast" id="toast"><i class="fas fa-check-circle"></i> <span id="toastMsg">Action completed</span></div>

    <script>
        // ─── Global Variables ───
        let students = [];
        let currentPage = 1;
        const perPage = 10;
        let deleteId = null;
        let imageFile = null;

        // ─── CSRF Token ───
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // ─── Load Students from Database ───
        async function loadStudents() {
            try {
                const response = await fetch('{{ route("admin.students.index") }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                students = data.data || [];
                renderTable();
            } catch (error) {
                console.error('Error loading students:', error);
                showToast('⚠️ Error loading students');
                document.getElementById('studentTableBody').innerHTML = `
                    <tr><td colspan="7" style="text-align:center; padding:40px; color:#94A3B8;">
                        <i class="fas fa-exclamation-circle" style="font-size:24px; display:block; margin-bottom:8px;"></i>
                        Failed to load students. Please refresh the page.
                    </td></tr>
                `;
            }
        }

        // ─── Render Table ───
        function renderTable() {
            const filtered = getFilteredStudents();
            const total = filtered.length;
            const totalPages = Math.ceil(total / perPage);
            if (currentPage > totalPages) currentPage = totalPages || 1;
            const start = (currentPage - 1) * perPage;
            const pageData = filtered.slice(start, start + perPage);

            const tbody = document.getElementById('studentTableBody');
            if (pageData.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" style="text-align:center; padding:40px; color:#94A3B8;">No students found</td></tr>`;
            } else {
                tbody.innerHTML = pageData.map(s => {
                    const initials = s.name.split(' ').map(w => w[0]).join('').toUpperCase();
                    const statusClass = s.status || 'active';
                    // Check if profile image exists
                    const hasImage = s.profile_image && s.profile_image !== null;
                    const imageHtml = hasImage 
                        ? `<img src="/storage/${s.profile_image}" alt="${s.name}" style="width:36px; height:36px; border-radius:50%; object-fit:cover;">`
                        : `<div class="avatar-sm" style="background:#6D4AFF; color:#fff; display:flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:50%; font-weight:600; font-size:14px;">${initials}</div>`;
                    return `
                        <tr>
                            <td>${imageHtml}</td>
                            <td><strong>${s.student_id || 'N/A'}</strong></td>
                            <td><strong>${s.name}</strong></td>
                            <td>${s.father_name || '-'}</td>
                            <td>${s.phone}</td>
                            <td><span class="status-badge ${statusClass}">${statusClass.charAt(0).toUpperCase() + statusClass.slice(1)}</span></td>
                            <td>
                                <div class="action-dropdown">
                                    <button class="dropdown-trigger" onclick="toggleDD(this)"><i class="fas fa-ellipsis-v"></i></button>
                                    <div class="dd-menu">
                                        <a href="#" onclick="viewStudent(${s.id}); return false;"><i class="fas fa-eye"></i> View Profile</a>
                                        <a href="#" onclick="editStudent(${s.id}); return false;"><i class="fas fa-edit"></i> Edit Student</a>
                                        <a href="#" onclick="deleteStudent(${s.id}); return false;"><i class="fas fa-trash"></i> Delete</a>
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

        // ─── Render Pagination ───
        function renderPagination(totalPages) {
            const container = document.getElementById('paginationControls');
            if (totalPages <= 1) {
                container.innerHTML = '';
                return;
            }
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

        // ─── Filter Functions ───
        function getFilteredStudents() {
            const search = document.getElementById('filterSearch').value.toLowerCase().trim();
            const status = document.getElementById('filterStatus').value;
            return students.filter(s => {
                const matchSearch = search === '' || 
                    (s.name && s.name.toLowerCase().includes(search)) || 
                    (s.student_id && s.student_id.toLowerCase().includes(search)) ||
                    (s.father_name && s.father_name.toLowerCase().includes(search));
                const matchStatus = status === '' || (s.status && s.status === status);
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

        // ─── Modal Functions ───
        function openModal() {
            document.getElementById('studentModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('studentModal').classList.remove('active');
            document.getElementById('studentForm').reset();
            document.getElementById('studentId').value = '';
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('sImage').value = '';
            imageFile = null;
        }

        // ─── Add Student ───
        document.getElementById('addStudentBtn').addEventListener('click', function() {
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-user-plus" style="color:#6D4AFF; margin-right:10px;"></i> Add New Student';
            document.getElementById('saveBtn').innerHTML = '<i class="fas fa-save"></i> Save Student';
            document.getElementById('studentForm').reset();
            document.getElementById('studentId').value = '';
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('sImage').value = '';
            document.getElementById('sStatus').value = 'active';
            imageFile = null;
            openModal();
        });

        // ─── Edit Student ───
        async function editStudent(id) {
            try {
                const response = await fetch(`/admin/students/${id}/edit`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                const student = data.data;

                document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit" style="color:#6D4AFF; margin-right:10px;"></i> Edit Student';
                document.getElementById('saveBtn').innerHTML = '<i class="fas fa-save"></i> Update Student';
                document.getElementById('studentId').value = student.id;
                document.getElementById('sName').value = student.name || '';
                document.getElementById('sFather').value = student.father_name || '';
                document.getElementById('sPhone').value = student.phone || '';
                document.getElementById('sEmail').value = student.email || '';
                document.getElementById('sDob').value = student.date_of_birth || '';
                document.getElementById('sNationality').value = student.nationality || '';
                document.getElementById('sQualification').value = student.qualification || '';
                document.getElementById('sAddress').value = student.address || '';
                document.getElementById('sStatus').value = student.status || 'active';
                document.getElementById('imagePreview').style.display = 'none';
                document.getElementById('sImage').value = '';
                imageFile = null;
                openModal();
            } catch (error) {
                showToast('⚠️ Error loading student data');
            }
        }

        // ─── View Student ───
        async function viewStudent(id) {
            try {
                const response = await fetch(`/admin/students/${id}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                const s = data.data;
                alert(`👤 Student Profile\n\nName: ${s.name}\nID: ${s.student_id}\nFather: ${s.father_name || '-'}\nPhone: ${s.phone}\nEmail: ${s.email || '-'}\nStatus: ${s.status}`);
            } catch (error) {
                showToast('⚠️ Error loading student details');
            }
        }

        // ─── Save Student ───
        async function saveStudent(e) {
            e.preventDefault();
            const id = document.getElementById('studentId').value;
            
            // Create FormData for file upload
            const formData = new FormData();
            formData.append('name', document.getElementById('sName').value);
            formData.append('father_name', document.getElementById('sFather').value);
            formData.append('phone', document.getElementById('sPhone').value);
            formData.append('email', document.getElementById('sEmail').value);
            formData.append('date_of_birth', document.getElementById('sDob').value);
            formData.append('nationality', document.getElementById('sNationality').value);
            formData.append('qualification', document.getElementById('sQualification').value);
            formData.append('address', document.getElementById('sAddress').value);
            formData.append('status', document.getElementById('sStatus').value);
            
            // Append image if exists
            const fileInput = document.getElementById('sImage');
            if (fileInput.files.length > 0) {
                formData.append('profile_image', fileInput.files[0]);
            }

            // For edit, use PUT method
            if (id) {
                formData.append('_method', 'PUT');
            }

            const url = id ? `/admin/students/${id}` : '{{ route("admin.students.store") }}';

            try {
                const response = await fetch(url, {
                    method: 'POST', // Use POST with _method override
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    showToast(result.message);
                    closeModal();
                    loadStudents();
                } else {
                    const errors = result.errors || {};
                    let errorMsg = 'Validation errors:\n';
                    for (const key in errors) {
                        errorMsg += `- ${errors[key].join(', ')}\n`;
                    }
                    showToast(errorMsg);
                }
            } catch (error) {
                showToast('⚠️ Error saving student');
            }
        }

        // ─── Delete Student ───
        function deleteStudent(id) {
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
                    const response = await fetch(`/admin/students/${deleteId}`, {
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
                        loadStudents();
                    } else {
                        showToast('⚠️ ' + (result.message || 'Cannot delete student'));
                        closeDeleteModal();
                    }
                } catch (error) {
                    showToast('⚠️ Error deleting student');
                    closeDeleteModal();
                }
            }
        });

        // ─── Image Upload ───
        function handleImageUpload(input) {
            const file = input.files[0];
            if (file) {
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                if (!allowedTypes.includes(file.type)) {
                    showToast('⚠️ Please upload JPG, PNG or GIF image');
                    input.value = '';
                    return;
                }
                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    showToast('⚠️ Image size must be less than 2MB');
                    input.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreviewImg').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                    showToast('📷 Image uploaded successfully');
                };
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('sImage').value = '';
        }

        // ─── Toast ───
        function showToast(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            toast.classList.add('show');
            clearTimeout(toast._timer);
            toast._timer = setTimeout(() => toast.classList.remove('show'), 3500);
        }

        // ─── Close modals on overlay click ───
        document.querySelectorAll('.modal-overlay').forEach(el => {
            el.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        });

        // ─── Init ───
        loadStudents();
    </script>
</body>
</html>