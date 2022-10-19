<?php include("Check.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> لوحة التحكم   </title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/icheck/flat/green.css" rel="stylesheet">


    <script src="js/jquery.min.js"></script>
 <script>
 
  function Search()
{
	
var Word=document.getElementById("Word").value;
var url="ajax/Search_User.php?Word="+Word;	
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {	
	 document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
	else
	{
	 document.getElementById("myDiv").innerHTML="<img src=images/loading.gif></img>";
	
	}
  }
xmlhttp.open("GET",url,true);
xmlhttp.send();

}

 
 
function Delete(id)
{
	
	if(confirm("هل أنت متأكد من عملية الحذف ؟  "))
{	


var url="ajax/Delete_User.php?id="+id;
var xmlhttp;	
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {	
	 document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
	else
	{
	 document.getElementById("myDiv").innerHTML="<img src=images/loading.gif></img>";
	
	}
  }
xmlhttp.open("GET",url,true);
xmlhttp.send();
}
else
	return false;
}


</script>


</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                   <div class="navbar nav_title" style="border: 0;">
                        <a href="index.php" class="site_title"> <span> <img src="images/sh.png" alt="..." style="width:100px; height:auto;"> </span></a>
                    </div>
                    <div class="clearfix"></div>
                      <?php   include("../include/Left_Menue.php"); ?>                  
                </div>
            </div>

            <!-- top navigation -->
           <?php   include("../include/Head_Menue.php"); ?>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">

                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3></h3>
                        </div>

                        <div class="title_right">
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                <div class="input-group">
                                    
								 <?php
								
                                    echo'<input type="search" id="Word" name="Word" style="direction:rtl;" class="form-control"   placeholder="إبحث ">';
									?>
                                    <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                            
                            
                              <script>
							 
							 
							var timeout = null;
$('#Word').on('keyup', function () {
    var that = this;
    if (timeout !== null) {
        clearTimeout(timeout);
    }
    timeout = setTimeout(function () {
        Search($(that).val());
    }, 1500);
});
							
							</script>
                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="x_panel">
                            
                           <h4 style="text-align:right; direction:rtl; float:right;">الأعضاء المسجلين ( <?php 
						   
						    $sql1="select Count(*) as num from user  Where Type=2";
						   $result1=mysql_query($sql1,$link);
						   $row1=@mysql_fetch_array($result1);
						   echo $row1['num']; echo '<span style="color:#ffbf00;"> تاجر </span>';
						   echo " , ";
						   $sql1="select Count(*) as num from user  Where Type=1";
						   $result1=mysql_query($sql1,$link);
						   $row1=@mysql_fetch_array($result1);
						   echo $row1['num']; echo '<span style="color:#00acd1;"> زائر </span>';
						   echo " ) ";
						   
						   
						   
						   
						    ?>  </h4>
  <ul class="nav navbar-left panel_toolbox">
                                    
                                       <a style="font-size:14px;" href="New_Member.php" class="btn btn-danger btn-xs"> <i class="fa fa-user">
                                                            </i> إضافة عضو</a>
                                    </ul>

                                <div class="x_content">
<hr/>

   
   
   
<div id="myDiv" >


                                    <div class="row">

                                       
                                        <div class="clearfix"></div>



                                  <?php 
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
												  if ($row['Type']==2)
                                                  echo'  <h4 class="brief"><i style="text-align:right; float:right; color:#ffbf00;">تاجر  </i></h4>';
												
											   else  if ($row['Type']==1)	
											  echo'  <h4 class="brief"><i style="text-align:right; float:right; color:#00acd1;">عضو عادي </i></h4>';

                                                   echo' <div class="left  col-xs-5 text-center">  
                                                    <img src="../image/User/'.$row['Image']. '"  alt="" class="img-circle img-responsive">  
                                                    </div>
                                                    <div class="right  col-xs-7" style="text-align:right; float:right;">

                                                       <h5 style="height:40px;">'.$row['Name'].'</h5>
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
												   
                                                           echo' <a>عدد المنتجات  : ' .$row1['Product']. ' </a>';
															
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
										 
										 ?>








                                    </div>
                                    
                                    
                                    
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                 <!-- footer content -->
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

                <footer>
                    <div class="">
                         <p class="pull-right">
                            <span class="lead"> <img src="images/sh.png" alt="..." style="width:100px; height:auto;"></span>
                            
                                 

                        </p>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->

            </div>
            <!-- /page content -->
        </div>

    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <script src="js/bootstrap.min.js"></script>

    <!-- chart js -->
    <script src="js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="js/icheck/icheck.min.js"></script>

    <script src="js/custom.js"></script>

</body>

</html>