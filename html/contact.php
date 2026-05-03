<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Contacto</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico">
    <!-- Place favicon.ico in the root directory -->

   <!-- CSS here -->
   <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
   <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
   <link rel="stylesheet" href="../assets/css/slicknav.css">
   <link rel="stylesheet" href="../assets/css/animate.min.css">
   <link rel="stylesheet" href="../assets/css/magnific-popup.css">
   <link rel="stylesheet" href="../assets/css/fontawesome-all.min.css">
   <link rel="stylesheet" href="../assets/css/themify-icons.css">
   <link rel="stylesheet" href="../assets/css/themify-icons.css">
   <link rel="stylesheet" href="../assets/css/slick.css">
   <link rel="stylesheet" href="../assets/css/nice-select.css">
   <link rel="stylesheet" href="../assets/css/style.css">
   <link rel="stylesheet" href="../assets/css/responsive.css">
</head>

<body>
    
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <strong>Hotel</b>
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->

    <header>
        <!-- Header Start -->
       <div class="header-area header-sticky">
            <div class="main-header ">
                <div class="container">
                    <div class="row align-items-center">
                        <!-- logo -->
                        <div class="col-xl-2 col-lg-2">
                            <div class="logo">
                               <a href="index.php"><img src="../assets/img/logo/logo.png" alt="" style="max-width: 100px;"></a>
                            </div>
                        </div>
                    <div class="col-xl-8 col-lg-8">
                            <!-- main-menu -->
                            <div class="main-menu f-right d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">                                                                                                                                     
                                        <li><a href="../index.php">Home</a></li>
                                        <li><a href="about.php">About</a></li>
                                        <li><a href="rooms.php">Habitaciones</a></li>
                                        <li><a href="contact.php">Contacto</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>             
                        <div class="col-xl-2 col-lg-2">
                            <!-- header-btn -->
                            <div class="header-btn">
                                <a href="../index.php#reserva" class="btn btn1 d-none d-lg-block ">Reservar Ahora </a>
                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
        <!-- Header End -->
    </header>

    <!-- slider Area Start-->
    <div class="slider-area">
        <div class="single-slider hero-overly slider-height2 d-flex align-items-center" data-background="../assets/img/hero/contact_hero.jpg" >
            <div class="container">
                <div class="row ">
                    <div class="col-md-11 offset-xl-1 offset-lg-1 offset-md-1">
                        <div class="hero-caption">
                            <span>Contacto</span>
                            <h2>Contacto</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->

    <!-- ================ contact section start ================= -->
    <section class="contact-section">
            <div class="container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4209.741222272707!2d-15.433031223967136!3d28.14518770604353!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xc409538abd963db%3A0x5177e33862229b0a!2sC.%20Fuerteventura%2C%204-12%2C%2035008%20Las%20Palmas%20de%20Gran%20Canaria%2C%20Las%20Palmas!5e1!3m2!1ses!2ses!4v1777634251672!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <div class="row">
                    <div class="col-12">
                        <h2 class="contact-title">Contactanos</h2>
                    </div>
                    <div class="col-lg-8">
                        <form class="form-contact contact_form" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'" placeholder=" Introduce tu mensaje"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control valid" name="name" id="name" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" placeholder="Introduce tu nombre">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control valid" name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input class="form-control" name="subject" id="subject" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Subject'" placeholder="Introduce el tema">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="button button-contactForm boxed-btn">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    <!-- ================ contact section end ================= -->
    
        <footer>
        <!-- Footer Start-->
        <div class="footer-area black-bg footer-padding">
            <div class="container">
                <div class="row d-flex justify-content-between align-items-flex-start">
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="single-footer-caption mb-30" style="display: flex; gap: 30px; align-items: flex-start;">
                            <!-- logo -->
                            <div class="footer-logo" style="flex-shrink: 0;">
                            <a href="index.php"><img src="../assets/img/logo/logo.png" alt="" style="max-width: 150px;"></a>
                            <div class="footer-social footer-social2" style="margin-top: 15px; margin-bottom: 0;">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fas fa-globe"></i></a>
                                <a href="#"><i class="fab fa-behance"></i></a>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="single-footer-caption mb-30">
                            <div class="footer-tittle">
                                <h4>Reservas</h4>
                                <ul>
                                    <li><a href="#">Tel: +34 640 031 294</a></li>
                                    <li><a href="#">reservas@mihotel.com</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="single-footer-caption mb-30">
                            <div class="footer-tittle">
                                <h4>Ubicacion</h4>
                                <ul>
                                    <li><a href="#">Ciudad</a></li>
                                    <li><a href="#">C/ Imgainaria, 123</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="footer-pera" style="text-align: center;">
                            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="ti-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End-->
    </footer>
    <!-- JS here -->
	
		<!-- All JS Custom Plugins Link Here here -->
        <script src="./../assets/js/vendor/modernizr-3.5.0.min.js"></script>
		
		<!-- Jquery, Popper, Bootstrap -->
		<script src="./../assets/js/vendor/jquery-1.12.4.min.js"></script>
        <script src="./../assets/js/popper.min.js"></script>
        <script src="./../assets/js/bootstrap.min.js"></script>
	    <!-- Jquery Mobile Menu -->
        <script src="./../assets/js/jquery.slicknav.min.js"></script>

		<!-- Jquery Slick , Owl-Carousel Plugins -->
        <script src="./../assets/js/owl.carousel.min.js"></script>
        <script src="./../assets/js/slick.min.js"></script>
		<!-- Date Picker -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
		<!-- One Page, Animated-HeadLin -->
        <script src="./../assets/js/wow.min.js"></script>
		<script src="./../assets/js/animated.headline.js"></script>
		
		<!-- Scrollup, nice-select, sticky -->
        <script src="./../assets/js/jquery.scrollUp.min.js"></script>
        <script src="./../assets/js/jquery.nice-select.min.js"></script>
		<script src="./../assets/js/jquery.sticky.js"></script>
        <script src="./../assets/js/jquery.magnific-popup.js"></script>

        <!-- contact js -->
        <script src="./../assets/js/contact.js"></script>
        <script src="./../assets/js/jquery.form.js"></script>
        <script src="./../assets/js/jquery.validate.min.js"></script>
        <script src="./../assets/js/mail-script.js"></script>
        <script src="./../assets/js/jquery.ajaxchimp.min.js"></script>
        
		<!-- Jquery Plugins, main Jquery -->	
        <script src="./../assets/js/plugins.js"></script>
        <script src="./../assets/js/main.js"></script>
        

        <script>
        $('#datepicker').flatpickr = flatpickr('#datepicker', {
            dateFormat: 'd/m/Y',
            locale: 'es'
        });
        $('#datepicker2').flatpickr = flatpickr('#datepicker2', {
            dateFormat: 'd/m/Y',
            locale: 'es'
        });
        var timepicker = $('#timepicker').timepicker({
         format: 'HH.MM'
     });
        </script>
    </body>
    
    </html>