{{-- resources/views/partials/sidebar.blade.php --}}
<aside class="sidebar" id="sidebar">
    <!-- ─── Search Bar ─── -->
    <div class="sidebar-search">
        <div class="search-input-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="sidebarSearch" placeholder="Search menu..." onkeyup="filterSidebarMenu()" />
            <button class="search-clear" id="searchClear" onclick="clearSearch()" style="display:none;">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <div class="sidebar-brand">
        <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
        <div class="brand-text">
            <span class="name">Leeds<span>Institute</span></span>
            <span class="tagline">Excellence in Education</span>
        </div>
    </div>

    <ul class="sidebar-menu" id="sidebarMenu">
        <li class="menu-label">Main</li>
        <li class="{{ request()->is('dashboard') ? 'active' : '' }}" data-search="Dashboard">
            <a href="{{ url('/dashboard') }}"><i class="fas fa-th-large"></i> Dashboard</a>
        </li>
        <li class="{{ request()->is('admin/students*') ? 'active' : '' }}" data-search="Students Student Management">
            <a href="{{ url('/admin/students') }}"><i class="fas fa-user-graduate"></i> Students</a>
        </li>
        <li class="{{ request()->is('admin/teachers*') ? 'active' : '' }}" data-search="Teachers Teacher Management">
            <a href="{{ url('/admin/teachers') }}"><i class="fas fa-chalkboard-teacher"></i> Teachers</a>
        </li>
        <li class="{{ request()->is('admin/courses*') ? 'active' : '' }}" data-search="Courses Course Management">
            <a href="{{ url('/admin/courses') }}"><i class="fas fa-book-open"></i> Courses</a>
        </li>

        <li class="menu-label">Management</li>
        <li class="{{ request()->is('admin/enrollments*') ? 'active' : '' }}" data-search="Enrollments Enrollment Management">
            <a href="{{ url('/admin/enrollments') }}"><i class="fas fa-user-plus"></i> Enrollments</a>
        </li>
        <li class="{{ request()->is('admin/fee-payments*') ? 'active' : '' }}" data-search="Fee Payments Payment Fees">
            <a href="{{ url('/admin/fee-payments') }}"><i class="fas fa-dollar-sign"></i> Fee Payments</a>
        </li>
        <li class="{{ request()->is('admin/student-cards*') ? 'active' : '' }}" data-search="Student Cards ID Card">
            <a href="{{ url('/admin/student-cards') }}"><i class="fas fa-id-card"></i> Student Cards</a>
        </li>
        <li class="{{ request()->is('admin/certificates*') ? 'active' : '' }}" data-search="Certificates Certificate">
            <a href="{{ url('/admin/certificates') }}"><i class="fas fa-certificate"></i> Certificates</a>
        </li>
        <li class="{{ request()->is('admin/talent-test*') ? 'active' : '' }}" data-search="Talent Test Assessment">
            <a href="{{ url('/admin/talent-test') }}"><i class="fas fa-clipboard-list"></i> Talent Test</a>
        </li>

        <li class="menu-label">Reports</li>
        <li class="{{ request()->is('admin/reports*') ? 'active' : '' }}" data-search="Reports Report Analytics">
            <a href="{{ url('/admin/reports') }}"><i class="fas fa-chart-bar"></i> Reports</a>
        </li>
        <li class="{{ request()->is('admin/enquiries*') ? 'active' : '' }}" data-search="Enquiries Enquiry Messages">
            <a href="{{ url('/admin/enquiries') }}"><i class="fas fa-envelope"></i> Enquiries</a>
        </li>

        <li class="menu-label">Website</li>
        <li class="{{ request()->is('admin/gallery*') ? 'active' : '' }}" data-search="Gallery Images Photos">
            <a href="{{ url('/admin/gallery') }}"><i class="fas fa-images"></i> Gallery</a>
        </li>

        <li class="menu-label">System</li>
        <li class="{{ request()->is('admin/settings*') ? 'active' : '' }}" data-search="Settings Configuration Setup">
            <a href="{{ url('/admin/settings') }}"><i class="fas fa-cog"></i> Settings</a>
        </li>
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


<style>
/* ─── Premium Sidebar with Leeds Colors (Red & Yellow Dominant) ─── */
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

/* ─── Scrollbar - Wider ─── */
.sidebar::-webkit-scrollbar { 
    width: 8px; 
}
.sidebar::-webkit-scrollbar-track { 
    background: rgba(255,255,255,0.05); 
    border-radius: 10px;
}
.sidebar::-webkit-scrollbar-thumb { 
    background: linear-gradient(180deg, #FFC107, #E53935);
    border-radius: 10px;
    border: 2px solid rgba(0,0,0,0.1);
}
.sidebar::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, #E53935, #FFC107);
}

/* Firefox scrollbar */
.sidebar {
    scrollbar-width: thin;
    scrollbar-color: #FFC107 rgba(255,255,255,0.05);
}

/* ─── Search Bar ─── */
.sidebar-search {
    padding: 0 8px 16px 8px;
    margin-bottom: 8px;
    border-bottom: 1px solid rgba(255,193,7,0.08);
}
.search-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
    background: rgba(255,255,255,0.06);
    border-radius: 30px;
    padding: 0 14px;
    transition: all 0.3s ease;
    border: 1.5px solid transparent;
}
.search-input-wrap:focus-within {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,193,7,0.3);
    box-shadow: 0 0 20px rgba(255,193,7,0.05);
}
.search-input-wrap i {
    color: rgba(255,255,255,0.35);
    font-size: 14px;
    margin-right: 10px;
    transition: color 0.3s;
}
.search-input-wrap:focus-within i {
    color: #FFC107;
}
.search-input-wrap input {
    background: transparent;
    border: none;
    outline: none;
    color: #fff;
    font-size: 13px;
    font-family: 'Inter', sans-serif;
    padding: 10px 0;
    flex: 1;
    width: 100%;
}
.search-input-wrap input::placeholder {
    color: rgba(255,255,255,0.3);
}
.search-clear {
    background: none;
    border: none;
    color: rgba(255,255,255,0.3);
    cursor: pointer;
    padding: 4px 8px;
    font-size: 12px;
    transition: color 0.3s;
}
.search-clear:hover {
    color: #E53935;
}

/* ─── Search Results Highlight ─── */
.sidebar-menu li.hidden {
    display: none !important;
}
.sidebar-menu li.menu-label.hidden {
    display: none !important;
}
.sidebar-menu li.highlight {
    background: rgba(255,193,7,0.08);
    border-left: 3px solid #FFC107;
}
.sidebar-menu li.highlight a {
    color: #FFC107 !important;
}
.sidebar-menu li.highlight a i {
    color: #E53935 !important;
}

/* ─── No results message ─── */
.no-results-msg {
    display: none;
    padding: 20px 16px;
    text-align: center;
    color: rgba(255,255,255,0.3);
    font-size: 13px;
}
.no-results-msg i {
    display: block;
    font-size: 28px;
    margin-bottom: 8px;
    color: rgba(255,255,255,0.15);
}
.no-results-msg.show {
    display: block;
}

/* ─── Sidebar Brand ─── */
.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 28px;
    padding: 4px 6px;
    position: relative;
}
.sidebar-brand .logo-icon {
    background: linear-gradient(135deg, #E53935, #FFC107, #E53935);
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: #fff;
    box-shadow: 0 4px 20px rgba(229,57,53,0.4);
    transition: all 0.3s;
    border: 2px solid rgba(255,193,7,0.3);
}
.sidebar-brand .logo-icon:hover {
    transform: scale(1.05) rotate(-5deg);
    box-shadow: 0 8px 30px rgba(229,57,53,0.5);
    border-color: #FFC107;
}
.sidebar-brand .brand-text .name {
    font-weight: 800;
    font-size: 22px;
    letter-spacing: -0.5px;
    color: #fff;
    text-shadow: 0 2px 10px rgba(255,193,7,0.1);
}
.sidebar-brand .brand-text .name span {
    color: #FFC107;
    position: relative;
    text-shadow: 0 0 30px rgba(255,193,7,0.3);
}
.sidebar-brand .brand-text .name span::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #E53935, #FFC107, #E53935);
    border-radius: 2px;
}
.sidebar-brand .brand-text .tagline {
    font-size: 10px;
    font-weight: 500;
    color: rgba(255,193,7,0.6);
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-top: 2px;
}

.sidebar-menu {
    list-style: none;
    flex: 1;
    margin-top: 4px;
}
.sidebar-menu .menu-label {
    font-size: 11px;
    font-weight: 600;
    color: rgba(255,193,7,0.4);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    padding: 16px 12px 8px;
    position: relative;
}
.sidebar-menu .menu-label::before {
    content: '';
    position: absolute;
    left: 12px;
    bottom: 0;
    width: 30px;
    height: 2px;
    background: linear-gradient(90deg, #FFC107, #E53935);
    border-radius: 2px;
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
    transition: all 0.25s;
    position: relative;
}
.sidebar-menu li a i {
    width: 20px;
    font-size: 16px;
    text-align: center;
    color: rgba(255,255,255,0.35);
    transition: color 0.3s;
}
.sidebar-menu li a:hover {
    background: rgba(255,193,7,0.1);
    color: #FFC107;
    transform: translateX(4px);
}
.sidebar-menu li a:hover i { 
    color: #E53935; 
}
.sidebar-menu li.active a {
    background: rgba(255,193,7,0.15);
    color: #FFC107;
    font-weight: 600;
    border-left: 4px solid #E53935;
    box-shadow: inset 0 0 20px rgba(229,57,53,0.05);
}
.sidebar-menu li.active a i { 
    color: #E53935;
    text-shadow: 0 0 20px rgba(229,57,53,0.3);
}
.sidebar-menu li.active a::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 30px;
    background: linear-gradient(180deg, #E53935, #FFC107);
    border-radius: 0 3px 3px 0;
}

.sidebar-footer {
    border-top: 1px solid rgba(255,193,7,0.1);
    padding-top: 16px;
    margin-top: 8px;
}
.sidebar-footer .user-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 12px;
    background: rgba(255,193,7,0.04);
    transition: background 0.2s;
    cursor: pointer;
    border: 1px solid rgba(255,193,7,0.05);
}
.sidebar-footer .user-card:hover { 
    background: rgba(255,193,7,0.1);
    border: 1px solid rgba(255,193,7,0.2);
}
.sidebar-footer .user-card .avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, #E53935, #FFC107);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 17px;
    color: #fff;
    flex-shrink: 0;
    box-shadow: 0 2px 15px rgba(229,57,53,0.3);
}
.sidebar-footer .user-card .info .name {
    font-weight: 600;
    font-size: 14px;
    color: #fff;
}
.sidebar-footer .user-card .info .role {
    font-size: 12px;
    color: rgba(255,193,7,0.5);
}
.sidebar-footer .user-card .badge {
    background: #E53935;
    color: #fff;
    font-size: 9px;
    font-weight: 700;
    padding: 2px 10px;
    border-radius: 30px;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 10px rgba(229,57,53,0.3);
}

/* ─── Responsive Sidebar ─── */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        width: 270px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        z-index: 60;
    }
    .sidebar.open {
        transform: translateX(0);
    }
}
</style>

<script>
// ─── Live Search Function ───
function filterSidebarMenu() {
    const input = document.getElementById('sidebarSearch');
    const filter = input.value.toLowerCase().trim();
    const menu = document.getElementById('sidebarMenu');
    const items = menu.querySelectorAll('li');
    const clearBtn = document.getElementById('searchClear');
    let hasVisible = false;

    // Show/hide clear button
    if (filter.length > 0) {
        clearBtn.style.display = 'block';
    } else {
        clearBtn.style.display = 'none';
    }

    // If search is empty, show everything
    if (filter === '') {
        items.forEach(item => {
            item.classList.remove('hidden');
            item.classList.remove('highlight');
        });
        document.querySelectorAll('.no-results-msg').forEach(el => el.classList.remove('show'));
        return;
    }

    // Filter items
    items.forEach(item => {
        // Skip menu-label items (they will be shown/hidden based on children)
        if (item.classList.contains('menu-label')) {
            return;
        }

        const searchData = item.getAttribute('data-search') || '';
        const text = item.textContent.toLowerCase();
        const match = searchData.toLowerCase().includes(filter) || text.includes(filter);

        if (match) {
            item.classList.remove('hidden');
            item.classList.add('highlight');
            hasVisible = true;
        } else {
            item.classList.add('hidden');
            item.classList.remove('highlight');
        }
    });

    // Show/hide menu labels based on visible children
    const labels = menu.querySelectorAll('.menu-label');
    labels.forEach(label => {
        let hasVisibleChild = false;
        let nextSibling = label.nextElementSibling;
        while (nextSibling && !nextSibling.classList.contains('menu-label')) {
            if (!nextSibling.classList.contains('hidden')) {
                hasVisibleChild = true;
                break;
            }
            nextSibling = nextSibling.nextElementSibling;
        }
        if (hasVisibleChild) {
            label.classList.remove('hidden');
        } else {
            label.classList.add('hidden');
        }
    });

    // Show "no results" message
    let noResultsMsg = document.querySelector('.no-results-msg');
    if (!noResultsMsg) {
        noResultsMsg = document.createElement('div');
        noResultsMsg.className = 'no-results-msg';
        noResultsMsg.innerHTML = `
            <i class="fas fa-search"></i>
            No results found
            <span style="display:block;font-size:11px;color:rgba(255,255,255,0.2);margin-top:4px;">Try a different keyword</span>
        `;
        menu.appendChild(noResultsMsg);
    }

    if (!hasVisible && filter !== '') {
        noResultsMsg.classList.add('show');
    } else {
        noResultsMsg.classList.remove('show');
    }
}

// ─── Clear Search ───
function clearSearch() {
    const input = document.getElementById('sidebarSearch');
    input.value = '';
    input.focus();
    filterSidebarMenu();
}

// ─── Keyboard shortcut: Ctrl+K to focus search ───
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.getElementById('sidebarSearch');
        searchInput.focus();
        searchInput.select();
    }
});

// ─── Close sidebar on mobile after link click ───
document.querySelectorAll('.sidebar-menu li a').forEach(link => {
    link.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('overlay')?.classList.remove('active');
        }
    });
});
</script>