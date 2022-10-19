<?php session_start();   $_SESSION['Active']=1;  
unset($_SESSION['categ']);
//unset($_SESSION['Membar']);
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
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <title><?php echo $row_Home['Title']; ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/bootstrap-selector/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="css/bootstrap-reboot.min.css">
    <!--icon font css-->
    <link rel="stylesheet" href="vendors/themify-icon/themify-icons.css">
    <link rel="stylesheet" href="vendors/elagent/style.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/all.css">
    <link rel="stylesheet" href="vendors/flaticon/flaticon.css">
    <link rel="stylesheet" href="vendors/animation/animate.css">
    <link rel="stylesheet" href="vendors/owl-carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="vendors/magnify-pop/magnific-popup.css">
    <link rel="stylesheet" href="vendors/nice-select/nice-select.css">
    <link rel="stylesheet" href="vendors/scroll/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/rtl.css">
</head>

<body>
    <div class="body_wrapper">
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
        
            
            <header class="header_area header_area_three">
            <nav class="navbar navbar-expand-lg menu_one">
            
                <div class="container">
                    <a class="navbar-brand sticky_logo" href="#">
                    <img style="width:120px; height:auto;" src="image/Logo/<?php echo $row_Home['Logo']; ?>" srcset="image/Logo/<?php echo $row_Home['Logo']; ?> 2x" alt="logo">
                    <img style="width:120px; height:auto;" src="image/Logo/<?php echo $row_Home['Logo']; ?>" srcset="image/Logo/<?php echo $row_Home['Logo']; ?> 2x" alt=""></a>
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
                        
                           <li class="nav-item  active">
                                <a class="nav-link" href="index.php" role="button"  aria-haspopup="true" aria-expanded="false">
                                   الرئيسية
                                </a>
                           </li>
                           
                           
                            <li class="nav-item ">
                                <a class="nav-link" href="about.php" role="button"  aria-haspopup="true" aria-expanded="false">
                                  من نحن ؟
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
                                <a class="nav-link" href="feature.html" role="button"  aria-haspopup="true" aria-expanded="false">
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
                            

                           
                            
                            
                            <li class="nav-item ">
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
        <section class="app_banner_area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="app_banner_contentmt" style="margin-top:90px;">
                            <a href="#services" class="btn_hover mt_30 app_btn wow fadeInLeft" data-wow-delay="0.5s"> خدماتنا </a>
                            <a href="about.php" class="btn_hover mt_30 app_btn wow fadeInLeft" data-wow-delay="0.5s"> من نحن </a>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="app_img">
                           
                            <img class="mobile" src="img/Artboard1.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        
        
           <section class="app_testimonial_area " style="padding-top:10px;" id="services">
            <div class="container">
                <div class="sec_title text-center mb_70">
                    <h2 class="f_p f_size_30 l_height30 f_700 t_color3 mb_20 wow fadeInUp"> خدماتنا </h2>
                </div>
                
                <div class="row app_service_info">
                
                   
			 <?php 
    
                $sql_Ser="select * from service Where  Sho='2' ";
                    
					 $r_Ser=$link->query($sql_Ser);
                     $r_Ser=$r_Ser->fetch_array(MYSQLI_ASSOC);
                     while($Ser=@mysqli_fetch_array($r_Ser))
                     {     
                    echo'<div class="col-lg-3">
                        <div class="app_service_item wow fadeInUp" data-wow-delay="0.2s">
                            <center><img style="width:150px; height:auto;" class="text_bg one wow fadeInLeft" data-wow-delay="0.1s" src="image/Services/'.$Ser['Image'].'" alt=""></center>
                            <h5 class="f_p f_size_15 f_600 t_color3 mt_30 mb-30" style="text-align:center;"> '.$Ser['Name'].' </h5>
                            <p class="f_400 f_size_15 mb-30" style="text-align:justify; direction:rtl;">
                              '.$Ser['Info'].'
                            </p>
                            <br>
                            <a href="#" class="learn_btn_two"> اقرأ المزيد <i class="ti-arrow-left"></i></a>
                        </div>
                    </div>';
					 }
					 ?>
                    
                    
                  
                    
                   
                    
                </div>
                
                
                
                
            </div>
           
                
        </section>
        
  
  
  
 <?php  include("include/footer.php"); ?>
      
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/propper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="vendors/bootstrap-selector/js/bootstrap-select.min.js"></script>
    <script src="vendors/wow/wow.min.js"></script>
    <script src="vendors/sckroller/jquery.parallax-scroll.js"></script>
    <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="vendors/nice-select/jquery.nice-select.min.js"></script>
    <script src="vendors/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="vendors/isotope/isotope-min.js"></script>
    <script src="vendors/magnify-pop/jquery.magnific-popup.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="vendors/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>