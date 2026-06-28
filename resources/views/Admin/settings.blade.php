<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Leeds Institute · Settings</title>
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
      cursor: pointer;
    }
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
    }
    .main { flex: 1; background: #F0F2F5; min-height: 100vh; display: flex; flex-direction: column; }
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
    .profile-btn .name { font-weight: 500; font-size: 14px; color: #1E293B; }
    .profile-btn .chevron { font-size: 12px; color: #94A3B8; }
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
    .dropdown-menu.open { opacity: 1; visibility: visible; transform: translateY(0) scale(1); }
    .dropdown-menu .dropdown-header { padding: 10px 18px 6px; font-size: 11px; font-weight: 600; color: #94A3B8; text-transform: uppercase; }
    .dropdown-menu a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 9px 18px;
      color: #1E293B;
      text-decoration: none;
      font-size: 13px;
      font-weight: 500;
    }
    .dropdown-menu a:hover { background: #F8FAFC; }
    .dropdown-menu a i { width: 18px; color: #64748B; font-size: 14px; }
    .dropdown-divider { height: 1px; background: #F1F5F9; margin: 6px 12px; }
    .dashboard-content { padding: 28px 32px 40px; flex: 1; }
    .settings-card {
      background: #fff;
      border-radius: 16px;
      border: 1px solid #F1F5F9;
      box-shadow: 0 2px 12px rgba(0,0,0,0.04);
      overflow: hidden;
    }
    .settings-tabs {
      display: flex;
      gap: 4px;
      padding: 20px 24px 0;
      border-bottom: 1px solid #F1F5F9;
      overflow-x: auto;
      flex-wrap: nowrap;
    }
    .settings-tab {
      padding: 10px 20px;
      border-radius: 10px 10px 0 0;
      font-weight: 600;
      font-size: 14px;
      color: #64748B;
      cursor: pointer;
      transition: all 0.2s;
      white-space: nowrap;
      border: none;
      background: transparent;
      font-family: 'Inter', sans-serif;
      position: relative;
    }
    .settings-tab:hover { color: #1E293B; background: #F8FAFC; }
    .settings-tab.active {
      color: #6D4AFF;
      background: rgba(109,74,255,0.06);
    }
    .settings-tab.active::after {
      content: '';
      position: absolute;
      bottom: -1px;
      left: 20%;
      right: 20%;
      height: 2px;
      background: #6D4AFF;
      border-radius: 2px;
    }
    .settings-tab i { margin-right: 8px; }
    .tab-content {
      padding: 28px 32px 32px;
      display: none;
      animation: fadeSlide 0.4s ease;
    }
    .tab-content.active { display: block; }
    @keyframes fadeSlide {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .tab-content .section-title {
      font-size: 18px;
      font-weight: 600;
      color: #0F172A;
      margin-bottom: 4px;
    }
    .tab-content .section-desc {
      font-size: 14px;
      color: #94A3B8;
      margin-bottom: 24px;
    }
    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px 24px;
    }
    .form-grid .full-width { grid-column: span 2; }
    .form-group {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }
    .form-group label {
      font-size: 14px;
      font-weight: 500;
      color: #334155;
    }
    .form-group label .required { color: #EF4444; margin-left: 4px; }
    .form-group input,
    .form-group textarea,
    .form-group select {
      padding: 10px 14px;
      border-radius: 12px;
      border: 1.5px solid #E2E8F0;
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      color: #1E293B;
      background: #fff;
      transition: all 0.15s;
      outline: none;
      width: 100%;
    }
    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
      border-color: #6D4AFF;
      box-shadow: 0 0 0 3px rgba(109,74,255,0.08);
    }
    .form-group textarea { resize: vertical; min-height: 80px; }
    .form-group .help-text { font-size: 12px; color: #94A3B8; }
    .upload-area {
      border: 2px dashed #E2E8F0;
      border-radius: 12px;
      padding: 32px 20px;
      text-align: center;
      cursor: pointer;
      transition: all 0.2s;
      background: #F8FAFC;
      position: relative;
    }
    .upload-area:hover { border-color: #6D4AFF; background: rgba(109,74,255,0.04); }
    .upload-area .icon { font-size: 2.4rem; color: #94A3B8; margin-bottom: 8px; }
    .upload-area p { font-size: 14px; color: #64748B; }
    .upload-area small { font-size: 12px; color: #94A3B8; }
    .upload-area input[type="file"] {
      position: absolute;
      inset: 0;
      opacity: 0;
      cursor: pointer;
    }
    .upload-preview {
      margin-top: 12px;
      display: flex;
      align-items: center;
      gap: 16px;
      padding: 12px;
      background: #F8FAFC;
      border-radius: 10px;
      border: 1px solid #E2E8F0;
    }
    .upload-preview img {
      width: 60px;
      height: 60px;
      border-radius: 8px;
      object-fit: cover;
    }
    .upload-preview .file-info { flex: 1; }
    .upload-preview .file-info .name { font-weight: 600; font-size: 14px; }
    .upload-preview .file-info .size { font-size: 12px; color: #94A3B8; }
    .upload-preview .remove-btn {
      color: #EF4444;
      cursor: pointer;
      font-size: 1.2rem;
      background: none;
      border: none;
      padding: 4px 8px;
    }
    .upload-preview .remove-btn:hover { transform: scale(1.2); }
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 10px 24px;
      border-radius: 40px;
      font-weight: 600;
      font-size: 14px;
      cursor: pointer;
      border: none;
      transition: all 0.15s;
      font-family: 'Inter', sans-serif;
    }
    .btn-purple {
      background: #6D4AFF;
      color: #fff;
      box-shadow: 0 6px 14px -6px rgba(109,74,255,0.3);
    }
    .btn-purple:hover {
      background: #5a3de0;
      transform: translateY(-2px);
      box-shadow: 0 10px 20px -8px rgba(109,74,255,0.35);
    }
    .btn-outline {
      background: transparent;
      color: #475569;
      border: 1.5px solid #E2E8F0;
    }
    .btn-outline:hover { background: #F1F5F9; border-color: #CBD5E1; }
    .form-actions {
      display: flex;
      gap: 12px;
      margin-top: 24px;
      padding-top: 20px;
      border-top: 1px solid #F1F5F9;
    }
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
    @media (max-width: 1024px) {
      .form-grid { grid-template-columns: 1fr; }
      .form-grid .full-width { grid-column: span 1; }
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
      .settings-tabs { padding: 12px 16px 0; gap: 2px; }
      .settings-tab { padding: 8px 14px; font-size: 13px; }
      .tab-content { padding: 20px 16px; }
      .form-actions { flex-direction: column; }
      .form-actions .btn { width: 100%; justify-content: center; }
    }
    @media (max-width: 480px) {
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
      <li><a href="dashboard.html"><i class="fas fa-th-large"></i> Dashboard</a></li>
      <li><a href="#"><i class="fas fa-user-graduate"></i> Students</a></li>
      <li><a href="#"><i class="fas fa-chalkboard-teacher"></i> Teachers</a></li>
      <li><a href="#"><i class="fas fa-book-open"></i> Courses</a></li>
      <li class="menu-label">Management</li>
      <li><a href="#"><i class="fas fa-user-plus"></i> Enrollments</a></li>
      <li><a href="#"><i class="fas fa-dollar-sign"></i> Fee Payments</a></li>
      <li><a href="#"><i class="fas fa-id-card"></i> Student Cards</a></li>
      <li><a href="#"><i class="fas fa-certificate"></i> Certificates</a></li>
      <li><a href="#"><i class="fas fa-clipboard-list"></i> Talent Test</a></li>
      <li class="menu-label">Reports</li>
      <li><a href="#"><i class="fas fa-chart-bar"></i> Reports</a></li>
      <li><a href="#"><i class="fas fa-envelope"></i> Enquiries</a></li>
      <li class="menu-label">System</li>
      <li class="active"><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
    </ul>
    <div class="sidebar-footer">
      <div class="user-card" onclick="window.location.href='#'">
        <div class="avatar">S</div>
        <div class="info">
          <div class="name">Super Admin</div>
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
          <h2>Settings</h2>
          <div class="subtitle">Manage your institute settings</div>
        </div>
      </div>
      <div class="topbar-right">
        <div class="search-box">
          <i class="fas fa-search"></i>
          <input type="text" placeholder="Search settings..." />
        </div>
        <button class="notif-btn" id="notifBtn">
          <i class="fas fa-bell"></i>
          <span class="notif-badge">3</span>
        </button>
        <div class="profile-dropdown-wrap">
          <button class="profile-btn" id="profileBtn">
            <div class="avatar">S</div>
            <span class="name">Super Admin</span>
            <i class="fas fa-chevron-down chevron"></i>
          </button>
          <div class="dropdown-menu" id="profileDropdown">
            <div class="dropdown-header">Account</div>
            <a href="#"><i class="fas fa-user"></i> View Profile</a>
            <a href="#"><i class="fas fa-sliders-h"></i> Account Settings</a>
            <a href="#"><i class="fas fa-key"></i> Change Password</a>
            <div class="dropdown-divider"></div>
            <a href="#" onclick="toggleTheme()"><i class="fas fa-moon"></i> Dark Mode</a>
            <div class="dropdown-divider"></div>
            <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </div>
        </div>
      </div>
    </header>

    <!-- DASHBOARD CONTENT -->
   <div class="dashboard-content">
    <div class="settings-card">
      <!-- Tabs -->
      <div class="settings-tabs" id="settingsTabs">
        <button class="settings-tab active" data-tab="institute"><i class="fas fa-university"></i> Institute</button>
        <button class="settings-tab" data-tab="ceo"><i class="fas fa-user-tie"></i> CEO</button>
        <button class="settings-tab" data-tab="about"><i class="fas fa-info-circle"></i> About</button>
        <button class="settings-tab" data-tab="contact"><i class="fas fa-phone"></i> Contact</button>
        <button class="settings-tab" data-tab="social"><i class="fas fa-share-alt"></i> Social</button>
      </div>

      <!-- TAB 1: INSTITUTE -->
      <div class="tab-content active" id="tab-institute">
        <form class="settings-form" id="formInstitute" enctype="multipart/form-data">
          @csrf
          <div class="form-grid">
            <div class="form-group full-width">
              <label>Institute Logo</label>
              <div class="upload-area" onclick="document.getElementById('logoUpload').click()">
                <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                <p>Click to upload logo</p>
                <small>PNG, JPG up to 2MB</small>
                <input type="file" id="logoUpload" name="institute_logo" accept="image/*" onchange="previewImage(this, 'logoPreview')" />
              </div>
              <div class="upload-preview" id="logoPreviewContainer" @if(isset($settings['institute']['logo']) && $settings['institute']['logo']) style="display:flex;" @else style="display:none;" @endif>
                @if(isset($settings['institute']['logo']) && $settings['institute']['logo'])
                  <img id="logoPreview" src="{{ asset('storage/' . $settings['institute']['logo']) }}" alt="Logo" />
                  <div class="file-info">
                    <div class="name" id="logoName">{{ basename($settings['institute']['logo']) }}</div>
                    <div class="size" id="logoSize">Current Logo</div>
                  </div>
                @else
                  <img id="logoPreview" src="#" alt="Logo preview" />
                  <div class="file-info">
                    <div class="name" id="logoName">logo.png</div>
                    <div class="size" id="logoSize">0 KB</div>
                  </div>
                @endif
                <button type="button" class="remove-btn" onclick="removePreview('logoPreviewContainer')"><i class="fas fa-times"></i></button>
              </div>
            </div>

            <div class="form-group">
              <label>Institute Name <span class="required">*</span></label>
              <input type="text" name="institute_name" value="{{ $settings['institute']['name'] ?? 'Leeds Institute' }}" required />
            </div>
            <div class="form-group">
              <label>Tagline</label>
              <input type="text" name="tagline" value="{{ $settings['institute']['tagline'] ?? 'Quality Education Since 2005' }}" />
            </div>

            <div class="form-group full-width">
              <label>About Description</label>
              <textarea name="about_description" rows="3">{{ $settings['institute']['about_description'] ?? 'Leeds Institute is dedicated to delivering quality education that prepares students for academic excellence and lifelong success.' }}</textarea>
            </div>

            <div class="form-group">
              <label>Years of Experience</label>
              <input type="number" name="years_experience" value="{{ $settings['institute']['years_experience'] ?? 20 }}" />
            </div>
            <div class="form-group">
              <label>Achievement Counter</label>
              <input type="text" name="achievement_counter" value="{{ $settings['about']['achievement_counter'] ?? '' }}" placeholder="e.g. 5000+ Students" />
            </div>

            <div class="form-group full-width">
              <label>Address</label>
              <textarea name="address" rows="2">{{ $settings['institute']['address'] ?? 'Main Road, City, Pakistan' }}</textarea>
            </div>

            <div class="form-group full-width">
              <label>Google Map Embed URL</label>
              <input type="url" name="google_map_embed_url" value="{{ $settings['institute']['map_url'] ?? '' }}" placeholder="https://www.google.com/maps/embed?..." />
            </div>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-purple"><i class="fas fa-save"></i> Save Changes</button>
            <button type="reset" class="btn btn-outline"><i class="fas fa-undo"></i> Reset</button>
          </div>
        </form>
      </div>

      <!-- TAB 2: CEO -->
      <div class="tab-content" id="tab-ceo">
        <form class="settings-form" id="formCEO" enctype="multipart/form-data">
          @csrf
          <div class="form-grid">
            <div class="form-group full-width">
              <label>CEO Profile Photo</label>
              <div class="upload-area" onclick="document.getElementById('ceoPhotoUpload').click()">
                <div class="icon"><i class="fas fa-camera"></i></div>
                <p>Upload CEO photo</p>
                <small>PNG, JPG up to 2MB</small>
                <input type="file" id="ceoPhotoUpload" name="ceo_photo" accept="image/*" onchange="previewImage(this, 'ceoPreview')" />
              </div>
              <div class="upload-preview" id="ceoPreviewContainer" @if(isset($settings['ceo']['photo']) && $settings['ceo']['photo']) style="display:flex;" @else style="display:none;" @endif>
                @if(isset($settings['ceo']['photo']) && $settings['ceo']['photo'])
                  <img id="ceoPreview" src="{{ asset('storage/' . $settings['ceo']['photo']) }}" alt="CEO photo" />
                  <div class="file-info">
                    <div class="name" id="ceoName">{{ basename($settings['ceo']['photo']) }}</div>
                    <div class="size" id="ceoSize">Current Photo</div>
                  </div>
                @else
                  <img id="ceoPreview" src="#" alt="CEO photo" />
                  <div class="file-info">
                    <div class="name" id="ceoName">photo.jpg</div>
                    <div class="size" id="ceoSize">0 KB</div>
                  </div>
                @endif
                <button type="button" class="remove-btn" onclick="removePreview('ceoPreviewContainer')"><i class="fas fa-times"></i></button>
              </div>
            </div>

            <div class="form-group">
              <label>CEO Name <span class="required">*</span></label>
              <input type="text" name="ceo_name" value="{{ $settings['ceo']['name'] ?? 'Dr. Imran Khalil' }}" required />
            </div>
            <div class="form-group">
              <label>Designation</label>
              <input type="text" name="ceo_designation" value="{{ $settings['ceo']['designation'] ?? 'Principal & CEO' }}" />
            </div>

            <div class="form-group full-width">
              <label>CEO Vision</label>
              <textarea name="ceo_vision" rows="3">{{ $settings['ceo']['vision'] ?? 'To create a world-class educational institution that nurtures future leaders through innovation, integrity, and academic excellence.' }}</textarea>
            </div>

            <div class="form-group full-width">
              <label>CEO Message</label>
              <textarea name="ceo_message" rows="4">{{ $settings['ceo']['message'] ?? 'At Leeds Institute, we believe education is not merely the transfer of knowledge — it is the transformation of lives.' }}</textarea>
            </div>

            <div class="form-group full-width">
              <label>CEO Signature</label>
              <div class="upload-area" onclick="document.getElementById('sigUpload').click()">
                <div class="icon"><i class="fas fa-pen-fancy"></i></div>
                <p>Upload signature</p>
                <small>PNG with transparent background</small>
                <input type="file" id="sigUpload" name="ceo_signature" accept="image/*" onchange="previewImage(this, 'sigPreview')" />
              </div>
              <div class="upload-preview" id="sigPreviewContainer" @if(isset($settings['ceo']['signature']) && $settings['ceo']['signature']) style="display:flex;" @else style="display:none;" @endif>
                @if(isset($settings['ceo']['signature']) && $settings['ceo']['signature'])
                  <img id="sigPreview" src="{{ asset('storage/' . $settings['ceo']['signature']) }}" alt="Signature" />
                  <div class="file-info">
                    <div class="name" id="sigName">{{ basename($settings['ceo']['signature']) }}</div>
                    <div class="size" id="sigSize">Current Signature</div>
                  </div>
                @else
                  <img id="sigPreview" src="#" alt="Signature" />
                  <div class="file-info">
                    <div class="name" id="sigName">signature.png</div>
                    <div class="size" id="sigSize">0 KB</div>
                  </div>
                @endif
                <button type="button" class="remove-btn" onclick="removePreview('sigPreviewContainer')"><i class="fas fa-times"></i></button>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-purple"><i class="fas fa-save"></i> Save Changes</button>
            <button type="reset" class="btn btn-outline"><i class="fas fa-undo"></i> Reset</button>
          </div>
        </form>
      </div>

      <!-- TAB 3: ABOUT -->
      <div class="tab-content" id="tab-about">
        <form class="settings-form" id="formAbout" enctype="multipart/form-data">
          @csrf
          <div class="form-grid">
            <div class="form-group full-width">
              <label>About Us</label>
              <textarea name="about_us" rows="4">{{ $settings['about']['about_us'] ?? 'Leeds Institute has been a cornerstone of quality education in the region for over two decades.' }}</textarea>
            </div>

            <div class="form-group full-width">
              <label>Our Mission</label>
              <textarea name="our_mission" rows="3">{{ $settings['about']['mission'] ?? 'To cultivate intellectual growth, moral character, and practical skills.' }}</textarea>
            </div>

            <div class="form-group full-width">
              <label>Our Vision</label>
              <textarea name="our_vision" rows="3">{{ $settings['about']['vision'] ?? 'To be the most trusted educational institution in the region.' }}</textarea>
            </div>

            <div class="form-group full-width">
              <label>Why Choose Us</label>
              <textarea name="why_choose_us" rows="4">{{ $settings['about']['why_choose'] ?? '• Experienced and qualified faculty\n• Modern classrooms' }}</textarea>
            </div>

            <div class="form-group full-width">
              <label>Institute Image</label>
              <div class="upload-area" onclick="document.getElementById('instImageUpload').click()">
                <div class="icon"><i class="fas fa-image"></i></div>
                <p>Upload institute image</p>
                <small>PNG, JPG up to 5MB</small>
                <input type="file" id="instImageUpload" name="institute_image" accept="image/*" onchange="previewImage(this, 'instPreview')" />
              </div>
              <div class="upload-preview" id="instPreviewContainer" @if(isset($settings['about']['image']) && $settings['about']['image']) style="display:flex;" @else style="display:none;" @endif>
                @if(isset($settings['about']['image']) && $settings['about']['image'])
                  <img id="instPreview" src="{{ asset('storage/' . $settings['about']['image']) }}" alt="Institute" />
                  <div class="file-info">
                    <div class="name" id="instName">{{ basename($settings['about']['image']) }}</div>
                    <div class="size" id="instSize">Current Image</div>
                  </div>
                @else
                  <img id="instPreview" src="#" alt="Institute" />
                  <div class="file-info">
                    <div class="name" id="instName">institute.jpg</div>
                    <div class="size" id="instSize">0 KB</div>
                  </div>
                @endif
                <button type="button" class="remove-btn" onclick="removePreview('instPreviewContainer')"><i class="fas fa-times"></i></button>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-purple"><i class="fas fa-save"></i> Save Changes</button>
            <button type="reset" class="btn btn-outline"><i class="fas fa-undo"></i> Reset</button>
          </div>
        </form>
      </div>

      <!-- TAB 4: CONTACT -->
      <div class="tab-content" id="tab-contact">
        <form class="settings-form" id="formContact">
          @csrf
          <div class="form-grid">
            <div class="form-group">
              <label>Email <span class="required">*</span></label>
              <input type="email" name="contact_email" value="{{ $settings['contact']['email'] ?? 'info@leedsinstitute.edu.pk' }}" required />
            </div>
            <div class="form-group">
              <label>Phone <span class="required">*</span></label>
              <input type="tel" name="contact_phone" value="{{ $settings['contact']['phone'] ?? '+92-XXX-XXXXXXX' }}" required />
            </div>

            <div class="form-group">
              <label>WhatsApp</label>
              <input type="tel" name="contact_whatsapp" value="{{ $settings['contact']['whatsapp'] ?? '+92-XXX-XXXXXXX' }}" />
            </div>
            <div class="form-group">
              <label>Alternate Phone</label>
              <input type="tel" name="alternate_phone" value="{{ $settings['contact']['alternate_phone'] ?? '+92-XXX-XXXXXXX' }}" />
            </div>

            <div class="form-group full-width">
              <label>Address</label>
              <textarea name="contact_address" rows="2">{{ $settings['contact']['address'] ?? 'Main Road, City, Pakistan' }}</textarea>
            </div>

            <div class="form-group full-width">
              <label>Google Maps URL</label>
              <input type="url" name="google_maps_url" value="{{ $settings['contact']['map_url'] ?? '' }}" placeholder="https://www.google.com/maps/embed?..." />
            </div>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-purple"><i class="fas fa-save"></i> Save Changes</button>
            <button type="reset" class="btn btn-outline"><i class="fas fa-undo"></i> Reset</button>
          </div>
        </form>
      </div>

      <!-- TAB 5: SOCIAL MEDIA -->
      <div class="tab-content" id="tab-social">
        <form class="settings-form" id="formSocial">
          @csrf
          <div class="form-grid">
            <div class="form-group full-width">
              <label><i class="fab fa-facebook" style="color:#1877F2;"></i> Facebook</label>
              <input type="url" name="facebook_url" value="{{ $settings['social']['facebook'] ?? '' }}" placeholder="https://facebook.com/leedsinstitute" />
            </div>

            <div class="form-group full-width">
              <label><i class="fab fa-tiktok"></i> TikTok</label>
              <input type="url" name="tiktok_url" value="{{ $settings['social']['tiktok'] ?? '' }}" placeholder="https://tiktok.com/@leedsinstitute" />
            </div>

            <div class="form-group full-width">
              <label><i class="fab fa-youtube" style="color:#FF0000;"></i> YouTube</label>
              <input type="url" name="youtube_url" value="{{ $settings['social']['youtube'] ?? '' }}" placeholder="https://youtube.com/@leedsinstitute" />
            </div>

            <div class="form-group full-width">
              <label><i class="fab fa-instagram" style="color:#E4405F;"></i> Instagram</label>
              <input type="url" name="instagram_url" value="{{ $settings['social']['instagram'] ?? '' }}" placeholder="https://instagram.com/leedsinstitute" />
            </div>

            <div class="form-group full-width">
              <label><i class="fab fa-linkedin" style="color:#0A66C2;"></i> LinkedIn</label>
              <input type="url" name="linkedin_url" value="{{ $settings['social']['linkedin'] ?? '' }}" placeholder="https://linkedin.com/company/leedsinstitute" />
            </div>

            <div class="form-group full-width">
              <label><i class="fab fa-twitter" style="color:#1DA1F2;"></i> Twitter/X</label>
              <input type="url" name="twitter_url" value="{{ $settings['social']['twitter'] ?? '' }}" placeholder="https://twitter.com/leedsinstitute" />
            </div>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-purple"><i class="fas fa-save"></i> Save Changes</button>
            <button type="reset" class="btn btn-outline"><i class="fas fa-undo"></i> Reset</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Toast -->
  <div class="toast" id="toast"><i class="fas fa-check-circle"></i> <span id="toastMsg">Action completed</span></div>

  <script>
    // Tab switching
    const tabs = document.querySelectorAll('.settings-tab');
    const contents = {
      institute: document.getElementById('tab-institute'),
      ceo: document.getElementById('tab-ceo'),
      about: document.getElementById('tab-about'),
      contact: document.getElementById('tab-contact'),
      social: document.getElementById('tab-social')
    };

    tabs.forEach(tab => {
      tab.addEventListener('click', function() {
        tabs.forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        Object.values(contents).forEach(c => c.classList.remove('active'));
        if (contents[this.dataset.tab]) contents[this.dataset.tab].classList.add('active');
      });
    });

    // Image preview
    function previewImage(input, previewId) {
      const container = document.getElementById(previewId + 'Container');
      const preview = document.getElementById(previewId);
      const nameEl = document.getElementById(previewId.replace('Preview', 'Name'));
      const sizeEl = document.getElementById(previewId.replace('Preview', 'Size'));

      if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
          preview.src = e.target.result;
          container.style.display = 'flex';
          if (nameEl) nameEl.textContent = file.name;
          if (sizeEl) sizeEl.textContent = (file.size / 1024).toFixed(1) + ' KB';
        };
        reader.readAsDataURL(file);
      }
    }

    function removePreview(containerId) {
      const container = document.getElementById(containerId);
      container.style.display = 'none';
      const input = container.parentElement.querySelector('input[type="file"]');
      if (input) input.value = '';
      const preview = container.querySelector('img');
      if (preview) preview.src = '#';
    }

    // AJAX Form Submission
    document.querySelectorAll('.settings-form').forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();

        const btn = this.querySelector('.btn-purple');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        btn.disabled = true;

        const formData = new FormData(this);
        let url = '';
        
        if (this.id === 'formInstitute') url = '{{ route("admin.settings.institute") }}';
        else if (this.id === 'formCEO') url = '{{ route("admin.settings.ceo") }}';
        else if (this.id === 'formAbout') url = '{{ route("admin.settings.about") }}';
        else if (this.id === 'formContact') url = '{{ route("admin.settings.contact") }}';
        else if (this.id === 'formSocial') url = '{{ route("admin.settings.social") }}';

        fetch(url, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
          },
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          btn.innerHTML = originalText;
          btn.disabled = false;
          
          if (data.success) {
            showToast('✅ ' + data.message);
            // Update preview if image was uploaded
            if (data.data) {
              if (data.data.logo) updatePreviewImage('logoPreview', data.data.logo);
              if (data.data.photo) updatePreviewImage('ceoPreview', data.data.photo);
              if (data.data.signature) updatePreviewImage('sigPreview', data.data.signature);
              if (data.data.image) updatePreviewImage('instPreview', data.data.image);
            }
          } else {
            showToast('❌ ' + (data.message || 'Something went wrong'));
          }
        })
        .catch(error => {
          btn.innerHTML = originalText;
          btn.disabled = false;
          showToast('❌ Network error. Please try again.');
          console.error('Error:', error);
        });
      });
    });

    function updatePreviewImage(previewId, path) {
      const preview = document.getElementById(previewId);
      if (preview) {
        preview.src = '/storage/' + path;
        const container = document.getElementById(previewId + 'Container');
        if (container) container.style.display = 'flex';
      }
    }

    // Toast notification
    function showToast(msg) {
      const toast = document.getElementById('toast');
      document.getElementById('toastMsg').textContent = msg;
      toast.classList.add('show');
      clearTimeout(toast._timer);
      toast._timer = setTimeout(() => toast.classList.remove('show'), 3500);
    }

    // Sidebar toggle
    document.getElementById('menuToggle').addEventListener('click', function() {
      document.getElementById('sidebar').classList.toggle('open');
      document.getElementById('overlay').classList.toggle('active');
    });
    document.getElementById('overlay').addEventListener('click', function() {
      document.getElementById('sidebar').classList.remove('open');
      document.getElementById('overlay').classList.remove('active');
    });

    // Profile dropdown
    document.getElementById('profileBtn').addEventListener('click', function(e) {
      e.stopPropagation();
      document.getElementById('profileDropdown').classList.toggle('open');
    });
    document.addEventListener('click', function(e) {
      if (!e.target.closest('.profile-dropdown-wrap')) {
        document.getElementById('profileDropdown').classList.remove('open');
      }
    });

    // Reset buttons
    document.querySelectorAll('.settings-form .btn-outline[type="reset"]').forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('.settings-form');
        form.querySelectorAll('input, textarea').forEach(input => {
          if (input.type === 'file') {
            input.value = '';
            const container = input.closest('.form-group').querySelector('.upload-preview');
            if (container) container.style.display = 'none';
          } else {
            input.value = input.defaultValue || '';
          }
        });
        showToast('🔄 Form has been reset.');
      });
    });

    function toggleTheme() {
      showToast('🌙 Dark mode coming soon!');
    }
  </script>

  <!-- Laravel Backend Routes (placed in web.php) -->
  <!--
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/institute', [SettingsController::class, 'updateInstitute'])->name('settings.institute');
    Route::post('/settings/ceo', [SettingsController::class, 'updateCEO'])->name('settings.ceo');
    Route::post('/settings/about', [SettingsController::class, 'updateAbout'])->name('settings.about');
    Route::post('/settings/contact', [SettingsController::class, 'updateContact'])->name('settings.contact');
    Route::post('/settings/social', [SettingsController::class, 'updateSocial'])->name('settings.social');
  -->
</body>
</html>