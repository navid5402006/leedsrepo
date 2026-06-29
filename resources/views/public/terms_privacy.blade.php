<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
  <title>Terms & Privacy – Leeds Institute</title>
  <meta name="description" content="Read the Terms & Conditions and Privacy Policy of Leeds Institute." />

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

    /* ═══════════════════════════════════════════════════
       HEADER (same as home)
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

    /* ─── HAMBURGER ─── */
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

    /* ─── MOBILE SIDEBAR NAV ─── */
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
       TERMS & PRIVACY PAGE
    ═══════════════════════════════════════════════════ */
    .legal-page-hero {
      min-height: 40vh;
      background: linear-gradient(135deg, #071e36 0%, #0B3C6D 45%, #1565a0 100%);
      display: flex;
      align-items: center;
      padding-top: 80px;
      position: relative;
      overflow: hidden;
    }
    .legal-page-hero::before {
      content: ''; position: absolute; inset: 0;
      background-image:
        radial-gradient(circle at 20% 80%, rgba(255,193,7,.08) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(229,57,53,.06) 0%, transparent 50%);
      pointer-events: none;
    }
    .legal-page-hero .hero-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2rem, 5vw, 3.2rem);
      font-weight: 800; color: var(--white);
      line-height: 1.15;
    }
    .legal-page-hero .hero-title span { color: var(--yellow); }
    .legal-page-hero p {
      color: rgba(255,255,255,.78);
      font-size: 1.05rem;
      max-width: 560px;
      margin-top: 12px;
    }

    /* Tabs */
    .legal-tabs {
      display: flex;
      gap: 12px;
      justify-content: center;
      margin-top: 32px;
      flex-wrap: wrap;
    }
    .legal-tab {
      padding: 12px 32px;
      border-radius: 50px;
      font-weight: 700;
      font-size: .9rem;
      cursor: pointer;
      transition: var(--transition);
      border: 2px solid var(--gray-200);
      background: var(--white);
      color: var(--gray-600);
    }
    .legal-tab:hover {
      border-color: var(--navy);
      color: var(--navy);
    }
    .legal-tab.active {
      background: var(--navy);
      color: var(--white);
      border-color: var(--navy);
      box-shadow: var(--shadow-sm);
    }
    .legal-tab i { margin-right: 8px; }

    /* Content Cards */
    .legal-content {
      margin-top: 40px;
    }
    .legal-card {
      background: var(--white);
      border-radius: var(--radius-xl);
      padding: 48px 56px;
      box-shadow: var(--shadow);
      border: 1px solid var(--gray-200);
      display: none;
      animation: fadeSlide .5s ease;
    }
    .legal-card.active {
      display: block;
    }
    @keyframes fadeSlide {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .legal-card h2 {
      font-family: 'Playfair Display', serif;
      font-size: 1.8rem;
      color: var(--navy);
      margin-bottom: 8px;
    }
    .legal-card .last-updated {
      color: var(--gray-400);
      font-size: .85rem;
      margin-bottom: 24px;
      display: block;
    }
    .legal-card h3 {
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--navy);
      margin: 24px 0 10px;
    }
    .legal-card h3:first-of-type { margin-top: 0; }
    .legal-card p {
      color: var(--gray-600);
      line-height: 1.8;
      margin-bottom: 12px;
      font-size: .95rem;
    }
    .legal-card ul {
      list-style: none;
      padding: 0;
      margin: 12px 0 16px;
    }
    .legal-card ul li {
      padding: 8px 0 8px 28px;
      position: relative;
      color: var(--gray-600);
      font-size: .92rem;
      line-height: 1.6;
      border-bottom: 1px solid var(--gray-100);
    }
    .legal-card ul li:last-child { border-bottom: none; }
    .legal-card ul li::before {
      content: '▸';
      position: absolute;
      left: 0;
      color: var(--yellow2);
      font-weight: 700;
    }

    /* ─── SOCIAL MEDIA ICONS IN FOOTER ─── */
    .footer-social {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }
    .social-btn {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      background: rgba(255,255,255,.08);
      color: rgba(255,255,255,.7);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .9rem;
      transition: var(--transition);
      text-decoration: none;
      border: none;
      cursor: pointer;
    }
    .social-btn:hover {
      background: var(--yellow);
      color: var(--navy);
      transform: translateY(-2px);
    }
    .social-btn:active {
      transform: scale(.95);
    }

    /* ═══════════════════════════════════════════════════
       FOOTER (same as home)
    ═══════════════════════════════════════════════════ */
    #footer {
      background: var(--navy2);
      color: rgba(255,255,255,.75);
    }
    .footer-top { padding: 70px 0 50px; }
    .footer-grid {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1fr 1.5fr;
      gap: 40px;
    }
    .footer-brand .logo { margin-bottom: 18px; }
    .footer-brand p { font-size: .88rem; line-height: 1.75; margin-bottom: 22px; }
    .footer-social { display: flex; gap: 10px; flex-wrap: wrap; }
    .social-btn {
      width: 38px; height: 38px; border-radius: 10px;
      background: rgba(255,255,255,.08);
      color: rgba(255,255,255,.7);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .9rem;
      transition: var(--transition);
    }
    .social-btn:hover { background: var(--yellow); color: var(--navy); transform: translateY(-2px); }
    .footer-col h4 {
      color: var(--white);
      font-size: .9rem;
      font-weight: 700;
      margin-bottom: 18px;
      letter-spacing: .5px;
    }
    .footer-col h4::after {
      content: '';
      display: block;
      width: 28px;
      height: 2px;
      background: var(--yellow);
      margin-top: 8px;
      border-radius: 1px;
    }
    .footer-col ul { display: flex; flex-direction: column; gap: 10px; }
    .footer-col ul li a {
      font-size: .86rem;
      color: rgba(255,255,255,.62);
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: 7px;
    }
    .footer-col ul li a:hover { color: var(--yellow); padding-left: 4px; }
    .footer-col ul li a i { font-size: .65rem; color: var(--yellow); }
    .footer-contact li {
      display: flex;
      gap: 12px;
      font-size: .86rem;
      color: rgba(255,255,255,.62);
      align-items: flex-start;
      margin-bottom: 10px;
    }
    .footer-contact li i { color: var(--yellow); margin-top: 3px; flex-shrink: 0; width: 14px; }

    .footer-bottom {
      border-top: 1px solid rgba(255,255,255,.08);
      padding: 22px 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: .82rem;
      flex-wrap: wrap;
      gap: 12px;
    }
    .footer-bottom a { color: rgba(255,255,255,.5); transition: var(--transition); }
    .footer-bottom a:hover { color: var(--yellow); }
    .footer-links { display: flex; gap: 20px; }

    #back-top {
      position: fixed;
      bottom: 28px;
      right: 28px;
      z-index: 999;
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: var(--navy);
      color: var(--white);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      box-shadow: var(--shadow);
      opacity: 0;
      pointer-events: none;
      transition: var(--transition);
      cursor: pointer;
      border: none;
    }
    #back-top.show { opacity: 1; pointer-events: auto; }
    #back-top:hover { background: var(--yellow); color: var(--navy); transform: translateY(-3px); }

    /* ═══════════════════════════════════════════════════
       RESPONSIVE — MOBILE
    ═══════════════════════════════════════════════════ */
    @media (max-width: 768px) {
      section { padding: 40px 0; }
      .container { padding: 0 14px; overflow-x: hidden; }

      /* Header */
      .nav-actions { display: none; }
      nav { display: none; }
      .hamburger { display: flex; margin-left: auto; }
      #header { padding: 0 14px; width: 100%; }
      .nav-inner { padding: 10px 0; gap: 8px; width: 100%; }
      .logo-mark { width: 34px; height: 34px; font-size: .85rem; border-radius: 8px; }
      .logo-text strong { font-size: .72rem; }
      .logo-text span { font-size: .5rem; }

      /* Legal Hero */
      .legal-page-hero { min-height: 30vh; padding-top: 60px; padding-bottom: 30px; }
      .legal-page-hero .hero-title { font-size: clamp(1.4rem, 5vw, 1.9rem); }
      .legal-page-hero p { font-size: .82rem; }

      /* Tabs - mobile */
      .legal-tabs {
        gap: 8px;
        margin-top: 20px;
      }
      .legal-tab {
        padding: 8px 18px;
        font-size: .78rem;
        border-radius: 30px;
      }
      .legal-tab i { margin-right: 4px; }

      /* Legal Cards - mobile */
      .legal-card {
        padding: 24px 18px;
        border-radius: 16px;
        margin-top: 16px;
      }
      .legal-card h2 {
        font-size: 1.3rem;
      }
      .legal-card .last-updated {
        font-size: .72rem;
        margin-bottom: 16px;
      }
      .legal-card h3 {
        font-size: .9rem;
        margin: 18px 0 8px;
      }
      .legal-card p {
        font-size: .82rem;
        line-height: 1.6;
      }
      .legal-card ul li {
        font-size: .8rem;
        padding: 6px 0 6px 22px;
      }

      /* Footer */
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

      .footer-bottom {
        flex-direction: column;
        text-align: center;
        gap: 4px;
        padding: 10px 0;
        font-size: .55rem;
      }
      .footer-links { gap: 8px; justify-content: center; }

      #back-top { width: 32px; height: 32px; font-size: .6rem; bottom: 12px; right: 12px; border-radius: 50%; }

      .section-tag { font-size: .55rem; padding: 3px 10px; margin-bottom: 6px; border-radius: 30px; }
      .section-tag i { font-size: .5rem; }
      .section-title { font-size: clamp(1.1rem, 4vw, 1.4rem); }
      .section-sub { font-size: .68rem; margin-top: 4px; }
      .accent-bar { width: 28px; height: 3px; margin: 8px 0 0; }
    }

    @media (max-width: 480px) {
      .legal-tab {
        padding: 6px 14px;
        font-size: .7rem;
      }
      .footer-grid { grid-template-columns: 1fr 1fr; }
      .footer-brand { grid-column: span 2; }
    }
  </style>
</head>
<body>

<!-- ═══════════════════════════════════════════════════
   MOBILE OVERLAY
═══════════════════════════════════════════════════ -->
<div class="mobile-overlay" id="mobileOverlay"></div>

<!-- ═══════════════════════════════════════════════════
   MOBILE SIDEBAR NAV
═══════════════════════════════════════════════════ -->
<div class="mobile-nav" id="mobileNav">
  <div class="mobile-nav-header">
    <div class="mobile-nav-brand">
      <div class="logo-mark-sm">LI</div>
      <span>Leeds Institute</span>
    </div>
    <button class="mobile-nav-close" id="navClose"><i class="fas fa-times"></i></button>
  </div>
  <a href="index.html" onclick="closeNav()"><i class="fas fa-home"></i> Home</a>
  <a href="about.html" onclick="closeNav()"><i class="fas fa-info-circle"></i> About</a>
  <a href="courses.html" onclick="closeNav()"><i class="fas fa-book-open"></i> Courses</a>
  <a href="admissions.html" onclick="closeNav()"><i class="fas fa-clipboard-list"></i> Admissions</a>
  <a href="results.html" onclick="closeNav()"><i class="fas fa-graduation-cap"></i> Results</a>
  <a href="crt-verify.html" onclick="closeNav()"><i class="fas fa-certificate"></i> CRT Verify</a>
  <a href="faq.html" onclick="closeNav()"><i class="fas fa-question-circle"></i> FAQ</a>
  <a href="teachers.html" onclick="closeNav()"><i class="fas fa-chalkboard-teacher"></i> Teachers</a>
  <a href="gallery.html" onclick="closeNav()"><i class="fas fa-images"></i> Gallery</a>
  <a href="contact.html" onclick="closeNav()"><i class="fas fa-phone"></i> Contact</a>
  <a href="terms.html" onclick="closeNav()" class="active"><i class="fas fa-file-contract"></i> Terms & Privacy</a>
</div>

<!-- ═══════════════════════════════════════════════════
   HEADER
═══════════════════════════════════════════════════ -->
<header id="header">
  <div class="container">
    <div class="nav-inner">
      <a href="index.html" class="logo">
        <div class="logo-mark">LI</div>
        <div class="logo-text">
          <strong>Leeds Institute</strong>
          <span>Quality Education Since 2005</span>
        </div>
      </a>
      <nav>
        <ul class="nav-list">
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="courses.html">Courses</a></li>
          <li><a href="admissions.html">Admissions</a></li>
          <li><a href="results.html">Results</a></li>
          <li><a href="crt-verify.html">CRT Verify</a></li>
          <li><a href="faq.html">FAQ</a></li>
          <li><a href="teachers.html">Teachers</a></li>
          <li><a href="gallery.html">Gallery</a></li>
          <li><a href="contact.html">Contact</a></li>
          <li><a href="terms.html" class="active">Terms & Privacy</a></li>
        </ul>
      </nav>
      <div class="nav-actions">
        <!-- Apply Now & Login buttons removed -->
      </div>
      <button class="hamburger" id="hamburger" aria-label="Menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>

<!-- ═══════════════════════════════════════════════════
   LEGAL PAGE HERO
═══════════════════════════════════════════════════ -->
<section class="legal-page-hero">
  <div class="container">
    <div class="hero-content" data-aos="fade-up">
      <div class="section-tag" style="background:rgba(255,193,7,.15);color:var(--yellow);border:1px solid rgba(255,193,7,.2);">
        <i class="fas fa-file-contract"></i> Legal
      </div>
      <h1 class="hero-title">Terms &amp; <span>Privacy</span></h1>
      <p>Read our Terms & Conditions and Privacy Policy to understand how we operate and protect your information.</p>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   LEGAL CONTENT
═══════════════════════════════════════════════════ -->
<section style="padding-top:0;">
  <div class="container">
    <!-- Tabs -->
    <div class="legal-tabs" data-aos="fade-up">
      <button class="legal-tab active" data-tab="terms">
        <i class="fas fa-file-contract"></i> Terms & Conditions
      </button>
      <button class="legal-tab" data-tab="privacy">
        <i class="fas fa-shield-alt"></i> Privacy Policy
      </button>
    </div>

    <!-- Content -->
    <div class="legal-content">
      <!-- Terms & Conditions -->
      <div class="legal-card active" id="terms-content" data-aos="fade-up">
        <h2>Terms &amp; Conditions</h2>
        <span class="last-updated">Last Updated: June 28, 2025</span>

        <h3>1. Acceptance of Terms</h3>
        <p>By accessing and using the Leeds Institute website, you agree to comply with and be bound by the following terms and conditions. If you do not agree with any part of these terms, please do not use our website.</p>

        <h3>2. Use of Website</h3>
        <p>You agree to use this website only for lawful purposes and in a manner that does not infringe the rights of, or restrict the use of, this website by any third party.</p>
        <ul>
          <li>You may not use this website to distribute any harmful or illegal content.</li>
          <li>You may not attempt to gain unauthorized access to any part of this website.</li>
          <li>You may not use this website in any way that could damage, disable, or impair the website.</li>
        </ul>

        <h3>3. Intellectual Property</h3>
        <p>All content on this website, including text, graphics, logos, images, and software, is the property of Leeds Institute and is protected by copyright and other intellectual property laws.</p>
        <ul>
          <li>You may not reproduce, distribute, or create derivative works from any content on this website without prior written permission.</li>
          <li>You may download or print content for personal, non-commercial use only.</li>
        </ul>

        <h3>4. Enrollment and Payments</h3>
        <p>All enrollment and admission procedures are subject to the policies outlined in the institute's official prospectus. Fees are non-refundable after the designated refund period.</p>
        <ul>
          <li>Registration fees are non-refundable once paid.</li>
          <li>Tuition fees are subject to change with prior notice.</li>
          <li>All students must abide by the institute's code of conduct.</li>
        </ul>

        <h3>5. Disclaimer of Warranties</h3>
        <p>This website is provided "as is" without any representations or warranties, express or implied. Leeds Institute does not warrant that this website will be constantly available or error-free.</p>

        <h3>6. Limitation of Liability</h3>
        <p>In no event shall Leeds Institute be liable for any damages arising out of or in connection with the use of this website. This includes, without limitation, direct, indirect, or consequential damages.</p>

        <h3>7. Changes to Terms</h3>
        <p>Leeds Institute reserves the right to revise these terms and conditions at any time. By continuing to use this website, you agree to be bound by the updated terms.</p>

        <h3>8. Contact Information</h3>
        <p>If you have any questions about these Terms & Conditions, please contact us at <a href="mailto:info@leedsinstitute.edu.pk" style="color:var(--navy);font-weight:600;">info@leedsinstitute.edu.pk</a> or call +92-XXX-XXXXXXX.</p>
      </div>

      <!-- Privacy Policy -->
      <div class="legal-card" id="privacy-content" data-aos="fade-up">
        <h2>Privacy Policy</h2>
        <span class="last-updated">Last Updated: June 28, 2025</span>

        <h3>1. Information We Collect</h3>
        <p>Leeds Institute collects personal information that you voluntarily provide to us when you enroll, contact us, or use our services. This may include:</p>
        <ul>
          <li>Full name, date of birth, and contact information (email, phone, address).</li>
          <li>Academic records and previous educational history.</li>
          <li>Payment and billing information for fee transactions.</li>
          <li>Any other information you choose to provide to us.</li>
        </ul>

        <h3>2. How We Use Your Information</h3>
        <p>We use your personal information for the following purposes:</p>
        <ul>
          <li>To process your admission and enrollment applications.</li>
          <li>To communicate with you about your academic progress and institute updates.</li>
          <li>To manage fee payments and financial records.</li>
          <li>To improve our educational services and website experience.</li>
          <li>To comply with legal and regulatory requirements.</li>
        </ul>

        <h3>3. Information Sharing</h3>
        <p>We do not sell, trade, or rent your personal information to third parties. We may share your information with:</p>
        <ul>
          <li>Teachers and administrative staff for academic purposes.</li>
          <li>Government authorities as required by law.</li>
          <li>Service providers who assist us in operating our institute (e.g., payment processors).</li>
        </ul>

        <h3>4. Data Security</h3>
        <p>We take reasonable measures to protect your personal information from unauthorized access, alteration, or disclosure. However, no method of transmission over the internet is 100% secure.</p>
        <ul>
          <li>We use secure servers and encryption for sensitive data.</li>
          <li>Access to personal information is restricted to authorized personnel only.</li>
        </ul>

        <h3>5. Your Rights</h3>
        <p>You have the right to:</p>
        <ul>
          <li>Access the personal information we hold about you.</li>
          <li>Request correction of inaccurate or incomplete information.</li>
          <li>Request deletion of your personal information, subject to legal requirements.</li>
          <li>Opt-out of receiving marketing communications.</li>
        </ul>

        <h3>6. Cookies</h3>
        <p>Our website uses cookies to enhance your browsing experience. You can choose to accept or decline cookies through your browser settings. Please note that declining cookies may affect the functionality of some website features.</p>

        <h3>7. Third-Party Links</h3>
        <p>Our website may contain links to third-party websites. We are not responsible for the privacy practices or content of these external sites. We encourage you to review their privacy policies.</p>

        <h3>8. Changes to Privacy Policy</h3>
        <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page with an updated "Last Updated" date.</p>

        <h3>9. Contact Us</h3>
        <p>If you have any questions or concerns about this Privacy Policy, please contact us at <a href="mailto:info@leedsinstitute.edu.pk" style="color:var(--navy);font-weight:600;">info@leedsinstitute.edu.pk</a> or call +92-XXX-XXXXXXX.</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   FOOTER
═══════════════════════════════════════════════════ -->
<footer id="footer">
  <div class="footer-top">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <a href="index.html" class="logo">
            <div class="logo-mark">LI</div>
            <div class="logo-text">
              <strong>Leeds Institute</strong>
              <span>Quality Education Since 2005</span>
            </div>
          </a>
          <p>Leeds Institute is dedicated to delivering quality education that prepares students for academic excellence and lifelong success in an ever-changing world.</p>
          <div class="footer-social">
            <a href="#" class="social-btn" title="Facebook" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-btn" title="Twitter" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-btn" title="Instagram" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-btn" title="YouTube" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            <a href="#" class="social-btn" title="WhatsApp" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
            <a href="#" class="social-btn" title="LinkedIn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>
        <div class="footer-col">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="index.html"><i class="fas fa-chevron-right"></i> Home</a></li>
            <li><a href="about.html"><i class="fas fa-chevron-right"></i> About Us</a></li>
            <li><a href="teachers.html"><i class="fas fa-chevron-right"></i> Our Faculty</a></li>
            <li><a href="gallery.html"><i class="fas fa-chevron-right"></i> Gallery</a></li>
            <li><a href="contact.html"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Programs</h4>
          <ul>
            <li><a href="courses.html"><i class="fas fa-chevron-right"></i> FSc Pre-Medical</a></li>
            <li><a href="courses.html"><i class="fas fa-chevron-right"></i> FSc Pre-Engineering</a></li>
            <li><a href="courses.html"><i class="fas fa-chevron-right"></i> ICS / I.Com</a></li>
            <li><a href="courses.html"><i class="fas fa-chevron-right"></i> Matric Science</a></li>
            <li><a href="courses.html"><i class="fas fa-chevron-right"></i> Computer Diploma</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Admissions</h4>
          <ul>
            <li><a href="admissions.html"><i class="fas fa-chevron-right"></i> Visit Our Office</a></li>
            <li><a href="admissions.html"><i class="fas fa-chevron-right"></i> Admission Process</a></li>
            <li><a href="faq.html"><i class="fas fa-chevron-right"></i> Scholarships</a></li>
            <li><a href="faq.html"><i class="fas fa-chevron-right"></i> Fee Structure</a></li>
            <li><a href="faq.html"><i class="fas fa-chevron-right"></i> FAQs</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Contact Info</h4>
          <ul class="footer-contact">
            <li><i class="fas fa-map-marker-alt"></i> Main Road, City, Pakistan</li>
            <li><i class="fas fa-phone"></i> +92-XXX-XXXXXXX</li>
            <li><i class="fas fa-envelope"></i> info@leedsinstitute.edu.pk</li>
            <li><i class="fab fa-whatsapp"></i> +92-XXX-XXXXXXX</li>
            <li><i class="fas fa-clock"></i> Mon–Sat: 8:00 AM – 5:00 PM</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="footer-bottom">
      <div style="color:rgba(255,255,255,.45)">
        &copy; 2025 Leeds Institute. All Rights Reserved.
      </div>
      <div class="footer-links">
        <a href="terms.html">Terms & Conditions</a>
        <a href="terms.html">Privacy Policy</a>
        <a href="#">Sitemap</a>
      </div>
    </div>
  </div>
</footer>

<button id="back-top" title="Back to Top"><i class="fas fa-chevron-up"></i></button>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
  AOS.init({ duration: 700, once: true, offset: 60, easing: 'ease-out-cubic' });

  const header = document.getElementById('header');
  window.addEventListener('scroll', () => {
    header.classList.toggle('scrolled', window.scrollY > 50);
    document.getElementById('back-top').classList.toggle('show', window.scrollY > 400);
  });

  document.getElementById('back-top').addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  // ── Hamburger toggle ───────────────────────────────────
  const hamburger = document.getElementById('hamburger');
  const mobileNav = document.getElementById('mobileNav');
  const navClose = document.getElementById('navClose');
  const overlay = document.getElementById('mobileOverlay');

  function openNav() {
    mobileNav.classList.add('open');
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
  }
  function closeNav() {
    mobileNav.classList.remove('open');
    overlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  hamburger.addEventListener('click', openNav);
  navClose.addEventListener('click', closeNav);
  overlay.addEventListener('click', closeNav);

  document.querySelectorAll('.mobile-nav a').forEach(link => {
    link.addEventListener('click', closeNav);
  });

  // ── Active nav link ─────────────────────────────────
  const navLinks = document.querySelectorAll('.nav-list a');
  navLinks.forEach(link => {
    link.classList.remove('active');
    if (link.getAttribute('href') === 'terms.html') {
      link.classList.add('active');
    }
  });

  // ── Tab switching ────────────────────────────────────
  const tabs = document.querySelectorAll('.legal-tab');
  const contents = {
    terms: document.getElementById('terms-content'),
    privacy: document.getElementById('privacy-content')
  };

  tabs.forEach(tab => {
    tab.addEventListener('click', function() {
      // Remove active class from all tabs
      tabs.forEach(t => t.classList.remove('active'));
      this.classList.add('active');

      // Hide all content
      Object.values(contents).forEach(c => c.classList.remove('active'));

      // Show selected content
      const target = this.dataset.tab;
      if (contents[target]) {
        contents[target].classList.add('active');
        contents[target].scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
</script>
</body>
</html>