<?php session_start();   $_SESSION['Active']=7;
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
          
        
            <p class="text-center">جاري التحميل </p>
       


           
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





                        <li class="nav-item  ">
                            <a class="nav-link" href="contact.php" role="button"  aria-haspopup="true" aria-expanded="false">
                             تواصل معنا 
                            </a>

                        </li>
                            <li class="nav-item active ">
                                <a class="nav-link" href="contact.php" role="button"  aria-haspopup="true" aria-expanded="false">
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
                    <h2 style="margin-top:120px;"  class="f_p f_700 f_size_50  l_height50 mb_20 t_color  wow fadeInUp" data-wow-delay="0.3s" > إبدأ معنا لتوفير وقتك وجهدك </h2>
                    <br>
                    <h3>مع إسناد لا تشيل هم وخلها علينا وركز كيف تزيد طلباتك لأن إسناد دائما  ...#سند لك </h3>

                </div>
            </div>

            <div class="col-lg-6 col-sm-6" style="float:left; text-align:left;">
                <img class="  wow fadeInUp" data-wow-delay="0.3s" style="width:320px; height: auto;" src="img/join_us.png" alt="">
            </div>

        </div>
    </section>








    <section class="contact_info_area sec_pad bg_color">

        <div class="contact_form" style="text-align:right; direction:rtl;">
            <h2 class="f_p f_size_22 t_color3 f_600 l_height28 mt_100 mb_40">نآمل تعبئة البيانات ادناه وسيتم التواصل معكم في اقرب وقت ..</h2>
            <form action="join_pr.php" class="contact_form_box" method="post" id="joinus" novalidate>
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
                    <div class="col-lg-6">
                        <div class="form-group text_box">
                            <input type="text" id="phone" name="phone" placeholder="رقم الجوال">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group text_box">
                            <input type="text" id="comName" name="comName" placeholder="اسم الشركة">
                        </div>
                    </div>
                     <div class="col-lg-12">
                        <div class="form-group text_box">
                            <input type="text" id="store_url" name="store_url" placeholder="رابط المتجر الالكتروني">
                        </div>
                    </div>
                                <div class="col-lg-6">
                      <div class="form-group">
  <label for="with">عدد الطلبات  الاسبوعية ( مع وجود حملة إعلانية)</label>
  <select class="form-control" name="with" id="with">
     <option value=''>اختيار</option>
    <option value='1'>0-50</option>
    <option value='2'>50-100</option>
    <option value='3'>100-200</option>
    <option value='4'>200-500</option>
    <option value='5'>500-1000</option>
  </select>
</div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
  <label for="without">عدد الطلبات  الاسبوعية (من دون  وجود حملة إعلانية)</label>
  <select class="form-control" name="without" id="without">
    <option value=''>اختيار</option>
    <option value='1'>0-50</option>
    <option value='2'>50-100</option>
    <option value='3'>100-200</option>
    <option value='4'>200-500</option>
    <option value='5'>500-1000</option>
  </select>
</div>
                    </div>

                                <div class="col-lg-6" dir="ltr">
                      <div class="form-group">
  <label for="sel1"> المنصة المستخدمة في المتجر الإلكتروني </label>
  <select class="form-control" name='mnsa' id="mnsa">
   <option value=''>اختيار</option>
   <option value='zid'>zid</option>
<option value='shopify'>shopify</option>
<option value='sala'>salla</option>
<option value='Magento'>Magento</option>
<option value='other'>other</option>
  </select>
</div>
                    </div>
                      <div class="col-lg-12" style="display: none;" id="mnsaNameDiv">
                        <div class="form-group text_box">
                            <input type="text" id="mnsaName" name="mnsaName" placeholder="اسم المنصة">
                        </div>
                    </div>
                    
                    
                    <div class="col-lg-12">
                     <label for="message">(اختياري)</label>
                        <div class="form-group text_box">
                            <textarea name="message" id="message" cols="30" rows="10" placeholder="تقدم برسالتك هنا ..."></textarea>
                        </div>
                    </div>
          
                </div>
                <button type="submit" class="btn_three">إرسال</button>
            </form>
            <?php if(isset($_SESSION['ok'])){ ?>
            <div class="alert alert-success" role="alert">
 لقد تم إرسال رسالتك بنجاح , سوف يتم التواصل معك
</div>
            
            <?php  unset($_SESSION['ok']); }?>

                 <?php if(isset($_SESSION['no'])){ ?>
            <div class="alert alert-danger" role="alert">
            الرجاء ادخال اسم المنصة 
</div>
            
            <?php  unset($_SESSION['no']); }?>
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
<script>
    $('#joinus').validate({
        rules:{
            name:{
                required:true,
                    minlength: 4
            },
            email:{
                required:true,
                email:true
            },
            without:{
                 required:true,
            },
            with:{
                  required:true,
            },
            phone:{
                 required:true,
                minlength: 10,
                maxlength:10,
                 number:true
            },
            comName:{
                 required:true,
            },
            store_url:{
                  required:true,
            },
            mnsaName:{
                required:true,
                ignore:":not(:visible)"
            },
  mnsa:{
           required:true,
               
  }
            
           
          
        }
    });
    $('#mnsa').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
   
    if(valueSelected=='other'){
       $('#mnsaNameDiv').show(); 
    }else{
         $('#mnsaNameDiv').hide(); 
    }

});
</script>
</body>

</html>
