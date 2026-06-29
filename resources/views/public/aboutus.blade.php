<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
  <title>About Us – {{ $settings['institute']['name'] ?? 'Leeds Institute' }}</title>
  <meta name="description" content="Learn about {{ $settings['institute']['name'] ?? 'Leeds Institute' }} - our mission, vision, history, and commitment to quality education since 2005." />

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
       ABOUT PAGE SPECIFIC STYLES
    ═══════════════════════════════════════════════════ */
    .about-page-hero {
      min-height: 40vh;
      background: linear-gradient(135deg, #071e36 0%, #0B3C6D 45%, #1565a0 100%);
      display: flex;
      align-items: center;
      padding-top: 80px;
      position: relative;
      overflow: hidden;
    }
    .about-page-hero::before {
      content: ''; position: absolute; inset: 0;
      background-image:
        radial-gradient(circle at 20% 80%, rgba(255,193,7,.08) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(229,57,53,.06) 0%, transparent 50%);
      pointer-events: none;
    }
    .about-page-hero .hero-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2rem, 5vw, 3.2rem);
      font-weight: 800; color: var(--white);
      line-height: 1.15;
    }
    .about-page-hero .hero-title span { color: var(--yellow); }
    .about-page-hero p {
      color: rgba(255,255,255,.78);
      font-size: 1.05rem;
      max-width: 560px;
      margin-top: 12px;
    }

    /* About Stats - Dynamic */
    .about-stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
      margin-top: -40px;
      position: relative;
      z-index: 2;
    }
    .about-stat-card {
      background: var(--white);
      border-radius: var(--radius-lg);
      padding: 28px 20px;
      text-align: center;
      box-shadow: var(--shadow);
      border: 1px solid var(--gray-200);
      transition: var(--transition);
    }
    .about-stat-card:hover {
      transform: translateY(-6px);
      box-shadow: var(--shadow-lg);
      border-color: var(--navy);
    }
    .about-stat-card .stat-number {
      font-size: 2.8rem;
      font-weight: 800;
      color: var(--navy);
      font-family: 'Playfair Display', serif;
      line-height: 1;
    }
    .about-stat-card .stat-number .yellow { color: var(--yellow); }
    .about-stat-card p {
      font-size: .9rem;
      color: var(--gray-600);
      margin-top: 6px;
      font-weight: 500;
    }

    /* About Content */
    .about-content-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      align-items: center;
    }
    .about-image-wrap {
      position: relative;
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: var(--shadow);
    }
    .about-image-wrap img {
      width: 100%;
      height: 450px;
      object-fit: cover;
    }
    .about-image-badge {
      position: absolute;
      bottom: -20px;
      right: -20px;
      background: var(--yellow);
      border-radius: 16px;
      padding: 20px 28px;
      box-shadow: var(--shadow);
      text-align: center;
    }
    .about-image-badge .num {
      font-size: 2rem;
      font-weight: 800;
      color: var(--navy);
      line-height: 1;
    }
    .about-image-badge .lbl {
      font-size: .78rem;
      font-weight: 600;
      color: var(--navy2);
    }

    .about-text h2 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(1.8rem, 3vw, 2.4rem);
      font-weight: 800;
      color: var(--navy);
      line-height: 1.22;
    }
    .about-text h2 span { color: var(--red); }
    .about-text .accent-bar { margin-bottom: 20px; }
    .about-text p {
      color: var(--gray-600);
      line-height: 1.8;
      margin-bottom: 16px;
      font-size: .95rem;
    }
    .about-features {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      margin-top: 20px;
    }
    .about-feature-item {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: .88rem;
      color: var(--gray-600);
    }
    .about-feature-item i {
      color: var(--yellow2);
      font-size: 1rem;
      width: 20px;
    }

    /* CEO Section */
    .ceo-section {
      background: linear-gradient(135deg, var(--navy2) 0%, #0B3C6D 60%, #1565a0 100%);
      position: relative;
      overflow: hidden;
    }
    .ceo-section::before {
      content: '"';
      position: absolute;
      top: -40px;
      left: 40px;
      font-size: 28rem;
      font-family: 'Playfair Display', serif;
      color: rgba(255,255,255,.04);
      line-height: 1;
      pointer-events: none;
    }
    .ceo-grid {
      display: grid;
      grid-template-columns: 360px 1fr;
      gap: 70px;
      align-items: center;
    }
    .ceo-photo-wrap { position: relative; text-align: center; }
    .ceo-photo {
      width: 240px;
      height: 240px;
      border-radius: 50%;
      border: 5px solid var(--yellow);
      margin: 0 auto 20px;
      overflow: hidden;
    }
    .ceo-photo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .ceo-name {
      font-size: 1.15rem;
      font-weight: 800;
      color: var(--white);
    }
    .ceo-role {
      color: var(--yellow);
      font-size: .85rem;
      font-weight: 600;
      margin-top: 4px;
    }
    .ceo-content { position: relative; }
    .ceo-quote-mark {
      font-size: 4rem;
      color: var(--yellow);
      line-height: .6;
      font-family: 'Playfair Display', serif;
      display: block;
      margin-bottom: 12px;
    }
    .ceo-message {
      font-size: 1.05rem;
      color: rgba(255,255,255,.85);
      line-height: 1.85;
      font-style: italic;
    }
    .ceo-sig {
      margin-top: 28px;
      display: flex;
      align-items: center;
      gap: 16px;
    }
    .ceo-sig-line { flex: 1; height: 1px; background: rgba(255,255,255,.15); }
    .ceo-sig-text { color: var(--yellow); font-weight: 700; font-size: .9rem; }

    /* Mission Vision Values */
    .mv-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 28px;
      margin-top: 52px;
    }
    .mv-card {
      background: var(--white);
      border-radius: var(--radius-lg);
      padding: 32px 28px;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--gray-200);
      text-align: center;
      transition: var(--transition);
    }
    .mv-card:hover {
      transform: translateY(-6px);
      box-shadow: var(--shadow);
      border-color: var(--navy);
    }
    .mv-card .icon {
      width: 64px;
      height: 64px;
      border-radius: 16px;
      background: rgba(11,60,109,.08);
      color: var(--navy);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.6rem;
      margin: 0 auto 16px;
      transition: var(--transition);
    }
    .mv-card:hover .icon {
      background: var(--navy);
      color: var(--yellow);
    }
    .mv-card h3 {
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--navy);
      margin-bottom: 8px;
    }
    .mv-card p {
      font-size: .88rem;
      color: var(--gray-600);
      line-height: 1.7;
    }

    /* ═══════════════════════════════════════════════════
       FOOTER (same as home with dynamic courses)
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

      /* About Hero */
      .about-page-hero { min-height: 30vh; padding-top: 60px; padding-bottom: 30px; }
      .about-page-hero .hero-title { font-size: clamp(1.4rem, 5vw, 1.9rem); }
      .about-page-hero p { font-size: .82rem; }

      /* About Stats - 2 col */
      .about-stats-grid {
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: -20px;
      }
      .about-stat-card { padding: 16px 12px; border-radius: 12px; }
      .about-stat-card .stat-number { font-size: 1.6rem; }
      .about-stat-card p { font-size: .7rem; }

      /* About Content */
      .about-content-grid {
        grid-template-columns: 1fr;
        gap: 30px;
      }
      .about-image-wrap img { height: 220px; }
      .about-image-badge {
        bottom: -10px;
        right: 10px;
        padding: 10px 16px;
        border-radius: 10px;
      }
      .about-image-badge .num { font-size: 1.2rem; }
      .about-image-badge .lbl { font-size: .6rem; }
      .about-text p { font-size: .82rem; line-height: 1.6; }
      .about-features { grid-template-columns: 1fr; gap: 6px; }
      .about-feature-item { font-size: .78rem; }

      /* CEO */
      .ceo-grid { grid-template-columns: 1fr; gap: 24px; text-align: center; }
      .ceo-photo { width: 100px; height: 100px; border-width: 3px; }
      .ceo-name { font-size: .95rem; }
      .ceo-role { font-size: .75rem; }
      .ceo-quote-mark { font-size: 2rem; }
      .ceo-message { font-size: .82rem; line-height: 1.6; }
      .ceo-sig { justify-content: center; gap: 10px; }
      .ceo-sig-text { font-size: .75rem; }

      /* Mission Vision Values */
      .mv-grid { grid-template-columns: 1fr; gap: 16px; margin-top: 28px; }
      .mv-card { padding: 20px 16px; }
      .mv-card .icon { width: 48px; height: 48px; font-size: 1.2rem; }
      .mv-card h3 { font-size: .9rem; }
      .mv-card p { font-size: .78rem; }

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
      .about-stats-grid { grid-template-columns: 1fr 1fr; }
      .footer-grid { grid-template-columns: 1fr 1fr; }
      .footer-brand { grid-column: span 2; }
    }

    @media (min-width: 769px) {
      .about-stats-grid { grid-template-columns: repeat(4, 1fr); }
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
      <span>{{ $settings['institute']['name'] ?? 'Leeds Institute' }}</span>
    </div>
    <button class="mobile-nav-close" id="navClose"><i class="fas fa-times"></i></button>
  </div>
  <a href="{{ route('home') }}" onclick="closeNav()"><i class="fas fa-home"></i> Home</a>
  <a href="{{ route('aboutus') }}" onclick="closeNav()" class="active"><i class="fas fa-info-circle"></i> About</a>
  <a href="{{ route('courses') }}" onclick="closeNav()"><i class="fas fa-book-open"></i> Courses</a>
  <a href="{{ route('admissions') }}" onclick="closeNav()"><i class="fas fa-clipboard-list"></i> Admissions</a>
  <a href="{{ route('faq') }}" onclick="closeNav()"><i class="fas fa-question-circle"></i> FAQ</a>
  <a href="{{ route('teachers') }}" onclick="closeNav()"><i class="fas fa-chalkboard-teacher"></i> Teachers</a>
  <a href="{{ route('gallery') }}" onclick="closeNav()"><i class="fas fa-images"></i> Gallery</a>
  <a href="{{ route('contact') }}" onclick="closeNav()"><i class="fas fa-phone"></i> Contact</a>
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
          <li><a href="{{ route('home') }}">Home</a></li>
          <li><a href="{{ route('aboutus') }}" class="active">About</a></li>
          <li><a href="{{ route('courses') }}">Courses</a></li>
          <li><a href="{{ route('admissions') }}">Admissions</a></li>
          <li><a href="{{ route('faq') }}">FAQ</a></li>
          <li><a href="{{ route('teachers') }}">Teachers</a></li>
          <li><a href="{{ route('gallery') }}">Gallery</a></li>
          <li><a href="{{ route('contact') }}">Contact</a></li>
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
   ABOUT PAGE HERO
═══════════════════════════════════════════════════ -->
<section class="about-page-hero">
  <div class="container">
    <div class="hero-content" data-aos="fade-up">
      <div class="section-tag" style="background:rgba(255,193,7,.15);color:var(--yellow);border:1px solid rgba(255,193,7,.2);">
        <i class="fas fa-info-circle"></i> About Us
      </div>
      <h1 class="hero-title">Building <span>Excellence</span><br>Since 2005</h1>
      <p>{{ $settings['institute']['about_description'] ?? 'Leeds Institute has been a cornerstone of quality education in the region for over two decades, committed to nurturing future leaders through innovation and integrity.' }}</p>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   ABOUT STATS CARDS (Dynamic from Database)
═══════════════════════════════════════════════════ -->
<section style="padding: 0 0 40px 0;">
  <div class="container">
    <div class="about-stats-grid">
      <div class="about-stat-card" data-aos="fade-up" data-aos-delay="0">
        <div class="stat-number">{{ $stats['students'] ?? 0 }}<span class="yellow">+</span></div>
        <p>Students Enrolled</p>
      </div>
      <div class="about-stat-card" data-aos="fade-up" data-aos-delay="60">
        <div class="stat-number">{{ $stats['teachers'] ?? 0 }}<span class="yellow">+</span></div>
        <p>Expert Teachers</p>
      </div>
      <div class="about-stat-card" data-aos="fade-up" data-aos-delay="120">
        <div class="stat-number">{{ $stats['courses'] ?? 0 }}<span class="yellow">+</span></div>
        <p>Courses Offered</p>
      </div>
      <div class="about-stat-card" data-aos="fade-up" data-aos-delay="180">
        <div class="stat-number">{{ $stats['success_rate'] ?? 98 }}<span class="yellow">%</span></div>
        <p>Success Rate</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   ABOUT CONTENT (Dynamic from Settings)
═══════════════════════════════════════════════════ -->
<section style="padding-top:0;">
  <div class="container">
    <div class="about-content-grid">
      <div class="about-image-wrap" data-aos="fade-right">
        <img src="{{ $settings['about']['image'] ? asset('storage/' . $settings['about']['image']) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTi6iTao9uzCT0_np_Ql0lj9_3FeGFSddBvDtRCZ0r9fQ&s=10' }}" alt="{{ $settings['institute']['name'] ?? 'Leeds Institute' }} Campus" />
        <div class="about-image-badge">
          <div class="num">{{ $settings['institute']['years_experience'] ?? 20 }}+</div>
          <div class="lbl">Years of<br>Excellence</div>
        </div>
      </div>
      <div class="about-text" data-aos="fade-left">
        <div class="section-tag"><i class="fas fa-building-columns"></i> Our Story</div>
        <h2>Building a Legacy of <span>Quality Education</span></h2>
        <div class="accent-bar"></div>
        <p>
          {{ $settings['about']['about_us'] ?? 'Leeds Institute was founded in 2005 with a simple yet powerful mission: to make quality education accessible to every student who dreams of a better future. What started as a small learning center has grown into a fully equipped institution serving thousands of students across multiple disciplines.' }}
        </p>
        <p>
          Over the past two decades, we have consistently delivered outstanding results in board examinations, with a 98% pass rate that speaks volumes about our commitment to academic excellence. Our students have gone on to become doctors, engineers, entrepreneurs, and leaders in their respective fields.
        </p>
        <div class="about-features">
          <div class="about-feature-item"><i class="fas fa-check-circle"></i> HEC Recognized Institute</div>
          <div class="about-feature-item"><i class="fas fa-check-circle"></i> Modern Curriculum</div>
          <div class="about-feature-item"><i class="fas fa-check-circle"></i> Experienced Faculty</div>
          <div class="about-feature-item"><i class="fas fa-check-circle"></i> State-of-the-Art Facilities</div>
          <div class="about-feature-item"><i class="fas fa-check-circle"></i> Affordable Fee Structure</div>
          <div class="about-feature-item"><i class="fas fa-check-circle"></i> Career Guidance & Support</div>
        </div>
        <a href="#mission" class="btn btn-navy" style="margin-top:20px;"><i class="fas fa-arrow-right"></i> Our Mission & Vision</a>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   MISSION VISION VALUES (Dynamic from Settings)
═══════════════════════════════════════════════════ -->
<section id="mission" style="background:var(--gray-50);">
  <div class="container">
    <div class="text-center" data-aos="fade-up">
      <div class="section-tag"><i class="fas fa-bullseye"></i> Our Core</div>
      <h2 class="section-title">Mission, Vision &amp; <span>Values</span></h2>
      <div class="accent-bar"></div>
      <p class="section-sub">Our guiding principles that shape everything we do at {{ $settings['institute']['name'] ?? 'Leeds Institute' }}.</p>
    </div>
    <div class="mv-grid">
      <div class="mv-card" data-aos="fade-up" data-aos-delay="0">
        <div class="icon"><i class="fas fa-rocket"></i></div>
        <h3>Our Mission</h3>
        <p>{{ $settings['about']['mission'] ?? 'To cultivate intellectual growth, moral character, and practical skills that equip students for lifelong success and meaningful contributions to society.' }}</p>
      </div>
      <div class="mv-card" data-aos="fade-up" data-aos-delay="80">
        <div class="icon"><i class="fas fa-eye"></i></div>
        <h3>Our Vision</h3>
        <p>{{ $settings['about']['vision'] ?? 'To be the most trusted educational institution in the region, recognized for academic excellence, student achievement, and community impact.' }}</p>
      </div>
      <div class="mv-card" data-aos="fade-up" data-aos-delay="160">
        <div class="icon"><i class="fas fa-heart"></i></div>
        <h3>Our Values</h3>
        <p>Integrity, excellence, innovation, inclusivity, and a commitment to nurturing every student's unique potential in a supportive environment.</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   CEO MESSAGE (Dynamic from Settings)
═══════════════════════════════════════════════════ -->
<section class="ceo-section">
  <div class="container">
    <div class="ceo-grid">
      <div class="ceo-photo-wrap" data-aos="fade-right">
        <div class="ceo-photo">
          <img src="{{ $settings['ceo']['photo'] ? asset('storage/' . $settings['ceo']['photo']) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcROdZ8ey95QUY6mhM2AvYu9AEPxdQl6Yno02JhtOiK_iQ&s=10' }}" alt="{{ $settings['ceo']['name'] ?? 'Dr. Imran Khalil' }}" />
        </div>
        <div class="ceo-name">{{ $settings['ceo']['name'] ?? 'Dr. Imran Khalil' }}</div>
        <div class="ceo-role">{{ $settings['ceo']['designation'] ?? 'Principal & CEO, Leeds Institute' }}</div>
      </div>
      <div class="ceo-content" data-aos="fade-left">
        <span class="ceo-quote-mark">"</span>
        <p class="ceo-message">
          {{ $settings['ceo']['message'] ?? 'At Leeds Institute, we believe education is not merely the transfer of knowledge — it is the transformation of lives. Every student who walks through our doors carries with them a dream, and it is our sacred responsibility to nurture that dream with the finest teaching, the most supportive environment, and the highest standards of academic rigour. Our commitment to excellence is reflected not just in our examination results, but in the leaders, professionals, and responsible citizens our graduates become. I invite every aspiring student and supportive parent to join the Leeds family — where your future begins today.' }}
        </p>
        <div class="ceo-sig">
          <div class="ceo-sig-line"></div>
          <div class="ceo-sig-text">— {{ $settings['ceo']['name'] ?? 'Dr. Imran Khalil' }}, Principal</div>
          <div class="ceo-sig-line"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   WHY CHOOSE US - SHORT (Dynamic from Settings)
═══════════════════════════════════════════════════ -->
<section style="background:var(--white);">
  <div class="container">
    <div class="text-center" data-aos="fade-up">
      <div class="section-tag"><i class="fas fa-star"></i> Why Leeds</div>
      <h2 class="section-title">What Makes Us <span>Different</span></h2>
      <div class="accent-bar"></div>
      <p class="section-sub">{{ $settings['about']['why_choose'] ?? 'We are committed to delivering an education that goes beyond textbooks — building character, skills, and futures.' }}</p>
    </div>
    <div class="why-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-top:52px;">
      <div class="why-card" data-aos="fade-up" data-aos-delay="0" style="background:var(--white);border-radius:var(--radius-lg);padding:28px 24px;box-shadow:var(--shadow-sm);border:1px solid var(--gray-200);transition:var(--transition);cursor:default;text-align:center;">
        <div style="width:56px;height:56px;border-radius:14px;background:rgba(11,60,109,.08);color:var(--navy);display:flex;align-items:center;justify-content:center;font-size:1.4rem;margin:0 auto 16px;transition:var(--transition);">
          <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <h3 style="font-size:1rem;font-weight:700;color:var(--navy);margin-bottom:6px;">Expert Faculty</h3>
        <p style="font-size:.85rem;color:var(--gray-600);line-height:1.6;">Our educators bring years of academic and industry experience to every classroom.</p>
      </div>
      <div class="why-card" data-aos="fade-up" data-aos-delay="80" style="background:var(--white);border-radius:var(--radius-lg);padding:28px 24px;box-shadow:var(--shadow-sm);border:1px solid var(--gray-200);transition:var(--transition);cursor:default;text-align:center;">
        <div style="width:56px;height:56px;border-radius:14px;background:rgba(11,60,109,.08);color:var(--navy);display:flex;align-items:center;justify-content:center;font-size:1.4rem;margin:0 auto 16px;transition:var(--transition);">
          <i class="fas fa-laptop"></i>
        </div>
        <h3 style="font-size:1rem;font-weight:700;color:var(--navy);margin-bottom:6px;">Modern Facilities</h3>
        <p style="font-size:.85rem;color:var(--gray-600);line-height:1.6;">Smart classrooms, computer labs, and a library with 10,000+ resources.</p>
      </div>
      <div class="why-card" data-aos="fade-up" data-aos-delay="160" style="background:var(--white);border-radius:var(--radius-lg);padding:28px 24px;box-shadow:var(--shadow-sm);border:1px solid var(--gray-200);transition:var(--transition);cursor:default;text-align:center;">
        <div style="width:56px;height:56px;border-radius:14px;background:rgba(11,60,109,.08);color:var(--navy);display:flex;align-items:center;justify-content:center;font-size:1.4rem;margin:0 auto 16px;transition:var(--transition);">
          <i class="fas fa-hand-holding-heart"></i>
        </div>
        <h3 style="font-size:1rem;font-weight:700;color:var(--navy);margin-bottom:6px;">Affordable Education</h3>
        <p style="font-size:.85rem;color:var(--gray-600);line-height:1.6;">Quality education with transparent fee structure and flexible payment options.</p>
      </div>
    </div>
    <div style="text-align:center;margin-top:40px;">
      <a href="{{ route('contact') }}" class="btn btn-primary"><i class="fas fa-phone"></i> Get In Touch</a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════
   FOOTER (Dynamic Courses)
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
          <p>{{ $settings['institute']['about_description'] ?? 'Leeds Institute is dedicated to delivering quality education that prepares students for academic excellence and lifelong success in an ever-changing world.' }}</p>
          <div class="footer-social">
            @if($settings['social']['facebook'])
              <a href="{{ $settings['social']['facebook'] }}" class="social-btn" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            @endif
            @if($settings['social']['twitter'])
              <a href="{{ $settings['social']['twitter'] }}" class="social-btn" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
            @endif
            @if($settings['social']['instagram'])
              <a href="{{ $settings['social']['instagram'] }}" class="social-btn" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
            @endif
            @if($settings['social']['youtube'])
              <a href="{{ $settings['social']['youtube'] }}" class="social-btn" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
            @endif
            @if($settings['social']['tiktok'])
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
              <li><a href="{{ route('courses') }}"><i class="fas fa-chevron-right"></i> {{ $course->name }}</a></li>
            @endforeach
            @if($allCourses->count() > 5)
              <li><a href="{{ route('courses') }}"><i class="fas fa-chevron-right"></i> View All</a></li>
            @endif
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
            @if($settings['contact']['whatsapp'])
              <li><i class="fab fa-whatsapp"></i> {{ $settings['contact']['whatsapp'] }}</li>
            @endif
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
        <a href="{{ route('home') }}">Sitemap</a>
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
    if (link.getAttribute('href') === '{{ route('aboutus') }}') {
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