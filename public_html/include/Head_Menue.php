<?php
$i=0;

 $sql4="SELECT COUNT(*) AS num FROM user Where Sho=1 and Seen=1";
 $result4=mysql_query($sql4,$link);
 $row4=mysql_fetch_array($result4);
 
 $sql44="SELECT COUNT(*) AS num FROM product Where Sho=1 and Seen=1";
 $result44=mysql_query($sql44,$link);
 $row44=mysql_fetch_array($result44);
 
 $sql444="SELECT COUNT(*) AS num FROM comment Where Sho=1 and Seen=1";
 $result444=mysql_query($sql444,$link);
 $row444=mysql_fetch_array($result444);


$i=$i+$row4['num']+$row44['num']+$row444['num'];
echo'
  <div class="top_nav">

                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="images/img.jpg" alt="">'.$_SESSION['Name'].'
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    <li><a href="Edit_Admin.php?id='.$_SESSION['USERID'].'">  تعديل الملف الشخصي</a>
                                    </li>
                                   
                                    <li><a href="Log_Out.php"><i class="fa fa-sign-out pull-right"></i> تسجيل الخروج</a>
                                    </li>
                                </ul>
                            </li>





                           <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>';
									if ($i !=0)
                                   echo' <span class="badge bg-green">'. $i.'</span>';
                               echo' </a>
                             <ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">';
							 
		   $sql11="select * from product Where Seen='1' Order by idProduct DESC  ";
		   $result11=mysql_query($sql11,$link);
		   while($Product=@mysql_fetch_array($result11))
		                     {
                             echo'<li style="text-align:right; direction:rtl;">
                                                                     
                                     <span class="message"  >
                                     تم إضافة اللوحة :  <a style="color:Blue;" href="Product.php?id='.$Product['idProduct'].'">'.$Product['Name'].' </a> و بإنتظار الموافقة عليه 
                                    </span>
                                      
                                    </li>';
		                              }
									  
									  
									  
		   $sql12="select * from user Where Seen='1' Order by idUser DESC  ";
		   $result12=mysql_query($sql12,$link);
		   while($User=@mysql_fetch_array($result12))
		                     {
                             echo'<li style="text-align:right; direction:rtl;">
                                                                     
                                     <span class="message"  >
                                    لقد تم إضافة العضو : <a style="color:Blue;"  href="Profile.php?id='.$User['idUser'].'">'.$User['Name'].' </a>  على الدليل وبإنتظار الموافقة
                                    </span>
                                      
                                    </li>';
									
		                              }
									  
									  							
			 $sql13="select * from comment Where Seen='1' Order by idComment DESC  ";
		   $result13=mysql_query($sql13,$link);
		   while($Comment=@mysql_fetch_array($result13))
		                     {
                             echo'<li style="text-align:right; direction:rtl;">
                                                                     
                                     <span class="message">
                                    لقد تم إضافة تعلق من قبل العضو : <a style="color:Blue;"  href="Comments.php?id='.$Comment['F_New'].'">'.$Comment['Name'].' </a>   وبإنتظار الموافقة
                                    </span>
                                      
                                    </li>';
							 }
									  
                                     echo'<!--<li>
                                        <div class="text-center">
                                            <a>
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>-->
                                </ul>
                            </li>

                        </ul>
                    </nav>
                </div>

            </div>

';
?>