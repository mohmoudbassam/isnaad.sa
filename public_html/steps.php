<?php session_start();   $_SESSION['Active']=3;  
//unset($_SESSION['Membar']);
include("include/dataconnect.php");
$sql_Home="select * from home";
$r_Home=$link->query($sql_Home);
$row_Home=$r_Home->fetch_array(MYSQLI_ASSOC);

?>
<!doctype html>
<html lang="en" dir="rtl">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
                            
                            
                             <li class="nav-item active ">
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
        
          <section class="service_area sec_pad">
            <div class="container custom_container p0">
                <div class="sec_title text-center">
                    <h2 class="f_p f_size_30 l_height50 f_700 t_color">المسار التشغيلي</h2>
                    
                </div>
                <div class="row service_info mt_70 mb_30">
                
                
                 <?php 
             $i=1;						
			 $q_Prod="select * from project Where Sho='2' and F_Category='1' order by idProject DESC ";
             $r_Prod=$link->query($q_Prod);
             $r_Prod=$r_Prod->fetch_array(MYSQLI_ASSOC);
            
					 while($row_Prod=@mysqli_fetch_array($r_Prod))
						  {
                            
							$Project=$row_Prod['idProject'];
							$q_img="select * from project_image where F_Project= '$Project'";
							$r_img=$link->query($q_img);
							$row_img=@mysql_fetch_array($r_img);
							
						
						echo'<div class="col-lg-4 col-sm-6 mb-30">
							<div class="service_item">
								<center><img style="width:140px; height: auto;" src="image/Project/'.$row_img['Link'].'" alt=""></center>
								<h4 class="f_500 f_size_20 l_height28 t_color mb_20" style="text-align:center;">'.$row_Prod['Name'].'</h4>
								<p>'.$row_Prod['Info'].'</p>
								 <center><img style="width:140px; height: auto;"  src="img/n'.$i.'.png" alt=""></center>
								 <br>
	
							</div>
						</div>';
						$i++;
					  }
					  ?>
                  
                  
                    
                    
                    
                </div>
            </div>
        </section>
        
        

        
        
        <section class="app_screenshot_area sec_pad" style="background:#dc4029;">
            <div class="container custom_container p0">
                <div class="sec_title text-center">
                    <h2 class="f_p f_size_30 l_height50 f_700 " style="color:#FFFFFF;"> فوق البيعة </h2>
                    
                </div>
                <div class="row service_info mt_70 mb_30">
                
                 <?php 
           						
			 $q_Prod="select * from project Where Sho='2' and F_Category='2' order by idProject  ";
             $r_Prod=$link->query($q_Prod);
                  
					 while($row_Prod=@mysqli_fetch_array($r_Prod))
						  {
							  
							$Project=$row_Prod['idProject'];
							$q_img="select * from project_image where F_Project= '$Project'";
							$r_img=$link->query($q_img);
							$row_img=@mysqli_fetch_array($r_img);
						
						   echo' <div class="col-lg-4 col-sm-6 mb-30">
								<div class="service_item">
									<center><img style="width:160px; height: auto;" src="image/Project/'.$row_img['Link'].'" alt=""></center>
									<h4 class="f_500 f_size_20 l_height28 t_color mb_20" style="text-align:center;">'.$row_Prod['Name'].'</h4>
									<p>'.$row_Prod['Info'].'</p>
									 
									 
		
								</div>
							</div>';
							
						  }
						  ?>
                    
               
                    
                    
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