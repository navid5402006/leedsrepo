{{-- resources/views/admin/gallery.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leeds Academy · Gallery Management</title>
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
        /* ... sidebar styles (same as other admin pages) ... */
        
        .main { flex:1; background: #F5F7FA; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar {
            background: #FFFFFF; padding: 16px 32px; display: flex; align-items: center;
            justify-content: space-between; flex-wrap: wrap; gap: 16px;
            border-bottom: 1px solid #F1F5F9; position: sticky; top: 0; z-index: 40;
        }
        .content { padding: 28px 32px 40px; flex:1; }
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 16px; margin-bottom: 24px;
        }
        .page-header h3 { font-size: 24px; font-weight: 600; color: #0F172A; }
        .btn-primary {
            background: #6D4AFF; border: none; padding: 10px 24px; border-radius: 40px;
            font-weight: 600; font-size: 14px; color: #fff; display: inline-flex;
            align-items: center; gap: 10px; cursor: pointer; transition: all 0.15s;
            box-shadow: 0 6px 14px -6px rgba(109,74,255,0.3); font-family: 'Inter', sans-serif;
        }
        .btn-primary:hover { background: #5a3de0; transform: translateY(-2px); }
        .btn-danger { background: #EF4444; border: none; padding: 8px 16px; border-radius: 30px;
            font-weight: 600; font-size: 12px; color: #fff; cursor: pointer; transition: 0.15s; }
        .btn-danger:hover { background: #DC2626; }
        .btn-success { background: #10B981; border: none; padding: 8px 16px; border-radius: 30px;
            font-weight: 600; font-size: 12px; color: #fff; cursor: pointer; transition: 0.15s; }
        .btn-success:hover { background: #0EA373; }
        .btn-outline {
            background: transparent; border: 1.5px solid #E2E8F0; padding: 8px 18px;
            border-radius: 40px; font-weight: 600; font-size: 13px; color: #475569;
            cursor: pointer; transition: 0.15s; font-family: 'Inter', sans-serif;
        }
        .btn-outline:hover { background: #F1F5F9; }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .gallery-item {
            background: #fff; border-radius: 16px; overflow: hidden;
            border: 1px solid #F1F5F9; box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            transition: all 0.3s; cursor: pointer; position: relative;
        }
        .gallery-item:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .gallery-item img {
            width: 100%; height: 180px; object-fit: cover; display: block;
        }
        .gallery-item .info {
            padding: 14px 16px 16px;
        }
        .gallery-item .info .title {
            font-weight: 600; font-size: 14px; color: #0F172A;
            margin-bottom: 2px;
        }
        .gallery-item .info .category {
            font-size: 12px; color: #94A3B8;
        }
        .gallery-item .info .actions {
            display: flex; gap: 6px; margin-top: 10px;
            justify-content: flex-end;
        }
        .gallery-item .status-badge {
            position: absolute; top: 10px; right: 10px;
            font-size: 10px; font-weight: 600; padding: 3px 12px;
            border-radius: 30px; background: #DCFCE7; color: #10B981;
        }
        .gallery-item .status-badge.inactive {
            background: #FEE2E2; color: #DC2626;
        }

        .modal-overlay {
            position: fixed; inset: 0; background: rgba(15,23,42,0.55);
            backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center;
            z-index: 999; padding: 20px;
        }
        .modal-overlay.active { display: flex; }
        .modal {
            background: #fff; border-radius: 24px; max-width: 600px; width: 100%;
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
        .full-width { grid-column: 1 / -1; }

        .upload-area {
            border: 2px dashed #E2E8F0; border-radius: 12px; padding: 20px;
            text-align: center; color: #94A3B8; transition: 0.2s; cursor: pointer;
        }
        .upload-area:hover { border-color: #6D4AFF; background: #F8FAFC; }
        .upload-area i { font-size: 28px; color: #6D4AFF; display: block; margin-bottom: 6px; }
        .upload-preview {
            margin-top: 10px; display: flex; align-items: center; gap: 12px;
            padding: 10px; background: #F8FAFC; border-radius: 10px;
            border: 1px solid #E2E8F0;
        }
        .upload-preview img {
            width: 60px; height: 60px; border-radius: 8px; object-fit: cover;
        }

        .modal-footer {
            display: flex; justify-content: flex-end; gap: 12px;
            margin-top: 24px; padding-top: 20px; border-top: 1px solid #F1F5F9;
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

        @media (max-width: 768px) {
            .content { padding: 16px; }
            .form-grid { grid-template-columns: 1fr; }
            .gallery-grid { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); }
        }
    </style>
</head>
<body>
    @include('admin.sidebar')
    <div class="main">
        <header class="topbar">
            <div class="topbar-left">
                <div><h2>Gallery Management</h2><div class="breadcrumb">Dashboard / <span>Gallery</span></div></div>
            </div>
            <div class="topbar-right">
                <button class="btn-primary" onclick="openAddModal()"><i class="fas fa-plus"></i> Add Image</button>
            </div>
        </header>
        <div class="content">
            <div class="gallery-grid" id="galleryGrid">
                <!-- Dynamic content -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal-overlay" id="galleryModal">
        <div class="modal">
            <div class="modal-header">
                <h2 id="modalTitle"><i class="fas fa-image" style="color:#6D4AFF;"></i> Add Gallery Image</h2>
                <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
            </div>
            <form id="galleryForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="galleryId" value="">
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Title <span class="required">*</span></label>
                        <input type="text" id="gTitle" placeholder="Image title" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Image <span class="required">*</span></label>
                        <div class="upload-area" onclick="document.getElementById('gImage').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Click to upload image (JPG, PNG, GIF, WEBP)</p>
                        </div>
                        <input type="file" id="gImage" name="image" accept="image/*" style="display:none;" onchange="handleImageUpload(this)">
                        <div class="upload-preview" id="imagePreview" style="display:none;">
                            <img id="previewImg" src="#" alt="Preview">
                            <span id="previewName">image.jpg</span>
                            <button type="button" onclick="removeImage()" style="background:none;border:none;color:#EF4444;cursor:pointer;margin-left:auto;">Remove</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" id="gCategory" placeholder="e.g. Campus, Events">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select id="gStatus">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group full-width">
                        <label>Description</label>
                        <textarea id="gDescription" rows="2" placeholder="Image description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-primary" id="saveBtn"><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal" style="max-width:440px;text-align:center;">
            <div style="font-size:48px;color:#EF4444;margin-bottom:12px;"><i class="fas fa-exclamation-circle"></i></div>
            <h3 style="font-size:20px;font-weight:600;margin-bottom:4px;">Delete Image</h3>
            <p style="color:#64748B;font-size:14px;">Are you sure you want to delete this image? This action cannot be undone.</p>
            <div style="margin-top:16px;display:flex;gap:12px;justify-content:center;">
                <button class="btn-outline" onclick="document.getElementById('deleteModal').classList.remove('active')">Cancel</button>
                <button class="btn-danger" id="confirmDeleteBtn"><i class="fas fa-trash"></i> Delete</button>
            </div>
        </div>
    </div>

    <div class="toast" id="toast"><i class="fas fa-check-circle"></i> <span id="toastMsg"></span></div>

    <script>
      // ─── FIXED: Gallery Management Script ───

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let deleteId = null;

function showToast(msg) {
    const toast = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = msg;
    toast.classList.add('show');
    clearTimeout(toast._timer);
    toast._timer = setTimeout(() => toast.classList.remove('show'), 3500);
}

function openModal() { document.getElementById('galleryModal').classList.add('active'); }
function closeModal() {
    document.getElementById('galleryModal').classList.remove('active');
    document.getElementById('galleryForm').reset();
    document.getElementById('galleryId').value = '';
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('previewImg').src = '';
}

function handleImageUpload(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('previewName').textContent = file.name;
            document.getElementById('imagePreview').style.display = 'flex';
        };
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('gImage').value = '';
}

function openAddModal() {
    document.getElementById('modalTitle').innerHTML = '<i class="fas fa-image" style="color:#6D4AFF;"></i> Add Gallery Image';
    document.getElementById('saveBtn').innerHTML = '<i class="fas fa-save"></i> Save';
    document.getElementById('galleryForm').reset();
    document.getElementById('galleryId').value = '';
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('gStatus').value = '1';
    openModal();
}

async function loadGallery() {
    try {
        const response = await fetch('{{ route("admin.gallery.index") }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await response.json();
        const grid = document.getElementById('galleryGrid');
        if (data.data.length === 0) {
            grid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:60px;color:#94A3B8;"><i class="fas fa-images" style="font-size:48px;display:block;margin-bottom:16px;opacity:0.3;"></i><p>No images in gallery yet. Click "Add Image" to get started.</p></div>';
            return;
        }
        grid.innerHTML = data.data.map(item => `
            <div class="gallery-item">
                <img src="${item.image_url || '/storage/' + item.image}" alt="${item.title}" onerror="this.src='https://placehold.co/400x300/6D4AFF/FFFFFF?text=No+Image'"/>
                <span class="status-badge ${item.status ? '' : 'inactive'}">${item.status ? 'Active' : 'Inactive'}</span>
                <div class="info">
                    <div class="title">${item.title}</div>
                    <div class="category">${item.category || 'Uncategorized'}</div>
                    <div class="actions">
                        <button class="btn-success" onclick="editGallery(${item.id})"><i class="fas fa-edit"></i></button>
                        <button class="btn-danger" onclick="confirmDelete(${item.id})"><i class="fas fa-trash"></i></button>
                        <button class="btn-outline" onclick="toggleStatus(${item.id})" style="padding:4px 12px;font-size:11px;">
                            ${item.status ? 'Deactivate' : 'Activate'}
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading gallery:', error);
        showToast('⚠️ Error loading gallery');
    }
}

async function editGallery(id) {
    try {
        const response = await fetch(`/admin/gallery/${id}/edit`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await response.json();
        const item = data.data;
        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit" style="color:#6D4AFF;"></i> Edit Gallery Image';
        document.getElementById('saveBtn').innerHTML = '<i class="fas fa-save"></i> Update';
        document.getElementById('galleryId').value = item.id;
        document.getElementById('gTitle').value = item.title;
        document.getElementById('gCategory').value = item.category || '';
        document.getElementById('gDescription').value = item.description || '';
        document.getElementById('gStatus').value = item.status ? '1' : '0';
        if (item.image) {
            document.getElementById('previewImg').src = '/storage/' + item.image;
            document.getElementById('previewName').textContent = 'Current image';
            document.getElementById('imagePreview').style.display = 'flex';
        }
        openModal();
    } catch (error) {
        showToast('⚠️ Error loading image data');
    }
}

async function toggleStatus(id) {
    try {
        const response = await fetch(`/admin/gallery/${id}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        });
        const result = await response.json();
        if (result.success) {
            showToast(result.message);
            loadGallery();
        }
    } catch (error) {
        showToast('⚠️ Error updating status');
    }
}

function confirmDelete(id) {
    deleteId = id;
    document.getElementById('deleteModal').classList.add('active');
}

document.getElementById('confirmDeleteBtn').addEventListener('click', async function() {
    if (deleteId) {
        try {
            const response = await fetch(`/admin/gallery/${deleteId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const result = await response.json();
            if (result.success) {
                showToast(result.message);
                document.getElementById('deleteModal').classList.remove('active');
                loadGallery();
            }
        } catch (error) {
            showToast('⚠️ Error deleting image');
        }
    }
});

// ─── FIXED: Form Submission ───
document.getElementById('galleryForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const id = document.getElementById('galleryId').value;
    const title = document.getElementById('gTitle').value.trim();
    const category = document.getElementById('gCategory').value.trim();
    const description = document.getElementById('gDescription').value.trim();
    const status = document.getElementById('gStatus').value;
    const imageFile = document.getElementById('gImage').files[0];

    // ─── Validate title ───
    if (!title) {
        showToast('⚠️ Title is required');
        document.getElementById('gTitle').style.borderColor = '#EF4444';
        setTimeout(() => {
            document.getElementById('gTitle').style.borderColor = '';
        }, 2000);
        return;
    }

    // ─── Validate image for new entry ───
    if (!id && !imageFile) {
        showToast('⚠️ Please select an image');
        return;
    }

    const formData = new FormData();
    formData.append('title', title);
    formData.append('category', category);
    formData.append('description', description);
    formData.append('status', status);
    if (imageFile) {
        formData.append('image', imageFile);
    }

    // For edit, use PUT method
    const url = id ? `/admin/gallery/${id}` : '/admin/gallery/store';
    if (id) {
        formData.append('_method', 'PUT');
    }

    try {
        const response = await fetch(url, {
            method: 'POST', // Use POST with _method override for PUT
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
            loadGallery();
        } else {
            // ─── Show validation errors ───
            const errors = result.errors || {};
            let errorMsg = '';
            for (const key in errors) {
                errorMsg += `⚠️ ${errors[key].join(', ')}\n`;
            }
            showToast(errorMsg || '⚠️ Error saving image');
            
            // Highlight fields with errors
            if (errors.title) {
                document.getElementById('gTitle').style.borderColor = '#EF4444';
                setTimeout(() => {
                    document.getElementById('gTitle').style.borderColor = '';
                }, 3000);
            }
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('⚠️ Error saving image. Please try again.');
    }
});

// ─── Close modals on overlay click ───
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });
});

// ─── Load gallery on page load ───
loadGallery();
    </script>
</body>
</html>