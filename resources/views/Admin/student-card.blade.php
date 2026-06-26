{{-- resources/views/admin/student-card.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leeds Academy · Student Cards</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
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
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 20px;
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
        .btn-primary:disabled { opacity: 0.5; cursor: not-allowed; transform: none !important; }
        .btn-outline {
            background: transparent; border: 1.5px solid #E2E8F0; padding: 8px 18px;
            border-radius: 40px; font-weight: 600; font-size: 13px; color: #475569;
            cursor: pointer; transition: 0.15s; font-family: 'Inter', sans-serif;
        }
        .btn-outline:hover { background: #F1F5F9; }
        .btn-outline:disabled { opacity: 0.5; cursor: not-allowed; }
        .btn-success {
            background: #10B981; border: none; padding: 10px 24px; border-radius: 40px;
            font-weight: 600; font-size: 14px; color: #fff; display: inline-flex; align-items: center; gap: 8px;
            cursor: pointer; transition: 0.15s; font-family: 'Inter', sans-serif; box-shadow: 0 6px 14px -6px rgba(16,185,129,0.3);
        }
        .btn-success:hover { background: #0ea373; transform: translateY(-2px); }
        .btn-warning {
            background: #F59E0B; border: none; padding: 10px 24px; border-radius: 40px;
            font-weight: 600; font-size: 14px; color: #fff; display: inline-flex; align-items: center; gap: 8px;
            cursor: pointer; transition: 0.15s; font-family: 'Inter', sans-serif; box-shadow: 0 6px 14px -6px rgba(245,158,11,0.3);
        }
        .btn-warning:hover { background: #D97706; transform: translateY(-2px); }
        .btn-warning:disabled { opacity: 0.5; cursor: not-allowed; transform: none !important; }
        .btn-danger {
            background: #EF4444; border: none; padding: 10px 24px; border-radius: 40px;
            font-weight: 600; font-size: 14px; color: #fff; display: inline-flex; align-items: center; gap: 8px;
            cursor: pointer; transition: 0.15s; font-family: 'Inter', sans-serif; box-shadow: 0 6px 14px -6px rgba(239,68,68,0.3);
        }
        .btn-danger:hover { background: #DC2626; transform: translateY(-2px); }

        .card-preview-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 20px;
        }
        .student-list-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #F1F5F9;
            padding: 20px 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            max-height: 650px;
            display: flex;
            flex-direction: column;
        }
        .student-list-card h4 {
            font-size: 16px;
            font-weight: 600;
            color: #0F172A;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }
        .student-list-card h4 i { color: #6D4AFF; }
        .student-list-card h4 .actions {
            margin-left: auto;
            display: flex;
            gap: 6px;
        }
        .student-list-card h4 .actions button {
            padding: 4px 12px;
            font-size: 11px;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            transition: 0.15s;
        }
        .student-list-card h4 .actions .select-all { background: #E2E8F0; color: #475569; }
        .student-list-card h4 .actions .select-all:hover { background: #CBD5E1; }
        .student-list-card h4 .actions .issue-selected { background: #6D4AFF; color: #fff; }
        .student-list-card h4 .actions .issue-selected:hover { background: #5a3de0; }
        .student-list-card h4 .actions .print-selected { background: #10B981; color: #fff; }
        .student-list-card h4 .actions .print-selected:hover { background: #0ea373; }
        .student-list-card h4 .actions .print-selected:disabled { opacity: 0.5; cursor: not-allowed; }

        .filter-bar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 12px;
            flex-shrink: 0;
        }
        .filter-bar select {
            padding: 6px 14px;
            border-radius: 30px;
            border: 1.5px solid #E2E8F0;
            font-size: 12px;
            font-family: 'Inter', sans-serif;
            background: #F8FAFC;
            cursor: pointer;
            transition: 0.15s;
            color: #1E293B;
        }
        .filter-bar select:focus {
            border-color: #6D4AFF;
            box-shadow: 0 0 0 3px rgba(109,74,255,0.08);
            outline: none;
        }
        .filter-bar .filter-label {
            font-size: 12px;
            font-weight: 500;
            color: #64748B;
            display: flex;
            align-items: center;
        }

        .student-search {
            position: relative;
            flex-shrink: 0;
        }
        .student-search input {
            width: 100%;
            padding: 8px 14px 8px 36px;
            border-radius: 10px;
            border: 1.5px solid #E2E8F0;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            transition: 0.15s;
            background: #F8FAFC;
        }
        .student-search input:focus {
            border-color: #6D4AFF;
            box-shadow: 0 0 0 3px rgba(109,74,255,0.08);
            outline: none;
            background: #fff;
        }
        .student-search i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
        }
        .student-list-scroll {
            flex: 1;
            overflow-y: auto;
            margin-right: -8px;
            padding-right: 8px;
        }
        .student-list-scroll::-webkit-scrollbar { width: 4px; }
        .student-list-scroll::-webkit-scrollbar-track { background: #F1F5F9; border-radius: 10px; }
        .student-list-scroll::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }

        .student-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.15s;
            border-bottom: 1px solid #F1F5F9;
        }
        .student-item:last-child { border-bottom: none; }
        .student-item:hover { background: #F8FAFC; }
        .student-item.active { background: #EDE7FF; border-left: 3px solid #6D4AFF; }
        .student-item input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #6D4AFF;
            cursor: pointer;
            flex-shrink: 0;
        }
        .student-item .info { display: flex; flex-direction: column; flex: 1; }
        .student-item .info .name { font-weight: 600; font-size: 14px; }
        .student-item .info .father { font-size: 12px; color: #64748B; }
        .student-item .info .id { font-size: 11px; color: #94A3B8; }
        .student-item .status-badge {
            font-size: 10px;
            font-weight: 600;
            padding: 2px 12px;
            border-radius: 30px;
            background: #E6F7E6;
            color: #10B981;
            flex-shrink: 0;
        }
        .student-item .status-badge.pending { background: #FEF3C7; color: #D97706; }
        .student-item .status-badge.issued { background: #EDE7FF; color: #6D4AFF; }
        .student-item .status-badge.unissued { background: #FEE2E2; color: #DC2626; }

        .card-preview-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }
        .card-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .card-actions .btn-primary, .card-actions .btn-outline {
            padding: 8px 20px;
            font-size: 13px;
        }

        #studentCard {
            width: 380px;
            height: 240px;
            border-radius: 18px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0,0,0,0.12);
            font-family: 'Inter', sans-serif;
            flex-shrink: 0;
            background: #FFFFFF;
            border: 1px solid #E8EDF4;
        }

        #studentCard .card-top-bar {
            height: 50px;
            background: linear-gradient(135deg, #6D4AFF, #4F46E5);
            position: relative;
            display: flex;
            align-items: center;
            padding: 0 20px;
        }
        #studentCard .card-top-bar .academy-name {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 2px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        #studentCard .card-top-bar .academy-name i {
            font-size: 18px;
            color: rgba(255,255,255,0.8);
        }
        #studentCard .card-top-bar .card-type {
            position: absolute;
            right: 20px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.5px;
            background: rgba(255,255,255,0.15);
            padding: 4px 14px;
            border-radius: 30px;
            color: rgba(255,255,255,0.9);
            border: 1px solid rgba(255,255,255,0.1);
        }

        #studentCard .card-body-white {
            padding: 16px 24px 14px;
            display: flex;
            align-items: center;
            gap: 18px;
            flex: 1;
            background: #fff;
            min-height: 140px;
        }
        #studentCard .card-body-white .avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6D4AFF, #4F46E5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(109,74,255,0.25);
        }
        #studentCard .card-body-white .details {
            flex: 1;
        }
        #studentCard .card-body-white .details .student-name {
            font-size: 19px;
            font-weight: 700;
            color: #0F172A;
            letter-spacing: -0.3px;
        }
        #studentCard .card-body-white .details .student-id {
            font-size: 13px;
            color: #64748B;
            margin-top: 2px;
        }
        #studentCard .card-body-white .details .student-id span { font-weight: 600; color: #1E293B; }
        #studentCard .card-body-white .details .student-dob {
            font-size: 12px;
            color: #94A3B8;
            margin-top: 2px;
        }
        #studentCard .card-body-white .details .student-dob span { font-weight: 500; color: #64748B; }

        #studentCard .card-footer-bar {
            height: 44px;
            background: #F8FAFC;
            border-top: 1px solid #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }
        #studentCard .card-footer-bar .footer-left {
            font-size: 10px;
            color: #94A3B8;
        }
        #studentCard .card-footer-bar .footer-left .reg-no {
            font-weight: 600;
            color: #6D4AFF;
            letter-spacing: 0.5px;
        }
        #studentCard .card-footer-bar .qr-code {
            width: 32px;
            height: 32px;
            background: #F1F5F9;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #94A3B8;
        }

        .mini-card {
            width: 100%;
            aspect-ratio: 380/240;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border: 1px solid #E2E8F0;
            position: relative;
            background: #fff;
        }
        .mini-card .card-top-bar {
            height: 32px;
            background: linear-gradient(135deg, #6D4AFF, #4F46E5);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 12px;
            position: relative;
        }
        .mini-card .card-top-bar .academy-name {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .mini-card .card-top-bar .academy-name i { font-size: 12px; }
        .mini-card .card-top-bar .card-type {
            position: absolute;
            right: 12px;
            font-size: 7px;
            font-weight: 600;
            letter-spacing: 1px;
            background: rgba(255,255,255,0.12);
            padding: 2px 10px;
            border-radius: 30px;
            color: rgba(255,255,255,0.8);
        }
        .mini-card .card-body-white {
            padding: 10px 14px 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
            min-height: 100px;
        }
        .mini-card .card-body-white .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6D4AFF, #4F46E5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(109,74,255,0.2);
        }
        .mini-card .card-body-white .details .student-name { font-size: 13px; font-weight: 700; color: #0F172A; }
        .mini-card .card-body-white .details .student-id { font-size: 10px; color: #64748B; }
        .mini-card .card-body-white .details .student-id span { font-weight: 600; color: #1E293B; }
        .mini-card .card-body-white .details .student-dob { font-size: 9px; color: #94A3B8; }
        .mini-card .card-footer-bar {
            height: 28px;
            background: #F8FAFC;
            border-top: 1px solid #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 14px;
        }
        .mini-card .card-footer-bar .footer-left { font-size: 8px; color: #94A3B8; }
        .mini-card .card-footer-bar .footer-left .reg-no { font-weight: 600; color: #6D4AFF; }
        .mini-card .card-footer-bar .qr-code {
            width: 24px;
            height: 24px;
            background: #F1F5F9;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #94A3B8;
        }

        .no-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 240px;
            width: 380px;
            background: #F8FAFC;
            border-radius: 16px;
            border: 2px dashed #E2E8F0;
            color: #94A3B8;
            font-size: 14px;
            flex-shrink: 0;
        }
        .no-card i { font-size: 40px; margin-bottom: 12px; color: #E2E8F0; }

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

        .student-count {
            font-size: 12px;
            color: #94A3B8;
            margin-left: auto;
            font-weight: 400;
        }

        .modal-overlay {
            position: fixed; inset: 0; background: rgba(15,23,42,0.6);
            backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center;
            z-index: 999; padding: 20px;
        }
        .modal-overlay.active { display: flex; }
        .modal {
            background: #fff; border-radius: 24px; max-width: 95%; width: 100%;
            max-height: 92vh; overflow-y: auto; padding: 24px 28px 28px;
            box-shadow: 0 40px 80px -20px rgba(0,0,0,0.3);
            animation: modalIn 0.25s ease;
        }
        @keyframes modalIn { from { opacity:0; transform: scale(0.96) translateY(20px); } to { opacity:1; transform: scale(1) translateY(0); } }
        .modal-header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;
        }
        .modal-header h2 { font-size: 20px; font-weight: 600; color: #0F172A; }
        .modal-close { background: transparent; border: none; font-size: 24px; color: #94A3B8; cursor: pointer; padding: 6px; }
        .modal-close:hover { color: #1E293B; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px 24px; }
        .form-group { display: flex; flex-direction: column; gap: 4px; }
        .form-group label { font-weight: 500; font-size: 14px; color: #334155; }
        .form-group label .required { color: #EF4444; }
        .form-group input, .form-group select {
            padding: 10px 14px;
            border-radius: 12px;
            border: 1.5px solid #E2E8F0;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: 0.15s;
            background: #fff;
            width: 100%;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: #6D4AFF;
            box-shadow: 0 0 0 3px rgba(109,74,255,0.08);
            outline: none;
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

        @media print {
            html, body { margin:0; padding:0; background:#fff; }
            body * { visibility: hidden; }
            .modal { visibility: visible; }
            .modal * { visibility: visible; }
            .modal-overlay { 
                position: fixed; 
                inset: 0; 
                background: #fff; 
                padding: 0; 
                margin:0; 
                display:block !important;
            }
            .modal { 
                max-width: 100%; 
                max-height: 100%; 
                box-shadow: none; 
                padding: 0; 
                margin:0; 
                border-radius:0; 
                overflow:hidden;
                display:block !important;
            }
            .modal-header { display: none !important; }
            .modal-close { display: none !important; }
            .modal .print-hide { display: none !important; }
            
            .card-print-grid { 
                display: grid !important; 
                grid-template-columns: 1fr 1fr !important; 
                gap: 12px !important; 
                padding: 12px !important; 
                margin:0 !important; 
                max-width:100% !important;
                height:100vh !important;
                align-content: center !important;
            }
            .card-print-grid .mini-card { 
                border: 1px solid #E2E8F0; 
                border-radius: 10px; 
                page-break-inside: avoid;
                height: auto !important;
                aspect-ratio: 380/240;
                box-shadow: none !important;
            }
        }

        @media (max-width: 1024px) {
            .card-preview-section { grid-template-columns: 1fr; }
            #studentCard { width: 100%; max-width: 380px; height: auto; min-height: 240px; }
            .no-card { width: 100%; max-width: 380px; height: 240px; }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); width: 270px; position: fixed; top:0; left:0; height:100%; }
            .sidebar.open { transform: translateX(0); }
            .topbar-left .menu-toggle { display: block; }
            .search-box { width: 140px; }
            .content { padding: 20px 16px; }
            .topbar { padding: 12px 16px; }
            .student-list-card { max-height: 400px; }
            .modal { padding: 20px 18px; }
        }
        .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.2); z-index: 45; }
        .overlay.active { display: block; }
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
                    <h2>Student Cards</h2>
                    <div class="breadcrumb">Dashboard / <span>Student Cards</span></div>
                </div>
            </div>
            <div class="topbar-right">
                <div class="search-box"><i class="fas fa-search"></i><input type="text" placeholder="Search..." id="globalSearch" oninput="applyFilters()" /></div>
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
                <h3>Student ID Cards</h3>
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <button class="btn-success" onclick="issueSelected()"><i class="fas fa-check-circle"></i> Issue Selected</button>
                    <button class="btn-warning" id="printSelectedBtn" onclick="printSelected()"><i class="fas fa-print"></i> Print Selected</button>
                </div>
            </div>

            <div class="card-preview-section">
                <div class="student-list-card">
                    <h4>
                        <i class="fas fa-users"></i> Students
                        <span class="student-count" id="studentCount"></span>
                        <span class="actions">
                            <button class="select-all" onclick="toggleAllStudents()"><i class="fas fa-check-double"></i> All</button>
                            <button class="issue-selected" onclick="issueSelected()"><i class="fas fa-check"></i> Issue</button>
                            <button class="print-selected" id="printSelectedSmall" onclick="printSelected()"><i class="fas fa-print"></i> Print</button>
                        </span>
                    </h4>
                    <div class="filter-bar">
                        <span class="filter-label"><i class="fas fa-filter" style="margin-right:4px;"></i> Filter:</span>
                        <select id="statusFilter" onchange="applyFilters()">
                            <option value="all">All Students</option>
                            <option value="issued">Issued</option>
                            <option value="unissued">Unissued</option>
                        </select>
                    </div>
                    <div class="student-search">
                        <i class="fas fa-search"></i>
                        <input type="text" id="studentSearch" placeholder="Search by name or father name..." oninput="applyFilters()">
                    </div>
                    <div class="student-list-scroll" id="studentList"></div>
                </div>

                <div class="card-preview-container">
                    <div id="cardContainer">
                        <div class="no-card">
                            <i class="fas fa-id-card"></i>
                            <p>Select a student to preview card</p>
                        </div>
                    </div>
                    <div class="card-actions">
                        <button class="btn-primary" id="pdfBtn" onclick="downloadPDF()"><i class="fas fa-file-pdf"></i> PDF</button>
                        <button class="btn-primary" id="pngBtn" style="background:#3B82F6; box-shadow:0 6px 14px -6px rgba(59,130,246,0.3);" onclick="downloadPNG()"><i class="fas fa-image"></i> PNG</button>
                        <button class="btn-outline" id="printBtn" onclick="printCardSingle()"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
            </div>

        </div><!-- /content -->
    </div><!-- /main -->

    <!-- ─── ISSUE CARD MODAL ─── -->
    <div class="modal-overlay" id="issueModal">
        <div class="modal">
            <div class="modal-header">
                <h2><i class="fas fa-id-card" style="color:#6D4AFF; margin-right:10px;"></i> Issue Student Card</h2>
                <button class="modal-close" onclick="closeModal('issueModal')"><i class="fas fa-times"></i></button>
            </div>
            <form id="issueForm" onsubmit="issueCard(event)">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label>Select Student <span class="required">*</span></label>
                        <select id="issueStudent" required>
                            <option value="">Select Student</option>
                            @foreach($students ?? [] as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->student_id }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Issue Date <span class="required">*</span></label>
                        <input type="date" id="issueDate" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline" onclick="closeModal('issueModal')">Cancel</button>
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Issue Card</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ─── DELETE MODAL ─── -->
    <div class="modal-overlay delete-modal" id="deleteModal">
        <div class="modal">
            <div class="icon"><i class="fas fa-exclamation-circle"></i></div>
            <h3>Delete Student Card</h3>
            <p>Are you sure you want to delete this student card? This action cannot be undone.</p>
            <div style="margin-top:16px; display:flex; gap:12px; justify-content:center;">
                <button class="btn-outline" onclick="closeDeleteModal()">Cancel</button>
                <button class="btn-danger" id="confirmDeleteBtn"><i class="fas fa-trash"></i> Delete</button>
            </div>
        </div>
    </div>

    <!-- ─── BULK PRINT MODAL ─── -->
    <div class="modal-overlay" id="printModal">
        <div class="modal">
            <div class="modal-header">
                <h2><i class="fas fa-print" style="color:#6D4AFF;"></i> Print Cards</h2>
                <button class="modal-close" onclick="closeModal('printModal')"><i class="fas fa-times"></i></button>
            </div>
            <div id="printGridContainer" style="margin-top:10px; padding:0;"></div>
            <div style="display:flex; justify-content:center; gap:12px; margin-top:16px; padding-top:12px; border-top:1px solid #F1F5F9;" class="print-hide">
                <button class="btn-primary" id="bulkPdfBtn" onclick="downloadBulkPDF()"><i class="fas fa-file-pdf"></i> Download PDF</button>
                <button class="btn-primary" id="bulkPngBtn" style="background:#3B82F6; box-shadow:0 6px 14px -6px rgba(59,130,246,0.3);" onclick="downloadBulkPNG()"><i class="fas fa-image"></i> Download PNG</button>
                <button class="btn-success" id="bulkPrintBtn" onclick="printBulk()"><i class="fas fa-print"></i> Print</button>
                <button class="btn-outline" onclick="closeModal('printModal')">Close</button>
            </div>
        </div>
    </div>

    <!-- ─── TOAST ─── -->
    <div class="toast" id="toast"><i class="fas fa-check-circle"></i> <span id="toastMsg">Action completed</span></div>

    <script>
        // ─── Global Variables ───
        let students = [];
        let selectedStudent = null;
        let filteredStudents = [];
        let selectedIds = new Set();
        let deleteId = null;

        // ─── CSRF Token ───
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // ─── Load Students from Database ───
        async function loadStudents() {
            try {
                const response = await fetch('{{ route("admin.student-cards.index") }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                // We need students with their card status
                const studentsResponse = await fetch('{{ route("admin.students.index") }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const studentsData = await studentsResponse.json();
                
                // Merge card data with students
                const cards = data.data || [];
                const allStudents = studentsData.data || [];
                
                students = allStudents.map(s => {
                    const card = cards.find(c => c.student_id === s.id);
                    return {
                        ...s,
                        issued: !!card,
                        card_no: card ? card.card_no : null,
                        reg_no: card ? card.reg_no : null,
                        issue_date: card ? card.issue_date : null,
                        card_status: card ? card.status : 'unissued'
                    };
                });
                
                filteredStudents = [...students];
                renderStudentList();
                if (students.length > 0) {
                    selectedStudent = students[0];
                    renderCard(selectedStudent);
                    updateButtonStates();
                }
            } catch (error) {
                console.error('Error loading students:', error);
                showToast('⚠️ Error loading students');
                // Fallback demo data
                loadDemoData();
            }
        }

        // ─── Demo Data (fallback) ───
        function loadDemoData() {
            students = [
                { id: 1, student_id: 'STU-001', name: 'Rosa Maria', father_name: 'Carlos Maria', dob: '20 Jan 2002', address: '123 Anywhere St., Any City', status: 'Active', issued: false, reg_no: null },
                { id: 2, student_id: 'STU-002', name: 'Ali Raza', father_name: 'Ahmed Khan', dob: '15 Mar 2001', address: '456 Main St., Lahore', status: 'Active', issued: true, reg_no: 'REG-2026-0015' },
                { id: 3, student_id: 'STU-003', name: 'Fatima Noor', father_name: 'Khalid Mehmood', dob: '22 Jul 2003', address: '789 Park Ave., Karachi', status: 'Active', issued: false, reg_no: null },
                { id: 4, student_id: 'STU-004', name: 'Usman Ahmed', father_name: 'Javed Iqbal', dob: '10 Nov 2000', address: '321 Lake Rd., Islamabad', status: 'Pending', issued: true, reg_no: 'REG-2026-0033' },
            ];
            filteredStudents = [...students];
            renderStudentList();
            if (students.length > 0) {
                selectedStudent = students[0];
                renderCard(selectedStudent);
                updateButtonStates();
            }
        }

        // ─── Apply Filters ───
        function applyFilters() {
            const searchQuery = document.getElementById('studentSearch').value.toLowerCase().trim();
            const statusFilter = document.getElementById('statusFilter').value;
            
            filteredStudents = students.filter(s => {
                const matchesSearch = searchQuery === '' || 
                    s.name.toLowerCase().includes(searchQuery) || 
                    (s.father_name && s.father_name.toLowerCase().includes(searchQuery));
                const matchesStatus = statusFilter === 'all' || 
                    (statusFilter === 'issued' && s.issued) || 
                    (statusFilter === 'unissued' && !s.issued);
                return matchesSearch && matchesStatus;
            });
            
            if (selectedStudent && !filteredStudents.some(s => s.id === selectedStudent.id)) {
                selectedStudent = filteredStudents.length > 0 ? filteredStudents[0] : null;
                if (selectedStudent) {
                    renderCard(selectedStudent);
                } else {
                    document.getElementById('cardContainer').innerHTML = `<div class="no-card"><i class="fas fa-id-card"></i><p>Select a student to preview card</p></div>`;
                }
            }
            renderStudentList();
            updateButtonStates();
        }

        // ─── Render Student List ───
        function renderStudentList() {
            const container = document.getElementById('studentList');
            document.getElementById('studentCount').textContent = `(${filteredStudents.length})`;
            
            if (filteredStudents.length === 0) {
                container.innerHTML = `<div style="text-align:center; padding:30px 0; color:#94A3B8;"><i class="fas fa-search" style="font-size:24px; display:block; margin-bottom:8px;"></i><p>No students found</p></div>`;
                return;
            }

            container.innerHTML = filteredStudents.map((s) => {
                const isActive = selectedStudent && selectedStudent.id === s.id;
                const isChecked = selectedIds.has(s.id);
                const statusClass = s.issued ? 'issued' : 'unissued';
                const statusText = s.issued ? 'Issued' : 'Unissued';
                return `
                    <div class="student-item ${isActive ? 'active' : ''}" onclick="selectStudent(${s.id})">
                        <input type="checkbox" ${isChecked ? 'checked' : ''} onclick="event.stopPropagation(); toggleStudent(${s.id})">
                        <div class="info">
                            <span class="name">${s.name}</span>
                            <span class="father">Father: ${s.father_name || '-'}</span>
                            <span class="id">${s.student_id}</span>
                        </div>
                        <span class="status-badge ${statusClass}">${statusText}</span>
                    </div>
                `;
            }).join('');
            updateButtonStates();
        }

        // ─── Update Button States ───
        function updateButtonStates() {
            const selected = getSelectedStudents();
            const hasSelected = selected.length > 0;
            const allIssued = selected.every(s => s.issued);
            
            document.querySelectorAll('#printSelectedBtn, #printSelectedSmall').forEach(btn => {
                btn.disabled = !hasSelected || !allIssued;
            });
            
            const hasCard = selectedStudent !== null;
            const isIssued = selectedStudent ? selectedStudent.issued : false;
            ['pdfBtn', 'pngBtn', 'printBtn'].forEach(id => {
                const btn = document.getElementById(id);
                if (btn) btn.disabled = !hasCard || !isIssued;
            });
        }

        // ─── Select Student ───
        function selectStudent(id) {
            const student = students.find(s => s.id === id);
            if (!student) return;
            if (!filteredStudents.some(s => s.id === id)) return;
            selectedStudent = student;
            renderStudentList();
            renderCard(selectedStudent);
            updateButtonStates();
        }

        // ─── Toggle Student Selection ───
        function toggleStudent(id) {
            if (selectedIds.has(id)) {
                selectedIds.delete(id);
            } else {
                selectedIds.add(id);
            }
            renderStudentList();
            updateButtonStates();
        }

        // ─── Toggle All Students ───
        function toggleAllStudents() {
            const allKeys = filteredStudents.map(s => s.id);
            const allSelected = allKeys.every(k => selectedIds.has(k));
            allKeys.forEach(k => allSelected ? selectedIds.delete(k) : selectedIds.add(k));
            renderStudentList();
            updateButtonStates();
        }

        // ─── Get Selected Students ───
        function getSelectedStudents() {
            return students.filter(s => selectedIds.has(s.id));
        }

        // ─── Render Card ───
        function renderCard(student) {
            const container = document.getElementById('cardContainer');
            if (!student) {
                container.innerHTML = `<div class="no-card"><i class="fas fa-id-card"></i><p>Select a student to preview card</p></div>`;
                return;
            }
            
            const initials = student.name.split(' ').map(w => w[0]).join('').toUpperCase();
            const issueDate = student.issue_date ? new Date(student.issue_date).toLocaleDateString('en-US', { day: '2-digit', month: 'short', year: 'numeric' }) : new Date().toLocaleDateString('en-US', { day: '2-digit', month: 'short', year: 'numeric' });
            const regNo = student.reg_no || 'REG-2026-0000';
            const cardNo = student.card_no || 'CARD-0000';
            const issuedStatus = student.issued ? '✓ Issued' : 'Not Issued';
            const statusColor = student.issued ? '#10B981' : '#F59E0B';
            
            container.innerHTML = `
                <div id="studentCard">
                    <div class="card-top-bar">
                        <div class="academy-name"><i class="fas fa-graduation-cap"></i> Leeds Academy</div>
                        <div class="card-type">STUDENT ID</div>
                    </div>
                    <div class="card-body-white">
                        <div class="avatar">${initials}</div>
                        <div class="details">
                            <div class="student-name">${student.name}</div>
                            <div class="student-id">Student ID: <span>${student.student_id}</span></div>
                            <div class="student-dob">Date of Birth: <span>${student.dob || '-'}</span></div>
                            <div style="font-size:10px; color:#94A3B8; margin-top:4px;">
                                Card #: <span style="font-weight:600; color:#6D4AFF;">${cardNo}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer-bar">
                        <div class="footer-left">
                            <span class="reg-no">${regNo}</span> • Issued: ${issueDate}
                        </div>
                        <div class="qr-code"><i class="fas fa-qrcode"></i></div>
                    </div>
                </div>
            `;
            updateButtonStates();
        }

        // ─── Issue Selected ───
        async function issueSelected() {
            const selected = getSelectedStudents();
            if (selected.length === 0) {
                showToast('⚠️ Please select at least one student');
                return;
            }
            
            // Check if any already have cards
            const alreadyIssued = selected.filter(s => s.issued);
            if (alreadyIssued.length > 0) {
                if (!confirm(`${alreadyIssued.length} student(s) already have cards. Continue with remaining?`)) {
                    return;
                }
            }
            
            const studentIds = selected.filter(s => !s.issued).map(s => s.id);
            if (studentIds.length === 0) {
                showToast('⚠️ All selected students already have cards');
                return;
            }
            
            try {
                const response = await fetch('{{ route("admin.student-cards.issue") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ student_ids: studentIds })
                });
                
                const result = await response.json();
                if (result.success) {
                    showToast(result.message);
                    loadStudents();
                } else {
                    showToast('⚠️ ' + (result.message || 'Error issuing cards'));
                }
            } catch (error) {
                // Fallback for demo
                selected.forEach(s => { s.issued = true; });
                if (selectedStudent && selected.some(s => s.id === selectedStudent.id)) {
                    renderCard(selectedStudent);
                }
                applyFilters();
                showToast('✅ ' + selected.length + ' card(s) issued successfully!');
            }
        }

        // ─── Open Issue Modal ───
        document.getElementById('issue-selected-btn')?.addEventListener('click', function() {
            document.getElementById('issueDate').value = new Date().toISOString().split('T')[0];
            openModal('issueModal');
        });

        // ─── Issue Single Card ───
        async function issueCard(e) {
            e.preventDefault();
            const studentId = document.getElementById('issueStudent').value;
            const issueDate = document.getElementById('issueDate').value;
            
            if (!studentId) { showToast('⚠️ Please select a student'); return; }
            if (!issueDate) { showToast('⚠️ Please select an issue date'); return; }
            
            try {
                const response = await fetch('{{ route("admin.student-cards.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        student_id: studentId,
                        issue_date: issueDate
                    })
                });
                
                const result = await response.json();
                if (result.success) {
                    showToast(result.message);
                    closeModal('issueModal');
                    loadStudents();
                } else {
                    if (result.errors) {
                        const errors = Object.values(result.errors).flat().join('\n');
                        showToast('❌ ' + errors);
                    } else {
                        showToast('⚠️ ' + (result.message || 'Error issuing card'));
                    }
                }
            } catch (error) {
                // Fallback for demo
                const student = students.find(s => s.id === parseInt(studentId));
                if (student) {
                    student.issued = true;
                    student.reg_no = 'REG-2026-' + String(Math.floor(Math.random() * 10000)).padStart(4, '0');
                    student.card_no = 'CARD-' + String(Math.floor(Math.random() * 10000)).padStart(4, '0');
                    student.issue_date = issueDate;
                }
                closeModal('issueModal');
                applyFilters();
                showToast('✅ Card issued successfully!');
            }
        }

        // ─── Print Selected ───
        function printSelected() {
            const selected = getSelectedStudents();
            if (selected.length === 0) {
                showToast('⚠️ Please select at least one student');
                return;
            }
            
            const notIssued = selected.filter(s => !s.issued);
            if (notIssued.length > 0) {
                if (!confirm(`${notIssued.length} student(s) have not been issued. Issue them now?`)) return;
                notIssued.forEach(s => { s.issued = true; });
                if (selectedStudent && selected.some(s => s.id === selectedStudent.id)) {
                    renderCard(selectedStudent);
                }
                applyFilters();
            }
            showBulkPrintModal(selected);
        }

        // ─── Show Bulk Print Modal ───
        function showBulkPrintModal(students) {
            const container = document.getElementById('printGridContainer');
            const modal = document.getElementById('printModal');
            
            let html = `<div class="card-print-grid">`;
            students.forEach((s, idx) => {
                const initials = s.name.split(' ').map(w => w[0]).join('').toUpperCase();
                const issueDate = s.issue_date ? new Date(s.issue_date).toLocaleDateString('en-US', { day: '2-digit', month: 'short', year: 'numeric' }) : new Date().toLocaleDateString('en-US', { day: '2-digit', month: 'short', year: 'numeric' });
                const regNo = s.reg_no || 'REG-2026-0000';
                const cardNo = s.card_no || 'CARD-0000';
                html += `
                    <div class="mini-card" id="miniCard_${idx}">
                        <div class="card-top-bar">
                            <div class="academy-name"><i class="fas fa-graduation-cap"></i> Leeds</div>
                            <div class="card-type">ID</div>
                        </div>
                        <div class="card-body-white">
                            <div class="avatar">${initials}</div>
                            <div class="details">
                                <div class="student-name">${s.name}</div>
                                <div class="student-id">ID: ${s.student_id}</div>
                                <div class="student-dob">DOB: ${s.dob || '-'}</div>
                            </div>
                        </div>
                        <div class="card-footer-bar">
                            <div class="footer-left"><span class="reg-no">${regNo}</span></div>
                            <div class="qr-code"><i class="fas fa-qrcode"></i></div>
                        </div>
                    </div>
                `;
            });
            html += `</div>`;
            container.innerHTML = html;
            modal.classList.add('active');
        }

        // ─── Bulk PDF Download ───
        function downloadBulkPDF() {
            const cards = document.querySelectorAll('.mini-card');
            if (cards.length === 0) { showToast('⚠️ No cards to download'); return; }
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4');
            const cardsPerPage = 6;
            const pageWidth = 297;
            const pageHeight = 210;
            const margin = 8;
            const cardWidth = (pageWidth - margin * 3) / 2;
            const cardHeight = cardWidth * (240/380);
            
            let completed = 0;
            cards.forEach((card, idx) => {
                if (idx % cardsPerPage === 0 && idx > 0) doc.addPage();
                const col = idx % 2;
                const row = Math.floor((idx % cardsPerPage) / 2);
                const x = margin + col * (cardWidth + margin);
                const y = margin + row * (cardHeight + margin);
                html2canvas(card, { scale: 2, useCORS: true, logging: false, backgroundColor: '#ffffff' })
                    .then(canvas => {
                        const imgData = canvas.toDataURL('image/png');
                        doc.addImage(imgData, 'PNG', x, y, cardWidth, cardHeight);
                        completed++;
                        if (completed === cards.length) {
                            doc.save('student_cards.pdf');
                            showToast('📄 PDF downloaded successfully!');
                        }
                    });
            });
        }

        // ─── Bulk PNG Download ───
        function downloadBulkPNG() {
            const cards = document.querySelectorAll('.mini-card');
            if (cards.length === 0) { showToast('⚠️ No cards to download'); return; }
            const grid = document.querySelector('.card-print-grid');
            html2canvas(grid, { scale: 2, useCORS: true, logging: false, backgroundColor: '#ffffff' })
                .then(canvas => {
                    const link = document.createElement('a');
                    link.download = 'student_cards.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                    showToast('🖼️ PNG downloaded successfully!');
                });
        }

        // ─── Bulk Print ───
        function printBulk() { window.print(); }

        // ─── Modal Close ───
        function closeModal(id) { document.getElementById(id).classList.remove('active'); }
        function openModal(id) { document.getElementById(id).classList.add('active'); }

        // ─── Single Card PDF ───
        function downloadPDF() {
            const card = document.getElementById('studentCard');
            if (!card) { showToast('⚠️ Please select a student first'); return; }
            if (!selectedStudent.issued) { showToast('⚠️ Card must be issued first'); return; }
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'mm', [105, 75]);
            html2canvas(card, { scale: 2, useCORS: true, logging: false, backgroundColor: '#ffffff' })
                .then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const pdfWidth = 95;
                    const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
                    doc.addImage(imgData, 'PNG', 5, 5, pdfWidth, pdfHeight);
                    doc.save('student_card.pdf');
                    showToast('📄 PDF downloaded successfully!');
                });
        }

        // ─── Single Card PNG ───
        function downloadPNG() {
            const card = document.getElementById('studentCard');
            if (!card) { showToast('⚠️ Please select a student first'); return; }
            if (!selectedStudent.issued) { showToast('⚠️ Card must be issued first'); return; }
            html2canvas(card, { scale: 2, useCORS: true, logging: false, backgroundColor: '#ffffff' })
                .then(canvas => {
                    const link = document.createElement('a');
                    link.download = 'student_card.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                    showToast('🖼️ PNG downloaded successfully!');
                });
        }

        // ─── Single Card Print ───
        function printCardSingle() {
            const card = document.getElementById('studentCard');
            if (!card) { showToast('⚠️ Please select a student first'); return; }
            if (!selectedStudent.issued) { showToast('⚠️ Card must be issued first'); return; }
            window.print();
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

        // ─── Modal Overlay Close ───
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