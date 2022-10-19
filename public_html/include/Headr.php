     <?php
	     if ($_SESSION['Active']==1)
           echo'<header id="header" class="header-transparent header-fullwidth header-plain dark">';
		   else
		   echo'<header id="header" class="header-transparent header-fullwidth header-plain ">';
	  ?>
            <div id="header-wrap">
                <div class="container">
                    <!--Logo-->
                      <?php 
                        echo'<div id="logo">
                            <a href="index.php" class="logo" data-dark-logo="images/logo-w.png">
                                <img src="image/Logo/'.$row_Home['Logo'].'" alt="'.$row_Home['Title'].'">
                            </a>
                        </div>';
                     ?>
                    <!--End: Logo-->

                    <!--Top Search Form-->
                    <div id="top-search">
                        <form action="search-results-page.html" method="get">
                            <input type="text" name="q" class="form-control" value="" placeholder="Start typing & press  &quot;Enter&quot;">
                        </form>
                    </div>
                    <!--end: Top Search Form-->

                    <!--Header Extras-->
                    <div class="header-extras">
                        <ul>
                             <li>
                                <!--top search-->
                                <a id="top-search-trigger" href="#" class="toggle-item ">
                                    <i class="fa fa-search"></i>
                                    <i class="fa fa-close"></i>
                                </a>
                                <!--end: top search-->
                            </li>
                            
                            <li>
                                <div class="topbar-dropdown">
                                    <a class="title"><i class="fa fa-globe"></i></a>
                                    <div class="dropdown-list">
                                        <a class="list-entry" href="#">عربي</a>
                                        <a class="list-entry" href="E/index.php">English</a>
                                    </div>
                                </div>
                            </li>
                            
                            <li>
                                <!--top search-->
                                <a target="_blank"  href="<?php echo $row_Home['Whatsapp']; ?>">
                                   <i class="fa fa-whatsapp"></i>
                                   
                                </a>
                                <!--end: top search-->
                            </li>
                            
                        </ul>
                    </div>
                    <!--end: Header Extras-->

                    <!--Navigation Resposnive Trigger-->
                    <div id="mainMenu-trigger">
                        <button class="lines-button x"> <span class="lines"></span> </button>
                    </div>
                    <!--end: Navigation Resposnive Trigger-->

                    <!--Navigation-->
                    <div id="mainMenu" class="light">
                        <div class="container">
                            <nav>
                                 <ul>
                                    <li><a href="index.php"> الرئيسية </a></li>
                                    <li><a href="about.php"> من نحن  </a></li>
                                    
                                
                                         
                                    
                                      <li class="dropdown"> <a href="services.php">خدماتنا</a>
                                        <ul class="dropdown-menu">
                                        
                                        
                                         <?php 
                                
											$sql_Ser="select * from service Where  Sho='2' ";
												 $r_Ser=mysql_query($sql_Ser,$link); 
												 while($Ser=@mysql_fetch_array($r_Ser))
												 {        
												
												
												
													echo'<li><a href="service.php?id='.$Ser['idService'].'">'.$Ser['Name'].'</a></li>';
											
                                               }
										
										 ?>
                                            
                                            
                                          
                                           
                                        </ul>
                                    </li>
                                    
                                    
                                    <li><a href="projects.php"> مشاريعنا  </a></li>
                                    <li><a href="news.php"> أخبارنا  </a></li>
                                    

                                 
                                 
                                   <li><a href="contact.php"> للتواصل معنا </a></li>
                                  
                                  
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!--end: Navigation-->
                </div>
            </div>
        </header>
        <!-- end: Header -->

