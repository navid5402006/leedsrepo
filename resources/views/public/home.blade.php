<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
  <title>{{ $settings['institute']['name'] ?? 'Leeds Institute' }} – Empowering Future Leaders</title>
  <meta name="description" content="{{ $settings['institute']['about_description'] ?? 'Leeds Institute offers quality education with experienced faculty, modern facilities, and a proven track record of student success.' }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />

  <style>
    /* ─── ROOT TOKENS ─── */
    :root {
      --navy: #0B3C6D;
      --navy2: #07284a;
      --yellow: #FFC107;
      --yellow2: #e6ac00;
      --red: #E53935;
      --white: #ffffff;
      --gray-50: #f8fafc;
      --gray-100: #f1f5f9;
      --gray-200: #e2e8f0;
      --gray-300: #cbd5e1;
      --gray-400: #94a3b8;
      --gray-600: #475569;
      --gray-800: #1e293b;
      --radius: 12px;
      --radius-lg: 20px;
      --radius-xl: 28px;
      --shadow-sm: 0 2px 12px rgba(11,60,109,.08);
      --shadow: 0 8px 32px rgba(11,60,109,.14);
      --shadow-lg: 0 20px 60px rgba(11,60,109,.18);
      --transition: .3s cubic-bezier(.4,0,.2,1);
    }

    /* ─── RESET & BASE ─── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; font-size: 16px; overflow-x: hidden; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: var(--gray-800);
      background: var(--white);
      overflow-x: hidden;
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      width: 100%;
    }
    img { max-width: 100%; display: block; }
    a { text-decoration: none; color: inherit; }
    ul { list-style: none; }

    .container {
      max-width: 1240px;
      margin: 0 auto;
      padding: 0 20px;
      width: 100%;
    }

    /* ─── BUTTONS ─── */
    .btn {
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
      padding: 13px 28px; border-radius: 50px; font-weight: 700;
      font-size: .9rem; letter-spacing: .3px; cursor: pointer;
      border: none; transition: var(--transition);
      font-family: inherit;
    }
    .btn-primary {
      background: var(--yellow); color: var(--navy2);
      box-shadow: 0 4px 20px rgba(255,193,7,.4);
    }
    .btn-primary:hover { background: var(--yellow2); transform: translateY(-2px); box-shadow: 0 8px 28px rgba(255,193,7,.5); }
    .btn-outline {
      background: transparent; color: var(--white);
      border: 2px solid rgba(255,255,255,.7);
    }
    .btn-outline:hover { background: rgba(255,255,255,.1); border-color: var(--white); transform: translateY(-2px); }
    .btn-navy { background: var(--navy); color: var(--white); box-shadow: var(--shadow-sm); }
    .btn-navy:hover { background: var(--navy2); transform: translateY(-2px); box-shadow: var(--shadow); }

    /* ─── SECTION HEADERS ─── */
    .section-tag {
      display: inline-flex; align-items: center; gap: 8px;
      background: rgba(11,60,109,.08); color: var(--navy);
      padding: 6px 16px; border-radius: 50px;
      font-size: .8rem; font-weight: 700; letter-spacing: 1px;
      text-transform: uppercase; margin-bottom: 14px;
    }
    .section-tag i { color: var(--yellow); }
    .section-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(1.8rem, 4vw, 2.6rem);
      font-weight: 800; color: var(--navy);
      line-height: 1.22;
    }
    .section-title span { color: var(--red); }
    .section-sub {
      font-size: 1rem; color: var(--gray-600);
      max-width: 560px; line-height: 1.75; margin-top: 12px;
    }
    .text-center .section-sub { margin-left: auto; margin-right: auto; }

    .accent-bar {
      width: 52px; height: 4px; border-radius: 2px;
      background: var(--yellow); margin: 16px 0 0;
    }
    .text-center .accent-bar { margin-left: auto; margin-right: auto; }

    section { padding: 90px 0; }

    /* ─── CARDS ─── */
    .card-premium {
      background: var(--white);
      border-radius: var(--radius-xl);
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
      overflow: hidden;
      border: 1px solid rgba(0,0,0,.04);
    }
    .card-premium:hover { transform: translateY(-6px); box-shadow: var(--shadow); }

    /* ═══════════════════════════════════════════════════
       HEADER
    ═══════════════════════════════════════════════════ */
    #header {
      position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
      transition: var(--transition);
      padding: 0;
      width: 100%;
    }
    #header.scrolled {
      background: var(--navy2);
      box-shadow: 0 4px 24px rgba(11,60,109,.25);
    }
    .nav-inner {
      display: flex; align-items: center;
      padding: 16px 0; gap: 32px;
      width: 100%;
    }
    .logo {
      display: flex; align-items: center; gap: 12px; flex-shrink: 0;
    }
    .logo-mark {
      width: 48px; height: 48px; background: var(--yellow);
      border-radius: 12px; display: flex; align-items: center;
      justify-content: center; font-weight: 900; font-size: 1.4rem;
      color: var(--navy); letter-spacing: -1px; flex-shrink: 0;
    }
    .logo-text { line-height: 1.2; }
    .logo-text strong {
      display: block; color: var(--white);
      font-size: 1.05rem; font-weight: 800;
    }
    .logo-text span { color: var(--yellow); font-size: .72rem; letter-spacing: 1px; text-transform: uppercase; font-weight: 600; }

    nav { flex: 1; }
    .nav-list {
      display: flex; gap: 4px; align-items: center;
    }
    .nav-list a {
      padding: 8px 13px; border-radius: 8px;
      font-size: .88rem; font-weight: 600; color: rgba(255,255,255,.85);
      transition: var(--transition); white-space: nowrap;
    }
    .nav-list a:hover, .nav-list a.active {
      background: rgba(255,255,255,.1); color: var(--white);
    }
    .nav-actions { display: flex; gap: 10px; flex-shrink: 0; }
    .nav-actions .btn { padding: 10px 20px; font-size: .83rem; }

    /* ─── HAMBURGER (Right side on mobile) ─── */
    .hamburger {
      display: none; flex-direction: column; gap: 5px; cursor: pointer;
      padding: 6px; background: none; border: none;
      flex-shrink: 0;
      margin-left: auto;
      position: relative;
      z-index: 1001;
    }
    .hamburger span {
      display: block; height: 2px; width: 24px;
      background: var(--white); border-radius: 2px; transition: var(--transition);
    }

    /* ─── MOBILE SIDEBAR NAV (Left Drawer) ─── */
    .mobile-overlay {
      display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,.5); z-index: 999; opacity: 0;
      transition: opacity .3s ease;
    }
    .mobile-overlay.open {
      display: block; opacity: 1;
    }
    .mobile-nav {
      position: fixed; top: 0; left: -300px; bottom: 0;
      width: 280px; background: var(--navy2); z-index: 1000;
      padding: 24px 20px 30px;
      transition: left .35s cubic-bezier(.4,0,.2,1);
      overflow-y: auto;
      box-shadow: 4px 0 30px rgba(0,0,0,.3);
    }
    .mobile-nav.open { left: 0; }
    .mobile-nav-header {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 30px; padding-bottom: 16px;
      border-bottom: 1px solid rgba(255,255,255,.08);
    }
    .mobile-nav-brand {
      display: flex; align-items: center; gap: 10px;
    }
    .mobile-nav-brand .logo-mark-sm {
      width: 36px; height: 36px; background: var(--yellow);
      border-radius: 10px; display: flex; align-items: center;
      justify-content: center; font-weight: 900; font-size: 1rem;
      color: var(--navy);
    }
    .mobile-nav-brand span {
      color: var(--white); font-weight: 700; font-size: .9rem;
    }
    .mobile-nav-close {
      width: 36px; height: 36px; border-radius: 50%;
      background: rgba(255,255,255,.08); border: none;
      color: var(--white); font-size: 1rem; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: var(--transition);
    }
    .mobile-nav-close:hover { background: var(--red); }
    .mobile-nav a {
      display: block; font-size: .95rem; font-weight: 600;
      color: rgba(255,255,255,.8); padding: 12px 14px;
      border-radius: 10px; transition: var(--transition);
      margin-bottom: 2px;
    }
    .mobile-nav a:active { background: rgba(255,255,255,.08); color: var(--yellow); }
    .mobile-nav a i { width: 24px; color: var(--yellow); margin-right: 10px; }

    /* ═══════════════════════════════════════════════════
       HERO
    ═══════════════════════════════════════════════════ */
    #hero {
      min-height: 100vh; position: relative;
      background: linear-gradient(135deg, #071e36 0%, #0B3C6D 45%, #1565a0 100%);
      display: flex; align-items: center; overflow: hidden;
      padding-top: 80px;
    }
    #hero::before {
      content: ''; position: absolute; inset: 0;
      background-image:
        radial-gradient(circle at 20% 80%, rgba(255,193,7,.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(229,57,53,.08) 0%, transparent 50%),
        url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
      pointer-events: none;
    }
    .hero-inner {
      display: grid; grid-template-columns: 1fr 1fr;
      gap: 60px; align-items: center; position: relative; z-index: 2;
      padding: 60px 0;
    }
    .hero-badge {
      display: inline-flex; align-items: center; gap: 8px;
      background: rgba(255,193,7,.15); border: 1px solid rgba(255,193,7,.3);
      color: var(--yellow); padding: 7px 16px; border-radius: 50px;
      font-size: .8rem; font-weight: 700; letter-spacing: 1px;
      text-transform: uppercase; margin-bottom: 24px;
      animation: pulse-badge 2.5s ease-in-out infinite;
    }
    @keyframes pulse-badge {
      0%, 100% { box-shadow: 0 0 0 0 rgba(255,193,7,.3); }
      50% { box-shadow: 0 0 0 8px rgba(255,193,7,0); }
    }
    .hero-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2.2rem, 5vw, 3.6rem);
      font-weight: 800; color: var(--white);
      line-height: 1.15; margin-bottom: 24px;
    }
    .hero-title .highlight {
      color: var(--yellow);
      text-shadow: 0 0 40px rgba(255,193,7,.5);
    }
    .hero-sub {
      color: rgba(255,255,255,.78); font-size: 1.05rem;
      line-height: 1.8; margin-bottom: 36px;
    }
    .hero-btns { display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 48px; }
    .hero-stats { display: flex; gap: 32px; flex-wrap: wrap; }
    .hero-stat-num {
      font-size: 1.8rem; font-weight: 800; color: var(--yellow); line-height: 1;
    }
    .hero-stat-label { color: rgba(255,255,255,.65); font-size: .8rem; font-weight: 500; margin-top: 2px; }

    .hero-visual {
      position: relative; display: flex; justify-content: center;
    }
    .hero-img-frame {
      width: 100%; max-width: 440px;
      background: rgba(255,255,255,.06);
      border: 1px solid rgba(255,255,255,.12);
      border-radius: 24px; padding: 20px;
      backdrop-filter: blur(10px);
      position: relative;
    }
    .hero-campus-img {
      border-radius: 16px; overflow: hidden;
      height: 300px;
    }
    .hero-campus-img img {
      width: 100%; height: 100%; object-fit: cover;
    }
    .float-card {
      position: absolute; background: var(--white);
      border-radius: 14px; padding: 12px 16px;
      box-shadow: var(--shadow); display: flex; align-items: center; gap: 10px;
      font-size: .82rem; font-weight: 600; white-space: nowrap;
      animation: float 3s ease-in-out infinite;
    }
    .float-card:nth-child(2) { animation-delay: -.8s; }
    .float-card:nth-child(3) { animation-delay: -1.6s; }
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
    .float-card .icon {
      width: 36px; height: 36px; border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1rem; flex-shrink: 0;
    }
    .fc-1 { top: -20px; left: -30px; }
    .fc-1 .icon { background: rgba(11,60,109,.1); color: var(--navy); }
    .fc-2 { bottom: 20px; right: -30px; }
    .fc-2 .icon { background: rgba(255,193,7,.15); color: var(--yellow2); }
    .fc-3 { top: 50%; left: -40px; transform: translateY(-50%); }
    .fc-3 .icon { background: rgba(229,57,53,.1); color: var(--red); }

    .scroll-hint {
      position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%);
      display: flex; flex-direction: column; align-items: center; gap: 6px;
      color: rgba(255,255,255,.5); font-size: .72rem; letter-spacing: 1px;
      text-transform: uppercase; z-index: 3;
      animation: bounce 2s ease-in-out infinite;
    }
    @keyframes bounce { 0%,100%{transform:translateX(-50%) translateY(0)} 50%{transform:translateX(-50%) translateY(8px)} }
    .scroll-hint i { font-size: .9rem; }

    /* ═══════════════════════════════════════════════════
       WHY CHOOSE
    ═══════════════════════════════════════════════════ */
    #why { background: var(--gray-50); }
    .why-grid {
      display: grid; grid-template-columns: repeat(3, 1fr);
      gap: 24px; margin-top: 52px;
    }
    .why-card {
      background: var(--white); border-radius: var(--radius-lg);
      padding: 32px 28px; box-shadow: var(--shadow-sm);
      border: 1px solid var(--gray-200);
      transition: var(--transition); position: relative; overflow: hidden;
      cursor: default;
    }
    .why-card::after {
      content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
      background: var(--yellow); transform: scaleX(0); transform-origin: left;
      transition: var(--transition);
    }
    .why-card:hover { transform: translateY(-6px); box-shadow: var(--shadow); border-color: transparent; }
    .why-card:hover::after { transform: scaleX(1); }
    .why-icon {
      width: 60px; height: 60px; border-radius: 16px;
      background: rgba(11,60,109,.08); color: var(--navy);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.5rem; margin-bottom: 20px;
      transition: var(--transition);
    }
    .why-card:hover .why-icon { background: var(--navy); color: var(--yellow); }
    .why-card h3 { font-size: 1.05rem; font-weight: 700; color: var(--navy); margin-bottom: 8px; }
    .why-card p { font-size: .88rem; color: var(--gray-600); line-height: 1.7; }

    /* ═══════════════════════════════════════════════════
       ABOUT
    ═══════════════════════════════════════════════════ */
    #about { background: var(--white); }
    .about-grid {
      display: grid; grid-template-columns: 1fr 1fr;
      gap: 70px; align-items: center;
    }
    .about-img-wrap { position: relative; }
    .about-img-main {
      border-radius: var(--radius-lg); overflow: hidden;
      height: 460px;
    }
    .about-img-main img {
      width: 100%; height: 100%; object-fit: cover;
    }
    .about-badge-float {
      position: absolute; bottom: -20px; right: -20px;
      background: var(--yellow); border-radius: 16px; padding: 20px 24px;
      box-shadow: var(--shadow); text-align: center;
    }
    .about-badge-float .num { font-size: 2rem; font-weight: 800; color: var(--navy); line-height: 1; }
    .about-badge-float .lbl { font-size: .78rem; font-weight: 600; color: var(--navy2); margin-top: 2px; }
    .about-pills { display: flex; gap: 10px; flex-wrap: wrap; margin: 24px 0; }
    .pill {
      background: rgba(11,60,109,.07); color: var(--navy);
      padding: 6px 16px; border-radius: 50px; font-size: .82rem; font-weight: 600;
    }
    .about-list { margin: 18px 0 28px; display: flex; flex-direction: column; gap: 10px; }
    .about-list li {
      display: flex; align-items: flex-start; gap: 12px;
      font-size: .92rem; color: var(--gray-600);
    }
    .about-list li i { color: var(--yellow2); margin-top: 3px; flex-shrink: 0; }

    /* ═══════════════════════════════════════════════════
       CEO
    ═══════════════════════════════════════════════════ */
    #ceo {
      background: linear-gradient(135deg, var(--navy2) 0%, #0B3C6D 60%, #1565a0 100%);
      position: relative; overflow: hidden;
    }
    #ceo::before {
      content: '"'; position: absolute; top: -40px; left: 40px;
      font-size: 28rem; font-family: 'Playfair Display', serif;
      color: rgba(255,255,255,.04); line-height: 1; pointer-events: none;
    }
    .ceo-inner {
      display: grid; grid-template-columns: 360px 1fr;
      gap: 70px; align-items: center;
    }
    .ceo-photo-wrap { position: relative; text-align: center; }
    .ceo-photo {
      width: 240px; height: 240px; border-radius: 50%;
      border: 5px solid var(--yellow);
      margin: 0 auto 20px; overflow: hidden;
    }
    .ceo-photo img {
      width: 100%; height: 100%; object-fit: cover;
    }
    .ceo-name { font-size: 1.15rem; font-weight: 800; color: var(--white); }
    .ceo-role { color: var(--yellow); font-size: .85rem; font-weight: 600; margin-top: 4px; }
    .ceo-content { position: relative; }
    .ceo-quote-mark { font-size: 4rem; color: var(--yellow); line-height: .6; font-family: 'Playfair Display', serif; display: block; margin-bottom: 12px; }
    .ceo-message {
      font-size: 1.05rem; color: rgba(255,255,255,.85); line-height: 1.85;
      font-style: italic;
    }
    .ceo-sig {
      margin-top: 28px; display: flex; align-items: center; gap: 16px;
    }
    .ceo-sig-line { flex: 1; height: 1px; background: rgba(255,255,255,.15); }
    .ceo-sig-text { color: var(--yellow); font-weight: 700; font-size: .9rem; }

    /* ═══════════════════════════════════════════════════
       TEACHERS
    ═══════════════════════════════════════════════════ */
    #teachers { background: var(--gray-50); }
    .teachers-grid {
      display: grid; grid-template-columns: repeat(4, 1fr);
      gap: 24px; margin-top: 52px;
    }
    .teacher-card {
      background: var(--white); border-radius: var(--radius-lg);
      overflow: hidden; box-shadow: var(--shadow-sm);
      border: 1px solid var(--gray-200); transition: var(--transition);
      text-align: center;
    }
    .teacher-card:hover { transform: translateY(-8px); box-shadow: var(--shadow); }
    .teacher-photo {
      height: 200px; overflow: hidden;
    }
    .teacher-photo img {
      width: 100%; height: 100%; object-fit: cover; object-position: top;
    }
    .teacher-info { padding: 18px 16px 22px; }
    .teacher-name { font-size: 1rem; font-weight: 700; color: var(--navy); }
    .teacher-subject {
      display: inline-block; background: rgba(255,193,7,.15);
      color: var(--navy2); font-size: .75rem; font-weight: 700;
      padding: 3px 12px; border-radius: 50px; margin-top: 8px;
    }

    /* ═══════════════════════════════════════════════════
       COURSES
    ═══════════════════════════════════════════════════ */
    #courses { background: var(--white); }
    .courses-grid {
      display: grid; grid-template-columns: repeat(3, 1fr);
      gap: 28px; margin-top: 52px;
    }
    .course-card {
      border-radius: var(--radius-lg); overflow: hidden;
      box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200);
      transition: var(--transition); display: flex; flex-direction: column;
    }
    .course-card:hover { transform: translateY(-6px); box-shadow: var(--shadow); }
    .course-img {
      height: 180px; position: relative; overflow: hidden;
      display: flex; align-items: center; justify-content: center; font-size: 3.5rem;
    }
    .course-img-bg { position: absolute; inset: 0; opacity: .85; }
    .course-badge {
      position: absolute; top: 14px; left: 14px;
      background: var(--yellow); color: var(--navy); font-size: .72rem;
      font-weight: 700; padding: 4px 12px; border-radius: 50px;
    }
    .course-body { padding: 22px 22px 18px; flex: 1; display: flex; flex-direction: column; }
    .course-title { font-size: 1.05rem; font-weight: 700; color: var(--navy); margin-bottom: 8px; }
    .course-desc { font-size: .85rem; color: var(--gray-600); line-height: 1.65; flex: 1; margin-bottom: 14px; }
    .course-meta {
      display: flex; gap: 16px; font-size: .8rem; color: var(--gray-600);
      margin-bottom: 18px; padding-top: 14px; border-top: 1px solid var(--gray-100);
    }
    .course-meta span { display: flex; align-items: center; gap: 5px; }
    .course-meta i { color: var(--navy); }
    .course-footer {
      display: flex; align-items: center; justify-content: space-between;
    }
    .course-fee { font-size: 1.1rem; font-weight: 800; color: var(--navy); }
    .course-fee small { font-size: .7rem; font-weight: 500; color: var(--gray-400); display: block; }

    /* ═══════════════════════════════════════════════════
       ADMISSION
    ═══════════════════════════════════════════════════ */
    #admissions { background: var(--gray-50); }
    .admission-steps {
      display: grid; grid-template-columns: repeat(5, 1fr);
      gap: 0; margin-top: 52px; position: relative;
    }
    .admission-steps::before {
      content: ''; position: absolute; top: 44px; left: 10%; right: 10%; height: 2px;
      background: linear-gradient(90deg, var(--yellow), var(--navy));
      z-index: 0;
    }
    .adm-step {
      text-align: center; position: relative; z-index: 1; padding: 0 10px;
    }
    .adm-circle {
      width: 90px; height: 90px; border-radius: 50%;
      background: var(--white); border: 3px solid var(--gray-200);
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 18px; font-size: 1.5rem; color: var(--gray-400);
      transition: var(--transition); box-shadow: var(--shadow-sm); position: relative;
    }
    .adm-step.active .adm-circle {
      background: var(--navy); border-color: var(--navy); color: var(--yellow);
      box-shadow: 0 8px 24px rgba(11,60,109,.3);
    }
    .adm-step:hover .adm-circle {
      background: var(--yellow); border-color: var(--yellow); color: var(--navy);
      transform: scale(1.08);
    }
    .adm-num {
      position: absolute; top: -8px; right: -4px;
      width: 26px; height: 26px; background: var(--red); color: var(--white);
      border-radius: 50%; font-size: .72rem; font-weight: 800;
      display: flex; align-items: center; justify-content: center;
      border: 2px solid var(--white);
    }
    .adm-step h4 { font-size: .92rem; font-weight: 700; color: var(--navy); margin-bottom: 6px; }
    .adm-step p { font-size: .8rem; color: var(--gray-600); line-height: 1.5; }
    .adm-address { font-size: .78rem; color: var(--red); font-weight: 600; margin-top: 4px; }

    /* ═══════════════════════════════════════════════════
       STATS
    ═══════════════════════════════════════════════════ */
    #stats {
      background: linear-gradient(135deg, #0B3C6D, #1565a0);
      padding: 80px 0;
    }
    .stats-grid {
      display: grid; grid-template-columns: repeat(4, 1fr);
      gap: 24px; text-align: center;
    }
    .stat-item {
      padding: 32px 20px;
      border-right: 1px solid rgba(255,255,255,.12);
    }
    .stat-item:last-child { border-right: none; }
    .stat-num {
      font-size: 3rem; font-weight: 800; color: var(--yellow);
      line-height: 1; font-family: 'Playfair Display', serif;
    }
    .stat-label { color: rgba(255,255,255,.75); font-size: .9rem; margin-top: 8px; font-weight: 500; }

    /* ═══════════════════════════════════════════════════
       TESTIMONIALS
    ═══════════════════════════════════════════════════ */
    #testimonials { background: var(--gray-50); overflow: hidden; }
    .testi-scroll-wrap {
      margin-top: 52px; overflow: hidden; position: relative;
    }
    .testi-track {
      display: flex; gap: 24px;
      animation: scrollTestimonials 30s linear infinite;
      width: max-content;
    }
    .testi-track:hover { animation-play-state: paused; }
    @keyframes scrollTestimonials {
      0% { transform: translateX(0); }
      100% { transform: translateX(-50%); }
    }
    .testi-card {
      background: var(--white); border-radius: var(--radius-lg);
      padding: 28px; box-shadow: var(--shadow-sm);
      border: 1px solid var(--gray-200); position: relative;
      width: 340px; flex-shrink: 0;
    }
    .testi-stars { color: var(--yellow); font-size: .9rem; margin-bottom: 14px; letter-spacing: 2px; }
    .testi-text { font-size: .9rem; color: var(--gray-600); line-height: 1.75; font-style: italic; margin-bottom: 20px; }
    .testi-author { display: flex; align-items: center; gap: 12px; }
    .testi-avatar {
      width: 48px; height: 48px; border-radius: 50%;
      background: linear-gradient(135deg, var(--navy), #1565a0);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.2rem; color: rgba(255,255,255,.4); flex-shrink: 0;
    }
    .testi-name { font-weight: 700; font-size: .9rem; color: var(--navy); }
    .testi-course { font-size: .78rem; color: var(--gray-400); }
    .testi-quote-bg {
      position: absolute; top: 16px; right: 20px;
      font-size: 5rem; font-family: 'Playfair Display', serif;
      color: rgba(11,60,109,.05); line-height: 1;
    }
    .testi-about-badge {
      background: var(--navy); color: var(--white);
      padding: 24px 36px; border-radius: var(--radius-lg);
      text-align: center; margin-top: 40px;
      font-size: .95rem; line-height: 1.7;
    }
    .testi-about-badge strong { color: var(--yellow); font-size: 1.1rem; display: block; margin-bottom: 6px; }

    /* ═══════════════════════════════════════════════════
       GALLERY
    ═══════════════════════════════════════════════════ */
    #gallery { background: var(--white); }
    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      grid-template-rows: repeat(2, 200px);
      gap: 12px; margin-top: 52px;
    }
    .gallery-item {
      border-radius: var(--radius); overflow: hidden;
      position: relative; cursor: pointer;
    }
    .gallery-item img { width: 100%; height: 100%; object-fit: cover; }
    .gallery-item:nth-child(1) { grid-column: span 2; grid-row: span 2; }
    .gallery-item:nth-child(4) { grid-column: span 2; }
    .gallery-overlay {
      position: absolute; inset: 0; background: rgba(11,60,109,.5);
      display: flex; align-items: center; justify-content: center;
      opacity: 0; transition: var(--transition);
    }
    .gallery-item:hover .gallery-overlay { opacity: 1; }
    .gallery-overlay i { color: var(--white); font-size: 1.8rem; }
    .gallery-cta { text-align: center; margin-top: 36px; }

    /* ═══════════════════════════════════════════════════
       EVENTS
    ═══════════════════════════════════════════════════ */
    #news { background: var(--gray-50); }
    .events-grid {
      display: grid; grid-template-columns: repeat(3, 1fr);
      gap: 28px; margin-top: 52px;
    }
    .event-card {
      background: var(--white); border-radius: var(--radius-lg);
      overflow: hidden; box-shadow: var(--shadow-sm);
      border: 1px solid var(--gray-200); transition: var(--transition);
      display: flex; flex-direction: column;
    }
    .event-card:hover { transform: translateY(-5px); box-shadow: var(--shadow); }
    .event-header {
      background: linear-gradient(135deg, var(--navy), #1565a0);
      padding: 28px 24px; position: relative; overflow: hidden;
    }
    .event-date-big { font-size: 2.5rem; font-weight: 800; color: var(--yellow); line-height: 1; }
    .event-month { color: rgba(255,255,255,.7); font-size: .85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
    .event-icon { position: absolute; right: 24px; top: 50%; transform: translateY(-50%); font-size: 2.5rem; color: rgba(255,255,255,.1); }
    .event-body { padding: 22px; flex: 1; }
    .event-type {
      color: var(--red); font-size: .72rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: .5px; margin-bottom: 8px;
    }
    .event-title { font-size: 1rem; font-weight: 700; color: var(--navy); line-height: 1.35; }
    .event-status {
      display: inline-flex; align-items: center; gap: 5px;
      margin-top: 12px; background: rgba(255,193,7,.15);
      color: var(--navy2); font-size: .75rem; font-weight: 700;
      padding: 4px 12px; border-radius: 50px;
    }

    /* ═══════════════════════════════════════════════════
       CTA
    ═══════════════════════════════════════════════════ */
    #cta {
      background: linear-gradient(135deg, #071e36, var(--navy), #E53935 200%);
      padding: 100px 0; text-align: center; position: relative; overflow: hidden;
    }
    #cta::before {
      content: ''; position: absolute; inset: 0;
      background: radial-gradient(circle at 60% 50%, rgba(255,193,7,.08) 0%, transparent 60%);
    }
    .cta-badge {
      display: inline-block; background: var(--red);
      color: var(--white); padding: 6px 20px; border-radius: 50px;
      font-size: .78rem; font-weight: 700; letter-spacing: 1px;
      text-transform: uppercase; margin-bottom: 20px;
      animation: pulse-badge 2s infinite;
    }
    #cta h2 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2rem, 5vw, 3.2rem);
      color: var(--white); font-weight: 800; margin-bottom: 14px;
    }
    #cta h2 span { color: var(--yellow); }
    #cta p { color: rgba(255,255,255,.72); font-size: 1rem; margin-bottom: 36px; }
    .cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

    /* ═══════════════════════════════════════════════════
       CONTACT
    ═══════════════════════════════════════════════════ */
    #contact { background: var(--white); }
    .contact-grid {
      display: grid; grid-template-columns: 1fr 1fr;
      gap: 60px; margin-top: 52px;
    }
    .contact-cards { display: flex; flex-direction: column; gap: 16px; }
    .contact-card {
      display: flex; gap: 18px; padding: 22px;
      border-radius: var(--radius); border: 1px solid var(--gray-200);
      align-items: flex-start; transition: var(--transition);
    }
    .contact-card:hover { border-color: var(--navy); box-shadow: var(--shadow-sm); }
    .contact-icon {
      width: 50px; height: 50px; border-radius: 14px;
      background: rgba(11,60,109,.08); color: var(--navy);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.2rem; flex-shrink: 0;
    }
    .contact-info h4 { font-size: .92rem; font-weight: 700; color: var(--navy); margin-bottom: 4px; }
    .contact-info p, .contact-info a { font-size: .88rem; color: var(--gray-600); line-height: 1.6; }
    .contact-actions { display: flex; gap: 10px; margin-top: 24px; }
    .btn-wa {
      background: #25D366; color: var(--white); border: none;
      padding: 12px 22px; border-radius: 50px; font-weight: 700;
      font-size: .88rem; cursor: pointer; display: inline-flex;
      align-items: center; gap: 8px; transition: var(--transition); font-family: inherit;
    }
    .btn-wa:hover { background: #1da851; transform: translateY(-2px); }
    .btn-call {
      background: var(--navy); color: var(--white); border: none;
      padding: 12px 22px; border-radius: 50px; font-weight: 700;
      font-size: .88rem; cursor: pointer; display: inline-flex;
      align-items: center; gap: 8px; transition: var(--transition); font-family: inherit;
    }
    .btn-call:hover { background: var(--navy2); transform: translateY(-2px); }
    .contact-form-wrap { background: var(--gray-50); border-radius: var(--radius-lg); padding: 36px; }
    .contact-form-wrap h3 { font-size: 1.2rem; font-weight: 700; color: var(--navy); margin-bottom: 24px; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: .85rem; font-weight: 600; color: var(--navy); margin-bottom: 6px; }
    .form-group input, .form-group textarea, .form-group select {
      width: 100%; padding: 12px 16px; border-radius: 10px;
      border: 1.5px solid var(--gray-200); font-family: inherit; font-size: .9rem;
      color: var(--gray-800); background: var(--white); transition: var(--transition);
      outline: none;
    }
    .form-group input:focus, .form-group textarea:focus, .form-group select:focus {
      border-color: var(--navy); box-shadow: 0 0 0 3px rgba(11,60,109,.1);
    }
    .form-group textarea { resize: vertical; min-height: 100px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

    /* ═══════════════════════════════════════════════════
       MAP
    ═══════════════════════════════════════════════════ */
    #map { padding: 0; }
    .map-wrap {
      border-radius: var(--radius-lg); overflow: hidden;
      box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200);
      height: 420px; background: var(--gray-100); position: relative;
      display: flex; align-items: center; justify-content: center;
    }
    .map-placeholder { text-align: center; color: var(--gray-400); }
    .map-placeholder i { font-size: 3rem; margin-bottom: 10px; display: block; }

    /* ═══════════════════════════════════════════════════
       FAQ
    ═══════════════════════════════════════════════════ */
    #faq { background: var(--gray-50); }
    .faq-list { margin-top: 52px; max-width: 760px; margin-left: auto; margin-right: auto; display: flex; flex-direction: column; gap: 12px; }
    .faq-item {
      background: var(--white); border-radius: var(--radius);
      border: 1px solid var(--gray-200); overflow: hidden; transition: var(--transition);
    }
    .faq-item.open { border-color: var(--navy); }
    .faq-q {
      display: flex; align-items: center; justify-content: space-between;
      padding: 20px 22px; cursor: pointer; gap: 16px;
      font-weight: 700; font-size: .93rem; color: var(--navy);
      transition: var(--transition);
    }
    .faq-q:hover { color: var(--red); }
    .faq-arrow {
      width: 32px; height: 32px; border-radius: 50%;
      background: var(--gray-100); display: flex; align-items: center;
      justify-content: center; font-size: .8rem; color: var(--gray-600);
      transition: var(--transition); flex-shrink: 0;
    }
    .faq-item.open .faq-arrow { background: var(--navy); color: var(--yellow); transform: rotate(180deg); }
    .faq-a {
      padding: 0 22px; max-height: 0; overflow: hidden; transition: max-height .35s ease, padding .35s ease;
      font-size: .9rem; color: var(--gray-600); line-height: 1.75;
    }
    .faq-item.open .faq-a { max-height: 200px; padding-bottom: 20px; }

    /* ═══════════════════════════════════════════════════
       NEWSLETTER
    ═══════════════════════════════════════════════════ */
    #newsletter {
      background: linear-gradient(135deg, var(--yellow2), var(--yellow));
      padding: 80px 0; text-align: center;
    }
    #newsletter h2 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(1.6rem, 4vw, 2.2rem); color: var(--navy);
      font-weight: 800; margin-bottom: 10px;
    }
    #newsletter p { color: var(--navy2); opacity: .75; margin-bottom: 32px; font-size: .95rem; }
    .nl-form {
      display: flex; max-width: 500px; margin: 0 auto;
      background: var(--white); border-radius: 50px;
      padding: 6px; box-shadow: 0 8px 32px rgba(11,60,109,.15);
    }
    .nl-form input {
      flex: 1; border: none; outline: none; padding: 12px 20px;
      font-family: inherit; font-size: .9rem; background: transparent;
      color: var(--gray-800); border-radius: 50px;
    }
    .nl-form button {
      background: var(--navy); color: var(--white);
      border: none; padding: 12px 24px; border-radius: 50px;
      font-weight: 700; font-size: .88rem; cursor: pointer;
      transition: var(--transition); font-family: inherit; white-space: nowrap;
    }
    .nl-form button:hover { background: var(--navy2); }

    /* ═══════════════════════════════════════════════════
       FOOTER
    ═══════════════════════════════════════════════════ */
    #footer {
      background: var(--navy2); color: rgba(255,255,255,.75);
    }
    .footer-top { padding: 70px 0 50px; }
    .footer-grid {
      display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1.5fr;
      gap: 40px;
    }
    .footer-brand .logo { margin-bottom: 18px; }
    .footer-brand p { font-size: .88rem; line-height: 1.75; margin-bottom: 22px; }
    .footer-social { display: flex; gap: 10px; }
    .social-btn {
      width: 38px; height: 38px; border-radius: 10px;
      background: rgba(255,255,255,.08); color: rgba(255,255,255,.7);
      display: flex; align-items: center; justify-content: center;
      font-size: .9rem; transition: var(--transition);
    }
    .social-btn:hover { background: var(--yellow); color: var(--navy); }
    .footer-col h4 {
      color: var(--white); font-size: .9rem; font-weight: 700;
      margin-bottom: 18px; letter-spacing: .5px;
    }
    .footer-col h4::after {
      content: ''; display: block; width: 28px; height: 2px;
      background: var(--yellow); margin-top: 8px; border-radius: 1px;
    }
    .footer-col ul { display: flex; flex-direction: column; gap: 10px; }
    .footer-col ul li a {
      font-size: .86rem; color: rgba(255,255,255,.62);
      transition: var(--transition); display: flex; align-items: center; gap: 7px;
    }
    .footer-col ul li a:hover { color: var(--yellow); padding-left: 4px; }
    .footer-col ul li a i { font-size: .65rem; color: var(--yellow); }
    .footer-contact li {
      display: flex; gap: 12px; font-size: .86rem;
      color: rgba(255,255,255,.62); align-items: flex-start; margin-bottom: 10px;
    }
    .footer-contact li i { color: var(--yellow); margin-top: 3px; flex-shrink: 0; width: 14px; }

    .footer-bottom {
      border-top: 1px solid rgba(255,255,255,.08);
      padding: 22px 0; display: flex; align-items: center; justify-content: space-between;
      font-size: .82rem; flex-wrap: wrap; gap: 12px;
    }
    .footer-bottom a { color: rgba(255,255,255,.5); transition: var(--transition); }
    .footer-bottom a:hover { color: var(--yellow); }
    .footer-links { display: flex; gap: 20px; }

    #back-top {
      position: fixed; bottom: 28px; right: 28px; z-index: 999;
      width: 48px; height: 48px; border-radius: 50%;
      background: var(--navy); color: var(--white);
      display: flex; align-items: center; justify-content: center;
      font-size: 1rem; box-shadow: var(--shadow);
      opacity: 0; pointer-events: none; transition: var(--transition);
      cursor: pointer; border: none;
    }
    #back-top.show { opacity: 1; pointer-events: auto; }
    #back-top:hover { background: var(--yellow); color: var(--navy); transform: translateY(-3px); }

    /* ═══════════════════════════════════════════════════
       RESPONSIVE — MOBILE ONLY (app-like layout, 2-col cards)
    ═══════════════════════════════════════════════════ */
    @media (max-width: 768px) {
      section { padding: 40px 0; }
      .container { padding: 0 14px; overflow-x: hidden; }
      .nav-actions { display: none; }
      nav { display: none; }
      .hamburger { display: flex; margin-left: auto; }
      #header { padding: 0 14px; width: 100%; }
      .nav-inner { padding: 10px 0; gap: 8px; width: 100%; }
      .logo-mark { width: 34px; height: 34px; font-size: .85rem; border-radius: 8px; }
      .logo-text strong { font-size: .72rem; }
      .logo-text span { font-size: .5rem; }
      .mobile-overlay.open { display: block; opacity: 1; }
      #hero { padding-top: 60px; min-height: auto; padding-bottom: 25px; }
      .hero-inner { grid-template-columns: 1fr; gap: 20px; padding: 5px 0; }
      .hero-visual { display: none; }
      .hero-title { font-size: clamp(1.4rem, 5vw, 1.9rem); margin-bottom: 10px; }
      .hero-sub { font-size: .76rem; margin-bottom: 14px; line-height: 1.55; }
      .hero-badge { font-size: .55rem; padding: 3px 10px; margin-bottom: 10px; }
      .hero-btns { flex-direction: column; gap: 8px; margin-bottom: 16px; }
      .hero-btns .btn { width: 100%; justify-content: center; padding: 9px 16px; font-size: .75rem; min-height: 40px; border-radius: 30px; }
      .hero-stats { gap: 6px; padding: 10px 12px; border-radius: 10px; }
      .hero-stat { min-width: 50px; }
      .hero-stat-num { font-size: 1rem; }
      .hero-stat-label { font-size: .55rem; }
      .scroll-hint { display: none; }
      .section-tag { font-size: .55rem; padding: 3px 10px; margin-bottom: 6px; border-radius: 30px; }
      .section-tag i { font-size: .5rem; }
      .section-title { font-size: clamp(1.1rem, 4vw, 1.4rem); }
      .section-sub { font-size: .68rem; margin-top: 4px; }
      .accent-bar { width: 28px; height: 3px; margin: 8px 0 0; }
      .why-grid { grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 16px; }
      .why-card { padding: 12px 10px; border-radius: 10px; }
      .why-icon { width: 28px; height: 28px; font-size: .7rem; margin-bottom: 4px; border-radius: 6px; }
      .why-card h3 { font-size: .65rem; margin-bottom: 1px; }
      .why-card p { font-size: .58rem; line-height: 1.35; }
      .why-card::after { display: none; }
      .about-grid { grid-template-columns: 1fr; gap: 16px; }
      .about-img-main { height: 140px; border-radius: 12px; }
      .about-badge-float { bottom: -6px; right: 6px; padding: 6px 10px; border-radius: 8px; }
      .about-badge-float .num { font-size: .9rem; }
      .about-badge-float .lbl { font-size: .45rem; }
      .about-pills { gap: 4px; margin: 8px 0; }
      .pill { font-size: .5rem; padding: 2px 8px; border-radius: 20px; }
      .about-list { margin: 8px 0 12px; gap: 4px; }
      .about-list li { font-size: .68rem; gap: 5px; }
      .about-list li i { font-size: .6rem; margin-top: 1px; }
      .ceo-inner { grid-template-columns: 1fr; gap: 14px; text-align: center; }
      .ceo-photo { width: 70px; height: 70px; border-width: 3px; }
      .ceo-name { font-size: .75rem; }
      .ceo-role { font-size: .6rem; }
      .ceo-quote-mark { font-size: 1.4rem; }
      .ceo-message { font-size: .7rem; line-height: 1.5; }
      .ceo-sig { justify-content: center; gap: 6px; margin-top: 10px; }
      .ceo-sig-text { font-size: .65rem; }
      .teachers-grid { grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 16px; }
      .teacher-card { border-radius: 10px; }
      .teacher-photo { height: 70px; }
      .teacher-info { padding: 6px 4px 10px; }
      .teacher-name { font-size: .65rem; }
      .teacher-subject { font-size: .5rem; padding: 1px 6px; margin-top: 2px; border-radius: 20px; }
      .courses-grid { grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 16px; }
      .course-card { border-radius: 10px; }
      .course-img { height: 50px; font-size: 1rem; }
      .course-badge { font-size: .45rem; padding: 1px 5px; top: 3px; left: 3px; border-radius: 20px; }
      .course-body { padding: 6px 8px; }
      .course-title { font-size: .62rem; margin-bottom: 1px; }
      .course-desc { font-size: .52rem; -webkit-line-clamp: 2; margin-bottom: 3px; line-height: 1.3; }
      .course-meta { font-size: .5rem; gap: 4px; padding-top: 3px; margin-bottom: 4px; border-top: 1px solid var(--gray-100); }
      .course-meta span { gap: 2px; }
      .course-footer .btn { padding: 2px 6px; font-size: .5rem; min-height: 20px; border-radius: 16px; }
      .course-fee { font-size: .65rem; }
      .course-fee small { font-size: .45rem; }
      .admission-steps { grid-template-columns: 1fr; gap: 6px; margin-top: 16px; }
      .admission-steps::before { display: none; }
      .adm-step { display: flex; align-items: center; gap: 8px; text-align: left; padding: 8px 10px; background: var(--white); border-radius: 10px; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200); }
      .adm-circle { width: 32px; height: 32px; font-size: .6rem; margin: 0; flex-shrink: 0; border-width: 2px; border-radius: 50%; }
      .adm-num { width: 14px; height: 14px; font-size: .45rem; top: -3px; right: -3px; }
      .adm-step h4 { font-size: .65rem; margin-bottom: 0; }
      .adm-step p { font-size: .55rem; line-height: 1.25; }
      .adm-address { font-size: .5rem; }
      #stats { padding: 25px 0; }
      .stats-grid { grid-template-columns: 1fr 1fr; gap: 6px; }
      .stat-item { padding: 10px 6px; border: none; border-radius: 8px; background: rgba(255,255,255,.04); }
      .stat-num { font-size: 1.2rem; }
      .stat-label { font-size: .55rem; }
      .testi-scroll-wrap { margin-top: 16px; }
      .testi-card { width: 180px; padding: 12px; border-radius: 12px; }
      .testi-stars { font-size: .55rem; margin-bottom: 4px; }
      .testi-text { font-size: .6rem; line-height: 1.35; margin-bottom: 6px; }
      .testi-avatar { width: 24px; height: 24px; font-size: .6rem; }
      .testi-name { font-size: .6rem; }
      .testi-course { font-size: .5rem; }
      .testi-quote-bg { font-size: 2rem; top: 6px; right: 10px; }
      .testi-about-badge { padding: 12px 14px; font-size: .65rem; margin-top: 16px; line-height: 1.4; border-radius: 12px; }
      .testi-about-badge strong { font-size: .7rem; }
      .gallery-grid { grid-template-columns: 1fr 1fr; gap: 4px; margin-top: 16px; }
      .gallery-item { height: 70px; border-radius: 6px; }
      .gallery-item:nth-child(1) { grid-column: span 2; height: 100px; }
      .gallery-overlay i { font-size: .7rem; }
      .gallery-cta { margin-top: 12px; }
      .gallery-cta .btn { padding: 6px 14px; font-size: .65rem; min-height: 32px; border-radius: 30px; }
      .events-grid { grid-template-columns: 1fr; gap: 8px; margin-top: 16px; max-width: 320px; margin-left: auto; margin-right: auto; }
      .event-card { border-radius: 10px; }
      .event-header { padding: 10px 14px; gap: 6px; }
      .event-date-big { font-size: 1rem; }
      .event-month { font-size: .5rem; }
      .event-icon { font-size: 1rem; right: 10px; }
      .event-body { padding: 8px 12px; }
      .event-type { font-size: .45rem; margin-bottom: 1px; }
      .event-title { font-size: .65rem; }
      .event-status { font-size: .5rem; padding: 2px 6px; margin-top: 4px; border-radius: 20px; }
      #cta { padding: 32px 0; }
      #cta h2 { font-size: clamp(1.1rem, 4vw, 1.4rem); }
      #cta p { font-size: .68rem; margin-bottom: 14px; }
      .cta-badge { font-size: .55rem; padding: 3px 10px; border-radius: 30px; }
      .cta-btns .btn { width: 100%; padding: 9px 16px; font-size: .75rem; min-height: 40px; border-radius: 30px; }
      .contact-grid { grid-template-columns: 1fr; gap: 16px; margin-top: 16px; }
      .contact-card { padding: 8px 10px; gap: 8px; border-radius: 8px; }
      .contact-icon { width: 28px; height: 28px; font-size: .6rem; border-radius: 6px; }
      .contact-info h4 { font-size: .6rem; }
      .contact-info p, .contact-info a { font-size: .6rem; }
      .contact-actions { gap: 6px; margin-top: 8px; }
      .contact-actions .btn { padding: 6px 12px; font-size: .65rem; min-height: 32px; border-radius: 30px; flex: 1; }
      .contact-form-wrap { padding: 14px; border-radius: 12px; }
      .contact-form-wrap h3 { font-size: .75rem; margin-bottom: 10px; }
      .form-group { margin-bottom: 6px; }
      .form-group label { font-size: .6rem; }
      .form-group input, .form-group textarea, .form-group select { padding: 5px 8px; font-size: .65rem; border-radius: 6px; }
      .form-row { grid-template-columns: 1fr; gap: 0; }
      .form-group textarea { min-height: 50px; }
      .map-wrap { height: 120px; border-radius: 12px; }
      .faq-list { margin-top: 16px; gap: 4px; }
      .faq-q { padding: 8px 10px; font-size: .65rem; border-radius: 8px; }
      .faq-arrow { width: 20px; height: 20px; font-size: .5rem; border-radius: 50%; }
      .faq-a { font-size: .62rem; line-height: 1.4; }
      .faq-item.open .faq-a { max-height: 300px; padding-bottom: 10px; }
      #newsletter { padding: 25px 0; }
      #newsletter h2 { font-size: clamp(1rem, 3vw, 1.2rem); }
      #newsletter p { font-size: .65rem; margin-bottom: 10px; }
      .nl-form { max-width: 280px; border-radius: 30px; padding: 3px; }
      .nl-form input { padding: 5px 10px; font-size: .65rem; }
      .nl-form button { padding: 5px 12px; font-size: .6rem; border-radius: 30px; }
      .footer-top { padding: 20px 0 12px; }
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
      .footer-brand { grid-column: span 2; }
      .footer-brand .logo { margin-bottom: 6px; }
      .footer-brand p { font-size: .6rem; line-height: 1.35; margin-bottom: 8px; }
      .footer-social { gap: 4px; }
      .social-btn { width: 24px; height: 24px; font-size: .6rem; border-radius: 6px; }
      .footer-col h4 { font-size: .6rem; margin-bottom: 6px; }
      .footer-col h4::after { width: 16px; height: 2px; margin-top: 3px; }
      .footer-col ul li a { font-size: .56rem; gap: 3px; }
      .footer-col ul li a i { font-size: .4rem; }
      .footer-contact li { font-size: .56rem; gap: 4px; margin-bottom: 3px; }
      .footer-contact li i { width: 10px; font-size: .5rem; }
      .footer-bottom { flex-direction: column; text-align: center; gap: 4px; padding: 10px 0; font-size: .55rem; }
      .footer-links { gap: 8px; justify-content: center; }
      #back-top { width: 32px; height: 32px; font-size: .6rem; bottom: 12px; right: 12px; border-radius: 50%; }
    }

    @media (max-width: 480px) {
      .why-grid { grid-template-columns: 1fr 1fr; max-width: 100%; }
      .teachers-grid { grid-template-columns: 1fr 1fr; max-width: 100%; }
      .courses-grid { grid-template-columns: 1fr 1fr; max-width: 100%; }
      .gallery-grid { grid-template-columns: 1fr 1fr; }
      .gallery-item:nth-child(1) { grid-column: span 2; height: 80px; }
      .gallery-item { height: 80px; }
      .footer-grid { grid-template-columns: 1fr 1fr; }
      .footer-brand { grid-column: span 2; }
    }
  </style>
</head>
<body>

<!-- ═══════════════════════════════════════════════════
   MOBILE OVERLAY (for sidebar)
═══════════════════════════════════════════════════ -->
<div class="mobile-overlay" id="mobileOverlay"></div>

<!-- ═══════════════════════════════════════════════════
   MOBILE SIDEBAR NAV (Left Drawer)
═══════════════════════════════════════════════════ -->
<div class="mobile-nav" id="mobileNav">
  <div class="mobile-nav-header">
    <div class="mobile-nav-brand">
      <div class="logo-mark-sm">LI</div>
      <span>{{ $settings['institute']['name'] ?? 'Leeds Institute' }}</span>
    </div>
    <button class="mobile-nav-close" id="navClose"><i class="fas fa-times"></i></button>
  </div>
  <a href="{{ route('home') }}" onclick="closeNav()"><i class="fas fa-home"></i> Home</a>
  <a href="{{ route('aboutus') }}" onclick="closeNav()"><i class="fas fa-info-circle"></i> About</a>
  <a href="{{ route('courses') }}" onclick="closeNav()"><i class="fas fa-book-open"></i> Courses</a>
  <a href="{{ route('admissions') }}" onclick="closeNav()"><i class="fas fa-clipboard-list"></i> Admissions</a>
  <a href="{{ route('faq') }}" onclick="closeNav()"><i class="fas fa-question-circle"></i> FAQ</a>
  <a href="{{ route('teachers') }}" onclick="closeNav()"><i class="fas fa-chalkboard-teacher"></i> Teachers</a>
  <a href="{{ route('gallery') }}" onclick="closeNav()"><i class="fas fa-images"></i> Gallery</a>
  <a href="{{ route('contact') }}" onclick="closeNav()"><i class="fas fa-phone"></i> Contact</a>
  <a href="{{ route('crtverfictaion') }}" onclick="closeNav()"><i class="fas fa-certificate"></i> Verify Certificate</a>
  <a href="{{ route('search_results') }}" onclick="closeNav()"><i class="fas fa-search"></i> Search Results</a>
  <a href="{{ route('Terms_Privacy') }}" onclick="closeNav()"><i class="fas fa-shield-alt"></i> Terms & Privacy</a>
</div>

<!-- ═══════════════════════════════════════════════════
   HEADER
═══════════════════════════════════════════════════ -->
<header id="header">
  <div class="container">
    <div class="nav-inner">
      <a href="{{ route('home') }}" class="logo">
        <div class="logo-mark">LI</div>
        <div class="logo-text">
          <strong>{{ $settings['institute']['name'] ?? 'Leeds Institute' }}</strong>
          <span>{{ $settings['institute']['tagline'] ?? 'Quality Education Since 2005' }}</span>
        </div>
      </a>
      <nav>
        <ul class="nav-list">
          <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
          <li><a href="{{ route('aboutus') }}" class="{{ request()->routeIs('aboutus') ? 'active' : '' }}">About</a></li>
          <li><a href="{{ route('courses') }}" class="{{ request()->routeIs('courses') ? 'active' : '' }}">Courses</a></li>
          <li><a href="{{ route('admissions') }}" class="{{ request()->routeIs('admissions') ? 'active' : '' }}">Admissions</a></li>
          <li><a href="{{ route('faq') }}" class="{{ request()->routeIs('faq') ? 'active' : '' }}">FAQ</a></li>
          <li><a href="{{ route('teachers') }}" class="{{ request()->routeIs('teachers') ? 'active' : '' }}">Teachers</a></li>
          <li><a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active' : '' }}">Gallery</a></li>
          <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
          <li><a href="{{ route('crtverfictaion') }}" class="{{ request()->routeIs('crtverfictaion') ? 'active' : '' }}">Verify</a></li>
          <li><a href="{{ route('search_results') }}" class="{{ request()->routeIs('search_results') ? 'active' : '' }}">Search</a></li>
          <li><a href="{{ route('Terms_Privacy') }}" class="{{ request()->routeIs('Terms_Privacy') ? 'active' : '' }}">Privacy</a></li>
        </ul>
      </nav>
      <button class="hamburger" id="hamburger" aria-label="Menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>

<!-- ═══════════════════════════════════════════════════
   HERO
═══════════════════════════════════════════════════ -->
<section id="hero">
  <div class="container">
    <div class="hero-inner">
      <div class="hero-left">
        <div class="hero-badge"><i class="fas fa-star"></i> Admissions Open 2025–26</div>
        <h1 class="hero-title">
          Empowering<br>
          <span class="highlight">Future Leaders</span><br>
          Through Quality<br>Education
        </h1>
        <p class="hero-sub">
          {{ $settings['institute']['about_description'] ?? 'Leeds Institute delivers world-class education with experienced faculty, modern facilities, and a results-driven environment that prepares students for a competitive global landscape.' }}
        </p>
        <div class="hero-btns">
          <a href="#contact" class="btn btn-primary"><i class="fas fa-phone"></i> Contact Admissions</a>
          <a href="#courses" class="btn btn-outline"><i class="fas fa-book-open"></i> Explore Courses</a>
        </div>
        <div class="hero-stats">
          <div class="hero-stat">
            <div class="hero-stat-num" data-count="{{ $stats['students'] ?? 0 }}">{{ number_format($stats['students'] ?? 0) }}+</div>
            <div class="hero-stat-label">Students Enrolled</div>
          </div>
          <div class="hero-stat">
            <div class="hero-stat-num" data-count="{{ $stats['teachers'] ?? 0 }}">{{ number_format($stats['teachers'] ?? 0) }}+</div>
            <div class="hero-stat-label">Expert Teachers</div>
          </div>
          <div class="hero-stat">
            <div class="hero-stat-num" data-count="{{ $stats['success_rate'] ?? 98 }}">{{ $stats['success_rate'] ?? 98 }}%</div>
            <div class="hero-stat-label">Success Rate</div>
          </div>
        </div>
      </div>
      <div class="hero-visual">
        <div class="hero-img-frame">
          <div class="hero-campus-img">
            <img src="{{ $settings['about']['image'] ? asset('storage/' . $settings['about']['image']) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSShVvGMxavP7NUB-oqhfQ_8Z601gZuptX4rpp0uXGtSQ&s=10' }}" alt="{{ $settings['institute']['name'] ?? 'Leeds Institute' }} Campus" />
          </div>
          <div class="float-card fc-1">
            <div class="icon"><i class="fas fa-trophy"></i></div>
            <div>
              <div style="font-size:.75rem;color:var(--gray-400);font-weight:500">Achievement</div>
              <div style="color:var(--navy)">Top Ranked Institute</div>
            </div>
          </div>
          <div class="float-card fc-2">
            <div class="icon"><i class="fas fa-graduation-cap"></i></div>
            <div>
              <div style="font-size:.75rem;color:var(--gray-400);font-weight:500">Graduates</div>
              <div style="color:var(--navy)">{{ number_format($stats['students'] ?? 0) }}+ Alumni</div>
            </div>
          </div>
          <div class="float-card fc-3">
            <div class="icon"><i class="fas fa-certificate"></i></div>
            <div>
              <div style="font-size:.75rem;color:var(--gray-400);font-weight:500">Certified</div>
              <div style="color:var(--navy)">HEC Recognized</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="scroll-hint">
    <span>Scroll Down</span>
    <i class="fas fa-chevron-down"></i>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   WHY CHOOSE (Static - Keep as is since it's feature list)
═══════════════════════════════════════════════════ -->
<section id="why">
  <div class="container">
    <div class="text-center">
      <div class="section-tag"><i class="fas fa-star"></i> Why Choose Us</div>
      <h2 class="section-title">What Sets Leeds Institute <span>Apart</span></h2>
      <div class="accent-bar"></div>
      <p class="section-sub">We are committed to delivering an education that goes beyond textbooks — building character, skills, and futures.</p>
    </div>
    <div class="why-grid">
      <div class="why-card" data-aos="fade-up" data-aos-delay="0">
        <div class="why-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <h3>Experienced Faculty</h3>
        <p>Our educators bring years of academic and industry experience, delivering lessons that inspire critical thinking and real-world readiness.</p>
      </div>
      <div class="why-card" data-aos="fade-up" data-aos-delay="80">
        <div class="why-icon"><i class="fas fa-school"></i></div>
        <h3>Modern Classrooms</h3>
        <p>Smart boards, projectors, and air-conditioned rooms ensure a comfortable, tech-enabled learning environment every day.</p>
      </div>
      <div class="why-card" data-aos="fade-up" data-aos-delay="160">
        <div class="why-icon"><i class="fas fa-hand-holding-heart"></i></div>
        <h3>Affordable Fee Structure</h3>
        <p>We believe quality education should be accessible. Our transparent fee structure and flexible payment plans ease the burden on families.</p>
      </div>
      <div class="why-card" data-aos="fade-up" data-aos-delay="0">
        <div class="why-icon"><i class="fas fa-laptop"></i></div>
        <h3>Computer Labs</h3>
        <p>Fully equipped computer labs with high-speed internet give students hands-on experience with the digital tools that shape tomorrow's workforce.</p>
      </div>
      <div class="why-card" data-aos="fade-up" data-aos-delay="80">
        <div class="why-icon"><i class="fas fa-award"></i></div>
        <h3>Scholarships Available</h3>
        <p>Merit-based and need-based scholarships recognize academic excellence and ensure no deserving student is left behind.</p>
      </div>
      <div class="why-card" data-aos="fade-up" data-aos-delay="160">
        <div class="why-icon"><i class="fas fa-briefcase"></i></div>
        <h3>Career Guidance</h3>
        <p>A dedicated career counseling cell helps students explore pathways, prepare for interviews, and connect with industry professionals.</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   ABOUT (Dynamic)
═══════════════════════════════════════════════════ -->
<section id="about">
  <div class="container">
    <div class="about-grid">
      <div class="about-img-wrap" data-aos="fade-right">
        <div class="about-img-main">
          <img src="{{ $settings['about']['image'] ? asset('storage/' . $settings['about']['image']) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTi6iTao9uzCT0_np_Ql0lj9_3FeGFSddBvDtRCZ0r9fQ&s=10' }}" alt="About {{ $settings['institute']['name'] ?? 'Leeds Institute' }}" />
        </div>
        <div class="about-badge-float">
          <div class="num">{{ $settings['institute']['years_experience'] ?? 20 }}+</div>
          <div class="lbl">Years of<br>Excellence</div>
        </div>
      </div>
      <div data-aos="fade-left">
        <div class="section-tag"><i class="fas fa-building-columns"></i> About {{ $settings['institute']['name'] ?? 'Leeds Institute' }}</div>
        <h2 class="section-title">Building Excellence<br>Since <span>2005</span></h2>
        <div class="accent-bar"></div>
        <div class="about-pills">
          <span class="pill">🎯 Mission Driven</span>
          <span class="pill">🏅 HEC Recognized</span>
          <span class="pill">🌍 Modern Curriculum</span>
        </div>
        <p style="color:var(--gray-600);line-height:1.8;font-size:.95rem;">
          {{ $settings['about']['about_us'] ?? 'Leeds Institute has been a cornerstone of quality education in the region for over two decades. Founded with the mission of making excellent education accessible, we have grown into a fully equipped institution serving thousands of students across multiple disciplines.' }}
        </p>
        <ul class="about-list">
          <li><i class="fas fa-check-circle"></i> <span><strong>Mission:</strong> {{ $settings['about']['mission'] ?? 'To cultivate intellectual growth, moral character, and practical skills that equip students for lifelong success.' }}</span></li>
          <li><i class="fas fa-check-circle"></i> <span><strong>Vision:</strong> {{ $settings['about']['vision'] ?? 'To be the most trusted educational institution in the region, recognized for academic excellence and student achievement.' }}</span></li>
          <li><i class="fas fa-check-circle"></i> <span><strong>Excellence:</strong> Consistent top results in board examinations with a {{ $stats['success_rate'] ?? 98 }}% pass rate over the past decade.</span></li>
          <li><i class="fas fa-check-circle"></i> <span><strong>Community:</strong> A vibrant student community with clubs, sports, and extracurricular activities for holistic development.</span></li>
        </ul>
        <a href="#contact" class="btn btn-navy"><i class="fas fa-arrow-right"></i> Get In Touch</a>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   CEO MESSAGE (Dynamic)
═══════════════════════════════════════════════════ -->
<section id="ceo">
  <div class="container">
    <div class="ceo-inner">
      <div class="ceo-photo-wrap" data-aos="fade-right">
        <div class="ceo-photo">
          <img src="{{ $settings['ceo']['photo'] ? asset('storage/' . $settings['ceo']['photo']) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcROdZ8ey95QUY6mhM2AvYu9AEPxdQl6Yno02JhtOiK_iQ&s=10' }}" alt="{{ $settings['ceo']['name'] ?? 'Dr. Imran Khalil' }}" />
        </div>
        <div class="ceo-name">{{ $settings['ceo']['name'] ?? 'Dr. Imran Khalil' }}</div>
        <div class="ceo-role">{{ $settings['ceo']['designation'] ?? 'Principal & CEO' }}, {{ $settings['institute']['name'] ?? 'Leeds Institute' }}</div>
      </div>
      <div class="ceo-content" data-aos="fade-left">
        <span class="ceo-quote-mark">"</span>
        <p class="ceo-message">
          {{ $settings['ceo']['message'] ?? 'At Leeds Institute, we believe education is not merely the transfer of knowledge — it is the transformation of lives. Every student who walks through our doors carries with them a dream, and it is our sacred responsibility to nurture that dream with the finest teaching, the most supportive environment, and the highest standards of academic rigour.' }}
          <br><br>
          Our commitment to excellence is reflected not just in our examination results, but in the leaders, professionals, and responsible citizens our graduates become. I invite every aspiring student and supportive parent to join the Leeds family — where your future begins today.
        </p>
        <div class="ceo-sig">
          <div class="ceo-sig-line"></div>
          <div class="ceo-sig-text">— {{ $settings['ceo']['name'] ?? 'Dr. Imran Khalil' }}, {{ $settings['ceo']['designation'] ?? 'Principal' }}</div>
          <div class="ceo-sig-line"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   TEACHERS (Dynamic from Database)
═══════════════════════════════════════════════════ -->
<section id="teachers">
  <div class="container">
    <div class="text-center">
      <div class="section-tag"><i class="fas fa-chalkboard-teacher"></i> Our Faculty</div>
      <h2 class="section-title">Meet Our <span>Expert</span> Teachers</h2>
      <div class="accent-bar"></div>
      <p class="section-sub">Our faculty members are qualified professionals passionate about student success and academic excellence.</p>
    </div>
    <div class="teachers-grid">
      @forelse($teachers as $teacher)
        <div class="teacher-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
          <div class="teacher-photo">
            <img src="{{ $teacher->profile_image ? asset('storage/' . $teacher->profile_image) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT32QJylyT86CDgyExxYZTUVpS_ZvNm8mo75YuNlw2_TQ&s=10' }}" alt="{{ $teacher->name }}" />
          </div>
          <div class="teacher-info">
            <div class="teacher-name">{{ $teacher->name }}</div>
            <div class="teacher-subject">{{ $teacher->specialization }}</div>
          </div>
        </div>
      @empty
        <div class="teacher-card" data-aos="fade-up">
          <div class="teacher-photo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT32QJylyT86CDgyExxYZTUVpS_ZvNm8mo75YuNlw2_TQ&s=10" alt="Prof. Ahmed Raza" />
          </div>
          <div class="teacher-info">
            <div class="teacher-name">Prof. Ahmed Raza</div>
            <div class="teacher-subject">Mathematics</div>
          </div>
        </div>
        <div class="teacher-card" data-aos="fade-up" data-aos-delay="80">
          <div class="teacher-photo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT32QJylyT86CDgyExxYZTUVpS_ZvNm8mo75YuNlw2_TQ&s=10" alt="Dr. Sana Malik" />
          </div>
          <div class="teacher-info">
            <div class="teacher-name">Dr. Sana Malik</div>
            <div class="teacher-subject">Physics</div>
          </div>
        </div>
        <div class="teacher-card" data-aos="fade-up" data-aos-delay="160">
          <div class="teacher-photo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT32QJylyT86CDgyExxYZTUVpS_ZvNm8mo75YuNlw2_TQ&s=10" alt="Mr. Usman Khan" />
          </div>
          <div class="teacher-info">
            <div class="teacher-name">Mr. Usman Khan</div>
            <div class="teacher-subject">Computer Science</div>
          </div>
        </div>
        <div class="teacher-card" data-aos="fade-up" data-aos-delay="240">
          <div class="teacher-photo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT32QJylyT86CDgyExxYZTUVpS_ZvNm8mo75YuNlw2_TQ&s=10" alt="Ms. Fatima Noor" />
          </div>
          <div class="teacher-info">
            <div class="teacher-name">Ms. Fatima Noor</div>
            <div class="teacher-subject">English Literature</div>
          </div>
        </div>
      @endforelse
    </div>
    <div style="text-align:center;margin-top:36px;">
      <a href="#contact" class="btn btn-navy"><i class="fas fa-users"></i> Meet All Faculty</a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   COURSES (Dynamic from Database)
═══════════════════════════════════════════════════ -->
<section id="courses">
  <div class="container">
    <div class="text-center">
      <div class="section-tag"><i class="fas fa-book-open"></i> Our Programs</div>
      <h2 class="section-title">Popular <span>Courses</span> & Programs</h2>
      <div class="accent-bar"></div>
      <p class="section-sub">Explore our diverse range of academic programs designed to prepare students for competitive examinations and professional careers.</p>
    </div>
    <div class="courses-grid">
      @forelse($courses as $course)
        <div class="course-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
          <div class="course-img">
            <div class="course-img-bg" style="background:linear-gradient(135deg, {{ $loop->index % 2 == 0 ? '#0B3C6D,#1565a0' : '#1a1a2e,#16213e' }})"></div>
            <i class="{{ $course->icon ?? 'fas fa-book' }}" style="position:relative;z-index:1;color:rgba(255,255,255,.9)"></i>
            <div class="course-badge">{{ $course->teacher->name ?? 'Course' }}</div>
          </div>
          <div class="course-body">
            <div class="course-title">{{ $course->name }}</div>
            <p class="course-desc">{{ $course->description }}</p>
            <div class="course-meta">
              <span><i class="fas fa-clock"></i> {{ $course->duration ?? 'N/A' }}</span>
              <span><i class="fas fa-users"></i> {{ $course->seats ?? 'N/A' }} Seats</span>
              <span><i class="fas fa-star"></i> {{ $course->rating ?? '4.8' }}/5</span>
            </div>
            <div class="course-footer">
              <div class="course-fee">Rs. {{ number_format($course->original_fee ?? 0) }}<small>per month</small></div>
              <a href="#contact" class="btn btn-primary" style="padding:9px 18px;font-size:.8rem;">Enroll Now</a>
            </div>
          </div>
        </div>
      @empty
        <!-- Fallback static courses if none in database -->
        <div class="course-card" data-aos="fade-up" data-aos-delay="0">
          <div class="course-img">
            <div class="course-img-bg" style="background:linear-gradient(135deg,#0B3C6D,#1565a0)"></div>
            <i class="fas fa-flask" style="position:relative;z-index:1;color:rgba(255,255,255,.9)"></i>
            <div class="course-badge">Science</div>
          </div>
          <div class="course-body">
            <div class="course-title">FSc Pre-Medical</div>
            <p class="course-desc">Prepare for medical entrance exams (MDCAT) with our intensive Pre-Medical program covering Biology, Chemistry, and Physics.</p>
            <div class="course-meta">
              <span><i class="fas fa-clock"></i> 2 Years</span>
              <span><i class="fas fa-users"></i> 180 Seats</span>
              <span><i class="fas fa-star"></i> 4.9/5</span>
            </div>
            <div class="course-footer">
              <div class="course-fee">Rs. 8,000<small>per month</small></div>
              <a href="#contact" class="btn btn-primary" style="padding:9px 18px;font-size:.8rem;">Enroll Now</a>
            </div>
          </div>
        </div>
        <!-- Add more fallback courses... -->
      @endforelse
    </div>
    <div style="text-align:center;margin-top:36px;">
      <a href="#contact" class="btn btn-navy"><i class="fas fa-th-large"></i> Enquire About All Courses</a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   ADMISSION PROCESS (Static - Keep as is)
═══════════════════════════════════════════════════ -->
<section id="admissions">
  <div class="container">
    <div class="text-center">
      <div class="section-tag"><i class="fas fa-clipboard-list"></i> How To Apply</div>
      <h2 class="section-title">Simple <span>Admission</span> Process</h2>
      <div class="accent-bar"></div>
      <p class="section-sub">Getting admitted to Leeds Institute is easy. Just walk in to our office and follow these simple steps.</p>
    </div>
    <div class="admission-steps">
      <div class="adm-step active" data-aos="fade-up" data-aos-delay="0">
        <div class="adm-circle">
          <i class="fas fa-building"></i>
          <div class="adm-num">1</div>
        </div>
        <h4>Come to Office</h4>
        <p>Visit us at our campus during office hours. Our friendly staff will guide you through the process.</p>
        <div class="adm-address">{{ $settings['contact']['address'] ?? 'Main Road, City, Pakistan' }}<br>Mon–Sat: 8 AM – 5 PM</div>
      </div>
      <div class="adm-step" data-aos="fade-up" data-aos-delay="80">
        <div class="adm-circle">
          <i class="fas fa-comments"></i>
          <div class="adm-num">2</div>
        </div>
        <h4>Discuss Your Course</h4>
        <p>Meet our academic advisor to select the right program based on your previous results and career goals.</p>
      </div>
      <div class="adm-step" data-aos="fade-up" data-aos-delay="160">
        <div class="adm-circle">
          <i class="fas fa-file-alt"></i>
          <div class="adm-num">3</div>
        </div>
        <h4>Registration</h4>
        <p>Fill out the admission form and pay the one-time registration fee of <strong>Rs. 1,000</strong> to secure your seat.</p>
      </div>
      <div class="adm-step" data-aos="fade-up" data-aos-delay="240">
        <div class="adm-circle">
          <i class="fas fa-money-bill-wave"></i>
          <div class="adm-num">4</div>
        </div>
        <h4>Fee Payment</h4>
        <p>Complete the fee payment for your chosen program. Monthly, quarterly, and annual plans available.</p>
      </div>
      <div class="adm-step" data-aos="fade-up" data-aos-delay="320">
        <div class="adm-circle">
          <i class="fas fa-check-double"></i>
          <div class="adm-num">5</div>
        </div>
        <h4>Confirmation</h4>
        <p>Receive your admission card, timetable, and student ID. You are now officially a Leeds student!</p>
      </div>
    </div>
    <div style="text-align:center;margin-top:48px;">
      <a href="#contact" class="btn btn-primary"><i class="fas fa-phone"></i> Contact Admissions Office</a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   STATS (Dynamic from Database)
═══════════════════════════════════════════════════ -->
<section id="stats">
  <div class="container">
    <div class="stats-grid">
      <div class="stat-item" data-aos="fade-up" data-aos-delay="0">
        <div class="stat-num" data-count="{{ $stats['students'] ?? 0 }}">{{ number_format($stats['students'] ?? 0) }}+</div>
        <div class="stat-label"><i class="fas fa-user-graduate" style="margin-right:6px"></i>Students Enrolled</div>
      </div>
      <div class="stat-item" data-aos="fade-up" data-aos-delay="80">
        <div class="stat-num" data-count="{{ $stats['teachers'] ?? 0 }}">{{ number_format($stats['teachers'] ?? 0) }}+</div>
        <div class="stat-label"><i class="fas fa-chalkboard-teacher" style="margin-right:6px"></i>Expert Teachers</div>
      </div>
      <div class="stat-item" data-aos="fade-up" data-aos-delay="160">
        <div class="stat-num" data-count="{{ $stats['courses'] ?? 0 }}">{{ number_format($stats['courses'] ?? 0) }}+</div>
        <div class="stat-label"><i class="fas fa-book" style="margin-right:6px"></i>Courses Offered</div>
      </div>
      <div class="stat-item" data-aos="fade-up" data-aos-delay="240">
        <div class="stat-num" data-count="{{ $stats['success_rate'] ?? 98 }}">{{ $stats['success_rate'] ?? 98 }}%</div>
        <div class="stat-label"><i class="fas fa-chart-line" style="margin-right:6px"></i>Success Rate</div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   TESTIMONIALS (Dynamic from Database)
═══════════════════════════════════════════════════ -->
<section id="testimonials">
  <div class="container">
    <div class="text-center">
      <div class="section-tag"><i class="fas fa-heart"></i> Student Stories</div>
      <h2 class="section-title">What Our <span>Students</span> Say</h2>
      <div class="accent-bar"></div>
    </div>
    <div class="testi-scroll-wrap">
      <div class="testi-track" id="testiTrack">
        <!-- Set 1 -->
        <div class="testi-card">
          <div class="testi-quote-bg">"</div>
          <div class="testi-stars">★★★★★</div>
          <p class="testi-text">Leeds Institute changed my life. The teachers genuinely care about every student. I secured A+ grades in FSc and got admission to a top medical college.</p>
          <div class="testi-author">
            <div class="testi-avatar"><i class="fas fa-user"></i></div>
            <div><div class="testi-name">Ayesha Tariq</div><div class="testi-course">FSc Pre-Medical, 2024</div></div>
          </div>
        </div>
        <div class="testi-card">
          <div class="testi-quote-bg">"</div>
          <div class="testi-stars">★★★★★</div>
          <p class="testi-text">My mathematics teacher made complex concepts so easy. I went from failing to topping the district — that kind of transformation only happens here at Leeds.</p>
          <div class="testi-author">
            <div class="testi-avatar" style="background:linear-gradient(135deg,#065f46,#059669)"><i class="fas fa-user"></i></div>
            <div><div class="testi-name">Hassan Mehmood</div><div class="testi-course">FSc Pre-Engineering, 2024</div></div>
          </div>
        </div>
        <div class="testi-card">
          <div class="testi-quote-bg">"</div>
          <div class="testi-stars">★★★★★</div>
          <p class="testi-text">As a parent I was nervous about choosing the right institute. Leeds exceeded every expectation — strict discipline and exceptional results. My son scored 1080/1100!</p>
          <div class="testi-author">
            <div class="testi-avatar" style="background:linear-gradient(135deg,#92400e,#d97706)"><i class="fas fa-user"></i></div>
            <div><div class="testi-name">Mr. Riaz Ahmed</div><div class="testi-course">Parent — Matric Section</div></div>
          </div>
        </div>
        <div class="testi-card">
          <div class="testi-quote-bg">"</div>
          <div class="testi-stars">★★★★★</div>
          <p class="testi-text">The Spoken English course completely transformed how I communicate. Within 3 months I could speak confidently in interviews. Best investment I ever made!</p>
          <div class="testi-author">
            <div class="testi-avatar" style="background:linear-gradient(135deg,#164e63,#0891b2)"><i class="fas fa-user"></i></div>
            <div><div class="testi-name">Zara Hussain</div><div class="testi-course">Spoken English Course, 2024</div></div>
          </div>
        </div>
        <div class="testi-card">
          <div class="testi-quote-bg">"</div>
          <div class="testi-stars">★★★★★</div>
          <p class="testi-text">Computer Lab facilities are top-notch. The teacher guided us practically on every project. I now work as a freelancer earning from home — all thanks to Leeds!</p>
          <div class="testi-author">
            <div class="testi-avatar" style="background:linear-gradient(135deg,#312e81,#4f46e5)"><i class="fas fa-user"></i></div>
            <div><div class="testi-name">Ali Raza</div><div class="testi-course">Computer Diploma, 2023</div></div>
          </div>
        </div>
        <div class="testi-card">
          <div class="testi-quote-bg">"</div>
          <div class="testi-stars">★★★★★</div>
          <p class="testi-text">I was worried about fees but Leeds has a very easy monthly payment option. The quality of education compared to the price is honestly unbeatable in this city.</p>
          <div class="testi-author">
            <div class="testi-avatar" style="background:linear-gradient(135deg,#7c2d12,#dc2626)"><i class="fas fa-user"></i></div>
            <div><div class="testi-name">Bilal Nawaz</div><div class="testi-course">I.Com, 2024</div></div>
          </div>
        </div>
        <!-- Set 2 (duplicate for seamless loop) -->
        <div class="testi-card">
          <div class="testi-quote-bg">"</div>
          <div class="testi-stars">★★★★★</div>
          <p class="testi-text">Leeds Institute changed my life. The teachers genuinely care about every student. I secured A+ grades in FSc and got admission to a top medical college.</p>
          <div class="testi-author">
            <div class="testi-avatar"><i class="fas fa-user"></i></div>
            <div><div class="testi-name">Ayesha Tariq</div><div class="testi-course">FSc Pre-Medical, 2024</div></div>
          </div>
        </div>
        <div class="testi-card">
          <div class="testi-quote-bg">"</div>
          <div class="testi-stars">★★★★★</div>
          <p class="testi-text">My mathematics teacher made complex concepts so easy. I went from failing to topping the district — that kind of transformation only happens here at Leeds.</p>
          <div class="testi-author">
            <div class="testi-avatar" style="background:linear-gradient(135deg,#065f46,#059669)"><i class="fas fa-user"></i></div>
            <div><div class="testi-name">Hassan Mehmood</div><div class="testi-course">FSc Pre-Engineering, 2024</div></div>
          </div>
        </div>
        <div class="testi-card">
          <div class="testi-quote-bg">"</div>
          <div class="testi-stars">★★★★★</div>
          <p class="testi-text">As a parent I was nervous about choosing the right institute. Leeds exceeded every expectation — strict discipline and exceptional results. My son scored 1080/1100!</p>
          <div class="testi-author">
            <div class="testi-avatar" style="background:linear-gradient(135deg,#92400e,#d97706)"><i class="fas fa-user"></i></div>
            <div><div class="testi-name">Mr. Riaz Ahmed</div><div class="testi-course">Parent — Matric Section</div></div>
          </div>
        </div>
        <div class="testi-card">
          <div class="testi-quote-bg">"</div>
          <div class="testi-stars">★★★★★</div>
          <p class="testi-text">The Spoken English course completely transformed how I communicate. Within 3 months I could speak confidently in interviews. Best investment I ever made!</p>
          <div class="testi-author">
            <div class="testi-avatar" style="background:linear-gradient(135deg,#164e63,#0891b2)"><i class="fas fa-user"></i></div>
            <div><div class="testi-name">Zara Hussain</div><div class="testi-course">Spoken English Course, 2024</div></div>
          </div>
        </div>
        <div class="testi-card">
          <div class="testi-quote-bg">"</div>
          <div class="testi-stars">★★★★★</div>
          <p class="testi-text">Computer Lab facilities are top-notch. The teacher guided us practically on every project. I now work as a freelancer earning from home — all thanks to Leeds!</p>
          <div class="testi-author">
            <div class="testi-avatar" style="background:linear-gradient(135deg,#312e81,#4f46e5)"><i class="fas fa-user"></i></div>
            <div><div class="testi-name">Ali Raza</div><div class="testi-course">Computer Diploma, 2023</div></div>
          </div>
        </div>
        <div class="testi-card">
          <div class="testi-quote-bg">"</div>
          <div class="testi-stars">★★★★★</div>
          <p class="testi-text">I was worried about fees but Leeds has a very easy monthly payment option. The quality of education compared to the price is honestly unbeatable in this city.</p>
          <div class="testi-author">
            <div class="testi-avatar" style="background:linear-gradient(135deg,#7c2d12,#dc2626)"><i class="fas fa-user"></i></div>
            <div><div class="testi-name">Bilal Nawaz</div><div class="testi-course">I.Com, 2024</div></div>
          </div>
        </div>
      </div>
    </div>
    <!-- About Leeds short badge -->
    <div class="testi-about-badge" data-aos="fade-up">
      <strong>🏫 About Leeds Institute</strong>
      Founded in 2005, Leeds Institute is a local institute dedicated to providing quality, affordable education in a disciplined environment. We have helped over 5,000 students achieve their academic dreams across Matric, FSc, ICS, and professional diploma programs. Our doors are open for every student who wants to succeed.
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   GALLERY (Static - Keep as is)
═══════════════════════════════════════════════════ -->
<section id="gallery">
  <div class="container">
    <div class="text-center">
      <div class="section-tag"><i class="fas fa-images"></i> Campus Gallery</div>
      <h2 class="section-title">Life at <span>Leeds Institute</span></h2>
      <div class="accent-bar"></div>
    </div>
    <div class="gallery-grid" data-aos="fade-up">
      <div class="gallery-item">
        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=600&q=80" alt="Campus" />
        <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
      </div>
      <div class="gallery-item">
        <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=400&q=80" alt="Classroom" />
        <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
      </div>
      <div class="gallery-item">
        <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?w=400&q=80" alt="Library" />
        <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
      </div>
      <div class="gallery-item">
        <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=600&q=80" alt="Students" />
        <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
      </div>
      <div class="gallery-item">
        <img src="https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=400&q=80" alt="Lab" />
        <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
      </div>
    </div>
    <div class="gallery-cta">
      <a href="#contact" class="btn btn-navy"><i class="fas fa-images"></i> View Full Gallery</a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   NEWS - Upcoming Events (Static)
═══════════════════════════════════════════════════ -->
<!-- <section id="news">
  <div class="container">
    <div class="text-center">
      <div class="section-tag"><i class="fas fa-calendar-alt"></i> What's Coming</div>
      <h2 class="section-title">Upcoming <span>Events</span></h2>
      <div class="accent-bar"></div>
      <p class="section-sub">Stay updated with our latest events, competitions, and important dates at Leeds Institute.</p>
    </div>
    <div class="events-grid">
      <div class="event-card" data-aos="fade-up" data-aos-delay="0">
        <div class="event-header">
          <div class="event-date-big">15</div>
          <div class="event-month">July 2025</div>
          <div class="event-icon"><i class="fas fa-pencil-alt"></i></div>
        </div>
        <div class="event-body">
          <div class="event-type">Admissions</div>
          <div class="event-title">Talent Test — Session 2025–26</div>
          <div class="event-status"><i class="fas fa-circle"></i> Registration Open</div>
        </div>
      </div>
      <div class="event-card" data-aos="fade-up" data-aos-delay="80">
        <div class="event-header" style="background:linear-gradient(135deg,#065f46,#059669)">
          <div class="event-date-big">22</div>
          <div class="event-month">July 2025</div>
          <div class="event-icon"><i class="fas fa-flask"></i></div>
        </div>
        <div class="event-body">
          <div class="event-type">Academic</div>
          <div class="event-title">Science Exhibition & Project Fair</div>
          <div class="event-status"><i class="fas fa-circle"></i> Open for All Students</div>
        </div>
      </div>
      <div class="event-card" data-aos="fade-up" data-aos-delay="160">
        <div class="event-header" style="background:linear-gradient(135deg,#7c2d12,#dc2626)">
          <div class="event-date-big">01</div>
          <div class="event-month">Aug 2025</div>
          <div class="event-icon"><i class="fas fa-graduation-cap"></i></div>
        </div>
        <div class="event-body">
          <div class="event-type">Ceremony</div>
          <div class="event-title">Annual Result & Prize Distribution</div>
          <div class="event-status"><i class="fas fa-circle"></i> Invite-Only Event</div>
        </div>
      </div>
    </div>
  </div>
</section> -->

<!-- ═══════════════════════════════════════════════════
   CALL TO ACTION
═══════════════════════════════════════════════════ -->
<section id="cta">
  <div class="container" style="position:relative;z-index:2">
    <div class="cta-badge"><i class="fas fa-fire"></i> Limited Seats Available</div>
    <h2>Admissions Are <span>Open</span><br>For 2025–26 Session</h2>
    <p>Don't miss your chance to be part of {{ $settings['institute']['name'] ?? 'Leeds Institute' }}. Contact our admissions office today before enrollment closes.</p>
    <div class="cta-btns">
      <a href="#contact" class="btn btn-outline" style="font-size:1rem;padding:15px 34px;"><i class="fas fa-phone"></i> Contact Admissions</a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   CONTACT (Dynamic)
═══════════════════════════════════════════════════ -->
<!-- ═══════════════════════════════════════════════════
   CONTACT (Dynamic with Form Submission)
═══════════════════════════════════════════════════ -->
<section id="contact">
  <div class="container">
    <div class="text-center">
      <div class="section-tag"><i class="fas fa-phone"></i> Get In Touch</div>
      <h2 class="section-title">Contact <span>Us</span></h2>
      <div class="accent-bar"></div>
      <p class="section-sub">Have questions about admissions, courses, or anything else? We're here to help.</p>
    </div>
    <div class="contact-grid">
      <div>
        <div class="contact-cards">
          <div class="contact-card">
            <div class="contact-icon"><i class="fas fa-phone"></i></div>
            <div class="contact-info">
              <h4>Phone Numbers</h4>
              <p>{{ $settings['contact']['phone'] ?? '+92-XXX-XXXXXXX' }}<br>{{ $settings['contact']['alternate_phone'] ?? '+92-XXX-XXXXXXX' }}</p>
            </div>
          </div>
          <div class="contact-card">
            <div class="contact-icon"><i class="fas fa-envelope"></i></div>
            <div class="contact-info">
              <h4>Email Address</h4>
              <a href="mailto:{{ $settings['contact']['email'] ?? 'info@leedsinstitute.edu.pk' }}">{{ $settings['contact']['email'] ?? 'info@leedsinstitute.edu.pk' }}</a>
            </div>
          </div>
          <div class="contact-card">
            <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div class="contact-info">
              <h4>Campus Address</h4>
              <p>{{ $settings['contact']['address'] ?? 'Leeds Institute, Main Road, City, Pakistan' }}</p>
            </div>
          </div>
          <div class="contact-card">
            <div class="contact-icon"><i class="fas fa-clock"></i></div>
            <div class="contact-info">
              <h4>Office Hours</h4>
              <p>Mon – Sat: 8:00 AM – 5:00 PM<br>Sunday: Closed</p>
            </div>
          </div>
        </div>
        <div class="contact-actions">
          <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['contact']['whatsapp'] ?? '923001234567') }}" 
             target="_blank" 
             class="btn btn-wa" 
             style="display:inline-flex;align-items:center;gap:8px;padding:12px 22px;border-radius:50px;font-weight:700;font-size:.88rem;background:#25D366;color:#fff;border:none;cursor:pointer;text-decoration:none;">
            <i class="fab fa-whatsapp"></i> WhatsApp Us
          </a>
          <a href="tel:{{ $settings['contact']['phone'] ?? '+92-XXX-XXXXXXX' }}" 
             class="btn btn-call" 
             style="display:inline-flex;align-items:center;gap:8px;padding:12px 22px;border-radius:50px;font-weight:700;font-size:.88rem;background:var(--navy);color:#fff;border:none;cursor:pointer;text-decoration:none;">
            <i class="fas fa-phone"></i> Call Now
          </a>
        </div>
      </div>
      <div class="contact-form-wrap" data-aos="fade-left">
        <h3><i class="fas fa-paper-plane" style="color:var(--navy);margin-right:8px"></i> Send Us a Message</h3>
        
        <!-- Success Message -->
        <div id="enquirySuccess" style="display:none;background:#10B981;color:#fff;padding:12px 16px;border-radius:8px;margin-bottom:16px;">
          <i class="fas fa-check-circle"></i> <span id="successMsg">Your enquiry has been submitted successfully!</span>
        </div>
        
        <!-- Error Message -->
        <div id="enquiryError" style="display:none;background:#EF4444;color:#fff;padding:12px 16px;border-radius:8px;margin-bottom:16px;">
          <i class="fas fa-exclamation-circle"></i> <span id="errorMsg">Something went wrong. Please try again.</span>
        </div>
        
        <form id="enquiryForm" onsubmit="submitEnquiry(event)">
          @csrf
          <div class="form-row">
            <div class="form-group">
              <label>Full Name <span class="required">*</span></label>
              <input type="text" id="full_name" name="full_name" placeholder="Your full name" required />
            </div>
            <div class="form-group">
              <label>Phone Number <span class="required">*</span></label>
              <input type="tel" id="phone_number" name="phone_number" placeholder="+92-XXX-XXXXXXX" required />
            </div>
          </div>
          <div class="form-group">
            <label>Email Address <span class="required">*</span></label>
            <input type="email" id="email" name="email" placeholder="your@email.com" required />
          </div>
          <div class="form-group">
            <label>Interested Course</label>
            <select id="interested_course" name="interested_course">
              <option value="">Select a course...</option>
              @foreach($courses as $course)
                <option value="{{ $course->name }}">{{ $course->name }}</option>
              @endforeach

              <option value="Other">Other</option>
            </select>
          </div>
          <div class="form-group">
            <label>Message</label>
            <textarea id="message" name="message" placeholder="Write your question or message here..." rows="4"></textarea>
          </div>
          <button type="submit" class="btn btn-primary" id="submitBtn" style="width:100%;justify-content:center;font-size:.95rem;padding:14px;">
            <i class="fas fa-paper-plane"></i> <span id="btnText">Send Message</span>
            <i class="fas fa-spinner fa-spin" id="btnSpinner" style="display:none;"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   MAP
═══════════════════════════════════════════════════ -->
<div id="map" style="padding:0 0 90px">
  <div class="container">
    <div class="map-wrap">
      <div class="map-placeholder">
        <i class="fas fa-map-marker-alt" style="color:var(--red)"></i>
        <p style="font-size:1rem;font-weight:600;color:var(--gray-600)">{{ $settings['institute']['name'] ?? 'Leeds Institute' }} Location</p>
        <p style="font-size:.85rem;margin-top:6px">{{ $settings['contact']['address'] ?? 'Main Road, City, Pakistan' }}</p>
        @if($settings['contact']['map_url'] ?? false)
          <iframe src="{{ $settings['contact']['map_url'] }}" width="100%" height="300" style="border:0;border-radius:12px;margin-top:12px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        @else
          <a href="#" class="btn btn-navy" style="margin-top:16px;font-size:.85rem;padding:10px 24px;"><i class="fas fa-directions"></i> Get Directions</a>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════════
   FAQ (Static)
═══════════════════════════════════════════════════ -->
<!-- <section id="faq" style="padding-top:0">
  <div class="container">
    <div class="text-center">
      <div class="section-tag"><i class="fas fa-question-circle"></i> FAQ</div>
      <h2 class="section-title">Frequently Asked <span>Questions</span></h2>
      <div class="accent-bar"></div>
    </div>
    <div class="faq-list">
      <div class="faq-item open">
        <div class="faq-q">
          What is the last date to apply for admission?
          <div class="faq-arrow"><i class="fas fa-chevron-down"></i></div>
        </div>
        <div class="faq-a">Admissions are open until all seats are filled. We recommend visiting the office as early as possible since seats are limited. Walk-in registration is available Monday through Saturday from 8 AM to 5 PM.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q">
          What documents are required at the time of admission?
          <div class="faq-arrow"><i class="fas fa-chevron-down"></i></div>
        </div>
        <div class="faq-a">You will need: your previous result card (original + photocopy), B-Form or CNIC photocopy, 4 passport-size photographs, and a school/college leaving certificate. All originals will be returned after verification.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q">
          Can I pay fees in monthly installments?
          <div class="faq-arrow"><i class="fas fa-chevron-down"></i></div>
        </div>
        <div class="faq-a">Yes, fees can be paid monthly at the institute's accounts office. We also offer quarterly and annual payment options. Annual payment carries a 10% discount. For families facing financial difficulty, easy installment plans are available on request.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q">
          Is there a uniform requirement at Leeds Institute?
          <div class="faq-arrow"><i class="fas fa-chevron-down"></i></div>
        </div>
        <div class="faq-a">Yes, all enrolled students are required to wear the Leeds Institute uniform. Details about the uniform (color, style, and where to purchase it) will be provided at the time of admission. Uniform is compulsory from the first day of classes.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q">
          Does Leeds Institute offer scholarships?
          <div class="faq-arrow"><i class="fas fa-chevron-down"></i></div>
        </div>
        <div class="faq-a">Yes. Students who scored 80% or above in their previous board exam are eligible for a merit scholarship. Need-based scholarships are also available for deserving students from low-income families. Please bring your income documents and ask the admissions officer at the time of visit.</div>
      </div>
      <div class="faq-item">
        <div class="faq-q">
          What are the timings of classes?
          <div class="faq-arrow"><i class="fas fa-chevron-down"></i></div>
        </div>
        <div class="faq-a">Classes run in two shifts: Morning Shift from 7:30 AM to 12:30 PM, and Evening Shift from 1:30 PM to 6:00 PM. Shift allocation depends on the program and availability. Preference can be discussed at the time of admission.</div>
      </div>
    </div>
  </div>
</section> -->

<!-- ═══════════════════════════════════════════════════
   NEWSLETTER
═══════════════════════════════════════════════════ -->
<!-- <section id="newsletter">
  <div class="container">
    <div class="section-tag" style="background:rgba(11,60,109,.12);"><i class="fas fa-envelope"></i> Stay Updated</div>
    <h2>Subscribe to Our Newsletter</h2>
    <p>Get the latest news, admission alerts, and exam schedules delivered to your inbox.</p>
    <form class="nl-form" onsubmit="return false;">
      <input type="email" placeholder="Enter your email address..." />
      <button type="submit"><i class="fas fa-paper-plane"></i> Subscribe</button>
    </form>
  </div>
</section> -->

<!-- ═══════════════════════════════════════════════════
   FOOTER (Dynamic)
═══════════════════════════════════════════════════ -->
<footer id="footer">
  <div class="footer-top">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <a href="#hero" class="logo">
            <div class="logo-mark">LI</div>
            <div class="logo-text">
              <strong>{{ $settings['institute']['name'] ?? 'Leeds Institute' }}</strong>
              <span>{{ $settings['institute']['tagline'] ?? 'Quality Education Since 2005' }}</span>
            </div>
          </a>
          <p>{{ $settings['about']['about_us'] ?? 'Leeds Institute is dedicated to delivering quality education that prepares students for academic excellence and lifelong success in an ever-changing world.' }}</p>
          <div class="footer-social">
            @if($settings['social']['facebook'] ?? false)
              <a href="{{ $settings['social']['facebook'] }}" class="social-btn" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            @endif
            @if($settings['social']['twitter'] ?? false)
              <a href="{{ $settings['social']['twitter'] }}" class="social-btn" title="Twitter"><i class="fab fa-twitter"></i></a>
            @endif
            @if($settings['social']['instagram'] ?? false)
              <a href="{{ $settings['social']['instagram'] }}" class="social-btn" title="Instagram"><i class="fab fa-instagram"></i></a>
            @endif
            @if($settings['social']['youtube'] ?? false)
              <a href="{{ $settings['social']['youtube'] }}" class="social-btn" title="YouTube"><i class="fab fa-youtube"></i></a>
            @endif
            @if($settings['social']['tiktok'] ?? false)
              <a href="{{ $settings['social']['tiktok'] }}" class="social-btn" title="WhatsApp"><i class="fab fa-tiktok"></i></a>
            @endif
          </div>
        </div>
        <div class="footer-col">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="#hero"><i class="fas fa-chevron-right"></i> Home</a></li>
            <li><a href="#about"><i class="fas fa-chevron-right"></i> About Us</a></li>
            <li><a href="#teachers"><i class="fas fa-chevron-right"></i> Our Faculty</a></li>
            <li><a href="#gallery"><i class="fas fa-chevron-right"></i> Gallery</a></li>
            <li><a href="#news"><i class="fas fa-chevron-right"></i> Events</a></li>
            <li><a href="#contact"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Programs</h4>
          <ul>
            @foreach($courses as $course)
              <li><a href="#courses"><i class="fas fa-chevron-right"></i> {{ $course->name }}</a></li>
            @endforeach
          </ul>
        </div>
        <div class="footer-col">
          <h4>Admissions</h4>
          <ul>
            <li><a href="#admissions"><i class="fas fa-chevron-right"></i> Visit Our Office</a></li>
            <li><a href="#admissions"><i class="fas fa-chevron-right"></i> Admission Process</a></li>
            <li><a href="#faq"><i class="fas fa-chevron-right"></i> Scholarships</a></li>
            <li><a href="#faq"><i class="fas fa-chevron-right"></i> Fee Structure</a></li>
            <li><a href="#faq"><i class="fas fa-chevron-right"></i> FAQs</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Contact Info</h4>
          <ul class="footer-contact">
            <li><i class="fas fa-map-marker-alt"></i> {{ $settings['contact']['address'] ?? 'Main Road, City, Pakistan' }}</li>
            <li><i class="fas fa-phone"></i> {{ $settings['contact']['phone'] ?? '+92-XXX-XXXXXXX' }}</li>
            <li><i class="fas fa-envelope"></i> {{ $settings['contact']['email'] ?? 'info@leedsinstitute.edu.pk' }}</li>
            <li><i class="fab fa-whatsapp"></i> {{ $settings['contact']['whatsapp'] ?? '+92-XXX-XXXXXXX' }}</li>
            <li><i class="fas fa-clock"></i> Mon–Sat: 8:00 AM – 5:00 PM</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="footer-bottom">
      <div style="color:rgba(255,255,255,.45)">
        &copy; 2025 {{ $settings['institute']['name'] ?? 'Leeds Institute' }}. All Rights Reserved.
      </div>
      <div class="footer-links">
        <a href="#">Privacy Policy</a>
        <a href="#">Terms & Conditions</a>
        <a href="#">Sitemap</a>
      </div>
    </div>
  </div>
</footer>

<button id="back-top" title="Back to Top"><i class="fas fa-chevron-up"></i></button>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // ─── Enquiry Form Submission ─────────────────────────────
    const enquiryForm = document.getElementById('enquiryForm');
    if (enquiryForm) {
        enquiryForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const form = this;
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');
            const successDiv = document.getElementById('enquirySuccess');
            const errorDiv = document.getElementById('enquiryError');
            const successMsg = document.getElementById('successMsg');
            const errorMsg = document.getElementById('errorMsg');
            
            // Hide previous messages
            if (successDiv) successDiv.style.display = 'none';
            if (errorDiv) errorDiv.style.display = 'none';
            
            // Show loading state
            if (btnText) btnText.textContent = 'Sending...';
            if (btnSpinner) btnSpinner.style.display = 'inline-block';
            if (submitBtn) submitBtn.disabled = true;
            
            const formData = new FormData(form);
            
            // Get CSRF token safely
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            const token = csrfToken ? csrfToken.content : '';
            
            fetch('{{ route("store.enquiry") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Reset button state
                if (btnText) btnText.textContent = 'Send Message';
                if (btnSpinner) btnSpinner.style.display = 'none';
                if (submitBtn) submitBtn.disabled = false;
                
                if (data.success) {
                    // Show success message
                    if (successMsg) successMsg.textContent = data.message;
                    if (successDiv) successDiv.style.display = 'block';
                    
                    // Reset form
                    form.reset();
                    
                    // Auto-hide success after 5 seconds
                    setTimeout(() => {
                        if (successDiv) successDiv.style.display = 'none';
                    }, 5000);
                } else {
                    // Show error message
                    if (errorMsg) errorMsg.textContent = data.message || 'Something went wrong. Please try again.';
                    if (errorDiv) errorDiv.style.display = 'block';
                    
                    // Auto-hide error after 5 seconds
                    setTimeout(() => {
                        if (errorDiv) errorDiv.style.display = 'none';
                    }, 5000);
                }
            })
            .catch(error => {
                // Reset button state
                if (btnText) btnText.textContent = 'Send Message';
                if (btnSpinner) btnSpinner.style.display = 'none';
                if (submitBtn) submitBtn.disabled = false;
                
                // Show error message
                if (errorMsg) errorMsg.textContent = 'Network error. Please check your connection and try again.';
                if (errorDiv) errorDiv.style.display = 'block';
                
                setTimeout(() => {
                    if (errorDiv) errorDiv.style.display = 'none';
                }, 5000);
                
                console.error('Error:', error);
            });
        });
    }

    // ─── AOS Init ──────────────────────────────────────────────
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 700, once: true, offset: 60, easing: 'ease-out-cubic' });
    }

    // ─── Header Scroll ────────────────────────────────────────
    const header = document.getElementById('header');
    const backTop = document.getElementById('back-top');
    
    window.addEventListener('scroll', () => {
        if (header) {
            header.classList.toggle('scrolled', window.scrollY > 50);
        }
        if (backTop) {
            backTop.classList.toggle('show', window.scrollY > 400);
        }
    });

    if (backTop) {
        backTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // ─── Hamburger toggle (Left Sidebar) ───────────────────
    const hamburger = document.getElementById('hamburger');
    const mobileNav = document.getElementById('mobileNav');
    const navClose = document.getElementById('navClose');
    const overlay = document.getElementById('mobileOverlay');

    function openNav() {
        if (mobileNav) mobileNav.classList.add('open');
        if (overlay) overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    
    function closeNav() {
        if (mobileNav) mobileNav.classList.remove('open');
        if (overlay) overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    if (hamburger) hamburger.addEventListener('click', openNav);
    if (navClose) navClose.addEventListener('click', closeNav);
    if (overlay) overlay.addEventListener('click', closeNav);

    // Close when clicking a link
    document.querySelectorAll('.mobile-nav a').forEach(link => {
        link.addEventListener('click', closeNav);
    });

    // ── Active nav link ─────────────────────────────────
    const sections = document.querySelectorAll('section[id], div[id]');
    const navLinks = document.querySelectorAll('.nav-list a');
    
    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(s => {
            if (window.scrollY >= s.offsetTop - 120) current = s.id;
        });
        navLinks.forEach(a => {
            a.classList.remove('active');
            if (a.getAttribute('href') === '#' + current) a.classList.add('active');
        });
    });

    // ── Counter animation ───────────────────────────────
    function animateCounters() {
        document.querySelectorAll('.stat-num[data-count]').forEach(el => {
            const target = parseInt(el.dataset.count);
            const suffix = el.textContent.replace(/[0-9]/g, '');
            let count = 0;
            const step = Math.ceil(target / 80);
            const timer = setInterval(() => {
                count = Math.min(count + step, target);
                el.textContent = count.toLocaleString() + suffix;
                if (count >= target) clearInterval(timer);
            }, 18);
        });
    }
    
    const statsEl = document.getElementById('stats');
    let counted = false;
    const io = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting && !counted) { 
            counted = true; 
            animateCounters(); 
        }
    }, { threshold: 0.3 });
    if (statsEl) io.observe(statsEl);

    // ── FAQ accordion ───────────────────────────────────
    document.querySelectorAll('.faq-q').forEach(q => {
        q.addEventListener('click', () => {
            const item = q.parentElement;
            const wasOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
            if (!wasOpen) item.classList.add('open');
        });
    });

    // ── Smooth internal links ───────────────────────────
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const id = a.getAttribute('href');
            if (id === '#') return;
            const target = document.querySelector(id);
            if (target) { 
                e.preventDefault(); 
                target.scrollIntoView({ behavior: 'smooth', block: 'start' }); 
            }
        });
    });
});
</script>
</body>
</html>