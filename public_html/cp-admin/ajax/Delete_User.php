<?php session_start();?>
<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../../include/dataconnect.php");
// Security one

$id=$_GET["id"];
 unset($_SESSION['havecart']);
 unset($_SESSION['haveproduct']);
 unset($_SESSION['deletedone']);
 
          
 	
	  
	   $q_Count="select Count(*) as num from product Where F_User='$id' ";
	   $r_Count=mysql_query($q_Count,$link); 
       $num_P=@mysql_fetch_array($r_Count);
	  
	   $q_Count1="select Count(*) as num from cart Where F_User='$id'";
	   $r_Count1=mysql_query($q_Count1,$link); 
       $num_Q=@mysql_fetch_array($r_Count1);
	  
		
		
		
		 
		if (  $num_Q['num']!=0) 
		  {
	       $_SESSION['havecart']=1; 
          }
		  
		  
		  if (  $num_P['num']!=0) 
		  {
			$_SESSION['haveproduct']=1; 
		  }
		  
		  
		
		
		
		if( (!isset($_SESSION['havecart'])) && (!isset($_SESSION['haveproduct'])) )
		{ 
		
		  $sql="DELETE FROM likee where F_User='$id'";
          $result=mysql_query($sql,$link);
		  
		  
		  $sql="DELETE FROM comment where F_User='$id'";
          $result=mysql_query($sql,$link);
		  
		  $sql="DELETE FROM user where idUser='$id'";
          $result=mysql_query($sql,$link);
		  $_SESSION['deletedone']=1;
		}


echo'  <div class="row">

                                       
                                        <div class="clearfix"></div>';


                                    if( (isset($_SESSION['havecart'])) && (isset($_SESSION['haveproduct'])) )
                                    {
                                    echo'<br>
									
									<div class="alert alert-danger alert-dismissible fade in" style="text-align:right; direction:rtl;" role="alert">
                                  
                                    <strong>عذراَ , لا يمكن إتمام الحذف لإرتباط العضو بلوحات و طلبات شراء </strong> 
                                </div>
  <br>
';
								 unset($_SESSION['havecart']);
								 unset($_SESSION['haveproduct']);
										}
		
								    else if(isset($_SESSION['havecart']))
                                    {
                                    echo'<br>
									
									<div class="alert alert-danger alert-dismissible fade in" style="text-align:right; direction:rtl;" role="alert">
                                  
                                    <strong>عذراَ , لا يمكن إتمام الحذف لإرتباط العضو بطلبات شراء  </strong> 
                                </div>
  <br>
';
								 unset($_SESSION['havecart']);
								 unset($_SESSION['haveproduct']);
										}
										
										else if(isset($_SESSION['haveproduct']))
                                    {
                                    echo'<br>
									
									<div class="alert alert-danger alert-dismissible fade in" style="text-align:right; direction:rtl;" role="alert">
                                  
                                    <strong>عذراَ , لا يمكن إتمام الحذف لإرتباط العضو بلوحات  </strong> 
                                </div>
  <br>
';
								 unset($_SESSION['havecart']);
								 unset($_SESSION['haveproduct']);
										}
									
								 else if(isset($_SESSION['deletedone']))
									{
										
									echo'<br>
<div class="alert alert-success alert-dismissible fade in" style="text-align:right;" role="alert">
                                   
                                    <strong>تم الحذف بنجاح</strong> 
                                </div><br>
';	 unset($_SESSION['deletedone']);
									}
								
								








										 $sql="select * from user order by idUser DESC";
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
                                                          
															
                                                    echo'    </p>
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
		 
		 echo '</div>';
										 ?>
	


