{{-- resources/views/admin/course.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leeds Academy · Course Management</title>
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

        .instructor-tag {
            display: inline-block;
            background: #EDE7FF;
            color: #6D4AFF;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            margin: 2px 4px 2px 0;
        }
        .instructor-tag i { margin-right: 4px; font-size: 10px; }

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
                    <h2>Courses Management</h2>
                    <div class="breadcrumb">Dashboard / <span>Courses</span></div>
                </div>
            </div>
            <div class="topbar-right">
                <div class="search-box"><i class="fas fa-search"></i><input type="text" placeholder="Search courses..." id="globalSearch" oninput="filterTable()"></div>
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
                <h3>Course List</h3>
                <button class="btn-primary" id="addCourseBtn"><i class="fas fa-plus"></i> Add New Course</button>
            </div>

            <div class="filters-bar">
                <input type="text" placeholder="Search course..." style="flex:1; min-width:140px;" id="filterSearch" oninput="filterTable()">
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
                            <th>#</th>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Duration</th>
                            <th>Fee (PKR)</th>
                            <th>Instructors</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="courseTableBody">
                        <tr><td colspan="8" style="text-align:center; padding:40px; color:#94A3B8;">Loading courses...</td></tr>
                    </tbody>
                </table>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:16px; flex-wrap:wrap; gap:10px;">
                    <span style="font-size:14px; color:#64748B;" id="recordCount">Loading...</span>
                    <div style="display:flex; gap:6px;" id="paginationControls"></div>
                </div>
            </div>

        </div><!-- /content -->
    </div><!-- /main -->

    <!-- ─── COURSE MODAL (Add/Edit) ─── -->
    <div class="modal-overlay" id="courseModal">
        <div class="modal">
            <div class="modal-header">
                <h2 id="modalTitle"><i class="fas fa-book-open" style="color:#6D4AFF; margin-right:10px;"></i> Add New Course</h2>
                <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
            </div>
            <form id="courseForm" onsubmit="saveCourse(event)" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="courseId" value="">
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Course Name <span class="required">*</span></label>
                        <input type="text" id="cName" placeholder="Enter course name" required>
                    </div>
                    <div class="form-group">
                        <label>Original Fee (PKR) <span class="required">*</span></label>
                        <input type="number" id="cFee" placeholder="30000" required>
                    </div>
                    <div class="form-group">
                        <label>Duration <span class="required">*</span></label>
                        <select id="cDuration" required>
                            <option value="">Select Duration</option>
                            <option value="1 Month">1 Month</option>
                            <option value="1.5 Months">1.5 Months</option>
                            <option value="2 Months">2 Months</option>
                            <option value="3 Months">3 Months</option>
                            <option value="4 Months">4 Months</option>
                            <option value="6 Months">6 Months</option>
                            <option value="1 Year">1 Year</option>
                        </select>
                    </div>
                    <div class="form-group full-width">
                        <label>Description</label>
                        <textarea id="cDescription" rows="3" placeholder="Course description..."></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label>Instructors (Multiple)</label>
                        <select id="cInstructors" multiple style="height:100px;">
                            @foreach($instructors ?? [] as $instructor)
                                <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                            @endforeach
                        </select>
                        <span style="font-size:12px; color:#94A3B8;">Hold Ctrl/Cmd to select multiple instructors</span>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select id="cStatus">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-primary" id="saveBtn"><i class="fas fa-save"></i> Save Course</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ─── DELETE MODAL ─── -->
    <div class="modal-overlay delete-modal" id="deleteModal">
        <div class="modal">
            <div class="icon"><i class="fas fa-exclamation-circle"></i></div>
            <h3>Delete Course</h3>
            <p>Are you sure you want to delete this course? This action cannot be undone.</p>
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
        let courses = [];
        let currentPage = 1;
        const perPage = 10;
        let deleteId = null;

        // ─── CSRF Token ───
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // ─── Load Courses from Database ───
        async function loadCourses() {
            try {
                const response = await fetch('{{ route("admin.courses.index") }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                courses = data.data || [];
                renderTable();
            } catch (error) {
                console.error('Error loading courses:', error);
                showToast('⚠️ Error loading courses');
                document.getElementById('courseTableBody').innerHTML = `
                    <tr><td colspan="8" style="text-align:center; padding:40px; color:#94A3B8;">
                        <i class="fas fa-exclamation-circle" style="font-size:24px; display:block; margin-bottom:8px;"></i>
                        Failed to load courses. Please refresh the page.
                    </td></tr>
                `;
            }
        }

        // ─── Render Table ───
        function renderTable() {
            const filtered = getFilteredCourses();
            const total = filtered.length;
            const totalPages = Math.ceil(total / perPage);
            if (currentPage > totalPages) currentPage = totalPages || 1;
            const start = (currentPage - 1) * perPage;
            const pageData = filtered.slice(start, start + perPage);

            const tbody = document.getElementById('courseTableBody');
            if (pageData.length === 0) {
                tbody.innerHTML = `<tr><td colspan="8" style="text-align:center; padding:40px; color:#94A3B8;">No courses found</td></tr>`;
            } else {
                tbody.innerHTML = pageData.map((c, index) => {
                    const statusClass = c.status || 'active';
                    // Get instructor names
                    let instructorNames = 'No instructors';
                    if (c.instructor_ids) {
                        try {
                            const ids = JSON.parse(c.instructor_ids);
                            if (Array.isArray(ids) && ids.length > 0) {
                                // We'll fetch instructor names from the data or display IDs
                                instructorNames = ids.map(id => {
                                    // Try to find instructor name from the course data if available
                                    if (c.instructors && c.instructors.length > 0) {
                                        const inst = c.instructors.find(i => i.id === id);
                                        if (inst) return inst.name;
                                    }
                                    return 'ID: ' + id;
                                }).join(', ');
                            }
                        } catch(e) {
                            instructorNames = 'No instructors';
                        }
                    }
                    
                    return `
                        <tr>
                            <td>${start + index + 1}</td>
                            <td><strong>${c.course_code || 'N/A'}</strong></td>
                            <td><strong>${c.name}</strong></td>
                            <td>${c.duration || '-'}</td>
                            <td>PKR ${parseFloat(c.original_fee).toLocaleString()}</td>
                            <td>${instructorNames}</td>
                            <td><span class="status-badge ${statusClass}">${statusClass.charAt(0).toUpperCase() + statusClass.slice(1)}</span></td>
                            <td>
                                <div class="action-dropdown">
                                    <button class="dropdown-trigger" onclick="toggleDD(this)"><i class="fas fa-ellipsis-v"></i></button>
                                    <div class="dd-menu">
                                        <a href="#" onclick="viewCourse(${c.id}); return false;"><i class="fas fa-eye"></i> View Details</a>
                                        <a href="#" onclick="editCourse(${c.id}); return false;"><i class="fas fa-edit"></i> Edit Course</a>
                                        <a href="#" onclick="deleteCourse(${c.id}); return false;"><i class="fas fa-trash"></i> Delete</a>
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
        function getFilteredCourses() {
            const search = document.getElementById('filterSearch').value.toLowerCase().trim();
            const status = document.getElementById('filterStatus').value;
            return courses.filter(c => {
                const matchSearch = search === '' || 
                    (c.name && c.name.toLowerCase().includes(search)) || 
                    (c.course_code && c.course_code.toLowerCase().includes(search));
                const matchStatus = status === '' || (c.status && c.status === status);
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
            document.getElementById('courseModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('courseModal').classList.remove('active');
            document.getElementById('courseForm').reset();
            document.getElementById('courseId').value = '';
        }

        // ─── Add Course ───
        document.getElementById('addCourseBtn').addEventListener('click', function() {
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-book-open" style="color:#6D4AFF; margin-right:10px;"></i> Add New Course';
            document.getElementById('saveBtn').innerHTML = '<i class="fas fa-save"></i> Save Course';
            document.getElementById('courseForm').reset();
            document.getElementById('courseId').value = '';
            document.getElementById('cStatus').value = 'active';
            // Deselect all instructors
            const select = document.getElementById('cInstructors');
            for (let i = 0; i < select.options.length; i++) {
                select.options[i].selected = false;
            }
            openModal();
        });

        // ─── Edit Course ───
        async function editCourse(id) {
            try {
                const response = await fetch(`/admin/courses/${id}/edit`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                const course = data.data;

                document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit" style="color:#6D4AFF; margin-right:10px;"></i> Edit Course';
                document.getElementById('saveBtn').innerHTML = '<i class="fas fa-save"></i> Update Course';
                document.getElementById('courseId').value = course.id;
                document.getElementById('cName').value = course.name || '';
                document.getElementById('cFee').value = course.original_fee || '';
                document.getElementById('cDuration').value = course.duration || '';
                document.getElementById('cDescription').value = course.description || '';
                document.getElementById('cStatus').value = course.status || 'active';
                
                // Select instructors
                const select = document.getElementById('cInstructors');
                for (let i = 0; i < select.options.length; i++) {
                    select.options[i].selected = false;
                }
                if (course.instructor_ids) {
                    const ids = typeof course.instructor_ids === 'string' ? JSON.parse(course.instructor_ids) : course.instructor_ids;
                    if (Array.isArray(ids)) {
                        for (let i = 0; i < select.options.length; i++) {
                            if (ids.includes(parseInt(select.options[i].value))) {
                                select.options[i].selected = true;
                            }
                        }
                    }
                }
                
                openModal();
            } catch (error) {
                showToast('⚠️ Error loading course data');
            }
        }

        // ─── View Course ───
        async function viewCourse(id) {
            try {
                const response = await fetch(`/admin/courses/${id}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                const c = data.data;
                alert(`📚 Course Details\n\nCode: ${c.course_code}\nName: ${c.name}\nDuration: ${c.duration}\nFee: PKR ${parseFloat(c.original_fee).toLocaleString()}\nDescription: ${c.description || 'N/A'}\nStatus: ${c.status}`);
            } catch (error) {
                showToast('⚠️ Error loading course details');
            }
        }

        // ─── Save Course ───
        async function saveCourse(e) {
            e.preventDefault();
            const id = document.getElementById('courseId').value;
            
            // Get selected instructors
            const select = document.getElementById('cInstructors');
            const selectedInstructors = Array.from(select.selectedOptions).map(opt => parseInt(opt.value));

            const formData = {
                name: document.getElementById('cName').value,
                original_fee: document.getElementById('cFee').value,
                duration: document.getElementById('cDuration').value,
                description: document.getElementById('cDescription').value,
                status: document.getElementById('cStatus').value,
                instructors: selectedInstructors
            };

            const url = id ? `/admin/courses/${id}` : '{{ route("admin.courses.store") }}';
            const method = id ? 'PUT' : 'POST';

            try {
                const response = await fetch(url, {
                    method: method,
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
                    closeModal();
                    loadCourses();
                } else {
                    const errors = result.errors || {};
                    let errorMsg = 'Validation errors:\n';
                    for (const key in errors) {
                        errorMsg += `- ${errors[key].join(', ')}\n`;
                    }
                    showToast(errorMsg);
                }
            } catch (error) {
                showToast('⚠️ Error saving course');
            }
        }

        // ─── Delete Course ───
        function deleteCourse(id) {
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
                    const response = await fetch(`/admin/courses/${deleteId}`, {
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
                        loadCourses();
                    } else {
                        showToast('⚠️ ' + (result.message || 'Cannot delete course'));
                        closeDeleteModal();
                    }
                } catch (error) {
                    showToast('⚠️ Error deleting course');
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

        // ─── Close modals on overlay click ───
        document.querySelectorAll('.modal-overlay').forEach(el => {
            el.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        });

        // ─── Init ───
        loadCourses();
    </script>
</body>
</html>