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

    <!-- Bootstrap core CSS -->

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
	
var Word=document.getElementById("id").value;

var url="Search_Payment.php?id="+id;	
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

var url="Delete_Payment.php?id="+id;	
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

    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

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
                           
                        </div>

                        <div class="title_right">
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                <div class="input-group">
                                <?php
								 $idcart= $_GET['idcart'];
                                    echo'<input type="search" id="Word" name="Word" style="direction:rtl;" class="form-control" onKeyUp="Search();"   placeholder="إبحث ">';
									?>
                                    <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="x_panel">
                                <div class="x_title">
                                
                                  
                                <?php
								
								/// رقم السلة
								 $idcart= $_GET['idcart'];
								 $_SESSION['Cart_ID']=$idcart;
								
								 $sql_Cart="select * from cart where idCart='$idcart' ";
                                 $result_Cart=mysql_query($sql_Cart,$link);
								 $row_Cart=mysql_fetch_array($result_Cart);
								 
								

                    echo' <h4 style="text-align:right; direction:rtl; float:right;"> سلة رقم '.$row_Cart['idCart'].' </h4>';
									?>
                                    
                                    <br>
<br>
<br>
<br>

                                                                     <?php
                                     if(isset($_SESSION['Done']))
                                    {
										if ($_SESSION['Done']==1)
										{
                                    echo' <div class="alert alert-success alert-dismissible fade in" style="text-align:right;" role="alert">
                                   
                                    <strong>تمت الإضافة </strong> 
                                </div>';
								 unset($_SESSION['Done']);
										}
										else
										{
                                
                                      echo'<div class="alert alert-danger alert-dismissible fade in" style="text-align:right; direction:rtl;" role="alert">
                                  
                                    <strong>حدث خطأ ما ! </strong> 
                                </div>';
								 unset($_SESSION['Done']);
										}
									}
								
								?>
<?php
	                             $sql_Sum="SELECT SUM(Val) AS Cost FROM payment where F_Cart='$idcart'";
                                 $result_Sum=mysql_query($sql_Sum,$link);
								 $row_Sum=mysql_fetch_array($result_Sum);
								if ( $row_Sum['Cost'] >= $row_Cart['Cost'])
								{
  echo' <div style="float:right;"> <a href="New_Payment.php" class="btn btn-primary btn-xs disabled "><i class="fa fa-archive"></i> دفعة جديدة </a> </div>';
								}
  else
  {
   echo' <div style="float:right;"> <a href="New_Payment.php"  class="btn btn-primary btn-xs  "><i class="fa fa-archive"></i> دفعة جديدة </a> </div>';
  }
?>
                                    <ul class="nav navbar-left panel_toolbox">
                                    
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                       
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>

                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                
                                   <div id="myDiv">  


                                    <!-- start project list -->
                                    <table class="table table-striped projects">
                                        <thead>
                                            <tr>
                                                <th >رقم الدفعة</th>
                                                <th >قيمة الدفعة</th>
                                                <th>تاريخ الدفعة</th>
                                               <th >#خيارات </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                           <?php 
										 $sql_P="select * from payment where F_Cart='$idcart' order by idPayment DESC ";
                                         $result_P=mysql_query($sql_P,$link);
								         while($row_P=@mysql_fetch_array($result_P))
										 {
                                            											
												
										 echo'
                                        
                                            <tr>
                                                <td>  <a href="">'.$row_P['idPayment'].'</a></td>
                                                <td>
                                                    <a href="" style="direction:rtl;">'.$row_P['Val'].' / ريال</a>
                                                   
                                                </td>
                                                <td>
                                                    <a href="">'.$row_P['Date'].'</a>
                                                   
                                                </td>
                                             
												
                                                <td>
                                                    <a href="Edit_Payment.php?id='.$row_P['idPayment'].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> تعديل </a>
                                      <a href="#" class="btn btn-danger btn-xs"  onclick="Delete('.$row_P['idPayment'].');"><i class="fa fa-trash-o"></i> حذف </a>                                                </td>
                                            </tr>';
										 }
										 ?>
                                     
                                           
                                        </tbody>
                                    </table>
                                    <!-- end project list -->
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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