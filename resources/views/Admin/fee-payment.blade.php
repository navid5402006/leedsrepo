{{-- resources/views/admin/fee-payment.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leeds Academy · Fee Payments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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

        .payment-layout {
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
        .history-item .amount {
            font-size: 13px;
            font-weight: 600;
            color: #10B981;
        }
        .history-item .remarks {
            font-size: 12px;
            color: #64748B;
            font-style: italic;
        }

        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th { text-align: left; padding: 12px 8px 12px 0; font-weight: 600; color: #475569; border-bottom: 1px solid #F1F5F9; }
        td { padding: 14px 8px 14px 0; border-bottom: 1px solid #F1F5F9; color: #1E293B; vertical-align: middle; }
        td:last-child { padding-right:0; }
        tr:hover td { background: #F8FAFC; cursor: pointer; }
        .avatar-sm {
            width: 32px; height: 32px; border-radius: 30px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: 12px;
            color: #fff;
        }
        .avatar-sm img {
            width: 32px; height: 32px; border-radius: 50%;
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
            background: #fff; border-radius: 28px; max-width: 1100px; width: 100%;
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

        .modal-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
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

        .modal-footer {
            display: flex; justify-content: flex-end; gap: 12px;
            margin-top: 24px; padding-top: 20px; border-top: 1px solid #F1F5F9;
        }

        .delete-modal .modal { max-width: 440px; text-align: center; }
        .delete-modal .modal .icon { font-size: 48px; color: #EF4444; margin-bottom: 12px; }
        .delete-modal .modal h3 { font-size: 20px; font-weight: 600; margin-bottom: 4px; }
        .delete-modal .modal p { color: #64748B; font-size: 14px; }

        .enrollment-detail-card {
            background: #F8FAFC;
            border-radius: 14px;
            padding: 16px 20px;
            border: 1px solid #F1F5F9;
            margin-bottom: 16px;
        }
        .enrollment-detail-card .row {
            display: flex; justify-content: space-between;
            padding: 4px 0;
            font-size: 14px;
        }
        .enrollment-detail-card .row .label { color: #64748B; }
        .enrollment-detail-card .row .value { font-weight: 500; }
        .enrollment-detail-card .total-row {
            border-top: 1px solid #E2E8F0;
            padding-top: 8px;
            margin-top: 4px;
            font-weight: 700;
            font-size: 15px;
        }

        .modal-history {
            background: #F8FAFC;
            border-radius: 14px;
            padding: 16px 20px;
            border: 1px solid #F1F5F9;
            max-height: 280px;
            overflow-y: auto;
        }
        .modal-history h5 {
            font-weight: 600;
            font-size: 14px;
            color: #0F172A;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .modal-history h5 i { color: #6D4AFF; }
        .modal-history-item {
            padding: 8px 0;
            border-bottom: 1px solid #E2E8F0;
            font-size: 13px;
        }
        .modal-history-item:last-child { border-bottom: none; }
        .modal-history-item .mh-amount { font-weight: 600; color: #10B981; }
        .modal-history-item .mh-date { color: #94A3B8; font-size: 12px; }

        .receipt-preview {
            background: #fff;
            border-radius: 14px;
            padding: 16px 20px;
            border: 1px solid #E2E8F0;
            margin-top: 12px;
        }
        .receipt-preview h5 {
            font-weight: 600;
            font-size: 14px;
            color: #0F172A;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .receipt-preview h5 i { color: #6D4AFF; }
        .receipt-preview .receipt-row {
            display: flex; justify-content: space-between;
            padding: 3px 0;
            font-size: 13px;
        }
        .receipt-preview .receipt-total {
            border-top: 1px solid #E2E8F0;
            padding-top: 6px;
            margin-top: 4px;
            font-weight: 700;
        }
        .receipt-actions {
            display: flex;
            gap: 10px;
            margin-top: 12px;
            flex-wrap: wrap;
        }
        .receipt-actions .btn-outline, .receipt-actions .btn-primary {
            padding: 6px 16px;
            font-size: 12px;
        }

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

        .search-select-wrapper { position: relative; }
        .search-select-wrapper input[type="text"] {
            width: 100%;
            padding: 10px 14px;
            border-radius: 12px;
            border: 1.5px solid #E2E8F0;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: 0.15s;
            background: #fff;
        }
        .search-select-wrapper input[type="text"]:focus {
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
        .search-select-dropdown .option:hover { background: #F8FAFC; }
        .search-select-dropdown .option.selected { background: #EDE7FF; color: #6D4AFF; }
        .search-select-dropdown .option .sub { font-size: 12px; color: #94A3B8; }

        @media print {
            body * { visibility: hidden; }
            #receiptContent, #receiptContent * { visibility: visible; }
            #receiptContent { position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); width: 380px; background: #fff; padding: 20px; border-radius: 12px; }
            .receipt-actions { display: none !important; }
            .modal-header { display: none !important; }
            .modal-close { display: none !important; }
        }

        @media (max-width: 1024px) {
            .payment-layout { grid-template-columns: 1fr; }
            .modal-grid { grid-template-columns: 1fr; }
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

    <!-- ─── SIDEBAR ─── -->
      @include('admin.sidebar')


    <!-- ─── MAIN ─── -->
    <div class="main">

        <!-- TOP HEADER -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
                <div>
                    <h2>Fee Payments</h2>
                    <div class="breadcrumb">Dashboard / <span>Fee Payments</span></div>
                </div>
            </div>
            <div class="topbar-right">
                <div class="search-box"><i class="fas fa-search"></i><input type="text" placeholder="Search payments..." id="globalSearch" oninput="filterTable()"></div>
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
                <h3>Payment List</h3>
                <button class="btn-primary" id="addPaymentBtn"><i class="fas fa-plus"></i> Record Payment</button>
            </div>

            <div class="filters-bar">
                <input type="text" placeholder="Search student..." style="flex:1; min-width:140px;" id="filterSearch" oninput="filterTable()">
                <select id="filterMethod" onchange="filterTable()">
                    <option value="">All Methods</option>
                    <option value="Cash">Cash</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="JazzCash">JazzCash</option>
                    <option value="EasyPaisa">EasyPaisa</option>
                </select>
                <button class="btn-reset" onclick="resetFilters()"><i class="fas fa-redo"></i> Reset</button>
            </div>

            <div class="payment-layout">
                <!-- Main Table -->
                <div class="table-card">
                    <table>
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Receipt No</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="paymentTableBody">
                            <tr><td colspan="7" style="text-align:center; padding:40px; color:#94A3B8;">Loading payments...</td></tr>
                        </tbody>
                    </table>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:16px; flex-wrap:wrap; gap:10px;">
                        <span style="font-size:14px; color:#64748B;" id="recordCount">Loading...</span>
                        <div style="display:flex; gap:6px;" id="paginationControls"></div>
                    </div>
                </div>

                <!-- Right Side: Payment History -->
                <div class="history-card" id="historyCard">
                    <h4><i class="fas fa-clock"></i> Payment History</h4>
                    <div id="historyList">
                        <div class="history-empty">Loading history...</div>
                    </div>
                </div>
            </div>

        </div><!-- /content -->
    </div><!-- /main -->

    <!-- ─── ADD PAYMENT MODAL ─── -->
    <div class="modal-overlay" id="addPaymentModal">
        <div class="modal">
            <div class="modal-header">
                <h2><i class="fas fa-dollar-sign" style="color:#6D4AFF; margin-right:10px;"></i> Record Payment</h2>
                <button class="modal-close" onclick="closeModal('addPaymentModal')"><i class="fas fa-times"></i></button>
            </div>
            <form id="paymentForm" onsubmit="savePayment(event)">
                @csrf
                <input type="hidden" id="paymentId" value="">
                <div class="modal-grid">
                    <div class="modal-left">
                        <div class="form-group" style="margin-bottom:16px;">
                            <label>Select Enrollment *</label>
                            <div class="search-select-wrapper">
                                <input type="text" id="enrollmentSearch" placeholder="Search enrollment..." oninput="filterEnrollments(this.value)" onfocus="document.getElementById('enrollmentDropdown').classList.add('show')">
                                <div class="search-select-dropdown" id="enrollmentDropdown">
                                    @foreach($enrollments ?? [] as $enrollment)
                                        <div class="option" data-value="{{ $enrollment->id }}" onclick="selectEnrollment('{{ $enrollment->id }}', '{{ $enrollment->student->name ?? 'Unknown' }} - {{ $enrollment->course->name ?? 'Unknown' }}', this)">
                                            {{ $enrollment->student->name ?? 'Unknown' }} - {{ $enrollment->course->name ?? 'Unknown' }}
                                            <span class="sub">PKR {{ number_format($enrollment->final_fee, 0) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" id="selectedEnrollment" value="">
                            </div>
                        </div>

                        <div class="form-group"><label>Payment Date *</label><input type="date" id="paymentDate" required></div>

                        <div class="enrollment-detail-card" id="enrollmentDetails">
                            <div class="row"><span class="label">Student</span><span class="value" id="detailStudent">-</span></div>
                            <div class="row"><span class="label">Course</span><span class="value" id="detailCourse">-</span></div>
                            <div class="row"><span class="label">Final Fee</span><span class="value" id="detailFinalFee">PKR 0</span></div>
                            <div class="row"><span class="label">Total Paid</span><span class="value" id="detailTotalPaid">PKR 0</span></div>
                            <div class="row total-row"><span class="label">Remaining</span><span class="value" id="detailRemaining">PKR 0</span></div>
                        </div>

                        <div style="font-weight:600; font-size:15px; margin:12px 0 10px;">Payment Details</div>
                        <div class="form-grid">
                            <div class="form-group"><label>Amount *</label><input type="number" placeholder="Enter amount" id="paymentAmount" required oninput="updateLiveCalculations()"></div>
                            <div class="form-group"><label>Payment Method *</label>
                                <select id="paymentMethod" required>
                                    <option value="">Select Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="JazzCash">JazzCash</option>
                                    <option value="EasyPaisa">EasyPaisa</option>
                                </select>
                            </div>
                            <div class="form-group full-width"><label>Remarks</label><input type="text" placeholder="Optional remarks" id="paymentRemarks"></div>
                        </div>
                    </div>

                    <div class="modal-right">
                        <div class="modal-history" id="modalHistory">
                            <h5><i class="fas fa-history"></i> Payment History</h5>
                            <div id="modalHistoryList">
                                <div class="modal-history-item" style="color:#94A3B8; text-align:center; padding:20px 0;">Select an enrollment to view history</div>
                            </div>
                        </div>

                        <div class="enrollment-detail-card" style="margin-top:12px; background:#EDE7FF; border-color:#6D4AFF;">
                            <div class="row"><span class="label">Current Payment</span><span class="value" id="liveAmount" style="color:#6D4AFF; font-weight:700;">PKR 0</span></div>
                            <div class="row"><span class="label">New Total Paid</span><span class="value" id="liveTotalPaid" style="color:#10B981; font-weight:700;">PKR 0</span></div>
                            <div class="row total-row"><span class="label">New Remaining</span><span class="value" id="liveRemaining" style="color:#F59E0B; font-weight:700;">PKR 0</span></div>
                        </div>

                        <div class="receipt-preview" id="receiptPreview">
                            <h5><i class="fas fa-receipt"></i> Receipt Preview</h5>
                            <div id="receiptContent">
                                <div class="receipt-row"><span>Student</span><span id="receiptStudent">-</span></div>
                                <div class="receipt-row"><span>Course</span><span id="receiptCourse">-</span></div>
                                <div class="receipt-row"><span>Amount Paid</span><span id="receiptAmount">PKR 0</span></div>
                                <div class="receipt-row"><span>Method</span><span id="receiptMethod">-</span></div>
                                <div class="receipt-row"><span>Date</span><span id="receiptDate">-</span></div>
                                <div class="receipt-row receipt-total"><span>Remaining</span><span id="receiptRemaining">PKR 0</span></div>
                            </div>
                            <div class="receipt-actions">
                                <button type="button" class="btn-primary" onclick="downloadPDF()"><i class="fas fa-file-pdf"></i> PDF</button>
                                <button type="button" class="btn-primary" style="background:#3B82F6; box-shadow:0 6px 14px -6px rgba(59,130,246,0.3);" onclick="downloadPNG()"><i class="fas fa-image"></i> PNG</button>
                                <button type="button" class="btn-outline" onclick="printReceipt()"><i class="fas fa-print"></i> Print</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-outline" onclick="closeModal('addPaymentModal')">Cancel</button>
                    <button type="submit" class="btn-primary" id="saveBtn"><i class="fas fa-save"></i> Record Payment</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ─── DELETE MODAL ─── -->
    <div class="modal-overlay delete-modal" id="deleteModal">
        <div class="modal">
            <div class="icon"><i class="fas fa-exclamation-circle"></i></div>
            <h3>Delete Payment</h3>
            <p>Are you sure you want to delete this payment? This action cannot be undone.</p>
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
        let payments = [];
        let currentPage = 1;
        const perPage = 10;
        let deleteId = null;
        let selectedEnrollmentId = null;
        let enrollmentData = {};

        // ─── CSRF Token ───
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // ─── Load Payments ───
        async function loadPayments() {
            try {
                const response = await fetch('{{ route("admin.fee-payments.index") }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                payments = data.data || [];
                renderTable();
                updateHistory();
            } catch (error) {
                console.error('Error loading payments:', error);
                showToast('⚠️ Error loading payments');
                document.getElementById('paymentTableBody').innerHTML = `
                    <tr><td colspan="7" style="text-align:center; padding:40px; color:#94A3B8;">
                        <i class="fas fa-exclamation-circle" style="font-size:24px; display:block; margin-bottom:8px;"></i>
                        Failed to load payments. Please refresh the page.
                    </td></tr>
                `;
            }
        }

        // ─── Render Table ───
        function renderTable() {
            const filtered = getFilteredPayments();
            const total = filtered.length;
            const totalPages = Math.ceil(total / perPage);
            if (currentPage > totalPages) currentPage = totalPages || 1;
            const start = (currentPage - 1) * perPage;
            const pageData = filtered.slice(start, start + perPage);

            const tbody = document.getElementById('paymentTableBody');
            if (pageData.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" style="text-align:center; padding:40px; color:#94A3B8;">No payments found</td></tr>`;
            } else {
                tbody.innerHTML = pageData.map(p => {
                    const studentName = p.enrollment && p.enrollment.student ? p.enrollment.student.name : 'Unknown';
                    const courseName = p.enrollment && p.enrollment.course ? p.enrollment.course.name : 'Unknown';
                    const initials = studentName.split(' ').map(w => w[0]).join('').toUpperCase();
                    const colors = ['purple', 'blue', 'green', 'orange'];
                    const colorIndex = (p.id || 0) % colors.length;
                    const date = p.payment_date ? new Date(p.payment_date).toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' }) : '-';
                    
                    return `
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div class="avatar-sm ${colors[colorIndex]}">${initials}</div>
                                    ${studentName}
                                </div>
                            </td>
                            <td>${courseName}</td>
                            <td><strong>${p.receipt_no || '-'}</strong></td>
                            <td>PKR ${parseFloat(p.amount).toLocaleString()}</td>
                            <td>${p.payment_method || '-'}</td>
                            <td>${date}</td>
                            <td>
                                <div class="action-dropdown">
                                    <button class="dropdown-trigger" onclick="toggleDD(this)"><i class="fas fa-ellipsis-v"></i></button>
                                    <div class="dd-menu">
                                        <a href="#" onclick="viewPayment(${p.id}); return false;"><i class="fas fa-eye"></i> View</a>
                                        <a href="#" onclick="editPayment(${p.id}); return false;"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="#" onclick="deletePayment(${p.id}); return false;"><i class="fas fa-trash"></i> Delete</a>
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
            if (payments.length === 0) {
                historyList.innerHTML = '<div class="history-empty">No payments found</div>';
                return;
            }
            
            const recent = payments.slice(0, 5);
            historyList.innerHTML = recent.map(p => {
                const studentName = p.enrollment && p.enrollment.student ? p.enrollment.student.name : 'Unknown';
                const courseName = p.enrollment && p.enrollment.course ? p.enrollment.course.name : 'Unknown';
                const date = p.payment_date ? new Date(p.payment_date).toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' }) : '-';
                return `
                    <div class="history-item">
                        <div class="student-name">${studentName}</div>
                        <span class="course-name">${courseName}</span>
                        <span class="date">${date} • <span class="amount">PKR ${parseFloat(p.amount).toLocaleString()}</span></span>
                        <span class="remarks">${p.payment_method} - ${p.remarks || 'No remarks'}</span>
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
        function getFilteredPayments() {
            const search = document.getElementById('filterSearch').value.toLowerCase().trim();
            const method = document.getElementById('filterMethod').value;
            return payments.filter(p => {
                const studentName = p.enrollment && p.enrollment.student ? p.enrollment.student.name.toLowerCase() : '';
                const courseName = p.enrollment && p.enrollment.course ? p.enrollment.course.name.toLowerCase() : '';
                const matchSearch = search === '' || studentName.includes(search) || courseName.includes(search);
                const matchMethod = method === '' || (p.payment_method && p.payment_method === method);
                return matchSearch && matchMethod;
            });
        }

        function filterTable() {
            currentPage = 1;
            renderTable();
        }

        function resetFilters() {
            document.getElementById('filterSearch').value = '';
            document.getElementById('filterMethod').value = '';
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

        // ─── Enrollment Search ───
        function filterEnrollments(query) {
            const dropdown = document.getElementById('enrollmentDropdown');
            const options = dropdown.querySelectorAll('.option');
            const search = query.toLowerCase().trim();
            options.forEach(opt => {
                const text = opt.textContent.toLowerCase();
                opt.style.display = (search === '' || text.includes(search)) ? 'block' : 'none';
            });
            dropdown.classList.add('show');
        }

        function selectEnrollment(id, displayName, element) {
            selectedEnrollmentId = id;
            document.getElementById('enrollmentSearch').value = displayName;
            document.getElementById('selectedEnrollment').value = id;
            document.getElementById('enrollmentDropdown').classList.remove('show');
            document.querySelectorAll('#enrollmentDropdown .option').forEach(opt => opt.classList.remove('selected'));
            if (element) element.classList.add('selected');
            loadEnrollmentDetails(id);
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.search-select-wrapper')) {
                document.getElementById('enrollmentDropdown').classList.remove('show');
            }
        });

        // ─── Load Enrollment Details ───
        async function loadEnrollmentDetails(id) {
            try {
                const response = await fetch(`/admin/fee-payments/enrollment/${id}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                if (data.success) {
                    const d = data.data;
                    enrollmentData = d;
                    
                    document.getElementById('detailStudent').textContent = d.enrollment.student.name;
                    document.getElementById('detailCourse').textContent = d.enrollment.course.name;
                    document.getElementById('detailFinalFee').textContent = 'PKR ' + parseFloat(d.enrollment.final_fee).toLocaleString();
                    document.getElementById('detailTotalPaid').textContent = 'PKR ' + parseFloat(d.total_paid).toLocaleString();
                    const remEl = document.getElementById('detailRemaining');
                    remEl.textContent = 'PKR ' + parseFloat(d.remaining).toLocaleString();
                    remEl.style.color = d.remaining === 0 ? '#10B981' : '#F59E0B';
                    
                    // Update history
                    let historyHtml = d.payments.length === 0 ? 
                        '<div class="modal-history-item" style="color:#94A3B8; text-align:center; padding:20px 0;">No payments recorded yet</div>' :
                        d.payments.map(p => `
                            <div class="modal-history-item">
                                <span class="mh-amount">PKR ${parseFloat(p.amount).toLocaleString()}</span>
                                <span class="mh-date">${new Date(p.payment_date).toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' })} • ${p.payment_method}</span>
                                <div style="font-size:12px; color:#64748B;">${p.remarks || 'No remarks'}</div>
                            </div>
                        `).join('');
                    document.getElementById('modalHistoryList').innerHTML = historyHtml;
                    
                    updateLiveCalculations();
                }
            } catch (error) {
                showToast('⚠️ Error loading enrollment details');
            }
        }

        // ─── Live Calculations ───
        function updateLiveCalculations() {
            const amount = parseInt(document.getElementById('paymentAmount').value) || 0;
            const remaining = parseFloat(document.getElementById('detailRemaining').textContent.replace(/[^0-9.]/g, '')) || 0;
            
            document.getElementById('liveAmount').textContent = 'PKR ' + amount.toLocaleString();
            
            const newPaid = (parseFloat(document.getElementById('detailTotalPaid').textContent.replace(/[^0-9.]/g, '')) || 0) + amount;
            document.getElementById('liveTotalPaid').textContent = 'PKR ' + newPaid.toLocaleString();
            
            const newRemaining = remaining - amount;
            const remEl = document.getElementById('liveRemaining');
            remEl.textContent = 'PKR ' + (newRemaining > 0 ? newRemaining : 0).toLocaleString();
            remEl.style.color = newRemaining <= 0 ? '#10B981' : '#F59E0B';
            
            updateReceiptPreview();
        }

        // ─── Receipt Preview ───
        function updateReceiptPreview() {
            const student = document.getElementById('detailStudent').textContent;
            const course = document.getElementById('detailCourse').textContent;
            const amount = parseInt(document.getElementById('paymentAmount').value) || 0;
            const method = document.getElementById('paymentMethod').value || '-';
            const date = document.getElementById('paymentDate').value;
            const remaining = parseFloat(document.getElementById('detailRemaining').textContent.replace(/[^0-9.]/g, '')) || 0;
            
            document.getElementById('receiptStudent').textContent = student !== '-' ? student : '-';
            document.getElementById('receiptCourse').textContent = course !== '-' ? course : '-';
            document.getElementById('receiptAmount').textContent = 'PKR ' + (amount > 0 ? amount.toLocaleString() : '0');
            document.getElementById('receiptMethod').textContent = method;
            document.getElementById('receiptDate').textContent = date ? new Date(date).toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' }) : '-';
            const newRemaining = remaining - amount;
            document.getElementById('receiptRemaining').textContent = 'PKR ' + (newRemaining > 0 ? newRemaining : 0).toLocaleString();
        }

        // ─── PDF Download ───
        function downloadPDF() {
            const receiptEl = document.getElementById('receiptContent');
            if (!receiptEl || receiptEl.textContent.includes('-')) {
                showToast('⚠️ Please select an enrollment and enter payment details');
                return;
            }
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'mm', 'a4');
            html2canvas(receiptEl, { scale: 2, useCORS: true, logging: false, backgroundColor: '#ffffff' })
                .then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const pdfWidth = 190;
                    const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
                    doc.addImage(imgData, 'PNG', 10, 10, pdfWidth, pdfHeight);
                    doc.save('receipt.pdf');
                    showToast('📄 PDF downloaded successfully!');
                });
        }

        // ─── PNG Download ───
        function downloadPNG() {
            const receiptEl = document.getElementById('receiptContent');
            if (!receiptEl || receiptEl.textContent.includes('-')) {
                showToast('⚠️ Please select an enrollment and enter payment details');
                return;
            }
            html2canvas(receiptEl, { scale: 2, useCORS: true, logging: false, backgroundColor: '#ffffff' })
                .then(canvas => {
                    const link = document.createElement('a');
                    link.download = 'receipt.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                    showToast('🖼️ PNG downloaded successfully!');
                });
        }

        // ─── Print Receipt ───
        function printReceipt() {
            const receiptEl = document.getElementById('receiptContent');
            if (!receiptEl || receiptEl.textContent.includes('-')) {
                showToast('⚠️ Please select an enrollment and enter payment details');
                return;
            }
            window.print();
        }

        // ─── Add Payment ───
        document.getElementById('addPaymentBtn').addEventListener('click', () => {
            document.getElementById('paymentForm').reset();
            document.getElementById('paymentId').value = '';
            document.getElementById('paymentDate').value = new Date().toISOString().split('T')[0];
            document.getElementById('enrollmentSearch').value = '';
            document.getElementById('selectedEnrollment').value = '';
            document.getElementById('paymentAmount').value = '';
            selectedEnrollmentId = null;
            document.querySelectorAll('#enrollmentDropdown .option').forEach(opt => opt.classList.remove('selected'));
            document.getElementById('saveBtn').innerHTML = '<i class="fas fa-save"></i> Record Payment';
            
            // Reset details
            ['detailStudent','detailCourse','detailFinalFee','detailTotalPaid','detailRemaining'].forEach(id => {
                document.getElementById(id).textContent = id.includes('Fee') || id.includes('Paid') || id.includes('Remaining') ? 'PKR 0' : '-';
            });
            document.getElementById('modalHistoryList').innerHTML = '<div class="modal-history-item" style="color:#94A3B8; text-align:center; padding:20px 0;">Select an enrollment to view history</div>';
            ['liveAmount','liveTotalPaid','liveRemaining'].forEach(id => {
                document.getElementById(id).textContent = 'PKR 0';
            });
            ['receiptStudent','receiptCourse','receiptAmount','receiptMethod','receiptDate','receiptRemaining'].forEach(id => {
                document.getElementById(id).textContent = id.includes('Amount') || id.includes('Remaining') ? 'PKR 0' : '-';
            });
            
            openModal('addPaymentModal');
        });

        // ─── Save Payment ───
        async function savePayment(e) {
            e.preventDefault();
            const id = document.getElementById('paymentId').value;
            const enrollmentId = document.getElementById('selectedEnrollment').value;
            const amount = parseInt(document.getElementById('paymentAmount').value);
            const method = document.getElementById('paymentMethod').value;
            const remarks = document.getElementById('paymentRemarks').value || '';
            const date = document.getElementById('paymentDate').value;
            
            if (!enrollmentId) { showToast('⚠️ Please select an enrollment'); return; }
            if (!amount || amount <= 0) { showToast('⚠️ Please enter a valid amount'); return; }
            if (!method) { showToast('⚠️ Please select a payment method'); return; }
            
            const formData = {
                enrollment_id: enrollmentId,
                amount: amount,
                payment_method: method,
                payment_date: date,
                remarks: remarks
            };

            const url = id ? `/admin/fee-payments/${id}` : '{{ route("admin.fee-payments.store") }}';
            const methodType = id ? 'PUT' : 'POST';

            try {
                const response = await fetch(url, {
                    method: methodType,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();

                if (result.success) {
                    showToast(result.message);
                    closeModal('addPaymentModal');
                    loadPayments();
                } else {
                    if (result.errors) {
                        const errors = Object.values(result.errors).flat().join('\n');
                        showToast('❌ Validation Error: ' + errors);
                    } else {
                        showToast('❌ ' + (result.message || 'Error saving payment'));
                    }
                }
            } catch (error) {
                showToast('⚠️ Error saving payment');
            }
        }

        // ─── View Payment ───
        async function viewPayment(id) {
            try {
                const response = await fetch(`/admin/fee-payments/${id}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                const p = data.data;
                const studentName = p.enrollment && p.enrollment.student ? p.enrollment.student.name : 'Unknown';
                const courseName = p.enrollment && p.enrollment.course ? p.enrollment.course.name : 'Unknown';
                const date = p.payment_date ? new Date(p.payment_date).toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' }) : '-';
                alert(`💳 Payment Details\n\nStudent: ${studentName}\nCourse: ${courseName}\nReceipt: ${p.receipt_no}\nAmount: PKR ${parseFloat(p.amount).toLocaleString()}\nMethod: ${p.payment_method}\nDate: ${date}\nRemarks: ${p.remarks || 'None'}`);
            } catch (error) {
                showToast('⚠️ Error loading payment details');
            }
        }

        // ─── Edit Payment ───
        async function editPayment(id) {
            try {
                const response = await fetch(`/admin/fee-payments/${id}/edit`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                const p = data.data;

                document.getElementById('paymentId').value = p.id;
                document.getElementById('saveBtn').innerHTML = '<i class="fas fa-save"></i> Update Payment';
                document.getElementById('paymentDate').value = p.payment_date || '';
                document.getElementById('paymentAmount').value = p.amount || '';
                document.getElementById('paymentMethod').value = p.payment_method || '';
                document.getElementById('paymentRemarks').value = p.remarks || '';
                
                // Select enrollment
                const enrollOpt = document.querySelector(`#enrollmentDropdown .option[data-value="${p.enrollment_id}"]`);
                if (enrollOpt) {
                    selectEnrollment(p.enrollment_id, enrollOpt.textContent.trim(), enrollOpt);
                }
                
                // Update modal title
                document.querySelector('#addPaymentModal .modal-header h2').innerHTML = '<i class="fas fa-edit" style="color:#6D4AFF; margin-right:10px;"></i> Edit Payment';
                
                openModal('addPaymentModal');
            } catch (error) {
                showToast('⚠️ Error loading payment data');
            }
        }

        // ─── Delete Payment ───
        function deletePayment(id) {
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
                    const response = await fetch(`/admin/fee-payments/${deleteId}`, {
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
                        loadPayments();
                    } else {
                        showToast('⚠️ ' + (result.message || 'Cannot delete payment'));
                        closeDeleteModal();
                    }
                } catch (error) {
                    showToast('⚠️ Error deleting payment');
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

        // ─── Event Listeners ───
        document.getElementById('paymentAmount').addEventListener('input', updateLiveCalculations);
        document.getElementById('paymentMethod').addEventListener('change', updateReceiptPreview);
        document.getElementById('paymentDate').addEventListener('change', updateReceiptPreview);

        // ─── Init ───
        loadPayments();
    </script>
</body>
</html>