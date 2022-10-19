<?php session_start();?>
<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../../include/dataconnect.php");
// Security one

$Word=$_GET["Word"];
	
	




										 $sql="select * from user Where (Name like '%$Word%' or Username like '%$Word%' or Company like '%$Word%' or Email like '%$Word%' or Mobile like '%$Word%' ) order by idUser DESC";
                                         $result=mysql_query($sql,$link);
								         while($row=@mysql_fetch_array($result))
										 {
											 $id=$row['idUser'];

                                      echo'  <div class="col-md-4 col-sm-4 col-xs-12 animated fadeInDown">
                                            <div class="well profile_view">
                                                <div class="col-sm-12">';
												if ($row['Sho']==1)
												echo' <img src="images/H.png" style="height:30px;" alt="" style="position:static;">  ';
												else if ($row['Sho']==2)
												echo' <img src="images/A.png" style="height:30px;" alt="" style="position:static;">  ';
												
                                                   echo' <div class="left  col-xs-5 text-center">  
                                                    <img src="../image/User/'.$row['Image']. '" style="height:120px;" alt="" class="img-circle img-responsive">  
                                                    </div>
                                                    <div class="right  col-xs-7" style="text-align:right; float:right;">

                                                       <h2 style="height:40px;">'.$row['Name'].'</h2>
                                                        <p><strong>الشركة :  </strong> '.$row['Company'].' </p>
                                                        <ul class="list-unstyled">
                                                            <li> جوال : ' .$row['Mobile']. ' <i class="fa fa-phone"></i></li>
                                                           <li> بريد إلكتروني <i class="fa fa-inbox"></i><br>
                                                                   ' .$row['Email']. ' </li>
                                                               <br>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 bottom text-center">
                                                    <div class="col-xs-12 col-sm-6 emphasis">
                                                       <p class="ratings">';
														
														 $sql1="select Count(*) as Product from product  Where F_User=$id";
		                                                 $result1=mysql_query($sql1,$link);
		                                                 $row1=@mysql_fetch_array($result1);
												   
                                                         
															
                                                    echo'</p>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6 emphasis">
													
													
													    <a href="#" onclick="Delete('.$row['idUser'].')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> حذف </a>
													
                                                        <a href="New_Message.php" class="btn btn-success btn-xs"> <i class="fa fa-user">
                                                            </i> <i class="fa fa-comments-o"></i> </a>
															
															
                                                         <a href="Member.php?id='.$row['idUser'].'" class="btn btn-primary btn-xs"> <i class="fa fa-user">
                                                            </i> الملف الشخصي </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
										 }
										 
										 ?>
	


