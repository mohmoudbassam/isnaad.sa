<?php
		 
  
  
  
  echo '
  
    <!-- menu prile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="images/img.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>أهلا بك </span>
                            <h2>'.$_SESSION['Name'].'</h2>
                            <br>
 							<br>

                        </div>
                    </div>
                    <!-- /menu prile quick info -->

                    <br />
    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <h3>صفحات المدير</h3>
                            <ul class="nav side-menu">
                                <li><a href="About.php"><i class="fa fa-home"></i> معلومات الموقع</a> </li>
                                <li><a href="Logo.php"><i class="fa fa-flag-o"></i> شعار الشركة </a> </li>
                                <li><a href="Services.php"><i class="fa fa-desktop"></i> خدماتنا </a> </li>
							
								
                           
                                
                                
                             
                                
                                
                                
                               <li><a><i class="fa fa-building-o"></i>  أقسام الموقع <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">';
                                       
							  $sql_sec="select * from projsection";
                                 $result_sec=mysql_query($sql_sec,$link);
								    while($Sec=@mysql_fetch_array($result_sec))
                               {
                                    echo'<li><a href="PCatg.php?id='.$Sec['idProjsection'].'">'.$Sec['Name'].'</a>
                                        </li>';
							   }
                                       
									   
                               echo'    <li style="background:#16b6b6; "><a  href="Project_Section.php">تعديل وإضافة أقسام </a>
                                        </li>
                                  
                                    </ul>
                                </li>
                                
                                 
                                
                                
                       
							  
                              <!-- <li><a href="Members.php"><i  class="fa fa-user"></i>الأعضاء</a> </li>-->
                              <!-- <li><a href="Cart.php"><i  class="fa fa-dollar"></i>طلبات الشراء</a> </li>-->
                               <!--<li><a href="Comments.php"><i  class="fa fa-comment"></i>تعليقات الأعضاء</a> </li>-->


                           
                             <!--   <li><a><i class="fa fa-desktop"></i> صفحات أخرى <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="general_elements.html">قوائم عامة</a>
                                        </li>
                                        <li><a href="media_gallery.html">معرض للميديا</a>
                                        </li>
                                        <li><a href="typography.html">الهيدرات</a>
                                        </li>
                                        <li><a href="icons.html">الأيقونات</a>
                                        </li>
                                        <li><a href="glyphicons.html">مربعات أيقونية</a>
                                        </li>
                                        <li><a href="widgets.html">مخططات تقييم</a>
                                        </li>
                                        <li><a href="invoice.html">فواتير</a>
                                        </li>
                                        <li><a href="inbox.html">صندوق البريد</a>
                                        </li>
                                        <li><a href="calender.html">التقويم</a>
                                        </li>
                                    </ul>
                                </li>-->
                             
                              
                                
                            </ul>
                        </div>
                      
                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
  
  ';
                    
                    ?>
				