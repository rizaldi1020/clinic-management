<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>klinik online</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <meta name="robots" content="noindex, nofollow">

  <!-- Favicons -->
  <link href="{{ asset('meditrust/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('meditrust/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('meditrust/css/main.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: MediTrust
  * Template URL: https://bootstrapmade.com/meditrust-bootstrap-hospital-website-template/
  * Updated: Jul 04 2025 with Bootstrap v5.3.7
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="#" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="{{ asset('meditrust/img/logo.webp') }}" alt=""> -->
        <svg class="my-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <g id="bgCarrier" stroke-width="0"></g>
          <g id="tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
          <g id="iconCarrier">
            <path d="M22 22L2 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path d="M17 22V6C17 4.11438 17 3.17157 16.4142 2.58579C15.8284 2 14.8856 2 13 2H11C9.11438 2 8.17157 2 7.58579 2.58579C7 3.17157 7 4.11438 7 6V22" stroke="currentColor" stroke-width="1.5"></path>
            <path opacity="0.5" d="M21 22V8.5C21 7.09554 21 6.39331 20.6629 5.88886C20.517 5.67048 20.3295 5.48298 20.1111 5.33706C19.6067 5 18.9045 5 17.5 5" stroke="currentColor" stroke-width="1.5"></path>
            <path opacity="0.5" d="M3 22V8.5C3 7.09554 3 6.39331 3.33706 5.88886C3.48298 5.67048 3.67048 5.48298 3.88886 5.33706C4.39331 5 5.09554 5 6.5 5" stroke="currentColor" stroke-width="1.5"></path>
            <path d="M12 22V19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path opacity="0.5" d="M10 12H14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path opacity="0.5" d="M5.5 11H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path opacity="0.5" d="M5.5 14H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path opacity="0.5" d="M17 11H18.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path opacity="0.5" d="M17 14H18.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path opacity="0.5" d="M5.5 8H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path opacity="0.5" d="M17 8H18.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path opacity="0.5" d="M10 15H14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path d="M12 9V5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M14 7L10 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
          </g>
        </svg>

        <h1 class="sitename">Klinik Online</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#" class="active">Beranda</a></li>
          <li><a href="#">Tentang</a></li>
          <li><a href="#">Departemen</a></li>
          <li><a href="#">Layanan</a></li>
          <li><a href="#">Dokter</a></li>
          <li class="dropdown"><a href="index.html#"><span>Halaman Lain</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Detail Departemen</a></li>
              <li><a href="#">Detail Layanan</a></li>
              <li><a href="{{ route('login') }}">Janji Temu</a></li>
              <li><a href="#">Testimoni</a></li>
              <li><a href="#">Pertanyaan yang Sering Diajukan</a></li>
              <li><a href="#">Galeri</a></li>
              <li><a href="#">Ketentuan Penggunaan</a></li>
              <li><a href="#">Pribadi</a></li>
              <li><a href="#">404</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="index.html#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="index.html#">Dropdown 1</a></li>
              <li class="dropdown"><a href="index.html#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="index.html#">Deep Dropdown 1</a></li>
                  <li><a href="index.html#">Deep Dropdown 2</a></li>
                  <li><a href="index.html#">Deep Dropdown 3</a></li>
                  <li><a href="index.html#">Deep Dropdown 4</a></li>
                  <li><a href="index.html#">Deep Dropdown 5</a></li>
                </ul>
              </li>
              <li><a href="index.html#">Dropdown 2</a></li>
              <li><a href="index.html#">Dropdown 3</a></li>
              <li><a href="index.html#">Dropdown 4</a></li>
            </ul>
          </li>
          <li><a href="#">Kontak</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      @auth
        <a class="btn-getstarted" href="{{ route('home') }}">Dasbor</a>
      
        @else
        <a class="btn-getstarted" href="{{ route('login') }}">Daftar</a>
      @endauth
    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">
      <div class="container-fluid p-0">
        <div class="hero-wrapper">
          <div class="hero-image">
            <img src="{{ asset('meditrust/img/health/showcase-1.webp') }}" alt="Layanan Kesehatan Canggih" class="img-fluid">
          </div>

          <div class="hero-content">
            <div class="container">
              <div class="row">
                <div class="col-lg-7 col-md-10" data-aos="fade-right" data-aos-delay="100">
                  <div class="content-box">
                    <span class="badge-accent" data-aos="fade-up" data-aos-delay="150">Spesialis Kesehatan Terkemuka</span>
                    <h1 data-aos="fade-up" data-aos-delay="200">Perawatan Medis Canggih untuk Kesehatan Keluarga Anda</h1>
                    <p data-aos="fade-up" data-aos-delay="250">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>

                    <div class="cta-group" data-aos="fade-up" data-aos-delay="300">
                      <a href="{{ route('login') }}" class="btn btn-primary">Buat Janji</a>
                      <a href="#" class="btn btn-outline">Jelajahi Layanan</a>
                    </div>

                    <div class="info-badges" data-aos="fade-up" data-aos-delay="350">
                      <div class="badge-item">
                        <i class="bi bi-telephone-fill"></i>
                        <div class="badge-content">
                          <span>Panggilan Darurat</span>
                          <strong>+62 123 456 789</strong>
                        </div>
                      </div>
                      <div class="badge-item">
                        <i class="bi bi-clock-fill"></i>
                        <div class="badge-content">
                          <span>Jam Kerja</span>
                          <strong>Senin-Jumat: 10:00-18:00</strong>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="features-wrapper">
                <div class="row gy-4">

                  <div class="col-lg-4">
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="450">
                      <div class="feature-icon">
                        <i class="bi bi-heart-pulse-fill"></i>
                      </div>
                      <div class="feature-text">
                        <h3>Kardiologi</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="500">
                      <div class="feature-icon">
                        <i class="bi bi-lungs-fill"></i>
                      </div>
                      <div class="feature-text">
                        <h3>Pulmonologi</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="550">
                      <div class="feature-icon">
                        <i class="bi bi-capsule"></i>
                      </div>
                      <div class="feature-text">
                        <h3>Diagnostik</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section><!-- /Hero Section -->

    <!-- Home About Section -->
    <section id="home-about" class="home-about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-5 align-items-center">
          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
            <div class="about-image">
              <img src="{{ asset('meditrust/img/health/facilities-1.webp') }}" alt="Fasilitas Kesehatan Modern" class="img-fluid rounded-3 mb-4">
              <div class="experience-badge">
                <span class="years">25+</span>
                <span class="text">Tahun Keunggulan</span>
              </div>
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
            <div class="about-content">
              <h2>Berkomitmen pada Perawatan Pasien yang Luar Biasa</h2>
              <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>

              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin consequat magna eu accumsan mattis. Duis non augue in tortor facilisis tincidunt ac sit amet sapien. Suspendisse id risus non nisi sodales condimentum.</p>

              <div class="row g-4 mt-4">
                <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                  <div class="feature-item">
                    <div class="icon">
                      <i class="bi bi-heart-pulse"></i>
                    </div>
                    <h4>Perawatan Penuh Kepedulian</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                  </div>
                </div>

                <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                  <div class="feature-item">
                    <div class="icon">
                      <i class="bi bi-star"></i>
                    </div>
                    <h4>Keunggulan Medis</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                  </div>
                </div>
              </div>

              <div class="cta-wrapper mt-4">
                <a href="#" class="btn btn-primary">Pelajari Lebih Lanjut Tentang Kami</a>
                <a href="index.html#" class="btn btn-outline">Temui Tim Kami</a>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-5 pt-4 certifications-row" data-aos="fade-up" data-aos-delay="600">
          <div class="col-12 text-center mb-4">
            <h4 class="certification-title">Akreditasi Kami</h4>
          </div>
          <div class="col-12">
            <div class="certifications">
              <div class="certification-item" data-aos="zoom-in" data-aos-delay="700">
                <img src="{{ asset('meditrust/img/clients/clients-1.webp') }}" alt="Sertifikasi">
              </div>
              <div class="certification-item" data-aos="zoom-in" data-aos-delay="800">
                <img src="{{ asset('meditrust/img/clients/clients-2.webp') }}" alt="Sertifikasi">
              </div>
              <div class="certification-item" data-aos="zoom-in" data-aos-delay="900">
                <img src="{{ asset('meditrust/img/clients/clients-3.webp') }}" alt="Sertifikasi">
              </div>
              <div class="certification-item" data-aos="zoom-in" data-aos-delay="1000">
                <img src="{{ asset('meditrust/img/clients/clients-4.webp') }}" alt="Sertifikasi">
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Home About Section -->

    <!-- Departemen Unggulan Section -->
    <section id="featured-departments" class="featured-departments section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Departemen Unggulan</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="department-card">
              <div class="department-image">
                <img src="{{ asset('meditrust/img/health/cardiology-3.webp') }}" alt="Departemen Kardiologi" class="img-fluid">
              </div>
              <div class="department-content">
                <div class="department-icon">
                  <i class="fas fa-heartbeat"></i>
                </div>
                <h3>Kardiologi</h3>
                <p>Perawatan kardiovaskular menyeluruh dengan teknik diagnostik canggih dan pilihan perawatan untuk kondisi jantung, demi kesehatan jantung yang optimal bagi semua pasien.</p>
                <a href="#" class="btn-learn-more">
                  <span>Pelajari Lebih Lanjut</span>
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Department Card -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="department-card">
              <div class="department-image">
                <img src="{{ asset('meditrust/img/health/neurology-2.webp') }}" alt="Departemen Neurologi" class="img-fluid">
              </div>
              <div class="department-content">
                <div class="department-icon">
                  <i class="fas fa-brain"></i>
                </div>
                <h3>Neurologi</h3>
                <p>Perawatan neurologis ahli yang berfokus pada gangguan otak dan sistem saraf, menghadirkan perawatan mutakhir serta dukungan penuh empati untuk kondisi neurologis.</p>
                <a href="#" class="btn-learn-more">
                  <span>Pelajari Lebih Lanjut</span>
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Department Card -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="department-card">
              <div class="department-image">
                <img src="{{ asset('meditrust/img/health/orthopedics-4.webp') }}" alt="Departemen Ortopedi" class="img-fluid">
              </div>
              <div class="department-content">
                <div class="department-icon">
                  <i class="fas fa-bone"></i>
                </div>
                <h3>Ortopedi</h3>
                <p>Perawatan muskuloskeletal canggih yang berfokus pada tulang, sendi, dan otot dengan pendekatan perawatan bedah maupun non-bedah untuk memulihkan mobilitas.</p>
                <a href="#" class="btn-learn-more">
                  <span>Pelajari Lebih Lanjut</span>
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Department Card -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="department-card">
              <div class="department-image">
                <img src="{{ asset('meditrust/img/health/pediatrics-3.webp') }}" alt="Departemen Pediatri" class="img-fluid">
              </div>
              <div class="department-content">
                <div class="department-icon">
                  <i class="fas fa-baby"></i>
                </div>
                <h3>Pediatri</h3>
                <p>Layanan kesehatan khusus untuk anak sejak bayi hingga remaja, menghadirkan perawatan medis menyeluruh dalam lingkungan yang ramah anak bersama spesialis anak berpengalaman.</p>
                <a href="#" class="btn-learn-more">
                  <span>Pelajari Lebih Lanjut</span>
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Department Card -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="department-card">
              <div class="department-image">
                <img src="{{ asset('meditrust/img/health/oncology-4.webp') }}" alt="Departemen Onkologi" class="img-fluid">
              </div>
              <div class="department-content">
                <div class="department-icon">
                  <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Onkologi</h3>
                <p>Perawatan kanker menyeluruh dengan pendekatan multidisiplin, menghadirkan pilihan perawatan canggih, uji klinis, dan dukungan penuh empati sepanjang perjalanan pengobatan kanker.</p>
                <a href="#" class="btn-learn-more">
                  <span>Pelajari Lebih Lanjut</span>
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Department Card -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="department-card">
              <div class="department-image">
                <img src="{{ asset('meditrust/img/health/emergency-2.webp') }}" alt="Departemen Gawat Darurat" class="img-fluid">
              </div>
              <div class="department-content">
                <div class="department-icon">
                  <i class="fas fa-ambulance"></i>
                </div>
                <h3>Perawatan Gawat Darurat</h3>
                <p>Layanan medis gawat darurat sepanjang waktu dengan kemampuan respons cepat, peralatan canggih, dan dokter gawat darurat berpengalaman untuk perawatan kritis.</p>
                <a href="#" class="btn-learn-more">
                  <span>Pelajari Lebih Lanjut</span>
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Department Card -->

        </div>

      </div>

    </section><!-- /Departemen Unggulan Section -->

    <!-- Layanan Unggulan Section -->
    <section id="featured-services" class="featured-services section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Layanan Unggulan</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-card">
              <div class="service-icon">
                <i class="fas fa-heartbeat"></i>
              </div>
              <div class="service-content">
                <h3>Keunggulan Kardiologi</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
                <ul class="service-features">
                  <li><i class="fas fa-check-circle"></i>Bedah Jantung Canggih</li>
                  <li><i class="fas fa-check-circle"></i>Perawatan Darurat 24/7</li>
                  <li><i class="fas fa-check-circle"></i>Skrining Pencegahan</li>
                </ul>
                <a href="#" class="service-btn">
                  Pelajari Lebih Lanjut
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Card -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-card">
              <div class="service-icon">
                <i class="fas fa-brain"></i>
              </div>
              <div class="service-content">
                <h3>Neurologi &amp; Kesehatan Otak</h3>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse.</p>
                <ul class="service-features">
                  <li><i class="fas fa-check-circle"></i>Pencitraan &amp; Diagnostik Otak</li>
                  <li><i class="fas fa-check-circle"></i>Pusat Penanganan Stroke</li>
                  <li><i class="fas fa-check-circle"></i>Rehabilitasi Neurologis</li>
                </ul>
                <a href="#" class="service-btn">
                  Pelajari Lebih Lanjut
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Card -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
            <div class="service-card">
              <div class="service-icon">
                <i class="fas fa-bone"></i>
              </div>
              <div class="service-content">
                <h3>Bedah Ortopedi</h3>
                <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error.</p>
                <ul class="service-features">
                  <li><i class="fas fa-check-circle"></i>Operasi Penggantian Sendi</li>
                  <li><i class="fas fa-check-circle"></i>Kedokteran Olahraga</li>
                  <li><i class="fas fa-check-circle"></i>Prosedur Minim Invasif</li>
                </ul>
                <a href="#" class="service-btn">
                  Pelajari Lebih Lanjut
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Card -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="500">
            <div class="service-card">
              <div class="service-icon">
                <i class="fas fa-ambulance"></i>
              </div>
              <div class="service-content">
                <h3>Gawat Darurat &amp; Perawatan Trauma</h3>
                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                <ul class="service-features">
                  <li><i class="fas fa-check-circle"></i>Unit Gawat Darurat 24/7</li>
                  <li><i class="fas fa-check-circle"></i>Pusat Trauma Level 1</li>
                  <li><i class="fas fa-check-circle"></i>Unit Perawatan Kritis</li>
                </ul>
                <a href="#" class="service-btn">
                  Pelajari Lebih Lanjut
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Card -->

        </div>

      </div>

    </section><!-- /Layanan Unggulan Section -->

    <!-- Temukan Dokter Section -->
    <section id="find-a-doctor" class="find-a-doctor section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Temukan Dokter</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="200">
          <div class="col-lg-12">
            <div class="search-container">
              <form class="search-form" action="#" method="get">
                <div class="row g-3">
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="doctor_name" placeholder="Nama dokter atau kata kunci">
                  </div>
                  <div class="col-md-4">
                    <select class="form-select" name="specialty" id="specialty-select">
                      <option value="">Pilih Spesialisasi</option>
                      <option value="cardiology">Kardiologi</option>
                      <option value="neurology">Neurologi</option>
                      <option value="orthopedics">Ortopedi</option>
                      <option value="pediatrics">Pediatri</option>
                      <option value="dermatology">Dermatologi</option>
                      <option value="oncology">Onkologi</option>
                      <option value="surgery">Bedah</option>
                      <option value="emergency">Kedokteran Gawat Darurat</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                      <i class="bi bi-search me-2"></i>Cari Dokter
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="400">
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="doctor-card">
              <div class="doctor-image">
                <img src="{{ asset('meditrust/img/health/staff-3.webp') }}" alt="Dr. Sarah Mitchell" class="img-fluid">
                <div class="availability-badge online">Tersedia</div>
              </div>
              <div class="doctor-info">
                <h5>Dr. Sarah Mitchell</h5>
                <p class="specialty">Kardiologi</p>
                <p class="experience">15+ tahun pengalaman</p>
                <div class="rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <span class="rating-text">(4.9)</span>
                </div>
                <div class="appointment-actions">
                  <a href="index.html#" class="btn btn-outline-primary btn-sm">Lihat Profil</a>
                  <a href="index.html#" class="btn btn-primary btn-sm">Buat Janji Temu</a>
                </div>
              </div>
            </div>
          </div><!-- End Doctor Card -->

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="doctor-card">
              <div class="doctor-image">
                <img src="{{ asset('meditrust/img/health/staff-7.webp') }}" alt="Dr. Michael Rodriguez" class="img-fluid">
                <div class="availability-badge busy">Sedang Operasi</div>
              </div>
              <div class="doctor-info">
                <h5>Dr. Michael Rodriguez</h5>
                <p class="specialty">Neurologi</p>
                <p class="experience">12+ tahun pengalaman</p>
                <div class="rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-half"></i>
                  <span class="rating-text">(4.7)</span>
                </div>
                <div class="appointment-actions">
                  <a href="index.html#" class="btn btn-outline-primary btn-sm">Lihat Profil</a>
                  <a href="index.html#" class="btn btn-primary btn-sm">Buat Janji Temu</a>
                </div>
              </div>
            </div>
          </div><!-- End Doctor Card -->

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="doctor-card">
              <div class="doctor-image">
                <img src="{{ asset('meditrust/img/health/staff-1.webp') }}" alt="Dr. Emily Chen" class="img-fluid">
                <div class="availability-badge online">Tersedia</div>
              </div>
              <div class="doctor-info">
                <h5>Dr. Emily Chen</h5>
                <p class="specialty">Pediatri</p>
                <p class="experience">8+ tahun pengalaman</p>
                <div class="rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <span class="rating-text">(5.0)</span>
                </div>
                <div class="appointment-actions">
                  <a href="index.html#" class="btn btn-outline-primary btn-sm">Lihat Profil</a>
                  <a href="index.html#" class="btn btn-primary btn-sm">Buat Janji Temu</a>
                </div>
              </div>
            </div>
          </div><!-- End Doctor Card -->

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="doctor-card">
              <div class="doctor-image">
                <img src="{{ asset('meditrust/img/health/staff-9.webp') }}" alt="Dr. James Thompson" class="img-fluid">
                <div class="availability-badge offline">Berikutnya: Besok Jam 9 Pagi</div>
              </div>
              <div class="doctor-info">
                <h5>Dr. James Thompson</h5>
                <p class="specialty">Ortopedi</p>
                <p class="experience">20+ tahun pengalaman</p>
                <div class="rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-half"></i>
                  <span class="rating-text">(4.8)</span>
                </div>
                <div class="appointment-actions">
                  <a href="index.html#" class="btn btn-outline-primary btn-sm">Lihat Profil</a>
                  <a href="index.html#" class="btn btn-primary btn-sm">Buat Janji Temu</a>
                </div>
              </div>
            </div>
          </div><!-- End Doctor Card -->

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="doctor-card">
              <div class="doctor-image">
                <img src="{{ asset('meditrust/img/health/staff-5.webp') }}" alt="Dr. Lisa Anderson" class="img-fluid">
                <div class="availability-badge online">Tersedia</div>
              </div>
              <div class="doctor-info">
                <h5>Dr. Lisa Anderson</h5>
                <p class="specialty">Dermatologi</p>
                <p class="experience">10+ tahun pengalaman</p>
                <div class="rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star"></i>
                  <span class="rating-text">(4.6)</span>
                </div>
                <div class="appointment-actions">
                  <a href="index.html#" class="btn btn-outline-primary btn-sm">Lihat Profil</a>
                  <a href="index.html#" class="btn btn-primary btn-sm">Buat Janji Temu</a>
                </div>
              </div>
            </div>
          </div><!-- End Doctor Card -->

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="doctor-card">
              <div class="doctor-image">
                <img src="{{ asset('meditrust/img/health/staff-12.webp') }}" alt="Dr. Robert Kim" class="img-fluid">
                <div class="availability-badge online">Tersedia</div>
              </div>
              <div class="doctor-info">
                <h5>Dr. Robert Kim</h5>
                <p class="specialty">Onkologi</p>
                <p class="experience">18+ tahun pengalaman</p>
                <div class="rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <span class="rating-text">(4.9)</span>
                </div>
                <div class="appointment-actions">
                  <a href="index.html#" class="btn btn-outline-primary btn-sm">Lihat Profil</a>
                  <a href="index.html#" class="btn btn-primary btn-sm">Buat Janji Temu</a>
                </div>
              </div>
            </div>
          </div><!-- End Doctor Card -->

        </div>

      </div>

    </section><!-- /Temukan Dokter Section -->

    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
            <h2 data-aos="fade-up" data-aos-delay="200">Kesehatan Anda adalah Prioritas Kami</h2>
            <p data-aos="fade-up" data-aos-delay="250">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>

            <div class="cta-buttons" data-aos="fade-up" data-aos-delay="300">
              <a href="{{ route('login') }}" class="btn-primary">Buat Janji Temu</a>
              <a href="#" class="btn-secondary">Temukan Dokter</a>
            </div>
          </div>
        </div>

        <div class="row features-row" data-aos="fade-up" data-aos-delay="400">

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
              <div class="icon-wrapper">
                <i class="bi bi-heart-pulse"></i>
              </div>
              <h5>Perawatan Darurat 24/7</h5>
              <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</p>
              <a href="index.html#" class="feature-link">
                <span>Pelajari Lebih Lanjut</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
              <div class="icon-wrapper">
                <i class="bi bi-calendar-check"></i>
              </div>
              <h5>Pemesanan Online Mudah</h5>
              <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
              <a href="index.html#" class="feature-link">
                <span>Pesan Sekarang</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
              <div class="icon-wrapper">
                <i class="bi bi-people"></i>
              </div>
              <h5>Tim Medis Ahli</h5>
              <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim.</p>
              <a href="index.html#" class="feature-link">
                <span>Temui Dokter Kami</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>

        </div>

        <div class="emergency-alert" data-aos="zoom-in" data-aos-delay="500">
          <div class="row align-items-center">
            <div class="col-lg-8">
              <div class="emergency-content">
                <div class="emergency-icon">
                  <i class="bi bi-telephone-fill"></i>
                </div>
                <div class="emergency-text">
                  <h4>Keadaan Darurat Medis?</h4>
                  <p>Hubungi hotline darurat 24/7 kami untuk bantuan segera</p>
                </div>
              </div>
            </div>
            <div class="col-lg-4 text-end">
              <a href="tel:911" class="emergency-btn">
                <i class="bi bi-telephone-fill"></i>
                Hubungi (555) 123-4567
              </a>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Call To Action Section -->

    <!-- Informasi Darurat Section -->
    <section id="emergency-info" class="emergency-info section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Informasi Darurat</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">

            <!-- Emergency Alert Banner -->
            <div class="emergency-alert" data-aos="zoom-in" data-aos-delay="100">
              <div class="alert-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
              </div>
              <div class="alert-content">
                <h3>Keadaan Darurat Medis?</h3>
                <p>Jika Anda mengalami keadaan darurat yang mengancam jiwa, segera hubungi 911 atau pergi ke unit gawat darurat terdekat.</p>
              </div>
              <div class="alert-action">
                <a href="tel:911" class="btn btn-emergency">
                  <i class="bi bi-telephone-fill"></i>
                  Hubungi 911
                </a>
              </div>
            </div><!-- End Emergency Alert -->

            <!-- Emergency Contact Grid -->
            <div class="row emergency-contacts" data-aos="fade-up" data-aos-delay="200">

              <div class="col-md-6 mb-4">
                <div class="contact-card urgent">
                  <div class="card-icon">
                    <i class="bi bi-hospital"></i>
                  </div>
                  <div class="card-content">
                    <h4>Unit Gawat Darurat</h4>
                    <p class="contact-info">
                      <i class="bi bi-telephone"></i>
                      <span>+1 (555) 123-4567</span>
                    </p>
                    <p class="address">
                      <i class="bi bi-geo-alt"></i>
                      1245 Healthcare Blvd, Medical City, CA 90210
                    </p>
                    <p class="hours">Buka 24/7</p>
                  </div>
                  <div class="card-action">
                    <a href="tel:+15551234567" class="btn btn-contact">Hubungi Sekarang</a>
                  </div>
                </div>
              </div><!-- End Unit Gawat Darurat Card -->

              <div class="col-md-6 mb-4">
                <div class="contact-card">
                  <div class="card-icon">
                    <i class="bi bi-clock"></i>
                  </div>
                  <div class="card-content">
                    <h4>Perawatan Mendesak</h4>
                    <p class="contact-info">
                      <i class="bi bi-telephone"></i>
                      <span>+1 (555) 987-6543</span>
                    </p>
                    <p class="address">
                      <i class="bi bi-geo-alt"></i>
                      892 Wellness Ave, Health District, CA 90211
                    </p>
                    <p class="hours">Sen-Min: 07:00 - 22:00</p>
                  </div>
                  <div class="card-action">
                    <a href="tel:+15559876543" class="btn btn-contact">Hubungi Sekarang</a>
                  </div>
                </div>
              </div><!-- End Perawatan Mendesak Card -->

              <div class="col-md-6 mb-4">
                <div class="contact-card">
                  <div class="card-icon">
                    <i class="bi bi-headset"></i>
                  </div>
                  <div class="card-content">
                    <h4>Hotline Perawat</h4>
                    <p class="contact-info">
                      <i class="bi bi-telephone"></i>
                      <span>+1 (555) 456-7890</span>
                    </p>
                    <p class="description">Saran dan panduan medis 24/7</p>
                    <p class="hours">Tersedia 24/7</p>
                  </div>
                  <div class="card-action">
                    <a href="tel:+15554567890" class="btn btn-contact">Hubungi Sekarang</a>
                  </div>
                </div>
              </div><!-- End Hotline Perawat Card -->

              <div class="col-md-6 mb-4">
                <div class="contact-card">
                  <div class="card-icon">
                    <i class="bi bi-heart-pulse"></i>
                  </div>
                  <div class="card-content">
                    <h4>Pusat Informasi Keracunan</h4>
                    <p class="contact-info">
                      <i class="bi bi-telephone"></i>
                      <span>1-800-222-1222</span>
                    </p>
                    <p class="description">Hotline pusat informasi keracunan nasional</p>
                    <p class="hours">Tersedia 24/7</p>
                  </div>
                  <div class="card-action">
                    <a href="tel:18002221222" class="btn btn-contact">Hubungi Sekarang</a>
                  </div>
                </div>
              </div><!-- End Pusat Informasi Keracunan Card -->

            </div><!-- End Emergency Contacts -->

            <!-- Aksi Cepat -->
            <div class="quick-actions" data-aos="fade-up" data-aos-delay="300">
              <h4>Aksi Cepat</h4>
              <div class="row">
                <div class="col-sm-6 col-lg-3">
                  <a href="index.html#" class="action-link">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>Dapatkan Petunjuk Arah</span>
                  </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                  <a href="index.html#" class="action-link">
                    <i class="bi bi-calendar-check"></i>
                    <span>Buat Janji Temu</span>
                  </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                  <a href="index.html#" class="action-link">
                    <i class="bi bi-person-badge"></i>
                    <span>Temukan Dokter</span>
                  </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                  <a href="index.html#" class="action-link">
                    <i class="bi bi-chat-dots"></i>
                    <span>Obrolan Langsung</span>
                  </a>
                </div>
              </div>
            </div><!-- End Aksi Cepat -->

            <!-- Emergency Preparation Tips -->
            <div class="emergency-tips" data-aos="fade-up" data-aos-delay="400">
              <h4>Kapan Harus Mencari Perawatan Darurat</h4>
              <div class="row">
                <div class="col-md-6">
                  <ul class="emergency-list">
                    <li><i class="bi bi-check-circle"></i> Nyeri dada atau kesulitan bernapas</li>
                    <li><i class="bi bi-check-circle"></i> Reaksi alergi parah</li>
                    <li><i class="bi bi-check-circle"></i> Trauma atau cedera besar</li>
                    <li><i class="bi bi-check-circle"></i> Tanda-tanda stroke atau serangan jantung</li>
                  </ul>
                </div>
                <div class="col-md-6">
                  <ul class="emergency-list">
                    <li><i class="bi bi-check-circle"></i> Luka bakar atau pendarahan parah</li>
                    <li><i class="bi bi-check-circle"></i> Kehilangan kesadaran</li>
                    <li><i class="bi bi-check-circle"></i> Nyeri perut parah</li>
                    <li><i class="bi bi-check-circle"></i> Demam tinggi disertai kebingungan</li>
                  </ul>
                </div>
              </div>
            </div><!-- End Emergency Tips -->

          </div>
        </div>

      </div>

    </section><!-- /Informasi Darurat Section -->

  </main>

  <footer id="footer" class="footer position-relative light-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="#" class="logo d-flex align-items-center">
            <span class="sitename">MediTrust</span>
          </a>
          <div class="footer-contact pt-3">
            <p>A108 Adam Street</p>
            <p>New York, NY 535022</p>
            <p class="mt-3"><strong>Telepon:</strong> <span>+1 5589 55488 55</span></p>
            <p><strong>Email:</strong> <span><a href="https://bootstrapmade.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="b0d9ded6dff0d5c8d1ddc0dcd59ed3dfdd">[email&#160;protected]</a></span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href="index.html"><i class="bi bi-twitter-x"></i></a>
            <a href="index.html"><i class="bi bi-facebook"></i></a>
            <a href="index.html"><i class="bi bi-instagram"></i></a>
            <a href="index.html"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Tautan Berguna</h4>
          <ul>
            <li><a href="index.html#">Beranda</a></li>
            <li><a href="index.html#">Tentang kami</a></li>
            <li><a href="index.html#">Layanan</a></li>
            <li><a href="index.html#">Ketentuan layanan</a></li>
            <li><a href="index.html#">Kebijakan privasi</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Layanan Kami</h4>
          <ul>
            <li><a href="index.html#">Desain Web</a></li>
            <li><a href="index.html#">Pengembangan Web</a></li>
            <li><a href="index.html#">Manajemen Produk</a></li>
            <li><a href="index.html#">Pemasaran</a></li>
            <li><a href="index.html#">Desain Grafis</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Hic solutasetp</h4>
          <ul>
            <li><a href="index.html#">Molestiae accusamus iure</a></li>
            <li><a href="index.html#">Excepturi dignissimos</a></li>
            <li><a href="index.html#">Suscipit distinctio</a></li>
            <li><a href="index.html#">Dilecta</a></li>
            <li><a href="index.html#">Sit quas consectetur</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Nobis illum</h4>
          <ul>
            <li><a href="index.html#">Ipsam</a></li>
            <li><a href="index.html#">Laudantium dolorum</a></li>
            <li><a href="index.html#">Dinera</a></li>
            <li><a href="index.html#">Trodelas</a></li>
            <li><a href="index.html#">Flexo</a></li>
          </ul>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Hak Cipta</span> <strong class="px-1 sitename">clinic-management</strong> <span>Semua Hak Dilindungi</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Didesain oleh <a href="https://mrizaldiwahyu@gmail.com/">rizal wahyu</a> & <a href="https://regandewa@gmail.com/">regan dewa</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="index.html#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@srexi/purecounterjs/dist/purecounter_vanilla.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/imagesloaded@5.0.0/imagesloaded.pkgd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/isotope-layout@3.0.6/dist/isotope.pkgd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

  <!-- Main JS File -->
  <script src="{{ asset('meditrust/js/main.js') }}"></script>

</body>

</html>