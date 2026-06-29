<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Results – {{ $settings['institute']['name'] ?? 'Leeds Institute' }}</title>
  <meta name="description" content="Check your exam results at {{ $settings['institute']['name'] ?? 'Leeds Institute' }}. Search by roll number, name, or father's name." />

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
       RESULTS PAGE SPECIFIC STYLES
    ═══════════════════════════════════════════════════ */
    .results-page-hero {
      min-height: 40vh;
      background: linear-gradient(135deg, #071e36 0%, #0B3C6D 45%, #1565a0 100%);
      display: flex;
      align-items: center;
      padding-top: 80px;
      position: relative;
      overflow: hidden;
    }
    .results-page-hero::before {
      content: ''; position: absolute; inset: 0;
      background-image:
        radial-gradient(circle at 20% 80%, rgba(255,193,7,.08) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(229,57,53,.06) 0%, transparent 50%);
      pointer-events: none;
    }
    .results-page-hero .hero-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2rem, 5vw, 3.2rem);
      font-weight: 800; color: var(--white);
      line-height: 1.15;
    }
    .results-page-hero .hero-title span { color: var(--yellow); }
    .results-page-hero p {
      color: rgba(255,255,255,.78);
      font-size: 1.05rem;
      max-width: 560px;
      margin-top: 12px;
    }

    /* Search Form */
    .search-card {
      background: var(--white);
      border-radius: var(--radius-xl);
      padding: 40px 48px;
      box-shadow: var(--shadow);
      margin-top: -30px;
      position: relative;
      z-index: 2;
      border: 1px solid var(--gray-200);
    }
    .search-form {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr auto;
      gap: 16px;
      align-items: end;
    }
    .form-group {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }
    .form-group label {
      font-size: .85rem;
      font-weight: 600;
      color: var(--navy);
    }
    .form-group input {
      padding: 12px 16px;
      border-radius: 10px;
      border: 1.5px solid var(--gray-200);
      font-family: inherit;
      font-size: .9rem;
      color: var(--gray-800);
      background: var(--white);
      transition: var(--transition);
      outline: none;
      width: 100%;
    }
    .form-group input:focus {
      border-color: var(--navy);
      box-shadow: 0 0 0 3px rgba(11,60,109,.1);
    }
    .form-group input::placeholder {
      color: var(--gray-400);
    }
    .search-btn {
      padding: 12px 32px;
      min-height: 48px;
      white-space: nowrap;
    }

    /* Result Card */
    .result-card {
      background: var(--white);
      border-radius: var(--radius-lg);
      padding: 32px 36px;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--gray-200);
      margin-top: 32px;
      display: none;
      animation: slideUp .5s ease;
    }
    .result-card.show {
      display: block;
    }
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .result-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-bottom: 16px;
      border-bottom: 2px solid var(--yellow);
    }
    .result-header .student-name {
      font-size: 1.3rem;
      font-weight: 700;
      color: var(--navy);
    }
    .result-header .roll-number {
      font-size: .95rem;
      color: var(--gray-600);
      background: var(--gray-100);
      padding: 4px 16px;
      border-radius: 50px;
    }
    .result-body {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      padding-top: 20px;
    }
    .result-item {
      display: flex;
      justify-content: space-between;
      padding: 10px 0;
      border-bottom: 1px solid var(--gray-100);
    }
    .result-item .subject {
      font-weight: 500;
      color: var(--gray-600);
    }
    .result-item .marks {
      font-weight: 700;
      color: var(--navy);
    }
    .result-item .marks.pass { color: #22c55e; }
    .result-item .marks.fail { color: var(--red); }
    .result-summary {
      grid-column: span 2;
      display: flex;
      justify-content: space-between;
      padding: 16px 0 0;
      border-top: 2px solid var(--yellow);
      margin-top: 8px;
    }
    .result-summary .total {
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--navy);
    }
    .result-summary .percentage {
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--yellow2);
    }
    .result-summary .status {
      font-size: 1rem;
      font-weight: 700;
      padding: 4px 20px;
      border-radius: 50px;
    }
    .result-summary .status.pass {
      background: rgba(34,197,94,.15);
      color: #22c55e;
    }
    .result-summary .status.fail {
      background: rgba(229,57,53,.15);
      color: var(--red);
    }

    /* No Result */
    .no-result {
      text-align: center;
      padding: 40px 20px;
      color: var(--gray-400);
      display: none;
    }
    .no-result.show {
      display: block;
      animation: slideUp .5s ease;
    }
    .no-result i {
      font-size: 3rem;
      color: var(--gray-300);
      margin-bottom: 16px;
    }
    .no-result h3 {
      font-size: 1.2rem;
      color: var(--gray-600);
    }
    .no-result p {
      color: var(--gray-400);
    }

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

      .results-page-hero { min-height: 30vh; padding-top: 60px; padding-bottom: 30px; }
      .results-page-hero .hero-title { font-size: clamp(1.4rem, 5vw, 1.9rem); }
      .results-page-hero p { font-size: .82rem; }

      .search-card {
        padding: 24px 20px;
        border-radius: 16px;
        margin-top: -20px;
      }
      .search-form {
        grid-template-columns: 1fr;
        gap: 12px;
      }
      .form-group label { font-size: .78rem; }
      .form-group input { padding: 10px 14px; font-size: .82rem; }
      .search-btn { width: 100%; padding: 12px; }

      .result-card { padding: 20px 16px; border-radius: 12px; }
      .result-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
        padding-bottom: 12px;
      }
      .result-header .student-name { font-size: 1.1rem; }
      .result-header .roll-number { font-size: .8rem; }
      .result-body {
        grid-template-columns: 1fr;
        gap: 0;
        padding-top: 12px;
      }
      .result-item { padding: 8px 0; font-size: .85rem; }
      .result-summary {
        grid-column: span 1;
        flex-wrap: wrap;
        gap: 8px;
        padding-top: 12px;
        margin-top: 4px;
      }
      .result-summary .total,
      .result-summary .percentage { font-size: .9rem; }
      .result-summary .status { font-size: .85rem; padding: 2px 16px; }

      .no-result i { font-size: 2.4rem; }
      .no-result h3 { font-size: 1rem; }

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
  <a href="{{ route('crtverfictaion') }}" onclick="closeNav()"><i class="fas fa-certificate"></i> Verify Certificate</a>
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
          <li><a href="{{ route('results') }}" class="active">Results</a></li>
        </ul>
      </nav>
      <button class="hamburger" id="hamburger" aria-label="Menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>

<!-- ═══════════════════════════════════════════════════
   RESULTS PAGE HERO
═══════════════════════════════════════════════════ -->
<section class="results-page-hero">
  <div class="container">
    <div class="hero-content" data-aos="fade-up">
      <div class="section-tag" style="background:rgba(255,193,7,.15);color:var(--yellow);border:1px solid rgba(255,193,7,.2);">
        <i class="fas fa-graduation-cap"></i> Results
      </div>
      <h1 class="hero-title">Check Your <span>Results</span></h1>
      <p>Search your exam results by entering your Roll Number, Name, or Father's Name below.</p>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   SEARCH FORM
═══════════════════════════════════════════════════ -->
<section style="padding-top:0;">
  <div class="container">
    <div class="search-card" data-aos="fade-up">
      <form class="search-form" id="searchForm" onsubmit="return searchResult(event)">
        <div class="form-group">
          <label><i class="fas fa-hashtag" style="color:var(--navy);margin-right:6px;"></i> Roll Number</label>
          <input type="text" id="rollNo" placeholder="e.g. TT-1100" />
        </div>
        <div class="form-group">
          <label><i class="fas fa-user" style="color:var(--navy);margin-right:6px;"></i> Name</label>
          <input type="text" id="studentName" placeholder="Enter your name" />
        </div>
        <div class="form-group">
          <label><i class="fas fa-user-friends" style="color:var(--navy);margin-right:6px;"></i> Father's Name</label>
          <input type="text" id="fatherName" placeholder="Enter father's name" />
        </div>
        <button type="submit" class="btn btn-primary search-btn">
          <i class="fas fa-search"></i> Search Results
        </button>
      </form>
    </div>

    <!-- Result Display -->
    <div id="resultContainer">
      <!-- Result Card (hidden by default) -->
      <div class="result-card" id="resultCard">
        <div class="result-header">
          <div>
            <div class="student-name" id="displayName">-</div>
            <div style="font-size:.85rem;color:var(--gray-400);margin-top:2px;" id="displayFather">S/o: -</div>
          </div>
          <div class="roll-number" id="displayRoll">Roll: -</div>
        </div>
        <div class="result-body" id="resultBody">
          <!-- Results will be injected here -->
          <div class="result-summary" id="resultSummary">
            <span class="total" id="displayTotal">Total: 0 / 0</span>
            <span class="percentage" id="displayPercentage">Percentage: 0%</span>
            <span class="status pass" id="displayStatus">✓ PASS</span>
          </div>
        </div>
      </div>

      <!-- No Result -->
      <div class="no-result" id="noResult">
        <i class="fas fa-search"></i>
        <h3>No Results Found</h3>
        <p>Please check your search criteria and try again.</p>
      </div>
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
        <a href="{{ route('results') }}">Results</a>
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
    if (link.getAttribute('href') === '{{ route("results") }}') {
      link.classList.add('active');
    }
  });

  // ─── Search Function (AJAX) ──────────────────────────
  function searchResult(e) {
    e.preventDefault();
    
    const rollNo = document.getElementById('rollNo').value.trim();
    const name = document.getElementById('studentName').value.trim();
    const father = document.getElementById('fatherName').value.trim();

    const resultCard = document.getElementById('resultCard');
    const noResult = document.getElementById('noResult');
    const resultBody = document.getElementById('resultBody');

    // Show loading state
    resultBody.innerHTML = `
      <div style="text-align:center;padding:20px;color:var(--gray-400);">
        <i class="fas fa-spinner fa-spin" style="font-size:2rem;"></i>
        <p style="margin-top:10px;">Searching for results...</p>
      </div>
    `;
    resultCard.classList.add('show');
    noResult.classList.remove('show');

    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    // Make AJAX request
  fetch('{{ route("search.results.ajax") }}', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
    body: JSON.stringify({
        roll_no: rollNo,
        name: name,
        father_name: father
    })
  })
    .then(response => response.json())
    .then(data => {
      if (data.success && data.data.length > 0) {
        // Show first result
        const result = data.data[0];
        
        // Update header
        document.getElementById('displayName').textContent = result.name;
        document.getElementById('displayFather').textContent = `S/o: ${result.father}`;
        document.getElementById('displayRoll').textContent = `Roll: ${result.roll_no} | ${result.class}`;
        
        // Build subjects (if available)
        let subjectsHTML = '';
        let totalMarks = 0;
        let totalObtained = 0;
        
        // If we have subject data, show it
        if (result.subjects && result.subjects.length > 0) {
          result.subjects.forEach(sub => {
            totalMarks += sub.total || 100;
            totalObtained += sub.marks || 0;
            const pass = (sub.marks || 0) >= ((sub.total || 100) * 0.4);
            subjectsHTML += `
              <div class="result-item">
                <span class="subject">${sub.name}</span>
                <span class="marks ${pass ? 'pass' : 'fail'}">${sub.marks || 0} / ${sub.total || 100}</span>
              </div>
            `;
          });
        } else {
          // Show single subject result (talent test)
          const pass = (result.marks || 0) >= 50;
          subjectsHTML = `
            <div class="result-item">
              <span class="subject">Talent Test</span>
              <span class="marks ${pass ? 'pass' : 'fail'}">${result.marks || 0} / ${result.total_marks || 100}</span>
            </div>
          `;
          totalMarks = result.total_marks || 100;
          totalObtained = result.marks || 0;
        }
        
        // Calculate percentage
        const percentage = totalMarks > 0 ? ((totalObtained / totalMarks) * 100) : 0;
        const passed = percentage >= 40;
        
        resultBody.innerHTML = subjectsHTML + `
          <div class="result-summary">
            <span class="total">Total: ${totalObtained} / ${totalMarks}</span>
            <span class="percentage">Percentage: ${percentage.toFixed(1)}%</span>
            <span class="status ${passed ? 'pass' : 'fail'}">${passed ? '✓ PASS' : '✗ FAIL'}</span>
          </div>
        `;
        
        // Scroll to result
        resultCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
      } else {
        // No results found
        resultCard.classList.remove('show');
        noResult.classList.add('show');
        noResult.querySelector('p').textContent = data.message || 'No results found. Please check your search criteria.';
      }
    })
    .catch(error => {
      console.error('Error:', error);
      resultBody.innerHTML = `
        <div style="text-align:center;padding:20px;color:var(--red);">
          <i class="fas fa-exclamation-circle" style="font-size:2rem;"></i>
          <p style="margin-top:10px;">Error searching results. Please try again.</p>
        </div>
      `;
    });
    
    return false;
  }

  // ─── Enter key support ──────────────────────────────────
  document.querySelectorAll('#rollNo, #studentName, #fatherName').forEach(input => {
    input.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('searchForm').dispatchEvent(new Event('submit'));
      }
    });
  });
</script>
</body>
</html>