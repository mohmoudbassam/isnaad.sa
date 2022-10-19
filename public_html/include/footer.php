<?php

$counter_name = "counter.txt";
// Check if a text file exists. If not create one and initialize it to zero.
//die(!file_exists($counter_name));
if (!file_exists($counter_name)) {
  $f = fopen($counter_name, "w");
  fwrite($f,"1");
  fclose($f);
}
// Read the current value of our counter file
$f = fopen($counter_name,"r");
$counterVal = fread($f, 1);
fclose($f);
// Has visitor been counted in this session?
// If not, increase counter value by one
if(!isset($_SESSION['hasVisited'])){
  $_SESSION['hasVisited']="yes";
  $counterVal++;
  $f = fopen($counter_name, "w");
  fwrite($f, $counterVal);
  fclose($f); 
}

?>
        
        
           <footer class="footer_area footer_area_four f_bg">
            <div class="footer_top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-4">
                            <div class="f_widget company_widget">
                                <a href="index.html" class="f-logo"><img style="width: 150px; height: auto;" src="img/logo11.png" srcset="img/logo11.png 2x" alt=""></a>
                                
                              
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="f_widget about-widget pl_40">
                                <h3 class="f-title f_600 t_color f_size_18 mb_40">للتواصل</h3>
                                <ul class="list-unstyled f_list">
                                    <li> <a href="mailto:<?php  echo $row_Home['Email'];?>" class="f_400"> <?php  echo $row_Home['Email'];?> </a></li>
                                    <li> <a href="tel:<?php  echo $row_Home['Phone'];?>" class="f_400"> <?php  echo $row_Home['Phone'];?> </a></li>
                                     <li> <a href="https://wa.me/message/QAY4TRJWYYZ6C1" class="f_400"><img style="width: auto; height: auto;" src="img/icons8-whatsapp-96.png" srcset="img/icons8-whatsapp-96.png 2x" alt=""></a></li>
                                  
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="f_widget about-widget">
                                <h3 class="f-title f_600 t_color f_size_18 mb_40">خريطة الموقع</h3>
                                <ul class="list-unstyled f_list">
                                    <li><a href="about.php"> من نحن ؟	 </a></li>
                                    <li><a href="steps.php">كيف نعمل ؟</a></li>
                                    <li><a href="promise.php">وعدنا</a></li>
                                    <li><a href="feature.php">ميزة</a></li>
                                    <li><a href="contact.php">انضم و تواصل</a></li>
                                </ul>
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>
            <div class="footer_bottom">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-md-5 col-sm-6">
                            <p class="mb-0 f_400">جميع الحقوق محفوظة © 2020 </p>
                        </div>
                        <div class="col-lg-4 col-md-3 col-sm-6">
                            <div class="f_social_icon_two text-center">
                                <a target="_blank" href="<?php  echo $row_Home['Facebook'];?> "><i class="ti-facebook"></i></a>
                                <a target="_blank" href="<?php  echo $row_Home['Twitter'];?> "><i class="ti-twitter-alt"></i></a>
                                <a target="_blank" href="<?php  echo $row_Home['Instagram'];?> "><i class="ti-instagram"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <ul class="list-unstyled f_menu text-right">
                                <li><a href="#">الشروط و الأحكام</a></li>
                                <li><a href="#">الخصوصية</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>