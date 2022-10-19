<?php session_start();   $_SESSION['Active']=6;  
include("include/dataconnect.php");
$sql_Home="select * from home";
$r_Home=$link->query($sql_Home);
$row_Home=$r_Home->fetch_array(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en" dir="rtl">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="<?php echo $row_Home['Title']; ?>" />
    <meta name="description" content="<?php echo $row_Home['Title']; ?>">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <title><?php echo $row_Home['Title']; ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/bootstrap-selector/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="css/bootstrap-reboot.min.css">
    <!--icon font css-->
    <link rel="stylesheet" href="vendors/themify-icon/themify-icons.css">
    <link rel="stylesheet" href="vendors/elagent/style.css">
    <link rel="stylesheet" href="vendors/flaticon/flaticon.css">
    <link rel="stylesheet" href="vendors/animation/animate.css">
    <link rel="stylesheet" href="vendors/owl-carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="vendors/nice-select/nice-select.css">
    <link rel="stylesheet" href="vendors/magnify-pop/magnific-popup.css">
    <link rel="stylesheet" href="vendors/scroll/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/rtl.css">
</head>

<body>
    <div id="preloader">
        <div id="ctn-preloader" class="ctn-preloader">
            <div class="animation-preloader">
                <div class="spinner"></div>
                 <div class="txt-loading">
                    <span data-text-preloader="I" class="letters-loading">
                        I
                    </span>
                    <span data-text-preloader="S" class="letters-loading">
                        S
                    </span>
                    <span data-text-preloader="N" class="letters-loading">
                        N
                    </span>
                    <span data-text-preloader="A" class="letters-loading">
                        A
                    </span>
                    <span data-text-preloader="A" class="letters-loading">
                        A
                    </span>
                    <span data-text-preloader="D" class="letters-loading">
                        D
                    </span>
                
                </div>
                <p class="text-center">جاري التحميل</p>
            </div>
            <div class="loader">
                <div class="row">
                    <div class="col-3 loader-section section-left">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-left">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-right">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-right">
                        <div class="bg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="body_wrapper">
       <header class="header_area header_area_three">
            <nav class="navbar navbar-expand-lg menu_one">
                <div class="container custom_container p0">
                    <a class="navbar-brand" href="#"><img style="width:120px; height:auto;" src="image/Logo/<?php echo $row_Home['Logo']; ?>" srcset="image/Logo/<?php echo $row_Home['Logo']; ?> 2x" alt="logo"></a>
                    
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="menu_toggle">
                            <span class="hamburger">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                            <span class="hamburger-cross">
                                <span></span>
                                <span></span>
                            </span>
                        </span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                               <ul class="navbar-nav ml-auto menu">
                        
                           <li class="nav-item  ">
                                <a class="nav-link" href="index.php" role="button"  aria-haspopup="true" aria-expanded="false">
                                   الرئيسية
                                </a>
                           </li>
                           
                           
                            <li class="nav-item ">
                                <a class="nav-link" href="about.php" role="button"  aria-haspopup="true" aria-expanded="false">
                                    من نحن
                                </a>
                            </li>
                            
                            
                             <li class="nav-item ">
                                <a class="nav-link" href="steps.php" role="button"  aria-haspopup="true" aria-expanded="false">
                                    كيف نعمل ؟
                                </a>
                            </li>
                            
                            
                            <li class="nav-item ">
                                <a class="nav-link" href="promise.php" role="button"  aria-haspopup="true" aria-expanded="false">
                                    وعدنا
                                </a>
                            </li>
                            
                            
                     
                            
                            
                             <li class="nav-item ">
                                <a class="nav-link" href="feature.php" role="button"  aria-haspopup="true" aria-expanded="false">
                                    ميزة
                                </a>
                            </li>
                            
                            
                          <!-- <li class="nav-item dropdown submenu">
                                 <a class="nav-link" href="feature.html" role="button"  aria-haspopup="true" aria-expanded="false">
                                    الخدمات
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item"><a href="service.html" class="nav-link">عنوان الخدمة</a></li>
                                    <li class="nav-item"><a href="service.html" class="nav-link">عنوان الخدمة</a></li>
                                    <li class="nav-item"><a href="service.html" class="nav-link">عنوان الخدمة</a></li>
                                    <li class="nav-item"><a href="service.html" class="nav-link">عنوان الخدمة</a></li>

                                </ul>
                            </li>-->
                            

                           
                            
                            
                            <li class="nav-item active ">
                                <a class="nav-link" href="contact.php" role="button"  aria-haspopup="true" aria-expanded="false">
تواصل معنا
                                </a>
                           
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="joinus.php" role="button"  aria-haspopup="true" aria-expanded="false">
                                   إبدأ معنا
                                </a>
                           
                            </li>
                            
                             <li class="nav-item ">
                                <a class="nav-link" href="" role="button"  aria-haspopup="true" aria-expanded="false">
                                   EN
                                </a>
                           
                            </li>
                                
                        </ul>
                    </div>
                 
                </div>
            </nav>
        </header>
        
        


         <section class="breadcrumb_area" style="margin-top:20px;">
           <!-- <img class="breadcrumb_shap" src="img/breadcrumb/banner_bg.png" alt="">-->
            <div class="container">
            <div class="col-lg-6 col-sm-6" style="float:right; text-align:right;">
             <div class="breadcrumb_content ">
                <h1 style="margin-top:120px;"  class="f_p f_700 f_size_50  l_height50 mb_20 t_color  wow fadeInUp" data-wow-delay="0.3s" >تواصل معنا</h1>
                  
                </div>
            </div>
            
             <div class="col-lg-6 col-sm-6" style="float:left; text-align:left;">
              <img class="  wow fadeInUp" data-wow-delay="0.3s" style="width:320px; height: auto;" src="img/Artboard19.png" alt="">
            </div>
            
            
               
            </div>
        </section>
               
        
        

        
        
        

        <section class="contact_info_area sec_pad bg_color">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 pr-0" style="text-align:right;">
                        <div class="contact_info_item" >
                            <h6 class="f_p f_size_20 t_color3 f_500 mb_20">العنوان</h6>
                            <p class="f_400 f_size_15"><?php echo $row_Home['Address']; ?> </p>
                        </div>
                        <div class="contact_info_item">
                            <h6 class="f_p f_size_20 t_color3 f_500 mb_20">معلومات التواصل</h6>
                            <p class="f_400 f_size_15"><span class="f_400 t_color3"> هاتف :</span> <a href="tel:<?php echo $row_Home['Phone']; ?>"><?php echo $row_Home['Phone']; ?></a></p>
                            <p class="f_400 f_size_15"><span class="f_400 t_color3"> فاكس :</span> <a href="tel:3024437488"><?php echo $row_Home['Fax']; ?></a></p>
                            <p class="f_400 f_size_15"><span class="f_400 t_color3"> البريد الإلكتروني :</span> <a href="mailto:<?php echo $row_Home['Email']; ?>">info@isnaad.sa</a></p>
                        </div>
                    </div>
                    <div class="col-lg-8 offset-lg-1">
                        <div class="mapbox">
                           <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14504.53261085816!2d46.660878950000004!3d24.6535447!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2ssa!4v1577608809018!5m2!1sen!2ssa"  frameborder="0" style="border:0; width:100%; height:380px;" allowfullscreen=""></iframe>
                        </div>
                    </div>
                </div>
                <div class="contact_form" style="text-align:right; direction:rtl;">
                    <h2 class="f_p f_size_22 t_color3 f_600 l_height28 mt_100 mb_40">للإستفسارات و الشكاوي</h2>
                    <form action="contact_process.php" class="contact_form_box" method="post" id="contactForm" novalidate>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group text_box">
                                    <input type="text" id="name" name="name" placeholder="الإسم الكامل">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group text_box">
                                    <input type="text" name="email" id="email" placeholder="البريد الإلكتروني">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group text_box">
                                    <input type="text" id="subject" name="subject" placeholder="العنوان">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group text_box">
                                    <textarea name="message" id="message" cols="30" rows="10" placeholder="تقدم برسالتك هنا ..."></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn_three">إرسال</button>
                    </form>
                    <div id="success"> لقد تم إرسال رسالتك بنجاح , سوف يتم التواصل معك </div>
                    <div id="error"> فشل إرسال الرسالة , يرجى المحاولة مرة أخرى </div>
                </div>
            </div>
        </section>

 <?php include("include/footer.php"); ?>



    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/propper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="vendors/wow/wow.min.js"></script>
    <script src="vendors/sckroller/jquery.parallax-scroll.js"></script>
    <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="vendors/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="vendors/isotope/isotope-min.js"></script>
    <script src="vendors/magnify-pop/jquery.magnific-popup.min.js"></script>
    <script src="vendors/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
    <!--gmaps Js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB13ZAvCezMx5TETYIiGlzVIq65Mc2FG5g"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/plugins.js"></script>
    <!-- contact js -->
    <script src="js/jquery.form.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/contact.js"></script>
    <script src="js/main.js"></script>
</body>

</html>