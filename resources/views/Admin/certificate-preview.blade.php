<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leeds Academy · Certificate - {{ $certificate->certificate_no ?? 'Preview' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;0,900;1,400;1,600&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Great+Vibes&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <style>
        /* All existing styles remain the same */
        *,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
        html,body{width:100%;height:100%;}
        body{
            font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif;
            background:#E8ECF2;color:#1E293B;
            display:flex;min-height:100vh;overflow-x:hidden;
        }

        .sidebar{
            width:280px;background:#071B3B;color:#fff;
            display:flex;flex-direction:column;flex-shrink:0;
            position:sticky;top:0;height:100vh;
            overflow-y:auto;padding:24px 18px 30px;
            transition:transform .25s ease;z-index:50;
            box-shadow:4px 0 24px rgba(0,0,0,.12);
        }
        .sidebar-brand{display:flex;align-items:center;gap:12px;margin-bottom:40px;padding-left:6px;}
        .sidebar-brand .logo-icon{
            background:rgba(255,255,255,.06);width:42px;height:42px;border-radius:14px;
            display:flex;align-items:center;justify-content:center;
            font-size:22px;color:#6D4AFF;box-shadow:0 4px 10px rgba(0,0,0,.2);
        }
        .sidebar-brand span{font-weight:700;font-size:20px;letter-spacing:-.3px;}
        .sidebar-brand span small{color:#6D4AFF;}
        .sidebar-menu{list-style:none;flex:1;}
        .sidebar-menu li{margin-bottom:4px;}
        .sidebar-menu li a{
            display:flex;align-items:center;gap:14px;padding:12px 16px;
            border-radius:12px;color:rgba(255,255,255,.7);font-weight:500;
            font-size:15px;text-decoration:none;transition:all .15s;
        }
        .sidebar-menu li a i{width:22px;font-size:16px;text-align:center;color:rgba(255,255,255,.5);transition:color .15s;}
        .sidebar-menu li a:hover{background:rgba(255,255,255,.06);color:#fff;}
        .sidebar-menu li a:hover i{color:#fff;}
        .sidebar-menu li.active a{background:rgba(109,74,255,.2);color:#fff;font-weight:600;}
        .sidebar-menu li.active a i{color:#6D4AFF;}

        .main{flex:1;display:flex;flex-direction:column;min-width:0;overflow:hidden;}
        .topbar{
            background:#fff;padding:16px 32px;
            display:flex;align-items:center;justify-content:space-between;
            flex-wrap:wrap;gap:16px;border-bottom:1px solid #F1F5F9;
            position:sticky;top:0;z-index:40;
            box-shadow:0 1px 6px rgba(0,0,0,.04);
        }
        .topbar-left{display:flex;align-items:center;gap:16px;}
        .menu-toggle{
            background:transparent;border:none;font-size:20px;color:#1E293B;
            cursor:pointer;display:none;padding:6px 8px;border-radius:8px;
        }
        .menu-toggle:hover{background:#F1F5F9;}
        .breadcrumb{font-size:13px;color:#64748B;}
        .breadcrumb span{color:#1E293B;font-weight:500;}
        .topbar-left h2{font-weight:700;font-size:21px;letter-spacing:-.3px;color:#0F172A;}
        .topbar-right{display:flex;align-items:center;gap:18px;}
        .search-box{
            position:relative;background:#F5F7FA;border-radius:30px;
            padding:6px 14px 6px 40px;border:1.5px solid transparent;
            transition:all .2s;display:flex;align-items:center;width:220px;
        }
        .search-box:focus-within{border-color:#6D4AFF;background:#fff;box-shadow:0 0 0 3px rgba(109,74,255,.08);}
        .search-box i{position:absolute;left:14px;color:#94A3B8;}
        .search-box input{background:transparent;border:none;padding:7px 0;width:100%;outline:none;font-size:14px;font-family:'Inter',sans-serif;}
        .notif-btn{
            background:transparent;border:none;font-size:20px;color:#475569;
            cursor:pointer;padding:6px;border-radius:30px;transition:background .15s;position:relative;
        }
        .notif-btn:hover{background:#F1F5F9;}
        .notif-badge{
            position:absolute;top:2px;right:2px;background:#6D4AFF;color:#fff;
            font-size:10px;font-weight:700;border-radius:30px;width:18px;height:18px;
            display:flex;align-items:center;justify-content:center;border:2px solid #fff;
        }
        .profile-dropdown-wrap{position:relative;}
        .profile-btn{
            display:flex;align-items:center;gap:8px;padding:4px 12px 4px 6px;
            border-radius:40px;background:#F1F5F9;border:none;cursor:pointer;
        }
        .profile-avatar{
            width:34px;height:34px;border-radius:50%;background:#6D4AFF;
            display:flex;align-items:center;justify-content:center;
            color:#fff;font-weight:700;font-size:14px;
        }
        .profile-btn span{font-weight:500;font-size:14px;color:#1E293B;}
        .dropdown-menu{
            position:absolute;right:0;top:48px;background:#fff;border-radius:16px;
            box-shadow:0 20px 40px -12px rgba(0,0,0,.15);min-width:210px;padding:10px 0;
            opacity:0;visibility:hidden;transform:translateY(8px);transition:all .18s ease;
            border:1px solid #F1F5F9;z-index:100;
        }
        .dropdown-menu.open{opacity:1;visibility:visible;transform:translateY(0);}
        .dropdown-menu a{display:flex;align-items:center;gap:12px;padding:10px 18px;color:#1E293B;text-decoration:none;font-size:14px;font-weight:500;transition:background .1s;}
        .dropdown-menu a:hover{background:#F8FAFC;}
        .dropdown-menu a i{width:20px;color:#64748B;}
        .dropdown-divider{height:1px;background:#F1F5F9;margin:6px 12px;}
        .content{padding:22px 26px 32px;flex:1;overflow:auto;}

        .split-layout{
            display:grid;
            grid-template-columns:1fr 310px;
            gap:22px;
            align-items:start;
        }

        .preview-panel{width:100%;}
        .preview-label{
            font-size:11px;font-weight:700;color:#64748B;
            letter-spacing:1.5px;text-transform:uppercase;
            display:flex;align-items:center;gap:6px;
            margin-bottom:12px;
        }
        .preview-label .status-badge{
            font-size:10px;font-weight:600;padding:2px 12px;border-radius:30px;
            background:#E6F7E6;color:#10B981;
        }
        .preview-label .status-badge.verified{background:#EDE7FF;color:#6D4AFF;}
        .preview-label .status-badge.pending{background:#FEF3C7;color:#D97706;}
        .cert-outer-wrapper{width:670px;}
        #certScaleBox{
            width:1122px;height:794px;
            transform-origin:top left;
            flex-shrink:0;
            filter:drop-shadow(0 24px 60px rgba(0,0,0,.32));
        }

        #certCanvas{
            width:1122px;
            height:794px;
            position:relative;
            overflow:hidden;
            background:#FFFFFF;
            font-family:'Playfair Display', Georgia, serif;
        }

        .c-bg-white{
            position:absolute;
            inset:0;
            background:#FFFFFF;
            z-index:0;
        }

        .c-geo{
            position:absolute;inset:0;
            width:1122px;height:794px;
            pointer-events:none;z-index:1;
        }

        .c-border-outer{
            position:absolute;
            top:18px;left:18px;right:18px;bottom:18px;
            border:2.5px solid #D4AF37;
            pointer-events:none;z-index:6;
        }
        .c-border-inner{
            position:absolute;
            top:25px;left:25px;right:25px;bottom:25px;
            border:1px solid rgba(212,175,55,.35);
            pointer-events:none;z-index:6;
        }

        .c-corner{position:absolute;width:60px;height:60px;pointer-events:none;z-index:7;}
        .c-corner.tl{top:12px;left:12px;}
        .c-corner.tr{top:12px;right:12px;transform:scaleX(-1);}
        .c-corner.bl{bottom:12px;left:12px;transform:scaleY(-1);}
        .c-corner.br{bottom:12px;right:12px;transform:scale(-1,-1);}

        .c-watermark{
            position:absolute;
            top:50%;left:50%;
            transform:translate(-50%,-50%);
            width:380px;height:380px;
            z-index:2;pointer-events:none;
            opacity:.06;
            display:flex;align-items:center;justify-content:center;
        }
        .c-watermark img{
            width:100%;height:100%;
            object-fit:contain;display:block;
        }

        .c-badge{
            position:absolute;
            top:42px;right:52px;
            z-index:8;
            width:90px;height:90px;
        }
        .c-badge-ring{
            width:90px;height:90px;
            border-radius:50%;
            border:3px solid #D4AF37;
            background:linear-gradient(135deg,#071B3B 0%,#0D2B5E 100%);
            display:flex;flex-direction:column;align-items:center;justify-content:center;
            box-shadow:0 4px 20px rgba(0,0,0,.35),inset 0 1px 0 rgba(212,175,55,.25);
            position:relative;
            overflow:hidden;
        }
        .c-badge-ring::before{
            content:'';
            position:absolute;inset:4px;
            border-radius:50%;
            border:1px solid rgba(212,175,55,.3);
        }
        .c-badge-img{
            width:56px;height:56px;
            object-fit:cover;
            border-radius:50%;
            display:block;
        }

        .c-content{
            position:absolute;
            inset:0;
            z-index:5;
            display:flex;
            flex-direction:column;
            align-items:center;
            padding:36px 120px 24px 120px;
        }

        .c-logo{
            display:flex;flex-direction:column;align-items:center;
            margin-bottom:10px;flex-shrink:0;
        }
        .c-logo img{
            width:150px;height:150px;
            object-fit:cover;
            border-radius:50%;
            display:block;
            border:2.5px solid #D4AF37;
            box-shadow:0 4px 16px rgba(0,0,0,.2);
        }
        .c-logo .c-org{
            font-family:'Playfair Display',serif;
            font-size:10.5px;font-weight:700;
            letter-spacing:5.5px;color:#071B3B;
            text-transform:uppercase;margin-top:6px;
        }

        .c-ornline{
            display:flex;align-items:center;gap:8px;
            width:420px;margin:8px auto 10px;flex-shrink:0;
        }
        .c-ornline .ol{flex:1;height:1px;background:linear-gradient(90deg,transparent,#D4AF37,transparent);}
        .c-ornline .od{width:6px;height:6px;background:#D4AF37;transform:rotate(45deg);flex-shrink:0;}
        .c-ornline .odl{width:9px;height:9px;background:#D4AF37;transform:rotate(45deg);flex-shrink:0;}

        .c-title-wrap{text-align:center;flex-shrink:0;margin-bottom:4px;}
        .c-title-eyebrow{
            font-family:'Cormorant Garamond',serif;
            font-size:20px;letter-spacing:6px;color:#D4AF37;
            text-transform:uppercase;font-weight:500;
            font-style:italic;
            display:block;margin-bottom:4px;
        }
        .c-title-main{
            font-family:'Playfair Display',serif;
            font-size:60px;font-weight:900;
            color:#071B3B;letter-spacing:5px;
            text-transform:uppercase;line-height:1.1;
            display:block;
        }

        .c-subdiv{
            display:flex;align-items:center;justify-content:center;gap:10px;
            margin:10px 0 10px;flex-shrink:0;
            width:100%;
        }
        .c-subdiv .sd-line{width:180px;height:1px;background:linear-gradient(90deg,transparent,#D4AF37);}
        .c-subdiv .sd-line.r{background:linear-gradient(90deg,#D4AF37,transparent);}
        .c-subdiv .sd-star{color:#D4AF37;font-size:11px;letter-spacing:4px;}

        .c-presented{
            font-family:'Cormorant Garamond',serif;
            font-size:13px;letter-spacing:4px;color:#6D4AFF;
            text-transform:uppercase;flex-shrink:0;margin-bottom:5px;
            font-weight:500;
        }

        .c-name{
            font-family:'Great Vibes',cursive;
            font-size:62px;font-weight:400;color:#071B3B;
            line-height:1.05;text-align:center;
            flex-shrink:0;margin-bottom:6px;
            white-space:nowrap;
            position:relative;
            padding-bottom:6px;
        }
        .c-name::after{
            content:'';
            position:absolute;
            bottom:0;left:50%;transform:translateX(-50%);
            width:65%;height:1.5px;
            background:linear-gradient(90deg,transparent,#D4AF37,transparent);
        }

        .c-body{
            font-family:'Cormorant Garamond',serif;
            font-size:14.5px;color:#1E293B;text-align:center;
            line-height:1.7;
            flex-shrink:0;
            max-width:640px;
            margin-bottom:12px;
        }
        .c-body .course-highlight{
            font-family:'Playfair Display',serif;
            font-style:normal;font-weight:700;
            color:#071B3B;font-size:15px;letter-spacing:1.5px;
            border-bottom:1.5px solid #D4AF37;padding-bottom:1px;
        }

        .c-info{
            display:flex;justify-content:center;align-items:center;
            gap:0;flex-shrink:0;
            border:1px solid rgba(212,175,55,.25);
            border-radius:4px;
            background:rgba(212,175,55,.03);
            padding:8px 0;
            width:580px;
            margin-bottom:14px;
        }
        .c-info-item{
            text-align:center;
            padding:0 22px;
        }
        .c-info-item:not(:last-child){
            border-right:1px solid rgba(212,175,55,.3);
        }
        .c-info-item .lbl{
            font-size:8px;letter-spacing:2.5px;text-transform:uppercase;
            color:#94A3B8;font-weight:600;display:block;margin-bottom:3px;
            font-family:'Inter',sans-serif;
        }
        .c-info-item .val{
            font-family:'Playfair Display',serif;
            font-size:11px;font-weight:700;color:#071B3B;letter-spacing:.5px;
        }

        .c-footer{
            width:100%;
            display:flex;
            justify-content:space-between;
            align-items:flex-end;
            flex-shrink:0;
            padding:0 20px;
        }
        .c-sig{text-align:center;flex:1;}
        .c-sig .s-line{
            width:130px;height:0;
            border-bottom:1.5px solid #D4AF37;
            margin:0 auto 6px;
        }
        .c-sig .s-name{
            font-family:'Playfair Display',serif;
            font-size:11px;font-weight:700;color:#071B3B;letter-spacing:.5px;
        }
        .c-sig .s-lbl{
            font-size:8px;letter-spacing:2px;text-transform:uppercase;
            color:#94A3B8;margin-top:2px;font-family:'Inter',sans-serif;
        }
        .c-qr{text-align:center;flex-shrink:0;}
        .c-qr .q-box{
            width:80px;
            height:80px;
            background:#fff;
            border-radius:6px;
            border:2px solid rgba(212,175,55,.5);
            display:flex;
            align-items:center;
            justify-content:center;
            margin:0 auto;
            overflow:hidden;
            padding:4px;
        }
        .c-qr .q-box canvas,
        .c-qr .q-box img {
            width: 100% !important;
            height: 100% !important;
            display: block;
        }
        .c-qr .q-lbl{
            font-size:8px;letter-spacing:2px;text-transform:uppercase;
            color:#94A3B8;margin-top:5px;font-family:'Inter',sans-serif;
            font-weight:600;
        }

        .editor-panel{
            background:#fff;border-radius:16px;padding:22px;
            border:1px solid #E2E8F0;
            box-shadow:0 4px 16px rgba(0,0,0,.04);
            position:sticky;top:88px;
        }
        .editor-panel h4{
            font-size:14px;font-weight:700;color:#0F172A;
            margin-bottom:18px;display:flex;align-items:center;gap:8px;
            padding-bottom:12px;border-bottom:1px solid #F1F5F9;
        }
        .editor-panel h4 i{color:#6D4AFF;}
        .eg{margin-bottom:14px;}
        .eg label{font-size:11.5px;font-weight:600;color:#64748B;display:block;margin-bottom:4px;}
        .eg input,.eg textarea{
            width:100%;padding:9px 12px;border-radius:10px;
            border:1.5px solid #E2E8F0;font-size:13px;
            font-family:'Inter',sans-serif;transition:.15s;background:#F8FAFC;
            color:#0F172A;
        }
        .eg input:focus,.eg textarea:focus{
            border-color:#6D4AFF;box-shadow:0 0 0 3px rgba(109,74,255,.08);
            outline:none;background:#fff;
        }
        .eg input:disabled{background:#F1F5F9;color:#94A3B8;cursor:not-allowed;}

        .ea{display:flex;flex-wrap:wrap;gap:8px;margin-top:18px;padding-top:16px;border-top:1px solid #F1F5F9;}
        .btn,.btn-o{
            padding:8px 15px;font-size:12px;border-radius:30px;font-weight:600;
            cursor:pointer;transition:.15s;border:none;font-family:'Inter',sans-serif;
            display:inline-flex;align-items:center;gap:6px;
        }
        .btn{background:#6D4AFF;color:#fff;box-shadow:0 4px 12px rgba(109,74,255,.22);}
        .btn:hover{background:#5B3EE0;transform:translateY(-1px);}
        .btn.green{background:#10B981;box-shadow:0 4px 12px rgba(16,185,129,.22);}
        .btn.green:hover{background:#0EA373;}
        .btn.blue{background:#3B82F6;box-shadow:0 4px 12px rgba(59,130,246,.22);}
        .btn.blue:hover{background:#2563EB;}
        .btn.amber{background:#F59E0B;box-shadow:0 4px 12px rgba(245,158,11,.22);}
        .btn.amber:hover{background:#D97706;}
        .btn-o{background:transparent;color:#475569;border:1.5px solid #E2E8F0;}
        .btn-o:hover{background:#F1F5F9;}

        #printPortal{display:none;}

        @media print{
            @page{size:A4 landscape;margin:0;}
            html,body{
                margin:0;padding:0;
                print-color-adjust:exact;
                -webkit-print-color-adjust:exact;
            }
            body>*:not(#printPortal){display:none!important;}
            #printPortal{
                display:block!important;
                position:fixed;inset:0;
                width:297mm;height:210mm;
                overflow:hidden;
                print-color-adjust:exact;
                -webkit-print-color-adjust:exact;
            }
            #printPortal #certCanvas{
                width:297mm!important;
                height:210mm!important;
            }
            #printPortal .c-geo{
                width:100%!important;height:100%!important;
            }
            #printPortal .c-qr .q-box {
                width: 90px !important;
                height: 90px !important;
            }
        }

        .toast{
            position:fixed;bottom:28px;right:28px;background:#0F172A;color:#fff;
            padding:14px 22px;border-radius:50px;
            box-shadow:0 16px 40px -8px rgba(0,0,0,.25);
            display:flex;align-items:center;gap:10px;font-weight:500;font-size:14px;
            transform:translateY(90px);opacity:0;transition:all .32s cubic-bezier(.34,1.56,.64,1);
            z-index:9999;border-left:4px solid #6D4AFF;
        }
        .toast.show{transform:translateY(0);opacity:1;}
        .toast i{color:#6D4AFF;font-size:17px;}
        .overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.22);z-index:45;}
        .overlay.active{display:block;}

        .modal-overlay{
            position:fixed;inset:0;background:rgba(15,23,42,0.55);
            backdrop-filter:blur(4px);display:none;align-items:center;justify-content:center;
            z-index:999;padding:20px;
        }
        .modal-overlay.active{display:flex;}
        .modal{
            background:#fff;border-radius:28px;max-width:560px;width:100%;
            max-height:90vh;overflow-y:auto;padding:32px 36px 36px;
            box-shadow:0 40px 80px -20px rgba(0,0,0,0.3);
            animation:modalIn 0.25s ease;
        }
        @keyframes modalIn{from{opacity:0;transform:scale(0.96) translateY(20px);}to{opacity:1;transform:scale(1) translateY(0);}}
        .modal-header{
            display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;
        }
        .modal-header h2{font-size:20px;font-weight:700;color:#0F172A;}
        .modal-close{background:transparent;border:none;font-size:24px;color:#94A3B8;cursor:pointer;padding:6px;}
        .modal-close:hover{color:#1E293B;}
        .modal .eg{margin-bottom:16px;}
        .modal .btn-success{background:#10B981;color:#fff;border:none;padding:10px 24px;border-radius:40px;font-weight:600;font-size:14px;cursor:pointer;transition:.15s;font-family:'Inter',sans-serif;}
        .modal .btn-success:hover{background:#0EA373;}
        .modal .btn-outline{background:transparent;border:1.5px solid #E2E8F0;padding:10px 24px;border-radius:40px;font-weight:600;font-size:14px;color:#475569;cursor:pointer;transition:.15s;font-family:'Inter',sans-serif;}
        .modal .btn-outline:hover{background:#F1F5F9;}

        @media(max-width:1280px){.split-layout{grid-template-columns:1fr 290px;}}
        @media(max-width:1024px){.split-layout{grid-template-columns:1fr;}.editor-panel{position:static;}}
        @media(max-width:768px){
            .sidebar{transform:translateX(-100%);width:270px;position:fixed;top:0;left:0;height:100%;}
            .sidebar.open{transform:translateX(0);}
            .menu-toggle{display:block!important;}
            .search-box{width:140px;}
            .content{padding:12px 14px;}
            .topbar{padding:12px 16px;}
        }
    </style>
</head>
<body>

<div id="printPortal"></div>

<!-- SIDEBAR -->
@include('admin.sidebar')
<div class="main">
    <header class="topbar">
        <div class="topbar-left">
            <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
            <div>
                <h2>Certificate Editor</h2>
                <div class="breadcrumb">Dashboard / Certificates / <span>{{ $certificate->certificate_no ?? 'Editor' }}</span></div>
            </div>
        </div>
        <div class="topbar-right">
            <div class="search-box"><i class="fas fa-search"></i><input type="text" placeholder="Search…"/></div>
            <button class="notif-btn"><i class="fas fa-bell"></i><span class="notif-badge">3</span></button>
            <div class="profile-dropdown-wrap">
                <button class="profile-btn" id="profileBtn">
                    <div class="profile-avatar">A</div>
                    <span>Admin</span>
                    <i class="fas fa-chevron-down" style="font-size:11px;margin-left:4px;color:#94A3B8;"></i>
                </button>
                <div class="dropdown-menu" id="profileDropdown">
                    <a href="#"><i class="fas fa-user"></i> View Profile</a>
                    <a href="#"><i class="fas fa-sliders-h"></i> Account Settings</a>
                    <a href="#"><i class="fas fa-key"></i> Change Password</a>
                    <div class="dropdown-divider"></div>
                    <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </div>
    </header>

    <div class="content">
        <div class="split-layout">

            <!-- PREVIEW PANEL -->
            <div class="preview-panel">
                <div class="preview-label">
                    <i class="fas fa-eye"></i> Live Preview — A4 Landscape (297 × 210 mm)
                    <span class="status-badge {{ $certificate->status ?? 'issued' }}">
                        {{ ucfirst($certificate->status ?? 'Issued') }}
                    </span>
                </div>
                <div class="cert-outer-wrapper" id="certOuterWrapper">
                    <div id="certScaleBox">

                        <!-- CERTIFICATE CANVAS -->
                        <div id="certCanvas">

                            <!-- White base -->
                            <div class="c-bg-white"></div>

                            <!-- GEOMETRIC SVG -->
                            <svg class="c-geo" viewBox="0 0 1122 794" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="gDark" x1="0" y1="0" x2="1" y2="1">
                                        <stop offset="0%" stop-color="#071B3B"/>
                                        <stop offset="100%" stop-color="#0D2B5E"/>
                                    </linearGradient>
                                    <linearGradient id="gDark2" x1="0" y1="0" x2="1" y2="0">
                                        <stop offset="0%" stop-color="#0D2B5E"/>
                                        <stop offset="100%" stop-color="#071B3B"/>
                                    </linearGradient>
                                    <linearGradient id="gGold" x1="0" y1="0" x2="1" y2="1">
                                        <stop offset="0%" stop-color="#D4AF37"/>
                                        <stop offset="100%" stop-color="#B8960C"/>
                                    </linearGradient>
                                    <linearGradient id="gGoldH" x1="0" y1="0" x2="1" y2="0">
                                        <stop offset="0%" stop-color="#D4AF37"/>
                                        <stop offset="100%" stop-color="#B8960C"/>
                                    </linearGradient>
                                    <linearGradient id="gMid" x1="0" y1="0" x2="1" y2="1">
                                        <stop offset="0%" stop-color="#1a3f7a"/>
                                        <stop offset="100%" stop-color="#0d2b5e"/>
                                    </linearGradient>
                                </defs>
                                <polygon points="0,0 280,0 0,220" fill="url(#gDark)"/>
                                <polygon points="0,0 210,0 0,160" fill="url(#gMid)" opacity="0.55"/>
                                <polygon points="240,0 280,0 0,260 0,220" fill="url(#gGold)" opacity="0.9"/>
                                <polygon points="1122,0 842,0 1122,220" fill="url(#gDark2)"/>
                                <polygon points="1122,0 912,0 1122,160" fill="url(#gMid)" opacity="0.55"/>
                                <polygon points="882,0 842,0 1122,260 1122,220" fill="url(#gGoldH)" opacity="0.9"/>
                                <polygon points="0,794 280,794 0,574" fill="url(#gDark)"/>
                                <polygon points="0,794 210,794 0,654" fill="url(#gMid)" opacity="0.55"/>
                                <polygon points="240,794 280,794 0,534 0,574" fill="url(#gGold)" opacity="0.9"/>
                                <polygon points="1122,794 842,794 1122,574" fill="url(#gDark2)"/>
                                <polygon points="1122,794 912,794 1122,654" fill="url(#gMid)" opacity="0.55"/>
                                <polygon points="882,794 842,794 1122,534 1122,574" fill="url(#gGoldH)" opacity="0.9"/>
                                <pattern id="dots" x="0" y="0" width="22" height="22" patternUnits="userSpaceOnUse">
                                    <circle cx="1" cy="1" r="0.7" fill="#071B3B" opacity="0.06"/>
                                </pattern>
                                <rect x="280" y="0" width="562" height="794" fill="url(#dots)"/>
                                <line x1="280" y1="40" x2="842" y2="40" stroke="#D4AF37" stroke-width="0.8" opacity="0.3"/>
                                <line x1="280" y1="754" x2="842" y2="754" stroke="#D4AF37" stroke-width="0.8" opacity="0.3"/>
                            </svg>

                            <!-- BORDERS -->
                            <div class="c-border-outer"></div>
                            <div class="c-border-inner"></div>

                            <!-- CORNER ORNAMENTS -->
                            <div class="c-corner tl">
                                <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 5 L5 26 M5 5 L26 5" stroke="#D4AF37" stroke-width="3.5" stroke-linecap="round"/>
                                    <path d="M13 13 L13 22 M13 13 L22 13" stroke="#D4AF37" stroke-width="1.5" stroke-linecap="round" opacity="0.5"/>
                                    <circle cx="5" cy="5" r="3.5" fill="#D4AF37"/>
                                    <circle cx="13" cy="13" r="1.8" fill="#D4AF37" opacity="0.55"/>
                                </svg>
                            </div>
                            <div class="c-corner tr">
                                <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 5 L5 26 M5 5 L26 5" stroke="#D4AF37" stroke-width="3.5" stroke-linecap="round"/>
                                    <path d="M13 13 L13 22 M13 13 L22 13" stroke="#D4AF37" stroke-width="1.5" stroke-linecap="round" opacity="0.5"/>
                                    <circle cx="5" cy="5" r="3.5" fill="#D4AF37"/>
                                    <circle cx="13" cy="13" r="1.8" fill="#D4AF37" opacity="0.55"/>
                                </svg>
                            </div>
                            <div class="c-corner bl">
                                <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 5 L5 26 M5 5 L26 5" stroke="#D4AF37" stroke-width="3.5" stroke-linecap="round"/>
                                    <path d="M13 13 L13 22 M13 13 L22 13" stroke="#D4AF37" stroke-width="1.5" stroke-linecap="round" opacity="0.5"/>
                                    <circle cx="5" cy="5" r="3.5" fill="#D4AF37"/>
                                    <circle cx="13" cy="13" r="1.8" fill="#D4AF37" opacity="0.55"/>
                                </svg>
                            </div>
                            <div class="c-corner br">
                                <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 5 L5 26 M5 5 L26 5" stroke="#D4AF37" stroke-width="3.5" stroke-linecap="round"/>
                                    <path d="M13 13 L13 22 M13 13 L22 13" stroke="#D4AF37" stroke-width="1.5" stroke-linecap="round" opacity="0.5"/>
                                    <circle cx="5" cy="5" r="3.5" fill="#D4AF37"/>
                                    <circle cx="13" cy="13" r="1.8" fill="#D4AF37" opacity="0.55"/>
                                </svg>
                            </div>

                            <!-- AWARD BADGE -->
                            <!-- <div class="c-badge">
                                <div class="c-badge-ring">
                                    <img class="c-badge-img" id="badgeImg" src="https://cdn.b12.io/client_media/sqZcMGxP/c4e2ba28-acd2-11ef-a4fa-0242ac110002-jpg-regular_image.jpeg" alt="Leeds Academy Award"/>
                                </div>
                            </div> -->

                            <!-- WATERMARK -->
                            <div class="c-watermark">
                                <img id="wmImg" src="https://cdn.b12.io/client_media/sqZcMGxP/c4e2ba28-acd2-11ef-a4fa-0242ac110002-jpg-regular_image.jpeg" alt="Leeds Academy watermark"/>
                            </div>

                            <!-- CONTENT -->
                            <div class="c-content">

                                <!-- Logo -->
                                <div class="c-logo">
                                    <img id="logoImg" src="https://cdn.b12.io/client_media/sqZcMGxP/c4e2ba28-acd2-11ef-a4fa-0242ac110002-jpg-regular_image.jpeg" alt="Leeds Academy Logo"/>
                                    <div class="c-org">Leeds institute</div>
                                </div>

                                <!-- Gold ornament -->
                                <div class="c-ornline">
                                    <span class="ol"></span>
                                    <span class="od"></span>
                                    <span class="odl"></span>
                                    <span class="od"></span>
                                    <span class="ol"></span>
                                </div>

                                <!-- Title -->
                                <div class="c-title-wrap">
                                    <span class="c-title-main">Certificate</span>
                                    <span class="c-title-eyebrow">of completion</span>
                                </div>

                                <!-- Sub divider -->
                                <div class="c-subdiv">
                                    <span class="sd-line"></span>
                                    <span class="sd-star">★ ★ ★</span>
                                    <span class="sd-line r"></span>
                                </div>

                                <!-- Presented to -->
                                <div class="c-presented">This Certificate is Proudly Presented To</div>

                                <!-- Student name -->
                                <div class="c-name" id="prevName">{{ $certificate->student_name ?? 'Student Name' }}</div>

                                <!-- Body text -->
                                <div class="c-body">
                                    For successfully completing the
                                    <span class="course-highlight" id="prevCourse">{{ strtoupper($certificate->course_name ?? 'COURSE') }}</span>
                                    course at Leeds Academy.<br>
                                    Awarded in recognition of dedication, commitment, perseverance, and successful achievement throughout the training program.
                                </div>

                                <!-- Info row -->
                                <div class="c-info">
                                    <div class="c-info-item">
                                        <span class="lbl">Certificate No.</span>
                                        <span class="val" id="prevCertNo">{{ $certificate->certificate_no ?? 'N/A' }}</span>
                                    </div>
                                    <div class="c-info-item">
                                        <span class="lbl">Student ID</span>
                                        <span class="val" id="prevStudentId">{{ $certificate->student_id ?? 'N/A' }}</span>
                                    </div>
                                    <div class="c-info-item">
                                        <span class="lbl">Issue Date</span>
                                        <span class="val" id="prevDate">{{ $certificate->issue_date ? $certificate->issue_date->format('d F Y') : date('d F Y') }}</span>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="c-footer">
                                    <div class="c-sig">
                                        <div class="s-line"></div>
                                        <div class="s-name">Course Organizer</div>
                                        <div class="s-lbl">Authorized Signature</div>
                                    </div>
                                    <div class="c-qr">
                                        <div class="q-box" id="qrCert"></div>
                                        <div class="q-lbl">Scan to Verify</div>
                                    </div>
                                    <div class="c-sig">
                                        <div class="s-line"></div>
                                        <div class="s-name">Director</div>
                                        <div class="s-lbl">Director's Signature</div>
                                    </div>
                                </div>

                            </div><!-- /c-content -->
                        </div><!-- /certCanvas -->
                    </div><!-- /certScaleBox -->
                </div><!-- /cert-outer-wrapper -->
            </div><!-- /preview-panel -->

            <!-- EDITOR PANEL -->
            <div class="editor-panel">
                <h4><i class="fas fa-pen-fancy"></i> Certificate Editor</h4>

                <div class="eg">
                    <label>Student Name</label>
                    <input type="text" id="eStudent" value="{{ $certificate->student_name ?? '' }}" oninput="update()">
                </div>
                <div class="eg">
                    <label>Course Name</label>
                    <input type="text" id="eCourse" value="{{ $certificate->course_name ?? '' }}" oninput="update()">
                </div>
                <div class="eg">
                    <label>Issue Date</label>
                    <input type="date" id="eDate" value="{{ $certificate->issue_date ? $certificate->issue_date->format('Y-m-d') : date('Y-m-d') }}" oninput="update()">
                </div>
                <div class="eg">
                    <label>Certificate Number</label>
                    <input type="text" id="eCertNo" value="{{ $certificate->certificate_no ?? '' }}" oninput="update()">
                </div>
                <div class="eg">
                    <label>Student ID</label>
                    <input type="text" id="eStudentId" value="{{ $certificate->student_id ?? '' }}" oninput="update()">
                </div>
                <div class="eg">
                    <label>Status</label>
                    <input type="text" id="eStatus" value="{{ ucfirst($certificate->status ?? 'Issued') }}" disabled style="background:#F1F5F9; color:#64748B;">
                </div>

                <div class="ea">
                    <button class="btn green" onclick="openUpdateModal()"><i class="fas fa-edit"></i> Update</button>
                    <button class="btn" onclick="printCert()"><i class="fas fa-print"></i> Print</button>
                    <button class="btn blue" onclick="exportPDF()"><i class="fas fa-file-pdf"></i> PDF</button>
                    <button class="btn amber" onclick="exportPNG()"><i class="fas fa-image"></i> PNG</button>
                    <button class="btn-o" onclick="window.location.href='{{ route('admin.certificates.index') }}'"><i class="fas fa-arrow-left"></i> Back</button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- UPDATE MODAL -->
<div class="modal-overlay" id="updateModal">
    <div class="modal">
        <div class="modal-header">
            <h2><i class="fas fa-edit" style="color:#6D4AFF;"></i> Update Certificate</h2>
            <button class="modal-close" onclick="closeModal('updateModal')"><i class="fas fa-times"></i></button>
        </div>
        <div class="eg">
            <label>Student Name</label>
            <input type="text" id="modalStudent" value="{{ $certificate->student_name ?? '' }}">
        </div>
        <div class="eg">
            <label>Course Name</label>
            <input type="text" id="modalCourse" value="{{ $certificate->course_name ?? '' }}">
        </div>
        <div class="eg">
            <label>Issue Date</label>
            <input type="date" id="modalDate" value="{{ $certificate->issue_date ? $certificate->issue_date->format('Y-m-d') : date('Y-m-d') }}">
        </div>
        <div class="eg">
            <label>Certificate Number</label>
            <input type="text" id="modalCertNo" value="{{ $certificate->certificate_no ?? '' }}">
        </div>
        <div class="eg">
            <label>Student ID</label>
            <input type="text" id="modalStudentId" value="{{ $certificate->student_id ?? '' }}">
        </div>
        <div class="eg">
            <label>Status</label>
            <select id="modalStatus" style="width:100%; padding:9px 12px; border-radius:10px; border:1.5px solid #E2E8F0; font-size:13px; font-family:'Inter',sans-serif; background:#F8FAFC;">
                <option value="issued" {{ ($certificate->status ?? 'issued') == 'issued' ? 'selected' : '' }}>Issued</option>
                <option value="verified" {{ ($certificate->status ?? '') == 'verified' ? 'selected' : '' }}>Verified</option>
                <option value="pending" {{ ($certificate->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>
        <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:20px; padding-top:16px; border-top:1px solid #F1F5F9;">
            <button class="btn-outline" onclick="closeModal('updateModal')">Cancel</button>
            <button class="btn-success" onclick="updateCertificate()"><i class="fas fa-save"></i> Update Certificate</button>
        </div>
    </div>
</div>

<div class="overlay" id="overlay"></div>
<div class="toast" id="toast"><i class="fas fa-check-circle"></i><span id="toastMsg"></span></div>

<script>
    // Get CSRF token
    function getCSRFToken() {
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }

    // ─── LOGO URL ───
    const LOGO_URL = 'https://cdn.b12.io/client_media/sqZcMGxP/c4e2ba28-acd2-11ef-a4fa-0242ac110002-jpg-regular_image.jpeg';
    let LOGO_B64 = null;

    function fetchLogoB64(cb){
        if(LOGO_B64){ cb(LOGO_B64); return; }
        var img = new Image();
        img.crossOrigin = 'anonymous';
        img.onload = function(){
            var c = document.createElement('canvas');
            c.width = img.naturalWidth; c.height = img.naturalHeight;
            c.getContext('2d').drawImage(img,0,0);
            try{ LOGO_B64 = c.toDataURL('image/jpeg'); }catch(e){ LOGO_B64 = LOGO_URL; }
            cb(LOGO_B64);
        };
        img.onerror = function(){ LOGO_B64 = LOGO_URL; cb(LOGO_B64); };
        img.src = LOGO_URL + '?v=' + Date.now();
    }

    function applyLogos(){
        ['logoImg','wmImg','badgeImg'].forEach(function(id){
            var el = document.getElementById(id);
            if(el) el.src = LOGO_URL;
        });
        fetchLogoB64(function(){});
    }

    function applyLogosB64(b64){
        ['logoImg','wmImg','badgeImg'].forEach(function(id){
            var el = document.getElementById(id);
            if(el) el.src = b64;
        });
    }

    // ─── SCALE SYSTEM ───
    const CERT_W = 1122, CERT_H = 794;

    function scaleCert(){
        var wrapper = document.getElementById('certOuterWrapper');
        var box     = document.getElementById('certScaleBox');
        if(!wrapper||!box) return;
        var availW = wrapper.clientWidth;
        var scale  = availW / CERT_W;
        box.style.transform       = 'scale('+scale+')';
        box.style.transformOrigin = 'top left';
        wrapper.style.height      = (CERT_H * scale) + 'px';
    }
    var _scaleRaf;
    function debouncedScale(){
        cancelAnimationFrame(_scaleRaf);
        _scaleRaf = requestAnimationFrame(scaleCert);
    }
    window.addEventListener('resize', debouncedScale);
    if(window.ResizeObserver){
        new ResizeObserver(debouncedScale).observe(document.getElementById('certOuterWrapper'));
    }

    // ─── SIDEBAR / DROPDOWN ───
    document.getElementById('menuToggle').addEventListener('click',function(){
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('overlay').classList.toggle('active');
    });
    document.getElementById('overlay').addEventListener('click',function(){
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('overlay').classList.remove('active');
    });
    document.getElementById('profileBtn').addEventListener('click',function(e){
        e.stopPropagation();
        document.getElementById('profileDropdown').classList.toggle('open');
    });
    document.addEventListener('click',function(){
        document.getElementById('profileDropdown').classList.remove('open');
    });

    // ─── TOAST ───
    function toast(msg){
        var t = document.getElementById('toast');
        document.getElementById('toastMsg').textContent = msg;
        t.classList.add('show');
        clearTimeout(t._t);
        t._t = setTimeout(function(){ t.classList.remove('show'); }, 3600);
    }

    // ─── QR CODE ───
    function buildQR(){
        var certno = document.getElementById('eCertNo').value || 'CERT-0000';
        var verifyUrl = '{{ url("/certificates/verify") }}/' + certno;

        var qrContainer = document.getElementById('qrCert');
        if(qrContainer){
            qrContainer.innerHTML = '';
            try{
                // Create QR with larger size for better scanning
                var qr = new QRCode(qrContainer, {
                    text: verifyUrl,
                    width: 72,
                    height: 72,
                    colorDark: '#071B3B',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.L  // Low error correction = denser but clearer
                });
                // Make sure canvas fills container
                var canvas = qrContainer.querySelector('canvas');
                if(canvas) {
                    canvas.style.width = '100%';
                    canvas.style.height = '100%';
                }
            } catch(e){
                qrContainer.innerHTML = '<i class="fas fa-qrcode" style="color:#071B3B;font-size:40px;"></i>';
                console.error('QR Error:', e);
            }
        }
    }

    // ─── UPDATE PREVIEW ───
    function update(){
        var student = document.getElementById('eStudent').value || 'Student Name';
        var course  = document.getElementById('eCourse').value  || 'Course Name';
        var studentId = document.getElementById('eStudentId').value || 'STU-0000';
        var certno  = document.getElementById('eCertNo').value  || 'CERT-0000';
        var raw     = document.getElementById('eDate').value    || '2026-01-01';
        var d = new Date(raw+'T00:00:00');
        var fmt = d.toLocaleDateString('en-GB',{day:'2-digit',month:'long',year:'numeric'});

        document.getElementById('prevName').textContent   = student;
        document.getElementById('prevCourse').textContent = course.toUpperCase();
        document.getElementById('prevStudentId').textContent = studentId;
        document.getElementById('prevCertNo').textContent = certno;
        document.getElementById('prevDate').textContent   = fmt;
        buildQR();
    }

    // ─── MODAL FUNCTIONS ───
    function openModal(id) {
        document.getElementById(id).classList.add('active');
        document.getElementById('modalStudent').value = document.getElementById('eStudent').value;
        document.getElementById('modalCourse').value = document.getElementById('eCourse').value;
        document.getElementById('modalDate').value = document.getElementById('eDate').value;
        document.getElementById('modalCertNo').value = document.getElementById('eCertNo').value;
        document.getElementById('modalStudentId').value = document.getElementById('eStudentId').value;
        document.getElementById('modalStatus').value = document.getElementById('eStatus').value.toLowerCase();
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }

    function openUpdateModal() {
        openModal('updateModal');
    }

    // ─── UPDATE CERTIFICATE ───
    async function updateCertificate() {
        const id = {{ $certificate->id ?? 0 }};
        if (!id) {
            toast('⚠️ Certificate ID not found');
            return;
        }

        const data = {
            student_name: document.getElementById('modalStudent').value,
            course_name: document.getElementById('modalCourse').value,
            issue_date: document.getElementById('modalDate').value,
            certificate_no: document.getElementById('modalCertNo').value,
            student_id: document.getElementById('modalStudentId').value,
            status: document.getElementById('modalStatus').value,
            title: 'Certificate of Completion'
        };

        try {
            const response = await fetch(`/admin/certificates/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': getCSRFToken(),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            if (result.success) {
                toast('✅ ' + result.message);
                closeModal('updateModal');
                document.getElementById('eStudent').value = data.student_name;
                document.getElementById('eCourse').value = data.course_name;
                document.getElementById('eDate').value = data.issue_date;
                document.getElementById('eCertNo').value = data.certificate_no;
                document.getElementById('eStudentId').value = data.student_id;
                document.getElementById('eStatus').value = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                update();
                setTimeout(() => window.location.reload(), 1000);
            } else {
                toast('⚠️ ' + (result.message || 'Failed to update'));
            }
        } catch (error) {
            console.error('Error:', error);
            toast('⚠️ Failed to update certificate');
        }
    }

    // ─── PRINT ───
    function printCert(){
        var portal = document.getElementById('printPortal');
        var canvas = document.getElementById('certCanvas');
        var clone  = canvas.cloneNode(true);
        fetchLogoB64(function(b64){
            clone.querySelectorAll('img').forEach(function(img){ img.src = b64; });
            
            var certno = document.getElementById('eCertNo').value || 'CERT-0000';
            var verifyUrl = '{{ url("/certificates/verify") }}/' + certno;
            
            var qrEl = clone.querySelector('#qrCert');
            if(qrEl){
                qrEl.innerHTML = '';
                try{
                    new QRCode(qrEl, {
                        text: verifyUrl,
                        width: 80,
                        height: 80,
                        colorDark: '#071B3B',
                        colorLight: '#ffffff',
                        correctLevel: QRCode.CorrectLevel.L
                    });
                } catch(e){
                    qrEl.innerHTML = '<i class="fas fa-qrcode" style="color:#071B3B;font-size:40px;"></i>';
                }
            }
            
            portal.innerHTML = '';
            portal.appendChild(clone);
            portal.style.display = 'block';
            setTimeout(function(){
                window.print();
                setTimeout(function(){ portal.style.display='none'; portal.innerHTML=''; },1000);
            },500);
        });
    }

    // ─── CAPTURE FOR EXPORT ───
    function captureCanvas(cb){
        // First rebuild QR with high quality
        buildQR();
        
        setTimeout(function(){
            fetchLogoB64(function(b64){
                applyLogosB64(b64);
                var box   = document.getElementById('certScaleBox');
                var saved = box.style.transform;
                box.style.transform = 'none';
                document.getElementById('certOuterWrapper').style.height = CERT_H+'px';
                
                // Force QR to be visible
                var qrContainer = document.getElementById('qrCert');
                if(qrContainer) {
                    qrContainer.style.display = 'flex';
                }
                
                requestAnimationFrame(function(){
                    setTimeout(function(){
                        html2canvas(document.getElementById('certCanvas'),{
                            scale: 3,
                            useCORS: true,
                            allowTaint: true,
                            logging: false,
                            backgroundColor: '#ffffff',
                            width: CERT_W,
                            height: CERT_H,
                            scrollX: 0,
                            scrollY: 0,
                            windowWidth: CERT_W,
                            windowHeight: CERT_H,
                            onclone: function(clonedDoc) {
                                // Ensure QR is rendered in clone
                                var clonedQR = clonedDoc.getElementById('qrCert');
                                if(clonedQR) {
                                    clonedQR.style.display = 'flex';
                                }
                            }
                        }).then(function(cvs){
                            box.style.transform = saved;
                            scaleCert();
                            applyLogos();
                            cb(cvs);
                        }).catch(function(err){
                            box.style.transform = saved;
                            scaleCert();
                            applyLogos();
                            toast('❌ Export error: '+err.message);
                            console.error('Export error:', err);
                        });
                    }, 600);
                });
            });
        }, 300);
    }

    // ─── PDF EXPORT ───
    function exportPDF(){
        toast('⏳ Generating PDF…');
        captureCanvas(function(cvs){
            try {
                var img = cvs.toDataURL('image/png');
                var pdf = new jspdf.jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: 'a4'
                });
                pdf.addImage(img, 'PNG', 0, 0, 297, 210, undefined, 'FAST');
                pdf.save('leeds_certificate.pdf');
                toast('📄 PDF downloaded!');
            } catch(e) {
                console.error('PDF Error:', e);
                toast('❌ PDF generation failed: ' + e.message);
            }
        });
    }

    // ─── PNG EXPORT ───
    function exportPNG(){
        toast('⏳ Generating PNG…');
        captureCanvas(function(cvs){
            try {
                var a = document.createElement('a');
                a.download = 'leeds_certificate.png';
                a.href = cvs.toDataURL('image/png');
                a.click();
                toast('🖼️ PNG downloaded!');
            } catch(e) {
                console.error('PNG Error:', e);
                toast('❌ PNG generation failed: ' + e.message);
            }
        });
    }

    // ─── INIT ───
    window.addEventListener('load',function(){
        applyLogos();
        setTimeout(function(){
            update();
            scaleCert();
        }, 400);
    });
</script>
</body>
</html>