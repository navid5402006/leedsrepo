{{-- resources/views/admin/talent-test.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leeds Institute · Talent Test Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <style>
        /* [All existing CSS remains exactly the same - keeping the design system unchanged] */
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #F0F2F5;
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

        /* Main Content */
        .main {
            flex: 1;
            background: #F0F2F5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
        .topbar {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(12px);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            position: sticky;
            top: 0;
            z-index: 40;
        }
        .topbar-left { display: flex; align-items: center; gap: 16px; }
        .topbar-left .menu-toggle {
            background: transparent;
            border: none;
            font-size: 20px;
            color: #1E293B;
            cursor: pointer;
            display: none;
            padding: 6px 8px;
            border-radius: 8px;
            transition: background 0.15s;
        }
        .topbar-left .menu-toggle:hover { background: #F1F5F9; }
        .topbar-left .page-title h2 {
            font-weight: 700;
            font-size: 20px;
            color: #0A1628;
            letter-spacing: -0.3px;
        }
        .topbar-left .page-title .subtitle {
            font-size: 13px;
            color: #94A3B8;
            margin-top: 1px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .search-box {
            position: relative;
            background: #F1F5F9;
            border-radius: 30px;
            padding: 7px 16px 7px 42px;
            border: 1.5px solid transparent;
            transition: all 0.25s;
            display: flex;
            align-items: center;
            width: 240px;
        }
        .search-box:focus-within {
            border-color: #6D4AFF;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(109,74,255,0.08);
        }
        .search-box i {
            position: absolute;
            left: 16px;
            color: #94A3B8;
            font-size: 14px;
        }
        .search-box input {
            background: transparent;
            border: none;
            padding: 6px 0;
            width: 100%;
            outline: none;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
        }

        .notif-btn {
            background: transparent;
            border: none;
            font-size: 18px;
            color: #475569;
            cursor: pointer;
            padding: 8px;
            border-radius: 30px;
            transition: background 0.15s;
            position: relative;
        }
        .notif-btn:hover { background: #F1F5F9; }
        .notif-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            background: #EF4444;
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            border-radius: 30px;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
        }

        .profile-dropdown-wrap { position: relative; }
        .profile-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 14px 4px 4px;
            border-radius: 40px;
            background: #F1F5F9;
            border: none;
            cursor: pointer;
            transition: background 0.15s;
        }
        .profile-btn:hover { background: #E2E8F0; }
        .profile-btn .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6D4AFF, #8B6FFF);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 14px;
        }
        .profile-btn .name {
            font-weight: 500;
            font-size: 14px;
            color: #1E293B;
        }
        .profile-btn .chevron {
            font-size: 12px;
            color: #94A3B8;
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 48px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px -12px rgba(0,0,0,0.2);
            min-width: 220px;
            padding: 8px 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(8px) scale(0.96);
            transition: all 0.2s ease;
            border: 1px solid #F1F5F9;
        }
        .dropdown-menu.open {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }
        .dropdown-menu .dropdown-header {
            padding: 10px 18px 6px;
            font-size: 11px;
            font-weight: 600;
            color: #94A3B8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 9px 18px;
            color: #1E293B;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: background 0.1s;
        }
        .dropdown-menu a:hover { background: #F8FAFC; }
        .dropdown-menu a i { width: 18px; color: #64748B; font-size: 14px; }
        .dropdown-divider { height: 1px; background: #F1F5F9; margin: 6px 12px; }

        .content { padding: 28px 32px 40px 32px; flex:1; }

        /* [All remaining CSS stays exactly the same] */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }
        .page-header h3 {
            font-size: 24px;
            font-weight: 700;
            color: #0A1628;
        }
        .page-header .desc {
            font-size: 14px;
            color: #64748B;
            margin-top: 2px;
        }
        .page-header .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: #6D4AFF;
            border: none;
            padding: 10px 22px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 13px;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.15s;
            box-shadow: 0 4px 14px rgba(109,74,255,0.25);
            font-family: 'Inter', sans-serif;
        }
        .btn-primary:hover { background: #5a3de0; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(109,74,255,0.35); }
        .btn-primary:active { transform: scale(0.97); }

        .btn-outline {
            background: transparent;
            border: 1.5px solid #E2E8F0;
            padding: 9px 20px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 13px;
            color: #475569;
            cursor: pointer;
            transition: 0.15s;
            font-family: 'Inter', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-outline:hover { background: #F1F5F9; }

        .btn-success {
            background: #10B981;
            border: none;
            padding: 10px 22px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 13px;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: 0.15s;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 4px 14px rgba(16,185,129,0.25);
        }
        .btn-success:hover { background: #0ea373; transform: translateY(-2px); }

        .btn-danger {
            background: #EF4444;
            border: none;
            padding: 10px 22px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 13px;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: 0.15s;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 4px 14px rgba(239,68,68,0.25);
        }
        .btn-danger:hover { background: #DC2626; transform: translateY(-2px); }

        .btn-export-pdf { background: #FEE2E2; color: #DC2626; border: none; padding: 9px 18px; border-radius: 40px; font-weight: 600; font-size: 13px; cursor: pointer; transition: 0.15s; font-family: 'Inter', sans-serif; display: inline-flex; align-items: center; gap: 6px; }
        .btn-export-pdf:hover { background: #FECACA; }

        .btn-export-excel { background: #DCFCE7; color: #10B981; border: none; padding: 9px 18px; border-radius: 40px; font-weight: 600; font-size: 13px; cursor: pointer; transition: 0.15s; font-family: 'Inter', sans-serif; display: inline-flex; align-items: center; gap: 6px; }
        .btn-export-excel:hover { background: #BBF7D0; }

        .btn-print { background: #F1F5F9; color: #1E293B; border: none; padding: 9px 18px; border-radius: 40px; font-weight: 600; font-size: 13px; cursor: pointer; transition: 0.15s; font-family: 'Inter', sans-serif; display: inline-flex; align-items: center; gap: 6px; }
        .btn-print:hover { background: #E2E8F0; }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 18px 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            border: 1px solid #F1F5F9;
            transition: all 0.3s;
        }
        .stat-card:hover {
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }
        .stat-card .label {
            font-size: 12px;
            font-weight: 500;
            color: #94A3B8;
        }
        .stat-card .value {
            font-size: 26px;
            font-weight: 700;
            color: #0A1628;
            margin-top: 2px;
        }
        .stat-card .change {
            font-size: 11px;
            font-weight: 600;
            margin-top: 2px;
        }
        .stat-card .change.up { color: #10B981; }
        .stat-card .change.down { color: #EF4444; }

        /* Tabs */
        .tabs-container {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #F1F5F9;
            padding: 6px;
            display: flex;
            gap: 4px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        .tab-btn {
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.25s;
            font-family: 'Inter', sans-serif;
            background: transparent;
            color: #64748B;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .tab-btn:hover { background: #F1F5F9; color: #1E293B; }
        .tab-btn.active {
            background: #6D4AFF;
            color: #fff;
            box-shadow: 0 4px 14px rgba(109,74,255,0.25);
        }
        .tab-btn .badge {
            background: rgba(255,255,255,0.2);
            padding: 0 10px;
            border-radius: 30px;
            font-size: 11px;
        }
        .tab-btn.active .badge { background: rgba(255,255,255,0.2); }

        .tab-content {
            display: none;
            animation: fadeIn 0.3s ease;
        }
        .tab-content.active { display: block; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }

        /* Toolbar */
        .toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            background: #fff;
            padding: 14px 20px;
            border-radius: 14px;
            border: 1px solid #F1F5F9;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        .toolbar input, .toolbar select {
            padding: 8px 14px;
            border-radius: 30px;
            border: 1.5px solid #E2E8F0;
            background: #F8FAFC;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            color: #1E293B;
            outline: none;
            transition: 0.15s;
        }
        .toolbar input:focus, .toolbar select:focus {
            border-color: #6D4AFF;
            box-shadow: 0 0 0 3px rgba(109,74,255,0.08);
        }
        .toolbar .btn-reset {
            background: transparent;
            border: 1.5px solid #E2E8F0;
            padding: 8px 18px;
            border-radius: 30px;
            font-weight: 500;
            font-size: 13px;
            color: #475569;
            cursor: pointer;
            transition: 0.15s;
            font-family: 'Inter', sans-serif;
        }
        .toolbar .btn-reset:hover { background: #F1F5F9; }

        /* Table Card */
        .table-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #F1F5F9;
            padding: 20px 24px 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            overflow-x: auto;
        }
        .table-card .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
        }
        .table-card .table-header h4 {
            font-size: 16px;
            font-weight: 600;
            color: #0A1628;
        }

        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th {
            text-align: left;
            padding: 10px 8px 10px 0;
            font-weight: 600;
            color: #64748B;
            border-bottom: 1.5px solid #F1F5F9;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            padding: 12px 8px 12px 0;
            border-bottom: 1px solid #F1F5F9;
            color: #1E293B;
            vertical-align: middle;
        }
        td:last-child { padding-right:0; }
        tr:hover td { background: #F8FAFC; }

        .status-badge {
            font-size: 11px;
            font-weight: 600;
            padding: 3px 14px;
            border-radius: 40px;
            display: inline-block;
        }
        .status-badge.pending { background: #FEF3C7; color: #D97706; }
        .status-badge.pass { background: #DCFCE7; color: #10B981; }
        .status-badge.fail { background: #FEE2E2; color: #DC2626; }

        .action-btn {
            background: transparent;
            border: none;
            color: #94A3B8;
            padding: 4px 8px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.1s;
            font-size: 14px;
        }
        .action-btn:hover { background: #F1F5F9; color: #1E293B; }
        .action-btn.primary:hover { color: #6D4AFF; }
        .action-btn.success:hover { color: #10B981; }
        .action-btn.danger:hover { color: #EF4444; }

        .action-dropdown { position: relative; display: inline-block; }
        .action-dropdown .dropdown-trigger {
            background: transparent; border: none; color: #94A3B8;
            padding: 4px 8px; border-radius: 6px; cursor: pointer; transition: 0.1s;
        }
        .action-dropdown .dropdown-trigger:hover { background: #F1F5F9; color:#1E293B; }
        .action-dropdown .dd-menu {
            position: absolute; right: 0; top: 28px; background: #fff;
            border-radius: 12px; box-shadow: 0 20px 40px -12px rgba(0,0,0,0.15);
            min-width: 180px; padding: 6px 0; border: 1px solid #F1F5F9;
            opacity: 0; visibility: hidden; transform: translateY(6px);
            transition: all 0.15s; z-index: 20;
        }
        .action-dropdown .dd-menu.open { opacity: 1; visibility: visible; transform: translateY(0); }
        .action-dropdown .dd-menu a {
            display: flex; align-items: center; gap: 10px; padding: 8px 16px;
            font-size: 13px; color: #1E293B; text-decoration: none; transition: 0.1s;
        }
        .action-dropdown .dd-menu a:hover { background: #F8FAFC; }
        .action-dropdown .dd-menu a i { width: 18px; color: #64748B; }

        /* Modal */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(15,23,42,0.55);
            backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center;
            z-index: 999; padding: 20px;
        }
        .modal-overlay.active { display: flex; }
        .modal {
            background: #fff; border-radius: 24px; max-width: 640px; width: 100%;
            max-height: 92vh; overflow-y: auto; padding: 28px 32px 32px;
            box-shadow: 0 40px 80px -20px rgba(0,0,0,0.3);
            animation: modalIn 0.25s ease;
        }
        .modal-wide { max-width: 720px; }
        .modal-large { max-width: 860px; }
        @keyframes modalIn { from { opacity:0; transform: scale(0.96) translateY(20px); } to { opacity:1; transform: scale(1) translateY(0); } }
        .modal-header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;
        }
        .modal-header h2 { font-size: 20px; font-weight: 700; color: #0A1628; }
        .modal-close { background: transparent; border: none; font-size: 24px; color: #94A3B8; cursor: pointer; padding: 6px; }
        .modal-close:hover { color: #1E293B; }

        .modal .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px 20px; }
        .modal .form-group { display: flex; flex-direction: column; gap: 4px; }
        .modal .form-group label { font-weight: 500; font-size: 13px; color: #334155; }
        .modal .form-group label .required { color: #EF4444; }
        .modal .form-group input, .modal .form-group select {
            padding: 9px 12px; border-radius: 10px; border: 1.5px solid #E2E8F0;
            font-size: 13px; font-family: 'Inter', sans-serif; transition: 0.15s; background: #fff;
            width: 100%;
        }
        .modal .form-group input:focus, .modal .form-group select:focus {
            border-color: #6D4AFF; box-shadow: 0 0 0 3px rgba(109,74,255,0.08); outline: none;
        }
        .modal .form-group .readonly-input {
            background: #F8FAFC;
            color: #94A3B8;
            cursor: not-allowed;
        }
        .modal-footer {
            display: flex; justify-content: flex-end; gap: 12px;
            margin-top: 24px; padding-top: 20px; border-top: 1px solid #F1F5F9;
        }
        .modal .result-preview {
            background: #F8FAFC;
            border-radius: 12px;
            padding: 14px 18px;
            border: 1px solid #F1F5F9;
            margin-top: 12px;
        }
        .modal .result-preview .row {
            display: flex; justify-content: space-between; padding: 4px 0;
            font-size: 14px;
        }
        .modal .result-preview .row .label { color: #64748B; }
        .modal .result-preview .row .value { font-weight: 600; }

        .toast {
            position: fixed; bottom: 30px; right: 30px; background: #0A1628;
            color: #fff; padding: 14px 28px; border-radius: 60px;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.25);
            display: flex; align-items: center; gap: 12px; font-weight: 500; font-size: 14px;
            transform: translateY(80px); opacity: 0; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: 9999; border-left: 4px solid #6D4AFF;
        }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast i { color: #8B6FFF; font-size: 18px; }

        .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.3); z-index: 45; }
        .overlay.active { display: block; }

        .loading-spinner {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 3px solid rgba(255,255,255,0.2);
            border-top: 3px solid #6D4AFF;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        .candidate-card {
            background: #F8FAFC;
            border-radius: 12px;
            padding: 14px 16px;
            border: 1px solid #F1F5F9;
            margin-top: 12px;
        }
        .candidate-card .row {
            display: flex; justify-content: space-between; padding: 3px 0;
            font-size: 13px;
        }
        .candidate-card .row .label { color: #64748B; }
        .candidate-card .row .value { font-weight: 500; }

        /* Slip Modal */
        .slip-content {
            max-width: 380px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
        }
        .slip-content .slip-header {
            text-align: center;
            border-bottom: 2px solid #071B3B;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }
        .slip-content .slip-header .logo {
            font-size: 18px;
            font-weight: 800;
            color: #071B3B;
        }
        .slip-content .slip-header .logo span { color: #6D4AFF; }
        .slip-content .slip-header .title {
            font-size: 13px;
            font-weight: 600;
            color: #64748B;
            letter-spacing: 1px;
        }
        .slip-content .slip-body {
            padding: 8px 0;
        }
        .slip-content .slip-body .row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
            font-size: 13px;
            border-bottom: 1px dashed #F1F5F9;
        }
        .slip-content .slip-body .row .label { color: #64748B; }
        .slip-content .slip-body .row .value { font-weight: 600; color: #0A1628; }
        .slip-content .slip-body .roll-number {
            font-size: 28px;
            font-weight: 800;
            color: #6D4AFF;
            text-align: center;
            padding: 8px 0;
        }
        .slip-content .slip-footer {
            text-align: center;
            font-size: 10px;
            color: #94A3B8;
            border-top: 1px solid #F1F5F9;
            padding-top: 10px;
            margin-top: 10px;
        }
        .slip-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 16px;
        }

        /* Confirmation Dialog */
        .confirm-dialog .modal { max-width: 480px; text-align: center; }
        .confirm-dialog .modal .icon { font-size: 48px; color: #F59E0B; margin-bottom: 12px; }
        .confirm-dialog .modal h3 { font-size: 20px; font-weight: 700; margin-bottom: 4px; }
        .confirm-dialog .modal p { color: #64748B; font-size: 14px; margin-bottom: 16px; }

        /* Profile Modal */
        .profile-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin: 16px 0;
        }
        .profile-stat-card {
            background: #F8FAFC;
            border-radius: 10px;
            padding: 12px;
            text-align: center;
            border: 1px solid #F1F5F9;
        }
        .profile-stat-card .num {
            font-size: 20px;
            font-weight: 700;
            color: #0A1628;
        }
        .profile-stat-card .lbl {
            font-size: 11px;
            color: #94A3B8;
            margin-top: 2px;
        }
        .profile-stat-card.purple .num { color: #6D4AFF; }
        .profile-stat-card.green .num { color: #10B981; }
        .profile-stat-card.red .num { color: #EF4444; }
        .profile-stat-card.orange .num { color: #F59E0B; }

        /* Result Detail Modal */
        .result-detail-card {
            background: #F8FAFC;
            border-radius: 12px;
            padding: 16px 20px;
            border: 1px solid #F1F5F9;
            margin: 8px 0;
        }
        .result-detail-card .row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
            font-size: 14px;
        }
        .result-detail-card .row .label { color: #64748B; }
        .result-detail-card .row .value { font-weight: 600; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); width: 270px; position: fixed; top:0; left:0; height:100%; }
            .sidebar.open { transform: translateX(0); }
            .topbar-left .menu-toggle { display: block; }
            .search-box { width: 140px; }
            .content { padding: 16px; }
            .topbar { padding: 12px 16px; }
            .modal .form-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .tabs-container { overflow-x: auto; flex-wrap: nowrap; }
            .tab-btn { white-space: nowrap; }
            .page-header .actions { width: 100%; }
            .page-header .actions .btn { flex: 1; justify-content: center; }
            .profile-stats { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
            .toolbar { flex-direction: column; }
            .toolbar input, .toolbar select { width: 100%; }
            .profile-stats { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div class="overlay" id="overlay"></div>

    <!-- SIDEBAR -->
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
            <li><a href="{{ url('/dashboard') }}"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="{{ url('/admin/students') }}"><i class="fas fa-user-graduate"></i> Students</a></li>
            <li><a href="{{ url('/admin/teachers') }}"><i class="fas fa-chalkboard-teacher"></i> Teachers</a></li>
            <li><a href="{{ url('/admin/courses') }}"><i class="fas fa-book-open"></i> Courses</a></li>

            <li class="menu-label">Management</li>
            <li><a href="{{ url('/admin/enrollments') }}"><i class="fas fa-user-plus"></i> Enrollments</a></li>
            <li><a href="{{ url('/admin/fee-payments') }}"><i class="fas fa-dollar-sign"></i> Fee Payments</a></li>
            <li><a href="{{ url('/admin/student-cards') }}"><i class="fas fa-id-card"></i> Student Cards</a></li>
            <li><a href="{{ url('/admin/certificates') }}"><i class="fas fa-certificate"></i> Certificates</a></li>
            <li class="active"><a href="{{ url('/admin/talent-test') }}"><i class="fas fa-clipboard-list"></i> Talent Test</a></li>

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

    <!-- MAIN -->
    <div class="main">

        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
                <div class="page-title">
                    <h2>Talent Test Management</h2>
                    <div class="subtitle">Dashboard / Talent Test</div>
                </div>
            </div>
            <div class="topbar-right">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search..." id="globalSearch" oninput="filterAll()" />
                </div>
                <button class="notif-btn" onclick="showToast('🔔 No new notifications')">
                    <i class="fas fa-bell"></i>
                    <span class="notif-badge">3</span>
                </button>
                <div class="profile-dropdown-wrap">
                    <button class="profile-btn" id="profileBtn">
                        <div class="avatar">{{ substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1) }}</div>
                        <span class="name">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
                        <i class="fas fa-chevron-down chevron"></i>
                    </button>
                    <div class="dropdown-menu" id="profileDropdown">
                        <div class="dropdown-header">Account</div>
                        <a href="{{ url('/admin/profile') }}"><i class="fas fa-user"></i> View Profile</a>
                        <a href="{{ url('/admin/settings') }}"><i class="fas fa-sliders-h"></i> Account Settings</a>
                        <a href="{{ url('/admin/change-password') }}"><i class="fas fa-key"></i> Change Password</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" onclick="showToast('🌙 Dark mode coming soon!')"><i class="fas fa-moon"></i> Dark Mode</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <a href="#" onclick="this.closest('form').submit(); return false;"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="content">

            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <h3>Talent Test Management</h3>
                    <div class="desc">Register candidates, manage test attempts and publish results.</div>
                </div>
                <div class="actions">
                    <button class="btn-primary" onclick="openRegisterModal()"><i class="fas fa-user-plus"></i> Register Candidate</button>
                    <button class="btn-export-pdf" onclick="showToast('📄 PDF export started')"><i class="fas fa-file-pdf"></i> Export PDF</button>
                    <button class="btn-export-excel" onclick="showToast('📊 Excel export started')"><i class="fas fa-file-excel"></i> Export Excel</button>
                    <button class="btn-print" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>

            <!-- Stats -->
            <div class="stats-grid" id="statsGrid">
                <div class="stat-card">
                    <div class="label">Total Candidates</div>
                    <div class="value" id="totalCandidates">0</div>
                    <div class="change up"><i class="fas fa-arrow-up"></i> 12%</div>
                </div>
                <div class="stat-card">
                    <div class="label">Test Attempts</div>
                    <div class="value" id="totalAttempts">0</div>
                    <div class="change up"><i class="fas fa-arrow-up"></i> 8%</div>
                </div>
                <div class="stat-card">
                    <div class="label">Pending Results</div>
                    <div class="value" id="pendingResults">0</div>
                    <div class="change down"><i class="fas fa-arrow-down"></i> 3%</div>
                </div>
                <div class="stat-card">
                    <div class="label">Published Results</div>
                    <div class="value" id="publishedResults">0</div>
                    <div class="change up"><i class="fas fa-arrow-up"></i> 15%</div>
                </div>
                <div class="stat-card">
                    <div class="label">Average Percentage</div>
                    <div class="value" id="avgPercentage">0%</div>
                    <div class="change up"><i class="fas fa-arrow-up"></i> 5%</div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="tabs-container">
                <button class="tab-btn active" data-tab="tab1" onclick="switchTab('tab1')">
                    <i class="fas fa-users"></i> Candidates <span class="badge" id="candidateBadge">0</span>
                </button>
                <button class="tab-btn" data-tab="tab2" onclick="switchTab('tab2')">
                    <i class="fas fa-file-alt"></i> Test Attempts <span class="badge" id="attemptBadge">0</span>
                </button>
                <button class="tab-btn" data-tab="tab3" onclick="switchTab('tab3')">
                    <i class="fas fa-chart-bar"></i> Results <span class="badge" id="resultBadge">0</span>
                </button>
            </div>

            <!-- ====== TAB 1: CANDIDATES ====== -->
            <div class="tab-content active" id="tab1">
                <div class="toolbar">
                    <input type="text" placeholder="Search Candidate..." id="searchCandidate" oninput="filterCandidates()" style="flex:1; min-width:140px;">
                    <input type="text" placeholder="Search Phone..." id="searchPhone" oninput="filterCandidates()" style="flex:1; min-width:120px;">
                    <input type="date" id="regDateFilter" onchange="filterCandidates()" style="width:150px;">
                    <button class="btn-reset" onclick="resetFilters()"><i class="fas fa-redo"></i> Reset</button>
                    <button class="btn-primary" onclick="openRegisterModal()" style="padding:8px 18px; font-size:12px;"><i class="fas fa-plus"></i> Register Candidate</button>
                </div>

                <div class="table-card">
                    <div class="table-header">
                        <h4><i class="fas fa-users" style="color:#6D4AFF;"></i> Candidates List</h4>
                        <span style="font-size:13px; color:#94A3B8;" id="candidateCount">Showing 0 candidates</span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Candidate ID</th>
                                <th>Candidate Name</th>
                                <th>Father Name</th>
                                <th>Phone Number</th>
                                <th>Total Attempts</th>
                                <th>Last Test Date</th>
                                <th>Registration Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="candidatesTableBody">
                            <tr><td colspan="8" style="text-align:center; padding:40px; color:#94A3B8;"><div class="loading-spinner"></div> Loading candidates...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ====== TAB 2: TEST ATTEMPTS ====== -->
            <div class="tab-content" id="tab2">
                <div class="toolbar">
                    <input type="text" placeholder="Search Roll Number..." id="searchRollNo" oninput="filterAttempts()" style="flex:1; min-width:120px;">
                    <input type="text" placeholder="Search Candidate..." id="searchAttemptCandidate" oninput="filterAttempts()" style="flex:1; min-width:140px;">
                    <input type="date" id="attemptDateFilter" onchange="filterAttempts()" style="width:150px;">
                    <select id="attemptStatusFilter" onchange="filterAttempts()" style="min-width:120px;">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="pass">Pass</option>
                        <option value="fail">Fail</option>
                    </select>
                    <button class="btn-primary" onclick="openNewAttemptModal()" style="padding:8px 18px; font-size:12px;"><i class="fas fa-plus"></i> New Test Attempt</button>
                </div>

                <div class="table-card">
                    <div class="table-header">
                        <h4><i class="fas fa-file-alt" style="color:#6D4AFF;"></i> Test Attempts</h4>
                        <span style="font-size:13px; color:#94A3B8;" id="attemptCount">Showing 0 attempts</span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Roll Number</th>
                                <th>Candidate</th>
                                <th>Father Name</th>
                                <th>Test Date</th>
                                <th>Obtained Marks</th>
                                <th>Percentage</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="attemptsTableBody">
                            <tr><td colspan="8" style="text-align:center; padding:40px; color:#94A3B8;"><div class="loading-spinner"></div> Loading attempts...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ====== TAB 3: RESULTS ====== -->
            <div class="tab-content" id="tab3">
                <div class="toolbar">
                    <input type="text" placeholder="Search Roll Number..." id="searchResultRoll" oninput="filterResults()" style="flex:1; min-width:120px;">
                    <input type="text" placeholder="Search Candidate..." id="searchResultCandidate" oninput="filterResults()" style="flex:1; min-width:140px;">
                    <select id="resultStatusFilter" onchange="filterResults()" style="min-width:120px;">
                        <option value="">All Status</option>
                        <option value="pass">Pass</option>
                        <option value="fail">Fail</option>
                    </select>
                </div>

                <div class="table-card">
                    <div class="table-header">
                        <h4><i class="fas fa-chart-bar" style="color:#6D4AFF;"></i> Results</h4>
                        <span style="font-size:13px; color:#94A3B8;" id="resultCount">Showing 0 results</span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Roll Number</th>
                                <th>Candidate</th>
                                <th>Test Date</th>
                                <th>Obtained Marks</th>
                                <th>Percentage</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="resultsTableBody">
                            <tr><td colspan="7" style="text-align:center; padding:40px; color:#94A3B8;"><div class="loading-spinner"></div> Loading results...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- /content -->
    </div><!-- /main -->

    <!-- ====== REGISTER CANDIDATE MODAL ====== -->
    <div class="modal-overlay" id="registerModal">
        <div class="modal">
            <div class="modal-header">
                <h2><i class="fas fa-user-plus" style="color:#6D4AFF;"></i> Register Candidate</h2>
                <button class="modal-close" onclick="closeModal('registerModal')"><i class="fas fa-times"></i></button>
            </div>
            <form id="registerForm" onsubmit="registerCandidate(event)">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Candidate Name <span class="required">*</span></label>
                        <input type="text" id="regName" placeholder="Full name" required>
                    </div>
                    <div class="form-group">
                        <label>Father Name <span class="required">*</span></label>
                        <input type="text" id="regFather" placeholder="Father's name" required>
                    </div>
                    <div class="form-group">
                        <label>Contact Number <span class="required">*</span></label>
                        <input type="text" id="regPhone" placeholder="+92 300 1234567" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="regEmail" placeholder="candidate@example.com">
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label>Address</label>
                        <input type="text" id="regAddress" placeholder="Residential address">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline" onclick="closeModal('registerModal')">Cancel</button>
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Register Candidate</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ====== NEW TEST ATTEMPT MODAL ====== -->
    <div class="modal-overlay" id="attemptModal">
        <div class="modal modal-wide">
            <div class="modal-header">
                <h2><i class="fas fa-file-alt" style="color:#6D4AFF;"></i> New Test Attempt</h2>
                <button class="modal-close" onclick="closeModal('attemptModal')"><i class="fas fa-times"></i></button>
            </div>
            <form id="attemptForm" onsubmit="createAttempt(event)">
                <div class="form-grid">
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label>Search Candidate <span class="required">*</span></label>
                        <input type="text" id="attemptSearch" placeholder="Type candidate name..." oninput="searchCandidates(this.value)" required>
                        <div id="candidateResults" style="max-height:150px; overflow-y:auto; background:#fff; border:1px solid #E2E8F0; border-radius:8px; display:none; margin-top:4px;"></div>
                        <input type="hidden" id="selectedCandidateId" value="">
                    </div>
                </div>

                <div id="selectedCandidateCard" class="candidate-card" style="display:none;">
                    <div class="row"><span class="label">Candidate Name</span><span class="value" id="selCandidateName">-</span></div>
                    <div class="row"><span class="label">Father Name</span><span class="value" id="selFatherName">-</span></div>
                    <div class="row"><span class="label">Phone Number</span><span class="value" id="selPhone">-</span></div>
                    <div class="row"><span class="label">Previous Attempts</span><span class="value" id="selAttempts">0</span></div>
                </div>

                <div style="margin-top:12px; padding:12px 16px; background:#EDE7FF; border-radius:10px; border:1px solid #6D4AFF; display:none;" id="rollNumberDisplay">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-weight:600; color:#071B3B;">Roll Number:</span>
                        <span style="font-size:20px; font-weight:800; color:#6D4AFF;" id="generatedRollNumber">1100</span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-outline" onclick="closeModal('attemptModal')">Cancel</button>
                    <button type="submit" class="btn-success"><i class="fas fa-plus"></i> Start Test Attempt</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ====== ENTER RESULT MODAL ====== -->
    <div class="modal-overlay" id="resultModal">
        <div class="modal">
            <div class="modal-header">
                <h2><i class="fas fa-pen-fancy" style="color:#6D4AFF;"></i> Enter Result</h2>
                <button class="modal-close" onclick="closeModal('resultModal')"><i class="fas fa-times"></i></button>
            </div>
            <form id="resultForm" onsubmit="saveResult(event)">
                <input type="hidden" id="resultAttemptId" value="">

                <div class="candidate-card" id="resultCandidateCard">
                    <div class="row"><span class="label">Roll Number</span><span class="value" id="resultRollNo">-</span></div>
                    <div class="row"><span class="label">Candidate Name</span><span class="value" id="resultCandidateName">-</span></div>
                    <div class="row"><span class="label">Father Name</span><span class="value" id="resultFatherName">-</span></div>
                </div>

                <div class="form-grid" style="margin-top:16px;">
                    <div class="form-group">
                        <label>Total Marks</label>
                        <input type="text" id="resultTotalMarks" value="100" class="readonly-input" readonly>
                    </div>
                    <div class="form-group">
                        <label>Obtained Marks <span class="required">*</span></label>
                        <input type="number" id="resultObtainedMarks" placeholder="0" min="0" max="100" required oninput="calculateResult()">
                    </div>
                </div>

                <div class="result-preview" id="resultPreview">
                    <div class="row"><span class="label">Percentage</span><span class="value" id="resultPercentage">0%</span></div>
                    <div class="row"><span class="label">Status</span><span class="value" id="resultStatusDisplay"><span class="status-badge pending">Pending</span></span></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-outline" onclick="closeModal('resultModal')">Cancel</button>
                    <button type="submit" class="btn-success"><i class="fas fa-save"></i> Save Result</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ====== CONFIRM DUPLICATE CANDIDATE MODAL ====== -->
    <div class="modal-overlay confirm-dialog" id="confirmDuplicateModal">
        <div class="modal">
            <div class="icon"><i class="fas fa-user-check"></i></div>
            <h3>Candidate Already Registered</h3>
            <p id="duplicateMessage">This candidate is already registered in the Talent Test system.</p>
            <p style="font-size:13px; color:#64748B; margin-bottom:12px;">Would you like to create a new test attempt for this candidate?</p>
            <div style="display:flex; gap:12px; justify-content:center;">
                <button class="btn-outline" onclick="closeDuplicateModal()">Cancel</button>
                <button class="btn-primary" id="confirmDuplicateBtn"><i class="fas fa-plus"></i> Create New Attempt</button>
            </div>
        </div>
    </div>

    <!-- ====== VIEW CANDIDATE PROFILE MODAL ====== -->
    <div class="modal-overlay" id="profileModal">
        <div class="modal modal-large">
            <div class="modal-header">
                <h2><i class="fas fa-user-graduate" style="color:#6D4AFF;"></i> Candidate Profile</h2>
                <button class="modal-close" onclick="closeModal('profileModal')"><i class="fas fa-times"></i></button>
            </div>
            <div id="profileContent">
                <div style="display:flex; gap:20px; align-items:flex-start; flex-wrap:wrap;">
                    <div style="width:80px; height:80px; border-radius:50%; background:linear-gradient(135deg, #6D4AFF, #8B6FFF); display:flex; align-items:center; justify-content:center; font-size:32px; font-weight:700; color:#fff; flex-shrink:0;" id="profileAvatar">A</div>
                    <div style="flex:1; min-width:200px;">
                        <div style="font-size:20px; font-weight:700;" id="profileName">-</div>
                        <div style="font-size:14px; color:#64748B;" id="profileFather">Father: -</div>
                        <div style="font-size:14px; color:#64748B;" id="profilePhone">Phone: -</div>
                        <div style="font-size:14px; color:#64748B;" id="profileEmail">Email: -</div>
                        <div style="font-size:14px; color:#64748B;" id="profileAddress">Address: -</div>
                        <div style="font-size:14px; color:#64748B;" id="profileRegDate">Registered: -</div>
                    </div>
                    <div style="text-align:right; flex-shrink:0;">
                        <div style="font-size:12px; color:#94A3B8;">Total Attempts</div>
                        <div style="font-size:24px; font-weight:700; color:#6D4AFF;" id="profileTotalAttempts">0</div>
                        <div style="font-size:12px; color:#94A3B8; margin-top:4px;">Best Percentage</div>
                        <div style="font-size:20px; font-weight:700; color:#10B981;" id="profileBestPercentage">0%</div>
                        <div style="font-size:12px; color:#94A3B8; margin-top:4px;">Latest Roll Number</div>
                        <div style="font-size:18px; font-weight:700; color:#0A1628;" id="profileLatestRoll">-</div>
                    </div>
                </div>

                <div class="profile-stats" id="profileStats">
                    <div class="profile-stat-card purple">
                        <div class="num" id="profileStatTotal">0</div>
                        <div class="lbl">Total Attempts</div>
                    </div>
                    <div class="profile-stat-card green">
                        <div class="num" id="profileStatPassed">0</div>
                        <div class="lbl">Passed</div>
                    </div>
                    <div class="profile-stat-card red">
                        <div class="num" id="profileStatFailed">0</div>
                        <div class="lbl">Failed</div>
                    </div>
                    <div class="profile-stat-card orange">
                        <div class="num" id="profileStatPending">0</div>
                        <div class="lbl">Pending</div>
                    </div>
                    <div class="profile-stat-card purple">
                        <div class="num" id="profileStatBest">0%</div>
                        <div class="lbl">Best Percentage</div>
                    </div>
                    <div class="profile-stat-card green">
                        <div class="num" id="profileStatLatest">-</div>
                        <div class="lbl">Latest Result</div>
                    </div>
                </div>

                <h4 style="margin:16px 0 12px; font-weight:600; color:#0A1628;"><i class="fas fa-history" style="color:#6D4AFF;"></i> Attempt History</h4>
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Roll Number</th>
                                <th>Test Date</th>
                                <th>Obtained Marks</th>
                                <th>Percentage</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="profileAttemptsBody">
                            <tr><td colspan="6" style="text-align:center; padding:20px; color:#94A3B8;">No attempts found</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== RESULT DETAIL MODAL ====== -->
    <div class="modal-overlay" id="resultDetailModal">
        <div class="modal">
            <div class="modal-header">
                <h2><i class="fas fa-file-alt" style="color:#6D4AFF;"></i> Result Details</h2>
                <button class="modal-close" onclick="closeModal('resultDetailModal')"><i class="fas fa-times"></i></button>
            </div>
            <div id="resultDetailContent">
                <div class="result-detail-card">
                    <div class="row"><span class="label">Candidate Name</span><span class="value" id="rdCandidateName">-</span></div>
                    <div class="row"><span class="label">Father Name</span><span class="value" id="rdFatherName">-</span></div>
                    <div class="row"><span class="label">Roll Number</span><span class="value" id="rdRollNo">-</span></div>
                    <div class="row"><span class="label">Test Date</span><span class="value" id="rdTestDate">-</span></div>
                </div>
                <div class="result-detail-card" style="background:#fff; border:2px solid #6D4AFF;">
                    <div class="row"><span class="label">Obtained Marks</span><span class="value" id="rdObtainedMarks">-</span></div>
                    <div class="row"><span class="label">Total Marks</span><span class="value" id="rdTotalMarks">100</span></div>
                    <div class="row"><span class="label">Percentage</span><span class="value" id="rdPercentage">-</span></div>
                    <div class="row"><span class="label">Status</span><span class="value" id="rdStatus">-</span></div>
                    <div class="row"><span class="label">Published Date</span><span class="value" id="rdPublishedDate">-</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== ROLL NUMBER SLIP MODAL ====== -->
    <div class="modal-overlay" id="slipModal">
        <div class="modal" style="max-width:420px;">
            <div class="modal-header">
                <h2><i class="fas fa-print" style="color:#6D4AFF;"></i> Roll Number Slip</h2>
                <button class="modal-close" onclick="closeModal('slipModal')"><i class="fas fa-times"></i></button>
            </div>
            <div id="slipContent" class="slip-content">
                <div class="slip-header">
                    <div class="logo">Leeds<span>Institute</span></div>
                    <div class="title">Talent Test Roll Number Slip</div>
                </div>
                <div class="slip-body">
                    <div class="row"><span class="label">Candidate Name</span><span class="value" id="slipName">-</span></div>
                    <div class="row"><span class="label">Father Name</span><span class="value" id="slipFather">-</span></div>
                    <div class="row"><span class="label">Roll Number</span><span class="value" id="slipRollNo">-</span></div>
                    <div class="row"><span class="label">Test Date</span><span class="value" id="slipDate">-</span></div>
                    <div class="row"><span class="label">Generated Date</span><span class="value" id="slipGenerated">-</span></div>
                </div>
                <div class="slip-footer">
                    Please bring this slip on the test day.
                </div>
            </div>
            <div class="slip-actions">
                <button class="btn-primary" onclick="printSlip()"><i class="fas fa-print"></i> Print</button>
                <button class="btn-outline" onclick="downloadSlipPDF()"><i class="fas fa-file-pdf"></i> PDF</button>
                <button class="btn-outline" onclick="closeModal('slipModal')">Close</button>
            </div>
        </div>
    </div>

    <!-- ====== TOAST ====== -->
    <div class="toast" id="toast"><i class="fas fa-check-circle"></i> <span id="toastMsg">Action completed</span></div>

    <script>
        // ============================================
        // TALENT TEST MANAGEMENT - FULL INTEGRATION
        // ============================================

        let candidates = [];
        let testAttempts = [];
        let duplicateCandidateData = null;

        // ============================================
        // UTILITY FUNCTIONS
        // ============================================
        function getCSRFToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        function showToast(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            toast.classList.add('show');
            clearTimeout(toast._timer);
            toast._timer = setTimeout(() => toast.classList.remove('show'), 3500);
        }

        function formatDate(dateStr) {
            if (!dateStr) return '-';
            const d = new Date(dateStr);
            return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
        }

        // ============================================
        // LOAD DATA FROM DATABASE
        // ============================================
        async function loadCandidates() {
            try {
                const response = await fetch('/admin/talent-test/candidates', {
                    headers: {
                        'X-CSRF-TOKEN': getCSRFToken(),
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();
                if (result.success) {
                    candidates = result.data || [];
                    renderCandidates();
                }
            } catch (error) {
                console.error('Error loading candidates:', error);
                showToast('⚠️ Error loading candidates');
            }
        }

        async function loadAttempts() {
            try {
                const response = await fetch('/admin/talent-test/attempts', {
                    headers: {
                        'X-CSRF-TOKEN': getCSRFToken(),
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();
                if (result.success) {
                    testAttempts = result.data || [];
                    renderAttempts();
                    renderResults();
                }
            } catch (error) {
                console.error('Error loading attempts:', error);
                showToast('⚠️ Error loading attempts');
            }
        }

        async function loadStats() {
            try {
                const response = await fetch('/admin/talent-test/stats', {
                    headers: {
                        'X-CSRF-TOKEN': getCSRFToken(),
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();
                if (result.success) {
                    const stats = result.data;
                    document.getElementById('totalCandidates').textContent = stats.totalCandidates || 0;
                    document.getElementById('totalAttempts').textContent = stats.totalAttempts || 0;
                    document.getElementById('pendingResults').textContent = stats.pendingResults || 0;
                    document.getElementById('publishedResults').textContent = stats.publishedResults || 0;
                    document.getElementById('avgPercentage').textContent = (stats.avgPercentage || 0) + '%';
                    
                    document.getElementById('candidateBadge').textContent = stats.totalCandidates || 0;
                    document.getElementById('attemptBadge').textContent = stats.totalAttempts || 0;
                    document.getElementById('resultBadge').textContent = stats.publishedResults || 0;
                }
            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }

        // ============================================
        // TAB SWITCHING
        // ============================================
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
            document.querySelector(`.tab-btn[data-tab="${tabId}"]`).classList.add('active');
        }

        // ============================================
        // RENDER CANDIDATES
        // ============================================
        function renderCandidates() {
            const search = document.getElementById('searchCandidate').value.toLowerCase();
            const phone = document.getElementById('searchPhone').value.toLowerCase();
            const date = document.getElementById('regDateFilter').value;

            let filtered = candidates.filter(c => {
                const matchName = c.name.toLowerCase().includes(search);
                const matchPhone = c.phone.includes(phone);
                const matchDate = date === '' || c.regDate === date;
                return matchName && matchPhone && matchDate;
            });

            const tbody = document.getElementById('candidatesTableBody');
            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td colspan="8" style="text-align:center; padding:40px; color:#94A3B8;">No candidates found</td></tr>`;
            } else {
                tbody.innerHTML = filtered.map(c => `
                    <tr>
                        <td><strong>CID-${String(c.id).padStart(3, '0')}</strong></td>
                        <td><strong>${c.name}</strong></td>
                        <td>${c.father}</td>
                        <td>${c.phone}</td>
                        <td>${c.attempts || 0}</td>
                        <td>${c.lastTest || '-'}</td>
                        <td>${c.regDate}</td>
                        <td>
                            <div class="action-dropdown">
                                <button class="dropdown-trigger" onclick="toggleDD(this)"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="dd-menu">
                                    <a href="#" onclick="viewProfile(${c.id}); return false;"><i class="fas fa-user"></i> View Profile</a>
                                    <a href="#" onclick="openNewAttemptForCandidate(${c.id}); return false;"><i class="fas fa-plus"></i> New Test Attempt</a>
                                    <a href="#" onclick="deleteCandidate(${c.id}); return false;"><i class="fas fa-trash"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                `).join('');
            }

            document.getElementById('candidateCount').textContent = `Showing ${filtered.length} candidates`;
        }

        // ============================================
        // RENDER ATTEMPTS
        // ============================================
        function renderAttempts() {
            const roll = document.getElementById('searchRollNo').value.toLowerCase();
            const candidate = document.getElementById('searchAttemptCandidate').value.toLowerCase();
            const date = document.getElementById('attemptDateFilter').value;
            const status = document.getElementById('attemptStatusFilter').value;

            let filtered = testAttempts.filter(a => {
                const cName = (a.candidateName || '').toLowerCase();
                const matchRoll = a.rollNo.includes(roll);
                const matchCandidate = cName.includes(candidate);
                const matchDate = date === '' || a.testDate === date;
                const matchStatus = status === '' || a.status === status;
                return matchRoll && matchCandidate && matchDate && matchStatus;
            });

            const tbody = document.getElementById('attemptsTableBody');
            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td colspan="8" style="text-align:center; padding:40px; color:#94A3B8;">No attempts found</td></tr>`;
            } else {
                tbody.innerHTML = filtered.map(a => `
                    <tr>
                        <td><strong>${a.rollNo}</strong></td>
                        <td>${a.candidateName || 'N/A'}</td>
                        <td>${a.fatherName || 'N/A'}</td>
                        <td>${a.testDate}</td>
                        <td>${a.obtainedMarks !== null ? a.obtainedMarks : '-'}</td>
                        <td>${a.percentage !== null ? a.percentage + '%' : '-'}</td>
                        <td><span class="status-badge ${a.status}">${a.status.charAt(0).toUpperCase() + a.status.slice(1)}</span></td>
                        <td>
                            <div class="action-dropdown">
                                <button class="dropdown-trigger" onclick="toggleDD(this)"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="dd-menu">
                                    ${a.status === 'pending' ? `<a href="#" onclick="openResultModal(${a.id}); return false;"><i class="fas fa-pen"></i> Enter Result</a>` : ''}
                                    <a href="#" onclick="viewProfile(${a.candidateId}); return false;"><i class="fas fa-user"></i> View Candidate</a>
                                    <a href="#" onclick="viewResultDetail(${a.id}); return false;"><i class="fas fa-file-alt"></i> View Result</a>
                                    <a href="#" onclick="printSlipForAttempt(${a.id}); return false;"><i class="fas fa-print"></i> Print Slip</a>
                                    <a href="#" onclick="deleteAttempt(${a.id}); return false;"><i class="fas fa-trash"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                `).join('');
            }

            document.getElementById('attemptCount').textContent = `Showing ${filtered.length} attempts`;
        }

        // ============================================
        // RENDER RESULTS
        // ============================================
        function renderResults() {
            const roll = document.getElementById('searchResultRoll').value.toLowerCase();
            const candidate = document.getElementById('searchResultCandidate').value.toLowerCase();
            const status = document.getElementById('resultStatusFilter').value;

            let filtered = testAttempts.filter(a => {
                const cName = (a.candidateName || '').toLowerCase();
                const matchRoll = a.rollNo.includes(roll);
                const matchCandidate = cName.includes(candidate);
                const matchStatus = status === '' || a.status === status;
                return (a.status === 'pass' || a.status === 'fail') && matchRoll && matchCandidate && matchStatus;
            });

            const tbody = document.getElementById('resultsTableBody');
            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" style="text-align:center; padding:40px; color:#94A3B8;">No results found</td></tr>`;
            } else {
                tbody.innerHTML = filtered.map(a => `
                    <tr>
                        <td><strong>${a.rollNo}</strong></td>
                        <td>${a.candidateName || 'N/A'}</td>
                        <td>${a.testDate}</td>
                        <td>${a.obtainedMarks}</td>
                        <td>${a.percentage}%</td>
                        <td><span class="status-badge ${a.status}">${a.status.charAt(0).toUpperCase() + a.status.slice(1)}</span></td>
                        <td>
                            <button class="action-btn primary" onclick="viewResultDetail(${a.id})" title="View Result"><i class="fas fa-eye"></i></button>
                            <button class="action-btn success" onclick="printSlipForAttempt(${a.id})" title="Print Slip"><i class="fas fa-print"></i></button>
                        </td>
                    </tr>
                `).join('');
            }

            document.getElementById('resultCount').textContent = `Showing ${filtered.length} results`;
        }

        // ============================================
        // FILTER FUNCTIONS
        // ============================================
        function filterCandidates() { renderCandidates(); }
        function filterAttempts() { renderAttempts(); }
        function filterResults() { renderResults(); }
        function filterAll() { renderCandidates(); renderAttempts(); renderResults(); }

        function resetFilters() {
            document.getElementById('searchCandidate').value = '';
            document.getElementById('searchPhone').value = '';
            document.getElementById('regDateFilter').value = '';
            filterCandidates();
        }

        // ============================================
        // TOGGLE DROPDOWN
        // ============================================
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

        // ============================================
        // MODAL FUNCTIONS
        // ============================================
        function openModal(id) { document.getElementById(id).classList.add('active'); }
        function closeModal(id) { document.getElementById(id).classList.remove('active'); }

        document.querySelectorAll('.modal-overlay').forEach(el => {
            el.addEventListener('click', function(e) {
                if (e.target === this) this.classList.remove('active');
            });
        });

        // ============================================
        // REGISTER CANDIDATE - WITH DUPLICATE CHECK
        // ============================================
        function openRegisterModal() {
            document.getElementById('registerForm').reset();
            openModal('registerModal');
        }

        function closeDuplicateModal() {
            closeModal('confirmDuplicateModal');
            duplicateCandidateData = null;
        }

        async function registerCandidate(e) {
            e.preventDefault();
            const name = document.getElementById('regName').value.trim();
            const father = document.getElementById('regFather').value.trim();
            const phone = document.getElementById('regPhone').value.trim();

            if (!name || !father || !phone) {
                showToast('⚠️ Please fill all required fields');
                return;
            }

            // Check for duplicate candidate
            const existing = candidates.find(c => 
                c.name.toLowerCase() === name.toLowerCase() && 
                c.father.toLowerCase() === father.toLowerCase()
            );

            if (existing) {
                duplicateCandidateData = existing;
                document.getElementById('duplicateMessage').textContent = 
                    `"${existing.name}" (${existing.father}) is already registered in the Talent Test system.`;
                document.getElementById('confirmDuplicateBtn').onclick = function() {
                    closeDuplicateModal();
                    // Create new attempt for existing candidate
                    createAttemptForExisting(existing.id);
                };
                openModal('confirmDuplicateModal');
                return;
            }

            try {
                const response = await fetch('/admin/talent-test/candidate', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCSRFToken(),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        candidate_name: name,
                        father_name: father,
                        contact_number: phone
                    })
                });

                const result = await response.json();
                if (result.success) {
                    closeModal('registerModal');
                    document.getElementById('registerForm').reset();
                    showToast('✅ ' + result.message);
                    await loadCandidates();
                    await loadStats();
                    
                    // Auto-create first attempt for new candidate
                    const newCandidate = candidates.find(c => 
                        c.name.toLowerCase() === name.toLowerCase() && 
                        c.father.toLowerCase() === father.toLowerCase()
                    );
                    if (newCandidate) {
                        await createFirstAttempt(newCandidate.id);
                    }
                } else {
                    const errors = result.errors || {};
                    let errorMsg = 'Validation errors:\n';
                    for (const key in errors) {
                        errorMsg += `- ${errors[key].join(', ')}\n`;
                    }
                    showToast(errorMsg);
                }
            } catch (error) {
                showToast('⚠️ Error registering candidate');
            }
        }

        // ============================================
        // CREATE FIRST ATTEMPT (AUTO)
        // ============================================
        async function createFirstAttempt(candidateId) {
            try {
                const response = await fetch('/admin/talent-test/attempt', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCSRFToken(),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        candidate_id: candidateId
                    })
                });

                const result = await response.json();
                if (result.success) {
                    await loadAttempts();
                    await loadCandidates();
                    await loadStats();
                    showToast('✅ First test attempt created automatically!');
                    
                    // Show roll number slip
                    const attempt = result.data;
                    openSlipModal(attempt.id);
                }
            } catch (error) {
                console.error('Error creating first attempt:', error);
            }
        }

        // ============================================
        // CREATE ATTEMPT FOR EXISTING CANDIDATE
        // ============================================
        async function createAttemptForExisting(candidateId) {
            try {
                const response = await fetch('/admin/talent-test/attempt', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCSRFToken(),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        candidate_id: candidateId
                    })
                });

                const result = await response.json();
                if (result.success) {
                    await loadAttempts();
                    await loadCandidates();
                    await loadStats();
                    showToast('✅ ' + result.message);
                    
                    const attempt = result.data;
                    openSlipModal(attempt.id);
                }
            } catch (error) {
                showToast('⚠️ Error creating attempt');
            }
        }

        // ============================================
        // NEW TEST ATTEMPT
        // ============================================
        function openNewAttemptModal() {
            document.getElementById('attemptForm').reset();
            document.getElementById('selectedCandidateId').value = '';
            document.getElementById('selectedCandidateCard').style.display = 'none';
            document.getElementById('rollNumberDisplay').style.display = 'none';
            document.getElementById('candidateResults').style.display = 'none';
            openModal('attemptModal');
        }

        function openNewAttemptForCandidate(candidateId) {
            const candidate = candidates.find(c => c.id === candidateId);
            if (!candidate) return;
            document.getElementById('selectedCandidateId').value = candidateId;
            document.getElementById('selCandidateName').textContent = candidate.name;
            document.getElementById('selFatherName').textContent = candidate.father;
            document.getElementById('selPhone').textContent = candidate.phone;
            document.getElementById('selAttempts').textContent = candidate.attempts || 0;
            document.getElementById('selectedCandidateCard').style.display = 'block';
            document.getElementById('attemptSearch').value = candidate.name;
            document.getElementById('candidateResults').style.display = 'none';

            // Show placeholder roll number (server will generate actual)
            const rollNo = Math.floor(Math.random() * 1000 + 1100);
            document.getElementById('generatedRollNumber').textContent = rollNo;
            document.getElementById('rollNumberDisplay').style.display = 'block';

            openModal('attemptModal');
        }

        async function searchCandidates(query) {
            const results = document.getElementById('candidateResults');
            if (query.length < 2) {
                results.style.display = 'none';
                return;
            }

            try {
                const response = await fetch(`/admin/talent-test/search-candidates?q=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-CSRF-TOKEN': getCSRFToken(),
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();
                
                if (result.success && result.data.length > 0) {
                    results.innerHTML = result.data.map(c => `
                        <div style="padding:8px 12px; cursor:pointer; border-bottom:1px solid #F8FAFC;" 
                             onclick="selectCandidate(${c.id}, '${c.name}')" 
                             onmouseover="this.style.background='#F8FAFC'" 
                             onmouseout="this.style.background='#fff'">
                            <strong>${c.name}</strong> - ${c.phone}
                            <div style="font-size:12px; color:#94A3B8;">${c.father} | ${c.attempts} attempts</div>
                        </div>
                    `).join('');
                } else {
                    results.innerHTML = '<div style="padding:10px; color:#94A3B8;">No candidates found</div>';
                }
                results.style.display = 'block';
            } catch (error) {
                console.error('Error searching candidates:', error);
            }
        }

        function selectCandidate(id, name) {
            const candidate = candidates.find(c => c.id === id);
            if (!candidate) return;

            document.getElementById('selectedCandidateId').value = id;
            document.getElementById('selCandidateName').textContent = candidate.name;
            document.getElementById('selFatherName').textContent = candidate.father;
            document.getElementById('selPhone').textContent = candidate.phone;
            document.getElementById('selAttempts').textContent = candidate.attempts || 0;
            document.getElementById('selectedCandidateCard').style.display = 'block';
            document.getElementById('attemptSearch').value = name;
            document.getElementById('candidateResults').style.display = 'none';

            // Show placeholder roll number
            const rollNo = Math.floor(Math.random() * 1000 + 1100);
            document.getElementById('generatedRollNumber').textContent = rollNo;
            document.getElementById('rollNumberDisplay').style.display = 'block';
        }

        async function createAttempt(e) {
            e.preventDefault();
            const candidateId = document.getElementById('selectedCandidateId').value;
            if (!candidateId) {
                showToast('⚠️ Please select a candidate');
                return;
            }

            try {
                const response = await fetch('/admin/talent-test/attempt', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCSRFToken(),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        candidate_id: candidateId
                    })
                });

                const result = await response.json();
                if (result.success) {
                    closeModal('attemptModal');
                    document.getElementById('attemptForm').reset();
                    document.getElementById('selectedCandidateCard').style.display = 'none';
                    document.getElementById('rollNumberDisplay').style.display = 'none';
                    showToast('✅ ' + result.message);
                    await loadAttempts();
                    await loadCandidates();
                    await loadStats();
                    
                    // Show roll number slip
                    const attempt = result.data;
                    openSlipModal(attempt.id);
                } else {
                    showToast('⚠️ ' + (result.message || 'Failed to create attempt'));
                }
            } catch (error) {
                showToast('⚠️ Error creating test attempt');
            }
        }

        // ============================================
        // ENTER RESULT
        // ============================================
        function openResultModal(attemptId) {
            const attempt = testAttempts.find(a => a.id === attemptId);
            if (!attempt) return;

            document.getElementById('resultAttemptId').value = attemptId;
            document.getElementById('resultRollNo').textContent = attempt.rollNo;
            document.getElementById('resultCandidateName').textContent = attempt.candidateName || 'N/A';
            document.getElementById('resultFatherName').textContent = attempt.fatherName || 'N/A';
            document.getElementById('resultObtainedMarks').value = '';
            document.getElementById('resultPercentage').textContent = '0%';
            document.getElementById('resultStatusDisplay').innerHTML = '<span class="status-badge pending">Pending</span>';
            openModal('resultModal');
        }

        function calculateResult() {
            const obtained = parseInt(document.getElementById('resultObtainedMarks').value) || 0;
            const total = 100;
            const percentage = Math.min(100, (obtained / total) * 100);
            document.getElementById('resultPercentage').textContent = percentage.toFixed(1) + '%';

            let statusHtml = '';
            if (obtained === 0) {
                statusHtml = '<span class="status-badge pending">Pending</span>';
            } else if (percentage >= 50) {
                statusHtml = `<span class="status-badge pass">Pass (${percentage.toFixed(0)}%)</span>`;
            } else {
                statusHtml = `<span class="status-badge fail">Fail (${percentage.toFixed(0)}%)</span>`;
            }
            document.getElementById('resultStatusDisplay').innerHTML = statusHtml;
        }

        async function saveResult(e) {
            e.preventDefault();
            const attemptId = parseInt(document.getElementById('resultAttemptId').value);
            const obtained = parseInt(document.getElementById('resultObtainedMarks').value);
            const total = 100;

            if (isNaN(obtained) || obtained < 0 || obtained > total) {
                showToast('⚠️ Please enter valid marks (0-100)');
                return;
            }

            try {
                const response = await fetch(`/admin/talent-test/attempt/${attemptId}/result`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': getCSRFToken(),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        obtained_marks: obtained
                    })
                });

                const result = await response.json();
                if (result.success) {
                    closeModal('resultModal');
                    showToast('✅ ' + result.message);
                    await loadAttempts();
                    await loadStats();
                } else {
                    showToast('⚠️ ' + (result.message || 'Failed to save result'));
                }
            } catch (error) {
                showToast('⚠️ Error saving result');
            }
        }

        // ============================================
        // VIEW PROFILE
        // ============================================
        async function viewProfile(candidateId) {
            const candidate = candidates.find(c => c.id === candidateId);
            if (!candidate) {
                showToast('⚠️ Candidate not found');
                return;
            }

            const attempts = testAttempts.filter(a => a.candidateId === candidateId);
            const passed = attempts.filter(a => a.status === 'pass').length;
            const failed = attempts.filter(a => a.status === 'fail').length;
            const pending = attempts.filter(a => a.status === 'pending').length;
            const percentages = attempts.filter(a => a.percentage !== null).map(a => a.percentage);
            const best = percentages.length > 0 ? Math.max(...percentages) : 0;
            const latest = attempts.length > 0 ? attempts[attempts.length - 1] : null;

            document.getElementById('profileAvatar').textContent = candidate.name.charAt(0).toUpperCase();
            document.getElementById('profileName').textContent = candidate.name;
            document.getElementById('profileFather').textContent = 'Father: ' + candidate.father;
            document.getElementById('profilePhone').textContent = 'Phone: ' + candidate.phone;
            document.getElementById('profileEmail').textContent = 'Email: ' + (candidate.email || '-');
            document.getElementById('profileAddress').textContent = 'Address: ' + (candidate.address || '-');
            document.getElementById('profileRegDate').textContent = 'Registered: ' + formatDate(candidate.regDate);
            document.getElementById('profileTotalAttempts').textContent = attempts.length;
            document.getElementById('profileBestPercentage').textContent = best > 0 ? best + '%' : 'N/A';
            document.getElementById('profileLatestRoll').textContent = latest ? latest.rollNo : '-';

            document.getElementById('profileStatTotal').textContent = attempts.length;
            document.getElementById('profileStatPassed').textContent = passed;
            document.getElementById('profileStatFailed').textContent = failed;
            document.getElementById('profileStatPending').textContent = pending;
            document.getElementById('profileStatBest').textContent = best > 0 ? best + '%' : 'N/A';
            document.getElementById('profileStatLatest').textContent = latest ? latest.status.charAt(0).toUpperCase() + latest.status.slice(1) : '-';

            // Render attempt history
            const tbody = document.getElementById('profileAttemptsBody');
            if (attempts.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:20px; color:#94A3B8;">No attempts found</td></tr>';
            } else {
                tbody.innerHTML = attempts.map(a => `
                    <tr>
                        <td><strong>${a.rollNo}</strong></td>
                        <td>${formatDate(a.testDate)}</td>
                        <td>${a.obtainedMarks !== null ? a.obtainedMarks : '-'}</td>
                        <td>${a.percentage !== null ? a.percentage + '%' : '-'}</td>
                        <td><span class="status-badge ${a.status}">${a.status.charAt(0).toUpperCase() + a.status.slice(1)}</span></td>
                        <td>
                            ${a.status !== 'pending' ? `<button class="action-btn primary" onclick="viewResultDetail(${a.id})" title="View Result"><i class="fas fa-eye"></i></button>` : ''}
                            <button class="action-btn success" onclick="printSlipForAttempt(${a.id})" title="Print Slip"><i class="fas fa-print"></i></button>
                        </td>
                    </tr>
                `).join('');
            }

            openModal('profileModal');
        }

        // ============================================
        // VIEW RESULT DETAIL
        // ============================================
        function viewResultDetail(attemptId) {
            const attempt = testAttempts.find(a => a.id === attemptId);
            if (!attempt) {
                showToast('⚠️ Attempt not found');
                return;
            }

            if (attempt.status === 'pending') {
                showToast('⚠️ Result is still pending');
                return;
            }

            document.getElementById('rdCandidateName').textContent = attempt.candidateName || 'N/A';
            document.getElementById('rdFatherName').textContent = attempt.fatherName || 'N/A';
            document.getElementById('rdRollNo').textContent = attempt.rollNo;
            document.getElementById('rdTestDate').textContent = formatDate(attempt.testDate);
            document.getElementById('rdObtainedMarks').textContent = attempt.obtainedMarks + ' / 100';
            document.getElementById('rdTotalMarks').textContent = '100';
            document.getElementById('rdPercentage').textContent = attempt.percentage + '%';
            document.getElementById('rdStatus').innerHTML = `<span class="status-badge ${attempt.status}">${attempt.status.charAt(0).toUpperCase() + attempt.status.slice(1)}</span>`;
            document.getElementById('rdPublishedDate').textContent = formatDate(new Date());

            openModal('resultDetailModal');
        }

        // ============================================
        // ROLL NUMBER SLIP
        // ============================================
        function openSlipModal(attemptId) {
            const attempt = testAttempts.find(a => a.id === attemptId);
            if (!attempt) {
                showToast('⚠️ Attempt not found');
                return;
            }

            const candidate = candidates.find(c => c.id === attempt.candidateId);
            if (!candidate) {
                showToast('⚠️ Candidate not found');
                return;
            }

            document.getElementById('slipName').textContent = candidate.name;
            document.getElementById('slipFather').textContent = candidate.father;
            document.getElementById('slipRollNo').textContent = attempt.rollNo;
            document.getElementById('slipDate').textContent = formatDate(attempt.testDate);
            document.getElementById('slipGenerated').textContent = formatDate(new Date());

            openModal('slipModal');
        }

        function printSlipForAttempt(attemptId) {
            openSlipModal(attemptId);
            setTimeout(() => printSlip(), 500);
        }

        function printSlip() {
            const content = document.getElementById('slipContent');
            const win = window.open('', '_blank');
            win.document.write(`
                <html><head><title>Roll Number Slip</title>
                <style>
                    body { font-family: 'Inter', sans-serif; padding: 20px; max-width: 380px; margin: 0 auto; }
                    .slip-content { border: 1px solid #E2E8F0; border-radius: 12px; padding: 20px; }
                    .slip-header { text-align: center; border-bottom: 2px solid #071B3B; padding-bottom: 10px; margin-bottom: 12px; }
                    .slip-header .logo { font-size: 18px; font-weight: 800; color: #071B3B; }
                    .slip-header .logo span { color: #6D4AFF; }
                    .slip-header .title { font-size: 13px; font-weight: 600; color: #64748B; letter-spacing: 1px; }
                    .slip-body { padding: 8px 0; }
                    .slip-body .row { display: flex; justify-content: space-between; padding: 4px 0; font-size: 13px; border-bottom: 1px dashed #F1F5F9; }
                    .slip-body .row .label { color: #64748B; }
                    .slip-body .row .value { font-weight: 600; color: #0A1628; }
                    .slip-body .roll-number { font-size: 28px; font-weight: 800; color: #6D4AFF; text-align: center; padding: 8px 0; }
                    .slip-footer { text-align: center; font-size: 10px; color: #94A3B8; border-top: 1px solid #F1F5F9; padding-top: 10px; margin-top: 10px; }
                    @media print { body { padding: 0; } .no-print { display: none; } }
                </style>
                </head><body>
                ${content.outerHTML}
                <script>
                    window.onload = function() { window.print(); setTimeout(function(){ window.close(); }, 1000); };
                <\/script>
                </body></html>
            `);
            win.document.close();
        }

        function downloadSlipPDF() {
            showToast('📄 PDF download coming soon!');
        }

        // ============================================
        // DELETE FUNCTIONS
        // ============================================
        async function deleteCandidate(id) {
            if (!confirm('Are you sure you want to delete this candidate?')) return;
            
            try {
                const response = await fetch(`/admin/talent-test/candidate/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCSRFToken(),
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();
                if (result.success) {
                    showToast('🗑️ ' + result.message);
                    await loadCandidates();
                    await loadAttempts();
                    await loadStats();
                } else {
                    showToast('⚠️ ' + (result.message || 'Failed to delete'));
                }
            } catch (error) {
                showToast('⚠️ Error deleting candidate');
            }
        }

        async function deleteAttempt(id) {
            if (!confirm('Are you sure you want to delete this test attempt?')) return;
            
            try {
                const response = await fetch(`/admin/talent-test/attempt/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCSRFToken(),
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();
                if (result.success) {
                    showToast('🗑️ ' + result.message);
                    await loadAttempts();
                    await loadStats();
                } else {
                    showToast('⚠️ ' + (result.message || 'Failed to delete'));
                }
            } catch (error) {
                showToast('⚠️ Error deleting attempt');
            }
        }

        // ============================================
        // SIDEBAR & DROPDOWN
        // ============================================
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('overlay').classList.toggle('active');
        });
        document.getElementById('overlay').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('overlay').classList.remove('active');
        });

        document.getElementById('profileBtn').addEventListener('click', function(e) {
            e.stopPropagation();
            document.getElementById('profileDropdown').classList.toggle('open');
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.profile-dropdown-wrap')) {
                document.getElementById('profileDropdown').classList.remove('open');
            }
        });

        // ============================================
        // CLOSE DROPDOWN ON ESC
        // ============================================
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay.active').forEach(el => el.classList.remove('active'));
                document.querySelectorAll('.dd-menu.open').forEach(el => el.classList.remove('open'));
            }
        });

        // ============================================
        // INIT - LOAD ALL DATA
        // ============================================
        async function init() {
            await loadStats();
            await loadCandidates();
            await loadAttempts();
        }

        document.addEventListener('DOMContentLoaded', function() {
            init();
        });
    </script>

</body>
</html>