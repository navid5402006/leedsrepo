{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leeds Academy · @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="overlay" id="overlay"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
            <span>Leeds<small>Academy</small></span>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-th-large"></i> Dashboard</a>
            </li>
            <li><a href="#"><i class="fas fa-user-graduate"></i> Students</a></li>
            <li><a href="#"><i class="fas fa-chalkboard-teacher"></i> Teachers</a></li>
            <li class="{{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                <a href="{{ route('admin.courses.index') }}"><i class="fas fa-book-open"></i> Courses</a>
            </li>
            <li><a href="#"><i class="fas fa-user-plus"></i> Enrollments</a></li>
            <li><a href="#"><i class="fas fa-dollar-sign"></i> Fee Payments</a></li>
            <li><a href="#"><i class="fas fa-id-card"></i> Student Cards</a></li>
            <li><a href="#"><i class="fas fa-certificate"></i> Certificates</a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> Reports</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
        </ul>
    </aside>

    <!-- MAIN -->
    <div class="main">
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
                <div>
                    <h2>@yield('title', 'Dashboard')</h2>
                    <div class="breadcrumb">Dashboard / <span>@yield('breadcrumb', 'Dashboard')</span></div>
                </div>
            </div>
            <div class="topbar-right">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search..." />
                </div>
                <button class="notif-btn"><i class="fas fa-bell"></i><span class="notif-badge">3</span></button>
                <div class="profile-dropdown-wrap">
                    <button class="profile-btn" id="profileBtn">
                        <img src="#" alt="A" style="background:#6D4AFF; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:600;">
                        <span>{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
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

        <!-- CONTENT -->
        @yield('content')
    </div>

    <!-- STYLES & SCRIPTS -->
    <style>
        /* All styles from your existing UI go here */
        /* ... include all styles from the provided HTML ... */
    </style>

    <script>
        // Sidebar toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }
        menuToggle.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Profile dropdown
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('open');
        });
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.profile-dropdown-wrap')) profileDropdown.classList.remove('open');
        });

        // Toast
        function showToast(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            toast.classList.add('show');
            clearTimeout(toast._timer);
            toast._timer = setTimeout(() => toast.classList.remove('show'), 3500);
        }

        // Modal functions
        function openModal(id) { document.getElementById(id).classList.add('active'); }
        function closeModal(id) { document.getElementById(id).classList.remove('active'); }
        document.querySelectorAll('.modal-overlay').forEach(el => {
            el.addEventListener('click', function(e) { if (e.target === this) this.classList.remove('active'); });
        });

        // Drawer functions
        function openDrawer(id) {
            document.getElementById('drawerTitle').textContent = 'Course Details';
            document.getElementById('drawerOverlay').classList.add('active');
            document.getElementById('drawer').classList.add('open');
            // Load course details via AJAX
            fetch('/admin/courses/' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const course = data.data;
                        document.getElementById('drawerContent').innerHTML = `
                            <div style="margin-bottom:20px;">
                                <h4 style="font-size:18px;">${course.name}</h4>
                                <p style="color:#64748B;">Course ID: ${course.course_code}</p>
                            </div>
                            <div style="background:#F8FAFC; border-radius:14px; padding:16px; border:1px solid #F1F5F9; margin-bottom:12px;">
                                <div style="display:flex; justify-content:space-between; padding:4px 0;"><span style="color:#64748B;">Original Fee</span><span style="font-weight:600;">PKR ${Number(course.original_fee).toLocaleString()}</span></div>
                                <div style="display:flex; justify-content:space-between; padding:4px 0;"><span style="color:#64748B;">Duration</span><span>${course.duration}</span></div>
                                <div style="display:flex; justify-content:space-between; padding:4px 0;"><span style="color:#64748B;">Status</span><span class="status-badge">${course.status}</span></div>
                                <div style="display:flex; justify-content:space-between; padding:4px 0;"><span style="color:#64748B;">Enrollments</span><span>${course.enrollments?.length || 0}</span></div>
                            </div>
                            <div style="background:#F8FAFC; border-radius:14px; padding:16px; border:1px solid #F1F5F9; margin-bottom:12px;">
                                <h5 style="margin-bottom:8px;">Description</h5>
                                <p style="font-size:13px; color:#64748B;">${course.description || 'No description provided.'}</p>
                            </div>
                            <div style="margin-top:20px; display:flex; gap:10px; flex-wrap:wrap;">
                                <button class="btn-outline" style="flex:1;" onclick="editCourse('${course.id}')"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn-outline" style="flex:1;"><i class="fas fa-user-plus"></i> Assign Teacher</button>
                                <button class="btn-primary" style="flex:1;"><i class="fas fa-users"></i> Enrollments</button>
                            </div>
                        `;
                    }
                });
        }
        function closeDrawer() {
            document.getElementById('drawerOverlay').classList.remove('active');
            document.getElementById('drawer').classList.remove('open');
        }

        // Course functions
        document.getElementById('addCourseBtn').addEventListener('click', function() {
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-book-open" style="color:#6D4AFF; margin-right:10px;"></i> Add New Course';
            document.getElementById('submitBtnText').textContent = 'Save Course';
            document.getElementById('courseId').value = '';
            document.getElementById('courseForm').reset();
            document.getElementById('courseForm').action = '{{ route("admin.courses.store") }}';
            document.querySelector('input[name="_method"]')?.remove();
            openModal('courseModal');
        });

        function editCourse(id) {
            fetch('/admin/courses/' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const course = data.data;
                        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit" style="color:#6D4AFF; margin-right:10px;"></i> Edit Course';
                        document.getElementById('submitBtnText').textContent = 'Update Course';
                        document.getElementById('courseId').value = course.id;
                        document.getElementById('cName').value = course.name;
                        document.getElementById('cFee').value = course.original_fee;
                        document.getElementById('cDuration').value = course.duration;
                        document.getElementById('cDescription').value = course.description || '';
                        document.getElementById('cStatus').value = course.status;
                        
                        // Set form action for update
                        const form = document.getElementById('courseForm');
                        form.action = '/admin/courses/' + course.id;
                        if (!document.querySelector('input[name="_method"]')) {
                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'PUT';
                            form.appendChild(methodInput);
                        }
                        closeDrawer();
                        openModal('courseModal');
                    }
                });
        }

        function saveCourse(e) {
            e.preventDefault();
            const form = document.getElementById('courseForm');
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeModal('courseModal');
                    showToast('✅ ' + data.message);
                    setTimeout(() => window.location.reload(), 1000);
                }
            })
            .catch(error => {
                showToast('⚠️ Error saving course');
            });
        }

        function viewCourse(id) {
            openDrawer(id);
        }

        function deleteCourse(id, name) {
            document.getElementById('deleteCourseName').textContent = name;
            const form = document.getElementById('deleteForm');
            form.action = '/admin/courses/' + id;
            openModal('deleteModal');
        }

        function assignTeacher(id) {
            showToast('📋 Assign teacher functionality coming soon');
        }

        function viewEnrollments(id) {
            showToast('📋 View enrollments coming soon');
        }

        // Toggle dropdown
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
    </script>
    @stack('scripts')
</body>
</html>