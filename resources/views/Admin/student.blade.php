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
    /* ... (all existing styles remain the same) ... */
    /* Include all styles from the previous version */
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

    /* ─── MAIN ─── */
    .main { flex:1; background: #F5F7FA; min-height: 100vh; display: flex; flex-direction: column; }

    /* ─── TOPBAR ─── */
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
    .profile-btn .avatar-sm { width: 34px; height: 34px; border-radius: 50%; background: #6D4AFF; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600; }
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
    .btn-success {
      background: #10B981; border: none; padding: 10px 24px; border-radius: 40px;
      font-weight: 600; font-size: 14px; color: #fff; display: inline-flex; align-items: center; gap: 8px;
      cursor: pointer; transition: 0.15s; font-family: 'Inter', sans-serif; box-shadow: 0 6px 14px -6px rgba(16,185,129,0.3);
    }
    .btn-success:hover { background: #059669; transform: translateY(-2px); }

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
    .status-badge.active { background: #DCFCE7; color: #10B981; }
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

    /* ─── FULL PROFILE MODAL ─── */
    .profile-modal .modal {
      max-width: 1100px;
      width: 95%;
      max-height: 95vh;
      padding: 0;
      border-radius: 28px;
      overflow: hidden;
    }
    .profile-modal .modal-body { padding: 0; }
    .profile-modal .modal-header {
      padding: 20px 28px;
      background: linear-gradient(135deg, #0A1628 0%, #1A2A4A 100%);
      color: #fff;
      border-radius: 28px 28px 0 0;
      margin: 0;
      flex-wrap: wrap;
      gap: 12px;
    }
    .profile-modal .modal-header h2 { color: #fff; }
    .profile-modal .modal-header .modal-close { color: rgba(255,255,255,0.6); }
    .profile-modal .modal-header .modal-close:hover { color: #fff; }

    .profile-content { padding: 28px 32px 32px; }

    /* Profile Top Section */
    .profile-top {
      display: flex;
      gap: 28px;
      align-items: flex-start;
      padding-bottom: 24px;
      border-bottom: 1px solid #F1F5F9;
      margin-bottom: 24px;
      flex-wrap: wrap;
    }
    .profile-avatar {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      background: linear-gradient(135deg, #6D4AFF, #8B6FFF);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 48px;
      font-weight: 700;
      color: #fff;
      flex-shrink: 0;
      border: 4px solid #fff;
      box-shadow: 0 4px 16px rgba(109,74,255,0.2);
      overflow: hidden;
    }
    .profile-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .profile-info {
      flex: 1;
    }
    .profile-info .name {
      font-size: 24px;
      font-weight: 700;
      color: #0F172A;
    }
    .profile-info .id {
      font-size: 14px;
      color: #6D4AFF;
      font-weight: 600;
    }
    .profile-info .details {
      display: flex;
      flex-wrap: wrap;
      gap: 16px 28px;
      margin-top: 8px;
    }
    .profile-info .details .item {
      font-size: 13px;
      color: #64748B;
    }
    .profile-info .details .item strong {
      color: #1E293B;
      font-weight: 600;
    }
    .profile-stats {
      display: flex;
      gap: 24px;
      flex-wrap: wrap;
    }
    .profile-stats .stat {
      background: #F8FAFC;
      padding: 10px 18px;
      border-radius: 12px;
      text-align: center;
      border: 1px solid #F1F5F9;
      min-width: 80px;
    }
    .profile-stats .stat .num {
      font-size: 22px;
      font-weight: 700;
      color: #0F172A;
    }
    .profile-stats .stat .label {
      font-size: 11px;
      color: #94A3B8;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* Profile Tabs */
    .profile-tabs {
      display: flex;
      gap: 4px;
      border-bottom: 1px solid #F1F5F9;
      margin-bottom: 20px;
      overflow-x: auto;
    }
    .profile-tab {
      padding: 10px 20px;
      font-weight: 600;
      font-size: 14px;
      color: #64748B;
      cursor: pointer;
      transition: all 0.2s;
      border-bottom: 2px solid transparent;
      background: none;
      border-top: none;
      border-left: none;
      border-right: none;
      font-family: 'Inter', sans-serif;
    }
    .profile-tab:hover { color: #1E293B; }
    .profile-tab.active {
      color: #6D4AFF;
      border-bottom-color: #6D4AFF;
    }
    .profile-tab i { margin-right: 8px; }

    .profile-tab-content {
      display: none;
      animation: fadeSlide 0.3s ease;
    }
    .profile-tab-content.active { display: block; }
    @keyframes fadeSlide {
      from { opacity: 0; transform: translateY(8px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .profile-table-wrap { overflow-x: auto; }
    .profile-table {
      width: 100%;
      font-size: 13px;
    }
    .profile-table th {
      background: #F8FAFC;
      padding: 10px 12px;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .profile-table td {
      padding: 10px 12px;
      border-bottom: 1px solid #F1F5F9;
    }
    .profile-table tr:hover td { background: #F8FAFC; }
    .profile-table .badge {
      font-size: 11px;
      font-weight: 600;
      padding: 2px 12px;
      border-radius: 30px;
    }
    .profile-table .badge.paid { background: #DCFCE7; color: #10B981; }
    .profile-table .badge.unpaid { background: #FEE2E2; color: #DC2626; }
    .profile-table .badge.partial { background: #FEF3C7; color: #D97706; }

    .profile-actions {
      display: flex;
      gap: 10px;
      margin-top: 20px;
      padding-top: 16px;
      border-top: 1px solid #F1F5F9;
      flex-wrap: wrap;
    }

    .status-badge-sm {
      font-size: 11px;
      font-weight: 600;
      padding: 2px 12px;
      border-radius: 30px;
    }

    /* Payment Slip Styles */
    .payment-slip {
      background: #fff;
      padding: 30px;
      border-radius: 16px;
      border: 1px solid #E2E8F0;
      max-width: 600px;
      margin: 0 auto;
    }
    .payment-slip .header {
      text-align: center;
      border-bottom: 2px solid #6D4AFF;
      padding-bottom: 16px;
      margin-bottom: 20px;
    }
    .payment-slip .header h2 {
      color: #0A1628;
      font-size: 24px;
    }
    .payment-slip .header p {
      color: #64748B;
      font-size: 14px;
    }
    .payment-slip .details {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }
    .payment-slip .details .row {
      padding: 8px 0;
      border-bottom: 1px solid #F1F5F9;
      display: flex;
      justify-content: space-between;
    }
    .payment-slip .details .row .label {
      color: #94A3B8;
      font-size: 12px;
      text-transform: uppercase;
    }
    .payment-slip .details .row .value {
      font-weight: 600;
      color: #1E293B;
      font-size: 14px;
    }
    .payment-slip .total {
      margin-top: 20px;
      padding-top: 16px;
      border-top: 2px solid #6D4AFF;
      text-align: right;
      font-size: 18px;
      font-weight: 700;
      color: #0A1628;
    }
    .payment-slip .footer {
      text-align: center;
      margin-top: 20px;
      padding-top: 16px;
      border-top: 1px solid #E2E8F0;
      color: #94A3B8;
      font-size: 12px;
    }

    .clickable-row {
      cursor: pointer;
      transition: background 0.15s;
    }
    .clickable-row:hover {
      background: #EDE7FF;
    }

    .loading-spinner {
      display: inline-block;
      width: 30px;
      height: 30px;
      border: 3px solid #E2E8F0;
      border-top-color: #6D4AFF;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    @media (max-width: 1024px) {
      .form-grid { grid-template-columns: 1fr; }
      .profile-top { flex-direction: column; align-items: center; text-align: center; }
      .profile-info .details { justify-content: center; }
      .profile-stats { justify-content: center; }
    }
    @media (max-width: 768px) {
      .sidebar { transform: translateX(-100%); width: 270px; position: fixed; top:0; left:0; height:100%; }
      .sidebar.open { transform: translateX(0); }
      .topbar-left .menu-toggle { display: block; }
      .search-box { width: 140px; }
      .content { padding: 20px 16px; }
      .topbar { padding: 12px 16px; }
      .modal { padding: 20px 18px; }
      .profile-modal .modal { width: 98%; }
      .profile-content { padding: 16px; }
      .profile-tabs { gap: 2px; }
      .profile-tab { padding: 8px 12px; font-size: 12px; }
      .profile-stats .stat { padding: 6px 12px; min-width: 60px; }
      .profile-stats .stat .num { font-size: 16px; }
    }

    @media print {
      .topbar, .sidebar, .modal-close, #printProfileBtn, .profile-actions, .profile-tabs { display: none !important; }
      .profile-modal .modal { box-shadow: none !important; border: none !important; border-radius: 0 !important; max-width: 100% !important; width: 100% !important; max-height: none !important; }
      .profile-modal .modal-header { background: #0A1628 !important; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
      .profile-modal .modal-header h2 { color: #fff !important; }
      body { background: #fff !important; }
      .modal-overlay { position: static !important; background: #fff !important; backdrop-filter: none !important; display: block !important; }
      .modal-overlay.active { display: block !important; }
      .profile-content { padding: 20px !important; }
      .payment-slip { border: none !important; box-shadow: none !important; }
    }
  </style>
</head>
<body>

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
          <button class="profile-btn" id="profileBtn">
            <div class="avatar-sm">A</div>
            <span>Admin</span>
            <i class="fas fa-chevron-down" style="font-size:12px; margin-left:4px;"></i>
          </button>
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

  <!-- ─── FULL PROFILE MODAL ─── -->
  <div class="modal-overlay profile-modal" id="profileModal">
    <div class="modal">
      <div class="modal-header">
        <h2><i class="fas fa-user-circle" style="color:#8B6FFF; margin-right:10px;"></i> Student Profile</h2>
        <div style="display:flex; gap:10px; align-items:center;">
          <button class="btn-success" id="printProfileBtn" style="padding:6px 16px; font-size:12px;"><i class="fas fa-print"></i> Print</button>
          <button class="modal-close" onclick="closeProfileModal()"><i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="modal-body">
        <div class="profile-content" id="profileContent">
          <div style="text-align:center; padding:60px 20px; color:#94A3B8;">
            <div class="loading-spinner"></div>
            <p style="margin-top:12px;">Loading profile...</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ─── PAYMENT SLIP MODAL ─── -->
  <div class="modal-overlay" id="paymentSlipModal">
    <div class="modal" style="max-width: 700px;">
      <div class="modal-header">
        <h2><i class="fas fa-receipt" style="color:#10B981; margin-right:10px;"></i> Payment Receipt</h2>
        <div style="display:flex; gap:10px; align-items:center;">
          <button class="btn-success" onclick="printPaymentSlip()" style="padding:6px 16px; font-size:12px;"><i class="fas fa-print"></i> Print Receipt</button>
          <button class="modal-close" onclick="document.getElementById('paymentSlipModal').classList.remove('active')"><i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="modal-body">
        <div id="paymentSlipContent" class="payment-slip">
          <!-- Dynamic content loaded via JS -->
        </div>
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

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    // ─── Load Students ───
    async function loadStudents() {
      try {
        const response = await fetch('{{ route("admin.students.index") }}', {
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
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
          const initials = s.name ? s.name.split(' ').map(w => w[0]).join('').toUpperCase() : 'ST';
          const statusClass = s.status || 'active';
          const hasImage = s.profile_image && s.profile_image !== null;
          const imageHtml = hasImage 
            ? `<img src="/storage/${s.profile_image}" alt="${s.name}" style="width:36px; height:36px; border-radius:50%; object-fit:cover;">`
            : `<div class="avatar-sm" style="background:#6D4AFF;">${initials}</div>`;
          return `
            <tr onclick="viewFullProfile(${s.id})">
              <td>${imageHtml}</td>
              <td><strong>${s.student_id || 'N/A'}</strong></td>
              <td><strong>${s.name || 'N/A'}</strong></td>
              <td>${s.father_name || '-'}</td>
              <td>${s.phone || '-'}</td>
              <td><span class="status-badge ${statusClass}">${statusClass.charAt(0).toUpperCase() + statusClass.slice(1)}</span></td>
              <td onclick="event.stopPropagation();">
                <div class="action-dropdown">
                  <button class="dropdown-trigger" onclick="toggleDD(this)"><i class="fas fa-ellipsis-v"></i></button>
                  <div class="dd-menu">
                    <a href="#" onclick="viewFullProfile(${s.id}); return false;"><i class="fas fa-eye"></i> View Profile</a>
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

    // ─── Pagination ───
    function renderPagination(totalPages) {
      const container = document.getElementById('paginationControls');
      if (totalPages <= 1) { container.innerHTML = ''; return; }
      let html = '';
      if (currentPage > 1) html += `<button class="btn-reset" style="padding:4px 14px;" onclick="goToPage(${currentPage - 1})">Prev</button>`;
      for (let i = 1; i <= totalPages; i++) {
        const active = i === currentPage ? 'background:#6D4AFF; color:#fff; border-color:#6D4AFF;' : '';
        html += `<button class="btn-reset" style="padding:4px 14px; ${active}" onclick="goToPage(${i})">${i}</button>`;
      }
      if (currentPage < totalPages) html += `<button class="btn-reset" style="padding:4px 14px;" onclick="goToPage(${currentPage + 1})">Next</button>`;
      container.innerHTML = html;
    }

    function goToPage(page) { currentPage = page; renderTable(); }

    // ─── Filters ───
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
    function filterTable() { currentPage = 1; renderTable(); }
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

    // ─── Sidebar Toggle (with null checks) ───
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    if (menuToggle && sidebar && overlay) {
      menuToggle.addEventListener('click', function() {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('active');
      });
      overlay.addEventListener('click', function() {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
      });
    }

    // ─── Profile Dropdown ───
    const profileBtn = document.getElementById('profileBtn');
    if (profileBtn) {
      profileBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown) dropdown.classList.toggle('open');
      });
    }
    document.addEventListener('click', function(e) {
      if (!e.target.closest('.profile-dropdown-wrap')) {
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown) dropdown.classList.remove('open');
      }
    });

    // ─── Modal Helpers ───
    function openModal() { document.getElementById('studentModal').classList.add('active'); }
    function closeModal() {
      document.getElementById('studentModal').classList.remove('active');
      document.getElementById('studentForm').reset();
      document.getElementById('studentId').value = '';
      document.getElementById('imagePreview').style.display = 'none';
      document.getElementById('sImage').value = '';
    }
    function closeDeleteModal() { document.getElementById('deleteModal').classList.remove('active'); deleteId = null; }
    function closeProfileModal() { document.getElementById('profileModal').classList.remove('active'); }

    // ─── Add Student ───
    const addStudentBtn = document.getElementById('addStudentBtn');
    if (addStudentBtn) {
      addStudentBtn.addEventListener('click', function() {
        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-user-plus" style="color:#6D4AFF; margin-right:10px;"></i> Add New Student';
        document.getElementById('saveBtn').innerHTML = '<i class="fas fa-save"></i> Save Student';
        document.getElementById('studentForm').reset();
        document.getElementById('studentId').value = '';
        document.getElementById('imagePreview').style.display = 'none';
        document.getElementById('sImage').value = '';
        document.getElementById('sStatus').value = 'active';
        openModal();
      });
    }

    // ─── Edit Student ───
    async function editStudent(id) {
      try {
        const response = await fetch(`/admin/students/${id}/edit`, {
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
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
        openModal();
      } catch (error) {
        showToast('⚠️ Error loading student data');
      }
    }

    // ─── View Payment Slip ───
    function viewPaymentSlip(payment, studentName) {
      const content = document.getElementById('paymentSlipContent');
      const date = payment.payment_date ? new Date(payment.payment_date).toLocaleDateString('en-GB', { day:'2-digit', month:'long', year:'numeric' }) : 'N/A';
      content.innerHTML = `
        <div class="header">
          <h2>🧾 Payment Receipt</h2>
          <p>Leeds Institute · Quality Education Since 2005</p>
          <p style="font-size:12px; color:#94A3B8;">Receipt #: ${payment.receipt_no || 'REC-' + Math.random().toString(36).substr(2, 6).toUpperCase()}</p>
        </div>
        <div class="details">
          <div class="row"><span class="label">Student Name</span><span class="value">${studentName}</span></div>
          <div class="row"><span class="label">Course</span><span class="value">${payment.course || 'N/A'}</span></div>
          <div class="row"><span class="label">Payment Date</span><span class="value">${date}</span></div>
          <div class="row"><span class="label">Payment Method</span><span class="value">${payment.payment_method || 'Cash'}</span></div>
          <div class="row"><span class="label">Amount Paid</span><span class="value" style="color:#10B981; font-size:16px;">PKR ${(payment.amount || 0).toLocaleString()}</span></div>
          <div class="row"><span class="label">Status</span><span class="value"><span class="badge ${payment.status === 'paid' ? 'paid' : 'partial'}">${payment.status || 'Paid'}</span></span></div>
        </div>
        <div class="total">
          Total: PKR ${(payment.amount || 0).toLocaleString()}
        </div>
        <div class="footer">
          <p>This is a computer-generated receipt. Valid without signature.</p>
          <p style="margin-top:4px;">📧 info@leedsinstitute.edu.pk · 📞 +92-XXX-XXXXXXX</p>
        </div>
      `;
      document.getElementById('paymentSlipModal').classList.add('active');
    }

    function printPaymentSlip() {
      window.print();
    }

    // ─── View Full Profile ───
    async function viewFullProfile(id) {
      try {
        const profileContent = document.getElementById('profileContent');
        profileContent.innerHTML = `
          <div style="text-align:center; padding:60px 20px; color:#94A3B8;">
            <div class="loading-spinner"></div>
            <p style="margin-top:12px;">Loading profile...</p>
          </div>
        `;
        document.getElementById('profileModal').classList.add('active');

        const response = await fetch(`/admin/students/${id}`, {
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await response.json();
        const s = data.data.student;
        const stats = data.data.stats;
        
        // Get certificates from enrollments
        const allCertificates = [];
        if (s.enrollments) {
          s.enrollments.forEach(enrollment => {
            if (enrollment.certificate) {
              allCertificates.push({
                ...enrollment.certificate,
                course_name: enrollment.course ? enrollment.course.name : 'N/A',
                enrollment_id: enrollment.id
              });
            }
          });
        }

        const initials = s.name ? s.name.split(' ').map(w => w[0]).join('').toUpperCase() : 'ST';
        const hasImage = s.profile_image && s.profile_image !== null;
        const statusClass = s.status || 'active';

        profileContent.innerHTML = `
          <div class="profile-top">
            <div class="profile-avatar">
              ${hasImage ? `<img src="/storage/${s.profile_image}" alt="${s.name}">` : initials}
            </div>
            <div class="profile-info">
              <div class="name">${s.name || 'N/A'}</div>
              <div class="id">${s.student_id || 'N/A'}</div>
              <div class="details">
                <span class="item"><strong>Father:</strong> ${s.father_name || '-'}</span>
                <span class="item"><strong>Phone:</strong> ${s.phone || '-'}</span>
                <span class="item"><strong>Email:</strong> ${s.email || '-'}</span>
                <span class="item"><strong>DOB:</strong> ${s.date_of_birth || '-'}</span>
                <span class="item"><strong>Nationality:</strong> ${s.nationality || '-'}</span>
                <span class="item"><strong>Qualification:</strong> ${s.qualification || '-'}</span>
                <span class="item"><strong>Address:</strong> ${s.address || '-'}</span>
                <span class="item"><strong>Status:</strong> <span class="status-badge-sm ${statusClass}">${statusClass.charAt(0).toUpperCase() + statusClass.slice(1)}</span></span>
              </div>
            </div>
            <div class="profile-stats">
              <div class="stat"><div class="num">${stats.total_enrollments}</div><div class="label">Enrollments</div></div>
              <div class="stat"><div class="num">PKR ${(stats.total_fee || 0).toLocaleString()}</div><div class="label">Total Fee</div></div>
              <div class="stat"><div class="num">PKR ${(stats.total_paid || 0).toLocaleString()}</div><div class="label">Paid</div></div>
              <div class="stat"><div class="num" style="color:#EF4444;">PKR ${(stats.remaining || 0).toLocaleString()}</div><div class="label">Remaining</div></div>
            </div>
          </div>

          <div class="profile-tabs">
            <button class="profile-tab active" data-tab="enrollments"><i class="fas fa-user-plus"></i> Enrollments</button>
            <button class="profile-tab" data-tab="payments"><i class="fas fa-dollar-sign"></i> Payments <span style="font-size:11px; color:#10B981;">(click to view)</span></button>
            <button class="profile-tab" data-tab="certificates"><i class="fas fa-certificate"></i> Certificates <span style="font-size:11px; color:#6D4AFF;">(click to view)</span></button>
          </div>

          <div class="profile-tab-content active" id="pt-enrollments">
            <div class="profile-table-wrap">
              <table class="profile-table">
                <thead><tr><th>#</th><th>Course</th><th>Date</th><th>Original Fee</th><th>Discount</th><th>Final Fee</th><th>Status</th></tr></thead>
                <tbody>
                  ${s.enrollments && s.enrollments.length > 0 ? s.enrollments.map((e, i) => `
                    <tr>
                      <td>${i+1}</td>
                      <td>${e.course ? e.course.name : 'N/A'}</td>
                      <td>${e.enrollment_date ? new Date(e.enrollment_date).toLocaleDateString('en-GB', {day:'2-digit', month:'short', year:'numeric'}) : '-'}</td>
                      <td>PKR ${(e.original_fee || 0).toLocaleString()}</td>
                      <td>PKR ${(e.discount || 0).toLocaleString()}</td>
                      <td><strong>PKR ${(e.final_fee || 0).toLocaleString()}</strong></td>
                      <td><span class="badge ${e.status === 'active' ? 'paid' : e.status === 'completed' ? 'paid' : 'unpaid'}">${e.status || 'active'}</span></td>
                    </tr>
                  `).join('') : '<tr><td colspan="7" style="text-align:center;color:#94A3B8;padding:20px;">No enrollments found</td></tr>'}
                </tbody>
              </table>
            </div>
          </div>

          <div class="profile-tab-content" id="pt-payments">
            <div class="profile-table-wrap">
              <table class="profile-table">
                <thead><tr><th>#</th><th>Receipt</th><th>Course</th><th>Amount</th><th>Method</th><th>Date</th><th>Status</th></tr></thead>
                <tbody>
                  ${s.enrollments && s.enrollments.flatMap(e => e.payments || []).length > 0 ? 
                    s.enrollments.flatMap((e, idx) => (e.payments || []).map((p, j) => ({
                      ...p,
                      idx: idx + 1,
                      course: e.course ? e.course.name : 'N/A',
                      student_name: s.name
                    }))).map((p, i) => `
                    <tr class="clickable-row" onclick="viewPaymentSlip({
                      receipt_no: '${p.receipt_no || 'REC-' + Math.random().toString(36).substr(2, 6).toUpperCase()}',
                      payment_date: '${p.payment_date || ''}',
                      payment_method: '${p.payment_method || 'Cash'}',
                      amount: ${p.amount || 0},
                      status: '${p.status || 'paid'}',
                      course: '${p.course}'
                    }, '${p.student_name}')">
                      <td>${i+1}</td>
                      <td><strong>${p.receipt_no || 'REC-0000'}</strong></td>
                      <td>${p.course}</td>
                      <td>PKR ${(p.amount || 0).toLocaleString()}</td>
                      <td>${p.payment_method || '-'}</td>
                      <td>${p.payment_date ? new Date(p.payment_date).toLocaleDateString('en-GB', {day:'2-digit', month:'short', year:'numeric'}) : '-'}</td>
                      <td><span class="badge ${p.status === 'paid' ? 'paid' : 'partial'}">${p.status || 'paid'}</span></td>
                    </tr>
                  `).join('') : '<tr><td colspan="7" style="text-align:center;color:#94A3B8;padding:20px;">No payments found</td></tr>'}
                </tbody>
              </table>
            </div>
          </div>

          <div class="profile-tab-content" id="pt-certificates">
            <div class="profile-table-wrap">
              <table class="profile-table">
                <thead><tr><th>#</th><th>CRT Number</th><th>Course</th><th>Issue Date</th><th>Status</th></tr></thead>
                <tbody>
                  ${allCertificates.length > 0 ? allCertificates.map((c, i) => `
                    <tr class="clickable-row" onclick="window.open('/admin/certificates/${c.enrollment_id || c.id || i+1}', '_blank')">
                      <td>${i+1}</td>
                      <td><strong>${c.certificate_no || c.crt_number || 'N/A'}</strong></td>
                      <td>${c.course_name || c.course?.name || 'N/A'}</td>
                      <td>${c.issue_date ? new Date(c.issue_date).toLocaleDateString('en-GB', {day:'2-digit', month:'short', year:'numeric'}) : '-'}</td>
                      <td><span class="badge ${c.status === 'issued' || c.status === 'verified' ? 'paid' : 'unpaid'}">${c.status || 'pending'}</span></td>
                    </tr>
                  `).join('') : '<tr><td colspan="5" style="text-align:center;color:#94A3B8;padding:20px;">No certificates found</td></tr>'}
                </tbody>
              </table>
            </div>
          </div>

          <div class="profile-actions">
            <button class="btn-primary" onclick="closeProfileModal(); editStudent(${s.id});" style="padding:8px 18px; font-size:13px;">
              <i class="fas fa-edit"></i> Edit Profile
            </button>
            <button class="btn-success" id="printProfileBtn" style="padding:8px 18px; font-size:13px;">
              <i class="fas fa-print"></i> Print Profile
            </button>
            <button class="btn-outline" onclick="closeProfileModal()" style="padding:8px 18px; font-size:13px;">
              <i class="fas fa-times"></i> Close
            </button>
          </div>
        `;

        // Tab switching
        document.querySelectorAll('.profile-tab').forEach(tab => {
          tab.addEventListener('click', function() {
            document.querySelectorAll('.profile-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.profile-tab-content').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('pt-' + this.dataset.tab).classList.add('active');
          });
        });

        // Print button
        document.getElementById('printProfileBtn').addEventListener('click', function() {
          window.print();
        });

      } catch (error) {
        console.error('Error loading profile:', error);
        document.getElementById('profileContent').innerHTML = `
          <div style="text-align:center; padding:40px; color:#EF4444;">
            <i class="fas fa-exclamation-circle" style="font-size:32px; display:block; margin-bottom:12px;"></i>
            Failed to load profile. Please try again.
          </div>
        `;
      }
    }

    // ─── Save Student ───
    async function saveStudent(e) {
      e.preventDefault();
      const id = document.getElementById('studentId').value;
      
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
      
      const fileInput = document.getElementById('sImage');
      if (fileInput.files.length > 0) formData.append('profile_image', fileInput.files[0]);

      if (id) formData.append('_method', 'PUT');

      const url = id ? `/admin/students/${id}` : '{{ route("admin.students.store") }}';

      try {
        const response = await fetch(url, {
          method: 'POST',
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
          for (const key in errors) errorMsg += `- ${errors[key].join(', ')}\n`;
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
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
          showToast('⚠️ Please upload JPG, PNG or GIF image');
          input.value = '';
          return;
        }
        if (file.size > 2 * 1024 * 1024) {
          showToast('⚠️ Image size must be less than 2MB');
          input.value = '';
          return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('imagePreviewImg').src = e.target.result;
          document.getElementById('imagePreview').style.display = 'block';
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
        if (e.target === this) this.classList.remove('active');
      });
    });

    // ─── Init ───
    loadStudents();
  </script>
</body>
</html>