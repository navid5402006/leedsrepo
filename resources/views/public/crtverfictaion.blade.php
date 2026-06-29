<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>CRT Verification – {{ $settings['institute']['name'] ?? 'Leeds Institute' }}</title>
  <meta name="description" content="Enter your CRT number to verify your certificate at {{ $settings['institute']['name'] ?? 'Leeds Institute' }}." />

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
       HEADER (Dynamic)
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
      flex-wrap: wrap;
    }
    .nav-list a {
      padding: 8px 13px; border-radius: 8px;
      font-size: .88rem; font-weight: 600; color: rgba(255,255,255,.85);
      transition: var(--transition); white-space: nowrap;
    }
    .nav-list a:hover, .nav-list a.active {
      background: rgba(255,255,255,.1); color: var(--white);
    }

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
       CRT VERIFICATION PAGE SPECIFIC STYLES
    ═══════════════════════════════════════════════════ */
    .crt-page-hero {
      min-height: 40vh;
      background: linear-gradient(135deg, #071e36 0%, #0B3C6D 45%, #1565a0 100%);
      display: flex;
      align-items: center;
      padding-top: 80px;
      position: relative;
      overflow: hidden;
    }
    .crt-page-hero::before {
      content: ''; position: absolute; inset: 0;
      background-image:
        radial-gradient(circle at 20% 80%, rgba(255,193,7,.08) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(229,57,53,.06) 0%, transparent 50%);
      pointer-events: none;
    }
    .crt-page-hero .hero-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2rem, 5vw, 3.2rem);
      font-weight: 800; color: var(--white);
      line-height: 1.15;
    }
    .crt-page-hero .hero-title span { color: var(--yellow); }
    .crt-page-hero p {
      color: rgba(255,255,255,.78);
      font-size: 1.05rem;
      max-width: 560px;
      margin-top: 12px;
    }

    /* CRT Form Card */
    .crt-card {
      background: var(--white);
      border-radius: var(--radius-xl);
      padding: 48px 56px;
      box-shadow: var(--shadow);
      margin-top: -30px;
      position: relative;
      z-index: 2;
      border: 1px solid var(--gray-200);
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }
    .crt-card .icon-wrap {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: rgba(11,60,109,.08);
      color: var(--navy);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.4rem;
      margin: 0 auto 20px;
      transition: var(--transition);
    }
    .crt-card:hover .icon-wrap {
      background: var(--navy);
      color: var(--yellow);
    }
    .crt-card h3 {
      font-size: 1.2rem;
      font-weight: 700;
      color: var(--navy);
      text-align: center;
      margin-bottom: 8px;
    }
    .crt-card p {
      text-align: center;
      color: var(--gray-600);
      font-size: .9rem;
      margin-bottom: 28px;
    }
    .crt-form {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }
    .crt-form .form-group {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }
    .crt-form .form-group label {
      font-size: .85rem;
      font-weight: 600;
      color: var(--navy);
    }
    .crt-form .form-group input {
      padding: 14px 18px;
      border-radius: 12px;
      border: 2px solid var(--gray-200);
      font-family: inherit;
      font-size: 1rem;
      color: var(--gray-800);
      background: var(--white);
      transition: var(--transition);
      outline: none;
      width: 100%;
      text-align: center;
      letter-spacing: 2px;
      font-weight: 600;
      text-transform: uppercase;
    }
    .crt-form .form-group input:focus {
      border-color: var(--navy);
      box-shadow: 0 0 0 4px rgba(11,60,109,.1);
    }
    .crt-form .form-group input::placeholder {
      color: var(--gray-400);
      font-weight: 400;
      letter-spacing: 0;
      text-transform: none;
    }
    .crt-form .verify-btn {
      padding: 14px;
      font-size: 1rem;
      margin-top: 8px;
    }

    /* Toast Message */
    .toast-message {
      padding: 12px 16px;
      border-radius: 8px;
      margin-bottom: 16px;
      display: none;
      font-weight: 500;
      text-align: center;
    }
    .toast-message.error {
      background: #EF4444;
      color: #fff;
      display: block;
    }
    .toast-message.error i { margin-right: 8px; }

    /* ─── FOOTER (Dynamic) ─── */
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

    /* ─── SPINNER ─── */
    .spinner {
      display: inline-block;
      width: 18px;
      height: 18px;
      border: 2px solid rgba(255,255,255,.3);
      border-radius: 50%;
      border-top-color: #fff;
      animation: spin 0.6s linear infinite;
    }
    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    /* ─── RESPONSIVE ─── */
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

      .crt-page-hero { min-height: 30vh; padding-top: 60px; padding-bottom: 30px; }
      .crt-page-hero .hero-title { font-size: clamp(1.4rem, 5vw, 1.9rem); }
      .crt-page-hero p { font-size: .82rem; }

      .crt-card {
        padding: 28px 20px;
        border-radius: 16px;
        margin-top: -20px;
      }
      .crt-card .icon-wrap {
        width: 60px;
        height: 60px;
        font-size: 1.8rem;
        margin-bottom: 14px;
      }
      .crt-card h3 { font-size: 1rem; }
      .crt-card p { font-size: .8rem; margin-bottom: 20px; }
      .crt-form .form-group label { font-size: .78rem; }
      .crt-form .form-group input {
        padding: 12px 14px;
        font-size: .9rem;
        border-radius: 10px;
      }
      .crt-form .verify-btn { padding: 12px; font-size: .9rem; }

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

      #back-top { width: 32px; height: 32px; font-size: .6rem; bottom: 12px; right: 12px; }

      .section-tag { font-size: .55rem; padding: 3px 10px; margin-bottom: 6px; border-radius: 30px; }
      .section-tag i { font-size: .5rem; }
      .section-title { font-size: clamp(1.1rem, 4vw, 1.4rem); }
      .section-sub { font-size: .68rem; margin-top: 4px; }
      .accent-bar { width: 28px; height: 3px; margin: 8px 0 0; }
    }

    @media (max-width: 480px) {
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
   MOBILE SIDEBAR NAV (Dynamic)
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
  <a href="{{ route('crtverfictaion') }}" onclick="closeNav()" class="active"><i class="fas fa-certificate"></i> Verify Certificate</a>
  <a href="{{ route('search_results') }}" onclick="closeNav()"><i class="fas fa-search"></i> Search</a>
  <a href="{{ route('Terms_Privacy') }}" onclick="closeNav()"><i class="fas fa-shield-alt"></i> Privacy</a>
</div>

<!-- ═══════════════════════════════════════════════════
   HEADER (Dynamic)
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
          <li><a href="{{ route('home') }}">Home</a></li>
          <li><a href="{{ route('aboutus') }}">About</a></li>
          <li><a href="{{ route('courses') }}">Courses</a></li>
          <li><a href="{{ route('admissions') }}">Admissions</a></li>
          <li><a href="{{ route('faq') }}">FAQ</a></li>
          <li><a href="{{ route('teachers') }}">Teachers</a></li>
          <li><a href="{{ route('gallery') }}">Gallery</a></li>
          <li><a href="{{ route('contact') }}">Contact</a></li>
          <li><a href="{{ route('crtverfictaion') }}" class="active">Verify</a></li>
        </ul>
      </nav>
      <button class="hamburger" id="hamburger" aria-label="Menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>

<!-- ═══════════════════════════════════════════════════
   CRT VERIFICATION PAGE HERO
═══════════════════════════════════════════════════ -->
<section class="crt-page-hero">
  <div class="container">
    <div class="hero-content" data-aos="fade-up">
      <div class="section-tag" style="background:rgba(255,193,7,.15);color:var(--yellow);border:1px solid rgba(255,193,7,.2);">
        <i class="fas fa-certificate"></i> Certificate Verification
      </div>
      <h1 class="hero-title">CRT <span>Verification</span></h1>
      <p>Enter your CRT number below to verify your certificate from {{ $settings['institute']['name'] ?? 'Leeds Institute' }}.</p>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   CRT VERIFICATION FORM
═══════════════════════════════════════════════════ -->
<section style="padding-top:0;">
  <div class="container">
    <div class="crt-card" data-aos="fade-up">
      <div class="icon-wrap">
        <i class="fas fa-certificate"></i>
      </div>
      <h3>Enter CRT Number</h3>
      <p>Please enter your unique CRT number to verify your certificate.</p>
      
      <!-- Toast Error Message -->
      <div id="errorMsg" class="toast-message error" style="display:none;">
        <i class="fas fa-exclamation-circle"></i> <span id="errorText">Please enter a valid CRT number.</span>
      </div>
      
      <form class="crt-form" id="crtForm" onsubmit="verifyCRT(event)">
        @csrf
        <div class="form-group">
          <label><i class="fas fa-hashtag" style="color:var(--navy);margin-right:6px;"></i> CRT Number</label>
          <input 
            type="text" 
            id="crtNumber" 
            name="certificate_number"
            placeholder="e.g. CRT-2024-001" 
            required
            autofocus
          />
        </div>
        <button type="submit" class="btn btn-primary verify-btn" id="verifyBtn">
          <i class="fas fa-shield-alt"></i> <span id="btnText">Verify CRT</span>
          <span class="spinner" id="btnSpinner" style="display:none;"></span>
        </button>
      </form>
      
      <p style="text-align:center;margin-top:16px;font-size:.8rem;color:var(--gray-400);">
        <i class="fas fa-info-circle"></i> Example: CRT-2024-001, CRT-2023-045
      </p>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   FOOTER (Dynamic)
═══════════════════════════════════════════════════ -->
<footer id="footer">
  <div class="footer-top">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <a href="{{ route('home') }}" class="logo">
            <div class="logo-mark">LI</div>
            <div class="logo-text">
              <strong>{{ $settings['institute']['name'] ?? 'Leeds Institute' }}</strong>
              <span>{{ $settings['institute']['tagline'] ?? 'Quality Education Since 2005' }}</span>
            </div>
          </a>
          <p>{{ $settings['about']['about_us'] ?? 'Leeds Institute is dedicated to delivering quality education that prepares students for academic excellence and lifelong success in an ever-changing world.' }}</p>
          <div class="footer-social">
            @if($settings['social']['facebook'] ?? false)
              <a href="{{ $settings['social']['facebook'] }}" class="social-btn" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            @endif
            @if($settings['social']['twitter'] ?? false)
              <a href="{{ $settings['social']['twitter'] }}" class="social-btn" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
            @endif
            @if($settings['social']['instagram'] ?? false)
              <a href="{{ $settings['social']['instagram'] }}" class="social-btn" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
            @endif
            @if($settings['social']['youtube'] ?? false)
              <a href="{{ $settings['social']['youtube'] }}" class="social-btn" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
            @endif
            @if($settings['social']['linkedin'] ?? false)
              <a href="{{ $settings['social']['linkedin'] }}" class="social-btn" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            @endif
            @if($settings['social']['tiktok'] ?? false)
              <a href="{{ $settings['social']['tiktok'] }}" class="social-btn" target="_blank" title="TikTok"><i class="fab fa-tiktok"></i></a>
            @endif
          </div>
        </div>
        <div class="footer-col">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right"></i> Home</a></li>
            <li><a href="{{ route('aboutus') }}"><i class="fas fa-chevron-right"></i> About Us</a></li>
            <li><a href="{{ route('teachers') }}"><i class="fas fa-chevron-right"></i> Our Faculty</a></li>
            <li><a href="{{ route('gallery') }}"><i class="fas fa-chevron-right"></i> Gallery</a></li>
            <li><a href="{{ route('contact') }}"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Programs</h4>
          <ul>
            @foreach($allCourses->take(5) as $course)
              <li><a href="{{ route('courses') }}"><i class="fas fa-chevron-right"></i> {{ $course->title }}</a></li>
            @endforeach
            <li><a href="{{ route('courses') }}"><i class="fas fa-chevron-right"></i> View All Courses</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Admissions</h4>
          <ul>
            <li><a href="{{ route('admissions') }}"><i class="fas fa-chevron-right"></i> Visit Our Office</a></li>
            <li><a href="{{ route('admissions') }}"><i class="fas fa-chevron-right"></i> Admission Process</a></li>
            <li><a href="{{ route('faq') }}"><i class="fas fa-chevron-right"></i> Scholarships</a></li>
            <li><a href="{{ route('faq') }}"><i class="fas fa-chevron-right"></i> Fee Structure</a></li>
            <li><a href="{{ route('faq') }}"><i class="fas fa-chevron-right"></i> FAQs</a></li>
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
        &copy; {{ date('Y') }} {{ $settings['institute']['name'] ?? 'Leeds Institute' }}. All Rights Reserved.
      </div>
      <div class="footer-links">
        <a href="{{ route('Terms_Privacy') }}">Privacy Policy</a>
        <a href="{{ route('Terms_Privacy') }}">Terms & Conditions</a>
        <a href="{{ route('crtverfictaion') }}">Verify Certificate</a>
      </div>
    </div>
  </div>
</footer>

<button id="back-top" title="Back to Top"><i class="fas fa-chevron-up"></i></button>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
  AOS.init({ duration: 700, once: true, offset: 60, easing: 'ease-out-cubic' });

  // ─── Header Scroll ──────────────────────────────────────
  const header = document.getElementById('header');
  window.addEventListener('scroll', () => {
    header.classList.toggle('scrolled', window.scrollY > 50);
    document.getElementById('back-top').classList.toggle('show', window.scrollY > 400);
  });

  document.getElementById('back-top').addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  // ─── Hamburger toggle ───────────────────────────────────
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

  // ─── Active nav link ─────────────────────────────────
  const navLinks = document.querySelectorAll('.nav-list a');
  navLinks.forEach(link => {
    link.classList.remove('active');
    if (link.getAttribute('href') === '{{ route("crtverfictaion") }}') {
      link.classList.add('active');
    }
  });

  // ─── CRT Verification Function (FIXED) ─────────────────
  function verifyCRT(e) {
    e.preventDefault();
    
    const crtNumber = document.getElementById('crtNumber');
    const errorDiv = document.getElementById('errorMsg');
    const errorText = document.getElementById('errorText');
    const verifyBtn = document.getElementById('verifyBtn');
    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');
    
    // Get the value and trim whitespace
    const number = crtNumber.value.trim();
    
    // Validate - must not be empty
    if (!number) {
      errorText.textContent = 'Please enter a CRT number.';
      errorDiv.style.display = 'block';
      crtNumber.style.borderColor = 'var(--red)';
      
      setTimeout(() => {
        errorDiv.style.display = 'none';
        crtNumber.style.borderColor = '';
      }, 3000);
      
      return false;
    }
    
    // Validate - minimum length
    if (number.length < 5) {
      errorText.textContent = 'Please enter a valid CRT number (minimum 5 characters).';
      errorDiv.style.display = 'block';
      crtNumber.style.borderColor = 'var(--red)';
      
      setTimeout(() => {
        errorDiv.style.display = 'none';
        crtNumber.style.borderColor = '';
      }, 3000);
      
      return false;
    }
    
    // Hide error if shown
    errorDiv.style.display = 'none';
    crtNumber.style.borderColor = '';
    
    // Show loading state
    btnText.textContent = 'Verifying...';
    btnSpinner.style.display = 'inline-block';
    verifyBtn.disabled = true;
    
    // Redirect directly to the certificate verification page
    // Using the correct route URL pattern
    var verifyUrl = '{{ url("/crtverfictaion") }}/' + encodeURIComponent(number);
    window.location.href = verifyUrl;
    
    return false;
  }

  // ─── Enter key support ──────────────────────────────────
  document.getElementById('crtNumber').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      document.getElementById('crtForm').dispatchEvent(new Event('submit'));
    }
  });

  // ─── Auto-uppercase input ──────────────────────────────
  document.getElementById('crtNumber').addEventListener('input', function() {
    this.value = this.value.toUpperCase();
  });
</script>
</body>
</html>