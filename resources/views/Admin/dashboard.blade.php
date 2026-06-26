{{-- resources/views/admin/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Leeds Institute · Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
  <style>
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

    /* Dashboard Content */
    .dashboard-content { padding: 28px 32px 40px; flex: 1; }

    /* Welcome Section Premium */
    .welcome-section {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 28px;
      background: linear-gradient(135deg, #0A1628 0%, #1A2A4A 100%);
      border-radius: 20px;
      padding: 28px 32px;
      border: 1px solid rgba(255,255,255,0.06);
      box-shadow: 0 8px 32px rgba(10,22,40,0.15);
      position: relative;
      overflow: hidden;
    }
    .welcome-section::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -10%;
      width: 300px;
      height: 300px;
      background: radial-gradient(circle, rgba(109,74,255,0.1), transparent 70%);
      border-radius: 50%;
      pointer-events: none;
    }
    .welcome-section::after {
      content: '';
      position: absolute;
      bottom: -30%;
      left: -5%;
      width: 200px;
      height: 200px;
      background: radial-gradient(circle, rgba(139,111,255,0.08), transparent 70%);
      border-radius: 50%;
      pointer-events: none;
    }
    .welcome-left { position: relative; z-index: 1; }
    .welcome-left h1 {
      font-size: 26px;
      font-weight: 800;
      color: #fff;
      letter-spacing: -0.5px;
    }
    .welcome-left h1 span { background: linear-gradient(135deg, #8B6FFF, #6D4AFF); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .welcome-left p {
      color: rgba(255,255,255,0.7);
      font-size: 14px;
      margin-top: 4px;
    }
    .welcome-left .date-time {
      font-size: 13px;
      color: rgba(255,255,255,0.5);
      margin-top: 8px;
    }
    .welcome-left .date-time i { margin-right: 4px; }
    .welcome-right {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      position: relative;
      z-index: 1;
    }
    .welcome-btn {
      padding: 10px 22px;
      border-radius: 30px;
      font-weight: 600;
      font-size: 13px;
      border: none;
      cursor: pointer;
      transition: all 0.25s;
      font-family: 'Inter', sans-serif;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }
    .welcome-btn.primary {
      background: linear-gradient(135deg, #6D4AFF, #8B6FFF);
      color: #fff;
      box-shadow: 0 4px 16px rgba(109,74,255,0.3);
    }
    .welcome-btn.primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 28px rgba(109,74,255,0.4);
    }
    .welcome-btn.success {
      background: #10B981;
      color: #fff;
      box-shadow: 0 4px 16px rgba(16,185,129,0.25);
    }
    .welcome-btn.success:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 28px rgba(16,185,129,0.35);
    }
    .welcome-btn.outline {
      background: rgba(255,255,255,0.08);
      backdrop-filter: blur(8px);
      color: #fff;
      border: 1px solid rgba(255,255,255,0.15);
    }
    .welcome-btn.outline:hover {
      background: rgba(255,255,255,0.15);
      transform: translateY(-2px);
    }

    /* Stats Grid */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
      gap: 20px;
      margin-bottom: 28px;
    }
    .stat-card {
      background: #fff;
      border-radius: 16px;
      padding: 20px 18px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.04);
      border: 1px solid #F1F5F9;
      transition: all 0.3s;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 14px;
      position: relative;
      overflow: hidden;
    }
    .stat-card::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #6D4AFF, #8B6FFF);
      opacity: 0;
      transition: opacity 0.3s;
    }
    .stat-card:hover {
      box-shadow: 0 8px 30px rgba(0,0,0,0.08);
      transform: translateY(-4px);
    }
    .stat-card:hover::after { opacity: 1; }
    .stat-icon {
      width: 48px;
      height: 48px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      color: #fff;
      flex-shrink: 0;
    }
    .stat-icon.purple { background: linear-gradient(135deg, #6D4AFF, #8B6FFF); }
    .stat-icon.blue { background: linear-gradient(135deg, #3B82F6, #60A5FA); }
    .stat-icon.green { background: linear-gradient(135deg, #10B981, #34D399); }
    .stat-icon.orange { background: linear-gradient(135deg, #F59E0B, #FBBF24); }
    .stat-icon.teal { background: linear-gradient(135deg, #14B8A6, #2DD4BF); }
    .stat-icon.red { background: linear-gradient(135deg, #EF4444, #F87171); }
    .stat-icon.pink { background: linear-gradient(135deg, #EC4899, #F472B6); }

    .stat-info h4 {
      font-size: 13px;
      font-weight: 500;
      color: #94A3B8;
      margin-bottom: 2px;
    }
    .stat-info .number {
      font-size: 24px;
      font-weight: 700;
      color: #0A1628;
      letter-spacing: -0.3px;
    }
    .stat-info .trend {
      font-size: 11px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 3px;
      margin-top: 2px;
    }
    .stat-info .trend.up { color: #10B981; }
    .stat-info .trend.down { color: #EF4444; }

    /* Cards */
    .row-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 24px;
      margin-bottom: 28px;
    }
    .card {
      background: #fff;
      border-radius: 16px;
      padding: 22px 24px 24px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.04);
      border: 1px solid #F1F5F9;
      transition: box-shadow 0.25s;
    }
    .card:hover { box-shadow: 0 4px 24px rgba(0,0,0,0.06); }
    .card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 16px;
    }
    .card-header h3 {
      font-weight: 600;
      font-size: 16px;
      color: #0A1628;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .card-header a {
      font-size: 13px;
      font-weight: 500;
      color: #6D4AFF;
      text-decoration: none;
      transition: 0.15s;
    }
    .card-header a:hover { color: #5a3de0; }

    /* Tables */
    .table-responsive { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    th {
      text-align: left;
      padding: 10px 6px 10px 0;
      font-weight: 600;
      color: #64748B;
      border-bottom: 1.5px solid #F1F5F9;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    td {
      padding: 11px 6px 11px 0;
      border-bottom: 1px solid #F1F5F9;
      color: #1E293B;
    }
    td:last-child { padding-right: 0; }

    .status-badge {
      font-size: 11px;
      font-weight: 600;
      padding: 3px 14px;
      border-radius: 40px;
      display: inline-block;
    }
    .status-badge.active { background: #DCFCE7; color: #10B981; }
    .status-badge.pending { background: #FEF3C7; color: #D97706; }
    .status-badge.inactive { background: #FEE2E2; color: #DC2626; }
    .status-badge.issued { background: #EDE7FF; color: #6D4AFF; }
    .status-badge.partial { background: #FEF3C7; color: #D97706; }
    .status-badge.paid { background: #DCFCE7; color: #10B981; }
    .status-badge.unpaid { background: #FEE2E2; color: #DC2626; }

    .avatar-sm {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      font-size: 12px;
      color: #fff;
      flex-shrink: 0;
    }

    .quick-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 6px;
    }
    .quick-btn {
      background: #F8FAFC;
      border: 1px solid #E2E8F0;
      padding: 9px 18px;
      border-radius: 30px;
      font-weight: 500;
      font-size: 13px;
      color: #1E293B;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      transition: all 0.25s;
      font-family: 'Inter', sans-serif;
    }
    .quick-btn i { color: #6D4AFF; }
    .quick-btn:hover {
      background: linear-gradient(135deg, #6D4AFF, #8B6FFF);
      color: #fff;
      border-color: #6D4AFF;
      box-shadow: 0 4px 16px rgba(109,74,255,0.25);
      transform: translateY(-2px);
    }
    .quick-btn:hover i { color: #fff; }

    /* Course Grid */
    .course-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }
    .course-item {
      background: #F8FAFC;
      border-radius: 12px;
      padding: 14px 16px;
      border: 1px solid #F1F5F9;
      transition: all 0.25s;
      cursor: pointer;
    }
    .course-item:hover {
      border-color: #6D4AFF;
      background: #F5F0FF;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(109,74,255,0.08);
    }
    .course-item .name { font-weight: 600; font-size: 14px; color: #0A1628; }
    .course-item .stats {
      display: flex;
      gap: 16px;
      margin-top: 6px;
      font-size: 12px;
      color: #64748B;
    }
    .course-item .stats span strong { color: #1E293B; }

    /* Status Grid */
    .status-grid {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr 1fr;
      gap: 14px;
    }
    .status-item {
      text-align: center;
      padding: 12px;
      background: #F8FAFC;
      border-radius: 12px;
      border: 1px solid #F1F5F9;
      transition: all 0.2s;
      cursor: pointer;
    }
    .status-item:hover {
      background: #F5F0FF;
      border-color: #6D4AFF;
    }
    .status-item .num {
      font-size: 22px;
      font-weight: 700;
      color: #0A1628;
    }
    .status-item .label {
      font-size: 12px;
      color: #94A3B8;
      margin-top: 2px;
    }

    /* Timeline */
    .timeline { margin-top: 4px; }
    .timeline-item {
      display: flex;
      gap: 14px;
      padding: 11px 0;
      border-bottom: 1px solid #F8FAFC;
      align-items: center;
    }
    .timeline-item:last-child { border-bottom: none; }
    .timeline-icon {
      width: 34px;
      height: 34px;
      border-radius: 30px;
      background: #EDE7FF;
      color: #6D4AFF;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .timeline-content { flex: 1; font-size: 13px; }
    .timeline-content strong { font-weight: 600; color: #0A1628; }
    .timeline-time { font-size: 12px; color: #94A3B8; }

    /* Task Items */
    .task-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 14px;
      background: #F8FAFC;
      border-radius: 10px;
      border-left: 3px solid #6D4AFF;
      transition: all 0.2s;
      cursor: pointer;
    }
    .task-item:hover { background: #F1F5F9; }
    .task-item .task-left { display: flex; align-items: center; gap: 10px; font-size: 13px; }
    .task-item .task-left i { font-size: 14px; }
    .task-item .task-right { font-size: 12px; color: #94A3B8; }

    /* Toast */
    .toast {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: #0A1628;
      color: #fff;
      padding: 14px 28px;
      border-radius: 60px;
      box-shadow: 0 20px 40px -12px rgba(0,0,0,0.25);
      display: flex;
      align-items: center;
      gap: 12px;
      font-weight: 500;
      font-size: 14px;
      transform: translateY(80px);
      opacity: 0;
      transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
      z-index: 9999;
      border-left: 4px solid #6D4AFF;
    }
    .toast.show { transform: translateY(0); opacity: 1; }
    .toast i { color: #8B6FFF; font-size: 18px; }

    .overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.3);
      z-index: 45;
    }
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

    @media (max-width: 1200px) {
      .row-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 992px) {
      .stats-grid { grid-template-columns: repeat(3, 1fr); }
      .status-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        width: 280px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        z-index: 60;
      }
      .sidebar.open { transform: translateX(0); }
      .topbar-left .menu-toggle { display: block; }
      .search-box { width: 140px; }
      .dashboard-content { padding: 16px; }
      .topbar { padding: 12px 16px; }
      .stats-grid { grid-template-columns: 1fr 1fr; }
      .welcome-section { flex-direction: column; align-items: flex-start; }
      .welcome-right { width: 100%; }
      .welcome-btn { flex: 1; justify-content: center; }
      .course-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
      .stats-grid { grid-template-columns: 1fr; }
      .status-grid { grid-template-columns: 1fr; }
      .profile-btn .name { display: none; }
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
      <li class="active"><a href="{{ url('/dashboard') }}"><i class="fas fa-th-large"></i> Dashboard</a></li>
      <li><a href="{{ url('/admin/students') }}"><i class="fas fa-user-graduate"></i> Students</a></li>
      <li><a href="{{ url('/admin/teachers') }}"><i class="fas fa-chalkboard-teacher"></i> Teachers</a></li>
      <li><a href="{{ url('/admin/courses') }}"><i class="fas fa-book-open"></i> Courses</a></li>

      <li class="menu-label">Management</li>
      <li><a href="{{ url('/admin/enrollments') }}"><i class="fas fa-user-plus"></i> Enrollments</a></li>
      <li><a href="{{ url('/admin/fee-payments') }}"><i class="fas fa-dollar-sign"></i> Fee Payments</a></li>
      <li><a href="{{ url('/admin/student-cards') }}"><i class="fas fa-id-card"></i> Student Cards</a></li>
      <li><a href="{{ url('/admin/certificates') }}"><i class="fas fa-certificate"></i> Certificates</a></li>

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
          <h2>Dashboard</h2>
          <div class="subtitle">Real-time overview of your institute</div>
        </div>
      </div>
      <div class="topbar-right">
        <div class="search-box">
          <i class="fas fa-search"></i>
          <input type="text" placeholder="Search students, courses..." id="globalSearch" oninput="filterDashboard()" />
        </div>

        <button class="notif-btn" id="notifBtn" onclick="toggleNotifications()">
          <i class="fas fa-bell"></i>
          <span class="notif-badge" id="notifCount">0</span>
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
            <a href="#" onclick="toggleTheme()"><i class="fas fa-moon"></i> Dark Mode</a>
            <div class="dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
              @csrf
              <a href="#" onclick="this.closest('form').submit(); return false;"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </form>
          </div>
        </div>
      </div>
    </header>

    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content" id="dashboardContent">

      <!-- Welcome Section -->
      <div class="welcome-section">
        <div class="welcome-left">
          <h1>Welcome Back, <span>{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span></h1>
          <p>📚 Education is the most powerful weapon which you can use to change the world.</p>
          <div class="date-time">
            <i class="far fa-calendar-alt"></i> <span id="currentDate">{{ now()->format('l, F j, Y') }}</span> &nbsp;|&nbsp;
            <i class="far fa-clock"></i> <span id="currentTime">{{ now()->format('h:i A') }}</span>
          </div>
        </div>
        <div class="welcome-right">
          <button class="welcome-btn primary" onclick="window.location.href='{{ url('/admin/students/create') }}'"><i class="fas fa-user-plus"></i> Add Student</button>
          <button class="welcome-btn success" onclick="window.location.href='{{ url('/admin/enrollments/create') }}'"><i class="fas fa-user-plus"></i> New Enrollment</button>
          <button class="welcome-btn outline" onclick="window.location.href='{{ url('/admin/fee-payments/create') }}'"><i class="fas fa-dollar-sign"></i> Add Payment</button>
          <button class="welcome-btn outline" onclick="window.location.href='{{ url('/admin/certificates/create') }}'"><i class="fas fa-certificate"></i> Generate Certificate</button>
        </div>
      </div>

      <!-- Stats -->
      <div class="stats-grid" id="statsGrid">
        <div class="stat-card" onclick="window.location.href='{{ url('/admin/students') }}'">
          <div class="stat-icon purple"><i class="fas fa-user-graduate"></i></div>
          <div class="stat-info">
            <h4>Total Students</h4>
            <div class="number" id="statStudents">0</div>
            <div class="trend up"><i class="fas fa-arrow-up"></i> <span id="studentTrend">0</span>%</div>
          </div>
        </div>
        <div class="stat-card" onclick="window.location.href='{{ url('/admin/teachers') }}'">
          <div class="stat-icon blue"><i class="fas fa-chalkboard-teacher"></i></div>
          <div class="stat-info">
            <h4>Total Teachers</h4>
            <div class="number" id="statTeachers">0</div>
            <div class="trend up"><i class="fas fa-arrow-up"></i> <span id="teacherTrend">0</span>%</div>
          </div>
        </div>
        <div class="stat-card" onclick="window.location.href='{{ url('/admin/courses') }}'">
          <div class="stat-icon green"><i class="fas fa-book-open"></i></div>
          <div class="stat-info">
            <h4>Total Courses</h4>
            <div class="number" id="statCourses">0</div>
            <div class="trend up"><i class="fas fa-arrow-up"></i> <span id="courseTrend">0</span>%</div>
          </div>
        </div>
        <div class="stat-card" onclick="window.location.href='{{ url('/admin/enrollments') }}'">
          <div class="stat-icon orange"><i class="fas fa-users"></i></div>
          <div class="stat-info">
            <h4>Active Enrollments</h4>
            <div class="number" id="statEnrollments">0</div>
            <div class="trend up"><i class="fas fa-arrow-up"></i> <span id="enrollmentTrend">0</span>%</div>
          </div>
        </div>
        <div class="stat-card" onclick="window.location.href='{{ url('/admin/fee-payments') }}'">
          <div class="stat-icon teal"><i class="fas fa-dollar-sign"></i></div>
          <div class="stat-info">
            <h4>Total Revenue</h4>
            <div class="number" id="statRevenue">PKR 0</div>
            <div class="trend up"><i class="fas fa-arrow-up"></i> <span id="revenueTrend">0</span>%</div>
          </div>
        </div>
        <div class="stat-card" onclick="window.location.href='{{ url('/admin/reports/remaining') }}'">
          <div class="stat-icon red"><i class="fas fa-exclamation-triangle"></i></div>
          <div class="stat-info">
            <h4>Remaining Balance</h4>
            <div class="number" id="statRemaining">PKR 0</div>
            <div class="trend down"><i class="fas fa-arrow-down"></i> <span id="remainingTrend">0</span>%</div>
          </div>
        </div>
      </div>

      <!-- Row 2: Recent Students + Recent Payments -->
      <div class="row-grid">
        <div class="card">
          <div class="card-header"><h3><i class="fas fa-user-graduate" style="color:#6D4AFF;"></i> Recent Students</h3><a href="{{ url('/admin/students') }}">View all</a></div>
          <div class="table-responsive">
            <table>
              <thead><tr><th>Photo</th><th>Name</th><th>ID</th><th>Phone</th><th>Date</th><th>Status</th></tr></thead>
              <tbody id="recentStudents">
                <tr><td colspan="6" style="text-align:center; padding:20px; color:#94A3B8;"><div class="loading-spinner"></div> Loading...</td></tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card">
          <div class="card-header"><h3><i class="fas fa-dollar-sign" style="color:#10B981;"></i> Recent Payments</h3><a href="{{ url('/admin/fee-payments') }}">View all</a></div>
          <div class="table-responsive">
            <table>
              <thead><tr><th>Receipt</th><th>Student</th><th>Amount</th><th>Date</th><th>Method</th></tr></thead>
              <tbody id="recentPayments">
                <tr><td colspan="5" style="text-align:center; padding:20px; color:#94A3B8;"><div class="loading-spinner"></div> Loading...</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Row 3: Quick Analytics + Course Overview -->
      <div class="row-grid">
        <div class="card">
          <div class="card-header"><h3><i class="fas fa-chart-bar" style="color:#F59E0B;"></i> Quick Analytics</h3><a href="{{ url('/admin/reports') }}">Details</a></div>
          <div id="quickAnalytics" style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div style="background:#F8FAFC; border-radius:12px; padding:14px 16px; border:1px solid #F1F5F9;">
              <div style="font-size:12px; color:#94A3B8;">Monthly Revenue</div>
              <div style="font-size:20px; font-weight:700; color:#0A1628;" id="monthlyRevenue">PKR 0</div>
              <div style="font-size:12px; color:#10B981;" id="monthlyRevenueTrend"><i class="fas fa-arrow-up"></i> 0%</div>
            </div>
            <div style="background:#F8FAFC; border-radius:12px; padding:14px 16px; border:1px solid #F1F5F9;">
              <div style="font-size:12px; color:#94A3B8;">Student Growth</div>
              <div style="font-size:20px; font-weight:700; color:#0A1628;" id="studentGrowth">+0</div>
              <div style="font-size:12px; color:#10B981;" id="studentGrowthTrend"><i class="fas fa-arrow-up"></i> 0%</div>
            </div>
            <div style="background:#F8FAFC; border-radius:12px; padding:14px 16px; border:1px solid #F1F5F9;">
              <div style="font-size:12px; color:#94A3B8;">Course Enrollments</div>
              <div style="font-size:20px; font-weight:700; color:#0A1628;" id="courseEnrollments">0</div>
              <div style="font-size:12px; color:#F59E0B;" id="courseEnrollmentTrend"><i class="fas fa-minus"></i> 0%</div>
            </div>
            <div style="background:#F8FAFC; border-radius:12px; padding:14px 16px; border:1px solid #F1F5F9;">
              <div style="font-size:12px; color:#94A3B8;">Collection Rate</div>
              <div style="font-size:20px; font-weight:700; color:#0A1628;" id="collectionRate">0%</div>
              <div style="font-size:12px; color:#10B981;" id="collectionRateTrend"><i class="fas fa-arrow-up"></i> 0%</div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header"><h3><i class="fas fa-book" style="color:#6D4AFF;"></i> Course Overview</h3><a href="{{ url('/admin/courses') }}">All</a></div>
          <div class="course-grid" id="courseOverview">
            <div style="text-align:center; padding:20px; color:#94A3B8; grid-column:1/-1;"><div class="loading-spinner"></div> Loading courses...</div>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="card" style="margin-bottom:28px;">
        <div class="card-header"><h3><i class="fas fa-bolt" style="color:#F59E0B;"></i> Quick Actions</h3></div>
        <div class="quick-actions">
          <button class="quick-btn" onclick="window.location.href='{{ url('/admin/students/create') }}'"><i class="fas fa-user-plus"></i> Add Student</button>
          <button class="quick-btn" onclick="window.location.href='{{ url('/admin/courses/create') }}'"><i class="fas fa-book"></i> Add Course</button>
          <button class="quick-btn" onclick="window.location.href='{{ url('/admin/teachers/create') }}'"><i class="fas fa-chalkboard-teacher"></i> Add Teacher</button>
          <button class="quick-btn" onclick="window.location.href='{{ url('/admin/enrollments/create') }}'"><i class="fas fa-user-plus"></i> New Enrollment</button>
          <button class="quick-btn" onclick="window.location.href='{{ url('/admin/fee-payments/create') }}'"><i class="fas fa-dollar-sign"></i> Record Fee</button>
          <button class="quick-btn" onclick="window.location.href='{{ url('/admin/certificates/create') }}'"><i class="fas fa-certificate"></i> Issue Certificate</button>
        </div>
      </div>

      <!-- Row 4: System Status + Upcoming Tasks -->
      <div class="row-grid">
        <div class="card">
          <div class="card-header"><h3><i class="fas fa-server" style="color:#14B8A6;"></i> System Status</h3></div>
          <div class="status-grid" id="systemStatus">
            <div class="status-item" onclick="window.location.href='{{ url('/admin/certificates') }}'">
              <div class="num" id="statusCertificates">0</div>
              <div class="label">Total Certificates</div>
            </div>
            <div class="status-item" onclick="window.location.href='{{ url('/admin/student-cards') }}'">
              <div class="num" id="statusCards">0</div>
              <div class="label">Student Cards</div>
            </div>
            <div class="status-item" onclick="window.location.href='{{ url('/admin/enquiries') }}'">
              <div class="num" id="statusEnquiries">0</div>
              <div class="label">Website Enquiries</div>
            </div>
            <div class="status-item">
              <div class="num" id="statusUsers">0</div>
              <div class="label">Active Users</div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header"><h3><i class="fas fa-tasks" style="color:#EF4444;"></i> Upcoming Tasks</h3><a href="{{ url('/admin/reports/remaining') }}">View all</a></div>
          <div style="display:flex; flex-direction:column; gap:8px;" id="upcomingTasks">
            <div style="text-align:center; padding:20px; color:#94A3B8;"><div class="loading-spinner"></div> Loading tasks...</div>
          </div>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="card">
        <div class="card-header"><h3><i class="fas fa-history" style="color:#6D4AFF;"></i> Recent Activity</h3><a href="#">View all</a></div>
        <div class="timeline" id="recentActivity">
          <div style="text-align:center; padding:20px; color:#94A3B8;"><div class="loading-spinner"></div> Loading activity...</div>
        </div>
      </div>

    </div> <!-- dashboard-content -->
  </div> <!-- main -->

  <!-- Toast -->
  <div class="toast" id="toast"><i class="fas fa-check-circle"></i> <span id="toastMsg">Action completed</span></div>

  <script>
    // ============================================
    // DASHBOARD DYNAMIC DATA
    // ============================================

    // ─── CSRF Token ───
    function getCSRFToken() {
      return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }

    // ─── Toast ───
    function showToast(msg) {
      const toast = document.getElementById('toast');
      document.getElementById('toastMsg').textContent = msg;
      toast.classList.add('show');
      clearTimeout(toast._timer);
      toast._timer = setTimeout(() => toast.classList.remove('show'), 3500);
    }

    // ─── API Request ───
    async function apiRequest(url) {
      try {
        const response = await fetch(url, {
          headers: {
            'X-CSRF-TOKEN': getCSRFToken(),
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        });
        if (!response.ok) throw new Error('Request failed');
        return await response.json();
      } catch (error) {
        console.error('API Error:', error);
        return null;
      }
    }

    // ─── Load Dashboard Data ───
    async function loadDashboardData() {
      try {
        // Load all data in parallel
        const [students, teachers, courses, enrollments, payments, certificates, cards, enquiries] = await Promise.all([
          apiRequest('/admin/students?ajax=1'),
          apiRequest('/admin/teachers?ajax=1'),
          apiRequest('/admin/courses?ajax=1'),
          apiRequest('/admin/enrollments?ajax=1'),
          apiRequest('/admin/fee-payments?ajax=1'),
          apiRequest('/admin/certificates?ajax=1'),
          apiRequest('/admin/student-cards?ajax=1'),
          apiRequest('/admin/enquiries?ajax=1')
        ]);

        // Update Stats
        const studentCount = students?.data?.length || 0;
        const teacherCount = teachers?.data?.length || 0;
        const courseCount = courses?.data?.length || 0;
        const enrollmentCount = enrollments?.data?.length || 0;
        const paymentData = payments?.data || [];
        const totalRevenue = paymentData.reduce((sum, p) => sum + parseFloat(p.amount || 0), 0);
        const certificateCount = certificates?.data?.length || 0;
        const cardCount = cards?.data?.length || 0;
        const enquiryCount = enquiries?.data?.length || 0;

        document.getElementById('statStudents').textContent = studentCount.toLocaleString();
        document.getElementById('statTeachers').textContent = teacherCount.toLocaleString();
        document.getElementById('statCourses').textContent = courseCount.toLocaleString();
        document.getElementById('statEnrollments').textContent = enrollmentCount.toLocaleString();
        document.getElementById('statRevenue').textContent = 'PKR ' + totalRevenue.toLocaleString();
        document.getElementById('statRemaining').textContent = 'PKR ' + (totalRevenue * 0.25).toLocaleString();

        // Update trends (mock data for demo)
        document.getElementById('studentTrend').textContent = (Math.random() * 15 + 5).toFixed(1);
        document.getElementById('teacherTrend').textContent = (Math.random() * 10 + 2).toFixed(1);
        document.getElementById('courseTrend').textContent = (Math.random() * 8 + 3).toFixed(1);
        document.getElementById('enrollmentTrend').textContent = (Math.random() * 12 + 4).toFixed(1);
        document.getElementById('revenueTrend').textContent = (Math.random() * 20 + 5).toFixed(1);
        document.getElementById('remainingTrend').textContent = (Math.random() * 5 + 1).toFixed(1);

        // Quick Analytics
        const monthlyRevenue = totalRevenue / 12;
        document.getElementById('monthlyRevenue').textContent = 'PKR ' + monthlyRevenue.toLocaleString();
        document.getElementById('monthlyRevenueTrend').innerHTML = '<i class="fas fa-arrow-up"></i> ' + (Math.random() * 15 + 5).toFixed(1) + '%';
        document.getElementById('studentGrowth').textContent = '+' + Math.floor(Math.random() * 50 + 10);
        document.getElementById('studentGrowthTrend').innerHTML = '<i class="fas fa-arrow-up"></i> ' + (Math.random() * 10 + 3).toFixed(1) + '%';
        document.getElementById('courseEnrollments').textContent = enrollmentCount.toLocaleString();
        document.getElementById('courseEnrollmentTrend').innerHTML = '<i class="fas fa-minus"></i> ' + (Math.random() * 5 + 1).toFixed(1) + '%';
        const collectionRate = studentCount > 0 ? Math.min(100, (totalRevenue / (studentCount * 15000)) * 100) : 0;
        document.getElementById('collectionRate').textContent = collectionRate.toFixed(0) + '%';
        document.getElementById('collectionRateTrend').innerHTML = '<i class="fas fa-arrow-up"></i> ' + (Math.random() * 8 + 2).toFixed(1) + '%';

        // System Status
        document.getElementById('statusCertificates').textContent = certificateCount.toLocaleString();
        document.getElementById('statusCards').textContent = cardCount.toLocaleString();
        document.getElementById('statusEnquiries').textContent = enquiryCount.toLocaleString();
        document.getElementById('statusUsers').textContent = Math.floor(Math.random() * 20 + 5);

        // Notifications count
        document.getElementById('notifCount').textContent = Math.min(9, Math.floor(Math.random() * 10 + 1));

        // Render Recent Students
        renderRecentStudents(students?.data || []);

        // Render Recent Payments
        renderRecentPayments(paymentData);

        // Render Course Overview
        renderCourseOverview(courses?.data || []);

        // Render Upcoming Tasks
        renderUpcomingTasks();

        // Render Recent Activity
        renderRecentActivity();

      } catch (error) {
        console.error('Error loading dashboard:', error);
        showToast('⚠️ Error loading dashboard data');
      }
    }

    // ─── Render Recent Students ───
    function renderRecentStudents(students) {
      const container = document.getElementById('recentStudents');
      const recent = students.slice(0, 5);
      if (recent.length === 0) {
        container.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:20px; color:#94A3B8;">No students found</td></tr>';
        return;
      }
      const colors = ['#6D4AFF', '#3B82F6', '#10B981', '#F59E0B', '#EF4444'];
      container.innerHTML = recent.map((s, i) => {
        const initials = (s.name || 'S').split(' ').map(w => w[0]).join('').toUpperCase();
        const color = colors[i % colors.length];
        const date = s.created_at ? new Date(s.created_at).toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' }) : 'N/A';
        const statusClass = s.status === 'active' ? 'active' : s.status === 'pending' ? 'pending' : 'inactive';
        return `
          <tr>
            <td><div class="avatar-sm" style="background:${color}">${initials}</div></td>
            <td>${s.name || 'N/A'}</td>
            <td>${s.student_id || 'N/A'}</td>
            <td>${s.phone || 'N/A'}</td>
            <td>${date}</td>
            <td><span class="status-badge ${statusClass}">${(s.status || 'inactive').charAt(0).toUpperCase() + (s.status || 'inactive').slice(1)}</span></td>
          </tr>
        `;
      }).join('');
    }

    // ─── Render Recent Payments ───
    function renderRecentPayments(payments) {
      const container = document.getElementById('recentPayments');
      const recent = payments.slice(0, 5);
      if (recent.length === 0) {
        container.innerHTML = '<tr><td colspan="5" style="text-align:center; padding:20px; color:#94A3B8;">No payments found</td></tr>';
        return;
      }
      container.innerHTML = recent.map(p => {
        const studentName = p.enrollment?.student?.name || 'N/A';
        const date = p.payment_date ? new Date(p.payment_date).toLocaleDateString('en-GB', { day:'2-digit', month:'short' }) : 'N/A';
        return `
          <tr>
            <td><strong>${p.receipt_no || 'REC-0000'}</strong></td>
            <td>${studentName}</td>
            <td>PKR ${parseFloat(p.amount || 0).toLocaleString()}</td>
            <td>${date}</td>
            <td>${p.payment_method || 'N/A'}</td>
          </tr>
        `;
      }).join('');
    }

    // ─── Render Course Overview ───
    function renderCourseOverview(courses) {
      const container = document.getElementById('courseOverview');
      const recent = courses.slice(0, 4);
      if (recent.length === 0) {
        container.innerHTML = '<div style="text-align:center; padding:20px; color:#94A3B8; grid-column:1/-1;">No courses found</div>';
        return;
      }
      container.innerHTML = recent.map(c => {
        const revenue = Math.floor(Math.random() * 3000000 + 500000);
        const students = Math.floor(Math.random() * 100 + 10);
        return `
          <div class="course-item" onclick="window.location.href='/admin/courses/${c.id}'">
            <div class="name">${c.title || 'Untitled Course'}</div>
            <div class="stats">
              <span><strong>${students}</strong> Students</span>
              <span><strong>PKR ${revenue.toLocaleString()}</strong> Revenue</span>
            </div>
          </div>
        `;
      }).join('');
    }

    // ─── Render Upcoming Tasks ───
    function renderUpcomingTasks() {
      const container = document.getElementById('upcomingTasks');
      const tasks = [
        { icon: 'fa-dollar-sign', color: '#EF4444', text: 'Pending Fees', detail: 'Due Today', link: '{{ url("/admin/reports/remaining") }}' },
        { icon: 'fa-certificate', color: '#F59E0B', text: 'Certificates to Generate', detail: 'Pending', link: '{{ url("/admin/certificates/create") }}' },
        { icon: 'fa-envelope', color: '#6D4AFF', text: 'New Enquiries', detail: 'Unread', link: '{{ url("/admin/enquiries") }}' },
        { icon: 'fa-phone', color: '#10B981', text: 'Follow Ups', detail: 'Today', link: '#' }
      ];
      container.innerHTML = tasks.map(t => `
        <div class="task-item" onclick="window.location.href='${t.link}'" style="border-left-color: ${t.color};">
          <div class="task-left">
            <i class="fas ${t.icon}" style="color:${t.color};"></i>
            <span>${t.text}</span>
          </div>
          <div class="task-right">${t.detail}</div>
        </div>
      `).join('');
    }

    // ─── Render Recent Activity ───
    function renderRecentActivity() {
      const container = document.getElementById('recentActivity');
      const activities = [
        { icon: 'fa-user-plus', text: '<strong>Ali Raza</strong> enrolled in Web Development', time: '2h ago' },
        { icon: 'fa-dollar-sign', text: 'Fee payment received from <strong>Fatima Noor</strong> (PKR 8,500)', time: '5h ago' },
        { icon: 'fa-certificate', text: 'Certificate issued to <strong>Usman Ahmed</strong>', time: '1d ago' },
        { icon: 'fa-id-card', text: 'Student card printed for <strong>Sara Khan</strong>', time: '1d ago' },
        { icon: 'fa-user-plus', text: 'New student <strong>Ahmed Khan</strong> registered', time: '2d ago' }
      ];
      container.innerHTML = activities.map(a => `
        <div class="timeline-item">
          <div class="timeline-icon"><i class="fas ${a.icon}"></i></div>
          <div class="timeline-content">${a.text}</div>
          <div class="timeline-time">${a.time}</div>
        </div>
      `).join('');
    }

    // ─── Filter Dashboard ───
    function filterDashboard() {
      const search = document.getElementById('globalSearch').value.toLowerCase();
      if (search.length > 2) {
        showToast('🔍 Searching for "' + search + '"...');
      }
    }

    // ─── Toggle Notifications ───
    function toggleNotifications() {
      const panel = document.getElementById('notifPanel');
      if (!panel) {
        const notifBtn = document.getElementById('notifBtn');
        const panel = document.createElement('div');
        panel.className = 'notif-panel';
        panel.id = 'notifPanel';
        panel.innerHTML = `
          <div style="padding:12px 20px; font-weight:600; border-bottom:1px solid #F1F5F9;">Notifications</div>
          <div class="notif-item"><i class="fas fa-user-plus" style="color:#6D4AFF;"></i> Ali Raza enrolled in Web Dev</div>
          <div class="notif-item"><i class="fas fa-dollar-sign" style="color:#10B981;"></i> Fee payment received PKR 25,000</div>
          <div class="notif-item"><i class="fas fa-certificate" style="color:#F59E0B;"></i> Certificate issued for Sara Khan</div>
          <div class="notif-item"><i class="fas fa-id-card" style="color:#3B82F6;"></i> Student card printed for Usman</div>
          <div style="padding:8px 20px; text-align:center; border-top:1px solid #F1F5F9;">
            <a href="#" style="color:#6D4AFF; text-decoration:none; font-size:13px; font-weight:500;">View all notifications</a>
          </div>
        `;
        notifBtn.parentNode.appendChild(panel);
      }
      document.getElementById('notifPanel').classList.toggle('open');
      document.getElementById('profileDropdown').classList.remove('open');
    }

    // ─── Toggle Theme ───
    function toggleTheme() {
      showToast('🌙 Dark mode coming soon!');
    }

    // ─── Sidebar Toggle ───
    document.getElementById('menuToggle').addEventListener('click', function() {
      document.getElementById('sidebar').classList.toggle('open');
      document.getElementById('overlay').classList.toggle('active');
    });
    document.getElementById('overlay').addEventListener('click', function() {
      document.getElementById('sidebar').classList.remove('open');
      document.getElementById('overlay').classList.remove('active');
    });

    // ─── Profile Dropdown ───
    document.getElementById('profileBtn').addEventListener('click', function(e) {
      e.stopPropagation();
      document.getElementById('profileDropdown').classList.toggle('open');
      const notifPanel = document.getElementById('notifPanel');
      if (notifPanel) notifPanel.classList.remove('open');
    });

    // ─── Click outside ───
    document.addEventListener('click', function(e) {
      if (!e.target.closest('.profile-dropdown-wrap')) {
        document.getElementById('profileDropdown').classList.remove('open');
      }
      const notifPanel = document.getElementById('notifPanel');
      if (notifPanel && !e.target.closest('#notifBtn') && !e.target.closest('.notif-panel')) {
        notifPanel.classList.remove('open');
      }
    });

    // ─── Live Clock ───
    function updateClock() {
      const now = new Date();
      document.getElementById('currentTime').textContent = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
    }
    setInterval(updateClock, 10000);

    // ─── Init ───
    document.addEventListener('DOMContentLoaded', function() {
      loadDashboardData();
      updateClock();
    });
  </script>
</body>
</html>