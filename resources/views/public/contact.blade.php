<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
  <title>Contact Us – Leeds Institute</title>
  <meta name="description" content="Get in touch with Leeds Institute. Contact us for admissions, courses, and any inquiries." />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />

  <style>
    /* ─── ROOT TOKENS (same as home) ─── */
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
       CONTACT PAGE SPECIFIC STYLES
    ═══════════════════════════════════════════════════ */
    .contact-page-hero {
      min-height: 40vh;
      background: linear-gradient(135deg, #071e36 0%, #0B3C6D 45%, #1565a0 100%);
      display: flex;
      align-items: center;
      padding-top: 80px;
      position: relative;
      overflow: hidden;
    }
    .contact-page-hero::before {
      content: ''; position: absolute; inset: 0;
      background-image:
        radial-gradient(circle at 20% 80%, rgba(255,193,7,.08) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(229,57,53,.06) 0%, transparent 50%);
      pointer-events: none;
    }
    .contact-page-hero .hero-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2rem, 5vw, 3.2rem);
      font-weight: 800; color: var(--white);
      line-height: 1.15;
    }
    .contact-page-hero .hero-title span { color: var(--yellow); }
    .contact-page-hero p {
      color: rgba(255,255,255,.78);
      font-size: 1.05rem;
      max-width: 560px;
      margin-top: 12px;
    }

    /* Contact Info Cards */
    .contact-info-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
      margin-top: -40px;
      position: relative;
      z-index: 2;
    }
    .contact-info-card {
      background: var(--white);
      border-radius: var(--radius-lg);
      padding: 28px 24px;
      text-align: center;
      box-shadow: var(--shadow);
      border: 1px solid var(--gray-200);
      transition: var(--transition);
    }
    .contact-info-card:hover {
      transform: translateY(-6px);
      box-shadow: var(--shadow-lg);
      border-color: var(--navy);
    }
    .contact-info-card .icon-wrap {
      width: 60px;
      height: 60px;
      border-radius: 16px;
      background: rgba(11,60,109,.08);
      color: var(--navy);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      margin: 0 auto 16px;
      transition: var(--transition);
    }
    .contact-info-card:hover .icon-wrap {
      background: var(--navy);
      color: var(--yellow);
    }
    .contact-info-card h4 {
      font-size: 1rem;
      font-weight: 700;
      color: var(--navy);
      margin-bottom: 6px;
    }
    .contact-info-card p {
      font-size: .88rem;
      color: var(--gray-600);
      line-height: 1.6;
    }
    .contact-info-card a {
      color: var(--navy);
      font-weight: 600;
    }
    .contact-info-card a:hover { color: var(--red); }

    /* Contact Form + Map section */
    .contact-main-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 50px;
      margin-top: 60px;
      align-items: start;
    }
    .contact-form-wrap {
      background: var(--gray-50);
      border-radius: var(--radius-lg);
      padding: 40px;
      border: 1px solid var(--gray-200);
    }
    .contact-form-wrap h3 {
      font-size: 1.3rem;
      font-weight: 700;
      color: var(--navy);
      margin-bottom: 24px;
    }
    .form-group { margin-bottom: 16px; }
    .form-group label {
      display: block;
      font-size: .85rem;
      font-weight: 600;
      color: var(--navy);
      margin-bottom: 4px;
    }
    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 12px 16px;
      border-radius: 10px;
      border: 1.5px solid var(--gray-200);
      font-family: inherit;
      font-size: .9rem;
      color: var(--gray-800);
      background: var(--white);
      transition: var(--transition);
      outline: none;
    }
    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
      border-color: var(--navy);
      box-shadow: 0 0 0 3px rgba(11,60,109,.1);
    }
    .form-group textarea { resize: vertical; min-height: 120px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

    /* Map */
    .map-wrap {
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--gray-200);
      height: 100%;
      min-height: 400px;
      background: var(--gray-100);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }
    .map-wrap iframe {
      width: 100%;
      height: 100%;
      border: 0;
      min-height: 400px;
    }
    .map-placeholder {
      text-align: center;
      color: var(--gray-400);
      padding: 40px;
    }
    .map-placeholder i { font-size: 3rem; margin-bottom: 10px; display: block; }

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
    .footer-social { display: flex; gap: 10px; }
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
    .social-btn:hover { background: var(--yellow); color: var(--navy); }
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
       RESPONSIVE — MOBILE (same as home)
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

      /* Contact Hero */
      .contact-page-hero { min-height: 30vh; padding-top: 60px; padding-bottom: 30px; }
      .contact-page-hero .hero-title { font-size: clamp(1.4rem, 5vw, 1.9rem); }
      .contact-page-hero p { font-size: .82rem; }

      /* Contact Info Cards - 2 col on mobile */
      .contact-info-grid {
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: -20px;
      }
      .contact-info-card {
        padding: 16px 12px;
        border-radius: 12px;
      }
      .contact-info-card .icon-wrap {
        width: 40px;
        height: 40px;
        font-size: 1rem;
        margin-bottom: 8px;
        border-radius: 10px;
      }
      .contact-info-card h4 { font-size: .75rem; margin-bottom: 2px; }
      .contact-info-card p { font-size: .65rem; line-height: 1.3; }

      /* Contact Form + Map - stacked */
      .contact-main-grid {
        grid-template-columns: 1fr;
        gap: 24px;
        margin-top: 30px;
      }
      .contact-form-wrap { padding: 20px; border-radius: 12px; }
      .contact-form-wrap h3 { font-size: 1rem; margin-bottom: 16px; }
      .form-group { margin-bottom: 10px; }
      .form-group label { font-size: .7rem; }
      .form-group input,
      .form-group textarea,
      .form-group select {
        padding: 8px 12px;
        font-size: .8rem;
        border-radius: 8px;
      }
      .form-row { grid-template-columns: 1fr; gap: 0; }
      .form-group textarea { min-height: 80px; }
      .map-wrap { min-height: 200px; height: 200px; }
      .map-wrap iframe { min-height: 200px; }

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

      /* Section headers mobile */
      .section-tag { font-size: .55rem; padding: 3px 10px; margin-bottom: 6px; border-radius: 30px; }
      .section-tag i { font-size: .5rem; }
      .section-title { font-size: clamp(1.1rem, 4vw, 1.4rem); }
      .section-sub { font-size: .68rem; margin-top: 4px; }
      .accent-bar { width: 28px; height: 3px; margin: 8px 0 0; }
    }

    @media (max-width: 480px) {
      .contact-info-grid { grid-template-columns: 1fr 1fr; }
      .footer-grid { grid-template-columns: 1fr 1fr; }
      .footer-brand { grid-column: span 2; }
    }

    @media (min-width: 769px) {
      .contact-info-grid { grid-template-columns: repeat(4, 1fr); }
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
  <a href="faq.html" onclick="closeNav()"><i class="fas fa-question-circle"></i> FAQ</a>
  <a href="teachers.html" onclick="closeNav()"><i class="fas fa-chalkboard-teacher"></i> Teachers</a>
  <a href="gallery.html" onclick="closeNav()"><i class="fas fa-images"></i> Gallery</a>
  <a href="contact.html" onclick="closeNav()" class="active"><i class="fas fa-phone"></i> Contact</a>
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
          <li><a href="faq.html">FAQ</a></li>
          <li><a href="teachers.html">Teachers</a></li>
          <li><a href="gallery.html">Gallery</a></li>
          <li><a href="contact.html" class="active">Contact</a></li>
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
   CONTACT PAGE HERO
═══════════════════════════════════════════════════ -->
<section class="contact-page-hero">
  <div class="container">
    <div class="hero-content" data-aos="fade-up">
      <div class="section-tag" style="background:rgba(255,193,7,.15);color:var(--yellow);border:1px solid rgba(255,193,7,.2);">
        <i class="fas fa-phone"></i> Get In Touch
      </div>
      <h1 class="hero-title">Contact <span>Us</span></h1>
      <p>Have questions about admissions, courses, or anything else? We're here to help. Reach out to us through any of the channels below.</p>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   CONTACT INFO CARDS
═══════════════════════════════════════════════════ -->
<section style="padding: 0 0 40px 0;">
  <div class="container">
    <div class="contact-info-grid">
      <div class="contact-info-card" data-aos="fade-up" data-aos-delay="0">
        <div class="icon-wrap"><i class="fas fa-phone"></i></div>
        <h4>Phone Numbers</h4>
        <p><a href="tel:+92XXX-XXXXXXX">+92-XXX-XXXXXXX</a></p>
        <p><a href="tel:+92XXX-XXXXXXX">+92-XXX-XXXXXXX</a></p>
      </div>
      <div class="contact-info-card" data-aos="fade-up" data-aos-delay="60">
        <div class="icon-wrap"><i class="fas fa-envelope"></i></div>
        <h4>Email Address</h4>
        <p><a href="mailto:info@leedsinstitute.edu.pk">info@leedsinstitute.edu.pk</a></p>
        <p><a href="mailto:admissions@leedsinstitute.edu.pk">admissions@leedsinstitute.edu.pk</a></p>
      </div>
      <div class="contact-info-card" data-aos="fade-up" data-aos-delay="120">
        <div class="icon-wrap"><i class="fas fa-map-marker-alt"></i></div>
        <h4>Office Address</h4>
        <p>Leeds Institute, Main Road<br>City, Pakistan</p>
      </div>
      <div class="contact-info-card" data-aos="fade-up" data-aos-delay="180">
        <div class="icon-wrap"><i class="fas fa-clock"></i></div>
        <h4>Office Hours</h4>
        <p>Monday – Saturday<br>8:00 AM – 5:00 PM</p>
        <p style="color:var(--red);font-weight:600;">Sunday: Closed</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   CONTACT FORM + MAP
═══════════════════════════════════════════════════ -->
<section id="contact" style="padding-top:0;">
  <div class="container">
    <div class="contact-main-grid">
      <!-- Form -->
      <div class="contact-form-wrap" data-aos="fade-right">
        <h3><i class="fas fa-paper-plane" style="color:var(--navy);margin-right:10px;"></i> Send Us a Message</h3>
        <form onsubmit="return false;">
          <div class="form-row">
            <div class="form-group">
              <label>Full Name</label>
              <input type="text" placeholder="Your full name" />
            </div>
            <div class="form-group">
              <label>Phone Number</label>
              <input type="tel" placeholder="+92-XXX-XXXXXXX" />
            </div>
          </div>
          <div class="form-group">
            <label>Email Address</label>
            <input type="email" placeholder="your@email.com" />
          </div>
          <div class="form-group">
            <label>Interested Course</label>
            <select>
              <option value="">Select a course...</option>
              <option>FSc Pre-Medical</option>
              <option>FSc Pre-Engineering</option>
              <option>ICS / I.Com</option>
              <option>Matric (Science)</option>
              <option>Matric (Arts)</option>
              <option>Computer Diploma</option>
              <option>Spoken English</option>
            </select>
          </div>
          <div class="form-group">
            <label>Message</label>
            <textarea placeholder="Write your question or message here..."></textarea>
          </div>
          <button class="btn btn-primary" style="width:100%;justify-content:center;font-size:.95rem;padding:14px;">
            <i class="fas fa-paper-plane"></i> Send Message
          </button>
        </form>
      </div>

      <!-- Map -->
      <div data-aos="fade-left">
        <div class="map-wrap">
          <div class="map-placeholder">
            <i class="fas fa-map-marker-alt" style="color:var(--red)"></i>
            <p style="font-size:1rem;font-weight:600;color:var(--gray-600)">Find Us Here</p>
            <p style="font-size:.85rem;margin-top:6px;color:var(--gray-400);">Leeds Institute, Main Road, City</p>
            <a href="#" class="btn btn-navy" style="margin-top:16px;font-size:.85rem;padding:10px 24px;">
              <i class="fas fa-directions"></i> Get Directions
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   EXTRA CONTACT OPTIONS
═══════════════════════════════════════════════════ -->
<section style="padding:0 0 60px 0;background:var(--gray-50);">
  <div class="container">
    <div class="contact-actions" style="display:flex;gap:14px;flex-wrap:wrap;justify-content:center;padding:24px 0;">
      <button class="btn btn-wa" style="background:#25D366;color:var(--white);border:none;padding:12px 28px;border-radius:50px;font-weight:700;font-size:.9rem;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:var(--transition);font-family:inherit;">
        <i class="fab fa-whatsapp"></i> WhatsApp Us
      </button>
      <button class="btn btn-call" style="background:var(--navy);color:var(--white);border:none;padding:12px 28px;border-radius:50px;font-weight:700;font-size:.9rem;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:var(--transition);font-family:inherit;">
        <i class="fas fa-phone"></i> Call Now
      </button>
      <a href="mailto:info@leedsinstitute.edu.pk" class="btn btn-navy" style="background:var(--navy);color:var(--white);padding:12px 28px;border-radius:50px;font-weight:700;font-size:.9rem;display:inline-flex;align-items:center;gap:8px;">
        <i class="fas fa-envelope"></i> Email Us
      </a>
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
            <a href="#" class="social-btn" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-btn" title="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-btn" title="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-btn" title="YouTube"><i class="fab fa-youtube"></i></a>
            <a href="#" class="social-btn" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
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
    if (link.getAttribute('href') === 'contact.html') {
      link.classList.add('active');
    }
  });

  // ── Smooth internal links ───────────────────────────
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const id = a.getAttribute('href');
      if (id === '#') return;
      const target = document.querySelector(id);
      if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
    });
  });
</script>
</body>
</html>