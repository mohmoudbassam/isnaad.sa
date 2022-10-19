<?php session_start();  $_SESSION['Active']=2;
include("include/dataconnect.php");

$sql_Home="select * from home";
$r_Home=$link->query($sql_Home);
$row_Home=$r_Home->fetch_array(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en" dir="rtl">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
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
                <p class="text-center">Loading</p>
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
                    <a class="navbar-brand" href="#"><img style="width:120px; height:auto;" src="img/logo11.png" srcset="img/logo11.png 2x" alt="logo"></a>
                  
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
                           
                           
                            <li class="nav-item active">
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
        
      
      
<br/>
    <br/>    
    <br/>    
          <section class="app_featured_area" style="padding: 0px; ">
        <div class="container">
        
         <div class="row h_analytices_features_item flex-row-reverse">
                  
                  
                    <div class="col-lg-12">
                        <div class="app_featured_content">
                            <h2 class="f_p f_size_20 f_700 t_color3 l_height45 pr_70 mb-30"> إسناد, من هو ؟   </h2>
                           

                            <p class="f_400">
                            
                         <?php echo $row_Home['About_as']; ?>
                            </p>
                           
                             
                        </div>
                        
                        </div>
                        
                        
                         <div class="col-lg-6">
                         <div class="h_features_img">
                            <img src="img/Artboard6.png" alt="">
                        </div>
                    </div>
                        
                       <div class="col-lg-6">
                        
                           <div class="media h_features_item">
                               
                                <div class="media-body">
                                    <h4 class="h_head" style="color:#dc4029;">الرؤية</h4>
                                    <p style="text-align:justify;">
                                    <?php echo $row_Home['Ourthinking']; ?> 
                                    
                                    </p>
                                </div>
                            </div>
                            <div class="media h_features_item">
                               
                                <div class="media-body">
                                    <h4 class="h_head" style="color:#dc4029;">الرسالة</h4>
                                    <p>
                                         <?php echo $row_Home['Ourgrowth']; ?>
                                    </p>
                                </div>
                            </div>
                            
                            
                             <div class="media h_features_item">
                               
                                <div class="media-body">
                                    <h4 class="h_head" style="color:#dc4029;"> الطموح </h4>
                                    <p>
                                     <?php echo $row_Home['Ourfocus']; ?>
                                    </p>
                                </div>
                            </div>
                            
                       
                            
                            
                    </div>
                    
                    
                    
                    
                    
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
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
</body>

</html>