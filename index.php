<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Hotel</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="manifest" href="site.webmanifest">
		<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

		<!-- CSS here -->
            <link rel="stylesheet" href="assets/css/bootstrap.min.css">
            <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
            <link rel="stylesheet" href="assets/css/slicknav.css">
            <link rel="stylesheet" href="assets/css/animate.min.css">
            <link rel="stylesheet" href="assets/css/magnific-popup.css">
            <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
            <link rel="stylesheet" href="assets/css/themify-icons.css">
            <link rel="stylesheet" href="assets/css/slick.css">
            <link rel="stylesheet" href="assets/css/nice-select.css">
            <link rel="stylesheet" href="assets/css/style.css">
            <link rel="stylesheet" href="assets/css/responsive.css">
   </head>

   <body>
       
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <strong>MiHotel</b>
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
                               <a href="index.php"><img src="assets/img/logo/logo.png" alt="" style="max-width: 100px;"></a>
                            </div>
                        </div>
                    <div class="col-xl-8 col-lg-8">
                            <!-- main-menu -->
                            <div class="main-menu f-right d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">                                                                                                                                     
                                        <li><a href="index.php">Home</a></li>
                                        <li><a href="html/about.php">About</a></li>
                                        <li><a href="html/rooms.php">Habitaciones</a></li>
                                        <li><a href="html/contact.php">Contacto</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>             
                        <div class="col-xl-2 col-lg-2">
                            <!-- header-btn -->
                            <div class="header-btn">
                                <a href="#reserva" class="btn btn1 d-none d-lg-block ">Reservar Ahora </a>
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
    <main>

        <!-- slider Area Start-->
        <div class="slider-area ">
            <!-- Mobile Menu -->
                <div class="single-slider  hero-overly slider-height d-flex align-items-center" data-background="assets/img/hero/h1_hero.jpg" >
                    <div class="container" id="reserva">
                        <div class="row justify-content-center text-center">
                            <div class="col-xl-9">
                                <div class="h1-slider-caption">
                                    <h1 data-animation="fadeInUp" data-delay=".4s">disfruta de tu estancia</h1>
                                    <h3 data-animation="fadeInDown" data-delay=".4s">MiHotel & Resourt</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <!-- slider Area End-->

        <!-- Booking Room Start-->
        <div class="booking-area">
            <div class="container">
               <div class="row ">
               <div class="col-12">
                <form action="html/login.php" method="post" id="booking-form">
                <div class="booking-wrap d-flex justify-content-between align-items-center">
                 
                    <!-- select in date -->
                    <div class="single-select-box mb-30">
                        <!-- select out date -->
                        <div class="boking-tittle">
                            <span> Check In:</span>
                        </div>
                        <div class="boking-datepicker">
                            <input id="datepicker1" type="text" name="checkin" placeholder="dd/mm/yyyy" autocomplete="off" class="form-control" required />
                        </div>
                   </div>
                    <!-- Single Select Box -->
                    <div class="single-select-box mb-30">
                        <!-- select out date -->
                        <div class="boking-tittle">
                            <span>Check Out:</span>
                        </div>
                        <div class="boking-datepicker">
                            <input id="datepicker2" type="text" name="checkout" placeholder="dd/mm/yyyy" autocomplete="off" class="form-control" required />
                        </div>
                   </div>
                    <!-- Single Select Box -->
                    <?php
                        $max_personas = 4;
                    ?>
                    <div class="single-select-box mb-30">
                        <div class="boking-tittle">
                            <span>Adultos:</span>
                        </div>
                        <div class="select-this">
                            <div class="select-itms">
                                <select name="adults" id="select1">
                                    <?php
                                        for ($i = 1; $i <= $max_personas; $i++) {
                                            echo "<option value='$i'>$i</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Single Select Box -->
                    <div class="single-select-box mb-30">
                        <div class="boking-tittle">
                            <span>Niños:</span>
                        </div>
                        <div class="select-this">
                            <div class="select-itms">
                                <select name="children" id="select2">
                                    <?php
                                        for ($x = 0; $x <= $max_personas; $x++) {
                                            echo "<option value='$x'>$x</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                        <!-- Single Select Box -->
                    <div class="single-select-box pt-45 mb-30">
                        <button type="submit" class="btn select-btn">Reservar</button>
                   </div>
                </div>
                <div id="booking-error" style="color: #ff4c4c; margin-top: 10px; display: none;"></div>
            </form>
               </div>
               </div>
            </div>
        </div>
        <!-- Booking Room End-->
        <!-- Make customer Start-->
        <section class="make-customer-area customar-padding fix">
            <div class="container-fluid p-0">
                <div class="row">
                   <div class="col-xl-5 col-lg-6">
                        <div class="customer-img mb-120">
                            <img src="assets/img/customer/customar1.png" class="customar-img1" alt="">
                            <img src="assets/img/customer/customar2.png" class="customar-img2" alt="">
                            <div class="service-experience heartbeat">
                                <h3>25 Años de Servicio<br>Experiencia</h3>
                            </div>
                        </div>
                   </div>
                    <div class=" col-xl-4 col-lg-4">
                        <div class="customer-caption">
                            <span>Nosotros</span>
                            <h2>Hazemos de tu estancia una experiencia</h2>
                            <div class="caption-details">
                                <p class="pera-dtails">Nuestra prioridad absoluta es que su estancia con nosotros sea totalmente acogedora y placentera. </p>
                                <p>Cuidamos cada detalle para ofrecerte una experiencia única desde el primer momento. Nuestro equipo trabaja con dedicación para crear un ambiente cálido y armonioso, donde cada elemento está pensado para tu confort. Gracias a esta atención al detalle, conseguimos que cada estancia sea acogedora, relajante y te haga sentir como en casa </p>
                                <a href="html/about.php" class="btn more-btn1">Conoce más nuestro hotel <i class="ti-angle-right"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Make customer End-->
   <footer>
       <!-- Footer Start-->
       <div class="footer-area black-bg footer-padding">
           <div class="container">
               <div class="row d-flex justify-content-between align-items-flex-start">
                   <div class="col-xl-4 col-lg-4 col-md-6">
                      <div class="single-footer-caption mb-30" style="display: flex; gap: 30px; align-items: flex-start;">
                         <!-- logo -->
                         <div class="footer-logo" style="flex-shrink: 0;">
                           <a href="index.php"><img src="assets/img/logo/logo.png" alt="" style="max-width: 150px;"></a>
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
        <script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
		
		<!-- Jquery, Popper, Bootstrap -->
		<script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>
	    <!-- Jquery Mobile Menu -->
        <script src="./assets/js/jquery.slicknav.min.js"></script>

		<!-- Jquery Slick , Owl-Carousel Plugins -->
        <script src="./assets/js/owl.carousel.min.js"></script>
        <script src="./assets/js/slick.min.js"></script>
        <!-- Date Picker -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
		<!-- One Page, Animated-HeadLin -->
        <script src="./assets/js/wow.min.js"></script>
		<script src="./assets/js/animated.headline.js"></script>
        <script src="./assets/js/jquery.magnific-popup.js"></script>

		<!-- Scrollup, nice-select, sticky -->
        <script src="./assets/js/jquery.scrollUp.min.js"></script>
        <script src="./assets/js/jquery.nice-select.min.js"></script>
		<script src="./assets/js/jquery.sticky.js"></script>
        
        <!-- contact js -->
        <script src="./assets/js/contact.js"></script>
        <script src="./assets/js/jquery.form.js"></script>
        <script src="./assets/js/jquery.validate.min.js"></script>
        <script src="./assets/js/mail-script.js"></script>
        <script src="./assets/js/jquery.ajaxchimp.min.js"></script>
        
		<!-- Jquery Plugins, main Jquery -->	
        <script src="./assets/js/plugins.js"></script>
        <script src="./assets/js/main.js"></script>
        <script>
            const MAX_PERSONAS = 4;
            const select1 = document.getElementById('select1');
            const select2 = document.getElementById('select2');
            const bookingForm = document.getElementById('booking-form');
            const bookingError = document.getElementById('booking-error');
            const checkinInput = document.getElementById('datepicker1');
            const checkoutInput = document.getElementById('datepicker2');
            let checkoutPicker;

            if (window.flatpickr) {
                flatpickr.localize(flatpickr.l10ns.es);

                flatpickr(checkinInput, {
                    dateFormat: 'd/m/Y',
                    locale: 'es',
                    minDate: 'today',
                    allowInput: true,
                    onChange(selectedDates) {
                        if (selectedDates.length > 0 && checkoutPicker) {
                            checkoutPicker.set('minDate', selectedDates[0]);
                        }
                    }
                });

                checkoutPicker = flatpickr(checkoutInput, {
                    dateFormat: 'd/m/Y',
                    locale: 'es',
                    minDate: 'today',
                    allowInput: true,
                });
            }

            function updateChildrenOptions() {
                const adultos = parseInt(select1.value, 10);
                const ninosMaximo = MAX_PERSONAS - adultos;
                for (let i = 0; i < select2.options.length; i++) {
                    const valor = parseInt(select2.options[i].value, 10);
                    select2.options[i].disabled = valor > ninosMaximo;
                }
                if (parseInt(select2.value, 10) > ninosMaximo) {
                    select2.value = ninosMaximo;
                }
            }

            select1.addEventListener('change', function() {
                updateChildrenOptions();
            });

            bookingForm.addEventListener('submit', function(event) {
                const adultos = parseInt(select1.value, 10);
                const ninos = parseInt(select2.value, 10);
                const total = adultos + ninos;
                if (total > MAX_PERSONAS) {
                    event.preventDefault();
                    bookingError.textContent = 'El número de personas tiene que ser 4 o menor';
                    bookingError.style.display = 'block';
                } else {
                    bookingError.style.display = 'none';
                }
            });

            updateChildrenOptions();
        </script>
    </body>
</html>